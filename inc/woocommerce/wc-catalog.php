<?php
/**
 * WOOCOMMERCE КАТАЛОГ
 * Функции каталога, фильтров и пагинации
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// WOOCOMMERCE CATALOG FUNCTIONS
// ============================================

/**
 * Применение кастомных фильтров к каталогу WooCommerce
 * 
 * @param WP_Query $query Объект запроса
 */
function dsa_apply_catalog_filters($query) {
    // Применяем только к основному запросу товаров на странице каталога
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag())) {
        
        // ВАЖНО: Очищаем встроенные WooCommerce фильтры, которые могут конфликтовать
        $existing_tax_query = $query->get('tax_query') ?: [];
        $clean_tax_query = [];
        
        // Оставляем только системные фильтры WooCommerce (product_visibility, product_cat и т.д.)
        // Удаляем любые фильтры по атрибутам, чтобы избежать конфликта
        if (!empty($existing_tax_query)) {
            foreach ($existing_tax_query as $key => $tax) {
                if ($key === 'relation') {
                    continue; // Пропускаем ключ relation
                }
                
                // Оставляем только НЕ-атрибутные таксономии
                if (isset($tax['taxonomy']) && 
                    !taxonomy_is_product_attribute($tax['taxonomy']) &&
                    strpos($tax['taxonomy'], 'pa_') !== 0) {
                    $clean_tax_query[] = $tax;
                }
            }
        }
        
        $tax_query = $clean_tax_query;
        
        // Фильтр по мощности (диапазон) - используем числовую фильтрацию через термины
        if (!empty($_GET['filter_power'])) {
            $power_range = sanitize_text_field(urldecode($_GET['filter_power']));
            
            // Разбираем диапазон типа "16-40"
            if (preg_match('/^(\d+)-(\d+)$/', $power_range, $matches)) {
                $min_power = intval($matches[1]);
                $max_power = intval($matches[2]);
                
                // Получаем все термины мощности в диапазоне
                $power_taxonomy = wc_attribute_taxonomy_name('power');
                $terms = get_terms([
                    'taxonomy' => $power_taxonomy,
                    'hide_empty' => true,
                ]);
                
                $valid_term_slugs = [];
                if (!is_wp_error($terms) && !empty($terms)) {
                    foreach ($terms as $term) {
                        $power_value = intval($term->name);
                        if ($power_value >= $min_power && $power_value < $max_power) {
                            $valid_term_slugs[] = $term->slug;
                        }
                    }
                }
                
                if (!empty($valid_term_slugs)) {
                    $tax_query[] = [
                        'taxonomy' => $power_taxonomy,
                        'field' => 'slug',
                        'terms' => $valid_term_slugs,
                        'operator' => 'IN'
                    ];
                }
            }
        }
        
        // Фильтр по производителю двигателя
        if (!empty($_GET['filter_engine'])) {
            $engine_slug = sanitize_text_field(urldecode($_GET['filter_engine']));
            
            $tax_query[] = [
                'taxonomy' => wc_attribute_taxonomy_name('engine_manufacturer'),
                'field' => 'slug',
                'terms' => $engine_slug
            ];
        }
        
        // Фильтр по стране сборки
        if (!empty($_GET['filter_country'])) {
            $country_slug = sanitize_text_field(urldecode($_GET['filter_country']));
            
            $tax_query[] = [
                'taxonomy' => wc_attribute_taxonomy_name('country'),
                'field' => 'slug',
                'terms' => $country_slug
            ];
        }
        
        // Фильтр по номинальной мощности (точное значение)
        if (!empty($_GET['filter_power_exact'])) {
            $exact_power = sanitize_text_field(urldecode($_GET['filter_power_exact']));
            
            $tax_query[] = [
                'taxonomy' => wc_attribute_taxonomy_name('power'),
                'field' => 'name',
                'terms' => $exact_power
            ];
        }
        
        // Применяем таксономические запросы
        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND';
            $query->set('tax_query', $tax_query);
        }
    }
}
add_action('pre_get_posts', 'dsa_apply_catalog_filters', 20);

