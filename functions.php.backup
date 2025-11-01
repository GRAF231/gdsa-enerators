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
    
    // Регистрация меню
    register_nav_menus(array(
        'header-top-menu' => 'Верхнее меню (О компании)',
        'header-main-menu' => 'Основное меню (Каталог продукции)',
        'footer-products-menu' => 'Меню футера: Продукция',
        'footer-services-menu' => 'Меню футера: Услуги',
    ));
}
add_action('after_setup_theme', 'dsa_generators_theme_setup');

// ============================================
// КАСТОМНЫЕ MENU WALKERS
// ============================================

/**
 * Кастомный Walker для верхнего меню (с поддержкой dropdown)
 */
class Header_Top_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="header__dropdown-menu">';
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Определяем, есть ли у элемента дочерние
        $has_children = in_array('menu-item-has-children', $classes);
        
        if ($depth === 0) {
            $class_names = $has_children ? 'header__top-item header__top-item_dropdown' : 'header__top-item';
            $output .= '<li class="' . esc_attr($class_names) . '">';
            
            $attributes  = ' class="header__top-link"';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            
            $output .= '<a' . $attributes . '>';
            $output .= esc_html($item->title);
            
            if ($has_children) {
                $output .= ' <i class="fa-solid fa-caret-down header__dropdown-icon" aria-hidden="true"></i>';
            }
            
            $output .= '</a>';
        } else {
            // Подменю
            $output .= '<li class="header__dropdown-item">';
            
            $attributes  = ' class="header__dropdown-link"';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            
            // Сначала проверяем кастомное поле иконки
            $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
            
            // Если нет кастомного поля, ищем в CSS классах
            if (empty($icon_class)) {
                $icon_class = 'fa-solid fa-circle';
                foreach ($classes as $class) {
                    if (strpos($class, 'fa-') === 0) {
                        $icon_class = $class;
                        break;
                    }
                }
            }
            
            $output .= '<a' . $attributes . '>';
            $output .= '<i class="' . esc_attr($icon_class) . ' header__dropdown-icon" aria-hidden="true"></i>';
            $output .= '<span>' . esc_html($item->title) . '</span>';
            $output .= '</a>';
        }
    }
}

/**
 * Кастомный Walker для основного меню (с иконками)
 */
class Header_Main_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        $output .= '<li class="header__menu-item">';
        
        $attributes  = ' class="header__menu-link"';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        // Сначала проверяем кастомное поле иконки
        $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
        
        // Если нет кастомного поля, ищем в CSS классах
        if (empty($icon_class)) {
            $icon_class = 'fa-solid fa-circle';
            foreach ($classes as $class) {
                if (strpos($class, 'fa-') === 0) {
                    $icon_class = $class;
                    break;
                }
            }
        }
        
        $output .= '<a' . $attributes . '>';
        $output .= '<i class="' . esc_attr($icon_class) . '"></i>';
        $output .= '<span>' . esc_html($item->title) . '</span>';
        $output .= '</a>';
    }
}

/**
 * Кастомный Walker для меню футера (простые ссылки)
 */
class Footer_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<li>';
        
        $attributes  = ' class="footer__nav-link"';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $output .= '<a' . $attributes . '>';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }
}

// ============================================
// КАСТОМНЫЕ ПОЛЯ ДЛЯ МЕНЮ (ИКОНКИ)
// ============================================

/**
 * Добавляет поле для иконки в редакторе пунктов меню
 */
function dsa_add_menu_item_icon_field($item_id, $item, $depth, $args) {
    $icon_value = get_post_meta($item_id, '_menu_item_icon', true);
    ?>
    <p class="field-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <?php _e('Иконка Font Awesome'); ?><br>
            <input 
                type="text" 
                id="edit-menu-item-icon-<?php echo $item_id; ?>" 
                class="widefat edit-menu-item-icon" 
                name="menu-item-icon[<?php echo $item_id; ?>]" 
                value="<?php echo esc_attr($icon_value); ?>" 
                placeholder="fa-solid fa-home"
            />
            <span class="description">Например: fa-solid fa-home, fa-solid fa-industry</span>
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'dsa_add_menu_item_icon_field', 10, 4);

/**
 * Сохраняет значение иконки при сохранении меню
 */
function dsa_save_menu_item_icon($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        $icon_value = sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_icon', $icon_value);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_icon');
    }
}
add_action('wp_update_nav_menu_item', 'dsa_save_menu_item_icon', 10, 3);

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
        'contact-form',
        'callback-modal',
        'page'
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
    
    // Модальное окно обратного звонка
    $file = $theme_dir . '/assets/js/callback-modal.js';
    if (file_exists($file)) {
        wp_enqueue_script('dsa-callback-modal', $theme_uri . '/assets/js/callback-modal.js', array(), filemtime($file), true);
        
        // Передаем данные для AJAX
        wp_localize_script('dsa-callback-modal', 'dsaCallbackData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dsa_callback_nonce')
        ));
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
            // Специальная обработка для типа "project" - используем страницу "Выполненные проекты"
            if ( $post_type === 'project' ) {
                $projects_page = get_pages([
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'template-projects.php'
                ]);
                
                if ( !empty($projects_page) ) {
                    $projects_page_url = get_permalink($projects_page[0]->ID);
                    $projects_page_title = get_the_title($projects_page[0]->ID);
                    dsa_breadcrumb_link($projects_page_url, $projects_page_title);
                } else {
                    // Если страница не найдена, используем стандартный архив
                    $post_type_obj = get_post_type_object($post_type);
                    $archive_link = get_post_type_archive_link($post_type);
                    if ( $post_type_obj && $archive_link ) {
                        dsa_breadcrumb_link($archive_link, $post_type_obj->labels->name);
                    }
                }
            } else {
                // Для других CPT используем стандартный архив
                $post_type_obj = get_post_type_object($post_type);
                $archive_link = get_post_type_archive_link($post_type);
                
                if ( $post_type_obj && $archive_link ) {
                    dsa_breadcrumb_link($archive_link, $post_type_obj->labels->name);
                }
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
// РЕГИСТРАЦИЯ ACF OPTIONS PAGE
// ============================================
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Настройки сайта',
        'menu_title'    => 'Настройки сайта',
        'menu_slug'     => 'setting-template',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-admin-generic',
        'redirect'      => false,
        'position'      => 30
    ));
}

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
                
                // Локализация параметров для AJAX
                wp_localize_script('dsa-product', 'wc_add_to_cart_params', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
                    'i18n_view_cart' => esc_html__('Просмотреть корзину', 'dsa-generators'),
                    'cart_url' => wc_get_cart_url(),
                    'is_cart' => is_cart(),
                    'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add')
                ));
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
            
            // JS для личного кабинета (переключение видимости пароля и др.)
            $account_js = $theme_dir . '/assets/js/woocommerce/wc-account.js';
            if (file_exists($account_js)) {
                wp_enqueue_script('dsa-wc-account', $theme_uri . '/assets/js/woocommerce/wc-account.js', array('jquery'), filemtime($account_js), true);
            }
        }
        
        // ============================================
        // МИНИ-КОРЗИНА (на всех страницах WooCommerce)
        // ============================================
        $mini_cart_css = $theme_dir . '/assets/css/mini-cart.css';
        if (file_exists($mini_cart_css)) {
            wp_enqueue_style('dsa-mini-cart', $theme_uri . '/assets/css/mini-cart.css', array(), filemtime($mini_cart_css));
        }
        
        $mini_cart_js = $theme_dir . '/assets/js/mini-cart.js';
        if (file_exists($mini_cart_js)) {
            wp_enqueue_script('dsa-mini-cart', $theme_uri . '/assets/js/mini-cart.js', array(), filemtime($mini_cart_js), true);
            
            // Локализация параметров для мини-корзины
            wp_localize_script('dsa-mini-cart', 'dsaMiniCartParams', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('dsa-mini-cart'),
                'strings' => array(
                    'added' => __('Товар добавлен в корзину', 'dsa-generators'),
                    'removed' => __('Товар удален из корзины', 'dsa-generators'),
                    'error' => __('Произошла ошибка', 'dsa-generators'),
                    'updating' => __('Обновление...', 'dsa-generators')
                )
            ));
        }
    }
}
add_action('wp_enqueue_scripts', 'dsa_woocommerce_assets', 20);

/**
 * AJAX обработчик добавления товара в корзину
 * Поддерживает добавление без перезагрузки страницы
 */
