<?php
/**
 * Блок: Галерея изображений
 * Layout: gallery
 */

$gallery_images = get_sub_field('gallery_images');

if ($gallery_images) {
    echo '<div class="gallery">';
    
    foreach ($gallery_images as $image) {
        $url = is_array($image) ? $image['url'] : $image;
        $alt = is_array($image) ? $image['alt'] : '';
        
        echo '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '" loading="lazy">';
    }
    
    echo '</div>';
}
