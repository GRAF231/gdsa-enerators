<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header(); ?>

<?php
/**
 * Хлебные крошки
 */
if (function_exists('dsa_breadcrumbs')) {
    dsa_breadcrumbs();
}
?>

<main class="main-content">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            wc_get_template_part('content', 'single-product');
        endwhile; // end of the loop.
        ?>
    </div>
</main>

<?php
get_footer();
