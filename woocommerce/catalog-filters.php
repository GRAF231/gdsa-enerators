<?php
/**
 * Catalog Filters Template
 * 
 * Панель фильтров для каталога WooCommerce с переключателем видов
 */

if (!defined('ABSPATH')) {
    exit;
}

// Текущий вид каталога
$current_view = dsa_get_catalog_view();
$list_class = $current_view === 'list' ? 'catalog-view-toggle__btn_active' : '';
$cards_class = $current_view === 'cards' ? 'catalog-view-toggle__btn_active' : '';

// Текущий URL для построения ссылок
$current_url = add_query_arg(null, null);
$list_url = add_query_arg('view', 'list', remove_query_arg('view'));
$cards_url = add_query_arg('view', 'cards', remove_query_arg('view'));

// Определяем текущую категорию
$current_category_id = null;
if (is_product_category()) {
    $current_category = get_queried_object();
    if ($current_category && isset($current_category->term_id)) {
        $current_category_id = $current_category->term_id;
    }
}

// Получаем динамические опции фильтров из атрибутов WooCommerce
// Названия берутся автоматически из терминов атрибутов
// Передаем текущую категорию для фильтрации опций
$power_ranges = dsa_get_power_ranges_with_counts($current_category_id);
$engine_options = dsa_get_filter_options('engine_manufacturer', [], $current_category_id);
$country_options = dsa_get_filter_options('country', [], $current_category_id);
$power_values = dsa_get_unique_product_field_values('power', $current_category_id);
?>

<div class="catalog-filters">
    <div class="catalog-filters__row">
        <!-- Сортировка -->
        <div class="catalog-filters__sort">
            <label for="catalog-sort-select" class="catalog-filters__label">Сортировка:</label>
            <select id="catalog-sort-select" class="catalog-filters__select" onchange="window.location.href=this.value;">
                <?php
                $orderby = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
                $current_view = dsa_get_catalog_view();
                
                $catalog_orderby_options = array(
                    'menu_order' => 'По умолчанию',
                    'popularity' => 'По популярности',
                    'rating'     => 'По рейтингу',
                    'date'       => 'Новинки',
                    'price'      => 'Цена: по возрастанию',
                    'price-desc' => 'Цена: по убыванию',
                );
                
                foreach ($catalog_orderby_options as $id => $name) {
                    // Строим URL с сохранением параметра view
                    $url = add_query_arg(array('orderby' => $id, 'view' => $current_view), remove_query_arg(array('orderby', 'view')));
                    echo '<option value="' . esc_url($url) . '" ' . selected($orderby, $id, false) . '>' . esc_html($name) . '</option>';
                }
                ?>
            </select>
        </div>
        
        <!-- Счетчик результатов -->
        <?php
        global $wp_query;
        $total = $wp_query->found_posts;
        $per_page = $wp_query->get('posts_per_page');
        $current = max(1, $wp_query->get('paged'));
        $first = ($per_page * $current) - $per_page + 1;
        $last = min($total, $wp_query->get('posts_per_page') * $current);
        ?>
        <div class="catalog-filters__result-count">
            Показано <?php echo $first; ?>–<?php echo $last; ?> из <?php echo $total; ?> товаров
        </div>
        
        <!-- Кнопка фильтра и переключатель вида -->
        <div class="catalog-filters__actions">
            <button class="catalog-filters__toggle-btn" type="button" aria-label="Показать фильтры" aria-expanded="false">
                <i class="fa-solid fa-filter catalog-filters__icon" aria-hidden="true"></i>
                <span>Фильтр</span>
            </button>
            
            <!-- Переключатель вида карточек -->
            <div class="catalog-view-toggle">
                <a href="<?php echo esc_url($cards_url); ?>" 
                   class="catalog-view-toggle__btn <?php echo $cards_class; ?>" 
                   aria-label="Карточный вид"
                   data-view="cards">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="1" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/>
                        <rect x="9" y="1" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/>
                        <rect x="1" y="9" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/>
                        <rect x="9" y="9" width="6" height="6" rx="1" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </a>
                <a href="<?php echo esc_url($list_url); ?>" 
                   class="catalog-view-toggle__btn <?php echo $list_class; ?>" 
                   aria-label="Табличный вид"
                   data-view="list">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="2" width="14" height="5" rx="1" stroke="currentColor" stroke-width="1.5"/>
                        <rect x="1" y="9" width="14" height="5" rx="1" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Панель фильтров -->
    <div class="catalog-filters__panel">
        <form class="catalog-filters__form" method="get" action="">
            <!-- Сохраняем текущий вид каталога -->
            <input type="hidden" name="view" value="<?php echo esc_attr($current_view); ?>">
            
            <div class="catalog-filters__grid">
                
                <!-- Фильтр по мощности -->
                <div class="catalog-filters__group">
                    <label for="power-filter" class="catalog-filters__group-label">Мощность номинал., кВт</label>
                    <select id="power-filter" name="filter_power" class="catalog-filters__select">
                        <option value="">Все</option>
                        <?php
                        foreach ($power_ranges as $range_key => $range_data) {
                            $selected = selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', $range_key, false);
                            echo '<option value="' . esc_attr($range_key) . '" ' . $selected . '>' . esc_html($range_data['name']) . ' (' . esc_html($range_data['count']) . ')</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Фильтр по двигателю -->
                <div class="catalog-filters__group">
                    <label for="engine-filter" class="catalog-filters__group-label">Производитель двигателя</label>
                    <select id="engine-filter" name="filter_engine" class="catalog-filters__select">
                        <option value="">Все</option>
                        <?php
                        foreach ($engine_options as $option) {
                            $selected = selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', $option['value'], false);
                            echo '<option value="' . esc_attr($option['value']) . '" ' . $selected . '>' . esc_html($option['label']) . ' (' . esc_html($option['count']) . ')</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Фильтр по стране -->
                <div class="catalog-filters__group">
                    <label for="country-filter" class="catalog-filters__group-label">Страна сборки</label>
                    <select id="country-filter" name="filter_country" class="catalog-filters__select">
                        <option value="">Все</option>
                        <?php
                        foreach ($country_options as $option) {
                            $selected = selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', $option['value'], false);
                            echo '<option value="' . esc_attr($option['value']) . '" ' . $selected . '>' . esc_html($option['label']) . ' (' . esc_html($option['count']) . ')</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Фильтр по номинальной мощности -->
                <div class="catalog-filters__group">
                    <label for="nominal-power-filter" class="catalog-filters__group-label">Номинальная мощность</label>
                    <select id="nominal-power-filter" name="filter_power_exact" class="catalog-filters__select">
                        <option value="">Все</option>
                        <?php
                        foreach ($power_values as $power) {
                            $selected = selected(isset($_GET['filter_power_exact']) ? $_GET['filter_power_exact'] : '', $power, false);
                            echo '<option value="' . esc_attr($power) . '" ' . $selected . '>' . esc_html($power) . ' кВт</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Кнопки управления фильтрами -->
            <div class="catalog-filters__actions">
                <button class="catalog-filters__reset-btn" type="button" onclick="window.location.href='<?php echo esc_url(strtok($_SERVER['REQUEST_URI'], '?')); ?>'">
                    <i class="fa-solid fa-rotate-left catalog-filters__icon" aria-hidden="true"></i>
                    <span>Сбросить</span>
                </button>
                <button class="catalog-filters__apply-btn btn btn_type_primary" type="submit">
                    <i class="fa-solid fa-check catalog-filters__icon" aria-hidden="true"></i>
                    <span>Применить</span>
                </button>
            </div>
        </form>
    </div>
</div>