/**
 * Отключаем автоматические WooCommerce query vars для атрибутов
 * чтобы избежать конфликта с нашими кастомными фильтрами
 */
function dsa_disable_wc_attribute_query_vars($query_vars) {
    // Удаляем автоматические query vars для атрибутов
    global $wp_query;
    
    // Получаем все атрибуты продуктов
    $attribute_taxonomies = wc_get_attribute_taxonomies();
    
    if (!empty($attribute_taxonomies)) {
        foreach ($attribute_taxonomies as $tax) {
            $attribute = wc_attribute_taxonomy_name($tax->attribute_name);
            $query_var = 'filter_' . $tax->attribute_name;
            
            // Удаляем из query_vars, если это наши кастомные параметры
            if (isset($_GET[$query_var])) {
                unset($query_vars[$query_var]);
            }
        }
    }
    
    return $query_vars;
}
add_filter('woocommerce_get_layered_nav_chosen_attributes', '__return_empty_array', 99);

/**
 * Кастомная пагинация WooCommerce с нашими стилями
 */
function dsa_woocommerce_pagination() {
    if (!wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
        return;
    }

    $total   = wc_get_loop_prop('total_pages');
    $current = wc_get_loop_prop('current_page');

    // Сохраняем параметры в пагинации
    $view = dsa_get_catalog_view();
    
    // Функция для генерации URL страницы
    $get_page_link = function($page) use ($view) {
        if (is_shop()) {
            $link = get_permalink(wc_get_page_id('shop'));
        } elseif (is_product_category()) {
            $link = get_term_link(get_queried_object());
        } elseif (is_product_tag()) {
            $link = get_term_link(get_queried_object());
        } else {
            $link = get_permalink();
        }
        
        // Добавляем номер страницы
        if ($page > 1) {
            $link = trailingslashit($link) . 'page/' . $page . '/';
        }
        
        // Собираем все параметры из текущего URL для сохранения
        $params_to_keep = array();
        
        // Параметр вида
        if (!empty($view)) {
            $params_to_keep['view'] = $view;
        }
        
        // Параметры фильтров
        $filter_params = array('filter_power', 'filter_engine', 'filter_manufacturer', 'filter_country', 'filter_power_exact', 'orderby');
        foreach ($filter_params as $param) {
            if (!empty($_GET[$param])) {
                $params_to_keep[$param] = sanitize_text_field($_GET[$param]);
            }
        }
        
        // Добавляем все параметры к ссылке
        if (!empty($params_to_keep)) {
            $link = add_query_arg($params_to_keep, $link);
        }
        
        return $link;
    };
    
    echo '<div class="pagination">';
    
    // Блок "Выводить по" - показываем всегда
    echo '<div class="pagination__per-page">';
    echo '<span class="pagination__per-page-label">Выводить по:</span>';
    echo '<div class="pagination__per-page-buttons">';
    $per_page_options = array(50, 100, 200, 500);
    $current_per_page = wc_get_loop_prop('per_page');
    foreach ($per_page_options as $option) {
        $active_class = ($option == $current_per_page) ? ' pagination__per-page-btn_active' : '';
        echo '<button class="pagination__per-page-btn' . $active_class . '" type="button" data-per-page="' . $option . '">' . $option . '</button>';
    }
    echo '</div>';
    echo '</div>';
    
    // Если страница только одна, не показываем навигацию
    if ($total <= 1) {
        echo '</div>'; // pagination
        return;
    }
    
    echo '<div class="pagination__nav">';
    
    // Кнопка "Предыдущая"
    if ($current > 1) {
        $prev_link = $get_page_link($current - 1);
        echo '<a href="' . esc_url($prev_link) . '" class="pagination__btn pagination__btn_prev">';
        echo '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>';
        echo '<span>Предыдущая</span>';
        echo '</a>';
    } else {
        echo '<button class="pagination__btn pagination__btn_prev" type="button" disabled>';
        echo '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>';
        echo '<span>Предыдущая</span>';
        echo '</button>';
    }
    
    // Номера страниц
    echo '<div class="pagination__pages">';
    
    $range = 2; // Сколько страниц показывать по бокам от текущей
    
    // Первая страница
    if ($current > $range + 2) {
        $link = $get_page_link(1);
        echo '<a href="' . esc_url($link) . '" class="pagination__page">1</a>';
        if ($current > $range + 3) {
            echo '<span class="pagination__dots">...</span>';
        }
    }
    
    // Страницы вокруг текущей
    for ($i = max(1, $current - $range); $i <= min($total, $current + $range); $i++) {
        if ($i == $current) {
            echo '<button class="pagination__page pagination__page_active" type="button">' . $i . '</button>';
        } else {
            $link = $get_page_link($i);
            echo '<a href="' . esc_url($link) . '" class="pagination__page">' . $i . '</a>';
        }
    }
    
    // Последняя страница
    if ($current < $total - $range - 1) {
        if ($current < $total - $range - 2) {
            echo '<span class="pagination__dots">...</span>';
        }
        $link = $get_page_link($total);
        echo '<a href="' . esc_url($link) . '" class="pagination__page">' . $total . '</a>';
    }
    
    echo '</div>'; // pagination__pages
    
    // Кнопка "Следующая"
    if ($current < $total) {
        $next_link = $get_page_link($current + 1);
        echo '<a href="' . esc_url($next_link) . '" class="pagination__btn pagination__btn_next">';
        echo '<span>Следующая</span>';
        echo '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
        echo '</a>';
    } else {
        echo '<button class="pagination__btn pagination__btn_next" type="button" disabled>';
        echo '<span>Следующая</span>';
        echo '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
        echo '</button>';
    }
    
    echo '</div>'; // pagination__nav
    echo '</div>'; // pagination
}

