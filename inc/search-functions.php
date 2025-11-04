<?php
/**
 * ФУНКЦИИ ПОИСКА
 * Улучшенный поиск по сайту с поддержкой WooCommerce
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Улучшенный поиск по товарам WooCommerce
 * Ищет по названию, описанию, краткому описанию, SKU и мета-полям ACF
 */
function dsa_improve_product_search($search, $query) {
    global $wpdb;

    // Только для поисковых запросов на фронтенде
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $search_term = $query->get('s');
        
        if (!empty($search_term)) {
            $search = '';
            
            // Поиск по основным полям
            $search .= " AND (
                ({$wpdb->posts}.post_title LIKE '%{$search_term}%')
                OR ({$wpdb->posts}.post_content LIKE '%{$search_term}%')
                OR ({$wpdb->posts}.post_excerpt LIKE '%{$search_term}%')
            ";
            
            // Добавляем поиск по SKU для товаров
            if (class_exists('WooCommerce')) {
                $search .= " OR EXISTS (
                    SELECT * FROM {$wpdb->postmeta} 
                    WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID 
                    AND {$wpdb->postmeta}.meta_key = '_sku' 
                    AND {$wpdb->postmeta}.meta_value LIKE '%{$search_term}%'
                )";
            }
            
            $search .= ")";
        }
    }

    return $search;
}
add_filter('posts_search', 'dsa_improve_product_search', 10, 2);

/**
 * Включаем WooCommerce товары в результаты поиска
 */
function dsa_search_include_products($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        // Добавляем типы постов для поиска
        $post_types = array('post', 'page', 'project', 'tender');
        
        // Если WooCommerce активен, добавляем товары
        if (class_exists('WooCommerce')) {
            $post_types[] = 'product';
        }
        
        $query->set('post_type', $post_types);
        
        // Увеличиваем количество результатов на странице
        $query->set('posts_per_page', 15);
    }
}
add_action('pre_get_posts', 'dsa_search_include_products');

/**
 * Выделение поискового запроса в результатах
 */
function dsa_highlight_search_term($text) {
    if (is_search() && !empty(get_search_query())) {
        $search_term = get_search_query();
        $pattern = '/(' . preg_quote($search_term, '/') . ')/iu';
        $replacement = '<mark class="search-highlight">$1</mark>';
        $text = preg_replace($pattern, $replacement, $text);
    }
    return $text;
}
add_filter('the_excerpt', 'dsa_highlight_search_term');
add_filter('the_content', 'dsa_highlight_search_term');

/**
 * Получение популярных поисковых запросов
 * Можно использовать для отображения в подсказках
 */
function dsa_get_popular_searches($limit = 5) {
    $popular_searches = get_option('dsa_popular_searches', array());
    
    // Сортируем по количеству
    arsort($popular_searches);
    
    // Ограничиваем количество
    $popular_searches = array_slice($popular_searches, 0, $limit, true);
    
    return $popular_searches;
}

/**
 * Сохранение статистики поисковых запросов
 */
function dsa_save_search_query() {
    if (is_search() && !empty(get_search_query())) {
        $search_term = sanitize_text_field(get_search_query());
        
        // Получаем существующие запросы
        $popular_searches = get_option('dsa_popular_searches', array());
        
        // Увеличиваем счетчик для этого запроса
        if (isset($popular_searches[$search_term])) {
            $popular_searches[$search_term]++;
        } else {
            $popular_searches[$search_term] = 1;
        }
        
        // Ограничиваем размер массива (храним максимум 100 запросов)
        if (count($popular_searches) > 100) {
            arsort($popular_searches);
            $popular_searches = array_slice($popular_searches, 0, 100, true);
        }
        
        // Сохраняем
        update_option('dsa_popular_searches', $popular_searches);
    }
}
add_action('wp', 'dsa_save_search_query');

/**
 * Кастомный заголовок для страницы поиска
 */
function dsa_search_page_title($title) {
    if (is_search()) {
        $title = sprintf(
            'Поиск: %s',
            get_search_query()
        );
    }
    return $title;
}
add_filter('get_the_archive_title', 'dsa_search_page_title');

/**
 * Исключение определенных типов постов из поиска (если нужно)
 */
function dsa_exclude_from_search($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        // Здесь можно добавить логику исключения, например:
        // $query->set('post__not_in', array(123, 456));
    }
}
// add_action('pre_get_posts', 'dsa_exclude_from_search');

/**
 * AJAX поиск (живой поиск)
 */