function dsa_ajax_add_to_cart() {
    // Проверка безопасности
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(array('message' => 'Не указан ID товара'));
        return;
    }
    
    $product_id = absint($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;
    $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
    $variation = isset($_POST['variation']) ? $_POST['variation'] : array();
    
    // Проверяем существование товара
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error(array('message' => 'Товар не найден'));
        return;
    }
    
    // Проверяем доступность товара
    if (!$product->is_purchasable() || !$product->is_in_stock()) {
        wp_send_json_error(array('message' => 'Товар недоступен для покупки'));
        return;
    }
    
    // Добавляем товар в корзину
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    
    if ($passed_validation) {
        if ($variation_id) {
            // Вариативный товар
            $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);
        } else {
            // Простой товар
            $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
        }
        
        if ($cart_item_key) {
            // Успешное добавление
            do_action('woocommerce_ajax_added_to_cart', $product_id);
            
            // Получаем обновленные фрагменты корзины
            WC_AJAX::get_refreshed_fragments();
        } else {
            wp_send_json_error(array('message' => 'Не удалось добавить товар в корзину'));
        }
    } else {
        wp_send_json_error(array('message' => 'Товар не прошел валидацию'));
    }
}
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'dsa_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'dsa_ajax_add_to_cart');

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

    // Сохраняем параметры в пагинации
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
        
        // Собираем все параметры из текущего URL для сохранения
        $params_to_keep = array();
        
        // Параметр вида
        if (!empty($view)) {
            $params_to_keep['view'] = $view;
        }
        
        // Параметры фильтров
        $filter_params = array('filter_power', 'filter_engine', 'filter_manufacturer', 'filter_country', 'filter_power_exact', 'orderby');
        foreach ($filter_params as $param) {
            if (!empty($_GET[$param])) {
                $params_to_keep[$param] = sanitize_text_field($_GET[$param]);
            }
        }
        
        // Добавляем все параметры к ссылке
        if (!empty($params_to_keep)) {
            $link = add_query_arg($params_to_keep, $link);
        }
        
        return $link;
    };
    
    echo '<div class="pagination">';
    
    // Блок "Выводить по" - показываем всегда
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
    
    // Если страница только одна, не показываем навигацию
    if ($total <= 1) {
        echo '</div>'; // pagination
        return;
    }
    
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
 * Применение кастомных фильтров к каталогу WooCommerce
 * 
 * @param WP_Query $query Объект запроса
 */
function dsa_apply_catalog_filters($query) {
    // Применяем только к основному запросу товаров на странице каталога
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag())) {
        
        // ВАЖНО: Очищаем встроенные WooCommerce фильтры, которые могут конфликтовать
        $existing_tax_query = $query->get('tax_query') ?: [];
        $clean_tax_query = [];
        
        // Оставляем только системные фильтры WooCommerce (product_visibility, product_cat и т.д.)
        // Удаляем любые фильтры по атрибутам, чтобы избежать конфликта
        if (!empty($existing_tax_query)) {
            foreach ($existing_tax_query as $key => $tax) {
                if ($key === 'relation') {
                    continue; // Пропускаем ключ relation
                }
                
                // Оставляем только НЕ-атрибутные таксономии
                if (isset($tax['taxonomy']) && 
                    !taxonomy_is_product_attribute($tax['taxonomy']) &&
                    strpos($tax['taxonomy'], 'pa_') !== 0) {
                    $clean_tax_query[] = $tax;
                }
            }
        }
        
        $tax_query = $clean_tax_query;
        
        // Фильтр по мощности (диапазон) - используем числовую фильтрацию через термины
        if (!empty($_GET['filter_power'])) {
            $power_range = sanitize_text_field(urldecode($_GET['filter_power']));
            
            // Разбираем диапазон типа "16-40"
            if (preg_match('/^(\d+)-(\d+)$/', $power_range, $matches)) {
                $min_power = intval($matches[1]);
                $max_power = intval($matches[2]);
                
                // Получаем все термины мощности в диапазоне
                $power_taxonomy = wc_attribute_taxonomy_name('power');
                $terms = get_terms([
                    'taxonomy' => $power_taxonomy,
                    'hide_empty' => true,
                ]);
                
                $valid_term_slugs = [];
                if (!is_wp_error($terms) && !empty($terms)) {
                    foreach ($terms as $term) {
                        $power_value = intval($term->name);
                        if ($power_value >= $min_power && $power_value < $max_power) {
                            $valid_term_slugs[] = $term->slug;
                        }
                    }
                }
                
                if (!empty($valid_term_slugs)) {
                    $tax_query[] = [
                        'taxonomy' => $power_taxonomy,
                        'field' => 'slug',
                        'terms' => $valid_term_slugs,
                        'operator' => 'IN'
                    ];
                }
            }
        }
        
        // Фильтр по производителю двигателя
        if (!empty($_GET['filter_engine'])) {
            $engine_slug = sanitize_text_field(urldecode($_GET['filter_engine']));
            
            $tax_query[] = [
                'taxonomy' => wc_attribute_taxonomy_name('engine_manufacturer'),
                'field' => 'slug',
                'terms' => $engine_slug
            ];
        }
        
        // Фильтр по стране сборки
        if (!empty($_GET['filter_country'])) {
            $country_slug = sanitize_text_field(urldecode($_GET['filter_country']));
            
            $tax_query[] = [
                'taxonomy' => wc_attribute_taxonomy_name('country'),
                'field' => 'slug',
                'terms' => $country_slug
            ];
        }
        
        // Фильтр по номинальной мощности (точное значение)
        if (!empty($_GET['filter_power_exact'])) {
            $exact_power = sanitize_text_field(urldecode($_GET['filter_power_exact']));
            
            $tax_query[] = [
                'taxonomy' => wc_attribute_taxonomy_name('power'),
                'field' => 'name',
                'terms' => $exact_power
            ];
        }
        
        // Применяем таксономические запросы
        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND';
            $query->set('tax_query', $tax_query);
        }
    }
}
add_action('pre_get_posts', 'dsa_apply_catalog_filters', 20);

/**
 * Отключаем автоматические WooCommerce query vars для атрибутов
 * чтобы избежать конфликта с нашими кастомными фильтрами
 */
function dsa_disable_wc_attribute_query_vars($query_vars) {
    // Удаляем автоматические query vars для атрибутов
    global $wp_query;
    
    // Получаем все атрибуты продуктов
    $attribute_taxonomies = wc_get_attribute_taxonomies();
    
    if (!empty($attribute_taxonomies)) {
        foreach ($attribute_taxonomies as $tax) {
            $attribute = wc_attribute_taxonomy_name($tax->attribute_name);
            $query_var = 'filter_' . $tax->attribute_name;
            
            // Удаляем из query_vars, если это наши кастомные параметры
            if (isset($_GET[$query_var])) {
                unset($query_vars[$query_var]);
            }
        }
    }
    
    return $query_vars;
}
add_filter('woocommerce_get_layered_nav_chosen_attributes', '__return_empty_array', 99);

/**
 * Установка cookie для вида каталога (выполняется до вывода заголовков)
 */
function dsa_set_catalog_view_cookie() {
    // Проверяем GET параметр и устанавливаем cookie
    if (isset($_GET['view']) && in_array($_GET['view'], ['list', 'cards'])) {
        $view = sanitize_text_field($_GET['view']);
        // Устанавливаем cookie на 30 дней
        setcookie('catalog_view', $view, time() + (86400 * 30), '/', '', false, false);
    }
}
add_action('init', 'dsa_set_catalog_view_cookie');

/**
 * Определение текущего вида каталога (табличный или карточный)
 * Читает значение из GET параметра или Cookie
 * 
 * @return string 'list' или 'cards'
 */
function dsa_get_catalog_view() {
    // 1. Проверить GET параметр (имеет приоритет)
    if (isset($_GET['view']) && in_array($_GET['view'], ['list', 'cards'])) {
        return sanitize_text_field($_GET['view']);
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
 * Получение мощности товара из атрибута WooCommerce
 * 
 * @param WC_Product $product Объект товара
 * @return int Мощность в кВт
 */
function dsa_get_product_power($product) {
    $power = dsa_get_product_attribute_value($product->get_id(), 'power');
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
 * Форматирование цены для каталога с кастомным классом
 * 
 * @param WC_Product $product Объект товара
 * @return string HTML цены с правильным форматированием
 */
function dsa_get_formatted_catalog_price($product) {
    $price = $product->get_price();
    
    // Если цена не установлена
    if (empty($price)) {
        return '<span class="catalog-product__price-text">Цена по запросу</span>';
    }
    
    // Форматируем цену: число с пробелами в тысячах
    $formatted_price = number_format((float)$price, 0, ',', ' ');
    
    // Возвращаем с нужным классом и символом рубля
    return '<span class="catalog-product__price-text">' . $formatted_price . ' ₽</span>';
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
    $price = dsa_get_formatted_catalog_price($product);
    
    // Атрибуты WooCommerce
    $engine = dsa_get_product_attribute_value($product_id, 'engine') ?: '—';
    $power = dsa_get_product_attribute_value($product_id, 'power') ?: '—';
    $nominal_power = dsa_get_product_attribute_value($product_id, 'nominal_power') ?: '';
    $country = dsa_get_product_attribute_value($product_id, 'country') ?: '—';
    
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
    $price = dsa_get_formatted_catalog_price($product);
    
    // Атрибуты WooCommerce
    $engine = dsa_get_product_attribute_value($product_id, 'engine') ?: '—';
    $power = dsa_get_product_attribute_value($product_id, 'power') ?: '—';
    $nominal_power = dsa_get_product_attribute_value($product_id, 'nominal_power') ?: '';
    $country = dsa_get_product_attribute_value($product_id, 'country') ?: '—';
    
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
// MINI CART AJAX HANDLERS
// ============================================

/**
 * Получить количество конкретного товара в корзине
 * 
 * @param int $product_id ID товара
 * @return int Количество товара в корзине
 */
function dsa_get_cart_item_quantity($product_id) {
    if (!class_exists('WooCommerce') || !WC()->cart) {
        return 0;
    }
    
    $product_id = absint($product_id);
    
    foreach (WC()->cart->get_cart() as $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            return $cart_item['quantity'];
        }
        
        // Проверяем также вариации товара
        if (isset($cart_item['variation_id']) && $cart_item['variation_id'] == $product_id) {
            return $cart_item['quantity'];
        }
    }
    
    return 0;
}

/**
 * AJAX обработчик обновления мини-корзины
 * Возвращает HTML мини-корзины и статистику
 */
function dsa_ajax_update_mini_cart() {
    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error(['message' => 'WooCommerce не активен']);
        return;
    }
    
    // Получаем HTML мини-корзины через буферизацию
    ob_start();
    get_template_part('template-parts/mini-cart');
    $html = ob_get_clean();
    
    // Подготавливаем данные для ответа
    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_total = WC()->cart->get_cart_total();
    $cart_subtotal = WC()->cart->get_cart_subtotal();
    
    wp_send_json_success([
        'html' => $html,
        'count' => $cart_count,
        'total' => $cart_total,
        'subtotal' => $cart_subtotal
    ]);
}
add_action('wp_ajax_dsa_update_mini_cart', 'dsa_ajax_update_mini_cart');
add_action('wp_ajax_nopriv_dsa_update_mini_cart', 'dsa_ajax_update_mini_cart');

/**
 * AJAX обработчик удаления товара из корзины
 * Удаляет товар и возвращает обновленную корзину
 */
function dsa_ajax_remove_from_cart() {
    // Проверка безопасности
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dsa-mini-cart')) {
        wp_send_json_error(['message' => 'Ошибка безопасности']);
        return;
    }
    
    if (!isset($_POST['cart_item_key'])) {
        wp_send_json_error(['message' => 'Не указан ключ товара']);
        return;
    }
    
    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error(['message' => 'WooCommerce не активен']);
        return;
    }
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    
    // Получаем product_id перед удалением
    $cart_item = WC()->cart->get_cart_item($cart_item_key);
    $product_id = $cart_item ? $cart_item['product_id'] : 0;
    
    // Удаляем товар из корзины
    $removed = WC()->cart->remove_cart_item($cart_item_key);
    
    if ($removed) {
        // Получаем обновленные данные мини-корзины
        ob_start();
        get_template_part('template-parts/mini-cart');
        $html = ob_get_clean();
        
        $cart_count = WC()->cart->get_cart_contents_count();
        
        wp_send_json_success([
            'html' => $html,
            'count' => $cart_count,
            'product_id' => $product_id // Возвращаем ID удаленного товара
        ]);
    } else {
        wp_send_json_error(['message' => 'Не удалось удалить товар']);
    }
}
add_action('wp_ajax_dsa_remove_from_cart', 'dsa_ajax_remove_from_cart');
add_action('wp_ajax_nopriv_dsa_remove_from_cart', 'dsa_ajax_remove_from_cart');

