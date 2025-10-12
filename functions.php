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

// Автоматический импорт ACF полей из JSON
add_filter('acf/settings/save_json', function($path) {
    return get_stylesheet_directory() . '/acf-exports';
});

add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-exports';
    return $paths;
});
