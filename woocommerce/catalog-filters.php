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
?>

<div class="catalog-filters">
    <div class="catalog-filters__header">
        <div class="catalog-filters__header-left">
            <!-- Сортировка WooCommerce -->
            <?php woocommerce_catalog_ordering(); ?>
            
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
            <div class="catalog-filters__grid">
                
                <!-- Фильтр по мощности -->
                <div class="catalog-filters__group">
                    <label for="power-filter" class="catalog-filters__group-label">Мощность номинал., кВт</label>
                    <select id="power-filter" name="filter_power" class="catalog-filters__select">
                        <option value="">Все</option>
                        <option value="16-40" <?php selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', '16-40'); ?>>16-40 кВт</option>
                        <option value="40-100" <?php selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', '40-100'); ?>>40-100 кВт</option>
                        <option value="100-200" <?php selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', '100-200'); ?>>100-200 кВт</option>
                        <option value="200-500" <?php selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', '200-500'); ?>>200-500 кВт</option>
                        <option value="500-1000" <?php selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', '500-1000'); ?>>500-1000 кВт</option>
                        <option value="1000-2000" <?php selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', '1000-2000'); ?>>1000-2000 кВт</option>
                        <option value="2000-3000" <?php selected(isset($_GET['filter_power']) ? $_GET['filter_power'] : '', '2000-3000'); ?>>2000-3000 кВт</option>
                    </select>
                </div>

                <!-- Фильтр по двигателю -->
                <div class="catalog-filters__group">
                    <label for="engine-filter" class="catalog-filters__group-label">Двигатель</label>
                    <select id="engine-filter" name="filter_engine" class="catalog-filters__select">
                        <option value="">Все</option>
                        <option value="cummins" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'cummins'); ?>>Cummins</option>
                        <option value="perkins" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'perkins'); ?>>Perkins</option>
                        <option value="doosan" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'doosan'); ?>>Doosan</option>
                        <option value="mtu" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'mtu'); ?>>MTU</option>
                        <option value="caterpillar" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'caterpillar'); ?>>Caterpillar</option>
                        <option value="man" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'man'); ?>>MAN</option>
                        <option value="volvo" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'volvo'); ?>>Volvo</option>
                        <option value="deutz" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'deutz'); ?>>Deutz</option>
                        <option value="scania" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'scania'); ?>>Scania</option>
                        <option value="john-deere" <?php selected(isset($_GET['filter_engine']) ? $_GET['filter_engine'] : '', 'john-deere'); ?>>John Deere</option>
                    </select>
                </div>

                <!-- Фильтр по производителю -->
                <div class="catalog-filters__group">
                    <label for="manufacturer-filter" class="catalog-filters__group-label">Производитель</label>
                    <select id="manufacturer-filter" name="filter_manufacturer" class="catalog-filters__select">
                        <option value="">Все</option>
                        <option value="dsa" <?php selected(isset($_GET['filter_manufacturer']) ? $_GET['filter_manufacturer'] : '', 'dsa'); ?>>DSA Generators</option>
                        <option value="aksa" <?php selected(isset($_GET['filter_manufacturer']) ? $_GET['filter_manufacturer'] : '', 'aksa'); ?>>AKSA</option>
                        <option value="ctm" <?php selected(isset($_GET['filter_manufacturer']) ? $_GET['filter_manufacturer'] : '', 'ctm'); ?>>CTM</option>
                        <option value="emsa" <?php selected(isset($_GET['filter_manufacturer']) ? $_GET['filter_manufacturer'] : '', 'emsa'); ?>>EMSA</option>
                        <option value="energo" <?php selected(isset($_GET['filter_manufacturer']) ? $_GET['filter_manufacturer'] : '', 'energo'); ?>>Energo</option>
                    </select>
                </div>

                <!-- Фильтр по стране -->
                <div class="catalog-filters__group">
                    <label for="country-filter" class="catalog-filters__group-label">Страна</label>
                    <select id="country-filter" name="filter_country" class="catalog-filters__select">
                        <option value="">Все</option>
                        <option value="russia" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'russia'); ?>>Россия</option>
                        <option value="germany" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'germany'); ?>>Германия</option>
                        <option value="usa" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'usa'); ?>>США</option>
                        <option value="uk" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'uk'); ?>>Великобритания</option>
                        <option value="italy" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'italy'); ?>>Италия</option>
                        <option value="spain" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'spain'); ?>>Испания</option>
                        <option value="turkey" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'turkey'); ?>>Турция</option>
                        <option value="china" <?php selected(isset($_GET['filter_country']) ? $_GET['filter_country'] : '', 'china'); ?>>Китай</option>
                    </select>
                </div>

                <!-- Фильтр по номинальной мощности -->
                <div class="catalog-filters__group">
                    <label for="nominal-power-filter" class="catalog-filters__group-label">Номинальная мощность</label>
                    <select id="nominal-power-filter" name="filter_nominal_power" class="catalog-filters__select">
                        <option value="">Все</option>
                        <?php
                        $power_values = [16, 20, 30, 40, 50, 60, 80, 100, 150, 200, 250, 300, 400, 500, 600, 800, 1000, 1200, 1500, 2000, 2500, 3000];
                        foreach ($power_values as $power) {
                            $selected = selected(isset($_GET['filter_nominal_power']) ? $_GET['filter_nominal_power'] : '', $power, false);
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
