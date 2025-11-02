<?php
/**
 * ============================================
 * МОДУЛЬ ФУНКЦИЙ НОВОСТЕЙ
 * ============================================
 * 
 * Функции для работы со страницей новостей:
 * - Счетчик просмотров постов
 * - Получение похожих материалов
 * - AJAX фильтрация
 * - Рендеринг карточек новостей
 * - Кастомная пагинация
 * 
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// СЧЕТЧИК ПРОСМОТРОВ ПОСТОВ
// ============================================

/**
 * Установить счетчик просмотров для поста
 * 
 * @param int $post_id ID поста
 * @return void
 */
function dsa_set_post_views($post_id) {
    if (!is_single() || get_post_type($post_id) !== 'post') {
        return;
    }
    
    // Проверяем transient для защиты от накруток (1 просмотр в час с одного IP)
    $transient_key = 'post_view_' . $post_id . '_' . md5($_SERVER['REMOTE_ADDR']);
    
    if (get_transient($transient_key)) {
        return; // Уже считали просмотр в течение часа
    }
    
    $count_key = '_post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count === '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
    
    // Устанавливаем transient на 1 час
    set_transient($transient_key, '1', HOUR_IN_SECONDS);
}

/**
 * Получить количество просмотров поста
 * 
 * @param int $post_id ID поста
 * @return int Количество просмотров
 */
function dsa_get_post_views($post_id) {
    $count_key = '_post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count === '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return 0;
    }
    
    return intval($count);
}

/**
 * Форматировать количество просмотров (1234 → 1,234)
 * 
 * @param int $views Количество просмотров
 * @return string Форматированное число
 */
function dsa_format_post_views($views) {
    return number_format($views, 0, '.', ',');
}

// ============================================
// ПОХОЖИЕ МАТЕРИАЛЫ
// ============================================

/**
 * Получить похожие посты
 * 
 * @param int $post_id ID текущего поста
 * @param int $limit Количество постов (по умолчанию 3)
 * @return array Массив объектов WP_Post
 */
function dsa_get_related_posts($post_id, $limit = 3) {
    // Проверяем кэш
    $cache_key = 'related_posts_' . $post_id . '_' . $limit;
    $cached = get_transient($cache_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    // Получаем категории текущего поста
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return array();
    }
    
    // Запрос похожих постов
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'post__not_in' => array($post_id),
        'category__in' => $categories,
        'orderby' => 'rand',
        'post_status' => 'publish'
    );
    
    $related_posts = get_posts($args);
    
    // Кэшируем на 1 час
    set_transient($cache_key, $related_posts, HOUR_IN_SECONDS);
    
    return $related_posts;
}

/**
 * Рендеринг блока "Новости не найдены"
 * 
 * @param string $category Текущая категория (для подсказок)
 * @return string HTML блока
 */
