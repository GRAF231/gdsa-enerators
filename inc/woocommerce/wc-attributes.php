<?php
/**
 * WOOCOMMERCE АТРИБУТЫ
 * Система атрибутов для характеристик товаров
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
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
 * 
 * @param string $attribute_slug Slug атрибута
 * @param int|null $category_id ID категории для фильтрации (null = все товары)
 * @return array Массив уникальных значений
 */
function dsa_get_unique_attribute_values($attribute_slug, $category_id = null) {
    $taxonomy = wc_attribute_taxonomy_name($attribute_slug);
    
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false, // Получаем все термины для дальнейшей фильтрации
        'orderby' => 'name',
        'order' => 'ASC'
    ]);
    
    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }
    
    $values = [];
    foreach ($terms as $term) {
        // Считаем товары с этим термином
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                ]
            ]
        ];
        
        // Добавляем фильтр по категории если указана
        if ($category_id) {
            $args['tax_query']['relation'] = 'AND';
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
            ];
        }
        
        $query = new WP_Query($args);
        $count = $query->found_posts;
        
        // Показываем только термины с товарами
        if ($count > 0) {
            $values[] = [
                'slug' => $term->slug,
                'name' => $term->name,
                'count' => $count
            ];
        }
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
