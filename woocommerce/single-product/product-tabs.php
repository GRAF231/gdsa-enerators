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
        
        <!-- Табы навигация -->
        <div class="product-tabs">
            <div class="product-tabs__nav" role="tablist">
                <button class="product-tabs__btn active" 
                        data-tab="specifications" 
                        role="tab" 
                        aria-selected="true" 
                        aria-controls="tab-specifications">
                    Характеристики
                </button>
                
                <?php if ($has_docs) : ?>
                <button class="product-tabs__btn" 
                        data-tab="documentation" 
                        role="tab" 
                        aria-selected="false" 
                        aria-controls="tab-documentation">
                    Документация
                </button>
                <?php endif; ?>
            </div>
            
            <!-- Табы контент -->
            <div class="product-tabs__content">
                <!-- Таб "Характеристики" -->
                <div class="product-tabs__panel active" 
                     id="tab-specifications" 
                     data-panel="specifications" 
                     role="tabpanel" 
                     aria-labelledby="tab-specifications">
                    <?php wc_get_template('single-product/tab-specifications.php'); ?>
                </div>
                
                <!-- Таб "Документация" -->
                <?php if ($has_docs) : ?>
                <div class="product-tabs__panel" 
                     id="tab-documentation" 
                     data-panel="documentation" 
                     role="tabpanel" 
                     aria-labelledby="tab-documentation">
                    <?php wc_get_template('single-product/tab-documentation.php'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
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
        if ($engine_gallery) :
        ?>
            <div class="sidebar-section">
                <h3 class="sidebar-section__title">Фотографии двигателя <?php echo esc_html(get_field('engine')); ?></h3>
                <div class="engine-gallery">
                    <?php 
                    // Берем только первое изображение для отображения
                    $first_image = $engine_gallery[0];
                    if ($first_image) :
                    ?>
                        <img src="<?php echo esc_url($first_image['sizes']['large']); ?>" 
                             alt="<?php echo esc_attr($first_image['alt'] ? $first_image['alt'] : 'Двигатель ' . get_field('engine')); ?>" 
                             class="engine-img">
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