/**
 * Получение диапазонов мощности для группировки товаров
 * 
 * @return array Ассоциативный массив диапазонов
 */
function dsa_get_power_ranges() {
    return [
        '16-40' => ['name' => '16-40 кВт', 'min' => 16, 'max' => 40],
        '40-100' => ['name' => '40-100 кВт', 'min' => 40, 'max' => 100],
        '100-200' => ['name' => '100-200 кВт', 'min' => 100, 'max' => 200],
        '200-500' => ['name' => '200-500 кВт', 'min' => 200, 'max' => 500],
        '500-1000' => ['name' => '500-1000 кВт', 'min' => 500, 'max' => 1000],
        '1000-2000' => ['name' => '1000-2000 кВт', 'min' => 1000, 'max' => 2000],
        '2000-3000' => ['name' => '2000-3000 кВт', 'min' => 2000, 'max' => 3000],
    ];
}

/**
 * Получение мощности товара из атрибута WooCommerce
 * 
 * @param WC_Product $product Объект товара
 * @return int Мощность в кВт
 */
function dsa_get_product_power($product) {
    $power = dsa_get_product_attribute_value($product->get_id(), 'power');
    return $power ? intval($power) : 0;
}

/**
 * Определение группы мощности для товара
 * 
 * @param int $power Мощность в кВт
 * @return string|null Ключ группы или null
 */
function dsa_determine_power_group($power) {
    $ranges = dsa_get_power_ranges();
    
    foreach ($ranges as $key => $range) {
        if ($power >= $range['min'] && $power < $range['max']) {
            return $key;
        }
    }
    
    return null;
}

/**
 * Форматирование цены для каталога с кастомным классом
 * 
 * @param WC_Product $product Объект товара
 * @return string HTML цены с правильным форматированием
 */
function dsa_get_formatted_catalog_price($product) {
    $price = $product->get_price();
    
    // Если цена не установлена
    if (empty($price)) {
        return '<span class="catalog-product__price-text">Цена по запросу</span>';
    }
    
    // Форматируем цену: число с пробелами в тысячах
    $formatted_price = number_format((float)$price, 0, ',', ' ');
    
    // Возвращаем с нужным классом и символом рубля
    return '<span class="catalog-product__price-text">' . $formatted_price . ' ₽</span>';
}

