<?php
/**
 * ПРОЕКТЫ
 * Функции для работы с проектами и их фильтрацией
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Определение диапазона мощности для проекта на основе значения мощности
 * 
 * @param int $power Мощность в кВт
 * @return string Ключ диапазона мощности
 */
function dsa_determine_project_power_range($power) {
    if (!$power || $power < 16) {
        return '16-40';
    }
    
    $ranges = [
        '16-40' => ['min' => 16, 'max' => 40],
        '40-80' => ['min' => 40, 'max' => 80],
        '80-100' => ['min' => 80, 'max' => 100],
        '100-150' => ['min' => 100, 'max' => 150],
        '150-200' => ['min' => 150, 'max' => 200],
        '200-300' => ['min' => 200, 'max' => 300],
        '300-500' => ['min' => 300, 'max' => 500],
        '500-700' => ['min' => 500, 'max' => 700],
        '800-1000' => ['min' => 800, 'max' => 1000],
        '1000-1500' => ['min' => 1000, 'max' => 1500],
        '1500-2000' => ['min' => 1500, 'max' => 2000],
        '2000-3000' => ['min' => 2000, 'max' => 3000],
        '3000-6000' => ['min' => 3000, 'max' => 6000],
        '6000-12000' => ['min' => 6000, 'max' => 12000],
    ];
    
    foreach ($ranges as $key => $range) {
        if ($power >= $range['min'] && $power < $range['max']) {
            return $key;
        }
    }
    
    // Если мощность больше максимального диапазона
    return '6000-12000';
}

/**
 * Получение проектов с фильтрацией
 * 
 * @param array $args Параметры запроса
 * @return WP_Query Объект запроса WordPress
 */