/**
 * AJAX обработчик получения количества конкретного товара в корзине
 * Используется для динамического обновления индикаторов
 */
function dsa_ajax_get_product_quantity() {
    if (!isset($_POST['product_id'])) {
        wp_send_json(['quantity' => 0]);
        return;
    }
    
    $product_id = absint($_POST['product_id']);
    $quantity = dsa_get_cart_item_quantity($product_id);
    
    wp_send_json(['quantity' => $quantity]);
}
add_action('wp_ajax_dsa_get_product_quantity', 'dsa_ajax_get_product_quantity');
add_action('wp_ajax_nopriv_dsa_get_product_quantity', 'dsa_ajax_get_product_quantity');

/**
 * AJAX обработчик обновления количества товара в корзине
 * Используется для изменения количества через каунтер на странице товара
 */
function dsa_ajax_update_cart_quantity() {
    // Проверка безопасности
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dsa-mini-cart')) {
        wp_send_json_error(['message' => 'Ошибка безопасности']);
        return;
    }
    
    if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
        wp_send_json_error(['message' => 'Не указаны обязательные параметры']);
        return;
    }
    
    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error(['message' => 'WooCommerce не активен']);
        return;
    }
    
    $product_id = absint($_POST['product_id']);
    $new_quantity = absint($_POST['quantity']);
    
    // Если количество 0 - удаляем товар из корзины
    if ($new_quantity == 0) {
        // Находим cart_item_key для данного товара
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                WC()->cart->remove_cart_item($cart_item_key);
                break;
            }
        }
    } else {
        // Ищем товар в корзине
        $cart_updated = false;
        
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $product_id) {
                // Обновляем количество существующего товара
                WC()->cart->set_quantity($cart_item_key, $new_quantity, true);
                $cart_updated = true;
                break;
            }
        }
        
        // Если товара еще нет в корзине - добавляем
        if (!$cart_updated) {
            WC()->cart->add_to_cart($product_id, $new_quantity);
        }
    }
    
    // Возвращаем обновленные данные мини-корзины
    dsa_ajax_update_mini_cart();
}
add_action('wp_ajax_dsa_update_cart_quantity', 'dsa_ajax_update_cart_quantity');
add_action('wp_ajax_nopriv_dsa_update_cart_quantity', 'dsa_ajax_update_cart_quantity');

// ============================================
// UNIFIED CART & CHECKOUT
// ============================================

/**
 * Заменяем URL корзины на URL checkout во всех ссылках
 * НО только если корзина не пуста (чтобы избежать редирект-лупов)
 */
add_filter('woocommerce_get_cart_url', function() {
    // Если корзина пуста, оставляем стандартный URL корзины
    if (WC()->cart && WC()->cart->is_empty()) {
        return wc_get_page_permalink('cart');
    }
    // Если есть товары, редиректим на checkout
    return wc_get_checkout_url();
}, 99);

/**
 * Отключаем редирект на shop при пустой корзине
 * Разрешаем показывать пустую корзину на unified странице
 */
