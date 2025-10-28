<?php
/**
 * Tab: Documentation
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (have_rows('documents')) :
?>
<div class="documentation-content">
    <p class="documentation-content__intro">Доступная документация для скачивания:</p>
    
    <div class="documents-list documents-list_full">
        <?php 
        while (have_rows('documents')) : the_row();
            $doc_title = get_sub_field('doc_title');
            $doc_file = get_sub_field('doc_file');
            
            if ($doc_file) :
                // Получаем размер файла
                $file_size = '';
                if (isset($doc_file['filesize'])) {
                    $file_size = size_format($doc_file['filesize'], 2);
                }
        ?>
            <a href="<?php echo esc_url($doc_file['url']); ?>" 
               class="document-item document-item_detailed" 
               target="_blank" 
               download>
                <div class="document-item__icon">
                    <i class="fa-solid fa-file-pdf"></i>
                </div>
                <div class="document-item__info">
                    <span class="document-item__title">
                        <?php echo esc_html($doc_title ? $doc_title : $doc_file['filename']); ?>
                    </span>
                    <?php if ($file_size) : ?>
                        <span class="document-item__size"><?php echo esc_html($file_size); ?></span>
                    <?php endif; ?>
                </div>
                <div class="document-item__action">
                    <i class="fa-solid fa-download"></i>
                </div>
            </a>
        <?php 
            endif;
        endwhile; 
        ?>
    </div>
</div>
<?php else : ?>
<div class="documentation-content documentation-content_empty">
    <p>Документация для данного товара находится в стадии подготовки.</p>
    <p>Для получения технической документации, пожалуйста, свяжитесь с нами:</p>
    <a href="mailto:order@dsa-generators.ru" class="btn btn_type_primary">
        <i class="fa-solid fa-envelope"></i>
        <span>Запросить документацию</span>
    </a>
</div>
<?php endif; ?>
