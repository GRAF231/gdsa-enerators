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
    $css_dir = get_template_directory() . '/assets/css/';
    $js_dir = get_template_directory() . '/assets/js/';

    // Enqueue styles
    $css_files = glob( $css_dir . '*.css' );
    foreach ( $css_files as $file ) {
        $handle = 'dsa-' . sanitize_title( basename( $file, '.css' ) );
        $src = $theme_uri . '/assets/css/' . basename( $file );
        wp_enqueue_style( $handle, $src );
    }

    $css_sub_dirs = glob( $css_dir . '*', GLOB_ONLYDIR );
    foreach ($css_sub_dirs as $dir) {
        $css_files = glob( $dir . '/*.css' );
        foreach ( $css_files as $file ) {
            $handle = 'dsa-' . sanitize_title( basename( $dir ) ) . '-' . sanitize_title( basename( $file, '.css' ) );
            $src = $theme_uri . '/assets/css/' . basename($dir) . '/' . basename( $file );
            wp_enqueue_style( $handle, $src );
        }
    }


    // Enqueue scripts
    $js_files = glob( $js_dir . '*.js' );
    foreach ( $js_files as $file ) {
        $handle = 'dsa-' . sanitize_title( basename( $file, '.js' ) );
        $src = $theme_uri . '/assets/js/' . basename( $file );
        wp_enqueue_script( $handle, $src, array(), false, true );
    }

    $js_sub_dirs = glob( $js_dir . '*', GLOB_ONLYDIR );
    foreach ($js_sub_dirs as $dir) {
        $js_files = glob( $dir . '/*.js' );
        foreach ( $js_files as $file ) {
            $handle = 'dsa-' . sanitize_title( basename( $dir ) ) . '-' . sanitize_title( basename( $file, '.js' ) );
            $src = $theme_uri . '/assets/js/' . basename($dir) . '/' . basename( $file );
            wp_enqueue_script( $handle, $src, array(), false, true );
        }
    }

    // Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' );

    // Google Fonts
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap', array(), null );

}
add_action( 'wp_enqueue_scripts', 'dsa_generators_assets' );

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
// add_filter('acf/settings/save_json', function($path) {
//     return get_stylesheet_directory() . '/acf-exports';
// });

// add_filter('acf/settings/load_json', function($paths) {     unset($paths[0]);
//     $paths[] = get_stylesheet_directory() . '/acf-exports';
//     return $paths;
// }); 
 