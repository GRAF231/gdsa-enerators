
<?php
/**
 * Order Thank You Page Template
 * Страница благодарности после оформления заказа
 * 
 * @package DSA_Generators
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="thankyou-page">
    
    <?php if ($order) : ?>

        <?php if ($order->has_status('failed')) : ?>
            
            <!-- Заказ не выполнен -->
            <div class="thankyou-failed">
                <div class="thankyou-failed__icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h2 class="thankyou-failed__title">К сожалению, ваш заказ не может быть обработан</h2>
                <p class="thankyou-failed__text">
                    <?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?>
                </p>
                <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="btn btn_primary">
                    <?php esc_html_e('Pay', 'woocommerce'); ?>
                </a>
            </div>

        <?php else : ?>
            
            <!-- Успешное оформление -->
            <div class="thankyou-success">
                
                <!-- Иконка успеха -->
                <div class="thankyou-success__icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                
                <!-- Заголовок -->
                <h2 class="thankyou-success__title">Спасибо за ваш заказ!</h2>
                
                <!-- Сообщение -->
                <div class="thankyou-success__message">
                    <?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $order); ?>
                </div>
                
                <!-- Информация о заказе -->
                <div class="thankyou-order-info">
                    
                    <div class="thankyou-order-info__item">
                        <span class="thankyou-order-info__label">Номер заказа:</span>
                        <span class="thankyou-order-info__value"><?php echo $order->get_order_number(); ?></span>
                    </div>
                    
                    <div class="thankyou-order-info__item">
                        <span class="thankyou-order-info__label">Дата:</span>
                        <span class="thankyou-order-info__value">
                            <?php echo wc_format_datetime($order->get_date_created()); ?>
                        </span>
                    </div>
                    
                    <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                        <div class="thankyou-order-info__item">
                            <span class="thankyou-order-info__label">Email:</span>
                            <span class="thankyou-order-info__value"><?php echo $order->get_billing_email(); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="thankyou-order-info__item">
                        <span class="thankyou-order-info__label">Итого:</span>
                        <span class="thankyou-order-info__value thankyou-order-info__value_total">
                            <?php echo $order->get_formatted_order_total(); ?>
                        </span>
                    </div>
                    
                    <?php if ($order->get_payment_method_title()) : ?>
                        <div class="thankyou-order-info__item">
                            <span class="thankyou-order-info__label">Способ оплаты:</span>
                            <span class="thankyou-order-info__value"><?php echo wp_kses_post($order->get_payment_method_title()); ?></span>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
            </div>
            
            <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
            
            <!-- Детали заказа -->
            <div class="thankyou-order-details">
                
                <h3 class="thankyou-order-details__title">Детали заказа</h3>
                
                <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
                
                <!-- Таблица товаров -->
                <div class="thankyou-order-table">
                    <table class="shop_table order_details">
                        <thead>
                            <tr>
                                <th class="woocommerce-table__product-name product-name">Товар</th>
                                <th class="woocommerce-table__product-table product-total">Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            do_action('woocommerce_order_details_before_order_table_items', $order);

                            foreach ($order->get_items() as $item_id => $item) {
                                $product = $item->get_product();

                                wc_get_template(
                                    'order/order-details-item.php',
                                    array(
                                        'order'              => $order,
                                        'item_id'            => $item_id,
                                        'item'               => $item,
                                        'show_purchase_note' => $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing'))),
                                        'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                        'product'            => $product,
                                    )
                                );
                            }

                            do_action('woocommerce_order_details_after_order_table_items', $order);
                            ?>
                        </tbody>
                        <tfoot>
                            <?php
                            foreach ($order->get_order_item_totals() as $key => $total) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo esc_html($total['label']); ?></th>
                                    <td><?php echo wp_kses_post($total['value']); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php if ($order->get_customer_note()) : ?>
                                <tr>
                                    <th><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                                    <td><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                </div>
                
            </div>
            
            <!-- Адреса доставки и оплаты -->
            <div class="thankyou-addresses">
                
                <div class="thankyou-addresses__column">
                    <h3 class="thankyou-addresses__title">Адрес доставки</h3>
                    <address class="thankyou-addresses__address">
                        <?php echo wp_kses_post($order->get_formatted_billing_address(esc_html__('N/A', 'woocommerce'))); ?>
                        
                        <?php if ($order->get_billing_phone()) : ?>
                            <p class="thankyou-addresses__phone">
                                <i class="fas fa-phone"></i>
                                <?php echo esc_html($order->get_billing_phone()); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if ($order->get_billing_email()) : ?>
                            <p class="thankyou-addresses__email">
                                <i class="fas fa-envelope"></i>
                                <?php echo esc_html($order->get_billing_email()); ?>
                            </p>
                        <?php endif; ?>
                    </address>
                </div>
                
                <?php if (!wc_ship_to_billing_address_only() && $order->needs_shipping_address()) : ?>
                    <div class="thankyou-addresses__column">
                        <h3 class="thankyou-addresses__title">Адрес получателя</h3>
                        <address class="thankyou-addresses__address">
                            <?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('N/A', 'woocommerce'))); ?>
                        </address>
                    </div>
                <?php endif; ?>
                
            </div>
            
            <!-- Дальнейшие действия -->
            <div class="thankyou-actions">
                <h3 class="thankyou-actions__title">Что дальше?</h3>
                <div class="thankyou-actions__grid">
                    
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="thankyou-actions__btn">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Продолжить покупки</span>
                    </a>
                    
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="thankyou-actions__btn">
                            <i class="fas fa-user"></i>
                            <span>Мои заказы</span>
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="thankyou-actions__btn">
                        <i class="fas fa-home"></i>
                        <span>На главную</span>
                    </a>
                    
                </div>
            </div>

        <?php endif; ?>

    <?php else : ?>

        <!-- Заказ не найден -->
        <div class="thankyou-not-found">
            <div class="thankyou-not-found__icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <h2 class="thankyou-not-found__title">Заказ не найден</h2>
            <p class="thankyou-not-found__text">
                <?php esc_html_e('Sorry, this order is invalid and cannot be displayed.', 'woocommerce'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn_primary">
                <i class="fas fa-home"></i>
                <span>На главную</span>
            </a>
        </div>

    <?php endif; ?>
    
</div>

