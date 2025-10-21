<?php
/**
 * Шаблон одиночного тендера
 * 
 * @package DSA_Generators
 */

 /*
Template Name: О компании
*/

get_header();

// Хлебные крошки
dsa_breadcrumbs();
?>

<main class="main-content">
    <?php
    while (have_posts()) :
        the_post();
    ?>
        
        <!-- Page Header -->
        <section class="page-header">
            <div class="container">
                <h1 class="page-header__title"><?php the_title(); ?></h1>
            </div>
        </section>

        <!-- Tender Content -->
        <section class="tender-single">
            <div class="container">
                <div class="tender-single__content">
                    
                    <?php if (get_field('law_type')) : ?>
                        <div class="tender-single__meta">
                            <span class="tender-single__law-type">
                                <?php echo get_field('law_type') === '44fz' ? '44-ФЗ' : '223-ФЗ'; ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (get_field('contract_amount')) : ?>
                        <div class="tender-single__info-row">
                            <strong>Сумма контракта:</strong>
                            <span><?php echo esc_html(get_field('contract_amount')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (get_field('customer_name')) : ?>
                        <div class="tender-single__info-row">
                            <strong>Заказчик:</strong>
                            <span><?php echo esc_html(get_field('customer_name')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (get_field('contract_subject')) : ?>
                        <div class="tender-single__info-row">
                            <strong>Предмет контракта:</strong>
                            <span><?php echo esc_html(get_field('contract_subject')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (get_field('contract_date')) : ?>
                        <div class="tender-single__info-row">
                            <strong>Дата:</strong>
                            <span><?php echo esc_html(get_field('contract_date')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php the_content(); ?>

                    <div class="tender-single__navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <a href="<?php echo get_permalink($prev_post); ?>" class="btn btn--secondary">
                                <i class="fas fa-arrow-left"></i>
                                Предыдущий тендер
                            </a>
                        <?php endif; ?>

                        <a href="<?php echo get_post_type_archive_link('tender'); ?>" class="btn btn--primary">
                            Все тендеры
                        </a>

                        <?php if ($next_post) : ?>
                            <a href="<?php echo get_permalink($next_post); ?>" class="btn btn--secondary">
                                Следующий тендер
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </section>

    <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
?>
