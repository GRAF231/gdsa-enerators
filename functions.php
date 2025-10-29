<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Поддержка функций темы
function dsa_generators_theme_setup() {
    // Поддержка миниатюр записей
    add_theme_support('post-thumbnails');
    
    // Поддержка заголовка документа
    add_theme_support('title-tag');
    
    // Поддержка HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'dsa_generators_theme_setup');

function dsa_generators_assets() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    
    // ============================================
    // БАЗОВЫЕ СТИЛИ (загружаются на всех страницах)
    // ============================================
    $base_styles = array(
        'variables',
        'reset',
        'typography',
        'layout',
        'utilities',
        'buttons',
        'header',
        'footer',
        'breadcrumbs',
        'pagination',
        'contact-form'
    );
    
    foreach ($base_styles as $style) {
        $file = $theme_dir . '/assets/css/' . $style . '.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-' . $style, $theme_uri . '/assets/css/' . $style . '.css', array(), filemtime($file));
        }
    }
    
    // ============================================
    // УСЛОВНЫЕ СТИЛИ (загружаются на специфичных страницах)
    // ============================================
    
    // Главная страница
    if (is_front_page() || is_home()) {
        $home_styles = array('home-slider', 'home-catalog', 'home-advantages', 'home-equipment', 'home-popular', 'home-projects', 'home-news', 'home-catalog-footer');
        foreach ($home_styles as $style) {
            $file = $theme_dir . '/assets/css/home/' . $style . '.css';
            if (file_exists($file)) {
                wp_enqueue_style('dsa-' . $style, $theme_uri . '/assets/css/home/' . $style . '.css', array(), filemtime($file));
            }
        }
        
        // JS для главной
        $home_scripts = array('home-slider', 'home-popular', 'home-projects');
        foreach ($home_scripts as $script) {
            $file = $theme_dir . '/assets/js/' . $script . '.js';
            if (file_exists($file)) {
                wp_enqueue_script('dsa-' . $script, $theme_uri . '/assets/js/' . $script . '.js', array('jquery'), filemtime($file), true);
            }
        }
    }
    
    // О компании
    if (is_page_template('template-about.php')) {
        $file = $theme_dir . '/assets/css/about/about.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-about', $theme_uri . '/assets/css/about/about.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/about.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-about', $theme_uri . '/assets/js/about.js', array('jquery'), filemtime($file), true);
        }
        // Лицензии
        $file = $theme_dir . '/assets/css/company-licenses.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-company-licenses', $theme_uri . '/assets/css/company-licenses.css', array(), filemtime($file));
        }
    }
    
    // Контакты
    if (is_page_template('template-contacts.php')) {
        $file = $theme_dir . '/assets/css/contacts.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-contacts', $theme_uri . '/assets/css/contacts.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/contacts.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-contacts', $theme_uri . '/assets/js/contacts.js', array('jquery'), filemtime($file), true);
        }
        $file = $theme_dir . '/assets/css/contact-form.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-contact-form', $theme_uri . '/assets/css/contact-form.css', array(), filemtime($file));
        }
    }
    
    // Производство
    if (is_page_template('template-production.php')) {
        $file = $theme_dir . '/assets/css/production.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-production', $theme_uri . '/assets/css/production.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/production.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-production', $theme_uri . '/assets/js/production.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Проекты
    if (is_page_template('template-projects.php') || is_singular('project')) {
        $file = $theme_dir . '/assets/css/projects.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-projects', $theme_uri . '/assets/css/projects.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/projects.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-projects', $theme_uri . '/assets/js/projects.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Благодарности
    if (is_page_template('template-gratitude.php')) {
        $file = $theme_dir . '/assets/css/gratitude.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-gratitude', $theme_uri . '/assets/css/gratitude.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/gratitude.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-gratitude', $theme_uri . '/assets/js/gratitude.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Новости
    if (is_page_template('template-news.php')) {
        $file = $theme_dir . '/assets/css/news.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-news', $theme_uri . '/assets/css/news.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/news.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-news', $theme_uri . '/assets/js/news.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Статья новости
    if (is_page_template('template-news-article.php')) {
        $file = $theme_dir . '/assets/css/news-article.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-news-article', $theme_uri . '/assets/css/news-article.css', array(), filemtime($file));
        }
    }
    
    // Тендеры
    if (is_page_template('template-tenders.php') || is_singular('tender')) {
        $file = $theme_dir . '/assets/css/tenders.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-tenders', $theme_uri . '/assets/css/tenders.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/tenders.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-tenders', $theme_uri . '/assets/js/tenders.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Проектирование и EPC
    if (is_page_template('template-design-epc.php')) {
        $file = $theme_dir . '/assets/css/design-epc.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-design-epc', $theme_uri . '/assets/css/design-epc.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/design-epc.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-design-epc', $theme_uri . '/assets/js/design-epc.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // ============================================
    // БАЗОВЫЙ JS (на всех страницах)
    // ============================================
    $file = $theme_dir . '/assets/js/main.js';
    if (file_exists($file)) {
        wp_enqueue_script('dsa-main', $theme_uri . '/assets/js/main.js', array('jquery'), filemtime($file), true);
    }
    
    // ============================================
    // ВНЕШНИЕ БИБЛИОТЕКИ
    // ============================================
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap', array(), null);


    wp_enqueue_style('dsa-style', $theme_uri . '/style.css', array(), null);
}
add_action('wp_enqueue_scripts', 'dsa_generators_assets');

/**
 * Вспомогательная функция: добавляет разделитель хлебных крошек
 */
function dsa_breadcrumb_separator() {
    echo '<li class="breadcrumbs__separator" aria-hidden="true">»</li>';
}

/**
 * Вспомогательная функция: добавляет ссылку в хлебных крошках
 */
function dsa_breadcrumb_link($url, $title) {
    dsa_breadcrumb_separator();
    echo '<li class="breadcrumbs__item">';
    echo '<a href="' . esc_url($url) . '" class="breadcrumbs__link">';
    echo '<span>' . esc_html($title) . '</span>';
    echo '</a>';
    echo '</li>';
}

/**
 * Вспомогательная функция: добавляет текущий элемент хлебных крошек
 */
function dsa_breadcrumb_current($title) {
    dsa_breadcrumb_separator();
    echo '<li class="breadcrumbs__item breadcrumbs__item_current">';
    echo '<span class="breadcrumbs__current">' . esc_html($title) . '</span>';
    echo '</li>';
}

/**
 * Универсальная функция вывода хлебных крошек
 * Автоматически определяет тип страницы и использует названия из WordPress
 * Использование: dsa_breadcrumbs();
 */
function dsa_breadcrumbs() {
    // Не показываем хлебные крошки на главной странице
    if ( is_front_page() ) {
        return;
    }
    
    echo '<nav class="breadcrumbs" aria-label="Навигационная цепочка">';
    echo '<div class="container">';
    echo '<ol class="breadcrumbs__list">';
    
    // Главная страница (всегда первая)
    echo '<li class="breadcrumbs__item">';
    echo '<a href="' . esc_url(home_url()) . '" class="breadcrumbs__link">';
    echo '<i class="fa-solid fa-home breadcrumbs__icon" aria-hidden="true"></i>';
    echo '<span>Главная</span>';
    echo '</a>';
    echo '</li>';
    
    // Архив пользовательского типа записи (CPT)
    if ( is_post_type_archive() ) {
        $post_type = get_query_var('post_type');
        if ( is_array($post_type) ) {
            $post_type = reset($post_type);
        }
        $post_type_obj = get_post_type_object($post_type);
        
        if ( $post_type_obj ) {
            dsa_breadcrumb_current($post_type_obj->labels->name);
        }
    }
    // Одиночная запись CPT или стандартного типа
    elseif ( is_singular() ) {
        $post_type = get_post_type();
        
        // Если это не стандартная запись (post) или страница, добавляем ссылку на архив
        if ( $post_type !== 'post' && $post_type !== 'page' ) {
            $post_type_obj = get_post_type_object($post_type);
            $archive_link = get_post_type_archive_link($post_type);
            
            if ( $post_type_obj && $archive_link ) {
                dsa_breadcrumb_link($archive_link, $post_type_obj->labels->name);
            }
        }
        // Для стандартных записей (post) добавляем категорию
        elseif ( $post_type === 'post' ) {
            $categories = get_the_category();
            if ( !empty($categories) ) {
                $category = $categories[0];
                dsa_breadcrumb_link(get_category_link($category->term_id), $category->name);
            }
        }
        
        // Название текущей записи/страницы
        dsa_breadcrumb_current(get_the_title());
    }
    // Архив категории
    elseif ( is_category() ) {
        dsa_breadcrumb_current(single_cat_title('', false));
    }
    // Архив тегов
    elseif ( is_tag() ) {
        dsa_breadcrumb_current(single_tag_title('', false));
    }
    // Страница поиска
    elseif ( is_search() ) {
        dsa_breadcrumb_current('Результаты поиска: ' . get_search_query());
    }
    // Страница 404
    elseif ( is_404() ) {
        dsa_breadcrumb_current('Страница не найдена');
    }
    
    echo '</ol>';
    echo '</div>';
    echo '</nav>';
}

// Регистрация пользовательского типа записи "Проекты"
function register_project_cpt() {
    register_post_type('project', [
        'labels' => [
            'name' => 'Проекты',
            'singular_name' => 'Проект',
            'add_new' => 'Добавить проект',
            'add_new_item' => 'Добавить новый проект',
            'edit_item' => 'Редактировать проект',
            'new_item' => 'Новый проект',
            'view_item' => 'Просмотр проекта',
            'search_items' => 'Искать проекты',
            'not_found' => 'Проекты не найдены',
            'not_found_in_trash' => 'В корзине проектов не найдено',
        ],
        'public' => true,
        'has_archive' => 'projects',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'projects'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-portfolio',
    ]);
}
add_action('init', 'register_project_cpt');

// Регистрация пользовательского типа записи "Тендеры"
function register_tender_cpt() {
    register_post_type('tender', [
        'labels' => [
            'name' => 'Тендеры',
            'singular_name' => 'Тендер',
            'add_new' => 'Добавить тендер',
            'add_new_item' => 'Добавить новый тендер',
            'edit_item' => 'Редактировать тендер',
            'new_item' => 'Новый тендер',
            'view_item' => 'Просмотр тендера',
            'search_items' => 'Искать тендеры',
            'not_found' => 'Тендеры не найдены',
            'not_found_in_trash' => 'В корзине тендеров не найдено',
        ],
        'public' => true,
        'has_archive' => 'tenders',
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'tenders'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-gavel',
    ]);
}
add_action('init', 'register_tender_cpt');

// Автоматический импорт ACF полей из JSON
add_filter('acf/settings/save_json', function($path) {
    return get_stylesheet_directory() . '/acf-exports';
});

add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-exports';
    return $paths;
});

// ============================================
// ФУНКЦИИ ДЛЯ ПРОЕКТОВ
// ============================================

/**
 * Определение диапазона мощности для проекта на основе значения мощности
 * 
 * @param int $power Мощность в кВт
 * @return string Ключ диапазона мощности
 */
function dsa_determine_project_power_range($power) {
    if (!$power || $power < 16) {
        return '16-40';
    }
    
    $ranges = [
        '16-40' => ['min' => 16, 'max' => 40],
        '40-80' => ['min' => 40, 'max' => 80],
        '80-100' => ['min' => 80, 'max' => 100],
        '100-150' => ['min' => 100, 'max' => 150],
        '150-200' => ['min' => 150, 'max' => 200],
        '200-300' => ['min' => 200, 'max' => 300],
        '300-500' => ['min' => 300, 'max' => 500],
        '500-700' => ['min' => 500, 'max' => 700],
        '800-1000' => ['min' => 800, 'max' => 1000],
        '1000-1500' => ['min' => 1000, 'max' => 1500],
        '1500-2000' => ['min' => 1500, 'max' => 2000],
        '2000-3000' => ['min' => 2000, 'max' => 3000],
        '3000-6000' => ['min' => 3000, 'max' => 6000],
        '6000-12000' => ['min' => 6000, 'max' => 12000],
    ];
    
    foreach ($ranges as $key => $range) {
        if ($power >= $range['min'] && $power < $range['max']) {
            return $key;
        }
    }
    
    // Если мощность больше максимального диапазона
    return '6000-12000';
}

/**
 * Получение проектов с фильтрацией
 * 
 * @param array $args Параметры запроса
 * @return WP_Query Объект запроса WordPress
 */
function dsa_get_projects($args = []) {
    $defaults = [
        'post_type' => 'project',
        'posts_per_page' => -1, // Все проекты для фильтрации на клиенте
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    // Параметры фильтрации из GET
    $meta_query = [];
    
    // Фильтр по диапазону мощности
    if (isset($_GET['power']) && $_GET['power'] !== 'all') {
        $power_range = sanitize_text_field($_GET['power']);
        $ranges = [
            '16-40' => ['min' => 16, 'max' => 40],
            '40-80' => ['min' => 40, 'max' => 80],
            '80-100' => ['min' => 80, 'max' => 100],
            '100-150' => ['min' => 100, 'max' => 150],
            '150-200' => ['min' => 150, 'max' => 200],
            '200-300' => ['min' => 200, 'max' => 300],
            '300-500' => ['min' => 300, 'max' => 500],
            '500-700' => ['min' => 500, 'max' => 700],
            '800-1000' => ['min' => 800, 'max' => 1000],
            '1000-1500' => ['min' => 1000, 'max' => 1500],
            '1500-2000' => ['min' => 1500, 'max' => 2000],
            '2000-3000' => ['min' => 2000, 'max' => 3000],
            '3000-6000' => ['min' => 3000, 'max' => 6000],
            '6000-12000' => ['min' => 6000, 'max' => 12000],
        ];
        
        if (isset($ranges[$power_range])) {
            $meta_query[] = [
                'key' => 'power',
                'value' => [$ranges[$power_range]['min'], $ranges[$power_range]['max']],
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            ];
        }
    }
    
    // Фильтр по отрасли
    if (isset($_GET['industry']) && $_GET['industry'] !== 'all') {
        $meta_query[] = [
            'key' => 'industry',
            'value' => sanitize_text_field($_GET['industry']),
            'compare' => '=',
        ];
    }
    
    // Фильтр по городу
    if (isset($_GET['city']) && $_GET['city'] !== 'all') {
        $meta_query[] = [
            'key' => 'city',
            'value' => sanitize_text_field($_GET['city']),
            'compare' => '=',
        ];
    }
    
    // Фильтр по году
    if (isset($_GET['year']) && $_GET['year'] !== 'all') {
        $meta_query[] = [
            'key' => 'year',
            'value' => sanitize_text_field($_GET['year']),
            'compare' => '=',
        ];
    }
    
    if (!empty($meta_query)) {
        $defaults['meta_query'] = $meta_query;
    }
    
    $query_args = wp_parse_args($args, $defaults);
    
    return new WP_Query($query_args);
}

/**
 * Получение настроек фильтров из ACF с fallback на дефолтные значения
 * 
 * @param int $page_id ID страницы
 * @return array Массив настроек фильтров
 */
function dsa_get_projects_filters($page_id = null) {
    if (!$page_id) {
        global $post;
        $page_id = $post->ID ?? 0;
    }
    
    $settings = get_field('projects_filters_settings', $page_id);
    
    // Дефолтные значения фильтров
    $defaults = [
        'power' => [
            'enabled' => true,
            'label' => 'Диапазон мощности',
            'options' => [
                ['value' => '16-40', 'label' => '16-40 кВт', 'enabled' => true],
                ['value' => '40-80', 'label' => '40-80 кВт', 'enabled' => true],
                ['value' => '80-100', 'label' => '80-100 кВт', 'enabled' => true],
                ['value' => '100-150', 'label' => '100-150 кВт', 'enabled' => true],
                ['value' => '150-200', 'label' => '150-200 кВт', 'enabled' => true],
                ['value' => '200-300', 'label' => '200-300 кВт', 'enabled' => true],
                ['value' => '300-500', 'label' => '300-500 кВт', 'enabled' => true],
                ['value' => '500-700', 'label' => '500-700 кВт', 'enabled' => true],
                ['value' => '800-1000', 'label' => '800-1000 кВт', 'enabled' => true],
                ['value' => '1000-1500', 'label' => '1000-1500 кВт', 'enabled' => true],
                ['value' => '1500-2000', 'label' => '1500-2000 кВт', 'enabled' => true],
                ['value' => '2000-3000', 'label' => '2000-3000 кВт', 'enabled' => true],
                ['value' => '3000-6000', 'label' => '3000-6000 кВт', 'enabled' => true],
                ['value' => '6000-12000', 'label' => '6000-12000 кВт', 'enabled' => true],
            ]
        ],
        'industry' => [
            'enabled' => true,
            'label' => 'Отрасль применения',
            'options' => [
                ['value' => 'banks', 'label' => 'Банки', 'enabled' => true],
                ['value' => 'business_centers', 'label' => 'Бизнес-центры', 'enabled' => true],
                ['value' => 'commercial', 'label' => 'Коммерция', 'enabled' => true],
                ['value' => 'construction', 'label' => 'Строительство', 'enabled' => true],
                ['value' => 'data_centers', 'label' => 'Дата-центры', 'enabled' => true],
                ['value' => 'energy', 'label' => 'Энергетика', 'enabled' => true],
                ['value' => 'government', 'label' => 'Государственные и силовые структуры', 'enabled' => true],
                ['value' => 'healthcare', 'label' => 'Здравоохранение', 'enabled' => true],
                ['value' => 'hospitality', 'label' => 'Гостиничный бизнес', 'enabled' => true],
                ['value' => 'hotels', 'label' => 'Гостиницы', 'enabled' => true],
                ['value' => 'housing_utilities', 'label' => 'ЖКХ и социальная сфера', 'enabled' => true],
                ['value' => 'industrial', 'label' => 'Промышленность', 'enabled' => true],
                ['value' => 'mining', 'label' => 'Горнодобывающая', 'enabled' => true],
                ['value' => 'oil_gas', 'label' => 'Нефтегазовая отрасль', 'enabled' => true],
                ['value' => 'private_sector', 'label' => 'Частный сектор', 'enabled' => true],
                ['value' => 'production', 'label' => 'Производство', 'enabled' => true],
                ['value' => 'residential', 'label' => 'Жилые объекты', 'enabled' => true],
                ['value' => 'science_education', 'label' => 'Наука и образование', 'enabled' => true],
                ['value' => 'agriculture', 'label' => 'Сельское хозяйство', 'enabled' => true],
                ['value' => 'trade_services', 'label' => 'Торговля и услуги', 'enabled' => true],
                ['value' => 'transport', 'label' => 'Транспорт', 'enabled' => true],
            ]
        ],
        'city' => [
            'enabled' => true,
            'label' => 'Город',
            'options' => [
                ['value' => 'abinsk', 'label' => 'Абинск', 'enabled' => true],
                ['value' => 'abkhazia', 'label' => 'Абхазия', 'enabled' => true],
                ['value' => 'africa', 'label' => 'Африка', 'enabled' => true],
                ['value' => 'archangelsk', 'label' => 'Архангельск', 'enabled' => true],
                ['value' => 'achinsk', 'label' => 'Ачинск', 'enabled' => true],
                ['value' => 'baikonur', 'label' => 'Байконур', 'enabled' => true],
                ['value' => 'bangladesh', 'label' => 'Бангладеш', 'enabled' => true],
                ['value' => 'belgorod', 'label' => 'Белгородская область', 'enabled' => true],
                ['value' => 'belarus', 'label' => 'Республика Беларусь', 'enabled' => true],
                ['value' => 'bryansk', 'label' => 'Брянская область', 'enabled' => true],
                ['value' => 'vladimir', 'label' => 'Владимирская область', 'enabled' => true],
                ['value' => 'vladivostok', 'label' => 'Владивосток', 'enabled' => true],
                ['value' => 'voronezh', 'label' => 'Воронеж', 'enabled' => true],
                ['value' => 'vyborg', 'label' => 'Выборг', 'enabled' => true],
                ['value' => 'vsevolozhsk', 'label' => 'Всеволожск', 'enabled' => true],
                ['value' => 'gelendzhik', 'label' => 'Геленджик', 'enabled' => true],
                ['value' => 'gorny_altai', 'label' => 'Горно-Алтайск', 'enabled' => true],
                ['value' => 'grozny', 'label' => 'Грозный', 'enabled' => true],
                ['value' => 'gydan', 'label' => 'Гыданский полуостров', 'enabled' => true],
                ['value' => 'egypt', 'label' => 'Египет', 'enabled' => true],
                ['value' => 'ekaterinburg', 'label' => 'Екатеринбург', 'enabled' => true],
                ['value' => 'essentuki', 'label' => 'Ессентуки', 'enabled' => true],
                ['value' => 'ivanovo', 'label' => 'Ивановская область', 'enabled' => true],
                ['value' => 'izhevsk', 'label' => 'Ижевск', 'enabled' => true],
                ['value' => 'irkutsk', 'label' => 'Иркутск', 'enabled' => true],
                ['value' => 'irkutsk_region', 'label' => 'Иркутская область', 'enabled' => true],
                ['value' => 'kazakhstan', 'label' => 'Казахстан', 'enabled' => true],
                ['value' => 'kaluga', 'label' => 'Калуга', 'enabled' => true],
                ['value' => 'kaliningrad', 'label' => 'Калининград', 'enabled' => true],
                ['value' => 'kamchatka', 'label' => 'Камчатский край', 'enabled' => true],
                ['value' => 'karelia', 'label' => 'Карелия', 'enabled' => true],
                ['value' => 'kemerovo', 'label' => 'Кемеровская область', 'enabled' => true],
                ['value' => 'kirov', 'label' => 'Кировская область', 'enabled' => true],
                ['value' => 'krasnodar', 'label' => 'Краснодарский край', 'enabled' => true],
                ['value' => 'krasnoyarsk', 'label' => 'Красноярский край', 'enabled' => true],
                ['value' => 'crimea', 'label' => 'Крым', 'enabled' => true],
                ['value' => 'kursk', 'label' => 'Курск', 'enabled' => true],
                ['value' => 'lensk', 'label' => 'Ленск', 'enabled' => true],
                ['value' => 'leningrad_region', 'label' => 'Ленобласть', 'enabled' => true],
                ['value' => 'lobnya', 'label' => 'Лобня', 'enabled' => true],
                ['value' => 'magadan', 'label' => 'Магаданская область', 'enabled' => true],
                ['value' => 'mezen', 'label' => 'Мезень (Архангельская область)', 'enabled' => true],
                ['value' => 'moscow', 'label' => 'Москва', 'enabled' => true],
                ['value' => 'moscow_region', 'label' => 'Московская область', 'enabled' => true],
                ['value' => 'murmansk', 'label' => 'Мурманск', 'enabled' => true],
                ['value' => 'nalchik', 'label' => 'Нальчик', 'enabled' => true],
                ['value' => 'novaya_zemlya', 'label' => 'Новая Земля', 'enabled' => true],
                ['value' => 'novorossiysk', 'label' => 'Новороссийск', 'enabled' => true],
                ['value' => 'nnovgorod', 'label' => 'Нижний Новгород', 'enabled' => true],
                ['value' => 'novy_urengoy', 'label' => 'Новый Уренгой', 'enabled' => true],
                ['value' => 'norilsk', 'label' => 'Норильск', 'enabled' => true],
                ['value' => 'penza', 'label' => 'Пензенская область', 'enabled' => true],
                ['value' => 'primorsky', 'label' => 'Приморский край', 'enabled' => true],
                ['value' => 'rostov', 'label' => 'Ростов-на-Дону', 'enabled' => true],
                ['value' => 'rostov_region', 'label' => 'Ростовская область', 'enabled' => true],
                ['value' => 'samara', 'label' => 'Самара', 'enabled' => true],
                ['value' => 'sakhalin', 'label' => 'Сахалин', 'enabled' => true],
                ['value' => 'svobodny', 'label' => 'Свободный', 'enabled' => true],
                ['value' => 'sverdlovsk', 'label' => 'Свердловская область', 'enabled' => true],
                ['value' => 'spb', 'label' => 'Санкт-Петербург', 'enabled' => true],
                ['value' => 'syria', 'label' => 'Сирия', 'enabled' => true],
                ['value' => 'sochi', 'label' => 'Сочи', 'enabled' => true],
                ['value' => 'tazovsky', 'label' => 'Тазовский (Ямало-Ненецкий АО)', 'enabled' => true],
                ['value' => 'tver', 'label' => 'Тверь', 'enabled' => true],
                ['value' => 'tver_region', 'label' => 'Тверская обасть', 'enabled' => true],
                ['value' => 'tomsk', 'label' => 'Томск', 'enabled' => true],
                ['value' => 'turkey', 'label' => 'Турция', 'enabled' => true],
                ['value' => 'tyumen', 'label' => 'Тюмень', 'enabled' => true],
                ['value' => 'ulan_ude', 'label' => 'Улан-Удэ', 'enabled' => true],
                ['value' => 'ussuriysk', 'label' => 'Уссурийск', 'enabled' => true],
                ['value' => 'ust_ilimsk', 'label' => 'Усть-Илимск', 'enabled' => true],
                ['value' => 'ust_kut', 'label' => 'Усть-Кут', 'enabled' => true],
                ['value' => 'ust_luga', 'label' => 'Усть-Луга', 'enabled' => true],
                ['value' => 'ufa', 'label' => 'Уфа', 'enabled' => true],
                ['value' => 'khabarovsk', 'label' => 'Хабаровск', 'enabled' => true],
                ['value' => 'khmao_yugra', 'label' => 'ХМАО – Югра', 'enabled' => true],
                ['value' => 'cfd', 'label' => 'ЦФО (Центральный федеральный округ)', 'enabled' => true],
                ['value' => 'chechnya', 'label' => 'Чеченская Республика', 'enabled' => true],
                ['value' => 'chelyabinsk', 'label' => 'Челябинская область', 'enabled' => true],
                ['value' => 'chukotka', 'label' => 'Чукотский АО', 'enabled' => true],
                ['value' => 'shlisselburg', 'label' => 'Шлиссельбург', 'enabled' => true],
                ['value' => 'evenkia', 'label' => 'Эвенкия (Таймыр)', 'enabled' => true],
                ['value' => 'yakutia', 'label' => 'Якутия', 'enabled' => true],
                ['value' => 'yamal', 'label' => 'Ямало-Ненецкий АО', 'enabled' => true],
            ]
        ],
        'year' => [
            'enabled' => true,
            'label' => 'Год',
            'options' => [
                ['value' => '2025', 'label' => '2025', 'enabled' => true],
                ['value' => '2024', 'label' => '2024', 'enabled' => true],
                ['value' => '2023', 'label' => '2023', 'enabled' => true],
                ['value' => '2022', 'label' => '2022', 'enabled' => true],
                ['value' => '2021', 'label' => '2021', 'enabled' => true],
                ['value' => '2020', 'label' => '2020', 'enabled' => true],
                ['value' => '2019', 'label' => '2019', 'enabled' => true],
                ['value' => '2018', 'label' => '2018', 'enabled' => true],
                ['value' => '2017', 'label' => '2017', 'enabled' => true],
                ['value' => '2016', 'label' => '2016', 'enabled' => true],
                ['value' => '2015', 'label' => '2015', 'enabled' => true],
                ['value' => '2014', 'label' => '2014', 'enabled' => true],
            ]
        ],
    ];
    
    // Если ACF настройки есть, используем их
    if ($settings) {
        // Мощность
        if (isset($settings['filter_power_enabled'])) {
            $defaults['power']['enabled'] = (bool)$settings['filter_power_enabled'];
        }
        if (!empty($settings['power_ranges'])) {
            $defaults['power']['options'] = [];
            foreach ($settings['power_ranges'] as $range) {
                if (!empty($range['value']) && !empty($range['label'])) {
                    $defaults['power']['options'][] = [
                        'value' => $range['value'],
                        'label' => $range['label'],
                        'enabled' => isset($range['enabled']) ? (bool)$range['enabled'] : true,
                    ];
                }
            }
        }
        
        // Отрасль
        if (isset($settings['filter_industry_enabled'])) {
            $defaults['industry']['enabled'] = (bool)$settings['filter_industry_enabled'];
        }
        if (!empty($settings['industries'])) {
            $defaults['industry']['options'] = [];
            foreach ($settings['industries'] as $industry) {
                if (!empty($industry['value']) && !empty($industry['label'])) {
                    $defaults['industry']['options'][] = [
                        'value' => $industry['value'],
                        'label' => $industry['label'],
                        'enabled' => isset($industry['enabled']) ? (bool)$industry['enabled'] : true,
                    ];
                }
            }
        }
        
        // Город
        if (isset($settings['filter_city_enabled'])) {
            $defaults['city']['enabled'] = (bool)$settings['filter_city_enabled'];
        }
        if (!empty($settings['cities'])) {
            $defaults['city']['options'] = [];
            foreach ($settings['cities'] as $city) {
                if (!empty($city['value']) && !empty($city['label'])) {
                    $defaults['city']['options'][] = [
                        'value' => $city['value'],
                        'label' => $city['label'],
                        'enabled' => isset($city['enabled']) ? (bool)$city['enabled'] : true,
                    ];
                }
            }
        }
        
        // Год
        if (isset($settings['filter_year_enabled'])) {
            $defaults['year']['enabled'] = (bool)$settings['filter_year_enabled'];
        }
        if (!empty($settings['years'])) {
            $defaults['year']['options'] = [];
            foreach ($settings['years'] as $year) {
                if (!empty($year['value']) && !empty($year['label'])) {
                    $defaults['year']['options'][] = [
                        'value' => $year['value'],
                        'label' => $year['label'],
                        'enabled' => isset($year['enabled']) ? (bool)$year['enabled'] : true,
                    ];
                }
            }
        }
    }
    
    return $defaults;
}

/**
 * Получение похожих проектов
 * 
 * @param int $project_id ID текущего проекта
 * @param int $count Количество похожих проектов
 * @return WP_Query Объект запроса WordPress
 */
function dsa_get_related_projects($project_id, $count = 3) {
    // Получаем ACF поля текущего проекта
    $power_range = get_field('power_range', $project_id);
    $industry = get_field('industry', $project_id);
    $city = get_field('city', $project_id);
    
    // Формируем запрос
    $args = [
        'post_type' => 'project',
        'post__not_in' => [$project_id],
        'posts_per_page' => $count,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    // Создаем meta_query для поиска похожих проектов
    $meta_query = ['relation' => 'OR'];
    
    // По диапазону мощности
    if ($power_range) {
        $meta_query[] = [
            'key' => 'power_range',
            'value' => $power_range,
            'compare' => '=',
        ];
    }
    
    // По отрасли
    if ($industry) {
        $meta_query[] = [
            'key' => 'industry',
            'value' => $industry,
            'compare' => '=',
        ];
    }
    
    // По городу
    if ($city) {
        $meta_query[] = [
            'key' => 'city',
            'value' => $city,
            'compare' => '=',
        ];
    }
    
    if (count($meta_query) > 1) {
        $args['meta_query'] = $meta_query;
    }
    
    return new WP_Query($args);
} 

// ============================================
// WOOCOMMERCE INTEGRATION
// ============================================

/**
 * Поддержка WooCommerce в теме
 */
function dsa_add_woocommerce_support() {
    // Базовая поддержка WooCommerce
    add_theme_support('woocommerce');
    
    // Поддержка галереи товара
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'dsa_add_woocommerce_support');

/**
 * Отключение стандартных стилей WooCommerce
 * Используем собственные стили для полного контроля над дизайном
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Подключение кастомных стилей и скриптов WooCommerce
 */
function dsa_woocommerce_assets() {
    if (class_exists('WooCommerce')) {
        $theme_uri = get_template_directory_uri();
        $theme_dir = get_template_directory();
        
        // ============================================
        // КАТАЛОГ ТОВАРОВ (архив, категории, теги)
        // ============================================
        if (is_shop() || is_product_category() || is_product_tag()) {
            $catalog_view = dsa_get_catalog_view();
            
            // Зависимости каталога от базовых стилей
            $catalog_deps = array('dsa-pagination', 'dsa-buttons', 'dsa-utilities');
            
            if ($catalog_view === 'cards') {
                // Карточный вид
                $catalog_css = $theme_dir . '/assets/css/catalog-cards.css';
                if (file_exists($catalog_css)) {
                    wp_enqueue_style('dsa-catalog-cards', $theme_uri . '/assets/css/catalog-cards.css', $catalog_deps, filemtime($catalog_css));
                }
            } else {
                // Табличный вид (по умолчанию)
                $catalog_css = $theme_dir . '/assets/css/catalog-table.css';
                if (file_exists($catalog_css)) {
                    wp_enqueue_style('dsa-catalog-table', $theme_uri . '/assets/css/catalog-table.css', $catalog_deps, filemtime($catalog_css));
                }
            }
            
            // JS для каталога
            $catalog_js = $theme_dir . '/assets/js/woocommerce/wc-catalog.js';
            if (file_exists($catalog_js)) {
                wp_enqueue_script('dsa-wc-catalog', $theme_uri . '/assets/js/woocommerce/wc-catalog.js', array('jquery'), filemtime($catalog_js), true);
            }
        }
        
        // ============================================
        // СТРАНИЦА ТОВАРА
        // ============================================
        if (is_product()) {
            $product_css = $theme_dir . '/assets/css/product.css';
            if (file_exists($product_css)) {
                wp_enqueue_style('dsa-product', $theme_uri . '/assets/css/product.css', array(), filemtime($product_css));
            }
            
            $product_js = $theme_dir . '/assets/js/product.js';
            if (file_exists($product_js)) {
                wp_enqueue_script('dsa-product', $theme_uri . '/assets/js/product.js', array('jquery'), filemtime($product_js), true);
            }
            
            // Форма контакта (если используется на странице товара)
            $contact_form_css = $theme_dir . '/assets/css/contact-form.css';
            if (file_exists($contact_form_css)) {
                wp_enqueue_style('dsa-contact-form', $theme_uri . '/assets/css/contact-form.css', array(), filemtime($contact_form_css));
            }
        }
        
        // ============================================
        // КОРЗИНА И ОФОРМЛЕНИЕ ЗАКАЗА
        // ============================================
        if (is_cart() || is_checkout()) {
            $cart_checkout_css = $theme_dir . '/assets/css/woocommerce/wc-cart-checkout.css';
            if (file_exists($cart_checkout_css)) {
                wp_enqueue_style('dsa-wc-cart-checkout', $theme_uri . '/assets/css/woocommerce/wc-cart-checkout.css', array(), filemtime($cart_checkout_css));
            }
            
            $unified_checkout_js = $theme_dir . '/assets/js/woocommerce/wc-unified-checkout.js';
            if (file_exists($unified_checkout_js)) {
                wp_enqueue_script('dsa-wc-unified-checkout', $theme_uri . '/assets/js/woocommerce/wc-unified-checkout.js', array('jquery'), filemtime($unified_checkout_js), true);
            }
        }
        
        // ============================================
        // МОЙ АККАУНТ
        // ============================================
        if (is_account_page()) {
            $account_css = $theme_dir . '/assets/css/woocommerce/wc-account.css';
            if (file_exists($account_css)) {
                wp_enqueue_style('dsa-wc-account', $theme_uri . '/assets/css/woocommerce/wc-account.css', array(), filemtime($account_css));
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'dsa_woocommerce_assets', 20);

/**
 * Настройка базовых параметров WooCommerce
 */
function dsa_woocommerce_setup() {
    // Количество товаров на странице каталога
    add_filter('loop_shop_per_page', function() {
        // Разрешенные значения
        $allowed = array(50, 100, 200, 500);
        $default = 100;
        
        // 1. Проверяем GET параметр
        if (isset($_GET['per_page']) && in_array((int)$_GET['per_page'], $allowed)) {
            $per_page = (int)$_GET['per_page'];
            // Сохраняем в cookie
            setcookie('catalog_per_page', $per_page, time() + (30 * 24 * 60 * 60), '/');
            return $per_page;
        }
        
        // 2. Проверяем Cookie
        if (isset($_COOKIE['catalog_per_page']) && in_array((int)$_COOKIE['catalog_per_page'], $allowed)) {
            return (int)$_COOKIE['catalog_per_page'];
        }
        
        // 3. По умолчанию 100
        return $default;
    });
    
    // Количество связанных товаров
    add_filter('woocommerce_output_related_products_args', function($args) {
        $args['posts_per_page'] = 4;
        $args['columns'] = 4;
        return $args;
    });
}
add_action('init', 'dsa_woocommerce_setup');

/**
 * Кастомная пагинация WooCommerce с нашими стилями
 */
function dsa_woocommerce_pagination() {
    if (!wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
        return;
    }

    $total   = wc_get_loop_prop('total_pages');
    $current = wc_get_loop_prop('current_page');

    if ($total <= 1) {
        return;
    }

    // Сохраняем параметр view в пагинации
    $view = dsa_get_catalog_view();
    
    // Функция для генерации URL страницы
    $get_page_link = function($page) use ($view) {
        if (is_shop()) {
            $link = get_permalink(wc_get_page_id('shop'));
        } elseif (is_product_category()) {
            $link = get_term_link(get_queried_object());
        } elseif (is_product_tag()) {
            $link = get_term_link(get_queried_object());
        } else {
            $link = get_permalink();
        }
        
        // Добавляем номер страницы
        if ($page > 1) {
            $link = trailingslashit($link) . 'page/' . $page . '/';
        }
        
        // Добавляем параметр view
        $link = add_query_arg('view', $view, $link);
        
        return $link;
    };
    
    echo '<div class="pagination">';
    
    // Блок "Выводить по"
    echo '<div class="pagination__per-page">';
    echo '<span class="pagination__per-page-label">Выводить по:</span>';
    echo '<div class="pagination__per-page-buttons">';
    $per_page_options = array(50, 100, 200, 500);
    $current_per_page = wc_get_loop_prop('per_page');
    foreach ($per_page_options as $option) {
        $active_class = ($option == $current_per_page) ? ' pagination__per-page-btn_active' : '';
        echo '<button class="pagination__per-page-btn' . $active_class . '" type="button" data-per-page="' . $option . '">' . $option . '</button>';
    }
    echo '</div>';
    echo '</div>';
    
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

// Заменяем стандартную пагинацию WooCommerce на нашу
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action('woocommerce_after_shop_loop', 'dsa_woocommerce_pagination', 10);

// Отключаем стандартную сортировку и счетчик результатов (используем кастомную в catalog-filters.php)
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

/**
 * Хлебные крошки WooCommerce - использовать нашу функцию
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Обертка контента WooCommerce
 */
function dsa_woocommerce_wrapper_start() {
    echo '<div class="main-content">';
    echo '<div class="container">';
}
add_action('woocommerce_before_main_content', 'dsa_woocommerce_wrapper_start', 10);

function dsa_woocommerce_wrapper_end() {
    echo '</div>'; // container
    echo '</div>'; // main-content
}
add_action('woocommerce_after_main_content', 'dsa_woocommerce_wrapper_end', 10);

// ============================================
// WOOCOMMERCE CATALOG FUNCTIONS
// ============================================

/**
 * Определение текущего вида каталога (табличный или карточный)
 * Использует GET параметр и Cookie для сохранения выбора
 * 
 * @return string 'list' или 'cards'
 */
function dsa_get_catalog_view() {
    // 1. Проверить GET параметр
    if (isset($_GET['view']) && in_array($_GET['view'], ['list', 'cards'])) {
        $view = sanitize_text_field($_GET['view']);
        // Сохранить в cookie на 30 дней
        setcookie('catalog_view', $view, time() + (86400 * 30), '/');
        return $view;
    }
    
    // 2. Проверить Cookie
    if (isset($_COOKIE['catalog_view']) && in_array($_COOKIE['catalog_view'], ['list', 'cards'])) {
        return sanitize_text_field($_COOKIE['catalog_view']);
    }
    
    // 3. Дефолтный вид - табличный
    return 'list';
}

/**
 * Получение диапазонов мощности для группировки товаров
 * 
 * @return array Ассоциативный массив диапазонов
 */
function dsa_get_power_ranges() {
    return [
        '16-40' => ['name' => '16-40 кВт', 'min' => 16, 'max' => 40],
        '40-100' => ['name' => '40-100 кВт', 'min' => 40, 'max' => 100],
        '100-200' => ['name' => '100-200 кВт', 'min' => 100, 'max' => 200],
        '200-500' => ['name' => '200-500 кВт', 'min' => 200, 'max' => 500],
        '500-1000' => ['name' => '500-1000 кВт', 'min' => 500, 'max' => 1000],
        '1000-2000' => ['name' => '1000-2000 кВт', 'min' => 1000, 'max' => 2000],
        '2000-3000' => ['name' => '2000-3000 кВт', 'min' => 2000, 'max' => 3000],
    ];
}

/**
 * Получение мощности товара из ACF поля
 * 
 * @param WC_Product $product Объект товара
 * @return int Мощность в кВт
 */
function dsa_get_product_power($product) {
    $power = get_field('power', $product->get_id());
    return $power ? intval($power) : 0;
}

/**
 * Определение группы мощности для товара
 * 
 * @param int $power Мощность в кВт
 * @return string|null Ключ группы или null
 */
function dsa_determine_power_group($power) {
    $ranges = dsa_get_power_ranges();
    
    foreach ($ranges as $key => $range) {
        if ($power >= $range['min'] && $power < $range['max']) {
            return $key;
        }
    }
    
    return null;
}

/**
 * Вывод заголовков таблицы для табличного вида
 */
function dsa_catalog_table_header() {
    ?>
    <div class="catalog-table-header">
        <div class="catalog-table-header__col catalog-table-header__col_image"></div>
        <div class="catalog-table-header__col catalog-table-header__col_name">Название модели</div>
        <div class="catalog-table-header__col catalog-table-header__col_engine">Двигатель</div>
        <div class="catalog-table-header__col catalog-table-header__col_power">Мощность</div>
        <div class="catalog-table-header__col catalog-table-header__col_country">Страна сборки</div>
        <div class="catalog-table-header__col catalog-table-header__col_price">Цена</div>
    </div>
    <?php
}

/**
 * Вывод товара в табличном виде
 * 
 * @param WC_Product $product Объект товара
 */
function dsa_render_catalog_product_list($product) {
    // Получение данных товара
    $product_id = $product->get_id();
    $title = $product->get_name();
    $permalink = $product->get_permalink();
    $image = $product->get_image('medium');
    $price = $product->get_price_html();
    
    // ACF поля
    $engine = get_field('engine', $product_id) ?: '—';
    $power = get_field('power', $product_id) ?: '—';
    $nominal_power = get_field('nominal_power', $product_id) ?: '';
    $country = get_field('country', $product_id) ?: '—';
    
    // Формат мощности
    $power_display = $power !== '—' ? $power . ' кВт' : '—';
    if ($nominal_power) {
        $power_display .= ' (' . $nominal_power . ' кВА)';
    }
    ?>
    <div class="catalog-product">
        <div class="catalog-product__image">
            <a href="<?php echo esc_url($permalink); ?>">
                <?php echo $image; ?>
            </a>
        </div>
        <div class="catalog-product__name">
            <h3 class="catalog-product__title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>
        </div>
        <div class="catalog-product__engine">
            <span class="catalog-product__engine-text"><?php echo esc_html($engine); ?></span>
        </div>
        <div class="catalog-product__power">
            <span class="catalog-product__power-text"><?php echo esc_html($power_display); ?></span>
        </div>
        <div class="catalog-product__country">
            <span class="catalog-product__country-text"><?php echo esc_html($country); ?></span>
        </div>
        <div class="catalog-product__price">
            <?php echo $price; ?>
        </div>
    </div>
    <?php
}

/**
 * Вывод товара в карточном виде
 * 
 * @param WC_Product $product Объект товара
 */
function dsa_render_catalog_product_cards($product) {
    // Получение данных товара
    $product_id = $product->get_id();
    $title = $product->get_name();
    $permalink = $product->get_permalink();
    $image = $product->get_image('medium', [ 'class' => 'catalog-product__img' ]);
    $price = $product->get_price_html();
    
    // ACF поля
    $engine = get_field('engine', $product_id) ?: '—';
    $power = get_field('power', $product_id) ?: '—';
    $nominal_power = get_field('nominal_power', $product_id) ?: '';
    $country = get_field('country', $product_id) ?: '—';
    
    // Формат мощности
    $power_display = $power !== '—' ? $power . ' кВт' : '—';
    if ($nominal_power) {
        $power_display .= ' (' . $nominal_power . ' кВА)';
    }
    ?>
    <div class="catalog-product">
        <div class="catalog-product__image">
            <a href="<?php echo esc_url($permalink); ?>" class="catalog-product__image-link">
                <?php echo $image; ?>
            </a>
        </div>
        <div class="catalog-product__content">
            <div class="catalog-product__header">
                <h3 class="catalog-product__title">
                    <a href="<?php echo esc_url($permalink); ?>" class="catalog-product__title-link">
                        <?php echo esc_html($title); ?>
                    </a>
                </h3>
                <div class="catalog-product__price">
                    <?php echo $price; ?>
                </div>
            </div>
            <div class="catalog-product__specs">
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-cog catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Двигатель:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($engine); ?></span>
                </div>
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-bolt catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Мощность:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($power_display); ?></span>
                </div>
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-flag catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Страна:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($country); ?></span>
                </div>
            </div>
            <div class="catalog-product__actions">
                <button class="catalog-product__btn catalog-product__btn_primary" 
                        type="button"
                        data-product-id="<?php echo esc_attr($product_id); ?>">
                    <i class="fa-solid fa-cart-plus"></i>
                    <span>В корзину</span>
                </button>
                <button class="catalog-product__btn catalog-product__btn_secondary" 
                        type="button"
                        aria-label="Добавить в избранное">
                    <i class="fa-solid fa-heart"></i>
                </button>
                <button class="catalog-product__btn catalog-product__btn_secondary" 
                        type="button"
                        aria-label="Добавить к сравнению">
                    <i class="fa-solid fa-chart-line"></i>
                </button>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Основная функция вывода каталога с группировкой по мощности
 * 
 * @param string $view Вид отображения ('list' или 'cards')
 */
function dsa_render_grouped_catalog_products($view = 'list') {
    global $wp_query;
    
    if (!$wp_query->have_posts()) {
        echo '<p class="woocommerce-info">Товары не найдены.</p>';
        return;
    }
    
    // Получаем все товары из текущего запроса
    $products = [];
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        $product = wc_get_product(get_the_ID());
        if ($product) {
            $products[] = $product;
        }
    }
    wp_reset_postdata();
    
    // Группируем товары по мощности
    $grouped_products = [];
    $ranges = dsa_get_power_ranges();
    
    // Инициализация групп
    foreach ($ranges as $key => $range) {
        $grouped_products[$key] = [
            'name' => 'Группа мощности ' . $range['name'],
            'products' => []
        ];
    }
    
    // Распределение товаров по группам
    foreach ($products as $product) {
        $power = dsa_get_product_power($product);
        $group_key = dsa_determine_power_group($power);
        
        if ($group_key && isset($grouped_products[$group_key])) {
            $grouped_products[$group_key]['products'][] = $product;
        }
    }
    
    // Вывод групп с товарами
    foreach ($grouped_products as $group_key => $group_data) {
        // Пропускаем пустые группы
        if (empty($group_data['products'])) {
            continue;
        }
        
        echo '<div class="catalog-group">';
        echo '<h2 class="catalog-group__title">' . esc_html($group_data['name']) . '</h2>';
        
        // Класс контейнера зависит от вида
        $products_class = $view === 'cards' ? 'catalog-products catalog-products_view_cards' : 'catalog-products';
        echo '<div class="' . esc_attr($products_class) . '">';
        
        // Вывод товаров
        foreach ($group_data['products'] as $product) {
            if ($view === 'cards') {
                dsa_render_catalog_product_cards($product);
            } else {
                dsa_render_catalog_product_list($product);
            }
        }
        
        echo '</div>'; // .catalog-products
        echo '</div>'; // .catalog-group
    }
}

// ============================================
// WOOCOMMERCE AJAX HANDLERS
// ============================================

/**
 * AJAX handler для получения количества товаров в корзине
 */
function dsa_get_cart_count() {
    if (class_exists('WooCommerce')) {
        $count = WC()->cart->get_cart_contents_count();
        wp_send_json(['count' => $count]);
    } else {
        wp_send_json(['count' => 0]);
    }
}
add_action('wp_ajax_get_cart_count', 'dsa_get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'dsa_get_cart_count');

/**
 * Обработка добавления товара в корзину через AJAX
 */
function dsa_add_to_cart_handler() {
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(['message' => 'Product ID is required']);
        return;
    }

    $product_id = absint($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;

    if (class_exists('WooCommerce')) {
        $result = WC()->cart->add_to_cart($product_id, $quantity);
        
        if ($result) {
            $cart_count = WC()->cart->get_cart_contents_count();
            wp_send_json_success([
                'message' => 'Product added to cart',
                'cart_count' => $cart_count,
                'cart_hash' => WC()->cart->get_cart_hash()
            ]);
        } else {
            wp_send_json_error(['message' => 'Failed to add product to cart']);
        }
    } else {
        wp_send_json_error(['message' => 'WooCommerce is not active']);
    }
}
add_action('wp_ajax_woocommerce_add_to_cart', 'dsa_add_to_cart_handler');
add_action('wp_ajax_nopriv_woocommerce_add_to_cart', 'dsa_add_to_cart_handler');

// ============================================
// UNIFIED CART & CHECKOUT
// ============================================

/**
 * Перенаправление стандартной страницы корзины на unified checkout
 */
function dsa_redirect_cart_to_unified() {
    if (is_cart() && !is_checkout()) {
        // Получаем URL страницы unified checkout
        // Можно создать страницу с шаблоном "Unified Cart & Checkout"
        // или использовать кастомный endpoint
        wp_safe_redirect(wc_get_checkout_url());
        exit;
    }
}
add_action('template_redirect', 'dsa_redirect_cart_to_unified', 10);

/**
 * Настройка способов оплаты
 */
function dsa_setup_payment_gateways() {
    // По умолчанию WooCommerce предоставляет:
    // - COD (Cash on Delivery / Оплата при получении)
    // - BACS (Bank Transfer / Банковский перевод)
    // - Cheque (Check Payment / Чек)
    
    // Настройки уже доступны через админку WooCommerce
    // WooCommerce → Настройки → Платежи
}

/**
 * Настройка способов доставки
 */
function dsa_setup_shipping_methods() {
    // WooCommerce предоставляет стандартные методы:
    // - Flat Rate (Фиксированная ставка)
    // - Free Shipping (Бесплатная доставка)
    // - Local Pickup (Самовывоз)
    
    // Кастомные зоны доставки настраиваются через админку:
    // WooCommerce → Настройки → Доставка
}

/**
 * Добавление кастомного класса к body для unified checkout
 */
function dsa_unified_checkout_body_class($classes) {
    if (is_checkout() && !is_wc_endpoint_url('order-received')) {
        $classes[] = 'unified-checkout-page';
    }
    return $classes;
}
add_filter('body_class', 'dsa_unified_checkout_body_class');

/**
 * Изменение количества колонок для связанных товаров
 */
function dsa_related_products_columns() {
    return 4; // 4 товара в ряд
}
add_filter('woocommerce_related_products_columns', 'dsa_related_products_columns');

/**
 * Отключение стандартного поля купона в чекауте
 * (мы выводим его в cart-totals.php)
 */
function dsa_remove_checkout_coupon_form() {
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
}
add_action('woocommerce_before_checkout_form', 'dsa_remove_checkout_coupon_form', 9);

/**
 * Локализация текстов для JavaScript
 */
function dsa_wc_localize_scripts() {
    if (is_checkout()) {
        wp_localize_script('dsa-wc-wc-unified-checkout', 'dsaWCData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'cartUrl' => wc_get_cart_url(),
            'checkoutUrl' => wc_get_checkout_url(),
            'nonce' => wp_create_nonce('dsa_wc_nonce'),
            'strings' => array(
                'updating' => __('Обновление корзины...', 'dsa-generators'),
                'processing' => __('Обработка заказа...', 'dsa-generators'),
                'error' => __('Произошла ошибка. Попробуйте снова.', 'dsa-generators'),
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'dsa_wc_localize_scripts', 25);

/**
 * ========================================
 * ADMIN: СОЗДАНИЕ ТЕСТОВЫХ ТОВАРОВ
 * ========================================
 */

// Добавление пункта меню в админке
add_action('admin_menu', 'dsa_add_test_products_menu');
function dsa_add_test_products_menu() {
    add_submenu_page(
        'tools.php',
        'Создать тестовые товары',
        'Тестовые товары',
        'manage_options',
        'dsa-create-test-products',
        'dsa_create_test_products_page'
    );
}

// Страница создания тестовых товаров
function dsa_create_test_products_page() {
    // Проверка прав
    if (!current_user_can('manage_options')) {
        wp_die('Недостаточно прав доступа');
    }
    
    // Проверка WooCommerce
    if (!class_exists('WooCommerce')) {
        echo '<div class="notice notice-error"><p>❌ WooCommerce не установлен!</p></div>';
        return;
    }
    
    // Проверка ACF
    if (!function_exists('get_field')) {
        echo '<div class="notice notice-error"><p>❌ ACF Pro не установлен!</p></div>';
        return;
    }
    
    ?>
    <div class="wrap">
        <h1>🛠️ Создание тестовых товаров WooCommerce</h1>
        
        <?php
        // Обработка создания товаров
        if (isset($_POST['create_products']) && check_admin_referer('dsa_create_products')) {
            $result = dsa_create_test_products();
            
            if ($result['success']) {
                echo '<div class="notice notice-success"><p>✅ Создано товаров: <strong>' . $result['created'] . '</strong></p></div>';
                
                if ($result['errors'] > 0) {
                    echo '<div class="notice notice-warning"><p>⚠️ Ошибок: ' . $result['errors'] . '</p></div>';
                }
                
                // Список созданных товаров
                if (!empty($result['products'])) {
                    echo '<h2>📦 Созданные товары:</h2>';
                    echo '<table class="wp-list-table widefat fixed striped">';
                    echo '<thead><tr><th>№</th><th>Название</th><th>Мощность</th><th>Цена</th><th>ID</th><th>Действия</th></tr></thead>';
                    echo '<tbody>';
                    foreach ($result['products'] as $i => $product) {
                        echo '<tr>';
                        echo '<td>' . ($i + 1) . '</td>';
                        echo '<td><strong>' . esc_html($product['name']) . '</strong></td>';
                        echo '<td>' . $product['power'] . ' кВт</td>';
                        echo '<td>' . number_format($product['price'], 0, '.', ' ') . ' ₽</td>';
                        echo '<td>' . $product['id'] . '</td>';
                        echo '<td>';
                        echo '<a href="' . get_edit_post_link($product['id']) . '" class="button button-small">Редактировать</a> ';
                        echo '<a href="' . get_permalink($product['id']) . '" class="button button-small" target="_blank">Просмотр</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                }
                
                echo '<hr>';
                echo '<h3>🎯 Следующие шаги:</h3>';
                echo '<ul>';
                echo '<li>✅ Товары созданы и опубликованы</li>';
                echo '<li>📦 <a href="' . admin_url('edit.php?post_type=product') . '">Перейти к списку товаров</a></li>';
                echo '<li>🛒 <a href="' . home_url('/shop/') . '" target="_blank">Открыть каталог на фронтенде</a></li>';
                echo '<li>📝 Используйте <code>WOOCOMMERCE_TESTING_GUIDE.md</code> для тестирования</li>';
                echo '</ul>';
            } else {
                echo '<div class="notice notice-error"><p>❌ Ошибка при создании товаров</p></div>';
            }
        }
        ?>
        
        <div class="card" style="max-width: 800px;">
            <h2>📋 Что будет создано</h2>
            <p>Этот инструмент создаст <strong>15 тестовых товаров WooCommerce</strong> с полным заполнением всех <strong>24 ACF полей</strong>.</p>
            
            <h3>Список товаров:</h3>
            <table class="wp-list-table widefat" style="max-width: 100%;">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Название</th>
                        <th>Мощность</th>
                        <th>Группа</th>
                        <th>Цена</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>DSA DG-10 Kubota</td><td>10 кВт</td><td>До 16 кВт</td><td>850 000 ₽</td></tr>
                    <tr><td>2</td><td>DSA DG-16 Cummins</td><td>16 кВт</td><td>16-40 кВт</td><td>1 040 643 ₽</td></tr>
                    <tr><td>3</td><td>DSA DG-20 Perkins</td><td>20 кВт</td><td>16-40 кВт</td><td>1 200 000 ₽</td></tr>
                    <tr><td>4</td><td>DSA DG-30 Doosan</td><td>30 кВт</td><td>16-40 кВт</td><td>1 450 000 ₽</td></tr>
                    <tr><td>5</td><td>DSA DG-50 Perkins</td><td>50 кВт</td><td>40-100 кВт</td><td>1 850 000 ₽</td></tr>
                    <tr><td>6</td><td>DSA DG-80 Cummins</td><td>80 кВт</td><td>40-100 кВт</td><td>2 400 000 ₽</td></tr>
                    <tr><td>7</td><td>DSA DG-100 MTU</td><td>100 кВт</td><td>100-200 кВт</td><td>3 200 000 ₽</td></tr>
                    <tr><td>8</td><td>DSA DG-150 Perkins</td><td>150 кВт</td><td>100-200 кВт</td><td>4 500 000 ₽</td></tr>
                    <tr><td>9</td><td>DSA DG-200 Caterpillar</td><td>200 кВт</td><td>200-500 кВт</td><td>6 000 000 ₽</td></tr>
                    <tr><td>10</td><td>DSA DG-300 MAN</td><td>300 кВт</td><td>200-500 кВт</td><td>8 500 000 ₽</td></tr>
                    <tr><td>11</td><td>DSA DG-500 MTU</td><td>500 кВт</td><td>500-1000 кВт</td><td>12 000 000 ₽</td></tr>
                    <tr><td>12</td><td>DSA DG-800 Caterpillar</td><td>800 кВт</td><td>500-1000 кВт</td><td>18 000 000 ₽</td></tr>
                    <tr><td>13</td><td>DSA DG-1000 MTU</td><td>1000 кВт</td><td>1000-2000 кВт</td><td>25 000 000 ₽</td></tr>
                    <tr><td>14</td><td>DSA DG-1500 MAN</td><td>1500 кВт</td><td>1000-2000 кВт</td><td>35 000 000 ₽</td></tr>
                    <tr><td>15</td><td>DSA DG-2000 Caterpillar</td><td>2000 кВт</td><td>1000-2000 кВт</td><td>50 000 000 ₽</td></tr>
                </tbody>
            </table>
            
            <hr>
            
            <h3>✅ Что заполняется автоматически:</h3>
            <ul>
                <li><strong>WooCommerce поля:</strong> название, цена, описание, краткое описание</li>
                <li><strong>24 ACF поля:</strong> все характеристики (мощность, двигатель, топливо, электрика, габариты и т.д.)</li>
                <li><strong>Статус:</strong> Опубликован</li>
            </ul>
            
            <hr>
            
            <form method="post" style="margin-top: 20px;">
                <?php wp_nonce_field('dsa_create_products'); ?>
                <p>
                    <button type="submit" name="create_products" class="button button-primary button-hero">
                        🚀 Создать 15 тестовых товаров
                    </button>
                </p>
                <p class="description">
                    ⚠️ <strong>Внимание:</strong> Это создаст 15 новых товаров в вашем магазине. 
                    Убедитесь, что ACF поля импортированы из <code>acf-exports/group_product-fields.json</code>.
                </p>
            </form>
        </div>
    </div>
    <?php
}

// Функция создания тестовых товаров
function dsa_create_test_products() {
    // Массив тестовых товаров
    $test_products = [
        ['name' => 'DSA DG-10 Kubota', 'power' => 10, 'price' => 850000, 'nominal_power' => 12.5, 'max_power' => 11, 'engine' => 'Kubota D1105-BG', 'engine_manufacturer' => 'Kubota', 'engine_volume' => 1.123, 'country_engine' => 'Япония', 'oil_volume' => 4.5, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 50, 'fuel_consumption' => 2.5, 'generator_model_1' => 'Stamford UCI224C', 'generator_model_2' => 'Mecc Alte ECP28-2L', 'dimensions' => '1500×700×1200', 'weight' => 450, 'country' => 'Россия', 'start_type' => 'Электрический', 'noise_level' => 68, 'warranty' => '12 месяцев'],
        ['name' => 'DSA DG-16 Cummins (в кожухе)', 'power' => 16, 'price' => 1040643, 'nominal_power' => 20, 'max_power' => 17.6, 'engine' => 'Cummins 4B3.9G11', 'engine_manufacturer' => 'Cummins', 'engine_volume' => 3.9, 'country_engine' => 'США', 'oil_volume' => 10, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 100, 'fuel_consumption' => 4.2, 'generator_model_1' => 'Stamford UCI274C', 'generator_model_2' => 'Mecc Alte ECP32-1S', 'dimensions' => '2200×900×1500', 'weight' => 850, 'country' => 'Россия', 'start_type' => 'Электрический', 'noise_level' => 70, 'warranty' => '12 месяцев'],
        ['name' => 'DSA DG-20 Perkins', 'power' => 20, 'price' => 1200000, 'nominal_power' => 25, 'max_power' => 22, 'engine' => 'Perkins 403A-15G1', 'engine_manufacturer' => 'Perkins', 'engine_volume' => 1.5, 'country_engine' => 'Великобритания', 'oil_volume' => 6.5, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 120, 'fuel_consumption' => 5.0, 'generator_model_1' => 'Stamford UCI274D', 'generator_model_2' => 'Mecc Alte ECP32-3S', 'dimensions' => '2400×1000×1600', 'weight' => 950, 'country' => 'Россия', 'start_type' => 'Электрический', 'noise_level' => 72, 'warranty' => '12 месяцев'],
        ['name' => 'DSA DG-30 Doosan', 'power' => 30, 'price' => 1450000, 'nominal_power' => 37.5, 'max_power' => 33, 'engine' => 'Doosan P086TI', 'engine_manufacturer' => 'Doosan', 'engine_volume' => 3.4, 'country_engine' => 'Корея', 'oil_volume' => 12, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 150, 'fuel_consumption' => 7.5, 'generator_model_1' => 'Stamford UCI274E', 'generator_model_2' => 'Mecc Alte ECP34-2S', 'dimensions' => '2600×1100×1700', 'weight' => 1200, 'country' => 'Россия', 'start_type' => 'Электрический', 'noise_level' => 73, 'warranty' => '18 месяцев'],
        ['name' => 'DSA DG-50 Perkins (открытое исполнение)', 'power' => 50, 'price' => 1850000, 'nominal_power' => 63, 'max_power' => 55, 'engine' => 'Perkins 1104C-44TAG2', 'engine_manufacturer' => 'Perkins', 'engine_volume' => 4.4, 'country_engine' => 'Великобритания', 'oil_volume' => 15, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 200, 'fuel_consumption' => 12.5, 'generator_model_1' => 'Stamford UCI274F', 'generator_model_2' => 'Mecc Alte ECP34-3S', 'dimensions' => '2800×1200×1800', 'weight' => 1600, 'country' => 'Россия', 'start_type' => 'Автоматический', 'noise_level' => 75, 'warranty' => '18 месяцев'],
        ['name' => 'DSA DG-80 Cummins', 'power' => 80, 'price' => 2400000, 'nominal_power' => 100, 'max_power' => 88, 'engine' => 'Cummins 6BT5.9-G2', 'engine_manufacturer' => 'Cummins', 'engine_volume' => 5.9, 'country_engine' => 'США', 'oil_volume' => 18, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 300, 'fuel_consumption' => 20, 'generator_model_1' => 'Stamford UCI274G', 'generator_model_2' => 'Mecc Alte ECP38-1S', 'dimensions' => '3000×1300×1900', 'weight' => 2200, 'country' => 'Россия', 'start_type' => 'Автоматический', 'noise_level' => 76, 'warranty' => '24 месяца'],
        ['name' => 'DSA DG-100 MTU', 'power' => 100, 'price' => 3200000, 'nominal_power' => 125, 'max_power' => 110, 'engine' => 'MTU 6R 0183 TC21', 'engine_manufacturer' => 'MTU', 'engine_volume' => 12.8, 'country_engine' => 'Германия', 'oil_volume' => 45, 'cylinder_config' => 'V-образный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 500, 'fuel_consumption' => 25, 'generator_model_1' => 'Stamford UCI274E', 'generator_model_2' => 'Mecc Alte ECO40-3S', 'dimensions' => '3500×1500×2200', 'weight' => 4500, 'country' => 'Германия', 'start_type' => 'Автоматический', 'noise_level' => 75, 'warranty' => '24 месяца'],
        ['name' => 'DSA DG-150 Perkins', 'power' => 150, 'price' => 4500000, 'nominal_power' => 187.5, 'max_power' => 165, 'engine' => 'Perkins 1106A-70TAG4', 'engine_manufacturer' => 'Perkins', 'engine_volume' => 7.0, 'country_engine' => 'Великобритания', 'oil_volume' => 25, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 600, 'fuel_consumption' => 35, 'generator_model_1' => 'Stamford HCI444D', 'generator_model_2' => 'Mecc Alte ECO43-1S', 'dimensions' => '3800×1600×2300', 'weight' => 5200, 'country' => 'Великобритания', 'start_type' => 'Автоматический', 'noise_level' => 77, 'warranty' => '24 месяца'],
        ['name' => 'DSA DG-200 Caterpillar', 'power' => 200, 'price' => 6000000, 'nominal_power' => 250, 'max_power' => 220, 'engine' => 'Caterpillar C9', 'engine_manufacturer' => 'Caterpillar', 'engine_volume' => 8.8, 'country_engine' => 'США', 'oil_volume' => 35, 'cylinder_config' => 'Рядный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 800, 'fuel_consumption' => 50, 'generator_model_1' => 'Stamford HCI544C', 'generator_model_2' => 'Mecc Alte ECO46-2S', 'dimensions' => '4200×1800×2500', 'weight' => 6500, 'country' => 'США', 'start_type' => 'Автоматический', 'noise_level' => 78, 'warranty' => '36 месяцев'],
        ['name' => 'DSA DG-300 MAN', 'power' => 300, 'price' => 8500000, 'nominal_power' => 375, 'max_power' => 330, 'engine' => 'MAN D2842LE223', 'engine_manufacturer' => 'MAN', 'engine_volume' => 12.4, 'country_engine' => 'Германия', 'oil_volume' => 50, 'cylinder_config' => 'V-образный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 1000, 'fuel_consumption' => 75, 'generator_model_1' => 'Stamford HCI634E', 'generator_model_2' => 'Mecc Alte ECO50-3S', 'dimensions' => '4800×2000×2700', 'weight' => 8500, 'country' => 'Германия', 'start_type' => 'Автоматический', 'noise_level' => 80, 'warranty' => '36 месяцев'],
        ['name' => 'DSA DG-500 MTU', 'power' => 500, 'price' => 12000000, 'nominal_power' => 625, 'max_power' => 550, 'engine' => 'MTU 12V 2000 G25', 'engine_manufacturer' => 'MTU', 'engine_volume' => 24.0, 'country_engine' => 'Германия', 'oil_volume' => 85, 'cylinder_config' => 'V-образный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 1500, 'fuel_consumption' => 125, 'generator_model_1' => 'Stamford PI734G', 'generator_model_2' => 'Mecc Alte ECO55-1L', 'dimensions' => '5500×2200×3000', 'weight' => 12000, 'country' => 'Германия', 'start_type' => 'Автоматический', 'noise_level' => 82, 'warranty' => '36 месяцев'],
        ['name' => 'DSA DG-800 Caterpillar', 'power' => 800, 'price' => 18000000, 'nominal_power' => 1000, 'max_power' => 880, 'engine' => 'Caterpillar C27', 'engine_manufacturer' => 'Caterpillar', 'engine_volume' => 27.0, 'country_engine' => 'США', 'oil_volume' => 110, 'cylinder_config' => 'V-образный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 2000, 'fuel_consumption' => 200, 'generator_model_1' => 'Stamford PI844G', 'generator_model_2' => 'Mecc Alte ECO58-3L', 'dimensions' => '6000×2500×3200', 'weight' => 16000, 'country' => 'США', 'start_type' => 'Автоматический', 'noise_level' => 85, 'warranty' => '48 месяцев'],
        ['name' => 'DSA DG-1000 MTU', 'power' => 1000, 'price' => 25000000, 'nominal_power' => 1250, 'max_power' => 1100, 'engine' => 'MTU 16V 2000 G85', 'engine_manufacturer' => 'MTU', 'engine_volume' => 32.0, 'country_engine' => 'Германия', 'oil_volume' => 150, 'cylinder_config' => 'V-образный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 3000, 'fuel_consumption' => 250, 'generator_model_1' => 'Stamford PI944H', 'generator_model_2' => 'Mecc Alte ECO65-3L', 'dimensions' => '7000×3000×3500', 'weight' => 22000, 'country' => 'Германия', 'start_type' => 'Автоматический', 'noise_level' => 87, 'warranty' => '48 месяцев'],
        ['name' => 'DSA DG-1500 MAN', 'power' => 1500, 'price' => 35000000, 'nominal_power' => 1875, 'max_power' => 1650, 'engine' => 'MAN 18V32/40', 'engine_manufacturer' => 'MAN', 'engine_volume' => 40.0, 'country_engine' => 'Германия', 'oil_volume' => 200, 'cylinder_config' => 'V-образный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 4000, 'fuel_consumption' => 375, 'generator_model_1' => 'Stamford HCI1444J', 'generator_model_2' => 'Mecc Alte ECO70-3L', 'dimensions' => '8000×3200×4000', 'weight' => 30000, 'country' => 'Германия', 'start_type' => 'Автоматический', 'noise_level' => 90, 'warranty' => '60 месяцев'],
        ['name' => 'DSA DG-2000 Caterpillar', 'power' => 2000, 'price' => 50000000, 'nominal_power' => 2500, 'max_power' => 2200, 'engine' => 'Caterpillar 3516B', 'engine_manufacturer' => 'Caterpillar', 'engine_volume' => 69.0, 'country_engine' => 'США', 'oil_volume' => 280, 'cylinder_config' => 'V-образный', 'cooling_type' => 'liquid', 'rotation_speed' => 1500, 'voltage' => 400, 'frequency' => '50 Гц', 'phases' => '3-фазная', 'fuel_tank_volume' => 5000, 'fuel_consumption' => 500, 'generator_model_1' => 'Stamford HCI1644K', 'generator_model_2' => 'Mecc Alte ECO75-3L', 'dimensions' => '9000×3500×4500', 'weight' => 45000, 'country' => 'США', 'start_type' => 'Автоматический', 'noise_level' => 92, 'warranty' => '60 месяцев'],
    ];
    
    $created = 0;
    $errors = 0;
    $products = [];
    
    foreach ($test_products as $product_data) {
        try {
            $product = new WC_Product_Simple();
            $product->set_name($product_data['name']);
            $product->set_status('publish');
            $product->set_catalog_visibility('visible');
            $product->set_regular_price($product_data['price']);
            $product->set_manage_stock(false);
            
            $description = sprintf(
                'Дизельная электростанция %s мощностью %d кВт с двигателем %s. Надежное и экономичное решение для резервного и постоянного электроснабжения.',
                $product_data['name'],
                $product_data['power'],
                $product_data['engine_manufacturer']
            );
            $product->set_description($description);
            $product->set_short_description(
                sprintf('Генератор %d кВт, двигатель %s', $product_data['power'], $product_data['engine_manufacturer'])
            );
            
            $product_id = $product->save();
            
            if ($product_id) {
                // Заполнение ACF полей
                update_field('power', $product_data['power'], $product_id);
                update_field('nominal_power', $product_data['nominal_power'], $product_id);
                update_field('max_power', $product_data['max_power'], $product_id);
                update_field('voltage', $product_data['voltage'], $product_id);
                update_field('frequency', $product_data['frequency'], $product_id);
                update_field('phases', $product_data['phases'], $product_id);
                update_field('engine', $product_data['engine'], $product_id);
                update_field('engine_manufacturer', $product_data['engine_manufacturer'], $product_id);
                update_field('engine_volume', $product_data['engine_volume'], $product_id);
                update_field('country_engine', $product_data['country_engine'], $product_id);
                update_field('oil_volume', $product_data['oil_volume'], $product_id);
                update_field('cylinder_config', $product_data['cylinder_config'], $product_id);
                update_field('cooling_type', $product_data['cooling_type'], $product_id);
                update_field('rotation_speed', $product_data['rotation_speed'], $product_id);
                update_field('fuel_tank_volume', $product_data['fuel_tank_volume'], $product_id);
                update_field('fuel_consumption', $product_data['fuel_consumption'], $product_id);
                update_field('generator_model_1', $product_data['generator_model_1'], $product_id);
                update_field('generator_model_2', $product_data['generator_model_2'], $product_id);
                update_field('dimensions', $product_data['dimensions'], $product_id);
                update_field('weight', $product_data['weight'], $product_id);
                update_field('country', $product_data['country'], $product_id);
                update_field('start_type', $product_data['start_type'], $product_id);
                update_field('noise_level', $product_data['noise_level'], $product_id);
                update_field('warranty', $product_data['warranty'], $product_id);
                
                $created++;
                $products[] = [
                    'id' => $product_id,
                    'name' => $product_data['name'],
                    'power' => $product_data['power'],
                    'price' => $product_data['price']
                ];
            }
        } catch (Exception $e) {
            $errors++;
        }
    }
    
    return [
        'success' => $created > 0,
        'created' => $created,
        'errors' => $errors,
        'products' => $products
    ];
}
