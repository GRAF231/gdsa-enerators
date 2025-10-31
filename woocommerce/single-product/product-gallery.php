<?php
/**
 * Single Product Gallery (Кастомная галерея DSA)
 *
 * @package DSA_Generators
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

// Получаем главное изображение и галерею
$attachment_ids = $product->get_gallery_image_ids();
$main_image_id = $product->get_image_id();
$main_image_url = wp_get_attachment_image_url($main_image_id, 'full');
$main_image_alt = get_post_meta($main_image_id, '_wp_attachment_image_alt', true);

if (!$main_image_url) {
    $main_image_url = wc_placeholder_img_src('full');
    $main_image_alt = __('Placeholder', 'dsa-generators');
}
?>

<div class="product-gallery">
    <!-- Главное изображение -->
    <div class="product-image-main">
        <img src="<?php echo esc_url($main_image_url); ?>" 
             alt="<?php echo esc_attr($main_image_alt ?: get_the_title()); ?>" 
             class="product-main-img" 
             id="mainProductImage"
             data-full-image="<?php echo esc_url($main_image_url); ?>">
        
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
    
    <!-- Превью галереи (если есть дополнительные изображения) -->
    <?php if (!empty($attachment_ids) && count($attachment_ids) > 0) : ?>
    <div class="product-thumbnails">
        <!-- Главное изображение как первое превью -->
        <div class="product-thumbnail product-thumbnail_active" data-image="<?php echo esc_url($main_image_url); ?>">
            <img src="<?php echo esc_url(wp_get_attachment_image_url($main_image_id, 'thumbnail')); ?>" 
                 alt="<?php echo esc_attr($main_image_alt); ?>">
        </div>
        
        <!-- Дополнительные изображения -->
        <?php 
        $thumb_count = 0;
        foreach ($attachment_ids as $attachment_id) : 
            if ($thumb_count >= 3) break; // Максимум 4 превью (1 главное + 3 дополнительных)
            $thumb_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
            $full_url = wp_get_attachment_image_url($attachment_id, 'full');
            $thumb_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
        ?>
        <div class="product-thumbnail" data-image="<?php echo esc_url($full_url); ?>">
            <img src="<?php echo esc_url($thumb_url); ?>" 
                 alt="<?php echo esc_attr($thumb_alt); ?>">
        </div>
        <?php 
            $thumb_count++;
        endforeach; 
        ?>
    </div>
    <?php endif; ?>
</div>