add_action('template_redirect', function() {
    // Если это страница корзины или checkout и корзина пуста - НЕ редиректим
    if ((is_cart() || is_checkout()) && WC()->cart && WC()->cart->is_empty()) {
        // Убираем стандартный редирект WooCommerce для пустой корзины
        remove_action('template_redirect', 'wc_empty_cart_redirect', 10);
    }
}, 5);

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
            <p>Этот инструмент создаст <strong>15 тестовых товаров WooCommerce</strong> с полным заполнением всех <strong>24 атрибутов продукта</strong>.</p>
            
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
                <li><strong>24 атрибута продукта:</strong> все характеристики (мощность, двигатель, топливо, электрика, габариты и т.д.)</li>
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
                    Атрибуты регистрируются автоматически при активации темы.
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
        ['name' => 'DSA DG-10 Kubota', 'price' => 850000, 'attrs' => ['pa_power' => '10', 'pa_nominal_power' => '12.5', 'pa_max_power' => '11', 'pa_engine' => 'Kubota D1105-BG', 'pa_engine_manufacturer' => 'Kubota', 'pa_engine_volume' => '1.123', 'pa_country_engine' => 'Япония', 'pa_oil_volume' => '4.5', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '50', 'pa_fuel_consumption' => '2.5', 'pa_generator_model_1' => 'Stamford UCI224C', 'pa_generator_model_2' => 'Mecc Alte ECP28-2L', 'pa_dimensions' => '1500×700×1200', 'pa_weight' => '450', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '68', 'pa_warranty' => '12 месяцев']],
        ['name' => 'DSA DG-16 Cummins (в кожухе)', 'price' => 1040643, 'attrs' => ['pa_power' => '16', 'pa_nominal_power' => '20', 'pa_max_power' => '17.6', 'pa_engine' => 'Cummins 4B3.9G11', 'pa_engine_manufacturer' => 'Cummins', 'pa_engine_volume' => '3.9', 'pa_country_engine' => 'США', 'pa_oil_volume' => '10', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '100', 'pa_fuel_consumption' => '4.2', 'pa_generator_model_1' => 'Stamford UCI274C', 'pa_generator_model_2' => 'Mecc Alte ECP32-1S', 'pa_dimensions' => '2200×900×1500', 'pa_weight' => '850', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '70', 'pa_warranty' => '12 месяцев']],
        ['name' => 'DSA DG-20 Perkins', 'price' => 1200000, 'attrs' => ['pa_power' => '20', 'pa_nominal_power' => '25', 'pa_max_power' => '22', 'pa_engine' => 'Perkins 403A-15G1', 'pa_engine_manufacturer' => 'Perkins', 'pa_engine_volume' => '1.5', 'pa_country_engine' => 'Великобритания', 'pa_oil_volume' => '6.5', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '120', 'pa_fuel_consumption' => '5.0', 'pa_generator_model_1' => 'Stamford UCI274D', 'pa_generator_model_2' => 'Mecc Alte ECP32-3S', 'pa_dimensions' => '2400×1000×1600', 'pa_weight' => '950', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '72', 'pa_warranty' => '12 месяцев']],
        ['name' => 'DSA DG-30 Doosan', 'price' => 1450000, 'attrs' => ['pa_power' => '30', 'pa_nominal_power' => '37.5', 'pa_max_power' => '33', 'pa_engine' => 'Doosan P086TI', 'pa_engine_manufacturer' => 'Doosan', 'pa_engine_volume' => '3.4', 'pa_country_engine' => 'Корея', 'pa_oil_volume' => '12', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '150', 'pa_fuel_consumption' => '7.5', 'pa_generator_model_1' => 'Stamford UCI274E', 'pa_generator_model_2' => 'Mecc Alte ECP34-2S', 'pa_dimensions' => '2600×1100×1700', 'pa_weight' => '1200', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '73', 'pa_warranty' => '18 месяцев']],
        ['name' => 'DSA DG-50 Perkins (открытое исполнение)', 'price' => 1850000, 'attrs' => ['pa_power' => '50', 'pa_nominal_power' => '63', 'pa_max_power' => '55', 'pa_engine' => 'Perkins 1104C-44TAG2', 'pa_engine_manufacturer' => 'Perkins', 'pa_engine_volume' => '4.4', 'pa_country_engine' => 'Великобритания', 'pa_oil_volume' => '15', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '200', 'pa_fuel_consumption' => '12.5', 'pa_generator_model_1' => 'Stamford UCI274F', 'pa_generator_model_2' => 'Mecc Alte ECP34-3S', 'pa_dimensions' => '2800×1200×1800', 'pa_weight' => '1600', 'pa_country' => 'Россия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '75', 'pa_warranty' => '18 месяцев']],
        ['name' => 'DSA DG-80 Cummins', 'price' => 2400000, 'attrs' => ['pa_power' => '80', 'pa_nominal_power' => '100', 'pa_max_power' => '88', 'pa_engine' => 'Cummins 6BT5.9-G2', 'pa_engine_manufacturer' => 'Cummins', 'pa_engine_volume' => '5.9', 'pa_country_engine' => 'США', 'pa_oil_volume' => '18', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '300', 'pa_fuel_consumption' => '20', 'pa_generator_model_1' => 'Stamford UCI274G', 'pa_generator_model_2' => 'Mecc Alte ECP38-1S', 'pa_dimensions' => '3000×1300×1900', 'pa_weight' => '2200', 'pa_country' => 'Россия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '76', 'pa_warranty' => '24 месяца']],
        ['name' => 'DSA DG-100 MTU', 'price' => 3200000, 'attrs' => ['pa_power' => '100', 'pa_nominal_power' => '125', 'pa_max_power' => '110', 'pa_engine' => 'MTU 6R 0183 TC21', 'pa_engine_manufacturer' => 'MTU', 'pa_engine_volume' => '12.8', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '45', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '500', 'pa_fuel_consumption' => '25', 'pa_generator_model_1' => 'Stamford UCI274E', 'pa_generator_model_2' => 'Mecc Alte ECO40-3S', 'pa_dimensions' => '3500×1500×2200', 'pa_weight' => '4500', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '75', 'pa_warranty' => '24 месяца']],
        ['name' => 'DSA DG-150 Perkins', 'price' => 4500000, 'attrs' => ['pa_power' => '150', 'pa_nominal_power' => '187.5', 'pa_max_power' => '165', 'pa_engine' => 'Perkins 1106A-70TAG4', 'pa_engine_manufacturer' => 'Perkins', 'pa_engine_volume' => '7.0', 'pa_country_engine' => 'Великобритания', 'pa_oil_volume' => '25', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '600', 'pa_fuel_consumption' => '35', 'pa_generator_model_1' => 'Stamford HCI444D', 'pa_generator_model_2' => 'Mecc Alte ECO43-1S', 'pa_dimensions' => '3800×1600×2300', 'pa_weight' => '5200', 'pa_country' => 'Великобритания', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '77', 'pa_warranty' => '24 месяца']],
        ['name' => 'DSA DG-200 Caterpillar', 'price' => 6000000, 'attrs' => ['pa_power' => '200', 'pa_nominal_power' => '250', 'pa_max_power' => '220', 'pa_engine' => 'Caterpillar C9', 'pa_engine_manufacturer' => 'Caterpillar', 'pa_engine_volume' => '8.8', 'pa_country_engine' => 'США', 'pa_oil_volume' => '35', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '800', 'pa_fuel_consumption' => '50', 'pa_generator_model_1' => 'Stamford HCI544C', 'pa_generator_model_2' => 'Mecc Alte ECO46-2S', 'pa_dimensions' => '4200×1800×2500', 'pa_weight' => '6500', 'pa_country' => 'США', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '78', 'pa_warranty' => '36 месяцев']],
        ['name' => 'DSA DG-300 MAN', 'price' => 8500000, 'attrs' => ['pa_power' => '300', 'pa_nominal_power' => '375', 'pa_max_power' => '330', 'pa_engine' => 'MAN D2842LE223', 'pa_engine_manufacturer' => 'MAN', 'pa_engine_volume' => '12.4', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '50', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '1000', 'pa_fuel_consumption' => '75', 'pa_generator_model_1' => 'Stamford HCI634E', 'pa_generator_model_2' => 'Mecc Alte ECO50-3S', 'pa_dimensions' => '4800×2000×2700', 'pa_weight' => '8500', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '80', 'pa_warranty' => '36 месяцев']],
        ['name' => 'DSA DG-500 MTU', 'price' => 12000000, 'attrs' => ['pa_power' => '500', 'pa_nominal_power' => '625', 'pa_max_power' => '550', 'pa_engine' => 'MTU 12V 2000 G25', 'pa_engine_manufacturer' => 'MTU', 'pa_engine_volume' => '24.0', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '85', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '1500', 'pa_fuel_consumption' => '125', 'pa_generator_model_1' => 'Stamford PI734G', 'pa_generator_model_2' => 'Mecc Alte ECO55-1L', 'pa_dimensions' => '5500×2200×3000', 'pa_weight' => '12000', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '82', 'pa_warranty' => '36 месяцев']],
        ['name' => 'DSA DG-800 Caterpillar', 'price' => 18000000, 'attrs' => ['pa_power' => '800', 'pa_nominal_power' => '1000', 'pa_max_power' => '880', 'pa_engine' => 'Caterpillar C27', 'pa_engine_manufacturer' => 'Caterpillar', 'pa_engine_volume' => '27.0', 'pa_country_engine' => 'США', 'pa_oil_volume' => '110', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '2000', 'pa_fuel_consumption' => '200', 'pa_generator_model_1' => 'Stamford PI844G', 'pa_generator_model_2' => 'Mecc Alte ECO58-3L', 'pa_dimensions' => '6000×2500×3200', 'pa_weight' => '16000', 'pa_country' => 'США', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '85', 'pa_warranty' => '48 месяцев']],
        ['name' => 'DSA DG-1000 MTU', 'price' => 25000000, 'attrs' => ['pa_power' => '1000', 'pa_nominal_power' => '1250', 'pa_max_power' => '1100', 'pa_engine' => 'MTU 16V 2000 G85', 'pa_engine_manufacturer' => 'MTU', 'pa_engine_volume' => '32.0', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '150', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '3000', 'pa_fuel_consumption' => '250', 'pa_generator_model_1' => 'Stamford PI944H', 'pa_generator_model_2' => 'Mecc Alte ECO65-3L', 'pa_dimensions' => '7000×3000×3500', 'pa_weight' => '22000', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '87', 'pa_warranty' => '48 месяцев']],
        ['name' => 'DSA DG-1500 MAN', 'price' => 35000000, 'attrs' => ['pa_power' => '1500', 'pa_nominal_power' => '1875', 'pa_max_power' => '1650', 'pa_engine' => 'MAN 18V32/40', 'pa_engine_manufacturer' => 'MAN', 'pa_engine_volume' => '40.0', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '200', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '4000', 'pa_fuel_consumption' => '375', 'pa_generator_model_1' => 'Stamford HCI1444J', 'pa_generator_model_2' => 'Mecc Alte ECO70-3L', 'pa_dimensions' => '8000×3200×4000', 'pa_weight' => '30000', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '90', 'pa_warranty' => '60 месяцев']],
        ['name' => 'DSA DG-2000 Caterpillar', 'price' => 50000000, 'attrs' => ['pa_power' => '2000', 'pa_nominal_power' => '2500', 'pa_max_power' => '2200', 'pa_engine' => 'Caterpillar 3516B', 'pa_engine_manufacturer' => 'Caterpillar', 'pa_engine_volume' => '69.0', 'pa_country_engine' => 'США', 'pa_oil_volume' => '280', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '5000', 'pa_fuel_consumption' => '500', 'pa_generator_model_1' => 'Stamford HCI1644K', 'pa_generator_model_2' => 'Mecc Alte ECO75-3L', 'pa_dimensions' => '9000×3500×4500', 'pa_weight' => '45000', 'pa_country' => 'США', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '92', 'pa_warranty' => '60 месяцев']],
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
            
            // Получаем мощность для описания
            $power = isset($product_data['attrs']['pa_power']) ? $product_data['attrs']['pa_power'] : '0';
            $engine_manufacturer = isset($product_data['attrs']['pa_engine_manufacturer']) ? $product_data['attrs']['pa_engine_manufacturer'] : 'Unknown';
            
            $description = sprintf(
                'Дизельная электростанция %s мощностью %s кВт с двигателем %s. Надежное и экономичное решение для резервного и постоянного электроснабжения.',
                $product_data['name'],
                $power,
                $engine_manufacturer
            );
            $product->set_description($description);
            $product->set_short_description(
                sprintf('Генератор %s кВт, двигатель %s', $power, $engine_manufacturer)
            );
            
            $product_id = $product->save();
            
            if ($product_id) {
                // Устанавливаем атрибуты WooCommerce
                foreach ($product_data['attrs'] as $attr_slug => $attr_value) {
                    dsa_set_product_attribute($product_id, $attr_slug, $attr_value);
                }
                
                $created++;
                $products[] = [
                    'id' => $product_id,
                    'name' => $product_data['name'],
                    'power' => $power,
                    'price' => $product_data['price']
                ];
            }
        } catch (Exception $e) {
            $errors++;
            error_log('DSA: Ошибка создания товара: ' . $e->getMessage());
        }
    }
    
    return [
        'success' => $created > 0,
        'created' => $created,
        'errors' => $errors,
        'products' => $products
    ];
}

/**
 * Получение уникальных значений атрибута из всех товаров
 * Совместимая функция для обратной совместимости (переименовано для атрибутов)
 * 
 * @param string $attribute_slug Slug атрибута (например: 'pa_power')
 * @return array Массив уникальных значений
 */
function dsa_get_unique_product_field_values($attribute_slug) {
    return array_map(function($item) {
        return $item['name'];
    }, dsa_get_unique_attribute_values($attribute_slug));
}

/**
 * Получение диапазонов мощности с количеством товаров в каждом
 * Обновлено для работы с атрибутами WooCommerce
 * 
 * @return array Массив диапазонов с количеством товаров
 */
function dsa_get_power_ranges_with_counts() {
    $ranges = dsa_get_power_ranges();
    $ranges_with_counts = [];
    $power_taxonomy = wc_attribute_taxonomy_name('power');
    
    foreach ($ranges as $key => $range) {
        // Получаем все термины мощности в диапазоне
        $terms = get_terms([
            'taxonomy' => $power_taxonomy,
            'hide_empty' => true,
        ]);
        
        $valid_term_ids = [];
        foreach ($terms as $term) {
            $power_value = intval($term->name);
            if ($power_value >= $range['min'] && $power_value < $range['max']) {
                $valid_term_ids[] = $term->term_id;
            }
        }
        
        if (!empty($valid_term_ids)) {
            // Считаем товары с этими терминами
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
                'tax_query' => [
                    [
                        'taxonomy' => $power_taxonomy,
                        'field' => 'term_id',
                        'terms' => $valid_term_ids,
                        'operator' => 'IN'
                ]
            ]
        ];
        
        $query = new WP_Query($args);
        $count = $query->found_posts;
        
        if ($count > 0) {
            $ranges_with_counts[$key] = [
                'name' => $range['name'],
                'min' => $range['min'],
                'max' => $range['max'],
                'count' => $count
            ];
            }
        }
    }
    
    return $ranges_with_counts;
}

