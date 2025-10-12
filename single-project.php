<?php
/**
 * Single Project Template
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); 
    // Получаем ACF поля
    $power = get_field('power');
    $industry = get_field('industry');
    $city = get_field('city');
    $year = get_field('year');
    $client = get_field('client');
?>

    <!-- Хлебные крошки -->
    <nav class="breadcrumbs" aria-label="Навигационная цепочка">
        <div class="container">
            <ol class="breadcrumbs__list">
                <li class="breadcrumbs__item">
                    <a href="<?php echo home_url(); ?>" class="breadcrumbs__link">
                        <i class="fa-solid fa-home breadcrumbs__icon" aria-hidden="true"></i>
                        <span>Главная</span>
                    </a>
                </li>
                <li class="breadcrumbs__separator" aria-hidden="true">»</li>
                <li class="breadcrumbs__item">
                    <a href="<?php echo get_post_type_archive_link('project'); ?>" class="breadcrumbs__link">
                        <span>Проекты</span>
                    </a>
                </li>
                <li class="breadcrumbs__separator" aria-hidden="true">»</li>
                <li class="breadcrumbs__item breadcrumbs__item_current">
                    <span class="breadcrumbs__current"><?php the_title(); ?></span>
                </li>
            </ol>
        </div>
    </nav>

    <!-- Заголовок страницы -->
    <header class="page-header">
        <div class="container">
            <h1 class="page-header__title"><?php the_title(); ?></h1>
        </div>
    </header>

    <!-- Контент проекта -->
    <section class="project-single">
        <div class="container">
            <div class="project-single__content">
                
                <!-- Изображение проекта -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="project-single__image">
                        <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                    </div>
                <?php endif; ?>

                <!-- Метаинформация проекта -->
                <div class="project-single__meta">
                    <?php if ( $power ) : ?>
                        <div class="project-single__meta-item">
                            <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                            <strong>Мощность:</strong> <?php echo esc_html($power); ?> кВт
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $industry ) : ?>
                        <div class="project-single__meta-item">
                            <i class="fa-solid fa-industry" aria-hidden="true"></i>
                            <strong>Отрасль:</strong> <?php echo esc_html($industry); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $city ) : ?>
                        <div class="project-single__meta-item">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <strong>Город:</strong> <?php echo esc_html($city); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $year ) : ?>
                        <div class="project-single__meta-item">
                            <i class="fa-solid fa-calendar" aria-hidden="true"></i>
                            <strong>Год:</strong> <?php echo esc_html($year); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $client ) : ?>
                        <div class="project-single__meta-item">
                            <i class="fa-solid fa-building" aria-hidden="true"></i>
                            <strong>Клиент:</strong> <?php echo esc_html($client); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Основное содержимое -->
                <div class="project-single__description">
                    <?php the_content(); ?>
                </div>

                <!-- Навигация между проектами -->
                <div class="project-single__navigation">
                    <div class="project-single__nav-prev">
                        <?php 
                        $prev_post = get_previous_post();
                        if ( $prev_post ) : ?>
                            <a href="<?php echo get_permalink($prev_post); ?>" class="project-single__nav-link">
                                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                                <span>Предыдущий проект</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="project-single__nav-back">
                        <a href="<?php echo get_post_type_archive_link('project'); ?>" class="project-single__nav-link">
                            <i class="fa-solid fa-th" aria-hidden="true"></i>
                            <span>Все проекты</span>
                        </a>
                    </div>
                    
                    <div class="project-single__nav-next">
                        <?php 
                        $next_post = get_next_post();
                        if ( $next_post ) : ?>
                            <a href="<?php echo get_permalink($next_post); ?>" class="project-single__nav-link">
                                <span>Следующий проект</span>
                                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>

