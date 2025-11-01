<?php
/**
 * WOOCOMMERCE AJAX
 * AJAX обработчики для корзины и товаров
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
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