/**
 * Получение опций для фильтра с форматированием
 * Обновлено для работы с атрибутами WooCommerce
 * 
 * @param string $attribute_slug Slug атрибута (например: 'pa_engine_manufacturer')
 * @param array $labels Массив меток для значений (опционально)
 * @return array Массив опций вида ['value' => '', 'label' => '', 'count' => 0]
 */
function dsa_get_filter_options($attribute_slug, $labels = []) {
    $taxonomy = wc_attribute_taxonomy_name($attribute_slug);
    
    // Получаем все термины атрибута с подсчетом
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC'
    ]);
    
    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }
    
    $options = [];
    foreach ($terms as $term) {
        $value = $term->slug;
        $label = isset($labels[$value]) ? $labels[$value] : $term->name;
        
        $options[] = [
            'value' => $value,
            'label' => $label,
            'count' => intval($term->count)
        ];
    }
    
    return $options;
}

// ========================================
// WOOCOMMERCE LOCAL PICKUP INTEGRATION
// ========================================

/**
 * Объединение всех методов Local Pickup в один "Самовывоз"
 * 
 * @param array $rates Доступные методы доставки
 * @return array Модифицированные методы
 */
function dsa_merge_pickup_locations($rates) {
    $pickup_methods = [];
    $unified_pickup = null;
    
    // Ищем все методы pickup_location
    foreach ($rates as $rate_id => $rate) {
        if (strpos($rate_id, 'pickup_location:') === 0) {
            $pickup_methods[$rate_id] = $rate;
            
            // Сохраняем первый метод как базовый
            if ($unified_pickup === null) {
                $unified_pickup = $rate;
            }
        }
    }
    
    // Если найдено несколько методов pickup_location
    if (count($pickup_methods) > 1) {
        // Удаляем все методы pickup_location
        foreach ($pickup_methods as $rate_id => $rate) {
            unset($rates[$rate_id]);
        }
        
        // Создаем объединенный метод "Самовывоз"
        if ($unified_pickup) {
            $unified_pickup->id = 'pickup_location';
            $unified_pickup->label = 'Самовывоз';
            $unified_pickup->cost = 0;
            
            // Добавляем объединенный метод
            $rates['pickup_location'] = $unified_pickup;
        }
    } elseif (count($pickup_methods) == 1) {
        // Если только один метод, просто меняем его название
        foreach ($pickup_methods as $rate_id => $rate) {
            unset($rates[$rate_id]);
            $rate->id = 'pickup_location';
            $rate->label = 'Самовывоз';
            $rates['pickup_location'] = $rate;
        }
    }
    
    return $rates;
}
add_filter('woocommerce_package_rates', 'dsa_merge_pickup_locations', 100);

/**
 * Получение пунктов выдачи из WooCommerce Local Pickup
 * 
 * @return array Массив пунктов выдачи
 */
function dsa_get_pickup_locations() {
    // Получаем настройки Local Pickup из WooCommerce
    $pickup_locations = get_option('pickup_location_pickup_locations', []);
    
    if (empty($pickup_locations)) {
        // Если нет настроенных локаций, возвращаем дефолтную
        return [
            [
                'name' => 'Основной пункт выдачи',
                'address' => [
                    'address_1' => 'г. Москва, ул. Примерная, д. 1',
                    'city' => 'Москва',
                    'postcode' => '101000',
                    'country' => 'RU'
                ],
                'details' => 'Пн-Пт: 9:00-18:00, Сб-Вс: выходной'
            ]
        ];
    }
    
    return $pickup_locations;
}

/**
 * AJAX handler для получения пунктов выдачи
 */
function dsa_ajax_get_pickup_locations() {
    check_ajax_referer('woocommerce-process_checkout', 'security');
    
    $locations = dsa_get_pickup_locations();
    
    wp_send_json_success([
        'locations' => $locations
    ]);
}
add_action('wp_ajax_dsa_get_pickup_locations', 'dsa_ajax_get_pickup_locations');
add_action('wp_ajax_nopriv_dsa_get_pickup_locations', 'dsa_ajax_get_pickup_locations');

/**
 * Форматирование адреса пункта выдачи
 * 
 * @param array $location Данные локации
 * @return string Форматированный адрес
 */
function dsa_format_pickup_address($location) {
    if (empty($location['address'])) {
        return '';
    }
    
    $address = $location['address'];
    $parts = [];
    
    if (!empty($address['address_1'])) {
        $parts[] = $address['address_1'];
    }
    if (!empty($address['address_2'])) {
        $parts[] = $address['address_2'];
    }
    if (!empty($address['city'])) {
        $parts[] = $address['city'];
    }
    if (!empty($address['postcode'])) {
        $parts[] = $address['postcode'];
    }
    
    return implode(', ', $parts);
}

/**
 * Обработка выбора метода доставки "Самовывоз"
 * Когда пользователь выбирает наш объединенный метод "pickup_location",
 * устанавливаем первый реальный метод pickup_location из доступных
 */
function dsa_handle_pickup_location_selection($method, $index) {
    // Если выбран наш кастомный метод "pickup_location"
    if ($method === 'pickup_location') {
        // Получаем доступные методы доставки
        $packages = WC()->shipping()->get_packages();
        $first_package = reset($packages);
        $available_methods = isset($first_package['rates']) ? $first_package['rates'] : [];
        
        // Находим первый реальный метод pickup_location
        foreach ($available_methods as $rate_id => $rate) {
            if (strpos($rate_id, 'pickup_location:') === 0) {
                // Возвращаем ID первого найденного метода
                return $rate_id;
            }
        }
    }
    
    return $method;
}
add_filter('woocommerce_shipping_chosen_method', 'dsa_handle_pickup_location_selection', 10, 2);

/**
 * Сохранение выбранного пункта самовывоза в заказ
 */
function dsa_save_pickup_location_to_order($order_id) {
    if (isset($_POST['pickup_location_data']) && !empty($_POST['pickup_location_data'])) {
        $pickup_data = json_decode(stripslashes($_POST['pickup_location_data']), true);
        
        if ($pickup_data && isset($pickup_data['name']) && isset($pickup_data['address'])) {
            // Сохраняем данные пункта выдачи в мета заказа
            update_post_meta($order_id, '_pickup_location_name', sanitize_text_field($pickup_data['name']));
            update_post_meta($order_id, '_pickup_location_address', sanitize_text_field($pickup_data['address']));
            update_post_meta($order_id, '_pickup_location_index', intval($pickup_data['index']));
            
            // Добавляем заметку к заказу
            $order = wc_get_order($order_id);
            $order->add_order_note(
                sprintf(
                    'Пункт самовывоза: %s<br>Адрес: %s',
                    $pickup_data['name'],
                    $pickup_data['address']
                )
            );
        }
    }
}
add_action('woocommerce_checkout_update_order_meta', 'dsa_save_pickup_location_to_order');

/**
 * Отображение пункта самовывоза в админке заказа
 */
function dsa_display_pickup_location_in_admin($order) {
    $pickup_name = get_post_meta($order->get_id(), '_pickup_location_name', true);
    $pickup_address = get_post_meta($order->get_id(), '_pickup_location_address', true);
    
    if ($pickup_name && $pickup_address) {
        echo '<div class="order_data_column">';
        echo '<h3>Пункт самовывоза</h3>';
        echo '<p><strong>' . esc_html($pickup_name) . '</strong><br>';
        echo esc_html($pickup_address) . '</p>';
        echo '</div>';
    }
}
add_action('woocommerce_admin_order_data_after_shipping_address', 'dsa_display_pickup_location_in_admin');