function dsa_get_projects($args = []) {
    $defaults = [
        'post_type' => 'project',
        'posts_per_page' => -1, // Все проекты для фильтрации на клиенте
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    // Параметры фильтрации из GET
    $meta_query = [];
    
    // Фильтр по диапазону мощности
    if (isset($_GET['power']) && $_GET['power'] !== 'all') {
        $power_range = sanitize_text_field($_GET['power']);
        $ranges = [
            '16-40' => ['min' => 16, 'max' => 40],
            '40-80' => ['min' => 40, 'max' => 80],
            '80-100' => ['min' => 80, 'max' => 100],
            '100-150' => ['min' => 100, 'max' => 150],
            '150-200' => ['min' => 150, 'max' => 200],
            '200-300' => ['min' => 200, 'max' => 300],
            '300-500' => ['min' => 300, 'max' => 500],
            '500-700' => ['min' => 500, 'max' => 700],
            '800-1000' => ['min' => 800, 'max' => 1000],
            '1000-1500' => ['min' => 1000, 'max' => 1500],
            '1500-2000' => ['min' => 1500, 'max' => 2000],
            '2000-3000' => ['min' => 2000, 'max' => 3000],
            '3000-6000' => ['min' => 3000, 'max' => 6000],
            '6000-12000' => ['min' => 6000, 'max' => 12000],
        ];
        
        if (isset($ranges[$power_range])) {
            $meta_query[] = [
                'key' => 'power',
                'value' => [$ranges[$power_range]['min'], $ranges[$power_range]['max']],
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            ];
        }
    }
    
    // Фильтр по отрасли
    if (isset($_GET['industry']) && $_GET['industry'] !== 'all') {
        $meta_query[] = [
            'key' => 'industry',
            'value' => sanitize_text_field($_GET['industry']),
            'compare' => '=',
        ];
    }
    
    // Фильтр по городу
    if (isset($_GET['city']) && $_GET['city'] !== 'all') {
        $meta_query[] = [
            'key' => 'city',
            'value' => sanitize_text_field($_GET['city']),
            'compare' => '=',
        ];
    }
    
    // Фильтр по году
    if (isset($_GET['year']) && $_GET['year'] !== 'all') {
        $meta_query[] = [
            'key' => 'year',
            'value' => sanitize_text_field($_GET['year']),
            'compare' => '=',
        ];
    }
    
    if (!empty($meta_query)) {
        $defaults['meta_query'] = $meta_query;
    }
    
    $query_args = wp_parse_args($args, $defaults);
    
    return new WP_Query($query_args);
}

/**
 * Получение настроек фильтров из ACF с fallback на дефолтные значения
 * 
 * @return array Массив настроек фильтров
 */
function dsa_get_projects_filters() {
    // Получаем настройки из системных настроек сайта (options)
    $settings = get_field('projects_filters_settings', 'option');
    
    // Дефолтные значения фильтров
    $defaults = [
        'power' => [
            'enabled' => true,
            'label' => 'Диапазон мощности',
            'options' => [
                ['value' => '16-40', 'label' => '16-40 кВт', 'enabled' => true],
                ['value' => '40-80', 'label' => '40-80 кВт', 'enabled' => true],
                ['value' => '80-100', 'label' => '80-100 кВт', 'enabled' => true],
                ['value' => '100-150', 'label' => '100-150 кВт', 'enabled' => true],
                ['value' => '150-200', 'label' => '150-200 кВт', 'enabled' => true],
                ['value' => '200-300', 'label' => '200-300 кВт', 'enabled' => true],
                ['value' => '300-500', 'label' => '300-500 кВт', 'enabled' => true],
                ['value' => '500-700', 'label' => '500-700 кВт', 'enabled' => true],
                ['value' => '800-1000', 'label' => '800-1000 кВт', 'enabled' => true],
                ['value' => '1000-1500', 'label' => '1000-1500 кВт', 'enabled' => true],
                ['value' => '1500-2000', 'label' => '1500-2000 кВт', 'enabled' => true],
                ['value' => '2000-3000', 'label' => '2000-3000 кВт', 'enabled' => true],
                ['value' => '3000-6000', 'label' => '3000-6000 кВт', 'enabled' => true],
                ['value' => '6000-12000', 'label' => '6000-12000 кВт', 'enabled' => true],
            ]
        ],
        'industry' => [
            'enabled' => true,
            'label' => 'Отрасль применения',
            'options' => [
                ['value' => 'banks', 'label' => 'Банки', 'enabled' => true],
                ['value' => 'business_centers', 'label' => 'Бизнес-центры', 'enabled' => true],
                ['value' => 'commercial', 'label' => 'Коммерция', 'enabled' => true],
                ['value' => 'construction', 'label' => 'Строительство', 'enabled' => true],
                ['value' => 'data_centers', 'label' => 'Дата-центры', 'enabled' => true],
                ['value' => 'energy', 'label' => 'Энергетика', 'enabled' => true],
                ['value' => 'government', 'label' => 'Государственные и силовые структуры', 'enabled' => true],
                ['value' => 'healthcare', 'label' => 'Здравоохранение', 'enabled' => true],
                ['value' => 'hospitality', 'label' => 'Гостиничный бизнес', 'enabled' => true],
                ['value' => 'hotels', 'label' => 'Гостиницы', 'enabled' => true],
                ['value' => 'housing_utilities', 'label' => 'ЖКХ и социальная сфера', 'enabled' => true],
                ['value' => 'industrial', 'label' => 'Промышленность', 'enabled' => true],
                ['value' => 'mining', 'label' => 'Горнодобывающая', 'enabled' => true],
                ['value' => 'oil_gas', 'label' => 'Нефтегазовая отрасль', 'enabled' => true],
                ['value' => 'private_sector', 'label' => 'Частный сектор', 'enabled' => true],
                ['value' => 'production', 'label' => 'Производство', 'enabled' => true],
                ['value' => 'residential', 'label' => 'Жилые объекты', 'enabled' => true],
                ['value' => 'science_education', 'label' => 'Наука и образование', 'enabled' => true],
                ['value' => 'agriculture', 'label' => 'Сельское хозяйство', 'enabled' => true],
                ['value' => 'trade_services', 'label' => 'Торговля и услуги', 'enabled' => true],
                ['value' => 'transport', 'label' => 'Транспорт', 'enabled' => true],
            ]
        ],
        'city' => [
            'enabled' => true,
            'label' => 'Город',
            'options' => [
                ['value' => 'abinsk', 'label' => 'Абинск', 'enabled' => true],
                ['value' => 'abkhazia', 'label' => 'Абхазия', 'enabled' => true],
                ['value' => 'africa', 'label' => 'Африка', 'enabled' => true],
                ['value' => 'archangelsk', 'label' => 'Архангельск', 'enabled' => true],
                ['value' => 'achinsk', 'label' => 'Ачинск', 'enabled' => true],
                ['value' => 'baikonur', 'label' => 'Байконур', 'enabled' => true],
                ['value' => 'bangladesh', 'label' => 'Бангладеш', 'enabled' => true],
                ['value' => 'belgorod', 'label' => 'Белгородская область', 'enabled' => true],
                ['value' => 'belarus', 'label' => 'Республика Беларусь', 'enabled' => true],
                ['value' => 'bryansk', 'label' => 'Брянская область', 'enabled' => true],
                ['value' => 'vladimir', 'label' => 'Владимирская область', 'enabled' => true],
                ['value' => 'vladivostok', 'label' => 'Владивосток', 'enabled' => true],
                ['value' => 'voronezh', 'label' => 'Воронеж', 'enabled' => true],
                ['value' => 'vyborg', 'label' => 'Выборг', 'enabled' => true],
                ['value' => 'vsevolozhsk', 'label' => 'Всеволожск', 'enabled' => true],
                ['value' => 'gelendzhik', 'label' => 'Геленджик', 'enabled' => true],
                ['value' => 'gorny_altai', 'label' => 'Горно-Алтайск', 'enabled' => true],
                ['value' => 'grozny', 'label' => 'Грозный', 'enabled' => true],
                ['value' => 'gydan', 'label' => 'Гыданский полуостров', 'enabled' => true],
                ['value' => 'egypt', 'label' => 'Египет', 'enabled' => true],
                ['value' => 'ekaterinburg', 'label' => 'Екатеринбург', 'enabled' => true],
                ['value' => 'essentuki', 'label' => 'Ессентуки', 'enabled' => true],
                ['value' => 'ivanovo', 'label' => 'Ивановская область', 'enabled' => true],
                ['value' => 'izhevsk', 'label' => 'Ижевск', 'enabled' => true],
                ['value' => 'irkutsk', 'label' => 'Иркутск', 'enabled' => true],
                ['value' => 'irkutsk_region', 'label' => 'Иркутская область', 'enabled' => true],
                ['value' => 'kazakhstan', 'label' => 'Казахстан', 'enabled' => true],
                ['value' => 'kaluga', 'label' => 'Калуга', 'enabled' => true],
                ['value' => 'kaliningrad', 'label' => 'Калининград', 'enabled' => true],
                ['value' => 'kamchatka', 'label' => 'Камчатский край', 'enabled' => true],
                ['value' => 'karelia', 'label' => 'Карелия', 'enabled' => true],
                ['value' => 'kemerovo', 'label' => 'Кемеровская область', 'enabled' => true],
                ['value' => 'kirov', 'label' => 'Кировская область', 'enabled' => true],
                ['value' => 'krasnodar', 'label' => 'Краснодарский край', 'enabled' => true],
                ['value' => 'krasnoyarsk', 'label' => 'Красноярский край', 'enabled' => true],
                ['value' => 'crimea', 'label' => 'Крым', 'enabled' => true],
                ['value' => 'kursk', 'label' => 'Курск', 'enabled' => true],
                ['value' => 'lensk', 'label' => 'Ленск', 'enabled' => true],
                ['value' => 'leningrad_region', 'label' => 'Ленобласть', 'enabled' => true],
                ['value' => 'lobnya', 'label' => 'Лобня', 'enabled' => true],
                ['value' => 'magadan', 'label' => 'Магаданская область', 'enabled' => true],
                ['value' => 'mezen', 'label' => 'Мезень (Архангельская область)', 'enabled' => true],
                ['value' => 'moscow', 'label' => 'Москва', 'enabled' => true],
                ['value' => 'moscow_region', 'label' => 'Московская область', 'enabled' => true],
                ['value' => 'murmansk', 'label' => 'Мурманск', 'enabled' => true],
                ['value' => 'nalchik', 'label' => 'Нальчик', 'enabled' => true],
                ['value' => 'novaya_zemlya', 'label' => 'Новая Земля', 'enabled' => true],
                ['value' => 'novorossiysk', 'label' => 'Новороссийск', 'enabled' => true],
                ['value' => 'nnovgorod', 'label' => 'Нижний Новгород', 'enabled' => true],
                ['value' => 'novy_urengoy', 'label' => 'Новый Уренгой', 'enabled' => true],
                ['value' => 'norilsk', 'label' => 'Норильск', 'enabled' => true],
                ['value' => 'penza', 'label' => 'Пензенская область', 'enabled' => true],
                ['value' => 'primorsky', 'label' => 'Приморский край', 'enabled' => true],
                ['value' => 'rostov', 'label' => 'Ростов-на-Дону', 'enabled' => true],
                ['value' => 'rostov_region', 'label' => 'Ростовская область', 'enabled' => true],
                ['value' => 'samara', 'label' => 'Самара', 'enabled' => true],
                ['value' => 'sakhalin', 'label' => 'Сахалин', 'enabled' => true],
                ['value' => 'svobodny', 'label' => 'Свободный', 'enabled' => true],
                ['value' => 'sverdlovsk', 'label' => 'Свердловская область', 'enabled' => true],
                ['value' => 'spb', 'label' => 'Санкт-Петербург', 'enabled' => true],
                ['value' => 'syria', 'label' => 'Сирия', 'enabled' => true],
                ['value' => 'sochi', 'label' => 'Сочи', 'enabled' => true],
                ['value' => 'tazovsky', 'label' => 'Тазовский (Ямало-Ненецкий АО)', 'enabled' => true],
                ['value' => 'tver', 'label' => 'Тверь', 'enabled' => true],
                ['value' => 'tver_region', 'label' => 'Тверская обасть', 'enabled' => true],
                ['value' => 'tomsk', 'label' => 'Томск', 'enabled' => true],
                ['value' => 'turkey', 'label' => 'Турция', 'enabled' => true],
                ['value' => 'tyumen', 'label' => 'Тюмень', 'enabled' => true],
                ['value' => 'ulan_ude', 'label' => 'Улан-Удэ', 'enabled' => true],
                ['value' => 'ussuriysk', 'label' => 'Уссурийск', 'enabled' => true],
                ['value' => 'ust_ilimsk', 'label' => 'Усть-Илимск', 'enabled' => true],
                ['value' => 'ust_kut', 'label' => 'Усть-Кут', 'enabled' => true],
                ['value' => 'ust_luga', 'label' => 'Усть-Луга', 'enabled' => true],
                ['value' => 'ufa', 'label' => 'Уфа', 'enabled' => true],
                ['value' => 'khabarovsk', 'label' => 'Хабаровск', 'enabled' => true],
                ['value' => 'khmao_yugra', 'label' => 'ХМАО – Югра', 'enabled' => true],
                ['value' => 'cfd', 'label' => 'ЦФО (Центральный федеральный округ)', 'enabled' => true],
                ['value' => 'chechnya', 'label' => 'Чеченская Республика', 'enabled' => true],
                ['value' => 'chelyabinsk', 'label' => 'Челябинская область', 'enabled' => true],
                ['value' => 'chukotka', 'label' => 'Чукотский АО', 'enabled' => true],
                ['value' => 'shlisselburg', 'label' => 'Шлиссельбург', 'enabled' => true],
                ['value' => 'evenkia', 'label' => 'Эвенкия (Таймыр)', 'enabled' => true],
                ['value' => 'yakutia', 'label' => 'Якутия', 'enabled' => true],
                ['value' => 'yamal', 'label' => 'Ямало-Ненецкий АО', 'enabled' => true],
            ]
        ],
        'year' => [
            'enabled' => true,
            'label' => 'Год',
            'options' => [
                ['value' => '2025', 'label' => '2025', 'enabled' => true],
                ['value' => '2024', 'label' => '2024', 'enabled' => true],
                ['value' => '2023', 'label' => '2023', 'enabled' => true],
                ['value' => '2022', 'label' => '2022', 'enabled' => true],
                ['value' => '2021', 'label' => '2021', 'enabled' => true],
                ['value' => '2020', 'label' => '2020', 'enabled' => true],
                ['value' => '2019', 'label' => '2019', 'enabled' => true],
                ['value' => '2018', 'label' => '2018', 'enabled' => true],
                ['value' => '2017', 'label' => '2017', 'enabled' => true],
                ['value' => '2016', 'label' => '2016', 'enabled' => true],
                ['value' => '2015', 'label' => '2015', 'enabled' => true],
                ['value' => '2014', 'label' => '2014', 'enabled' => true],
            ]
        ],
    ];
    
    // Если ACF настройки есть, используем их
    if ($settings) {
        // Мощность
        if (isset($settings['filter_power_enabled'])) {
            $defaults['power']['enabled'] = (bool)$settings['filter_power_enabled'];
        }
        if (!empty($settings['power_ranges'])) {
            $defaults['power']['options'] = [];
            foreach ($settings['power_ranges'] as $range) {
                if (!empty($range['value']) && !empty($range['label'])) {
                    $defaults['power']['options'][] = [
                        'value' => $range['value'],
                        'label' => $range['label'],
                        'enabled' => isset($range['enabled']) ? (bool)$range['enabled'] : true,
                    ];
                }
            }
        }
        
        // Отрасль
        if (isset($settings['filter_industry_enabled'])) {
            $defaults['industry']['enabled'] = (bool)$settings['filter_industry_enabled'];
        }
        if (!empty($settings['industries'])) {
            $defaults['industry']['options'] = [];
            foreach ($settings['industries'] as $industry) {
                if (!empty($industry['value']) && !empty($industry['label'])) {
                    $defaults['industry']['options'][] = [
                        'value' => $industry['value'],
                        'label' => $industry['label'],
                        'enabled' => isset($industry['enabled']) ? (bool)$industry['enabled'] : true,
                    ];
                }
            }
        }
        
        // Город
        if (isset($settings['filter_city_enabled'])) {
            $defaults['city']['enabled'] = (bool)$settings['filter_city_enabled'];
        }
        if (!empty($settings['cities'])) {
            $defaults['city']['options'] = [];
            foreach ($settings['cities'] as $city) {
                if (!empty($city['value']) && !empty($city['label'])) {
                    $defaults['city']['options'][] = [
                        'value' => $city['value'],
                        'label' => $city['label'],
                        'enabled' => isset($city['enabled']) ? (bool)$city['enabled'] : true,
                    ];
                }
            }
        }
        
        // Год
        if (isset($settings['filter_year_enabled'])) {
            $defaults['year']['enabled'] = (bool)$settings['filter_year_enabled'];
        }
        if (!empty($settings['years'])) {
            $defaults['year']['options'] = [];
            foreach ($settings['years'] as $year) {
                if (!empty($year['value']) && !empty($year['label'])) {
                    $defaults['year']['options'][] = [
                        'value' => $year['value'],
                        'label' => $year['label'],
                        'enabled' => isset($year['enabled']) ? (bool)$year['enabled'] : true,
                    ];
                }
            }
        }
    }
    
    return $defaults;
}

/**
 * Получение похожих проектов
 * 
 * @param int $project_id ID текущего проекта
 * @param int $count Количество похожих проектов
 * @return WP_Query Объект запроса WordPress
 */
function dsa_get_related_projects($project_id, $count = 3) {
    // Получаем ACF поля текущего проекта
    $power_range = get_field('power_range', $project_id);
    $industry = get_field('industry', $project_id);
    $city = get_field('city', $project_id);
    
    // Формируем запрос
    $args = [
        'post_type' => 'project',
        'post__not_in' => [$project_id],
        'posts_per_page' => $count,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    // Создаем meta_query для поиска похожих проектов
    $meta_query = ['relation' => 'OR'];
    
    // По диапазону мощности
    if ($power_range) {
        $meta_query[] = [
            'key' => 'power_range',
            'value' => $power_range,
            'compare' => '=',
        ];
    }
    
    // По отрасли
    if ($industry) {
        $meta_query[] = [
            'key' => 'industry',
            'value' => $industry,
            'compare' => '=',
        ];
    }
    
    // По городу
    if ($city) {
        $meta_query[] = [
            'key' => 'city',
            'value' => $city,
            'compare' => '=',
        ];
    }
    
    if (count($meta_query) > 1) {
        $args['meta_query'] = $meta_query;
    }
    
    return new WP_Query($args);
}

// ============================================
// ПОЛУЧЕНИЕ ДОСТУПНЫХ (НЕПУСТЫХ) ФИЛЬТРОВ
// ============================================

/**
 * Получить только непустые значения фильтров (которые есть в проектах)
 * 
 * @return array Массив доступных значений для каждого фильтра
 */
function dsa_get_available_project_filters() {
    // Получаем все проекты
    $projects = new WP_Query([
        'post_type' => 'project',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ]);
    
    $available = [
        'power' => [],
        'industry' => [],
        'city' => [],
        'year' => [],
    ];
    
    if ($projects->have_posts()) {
        while ($projects->have_posts()) {
            $projects->the_post();
            $post_id = get_the_ID();
            
            // Мощность (определяем диапазон)
            $power = get_field('power', $post_id);
            $power_range_field = get_field('power_range', $post_id);
            
            if (!empty($power_range_field)) {
                $power_range = $power_range_field;
            } elseif ($power) {
                $power_range = dsa_determine_project_power_range(intval($power));
            } else {
                $power_range = null;
            }
            
            if ($power_range && !in_array($power_range, $available['power'])) {
                $available['power'][] = $power_range;
            }
            
            // Отрасль
            $industry = get_field('industry', $post_id);
            if ($industry && !in_array($industry, $available['industry'])) {
                $available['industry'][] = $industry;
            }
            
            // Город
            $city = get_field('city', $post_id);
            if ($city && !in_array($city, $available['city'])) {
                $available['city'][] = $city;
            }
            
            // Год
            $year = get_field('year', $post_id);
            if ($year && !in_array($year, $available['year'])) {
                $available['year'][] = $year;
            }
        }
        wp_reset_postdata();
    }
    
    return $available;
}

/**
 * Получить фильтры с пометкой доступности
 * 
 * @return array Массив фильтров с пометкой available
 */
function dsa_get_projects_filters_with_availability() {
    $filters = dsa_get_projects_filters();
    $available = dsa_get_available_project_filters();
    
    // Помечаем доступные опции
    foreach ($filters as $filter_key => &$filter_config) {
        if (isset($filter_config['options'])) {
            foreach ($filter_config['options'] as &$option) {
                $option['available'] = in_array($option['value'], $available[$filter_key]);
            }
        }
    }
    
    return $filters;
}

// ============================================
// РЕНДЕРИНГ КАРТОЧКИ ПРОЕКТА
// ============================================

/**
 * Рендеринг HTML карточки проекта
 * 
 * @param WP_Post $post Объект поста проекта
 * @return string HTML карточки
 */
function dsa_render_project_card($post) {
    $post_id = $post->ID;
    
    // Получаем ACF поля
    $power = get_field('power', $post_id);
    $power_range_field = get_field('power_range', $post_id);
    $industry = get_field('industry', $post_id);
    $city = get_field('city', $post_id);
    $year = get_field('year', $post_id);
    $client = get_field('client', $post_id);
    
    // Определяем диапазон мощности
    if (!empty($power_range_field)) {
        $power_range = $power_range_field;
    } elseif ($power) {
        $power_range = dsa_determine_project_power_range(intval($power));
    } else {
        $power_range = 'all';
    }
    
    // Получаем данные поста
    $title = get_the_title($post_id);
    $permalink = get_permalink($post_id);
    
    // Изображение проекта
    $image_url = '';
    $image_alt = $title;
    if (has_post_thumbnail($post_id)) {
        $thumbnail_id = get_post_thumbnail_id($post_id);
        $image_url = get_the_post_thumbnail_url($post_id, 'medium_large');
        $image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: $title;
    } else {
        // Fallback изображение
        $image_url = 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center';
    }
    
    // Форматируем мощность для отображения
    $power_display = $power ? number_format($power, 0, '.', ' ') . ' кВт' : '';
    
    // Значения для фильтрации
    $industry_display = $industry ?: 'all';
    $city_display = $city ?: 'all';
    $year_display = $year ?: 'all';
    $client_display = $client ?: '';
    
    ob_start();
    ?>
    <article class="project-card" 
             data-power="<?php echo esc_attr($power_range); ?>" 
             data-industry="<?php echo esc_attr($industry_display); ?>" 
             data-city="<?php echo esc_attr($city_display); ?>" 
             data-year="<?php echo esc_attr($year_display); ?>">
        <a href="<?php echo esc_url($permalink); ?>" class="project-card__link">
            <div class="project-card__image">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" 
                         alt="<?php echo esc_attr($image_alt); ?>" 
                         loading="lazy">
                <?php endif; ?>
                <?php if ($power_display) : ?>
                    <div class="project-card__power"><?php echo esc_html($power_display); ?></div>
                <?php endif; ?>
            </div>
            <div class="project-card__content">
                <h3 class="project-card__title"><?php echo esc_html($title); ?></h3>
                <?php if ($client_display) : ?>
                    <p class="project-card__client"><?php echo esc_html($client_display); ?></p>
                <?php endif; ?>
            </div>
        </a>
    </article>
    <?php
    return ob_get_clean();
}

// ============================================
// AJAX ФИЛЬТРАЦИЯ ПРОЕКТОВ
// ============================================

/**
 * AJAX обработчик фильтрации проектов
 */
function dsa_ajax_filter_projects() {
    // Проверка nonce
    check_ajax_referer('dsa_projects_nonce', 'nonce');
    
    // Получаем параметры
    $power = isset($_POST['power']) ? sanitize_text_field($_POST['power']) : 'all';
    $industry = isset($_POST['industry']) ? sanitize_text_field($_POST['industry']) : 'all';
    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : 'all';
    $year = isset($_POST['year']) ? sanitize_text_field($_POST['year']) : 'all';
    
    // Формируем аргументы запроса
    $args = [
        'post_type' => 'project',
        'posts_per_page' => -1, // Все проекты для клиентской фильтрации
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    $meta_query = [];
    
    // Фильтр по мощности
    if ($power && $power !== 'all') {
        $ranges = [
            '16-40' => ['min' => 16, 'max' => 40],
            '40-80' => ['min' => 40, 'max' => 80],
            '80-100' => ['min' => 80, 'max' => 100],
            '100-150' => ['min' => 100, 'max' => 150],
            '150-200' => ['min' => 150, 'max' => 200],
            '200-300' => ['min' => 200, 'max' => 300],
            '300-500' => ['min' => 300, 'max' => 500],
            '500-700' => ['min' => 500, 'max' => 700],
            '800-1000' => ['min' => 800, 'max' => 1000],
            '1000-1500' => ['min' => 1000, 'max' => 1500],
            '1500-2000' => ['min' => 1500, 'max' => 2000],
            '2000-3000' => ['min' => 2000, 'max' => 3000],
            '3000-6000' => ['min' => 3000, 'max' => 6000],
            '6000-12000' => ['min' => 6000, 'max' => 12000],
        ];
        
        if (isset($ranges[$power])) {
            $meta_query[] = [
                'key' => 'power',
                'value' => [$ranges[$power]['min'], $ranges[$power]['max']],
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN',
            ];
        }
    }
    
    // Фильтр по отрасли
    if ($industry && $industry !== 'all') {
        $meta_query[] = [
            'key' => 'industry',
            'value' => $industry,
            'compare' => '=',
        ];
    }
    
    // Фильтр по городу
    if ($city && $city !== 'all') {
        $meta_query[] = [
            'key' => 'city',
            'value' => $city,
            'compare' => '=',
        ];
    }
    
    // Фильтр по году
    if ($year && $year !== 'all') {
        $meta_query[] = [
            'key' => 'year',
            'value' => $year,
            'compare' => '=',
        ];
    }
    
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }
    
    // Выполняем запрос
    $query = new WP_Query($args);
    
    // Рендерим карточки
    ob_start();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo dsa_render_project_card(get_post());
        }
    } else {
        echo dsa_render_no_projects_found();
    }
    
    $html = ob_get_clean();
    
    wp_reset_postdata();
    
    // Отправляем ответ
    wp_send_json_success([
        'html' => $html,
        'total' => $query->found_posts,
    ]);
}

