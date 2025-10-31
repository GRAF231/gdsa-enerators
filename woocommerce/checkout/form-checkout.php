
<?php
/**
 * Checkout Form Template
 * Кастомная форма оформления заказа
 * 
 * @package DSA_Generators
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <?php if ($checkout->get_checkout_fields()) : ?>

        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div class="checkout-form">
            
            <!-- Заголовок формы -->
            <div class="checkout-form__header">
                <h2 class="checkout-form__title">Контактные данные</h2>
                <p class="checkout-form__description">Заполните форму для оформления заказа</p>
            </div>
            
            <!-- СЕКЦИЯ 1: Контактная информация -->
            <div class="checkout-form__section">
                <h3 class="checkout-form__section-title">
                    <i class="fas fa-user"></i>
                    <span>Контактная информация</span>
                </h3>
                
                <div class="checkout-form__fields">
                    <?php
                    // Выводим только основные поля billing (без адресных полей)
                    foreach ($checkout->get_checkout_fields('billing') as $key => $field) {
                        // Оставляем только имя, фамилию, телефон и email
                        if (in_array($key, ['billing_first_name', 'billing_last_name', 'billing_phone', 'billing_email'])) {
                            woocommerce_form_field($key, $field, $checkout->get_value($key));
                        }
                    }
                    ?>
                </div>
            </div>

        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

    <?php endif; ?>
    
    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
    
    <?php do_action('woocommerce_checkout_before_order_review'); ?>

    <!-- СЕКЦИЯ 2: Способ доставки -->
    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
        <div class="checkout-form__section">
            <h3 class="checkout-form__section-title">
                <i class="fas fa-shipping-fast"></i>
                <span>Способ доставки</span>
            </h3>
            
            <!-- Выбор способа доставки -->
            <div class="checkout-shipping-methods">
                <?php
                // Получаем доступные методы доставки
                $packages = WC()->shipping()->get_packages();
                $first_package = reset($packages);
                $available_methods = isset($first_package['rates']) ? $first_package['rates'] : [];
                
                // Группируем методы: отдельно pickup_location и остальные
                $pickup_methods = [];
                $other_methods = [];
                
                foreach ($available_methods as $rate_id => $rate) {
                    if (strpos($rate_id, 'pickup_location') !== false) {
                        $pickup_methods[] = $rate;
                    } else {
                        $other_methods[] = $rate;
                    }
                }
                
                // Получаем текущий выбранный метод
                $chosen_methods = WC()->session->get('chosen_shipping_methods');
                $chosen_method = isset($chosen_methods[0]) ? $chosen_methods[0] : '';
                
                // Проверяем, выбран ли самовывоз
                $is_pickup_selected = strpos($chosen_method, 'pickup_location') !== false;
                ?>
                
                <ul class="woocommerce-shipping-methods">
                    <?php
                    // Выводим объединенный метод "Самовывоз" если есть pickup методы
                    if (!empty($pickup_methods)) :
                        $first_pickup = reset($pickup_methods);
                        ?>
                        <li>
                            <input type="radio" 
                                   name="shipping_method[0]" 
                                   id="shipping_method_pickup_location"
                                   value="pickup_location" 
                                   class="shipping_method"
                                   <?php checked($is_pickup_selected, true); ?> />
                            <label for="shipping_method_pickup_location">
                                <span class="method-name">Самовывоз</span>
                                <span class="method-price">Бесплатно</span>
                            </label>
                        </li>
                    <?php endif; ?>
                    
                    <?php
                    // Выводим остальные методы доставки
                    foreach ($other_methods as $rate) :
                        $is_selected = ($chosen_method === $rate->id);
                        
                        // Формируем цену метода доставки
                        $price_html = '';
                        if ($rate->cost > 0) {
                            $price_html = wc_price($rate->cost);
                            if ($rate->get_shipping_tax() > 0 && WC()->cart->display_prices_including_tax()) {
                                $price_html = wc_price($rate->cost + $rate->get_shipping_tax());
                            }
                        } else {
                            $price_html = 'Бесплатно';
                        }
                        ?>
                        <li>
                            <input type="radio" 
                                   name="shipping_method[0]" 
                                   id="shipping_method_<?php echo esc_attr(sanitize_title($rate->id)); ?>"
                                   value="<?php echo esc_attr($rate->id); ?>" 
                                   class="shipping_method"
                                   <?php checked($is_selected, true); ?> />
                            <label for="shipping_method_<?php echo esc_attr(sanitize_title($rate->id)); ?>">
                                <span class="method-name"><?php echo esc_html($rate->label); ?></span>
                                <span class="method-price"><?php echo wp_kses_post($price_html); ?></span>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <!-- Блок самовывоза (показывается при выборе local_pickup) -->
            <div class="checkout-pickup-address" style="display: none;">
                <h4 class="pickup-locations-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Выберите пункт самовывоза
                </h4>
                
                <div class="pickup-locations-list">
                    <?php
                    // Получаем пункты выдачи из WooCommerce Local Pickup
                    $pickup_locations = dsa_get_pickup_locations();
                    
                    if (!empty($pickup_locations)) :
                        foreach ($pickup_locations as $index => $location) :
                            $location_id = 'pickup_location_' . $index;
                            $location_name = !empty($location['name']) ? $location['name'] : 'Пункт выдачи ' . ($index + 1);
                            $location_address = dsa_format_pickup_address($location);
                            $location_details = !empty($location['details']) ? $location['details'] : '';
                            ?>
                            
                            <div class="pickup-location-item">
                                <input type="radio" 
                                       id="<?php echo esc_attr($location_id); ?>" 
                                       name="pickup_location" 
                                       value="<?php echo esc_attr($index); ?>"
                                       class="pickup-location-radio"
                                       <?php checked($index, 0); ?> />
                                
                                <label for="<?php echo esc_attr($location_id); ?>" class="pickup-location-label">
                                    <div class="pickup-location-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="pickup-location-content">
                                        <div class="pickup-location-name"><?php echo esc_html($location_name); ?></div>
                                        <div class="pickup-location-address"><?php echo esc_html($location_address); ?></div>
                                        <?php if ($location_details) : ?>
                                            <div class="pickup-location-details">
                                                <i class="fas fa-clock"></i>
                                                <?php echo esc_html($location_details); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="pickup-location-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </label>
                            </div>
                            
                        <?php endforeach;
                    else : ?>
                        <p class="pickup-locations-empty">Пункты выдачи не настроены. Настройте их в WooCommerce → Настройки → Доставка → Local Pickup.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Поля адреса доставки (показываются при других способах) -->
            <div class="checkout-delivery-address" style="display: none;">
                <h4 class="checkout-delivery-address__title">
                    <i class="fas fa-map-marker-alt"></i>
                    Адрес доставки
                </h4>
                <div class="checkout-form__fields">
                    <?php
                    // Выводим поля адреса из billing (country, state, city, address, postcode)
                    foreach ($checkout->get_checkout_fields('billing') as $key => $field) {
                        if (in_array($key, ['billing_country', 'billing_state', 'billing_city', 'billing_address_1', 'billing_address_2', 'billing_postcode'])) {
                            woocommerce_form_field($key, $field, $checkout->get_value($key));
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- СЕКЦИЯ 3: Оплата заказа -->
    <div id="order_review" class="woocommerce-checkout-review-order">
        
        <div class="checkout-form__section">
            <h3 class="checkout-form__section-title">
                <i class="fas fa-credit-card"></i>
                <span>Оплата заказа</span>
            </h3>
            
            <!-- Комментарий к заказу (ПЕРЕД способами оплаты) -->
            <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>
                <div class="checkout-form__notes-wrapper">
                    <label for="order_comments" class="checkout-form__notes-label">
                        <i class="fas fa-comment"></i>
                        <span>Комментарий к заказу (необязательно)</span>
                    </label>
                    <textarea name="order_comments" 
                              class="checkout-form__notes-textarea" 
                              id="order_comments" 
                              placeholder="<?php esc_attr_e('Notes about your order, e.g. special notes for delivery.', 'woocommerce'); ?>" 
                              rows="3"></textarea>
                </div>
            <?php endif; ?>
            
            <!-- Способы оплаты и кнопка подтверждения -->
            <?php 
            /**
             * Хук woocommerce_checkout_payment выводит:
             * - div#payment с классом woocommerce-checkout-payment
             * - Список способов оплаты с radio buttons
             * - Описания способов оплаты (payment_box)
             * - Политику конфиденциальности
             * - Кнопку "Подтвердить заказ"
             * 
             * Этот хук автоматически подключает весь необходимый JavaScript
             */
            woocommerce_checkout_payment();
            ?>
            
        </div>
        
    </div>

    <?php do_action('woocommerce_checkout_after_order_review'); ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

