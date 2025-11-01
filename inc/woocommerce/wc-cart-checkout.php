<?php
/**
 * WOOCOMMERCE КОРЗИНА & CHECKOUT
 * Унифицированная корзина и оформление заказа
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

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