/**
 * Умное форматирование больших чисел для личного кабинета
 * 
 * @param float $number Число для форматирования
 * @return string Отформатированное число с суффиксом
 */
function dsa_format_large_number($number) {
    if ($number < 1000) {
        return number_format($number, 0, '.', ' ');
    } elseif ($number < 1000000) {
        // Тысячи: 1.5 тыс.
        return number_format($number / 1000, 1, '.', ' ') . ' тыс.';
    } elseif ($number < 1000000000) {
        // Миллионы: 76.85 млн
        return number_format($number / 1000000, 2, '.', ' ') . ' млн';
    } else {
        // Миллиарды: 1.2 млрд
        return number_format($number / 1000000000, 2, '.', ' ') . ' млрд';
    }
}

/**
 * Умное форматирование цены для личного кабинета
 * 
 * @param float $price Цена для форматирования
 * @param bool $include_currency Включать ли символ валюты
 * @return string Отформатированная цена
 */
function dsa_format_price_smart($price, $include_currency = true) {
    $formatted = dsa_format_large_number($price);
    
    if ($include_currency) {
        return $formatted . ' ₽';
    }
    
    return $formatted;
}

// ============================================
// WOOCOMMERCE: СИСТЕМА АТРИБУТОВ ДЛЯ ХАРАКТЕРИСТИК ТОВАРОВ
// ============================================

/**
 * Регистрация атрибутов WooCommerce при активации темы
 * Полная замена ACF полей нативными атрибутами WooCommerce
 */
function dsa_register_product_attributes() {
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    global $wpdb;
    
    /**
     * Структура атрибутов с группировкой:
     * - group: Группа для отображения в интерфейсе
     * - note: Примечание к атрибуту
     * - type: Тип атрибута (select, text)
     * - filterable: Используется ли в фильтрах
     * - visible: Отображается ли на странице товара
     * - values: Предопределенные значения для select
     */
    $attributes = [
        // ГРУППА: Мощность и электропараметры
        'pa_power' => [
            'label' => 'Мощность',
            'group' => 'Мощность и электропараметры',
            'note' => 'Мощность в кВт (для группировки в каталоге)',
            'type' => 'text',
            'filterable' => true,
            'visible' => true,
            'unit' => 'кВт'
        ],
        'pa_nominal_power' => [
            'label' => 'Номинальная мощность',
            'group' => 'Мощность и электропараметры',
            'note' => 'Номинальная мощность в кВА',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'кВА'
        ],
        'pa_max_power' => [
            'label' => 'Максимальная мощность',
            'group' => 'Мощность и электропараметры',
            'note' => 'Максимальная мощность в кВт',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'кВт'
        ],
        'pa_voltage' => [
            'label' => 'Напряжение',
            'group' => 'Мощность и электропараметры',
            'note' => 'Напряжение электросети в Вольтах',
            'type' => 'select',
            'filterable' => false,
            'visible' => true,
            'unit' => 'В',
            'values' => ['220', '380', '400', '480', '690']
        ],
        'pa_frequency' => [
            'label' => 'Частота',
            'group' => 'Мощность и электропараметры',
            'note' => 'Частота электросети',
            'type' => 'select',
            'filterable' => false,
            'visible' => true,
            'values' => ['50 Гц', '60 Гц']
        ],
        'pa_phases' => [
            'label' => 'Количество фаз',
            'group' => 'Мощность и электропараметры',
            'note' => '1-фазная или 3-фазная сеть',
            'type' => 'select',
            'filterable' => false,
            'visible' => true,
            'values' => ['1-фазная', '3-фазная']
        ],
        
        // ГРУППА: Двигатель
        'pa_engine' => [
            'label' => 'Двигатель',
            'group' => 'Двигатель',
            'note' => 'Модель двигателя (например: Cummins 4B3.9G11)',
            'type' => 'text',
            'filterable' => false,
            'visible' => true
        ],
        'pa_engine_manufacturer' => [
            'label' => 'Производитель двигателя',
            'group' => 'Двигатель',
            'note' => 'Бренд производителя двигателя',
            'type' => 'select',
            'filterable' => true,
            'visible' => true,
            'values' => [
                'Cummins', 'Perkins', 'Doosan', 'MTU', 'Caterpillar', 
                'MAN', 'Volvo', 'Deutz', 'Scania', 'John Deere', 
                'Yanmar', 'Iveco', 'Mitsubishi', 'Weichai', 'Kubota', 'Другой'
            ]
        ],
        'pa_engine_volume' => [
            'label' => 'Объем двигателя',
            'group' => 'Двигатель',
            'note' => 'Объем двигателя в литрах',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'л'
        ],
        'pa_country_engine' => [
            'label' => 'Страна производства двигателя',
            'group' => 'Двигатель',
            'note' => 'Страна где произведен двигатель',
            'type' => 'select',
            'filterable' => true,
            'visible' => true,
            'values' => [
                'США', 'Великобритания', 'Германия', 'Япония', 'Корея',
                'Китай', 'Италия', 'Франция', 'Швеция', 'Финляндия', 'Другая'
            ]
        ],
        'pa_oil_volume' => [
            'label' => 'Объем масляной системы',
            'group' => 'Двигатель',
            'note' => 'Объем масла в литрах',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'л'
        ],
        'pa_cylinder_config' => [
            'label' => 'Расположение цилиндров',
            'group' => 'Двигатель',
            'note' => 'Конфигурация цилиндров (например: 4, рядное)',
            'type' => 'text',
            'filterable' => false,
            'visible' => true
        ],
        'pa_cooling_type' => [
            'label' => 'Тип охлаждения',
            'group' => 'Двигатель',
            'note' => 'Система охлаждения двигателя',
            'type' => 'select',
            'filterable' => false,
            'visible' => true,
            'values' => ['Воздушное', 'Жидкостное']
        ],
        'pa_rotation_speed' => [
            'label' => 'Частота вращения',
            'group' => 'Двигатель',
            'note' => 'Частота вращения в об/мин',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'об/мин'
        ],
        
        // ГРУППА: Топливная система
        'pa_fuel_tank_volume' => [
            'label' => 'Объем топливного бака',
            'group' => 'Топливная система',
            'note' => 'Емкость топливного бака в литрах',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'л'
        ],
        'pa_fuel_consumption' => [
            'label' => 'Расход топлива',
            'group' => 'Топливная система',
            'note' => 'Расход топлива в литрах в час',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'л/ч'
        ],
        
        // ГРУППА: Генератор переменного тока
        'pa_generator_model_1' => [
            'label' => 'Генератор (модель 1)',
            'group' => 'Генератор переменного тока',
            'note' => 'Первая модель генератора',
            'type' => 'text',
            'filterable' => false,
            'visible' => true
        ],
        'pa_generator_model_2' => [
            'label' => 'Генератор (модель 2)',
            'group' => 'Генератор переменного тока',
            'note' => 'Вторая модель генератора (альтернатива)',
            'type' => 'text',
            'filterable' => false,
            'visible' => true
        ],
        
        // ГРУППА: Габариты и вес
        'pa_dimensions' => [
            'label' => 'Габариты (ДxШxВ)',
            'group' => 'Габариты и вес',
            'note' => 'Габариты в миллиметрах',
            'type' => 'text',
            'filterable' => false,
            'visible' => true
        ],
        'pa_weight' => [
            'label' => 'Вес',
            'group' => 'Габариты и вес',
            'note' => 'Вес электростанции в килограммах',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'кг'
        ],
        
        // ГРУППА: Общие характеристики
        'pa_country' => [
            'label' => 'Страна сборки электростанции',
            'group' => 'Общие характеристики',
            'note' => 'Страна где собрана электростанция',
            'type' => 'select',
            'filterable' => true,
            'visible' => true,
            'values' => [
                'Россия', 'Германия', 'США', 'Великобритания', 'Италия',
                'Испания', 'Турция', 'Китай', 'Япония', 'Южная Корея', 'Франция', 'Другая'
            ]
        ],
        'pa_start_type' => [
            'label' => 'Тип запуска',
            'group' => 'Общие характеристики',
            'note' => 'Способ запуска двигателя',
            'type' => 'select',
            'filterable' => false,
            'visible' => true,
            'values' => ['Ручной запуск', 'Электрический стартер', 'Автоматический запуск']
        ],
        'pa_noise_level' => [
            'label' => 'Уровень шума',
            'group' => 'Общие характеристики',
            'note' => 'Уровень шума в децибелах на расстоянии 7 метров',
            'type' => 'text',
            'filterable' => false,
            'visible' => true,
            'unit' => 'дБ (A)'
        ],
        'pa_warranty' => [
            'label' => 'Гарантия',
            'group' => 'Общие характеристики',
            'note' => 'Срок гарантии от производителя',
            'type' => 'text',
            'filterable' => false,
            'visible' => true
        ],
    ];
    
    // Регистрация каждого атрибута
    foreach ($attributes as $slug => $config) {
        // Проверяем, существует ли атрибут
        $attribute_id = wc_attribute_taxonomy_id_by_name($slug);
        
        if (!$attribute_id) {
            // Создаем новый атрибут
            $attribute_id = wc_create_attribute([
                'name' => $config['label'],
                'slug' => $slug,
                'type' => $config['type'],
                'order_by' => 'menu_order',
                'has_archives' => $config['filterable']
            ]);
            
            if (is_wp_error($attribute_id)) {
                error_log('DSA: Ошибка создания атрибута ' . $slug . ': ' . $attribute_id->get_error_message());
                continue;
            }
            
            // Регистрируем таксономию для атрибута
            $taxonomy = wc_attribute_taxonomy_name($slug);
            register_taxonomy($taxonomy, 'product', [
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_nav_menus' => false,
                'query_var' => true,
                'rewrite' => false,
                'public' => true,
                'show_in_rest' => true,
            ]);
            
            // Добавляем термины для select типов
            if ($config['type'] === 'select' && !empty($config['values'])) {
                foreach ($config['values'] as $value) {
                    if (!term_exists($value, $taxonomy)) {
                        wp_insert_term($value, $taxonomy);
                    }
                }
            }
        }
        
        // Сохраняем метаданные атрибута для использования в шаблонах
        // Определяем group_id на основе названия группы
        $groups = dsa_get_attribute_groups();
        $group_id = '';
        foreach ($groups as $gid => $gdata) {
            if ($gdata['name'] === $config['group']) {
                $group_id = $gid;
                break;
            }
        }
        
        $existing_meta = get_option("dsa_attribute_meta_{$slug}", []);
        update_option("dsa_attribute_meta_{$slug}", [
            'group_id' => !empty($existing_meta['group_id']) ? $existing_meta['group_id'] : $group_id,
            'group' => $config['group'],
            'note' => !empty($existing_meta['note']) ? $existing_meta['note'] : $config['note'],
            'unit' => !empty($existing_meta['unit']) ? $existing_meta['unit'] : ($config['unit'] ?? ''),
            'filterable' => $config['filterable'],
            'visible' => isset($existing_meta['visible']) ? $existing_meta['visible'] : $config['visible']
        ]);
    }
    
    // Очистка кэша
    delete_transient('wc_attribute_taxonomies');
    WC_Cache_Helper::invalidate_cache_group('woocommerce-attributes');
    
    // Обновление permalink структуры
    flush_rewrite_rules();
}

