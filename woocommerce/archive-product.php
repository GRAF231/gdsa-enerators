<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();

// Определяем текущий вид каталога
$catalog_view = dsa_get_catalog_view();

/**
 * Хлебные крошки
 */
if (function_exists('dsa_breadcrumbs')) {
    dsa_breadcrumbs();
}
?>

<!-- Заголовок страницы -->
<div class="page-header">
    <div class="container">
        <h1 class="page-header__title">
            <?php woocommerce_page_title(); ?>
        </h1>
    </div>
</div>

<main class="main-content">
    <div class="container">
        <div class="catalog">

            <?php
            /**
             * Фильтры каталога
             */
            woocommerce_get_template_part('catalog', 'filters');
            ?>

            <?php if (woocommerce_product_loop()) : ?>

                <?php
                /**
                 * Hook: woocommerce_before_shop_loop.
                 *
                 * @hooked woocommerce_output_all_notices - 10
                 * @hooked woocommerce_result_count - 20
                 * @hooked woocommerce_catalog_ordering - 30
                 */
                do_action('woocommerce_before_shop_loop');
                ?>

                <?php
                // Вывод заголовков таблицы только для табличного вида
                if ($catalog_view === 'list') {
                    dsa_catalog_table_header();
                }
                ?>

                <?php
                /**
                 * Вывод товаров с группировкой по мощности
                 */
                dsa_render_grouped_catalog_products($catalog_view);
                ?>

                <?php
                /**
                 * Hook: woocommerce_after_shop_loop.
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action('woocommerce_after_shop_loop');
                ?>

            <?php else : ?>

                <?php
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action('woocommerce_no_products_found');
                ?>

            <?php endif; ?>

        </div><!-- .catalog -->

    </div><!-- .container -->
</main><!-- .main-content -->

<?php
get_footer();
