<?php
/**
 * ACF INTEGRATION
 * Интеграция с Advanced Custom Fields
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

// Автоматический импорт ACF полей из JSON
add_filter('acf/settings/save_json', function($path) {
    return get_stylesheet_directory() . '/acf-exports';
});

add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-exports';
    return $paths;
});

// Регистрация ACF Options Page
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