// Хук для регистрации атрибутов
add_action('after_switch_theme', 'dsa_register_product_attributes');
add_action('admin_init', 'dsa_register_product_attributes', 1);

/**
 * Получение метаданных атрибута (группа, примечание, единица измерения)
 */
function dsa_get_attribute_meta($attribute_slug) {
    return get_option("dsa_attribute_meta_{$attribute_slug}", [
        'group' => 'Без группы',
        'note' => '',
        'unit' => '',
        'filterable' => false,
        'visible' => true
    ]);
}

/**
 * Получение всех атрибутов товара сгруппированных по категориям
 */
function dsa_get_product_attributes_grouped($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return [];
    }
    
    $attributes = $product->get_attributes();
    $grouped = [];
    $all_groups = dsa_get_attribute_groups();
    
    foreach ($attributes as $attribute) {
        if (!$attribute->is_taxonomy()) {
            continue;
        }
        
        $taxonomy = $attribute->get_taxonomy();
        $meta = dsa_get_attribute_meta($taxonomy);
        
        if (!$meta['visible']) {
            continue;
        }
        
        $group_id = $meta['group_id'] ?? '';
        $group_name = $meta['group'] ?? 'Без группы';
        $group_order = $all_groups[$group_id]['order'] ?? 999;
        
        if (!isset($grouped[$group_id])) {
            $grouped[$group_id] = [
                'name' => $group_name,
                'order' => $group_order,
                'attributes' => []
            ];
        }
        
        $terms = wc_get_product_terms($product_id, $taxonomy, ['fields' => 'names']);
        $value = !empty($terms) ? implode(', ', $terms) : '';
        
        if ($value) {
            // Получаем название атрибута
            $attribute_object = wc_get_attribute(wc_attribute_taxonomy_id_by_name($taxonomy));
            $label = $attribute_object ? $attribute_object->name : $taxonomy;
            
            // Добавляем единицу измерения
            if (!empty($meta['unit'])) {
                $value .= ' ' . $meta['unit'];
            }
            
            $grouped[$group_id]['attributes'][] = [
            'label' => $label,
                'value' => $value,
                'note' => $meta['note']
            ];
        }
    }
    
    // Сортируем группы по порядку
    uasort($grouped, function($a, $b) {
        return $a['order'] - $b['order'];
    });
    
    // Убираем служебные поля перед возвратом
    $result = [];
    foreach ($grouped as $group_id => $group_data) {
        $result[$group_data['name']] = $group_data['attributes'];
    }
    
    return $result;
}

/**
 * Получение значения конкретного атрибута товара
 * Принимает slug как с префиксом 'pa_', так и без него
 */
function dsa_get_product_attribute_value($product_id, $attribute_slug) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return '';
    }
    
    $taxonomy = wc_attribute_taxonomy_name($attribute_slug);
    $terms = wc_get_product_terms($product_id, $taxonomy, ['fields' => 'names']);
    
    if (empty($terms) || is_wp_error($terms)) {
        return '';
    }
    
    return implode(', ', $terms);
}

/**
 * Установка значения атрибута для товара
 * Принимает slug как с префиксом 'pa_', так и без него
 */
function dsa_set_product_attribute($product_id, $attribute_slug, $value) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return false;
    }
    
    // Получаем правильную таксономию
    $taxonomy = wc_attribute_taxonomy_name($clean_slug);
    
    // Проверяем существование таксономии
    if (!taxonomy_exists($taxonomy)) {
        error_log("DSA: Таксономия {$taxonomy} не существует для атрибута {$attribute_slug}");
        return false;
    }
    
    // Создаем или получаем термин ПО НАЗВАНИЮ (не по slug!)
    // term_exists() ищет по названию, slug или ID
    $term = get_term_by('name', $value, $taxonomy);
    
    if (!$term) {
        // Термин не существует - создаем новый
        $term = wp_insert_term($value, $taxonomy);
        if (is_wp_error($term)) {
            error_log('DSA: Ошибка создания термина: ' . $term->get_error_message());
            return false;
        }
        $term_id = $term['term_id'];
    } else {
        // Термин существует
        $term_id = $term->term_id;
    }
    
    // Устанавливаем термин для товара ПО НАЗВАНИЮ
    wp_set_object_terms($product_id, [$value], $taxonomy, false);
    
    // Получаем или создаем атрибут товара
    $attributes = $product->get_attributes();
    $attribute_key = sanitize_title($taxonomy);
    
    $attribute_id = wc_attribute_taxonomy_id_by_name($clean_slug);
    
    if (!$attribute_id) {
        error_log("DSA: Атрибут {$clean_slug} не зарегистрирован");
        return false;
    }
    
    // Создаем или обновляем атрибут
    if (!isset($attributes[$attribute_key])) {
        $attribute = new WC_Product_Attribute();
        $attribute->set_id($attribute_id);
        $attribute->set_name($taxonomy);
        $attribute->set_position(count($attributes));
    } else {
        $attribute = $attributes[$attribute_key];
    }
    
    // Устанавливаем опции (term IDs)
    $attribute->set_options([$term_id]);
    $attribute->set_visible(true);
    $attribute->set_variation(false);
    
    $attributes[$attribute_key] = $attribute;
    $product->set_attributes($attributes);
    $product->save();
    
    return true;
}

/**
 * Получение уникальных значений атрибута из всех товаров (для фильтров)
 */
function dsa_get_unique_attribute_values($attribute_slug) {
    $taxonomy = wc_attribute_taxonomy_name($attribute_slug);
    
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
        'orderby' => 'name',
        'order' => 'ASC'
    ]);
    
    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }
    
    $values = [];
    foreach ($terms as $term) {
        $values[] = [
            'slug' => $term->slug,
            'name' => $term->name,
            'count' => $term->count
        ];
    }
    
    return $values;
}

// ============================================
// ADMIN: УПРАВЛЕНИЕ ГРУППАМИ АТРИБУТОВ
// ============================================

/**
 * Добавление страницы управления группами атрибутов в меню
 */
function dsa_add_attribute_groups_menu() {
    add_submenu_page(
        'woocommerce',
        'Группы атрибутов',
        'Группы атрибутов',
        'manage_woocommerce',
        'dsa-attribute-groups',
        'dsa_attribute_groups_page'
    );
}
add_action('admin_menu', 'dsa_add_attribute_groups_menu');

/**
 * Получение списка групп из базы данных
 */
function dsa_get_attribute_groups() {
    $groups = get_option('dsa_attribute_groups', []);
    
    // Дефолтные группы при первом запуске
    if (empty($groups)) {
        $groups = [
            'power_electric' => [
                'name' => 'Мощность и электропараметры',
                'order' => 1
            ],
            'engine' => [
                'name' => 'Двигатель',
                'order' => 2
            ],
            'fuel' => [
                'name' => 'Топливная система',
                'order' => 3
            ],
            'generator' => [
                'name' => 'Генератор переменного тока',
                'order' => 4
            ],
            'dimensions' => [
                'name' => 'Габариты и вес',
                'order' => 5
            ],
            'general' => [
                'name' => 'Общие характеристики',
                'order' => 6
            ]
        ];
        update_option('dsa_attribute_groups', $groups);
    }
    
    return $groups;
}

/**
 * Сохранение группы атрибутов
 */
function dsa_save_attribute_group($group_id, $group_data) {
    $groups = dsa_get_attribute_groups();
    $groups[$group_id] = $group_data;
    update_option('dsa_attribute_groups', $groups);
}

