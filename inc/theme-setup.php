<?php
/**
 * THEME SETUP
 * Базовая настройка темы WordPress
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Поддержка функций темы
 */
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
