<?php
/**
 * Product Contact Form
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;
$power = get_field('power');
?>

   <!-- Форма запроса -->
   <div class="contact-form">
            <!-- <h2 class="contact-form__title"><?php echo esc_html(get_field('contact_form_title') ?: 'Оставьте заявку на расчет цены проекта дизельного генератора 16 кВт'); ?></h2> -->
            <?php echo do_shortcode('[contact-form-7 id="66a6e0c" title="Оставьте заявку"]'); ?>
        </div> 
  