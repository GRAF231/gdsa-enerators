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
 * @param int $page_id ID страницы
 * @return array Массив настроек фильтров
 */
function dsa_get_projects_filters($page_id = null) {
    if (!$page_id) {
        global $post;
        $page_id = $post->ID ?? 0;
    }
    
    $settings = get_field('projects_filters_settings', $page_id);
    
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
