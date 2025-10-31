<?php
/**
 * The template for displaying all pages
 *
 * @package DSA_Generators
 */

get_header(); ?>

<main class="page-content">
    <?php
    // Хлебные крошки (если не главная страница)
    if (!is_front_page() && function_exists('dsa_breadcrumbs')) {
        dsa_breadcrumbs();
    }
    ?>

    <div class="container">
        <div class="page-wrapper">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
                    <?php
                    // Заголовок страницы (скрываем на некоторых специальных страницах WooCommerce)
                    if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page()) :
                    ?>
                        <header class="page-header">
                            <h1 class="page-title"><?php the_title(); ?></h1>
                        </header>
                    <?php endif; ?>

                    <div class="page-content-area">
                        <?php
                        // Содержимое страницы
                        the_content();

                        // Разбиение на страницы (если используется <!--nextpage-->)
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Страницы:', 'dsa'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>

                <?php
                // Если комментарии открыты или есть хотя бы один комментарий
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