function dsa_ajax_search() {
    check_ajax_referer('dsa_search_nonce', 'nonce');
    
    $search_term = sanitize_text_field($_POST['search_term']);
    
    if (empty($search_term) || strlen($search_term) < 3) {
        wp_send_json_error(array('message' => 'Минимум 3 символа для поиска'));
    }
    
    // Выполняем поиск
    $args = array(
        's' => $search_term,
        'post_type' => array('post', 'page', 'product', 'project', 'tender'),
        'posts_per_page' => 5,
        'post_status' => 'publish'
    );
    
    $search_query = new WP_Query($args);
    $results = array();
    
    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            
            $post_type = get_post_type();
            $post_type_object = get_post_type_object($post_type);
            $post_type_name = $post_type_object ? $post_type_object->labels->singular_name : 'Запись';
            
            $result = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'type' => $post_type_name,
                'excerpt' => wp_trim_words(get_the_excerpt(), 15),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
            );
            
            // Для товаров добавляем цену
            if ($post_type === 'product' && class_exists('WooCommerce')) {
                $product = wc_get_product(get_the_ID());
                if ($product) {
                    $result['price'] = $product->get_price_html();
                }
            }
            
            $results[] = $result;
        }
        wp_reset_postdata();
    }
    
    if (!empty($results)) {
        wp_send_json_success(array(
            'results' => $results,
            'total' => $search_query->found_posts
        ));
    } else {
        wp_send_json_error(array('message' => 'Ничего не найдено'));
    }
}
add_action('wp_ajax_dsa_search', 'dsa_ajax_search');
add_action('wp_ajax_nopriv_dsa_search', 'dsa_ajax_search');

/**
 * Добавление CSS класса для выделения поисковых терминов
 */
function dsa_search_highlight_css() {
    if (is_search()) {
        echo '<style>
            .search-highlight {
                background: linear-gradient(135deg, rgba(59, 95, 219, 0.2) 0%, rgba(0, 194, 255, 0.2) 100%);
                padding: 2px 4px;
                border-radius: 3px;
                font-weight: 600;
                color: #0a1855;
            }
        </style>';
    }
}
add_action('wp_head', 'dsa_search_highlight_css');

/**
 * Улучшенная пагинация для поиска
 */
function dsa_search_pagination() {
    if (is_search()) {
        global $wp_query;
        
        if ($wp_query->max_num_pages > 1) {
            echo '<nav class="search-pagination" role="navigation">';
            echo paginate_links(array(
                'total' => $wp_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'prev_text' => '← Назад',
                'next_text' => 'Далее →',
                'type' => 'list'
            ));
            echo '</nav>';
        }
    }
}

/**
 * Кастомная пагинация для страницы поиска (аналог каталога)
 */
function dsa_custom_search_pagination() {
    global $wp_query;
    
    $total   = $wp_query->max_num_pages;
    $current = max(1, get_query_var('paged'));
    
    // Если страница только одна, не показываем пагинацию
    if ($total <= 1) {
        return;
    }
    
    // Функция для генерации URL страницы
    $get_page_link = function($page) {
        $search_query = get_search_query();
        
        // Базовый URL поиска
        $link = home_url('/');
        
        // Добавляем параметры
        $params = array('s' => $search_query);
        
        // Добавляем номер страницы, если не первая
        if ($page > 1) {
            $params['paged'] = $page;
        }
        
        // Создаем ссылку с параметрами
        $link = add_query_arg($params, $link);
        
        return $link;
    };
    
    echo '<div class="pagination">';
    
    echo '<div class="pagination__nav">';
    
    // Кнопка "Предыдущая"
    if ($current > 1) {
        $prev_link = $get_page_link($current - 1);
        echo '<a href="' . esc_url($prev_link) . '" class="pagination__btn pagination__btn_prev">';
        echo '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>';
        echo '<span>Предыдущая</span>';
        echo '</a>';
    } else {
        echo '<button class="pagination__btn pagination__btn_prev" type="button" disabled>';
        echo '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>';
        echo '<span>Предыдущая</span>';
        echo '</button>';
    }
    
    // Номера страниц
    echo '<div class="pagination__pages">';
    
    $range = 2; // Сколько страниц показывать по бокам от текущей
    
    // Первая страница
    if ($current > $range + 2) {
        $link = $get_page_link(1);
        echo '<a href="' . esc_url($link) . '" class="pagination__page">1</a>';
        if ($current > $range + 3) {
            echo '<span class="pagination__dots">...</span>';
        }
    }
    
    // Страницы вокруг текущей
    for ($i = max(1, $current - $range); $i <= min($total, $current + $range); $i++) {
        if ($i == $current) {
            echo '<button class="pagination__page pagination__page_active" type="button">' . $i . '</button>';
        } else {
            $link = $get_page_link($i);
            echo '<a href="' . esc_url($link) . '" class="pagination__page">' . $i . '</a>';
        }
    }
    
    // Последняя страница
    if ($current < $total - $range - 1) {
        if ($current < $total - $range - 2) {
            echo '<span class="pagination__dots">...</span>';
        }
        $link = $get_page_link($total);
        echo '<a href="' . esc_url($link) . '" class="pagination__page">' . $total . '</a>';
    }
    
    echo '</div>'; // pagination__pages
    
    // Кнопка "Следующая"
    if ($current < $total) {
        $next_link = $get_page_link($current + 1);
        echo '<a href="' . esc_url($next_link) . '" class="pagination__btn pagination__btn_next">';
        echo '<span>Следующая</span>';
        echo '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
        echo '</a>';
    } else {
        echo '<button class="pagination__btn pagination__btn_next" type="button" disabled>';
        echo '<span>Следующая</span>';
        echo '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
        echo '</button>';
    }
    
    echo '</div>'; // pagination__nav
    echo '</div>'; // pagination
}