function dsa_render_no_news_found($category = '') {
    $categories = dsa_get_news_categories();
    $popular_categories = array_slice($categories, 0, 4); // Первые 4 категории
    
    ob_start();
    ?>
    <div class="news-grid__empty">
        <div class="empty-state">
            <div class="empty-state__icon">
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Газета с грустным лицом -->
                    <rect x="20" y="30" width="80" height="70" rx="4" fill="url(#news-gradient)" stroke="#0a1855" stroke-width="2"/>
                    <!-- Заголовок газеты -->
                    <rect x="30" y="40" width="60" height="4" rx="2" fill="#fff" opacity="0.5"/>
                    <rect x="30" y="48" width="40" height="3" rx="1.5" fill="#fff" opacity="0.3"/>
                    <!-- Грустное лицо -->
                    <circle cx="50" cy="70" r="5" fill="#0a1855"/>
                    <circle cx="70" cy="70" r="5" fill="#0a1855"/>
                    <path d="M 45 85 Q 60 80 75 85" stroke="#0a1855" stroke-width="2" fill="none" stroke-linecap="round"/>
                    <!-- Лупа -->
                    <circle cx="85" cy="85" r="12" stroke="#00c2ff" stroke-width="2" fill="none"/>
                    <line x1="94" y1="94" x2="102" y2="102" stroke="#00c2ff" stroke-width="2" stroke-linecap="round"/>
                    
                    <defs>
                        <linearGradient id="news-gradient" x1="20" y1="30" x2="100" y2="100" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#3b5fdb"/>
                            <stop offset="100%" stop-color="#00c2ff"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            
            <h3 class="empty-state__title">Новости не найдены</h3>
            <p class="empty-state__description">
                К сожалению, в этой категории пока нет новостей.
            </p>
            
            <div class="empty-state__actions">
                <?php if ($category && $category !== 'all') : ?>
                <button class="btn btn_type_primary" data-filter="all" onclick="document.querySelector('.news-filters__tab[data-filter=\'all\']').click()">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Сбросить фильтр</span>
                </button>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn_type_secondary">
                    <i class="fa-solid fa-house"></i>
                    <span>На главную</span>
                </a>
            </div>
            
            <?php if (!empty($popular_categories)) : ?>
            <div class="empty-state__suggestions">
                <h4 class="empty-state__suggestions-title">Популярные категории</h4>
                <div class="empty-state__suggestions-list">
                    <?php foreach ($popular_categories as $cat) : ?>
                    <button class="empty-state__suggestion-btn" data-filter="<?php echo esc_attr($cat->slug); ?>" onclick="document.querySelector('.news-filters__tab[data-filter=\'<?php echo esc_attr($cat->slug); ?>\']').click()">
                        <i class="fa-solid fa-folder"></i>
                        <?php echo esc_html($cat->name); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// ============================================
// ПОЛУЧЕНИЕ КАТЕГОРИЙ НОВОСТЕЙ
// ============================================

/**
 * Получить категории новостей для фильтров
 * 
 * @return array Массив объектов категорий
 */
function dsa_get_news_categories() {
    $categories = get_categories(array(
        'taxonomy' => 'category',
        'hide_empty' => true,
        'exclude' => array(1), // Исключаем категорию "Без рубрики" (ID = 1)
        'orderby' => 'name',
        'order' => 'ASC'
    ));
    
    return $categories;
}

// ============================================
// РЕНДЕРИНГ КАРТОЧКИ НОВОСТИ
// ============================================

/**
 * Рендеринг HTML карточки новости
 * 
 * @param WP_Post $post Объект поста
 * @return string HTML карточки
 */
function dsa_render_news_card($post) {
    $post_id = $post->ID;
    
    // Получаем данные
    $thumbnail = get_the_post_thumbnail_url($post_id, 'medium');
    if (!$thumbnail) {
        $thumbnail = 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center';
    }
    
    $categories = get_the_category($post_id);
    $category_name = !empty($categories) ? $categories[0]->name : 'Новости';
    $category_slug = !empty($categories) ? $categories[0]->slug : 'news';
    
    $date = get_the_date('j F Y', $post_id);
    $views = dsa_format_post_views(dsa_get_post_views($post_id));
    $title = get_the_title($post_id);
    $excerpt = get_the_excerpt($post_id);
    $permalink = get_permalink($post_id);
    
    ob_start();
    ?>
    <article class="news-card" data-category="<?php echo esc_attr($category_slug); ?>">
        <div class="news-card__image">
            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
            <div class="news-card__category"><?php echo esc_html($category_name); ?></div>
        </div>
        <div class="news-card__content">
            <div class="news-card__meta">
                <time class="news-card__date" datetime="<?php echo get_the_date('Y-m-d', $post_id); ?>">
                    <?php echo esc_html($date); ?>
                </time>
                <span class="news-card__views">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                    <?php echo esc_html($views); ?>
                </span>
            </div>
            <h3 class="news-card__title"><?php echo esc_html($title); ?></h3>
            <p class="news-card__excerpt"><?php echo esc_html($excerpt); ?></p>
            <a href="<?php echo esc_url($permalink); ?>" class="news-card__link">Читать далее</a>
        </div>
    </article>
    <?php
    return ob_get_clean();
}

// ============================================
// КАСТОМНАЯ ПАГИНАЦИЯ
// ============================================

/**
 * Кастомная пагинация для новостей
 * 
 * @param WP_Query $query Объект запроса
 * @return void
 */
function dsa_news_pagination($query = null) {
    global $wp_query;
    
    if (!$query) {
        $query = $wp_query;
    }
    
    $total_pages = $query->max_num_pages;
    $current_page = max(1, get_query_var('paged'));
    
    if ($total_pages <= 1) {
        return;
    }
    
    // Получаем текущие параметры фильтра
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : '';
    
    // Формируем базовый URL
    $base_url = get_permalink();
    $query_params = array();
    
    if ($category && $category !== 'all') {
        $query_params['category'] = $category;
    }
    if ($per_page) {
        $query_params['per_page'] = $per_page;
    }
    
    ?>
    <div class="pagination">
        <!-- Блок "Выводить по" -->
        <div class="pagination__per-page">
            <span class="pagination__per-page-label">Выводить по:</span>
            <div class="pagination__per-page-buttons">
                <?php
                $allowed_per_page = array(6, 12, 24, 48);
                $current_per_page = 12;
                
                if (isset($_COOKIE['news_per_page']) && in_array(intval($_COOKIE['news_per_page']), $allowed_per_page)) {
                    $current_per_page = intval($_COOKIE['news_per_page']);
                }
                
                foreach ($allowed_per_page as $value) {
                    $active_class = ($value === $current_per_page) ? ' pagination__per-page-btn_active' : '';
                    echo '<button class="pagination__per-page-btn' . $active_class . '" type="button" data-per-page="' . $value . '">' . $value . '</button>';
                }
                ?>
            </div>
        </div>
        
        <!-- Навигация по страницам -->
        <div class="pagination__nav">
            <?php
            // Кнопка "Предыдущая"
            if ($current_page > 1) {
                $prev_params = $query_params;
                $prev_url = add_query_arg(array_merge($prev_params, array('paged' => $current_page - 1)), $base_url);
                echo '<a href="' . esc_url($prev_url) . '" class="pagination__btn pagination__btn_prev">';
                echo '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i><span>Предыдущая</span>';
                echo '</a>';
            } else {
                echo '<button class="pagination__btn pagination__btn_prev" type="button" disabled>';
                echo '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i><span>Предыдущая</span>';
                echo '</button>';
            }
            ?>
            
            <div class="pagination__pages">
                <?php
                // Логика отображения страниц (как в WooCommerce каталоге)
                $range = 2; // Сколько страниц показывать вокруг текущей
                
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == 1 || $i == $total_pages || ($i >= $current_page - $range && $i <= $current_page + $range)) {
                        $page_params = $query_params;
                        $page_url = ($i == 1) ? $base_url : add_query_arg(array_merge($page_params, array('paged' => $i)), $base_url);
                        $active_class = ($i === $current_page) ? ' pagination__page_active' : '';
                        
                        if ($i === $current_page) {
                            echo '<button class="pagination__page' . $active_class . '" type="button">' . $i . '</button>';
                        } else {
                            echo '<a href="' . esc_url($page_url) . '" class="pagination__page' . $active_class . '">' . $i . '</a>';
                        }
                    } elseif ($i == $current_page - $range - 1 || $i == $current_page + $range + 1) {
                        echo '<span class="pagination__dots">...</span>';
                    }
                }
                ?>
            </div>
            
            <?php
            // Кнопка "Следующая"
            if ($current_page < $total_pages) {
                $next_params = $query_params;
                $next_url = add_query_arg(array_merge($next_params, array('paged' => $current_page + 1)), $base_url);
                echo '<a href="' . esc_url($next_url) . '" class="pagination__btn pagination__btn_next">';
                echo '<span>Следующая</span><i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
                echo '</a>';
            } else {
                echo '<button class="pagination__btn pagination__btn_next" type="button" disabled>';
                echo '<span>Следующая</span><i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
                echo '</button>';
            }
            ?>
        </div>
    </div>
    <?php
}

