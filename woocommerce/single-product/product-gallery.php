<?php
/**
 * Single Product Gallery
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;
?>

<div class="product-gallery">
    <?php
    /**
     * WooCommerce галерея с поддержкой zoom и lightbox
     * Поддерживает функции: zoom, lightbox, slider
     */
    woocommerce_show_product_images();
    ?>
    
    <!-- Бейдж наличия товара -->
    <?php if ($product->is_in_stock()) : ?>
        <div class="product-badge">
            <span class="product-badge__text">В наличии</span>
        </div>
    <?php elseif ($product->is_on_backorder()) : ?>
        <div class="product-badge product-badge_type_backorder">
            <span class="product-badge__text">Под заказ</span>
        </div>
    <?php else : ?>
        <div class="product-badge product-badge_type_out-of-stock">
            <span class="product-badge__text">Нет в наличии</span>
        </div>
    <?php endif; ?>
</div>