// Регистрация AJAX actions
add_action('wp_ajax_dsa_filter_projects', 'dsa_ajax_filter_projects');
add_action('wp_ajax_nopriv_dsa_filter_projects', 'dsa_ajax_filter_projects');

/**
 * Рендеринг блока "Проекты не найдены"
 * 
 * @return string HTML блока
 */
function dsa_render_no_projects_found() {
    ob_start();
    ?>
    <div class="projects-grid__empty">
        <div class="empty-state">
            <div class="empty-state__icon">
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Папка с грустным лицом -->
                    <path d="M20 40 L50 40 L55 30 L100 30 L100 90 L20 90 Z" fill="url(#project-gradient)" stroke="#0a1855" stroke-width="2"/>
                    <!-- Грустное лицо -->
                    <circle cx="50" cy="60" r="4" fill="#0a1855"/>
                    <circle cx="70" cy="60" r="4" fill="#0a1855"/>
                    <path d="M 45 75 Q 60 70 75 75" stroke="#0a1855" stroke-width="2" fill="none" stroke-linecap="round"/>
                    
                    <defs>
                        <linearGradient id="project-gradient" x1="20" y1="30" x2="100" y2="90" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#3b5fdb"/>
                            <stop offset="100%" stop-color="#00c2ff"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            
            <h3 class="empty-state__title">Проекты не найдены</h3>
            <p class="empty-state__description">
                К сожалению, по выбранным фильтрам проекты не найдены. Попробуйте изменить параметры поиска.
            </p>
            
            <div class="empty-state__actions">
                <button class="btn btn_type_primary projects-filters__reset-btn" onclick="document.querySelector('.projects-filters__reset-btn').click()">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Сбросить фильтры</span>
                </button>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn_type_secondary">
                    <i class="fa-solid fa-house"></i>
                    <span>На главную</span>
                </a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// ============================================
// ЛОКАЛИЗАЦИЯ СКРИПТОВ
// ============================================

/**
 * Локализация данных для JavaScript
 */
function dsa_localize_projects_scripts() {
    if (is_post_type_archive('project') || is_singular('project')) {
        if (wp_script_is('dsa-projects', 'enqueued')) {
            wp_localize_script('dsa-projects', 'dsaProjectsData', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('dsa_projects_nonce'),
            ]);
        }
    }
}
add_action('wp_enqueue_scripts', 'dsa_localize_projects_scripts', 99);
