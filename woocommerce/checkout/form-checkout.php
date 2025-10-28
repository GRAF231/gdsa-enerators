
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
                    
                    <?php do_action('woocommerce_checkout_billing'); ?>
                    
                </div>
            </div>
            
            <?php if (WC()->cart->needs_shipping() && get_option('woocommerce_ship_to_destination') === 'shipping') : ?>
                
                <!-- СЕКЦИЯ 2: Адрес доставки -->
                <div class="checkout-form__section">
                    <h3 class="checkout-form__section-title">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Адрес доставки</span>
                    </h3>
                    
                    <div class="checkout-form__fields">
                        
                        <?php do_action('woocommerce_checkout_shipping'); ?>
                        
                    </div>
                </div>
                
            <?php endif; ?>

        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

    <?php endif; ?>
    
    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
    
    <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
        
        <!-- СЕКЦИЯ 3: Способ доставки -->
        <div class="checkout-form__section">
            <h3 class="checkout-form__section-title">
                <i class="fas fa-shipping-fast"></i>
                <span>Способ доставки</span>
            </h3>
            
            <div class="checkout-form__shipping">
                <?php woocommerce_checkout_shipping(); ?>
            </div>
        </div>
        
    <?php endif; ?>
    
    <?php do_action('woocommerce_checkout_before_order_review'); ?>

    <!-- СЕКЦИЯ 4: Способ оплаты -->
    <div id="order_review" class="woocommerce-checkout-review-order">
        
        <div class="checkout-form__section">
            <h3 class="checkout-form__section-title">
                <i class="fas fa-credit-card"></i>
                <span>Способ оплаты</span>
            </h3>
            
            <?php do_action('woocommerce_checkout_order_review'); ?>
            
        </div>
        
    </div>

    <?php do_action('woocommerce_checkout_after_order_review'); ?>
    
    <!-- СЕКЦИЯ 5: Комментарий к заказу -->
    <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>
        
        <div class="checkout-form__section">
            <h3 class="checkout-form__section-title">
                <i class="fas fa-comment"></i>
                <span>Комментарий к заказу</span>
            </h3>
            
            <div class="checkout-form__notes">
                <textarea name="order_comments" 
                          class="checkout-form__notes-textarea" 
                          id="order_comments" 
                          placeholder="<?php esc_attr_e('Notes about your order, e.g. special notes for delivery.', 'woocommerce'); ?>" 
                          rows="4"></textarea>
            </div>
        </div>
        
    <?php endif; ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