/**
 * Вывод заголовков таблицы для табличного вида
 */
function dsa_catalog_table_header() {
    ?>
    <div class="catalog-table-header">
        <div class="catalog-table-header__col catalog-table-header__col_image"></div>
        <div class="catalog-table-header__col catalog-table-header__col_name">Название модели</div>
        <div class="catalog-table-header__col catalog-table-header__col_engine">Двигатель</div>
        <div class="catalog-table-header__col catalog-table-header__col_power">Мощность</div>
        <div class="catalog-table-header__col catalog-table-header__col_country">Страна сборки</div>
        <div class="catalog-table-header__col catalog-table-header__col_price">Цена</div>
    </div>
    <?php
}

/**
 * Вывод товара в табличном виде
 * 
 * @param WC_Product $product Объект товара
 */
function dsa_render_catalog_product_list($product) {
    // Получение данных товара
    $product_id = $product->get_id();
    $title = $product->get_name();
    $permalink = $product->get_permalink();
    $image = $product->get_image('medium');
    $price = dsa_get_formatted_catalog_price($product);
    
    // Атрибуты WooCommerce
    $engine = dsa_get_product_attribute_value($product_id, 'engine') ?: '—';
    $power = dsa_get_product_attribute_value($product_id, 'power') ?: '—';
    $nominal_power = dsa_get_product_attribute_value($product_id, 'nominal_power') ?: '';
    $country = dsa_get_product_attribute_value($product_id, 'country') ?: '—';
    
    // Формат мощности
    $power_display = $power !== '—' ? $power . ' кВт' : '—';
    if ($nominal_power) {
        $power_display .= ' (' . $nominal_power . ' кВА)';
    }
    ?>
    <div class="catalog-product">
        <div class="catalog-product__image">
            <a href="<?php echo esc_url($permalink); ?>">
                <?php echo $image; ?>
            </a>
        </div>
        <div class="catalog-product__name">
            <h3 class="catalog-product__title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>
        </div>
        <div class="catalog-product__engine">
            <span class="catalog-product__engine-text"><?php echo esc_html($engine); ?></span>
        </div>
        <div class="catalog-product__power">
            <span class="catalog-product__power-text"><?php echo esc_html($power_display); ?></span>
        </div>
        <div class="catalog-product__country">
            <span class="catalog-product__country-text"><?php echo esc_html($country); ?></span>
        </div>
        <div class="catalog-product__price">
            <?php echo $price; ?>
        </div>
    </div>
    <?php
}

/**
 * Вывод товара в карточном виде
 * 
 * @param WC_Product $product Объект товара
 */
