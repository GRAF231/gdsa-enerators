<?php
/**
 * Блок: CTA (Призыв к действию)
 * Layout: cta_block
 */

$cta_title = get_sub_field('cta_title') ?: 'Нужен расчет под вашу задачу?';
$cta_text = get_sub_field('cta_text') ?: 'Подготовим технико-коммерческое предложение в течение 24 часов.';
$cta_button_text = get_sub_field('cta_button_text') ?: 'Запросить ТКП';
$cta_button_link = get_sub_field('cta_button_link') ?: 'mailto:order@example.com';
?>

<div class="cta">
    <div class="cta__content">
        <h3 class="cta__title"><?php echo esc_html($cta_title); ?></h3>
        <p class="cta__text"><?php echo esc_html($cta_text); ?></p>
    </div>
    <button type="button" class="btn btn_type_primary cta__btn" onclick="openCallbackModal()">
        <?php echo esc_html($cta_button_text); ?>
    </button>
</div>