// ============================================
// AJAX ФИЛЬТРАЦИЯ НОВОСТЕЙ
// ============================================

/**
 * AJAX обработчик фильтрации новостей
 */
function dsa_ajax_filter_news() {
    // Проверка nonce
    check_ajax_referer('dsa_news_nonce', 'nonce');
    
    // Получаем параметры
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 12;
    
    // Проверяем per_page
    $allowed_per_page = array(6, 12, 24, 48);
    if (!in_array($per_page, $allowed_per_page)) {
        $per_page = 12;
    }
    
    // Формируем аргументы запроса
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $per_page,
        'paged' => $paged,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    // Добавляем фильтр по категории
    if ($category && $category !== 'all') {
        $args['category_name'] = $category;
    }
    
    // Выполняем запрос
    $query = new WP_Query($args);
    
    // Рендерим карточки
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo dsa_render_news_card(get_post());
        }
    } else {
        echo dsa_render_no_news_found($category);
    }
    
    $html = ob_get_clean();
    
    // Рендерим пагинацию
    ob_start();
    dsa_news_pagination($query);
    $pagination_html = ob_get_clean();
    
    // Формируем URL
    $url_params = array();
    if ($category && $category !== 'all') {
        $url_params['category'] = $category;
    }
    if ($paged > 1) {
        $url_params['paged'] = $paged;
    }
    
    $page_id = get_option('page_for_posts');
    if (!$page_id) {
        // Если страница для постов не установлена, используем текущий URL
        $base_url = home_url('/news/');
    } else {
        $base_url = get_permalink($page_id);
    }
    
    $url = empty($url_params) ? $base_url : add_query_arg($url_params, $base_url);
    
    wp_reset_postdata();
    
    // Отправляем ответ
    wp_send_json_success(array(
        'html' => $html,
        'pagination' => $pagination_html,
        'url' => $url,
        'total' => $query->found_posts,
        'current_page' => $paged,
        'total_pages' => $query->max_num_pages
    ));
}

