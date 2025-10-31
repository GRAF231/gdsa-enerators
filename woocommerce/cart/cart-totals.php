
<?php
/**
 * Cart Totals Template
 * Отображает итоговую сумму корзины
 * 
 * @package DSA_Generators
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="cart-totals">
    
    <?php do_action('woocommerce_before_cart_totals'); ?>
    
    <!-- Заголовок -->
    <div class="cart-totals__header">
        <h3 class="cart-totals__title">Итого</h3>
    </div>
    
    <!-- Промежуточный итог -->
    <div class="cart-totals__row">
        <span class="cart-totals__label">Промежуточный итог:</span>
        <span class="cart-totals__value">
            <?php wc_cart_totals_subtotal_html(); ?>
        </span>
    </div>
    
    <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
        <!-- Примененные купоны -->
        <div class="cart-totals__row cart-totals__row_discount">
            <span class="cart-totals__label">
                Купон: <?php echo esc_html($code); ?>
                <a href="<?php echo esc_url(add_query_arg('remove_coupon', urlencode($code), wc_get_cart_url())); ?>" 
                   class="cart-totals__remove-coupon" 
                   aria-label="<?php esc_attr_e('Remove coupon', 'woocommerce'); ?>">
                    <i class="fas fa-times"></i>
                </a>
            </span>
            <span class="cart-totals__value cart-totals__value_discount">
                <?php wc_cart_totals_coupon_html($coupon); ?>
            </span>
        </div>
    <?php endforeach; ?>
    
    <?php 
    /**
     * Блок доставки скрыт в корзине
     * Доставка выбирается в форме оформления заказа (справа)
     */
    // if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : 
    //     Доставка скрыта
    // endif; 
    ?>
    
    <?php foreach (WC()->cart->get_fees() as $fee) : ?>
        <!-- Дополнительные сборы -->
        <div class="cart-totals__row cart-totals__row_fee">
            <span class="cart-totals__label"><?php echo esc_html($fee->name); ?>:</span>
            <span class="cart-totals__value">
                <?php wc_cart_totals_fee_html($fee); ?>
            </span>
        </div>
    <?php endforeach; ?>
    
    <?php if (wc_tax_enabled() && ! WC()->cart->display_prices_including_tax()) : ?>
        
        <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
            <!-- Налоги (по позициям) -->
            <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                <div class="cart-totals__row cart-totals__row_tax">
                    <span class="cart-totals__label"><?php echo esc_html($tax->label); ?>:</span>
                    <span class="cart-totals__value">
                        <?php echo wp_kses_post($tax->formatted_amount); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <!-- Налоги (общая сумма) -->
            <div class="cart-totals__row cart-totals__row_tax">
                <span class="cart-totals__label"><?php echo esc_html(WC()->countries->tax_or_vat()); ?>:</span>
                <span class="cart-totals__value">
                    <?php wc_cart_totals_taxes_total_html(); ?>
                </span>
            </div>
        <?php endif; ?>
        
    <?php endif; ?>
    
    <?php do_action('woocommerce_cart_totals_before_order_total'); ?>
    
    <!-- Итоговая сумма -->
    <div class="cart-totals__row cart-totals__row_total">
        <span class="cart-totals__label">Итого к оплате:</span>
        <span class="cart-totals__value cart-totals__value_total">
            <?php wc_cart_totals_order_total_html(); ?>
        </span>
    </div>
    
    <?php do_action('woocommerce_cart_totals_after_order_total'); ?>
    
    <!-- Форма применения купона -->
    <?php if (wc_coupons_enabled()) : ?>
        <div class="cart-totals__coupon">
            <form class="cart-totals__coupon-form" method="post">
                <div class="cart-totals__coupon-input-wrapper">
                    <input type="text" 
                           name="coupon_code" 
                           class="cart-totals__coupon-input" 
                           id="coupon_code" 
                           value="" 
                           placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                    <button type="submit" 
                            class="cart-totals__coupon-btn" 
                            name="apply_coupon" 
                            value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">
                        <i class="fas fa-tag"></i>
                        <span><?php esc_html_e('Apply coupon', 'woocommerce'); ?></span>
                    </button>
                </div>
                <?php do_action('woocommerce_cart_coupon'); ?>
            </form>
        </div>
    <?php endif; ?>
    
    <?php do_action('woocommerce_after_cart_totals'); ?>
    
</div>

