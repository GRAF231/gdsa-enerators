<?php
/**
 * Cart Page
 * Использует unified cart & checkout шаблон
 * 
 * @package DSA_Generators
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Загружаем unified шаблон для корзины
$unified_template = get_template_directory() . '/woocommerce/cart-checkout-unified.php';

if (file_exists($unified_template)) {
    // Удаляем header/footer так как они уже есть в unified
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    
    // Загружаем unified шаблон
    include $unified_template;
    
    // Важно: выходим, чтобы не загружался стандартный контент
    exit;
}

// Если unified не найден, загружаем стандартный шаблон WooCommerce
wc_get_template('cart/cart-empty.php');