function dsa_render_catalog_product_cards($product) {
    // Получение данных товара
    $product_id = $product->get_id();
    $title = $product->get_name();
    $permalink = $product->get_permalink();
    $image = $product->get_image('medium', [ 'class' => 'catalog-product__img' ]);
    $price = dsa_get_formatted_catalog_price($product);
    
    // Атрибуты WooCommerce
    $engine = dsa_get_product_attribute_value($product_id, 'engine') ?: '—';
    $power = dsa_get_product_attribute_value($product_id, 'power') ?: '—';
    $nominal_power = dsa_get_product_attribute_value($product_id, 'nominal_power') ?: '';
    $country = dsa_get_product_attribute_value($product_id, 'country') ?: '—';
    
    // Формат мощности
    $power_display = $power !== '—' ? $power . ' кВт' : '—';
    if ($nominal_power) {
        $power_display .= ' (' . $nominal_power . ' кВА)';
    }
    ?>
    <div class="catalog-product">
        <div class="catalog-product__image">
            <a href="<?php echo esc_url($permalink); ?>" class="catalog-product__image-link">
                <?php echo $image; ?>
            </a>
        </div>
        <div class="catalog-product__content">
            <div class="catalog-product__header">
                <h3 class="catalog-product__title">
                    <a href="<?php echo esc_url($permalink); ?>" class="catalog-product__title-link">
                        <?php echo esc_html($title); ?>
                    </a>
                </h3>
                <div class="catalog-product__price">
                    <?php echo $price; ?>
                </div>
            </div>
            <div class="catalog-product__specs">
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-cog catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Двигатель:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($engine); ?></span>
                </div>
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-bolt catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Мощность:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($power_display); ?></span>
                </div>
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-flag catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Страна:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($country); ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Основная функция вывода каталога с группировкой по мощности
 * 
 * @param string $view Вид отображения ('list' или 'cards')
 */
function dsa_render_grouped_catalog_products($view = 'list') {
    global $wp_query;
    
    if (!$wp_query->have_posts()) {
        echo '<p class="woocommerce-info">Товары не найдены.</p>';
        return;
    }
    
    // Получаем все товары из текущего запроса
    $products = [];
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        $product = wc_get_product(get_the_ID());
        if ($product) {
            $products[] = $product;
        }
    }
    wp_reset_postdata();
    
    // Группируем товары по мощности
    $grouped_products = [];
    $ranges = dsa_get_power_ranges();
    
    // Инициализация групп
    foreach ($ranges as $key => $range) {
        $grouped_products[$key] = [
            'name' => 'Группа мощности ' . $range['name'],
            'products' => []
        ];
    }
    
    // Распределение товаров по группам
    foreach ($products as $product) {
        $power = dsa_get_product_power($product);
        $group_key = dsa_determine_power_group($power);
        
        if ($group_key && isset($grouped_products[$group_key])) {
            $grouped_products[$group_key]['products'][] = $product;
        }
    }
    
    // Вывод групп с товарами
    foreach ($grouped_products as $group_key => $group_data) {
        // Пропускаем пустые группы
        if (empty($group_data['products'])) {
            continue;
        }
        
        echo '<div class="catalog-group">';
        echo '<h2 class="catalog-group__title">' . esc_html($group_data['name']) . '</h2>';
        
        // Класс контейнера зависит от вида
        $products_class = $view === 'cards' ? 'catalog-products catalog-products_view_cards' : 'catalog-products';
        echo '<div class="' . esc_attr($products_class) . '">';
        
        // Вывод товаров
        foreach ($group_data['products'] as $product) {
            if ($view === 'cards') {
                dsa_render_catalog_product_cards($product);
            } else {
                dsa_render_catalog_product_list($product);
            }
        }
        
        echo '</div>'; // .catalog-products
        echo '</div>'; // .catalog-group
    }
}

/**
 * Определение текущего вида каталога (табличный или карточный)
 * 
 * @return string 'list' или 'cards'
 */
function dsa_get_catalog_view() {
    // 1. Проверить GET параметр (имеет приоритет)
    if (isset($_GET['view']) && in_array($_GET['view'], ['list', 'cards'])) {
        return sanitize_text_field($_GET['view']);
    }
    
    // 2. Проверить Cookie
    if (isset($_COOKIE['catalog_view']) && in_array($_COOKIE['catalog_view'], ['list', 'cards'])) {
        return sanitize_text_field($_COOKIE['catalog_view']);
    }
    
    // 3. Дефолтный вид - табличный
    return 'list';
}

/**
 * Установка cookie для вида каталога
 */
function dsa_set_catalog_view_cookie() {
    if (isset($_GET['view']) && in_array($_GET['view'], ['list', 'cards'])) {
        $view = sanitize_text_field($_GET['view']);
        setcookie('catalog_view', $view, time() + (86400 * 30), '/', '', false, false);
    }
}
add_action('init', 'dsa_set_catalog_view_cookie');

// Отключаем стандартную сортировку и счетчик результатов (используем кастомную)
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

// Заменяем стандартную пагинацию на кастомную
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action('woocommerce_after_shop_loop', 'dsa_woocommerce_pagination', 10);
