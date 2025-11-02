<?php
/**
 * Archive template for Projects
 */
get_header();

dsa_breadcrumbs(); 
?>

<!-- Заголовок страницы -->
<header class="page-header">
    <div class="container">
        <?php 
        // Получаем заголовок из системных настроек ACF
        $page_title = get_field('projects_archive_title', 'option');
        if (!$page_title) {
            $page_title = 'Выполненные проекты за 2014 - 2025 годы';
        }
        ?>
        <h1 class="page-header__title"><?php echo esc_html($page_title); ?></h1>
    </div>
</header>

<!-- Основной контент -->
<main class="main-content" role="main">
    <div class="container">
    <!-- Фильтры -->
    <section class="projects-filters">
        <?php 
        // Получаем настройки фильтров с информацией о доступности
        $filters = dsa_get_projects_filters_with_availability();
        
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
                        
                        <!-- Остальные опции фильтра (только доступные) -->
                        <?php foreach ($filter_config['options'] as $option) : ?>
                            <?php if (!empty($option['enabled']) && !empty($option['available'])) : ?>
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
            <button class="projects-filters__reset-btn" type="button" style="display: none;">
                <i class="fa-solid fa-refresh" aria-hidden="true"></i>
                Сбросить все фильтры
            </button>
        </div>
    </section>

    <!-- Проекты -->
    <section class="projects-grid">
        <div class="projects-grid__items">
            <?php
            // Получаем проекты из WordPress
            $projects_query = dsa_get_projects();
            
            if ($projects_query->have_posts()) :
                while ($projects_query->have_posts()) : $projects_query->the_post();
                    echo dsa_render_project_card(get_post());
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
    </section>

    <!-- Пагинация -->
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

