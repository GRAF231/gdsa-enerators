<?php
/**
 * Product Additional Options
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Проверяем, есть ли дополнительные опции
if (!have_rows('additional_options')) {
    return;
}
?>

<div class="product-options">
    <h2 class="product-options__title">Выберите дополнительно:</h2>
    
    <div class="options-grid">
        <?php 
        while (have_rows('additional_options')) : the_row();
            $option_icon = get_sub_field('option_icon');
            $option_text = get_sub_field('option_text');
            
            if ($option_text) :
        ?>
            <div class="option-item">
                <div class="option-icon">
                    <?php if ($option_icon) : ?>
                        <i class="<?php echo esc_attr($option_icon); ?>"></i>
                    <?php else : ?>
                        <i class="fa-solid fa-cog"></i>
                    <?php endif; ?>
                </div>
                <div class="option-content">
                    <span class="option-text"><?php echo wp_kses_post($option_text); ?></span>
                </div>
            </div>
        <?php 
            endif;
        endwhile; 
        ?>
    </div>
</div>