/**
 * Удаление группы атрибутов
 */
function dsa_delete_attribute_group($group_id) {
    $groups = dsa_get_attribute_groups();
    unset($groups[$group_id]);
    update_option('dsa_attribute_groups', $groups);
    
    // Обновляем атрибуты, которые были в этой группе
    $all_attributes = wc_get_attribute_taxonomies();
    foreach ($all_attributes as $attribute) {
        $meta = dsa_get_attribute_meta('pa_' . $attribute->attribute_name);
        if (isset($meta['group_id']) && $meta['group_id'] === $group_id) {
            $meta['group_id'] = '';
            $meta['group'] = 'Без группы';
            update_option("dsa_attribute_meta_pa_{$attribute->attribute_name}", $meta);
        }
    }
}

/**
 * Страница управления группами атрибутов
 */
function dsa_attribute_groups_page() {
    if (!current_user_can('manage_woocommerce')) {
        wp_die('Недостаточно прав доступа');
    }
    
    // Обработка действий
    if (isset($_POST['action'])) {
        check_admin_referer('dsa_attribute_groups');
        
        switch ($_POST['action']) {
            case 'add_group':
                $group_id = sanitize_key($_POST['group_id']);
                $group_name = sanitize_text_field($_POST['group_name']);
                $group_order = intval($_POST['group_order']);
                
                if ($group_id && $group_name) {
                    dsa_save_attribute_group($group_id, [
                        'name' => $group_name,
                        'order' => $group_order
                    ]);
                    echo '<div class="notice notice-success"><p>✅ Группа добавлена</p></div>';
                }
                break;
                
            case 'delete_group':
                $group_id = sanitize_key($_POST['group_id']);
                if ($group_id) {
                    dsa_delete_attribute_group($group_id);
                    echo '<div class="notice notice-success"><p>✅ Группа удалена</p></div>';
                }
                break;
                
            case 'update_attribute':
                $attribute_name = sanitize_text_field($_POST['attribute_name']);
                $group_id = sanitize_key($_POST['group_id']);
                $note = sanitize_textarea_field($_POST['note']);
                $unit = sanitize_text_field($_POST['unit']);
                $visible = isset($_POST['visible']) ? true : false;
                
                $groups = dsa_get_attribute_groups();
                $group_name = isset($groups[$group_id]) ? $groups[$group_id]['name'] : 'Без группы';
                
                update_option("dsa_attribute_meta_{$attribute_name}", [
                    'group_id' => $group_id,
                    'group' => $group_name,
                    'note' => $note,
                    'unit' => $unit,
                    'visible' => $visible,
                    'filterable' => get_option("dsa_attribute_meta_{$attribute_name}")['filterable'] ?? false
                ]);
                
                echo '<div class="notice notice-success"><p>✅ Атрибут обновлен</p></div>';
                break;
        }
    }
    
    $groups = dsa_get_attribute_groups();
    $all_attributes = wc_get_attribute_taxonomies();
    
    ?>
    <div class="wrap">
        <h1>🎨 Управление группами атрибутов</h1>
        <p>Управляйте группировкой атрибутов для отображения на странице товара</p>
        
        <hr>
        
        <!-- Добавление новой группы -->
        <div class="card" style="max-width: 600px;">
            <h2>➕ Добавить новую группу</h2>
            <form method="post">
                <?php wp_nonce_field('dsa_attribute_groups'); ?>
                <input type="hidden" name="action" value="add_group">
                
                <table class="form-table">
                    <tr>
                        <th><label for="group_id">ID группы (slug)</label></th>
                        <td>
                            <input type="text" id="group_id" name="group_id" class="regular-text" required 
                                   pattern="[a-z0-9_-]+" placeholder="power_params">
                            <p class="description">Только латиница, цифры, дефис и подчеркивание</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="group_name">Название группы</label></th>
                        <td>
                            <input type="text" id="group_name" name="group_name" class="regular-text" required 
                                   placeholder="Мощность и параметры">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="group_order">Порядок отображения</label></th>
                        <td>
                            <input type="number" id="group_order" name="group_order" value="1" min="1" max="100">
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <button type="submit" class="button button-primary">Добавить группу</button>
                </p>
            </form>
        </div>
        
        <hr>
        
        <!-- Список существующих групп -->
        <h2>📋 Существующие группы</h2>
        <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                    <th>ID</th>
                        <th>Название</th>
                    <th>Порядок</th>
                    <th>Атрибутов</th>
                    <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
    <?php
                // Сортируем группы по порядку
                uasort($groups, function($a, $b) {
                    return ($a['order'] ?? 999) - ($b['order'] ?? 999);
                });
                
                foreach ($groups as $group_id => $group_data) :
                    // Считаем количество атрибутов в группе
                    $attr_count = 0;
                    foreach ($all_attributes as $attr) {
                        $meta = dsa_get_attribute_meta('pa_' . $attr->attribute_name);
                        if (($meta['group_id'] ?? '') === $group_id) {
                            $attr_count++;
                        }
                    }
                ?>
                <tr>
                    <td><code><?php echo esc_html($group_id); ?></code></td>
                    <td><strong><?php echo esc_html($group_data['name']); ?></strong></td>
                    <td><?php echo esc_html($group_data['order'] ?? 999); ?></td>
                    <td><?php echo $attr_count; ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <?php wp_nonce_field('dsa_attribute_groups'); ?>
                            <input type="hidden" name="action" value="delete_group">
                            <input type="hidden" name="group_id" value="<?php echo esc_attr($group_id); ?>">
                            <button type="submit" class="button button-small" 
                                    onclick="return confirm('Удалить группу? Атрибуты останутся, но потеряют группировку.')">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <hr>
        
        <!-- Настройка атрибутов -->
        <h2>⚙️ Настройка атрибутов</h2>
        <p>Назначьте атрибуты в группы и настройте их отображение</p>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th style="width: 20%;">Атрибут</th>
                    <th style="width: 20%;">Группа</th>
                    <th style="width: 30%;">Примечание</th>
                    <th style="width: 10%;">Единица</th>
                    <th style="width: 10%;">Видимость</th>
                    <th style="width: 10%;">Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_attributes as $attribute) :
                    $attr_name = 'pa_' . $attribute->attribute_name;
                    $meta = dsa_get_attribute_meta($attr_name);
                ?>
                <tr>
                    <form method="post">
                        <?php wp_nonce_field('dsa_attribute_groups'); ?>
                        <input type="hidden" name="action" value="update_attribute">
                        <input type="hidden" name="attribute_name" value="<?php echo esc_attr($attr_name); ?>">
                        
                        <td>
                            <strong><?php echo esc_html($attribute->attribute_label); ?></strong><br>
                            <code><?php echo esc_html($attr_name); ?></code>
                        </td>
                        
                        <td>
                            <select name="group_id" class="regular-text">
                                <option value="">Без группы</option>
                                <?php foreach ($groups as $gid => $gdata) : ?>
                                <option value="<?php echo esc_attr($gid); ?>" 
                                        <?php selected($meta['group_id'] ?? '', $gid); ?>>
                                    <?php echo esc_html($gdata['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" name="note" class="regular-text" 
                                   value="<?php echo esc_attr($meta['note'] ?? ''); ?>"
                                   placeholder="Краткое описание">
                        </td>
                        
                        <td>
                            <input type="text" name="unit" class="small-text" 
                                   value="<?php echo esc_attr($meta['unit'] ?? ''); ?>"
                                   placeholder="кВт">
                        </td>
                        
                        <td>
                            <label>
                                <input type="checkbox" name="visible" 
                                       <?php checked($meta['visible'] ?? true); ?>>
                                Показывать
                            </label>
                        </td>
                        
                        <td>
                            <button type="submit" class="button button-small button-primary">
                                Сохранить
                            </button>
                        </td>
                    </form>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            
            <hr>
            
        <div class="card" style="max-width: 800px; background: #f0f6fc;">
            <h3>💡 Справка</h3>
            <ul>
                <li><strong>Группа:</strong> Атрибуты с одной группой будут отображаться вместе на странице товара</li>
                <li><strong>Примечание:</strong> Краткое описание атрибута (tooltip при наведении)</li>
                <li><strong>Единица:</strong> Добавляется к значению автоматически (например: "кВт", "л", "кг")</li>
                <li><strong>Видимость:</strong> Скрытые атрибуты не отображаются на странице товара</li>
                <li><strong>Порядок отображения:</strong> Группы с меньшим числом показываются выше</li>
            </ul>
        </div>
    </div>
    
    <style>
        .wp-list-table input[type="text"],
        .wp-list-table select {
            width: 100%;
        }
        .wp-list-table .small-text {
            width: 80px;
        }
    </style>
    <?php
}

// ============================================
// WOOCOMMERCE: БАЗОВАЯ НАСТРОЙКА
// ============================================

/**
 * Добавление поддержки WooCommerce
 */

// ============================================
// CONTACT FORM 7: НАСТРОЙКИ
// ============================================

/**
 * Отключение автоматического добавления тегов <p> и <br> в Contact Form 7
 * Это необходимо для корректной работы с кастомной версткой модального окна
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Удаление лишних тегов из вывода CF7
 */
add_filter('wpcf7_form_elements', function($content) {
    // Удаляем пустые теги <p>
    $content = preg_replace('/<p>\s*<\/p>/i', '', $content);
    // Удаляем одиночные <br>
    $content = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/i', '', $content);
    return $content;
});
