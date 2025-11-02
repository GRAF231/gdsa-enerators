<?php
/**
 * CUSTOM POST TYPES
 * Регистрация пользовательских типов записей
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

// ⚠️ СКОПИРУЙТЕ КОД ИЗ functions.php.backup
// Секция: "Регистрация пользовательского типа записи "Проекты""
// До: "add_action('init', 'register_tender_cpt');"

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
        'has_archive' => 'tender', // Архив будет доступен по /tender/
        'supports' => ['title'],
        'rewrite' => ['slug' => 'tender', 'with_front' => false],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-gavel',
    ]);
}
add_action('init', 'register_tender_cpt');

// Блокируем доступ к отдельным страницам тендеров (редирект на архив)
function dsa_block_single_tender_pages() {
    if (is_singular('tender')) {
        wp_redirect(home_url('/tender/'), 301);
        exit;
    }
}
add_action('template_redirect', 'dsa_block_single_tender_pages');
