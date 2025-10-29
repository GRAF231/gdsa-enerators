<?php
/**
 * Template Name: Выполненные проекты
 */

get_header(); 

// Получаем глобальную переменную поста для доступа к данным страницы
global $post;

dsa_breadcrumbs(); ?>

    <!-- Основной контент -->
    <main>
  


        <!-- Заголовок страницы -->
        <header class="page-header">
            <div class="container">
                <?php 
                // Пробуем получить заголовок из ACF поля, если его нет - из заголовка страницы WordPress
                $page_title = get_field('projects_page_title', $post->ID);
                if (!$page_title) {
                    $page_title = get_the_title($post->ID);
                }
                // Fallback на дефолтное значение
                if (!$page_title) {
                    $page_title = 'Выполненные проекты за 2014 - 2025 годы';
                }
                ?>
                <h1 class="page-header__title"><?php echo esc_html($page_title); ?></h1>
            </div>
        </header>

        <!-- Фильтры -->
        <section class="projects-filters">
            <div class="container">
                <?php 
                // Получаем настройки фильтров из ACF
                $filters = dsa_get_projects_filters($post->ID);
                
                // Счетчик активных вкладок
                $active_tab_index = 0;
                ?>
                
                <div class="projects-filters__tabs">
                    <?php foreach ($filters as $filter_key => $filter_config) : ?>
                        <?php if ($filter_config['enabled']) : ?>
                            <button class="projects-filters__tab <?php echo $active_tab_index === 0 ? 'projects-filters__tab_active' : ''; ?>" 
                                    data-filter="<?php echo esc_attr($filter_key); ?>">
                                <?php echo esc_html($filter_config['label']); ?>
                    </button>
                            <?php $active_tab_index++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="projects-filters__content">
                    <?php 
                    $active_panel_index = 0;
                    foreach ($filters as $filter_key => $filter_config) : 
                        if (!$filter_config['enabled']) continue;
                    ?>
                        <div class="projects-filters__panel <?php echo $active_panel_index === 0 ? 'projects-filters__panel_active' : ''; ?>" 
                             data-panel="<?php echo esc_attr($filter_key); ?>">
                        <div class="projects-filters__options">
                                <!-- Кнопка "Все" всегда показывается -->
                            <button class="projects-filters__option projects-filters__option_active" data-value="all">Все</button>
                                
                                <!-- Остальные опции фильтра -->
                                <?php foreach ($filter_config['options'] as $option) : ?>
                                    <?php if (!empty($option['enabled'])) : ?>
                                        <button class="projects-filters__option" 
                                                data-value="<?php echo esc_attr($option['value']); ?>">
                                            <?php echo esc_html($option['label']); ?>
                                        </button>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                    </div>
                        </div>
                        <?php $active_panel_index++; ?>
                    <?php endforeach; ?>
                </div>

                <div class="projects-filters__actions">
                    <button class="projects-filters__reset-btn" type="button">
                        <i class="fa-solid fa-refresh" aria-hidden="true"></i>
                        Сбросить все фильтры
                    </button>
                </div>
            </div>
        </section>

        <!-- Проекты -->
        <section class="projects-grid">
            <div class="container">
                <div class="projects-grid__items">
                    <?php
                    // Получаем проекты из WordPress
                    $projects_query = dsa_get_projects();
                    
                    if ($projects_query->have_posts()) :
                        while ($projects_query->have_posts()) : $projects_query->the_post();
                            
                            // Получаем ACF поля
                            $power = get_field('power');
                            $power_range_field = get_field('power_range'); // Если задано вручную
                            $industry = get_field('industry');
                            $city = get_field('city');
                            $year = get_field('year');
                            $client = get_field('client');
                            
                            // Определяем диапазон мощности
                            // Сначала проверяем, задано ли поле power_range вручную
                            if (!empty($power_range_field)) {
                                $power_range = $power_range_field;
                            } elseif ($power) {
                                // Если power_range не задан, определяем автоматически на основе power
                                $power_range = dsa_determine_project_power_range(intval($power));
                            } else {
                                // Если мощность не указана, используем 'all' для совместимости с фильтрами
                                $power_range = 'all';
                            }
                            
                            // Получаем данные поста
                            $post_id = get_the_ID();
                            $title = get_the_title();
                            $permalink = get_permalink();
                            $excerpt = get_the_excerpt();
                            
                            // Изображение проекта
                            $image_url = '';
                            $image_alt = $title;
                            if (has_post_thumbnail()) {
                                $thumbnail_id = get_post_thumbnail_id();
                                $image_url = get_the_post_thumbnail_url($post_id, 'medium_large');
                                $image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: $title;
                            } else {
                                // Fallback изображение
                                $image_url = 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center';
                            }
                            
                            // Форматируем мощность для отображения
                            $power_display = $power ? number_format($power, 0, '.', ' ') . ' кВт' : '';
                            
                            // Значения для фильтрации (для совместимости с JS используем 'all' если значение отсутствует)
                            $industry_display = $industry ?: 'all';
                            $city_display = $city ?: 'all';
                            $year_display = $year ?: 'all';
                            $client_display = $client ?: '';
                            
                            ?>
                            <article class="project-card" 
                                     data-power="<?php echo esc_attr($power_range); ?>" 
                                     data-industry="<?php echo esc_attr($industry_display); ?>" 
                                     data-city="<?php echo esc_attr($city_display); ?>" 
                                     data-year="<?php echo esc_attr($year_display); ?>">
                                <a href="<?php echo esc_url($permalink); ?>" class="project-card__link">
                        <div class="project-card__image">
                                        <?php if ($image_url) : ?>
                                            <img src="<?php echo esc_url($image_url); ?>" 
                                                 alt="<?php echo esc_attr($image_alt); ?>" 
                                                 loading="lazy">
                                        <?php endif; ?>
                                        <?php if ($power_display) : ?>
                                            <div class="project-card__power"><?php echo esc_html($power_display); ?></div>
                                        <?php endif; ?>
                        </div>
                        <div class="project-card__content">
                                        <h3 class="project-card__title"><?php echo esc_html($title); ?></h3>
                                        <?php if ($client_display) : ?>
                                            <p class="project-card__client"><?php echo esc_html($client_display); ?></p>
                                        <?php endif; ?>
                        </div>
                                </a>
                    </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        ?>
                        <div class="projects-grid__empty">
                            <p class="projects-grid__empty-message">
                                Проекты не найдены. Добавьте проекты через админ-панель WordPress.
                            </p>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
        </section>

        <!-- Пагинация -->
        <div class="container">
            <div class="pagination">
                <!-- Показывать по -->
                <div class="pagination__per-page">
                    <span class="pagination__per-page-label">Выводить по:</span>
                    <div class="pagination__per-page-buttons">
                        <button class="pagination__per-page-btn" type="button">50</button>
                        <button class="pagination__per-page-btn pagination__per-page-btn_active" type="button">100</button>
                        <button class="pagination__per-page-btn" type="button">200</button>
                        <button class="pagination__per-page-btn" type="button">500</button>
                    </div>
                </div>
                <div class="pagination__nav">
                    <button class="pagination__btn pagination__btn_prev" type="button" disabled>
                        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                        <span>Предыдущая</span>
                    </button>
                    <div class="pagination__pages">
                        <button class="pagination__page pagination__page_active" type="button">1</button>
                        <button class="pagination__page" type="button">2</button>
                        <button class="pagination__page" type="button">3</button>
                        <span class="pagination__dots">...</span>
                        <button class="pagination__page" type="button">18</button>
                    </div>
                    <button class="pagination__btn pagination__btn_next" type="button">
                        <span>Следующая</span>
                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>


    </main>

    <?php get_footer(); ?>