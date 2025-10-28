<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

/**
 * Hook: woocommerce_before_single_product.
 */
do_action('woocommerce_before_single_product');

if (!$product) {
    return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

    <!-- Заголовок товара -->
    <div class="product-header">
        <h1 class="product-title"><?php the_title(); ?></h1>
    </div>

    <!-- Основная информация о товаре -->
    <div class="product-main">
        <?php
        /**
         * Галерея изображений
         */
        wc_get_template('single-product/product-gallery.php');
        
        /**
         * Информация о товаре (цена, характеристики, кнопки)
         */
        wc_get_template('single-product/product-info.php');
        ?>
    </div>

    <!-- Технические характеристики с табами -->
    <?php wc_get_template('single-product/product-tabs.php'); ?>

    <!-- Описание товара -->
    <?php if (get_the_content()) : ?>
    <div class="product-description">
        <h2 class="product-description__title">Описание <?php the_title(); ?></h2>
        <div class="product-description__content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Форма запроса консультации -->
    <?php wc_get_template('single-product/product-contact-form.php'); ?>

    <!-- Дополнительные опции -->
    <?php wc_get_template('single-product/product-options.php'); ?>

    <!-- Наша команда -->
    <?php wc_get_template('single-product/product-team.php'); ?>

    <!-- Похожие товары -->
    <?php wc_get_template('single-product/product-related.php'); ?>

    <!-- Контактная информация -->
    <div class="product-contact">
        <div class="contact-info">
            <p class="contact-text">Подбор оборудования, КП с детализацией цены, договор и счет - запросите через</p>
            <a href="mailto:order@dsa-generators.ru" class="contact-email">order@dsa-generators.ru</a>
        </div>
    </div>

</div>

<?php do_action('woocommerce_after_single_product'); ?>
