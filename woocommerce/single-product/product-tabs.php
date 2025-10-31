<?php
/**
 * Single Product Tabs (Specifications, Documentation)
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

// Проверяем, есть ли что показывать
$has_specs = get_field('engine_volume') || get_field('oil_volume') || get_field('rotation_speed');
$has_docs = have_rows('documents');
$has_engine_gallery = get_field('engine_gallery');
?>

<div class="product-specs">
    <div class="product-specs__content">
        <h2 class="product-specs__title">Технические характеристики <?php the_title(); ?></h2>
        
        <?php 
        $engine = get_field('engine');
        if ($engine) :
        ?>
        <div class="product-specs__subtitle">Двигатель <?php echo esc_html($engine); ?></div>
        <?php endif; ?>
        
        <!-- Характеристики без табов -->
        <?php wc_get_template('single-product/tab-specifications.php'); ?>
    </div>
    
    <!-- Sidebar с документацией и галереей двигателя -->
    <div class="product-sidebar">
        <?php
        // Документация (если есть)
        if ($has_docs) :
        ?>
            <div class="sidebar-section">
                <h3 class="sidebar-section__title">Скачать документацию</h3>
                <div class="documents-list">
                    <?php 
                    while (have_rows('documents')) : the_row();
                        $doc_title = get_sub_field('doc_title');
                        $doc_file = get_sub_field('doc_file');
                        
                        if ($doc_file) :
                    ?>
                        <a href="<?php echo esc_url($doc_file['url']); ?>" 
                           class="document-item" 
                           target="_blank" 
                           download>
                            <i class="fa-solid fa-file-pdf"></i>
                            <span><?php echo esc_html($doc_title ? $doc_title : $doc_file['filename']); ?></span>
                        </a>
                    <?php 
                        endif;
                    endwhile; 
                    ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php
        // Галерея двигателя (если есть)
        $engine_gallery = get_field('engine_gallery');
        if ($engine_gallery && !empty($engine_gallery)) :
        ?>
            <div class="sidebar-section">
                <h3 class="sidebar-section__title">Фотографии двигателя <?php echo esc_html(get_field('engine')); ?></h3>
                <div class="engine-gallery">
                    <?php 
                    // Выводим ВСЕ изображения из галереи
                    foreach ($engine_gallery as $index => $image) :
                        $image_url = $image['sizes']['large'] ?? $image['url'];
                        $image_full = $image['url']; // Полноразмерное для лайтбокса
                        $image_alt = $image['alt'] ? $image['alt'] : 'Двигатель ' . get_field('engine');
                    ?>
                        <div class="engine-gallery__item" data-lightbox="engine" data-image="<?php echo esc_url($image_full); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="<?php echo esc_attr($image_alt); ?>" 
                                 class="engine-img">
                            <div class="engine-gallery__overlay">
                                <i class="fa-solid fa-search-plus"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