// Регистрация AJAX actions
add_action('wp_ajax_dsa_filter_news', 'dsa_ajax_filter_news');
add_action('wp_ajax_nopriv_dsa_filter_news', 'dsa_ajax_filter_news');

// ============================================
// ЛОКАЛИЗАЦИЯ СКРИПТОВ
// ============================================

/**
 * Локализация данных для JavaScript
 */
function dsa_localize_news_scripts() {
    // Проверяем условия для страниц новостей
    if (is_home() || is_post_type_archive('post') || (is_single() && get_post_type() === 'post') || is_archive()) {
        // Проверяем что скрипт вообще загружен
        if (wp_script_is('dsa-news', 'enqueued')) {
            wp_localize_script('dsa-news', 'dsaNewsData', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('dsa_news_nonce')
            ));
        }
    }
}
add_action('wp_enqueue_scripts', 'dsa_localize_news_scripts', 99);

// ============================================
// ФУНКЦИЯ КОЛИЧЕСТВА ПОСТОВ НА СТРАНИЦУ
// ============================================

/**
 * Изменение количества постов на странице новостей
 * 
 * @param WP_Query $query
 */
function dsa_news_posts_per_page($query) {
    if (!is_admin() && $query->is_main_query() && (is_home() || is_post_type_archive('post'))) {
        $allowed = array(6, 12, 24, 48);
        $default = 12;
        
        // Проверяем GET параметр
        if (isset($_GET['per_page']) && in_array(intval($_GET['per_page']), $allowed)) {
            $per_page = intval($_GET['per_page']);
            setcookie('news_per_page', $per_page, time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);
            $query->set('posts_per_page', $per_page);
            return;
        }
        
        // Проверяем Cookie
        if (isset($_COOKIE['news_per_page']) && in_array(intval($_COOKIE['news_per_page']), $allowed)) {
            $query->set('posts_per_page', intval($_COOKIE['news_per_page']));
            return;
        }
        
        // Устанавливаем по умолчанию
        $query->set('posts_per_page', $default);
    }
}
add_action('pre_get_posts', 'dsa_news_posts_per_page');
