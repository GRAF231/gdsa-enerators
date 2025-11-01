<?php
/**
 * WOOCOMMERCE НАСТРОЙКА
 * Базовая настройка WooCommerce
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

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
            
            // Стили для пустых результатов
            $error_css = $theme_dir . '/assets/css/error-404.css';
            if (file_exists($error_css)) {
                wp_enqueue_style('dsa-error-404', $theme_uri . '/assets/css/error-404.css', array(), filemtime($error_css));
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

// Отключаем стандартные хлебные крошки WooCommerce
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

