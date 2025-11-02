<?php
/**
 * ============================================
 * DSA GENERATORS THEME - FUNCTIONS
 * ============================================
 * 
 * Основной файл функций темы WordPress для DSA Generators.
 * Код разбит на логические модули для улучшения читаемости и поддержки.
 * 
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// ============================================
// СТРУКТУРА МОДУЛЕЙ ТЕМЫ
// ============================================
/**
 * Документация: см. /inc/README.md
 * 
 * ОСНОВНЫЕ МОДУЛИ:
 * ├─ theme-setup.php          → Базовая настройка темы
 * ├─ menu-walkers.php         → Кастомные Walker для меню
 * ├─ assets.php               → Стили и скрипты
 * ├─ breadcrumbs.php          → Хлебные крошки
 * ├─ custom-post-types.php    → CPT (проекты, тендеры)
 * ├─ acf-integration.php      → Advanced Custom Fields
 * ├─ projects-functions.php   → Функции проектов
 * └─ contact-form-7.php       → Contact Form 7
 * 
 * WOOCOMMERCE МОДУЛИ (/inc/woocommerce/):
 * ├─ wc-setup.php             → Базовая настройка WC
 * ├─ wc-catalog.php           → Каталог и фильтры
 * ├─ wc-ajax.php              → AJAX обработчики
 * ├─ wc-cart-checkout.php     → Корзина и оформление
 * ├─ wc-attributes.php        → Система атрибутов
 * └─ wc-admin.php             → Админ функции
 */

// ============================================
// ПОДКЛЮЧЕНИЕ ОСНОВНЫХ МОДУЛЕЙ
// ============================================

// Базовая настройка темы
require_once get_template_directory() . '/inc/theme-setup.php';

// Кастомные Walker для меню
require_once get_template_directory() . '/inc/menu-walkers.php';

// Управление assets (стили и скрипты)
require_once get_template_directory() . '/inc/assets.php';

// Хлебные крошки
require_once get_template_directory() . '/inc/breadcrumbs.php';

// Пользовательские типы записей
require_once get_template_directory() . '/inc/custom-post-types.php';

// Интеграция ACF
require_once get_template_directory() . '/inc/acf-integration.php';

// Функции для проектов
require_once get_template_directory() . '/inc/projects-functions.php';

// Функции поиска
require_once get_template_directory() . '/inc/search-functions.php';

// Функции новостей
require_once get_template_directory() . '/inc/news-functions.php';

// Генератор тестовых новостей (только для админов)
if (is_admin()) {
    require_once get_template_directory() . '/inc/news-generator.php';
}
        
// ============================================
// ПОДКЛЮЧЕНИЕ WOOCOMMERCE МОДУЛЕЙ
// ============================================

if (class_exists('WooCommerce')) {
    // Базовая настройка WooCommerce
    require_once get_template_directory() . '/inc/woocommerce/wc-setup.php';
    
    // Каталог и фильтры
    require_once get_template_directory() . '/inc/woocommerce/wc-catalog.php';
    
    // AJAX обработчики
    require_once get_template_directory() . '/inc/woocommerce/wc-ajax.php';
    
    // Корзина и оформление заказа
    require_once get_template_directory() . '/inc/woocommerce/wc-cart-checkout.php';
    
    // Система атрибутов
    require_once get_template_directory() . '/inc/woocommerce/wc-attributes.php';
    
    // Административные функции
    require_once get_template_directory() . '/inc/woocommerce/wc-admin.php';
    
    // Импортер товаров (только для админов)
    if (is_admin()) {
        require_once get_template_directory() . '/inc/product-importer.php';
    }
}
        
// ============================================
// ПОДКЛЮЧЕНИЕ МОДУЛЕЙ ПЛАГИНОВ
// ============================================

// Contact Form 7
if (function_exists('wpcf7')) {
    require_once get_template_directory() . '/inc/contact-form-7.php';
}

// ============================================
// ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
// ============================================

/**
 * Проверка существования модуля перед подключением
 * Используется для отладки
 * 
 * @param string $module_path Путь к модулю относительно темы
 * @return bool
 */
function dsa_check_module_exists($module_path) {
    $full_path = get_template_directory() . $module_path;
    if (!file_exists($full_path)) {
        error_log("DSA Theme: Модуль не найден - {$module_path}");
        return false;
    }
    return true;
}

/**
 * Получение версии темы
 * 
 * @return string
 */
function dsa_get_theme_version() {
    $theme = wp_get_theme();
    return $theme->get('Version');
}

// ============================================
// ИНФОРМАЦИЯ О ТЕМЕ (только для админки)
// ============================================

if (is_admin()) {
    add_action('admin_notices', function() {
        // Проверка наличия обязательных плагинов
        $missing_plugins = array();
        
    if (!class_exists('WooCommerce')) {
            $missing_plugins[] = 'WooCommerce';
        }
        
        if (!function_exists('get_field')) {
            $missing_plugins[] = 'Advanced Custom Fields PRO';
        }
        
        if (!empty($missing_plugins) && current_user_can('activate_plugins')) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p><strong>DSA Generators:</strong> Для полной функциональности темы требуются следующие плагины: ';
            echo implode(', ', $missing_plugins);
            echo '</p></div>';
        }
    });
}
