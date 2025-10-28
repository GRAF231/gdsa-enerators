<?php
/**
 * СКРИПТ ДЛЯ СОЗДАНИЯ ТЕСТОВЫХ ТОВАРОВ WOOCOMMERCE
 * 
 * ИНСТРУКЦИЯ ПО ИСПОЛЬЗОВАНИЮ:
 * 1. Загрузить файл в корень темы (рядом с functions.php)
 * 2. Открыть в браузере: https://ваш-сайт.ru/wp-content/themes/ваша-тема/create-test-products.php
 * 3. Дождаться завершения (появится сообщение об успехе)
 * 4. УДАЛИТЬ ЭТОТ ФАЙЛ после использования (из соображений безопасности)
 * 
 * Создает 15 товаров с полным заполнением всех 24 ACF полей
 */

// Загрузка WordPress
require_once('../../../wp-load.php');

// Проверка прав администратора
if (!current_user_can('administrator')) {
    die('⛔ Доступ запрещен! Требуются права администратора.');
}

// Проверка WooCommerce
if (!class_exists('WooCommerce')) {
    die('⛔ WooCommerce не установлен!');
}

// Проверка ACF
if (!function_exists('get_field')) {
    die('⛔ ACF Pro не установлен!');
}

echo '<html><head><meta charset="UTF-8"><title>Создание тестовых товаров</title>';
echo '<style>body{font-family:Arial,sans-serif;max-width:800px;margin:50px auto;padding:20px;}';
echo '.success{color:green;}.error{color:red;}.info{color:blue;}</style></head><body>';
echo '<h1>🛠️ Создание тестовых товаров WooCommerce</h1>';

// Массив тестовых товаров
$test_products = [
    [
        'name' => 'DSA DG-10 Kubota',
        'power' => 10,
        'group' => 'До 16 кВт',
        'price' => 850000,
        'nominal_power' => 12.5,
        'max_power' => 11,
        'engine' => 'Kubota D1105-BG',
        'engine_manufacturer' => 'Kubota',
        'engine_volume' => 1.123,
        'country_engine' => 'Япония',
        'oil_volume' => 4.5,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 50,
        'fuel_consumption' => 2.5,
        'generator_model_1' => 'Stamford UCI224C',
        'generator_model_2' => 'Mecc Alte ECP28-2L',
        'dimensions' => '1500×700×1200',
        'weight' => 450,
        'country' => 'Россия',
        'start_type' => 'Электрический',
        'noise_level' => 68,
        'warranty' => '12 месяцев',
    ],
    [
        'name' => 'DSA DG-16 Cummins (в кожухе)',
        'power' => 16,
        'group' => '16-40 кВт',
        'price' => 1040643,
        'nominal_power' => 20,
        'max_power' => 17.6,
        'engine' => 'Cummins 4B3.9G11',
        'engine_manufacturer' => 'Cummins',
        'engine_volume' => 3.9,
        'country_engine' => 'США',
        'oil_volume' => 10,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 100,
        'fuel_consumption' => 4.2,
        'generator_model_1' => 'Stamford UCI274C',
        'generator_model_2' => 'Mecc Alte ECP32-1S',
        'dimensions' => '2200×900×1500',
        'weight' => 850,
        'country' => 'Россия',
        'start_type' => 'Электрический',
        'noise_level' => 70,
        'warranty' => '12 месяцев',
    ],
    [
        'name' => 'DSA DG-20 Perkins',
        'power' => 20,
        'group' => '16-40 кВт',
        'price' => 1200000,
        'nominal_power' => 25,
        'max_power' => 22,
        'engine' => 'Perkins 403A-15G1',
        'engine_manufacturer' => 'Perkins',
        'engine_volume' => 1.5,
        'country_engine' => 'Великобритания',
        'oil_volume' => 6.5,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 120,
        'fuel_consumption' => 5.0,
        'generator_model_1' => 'Stamford UCI274D',
        'generator_model_2' => 'Mecc Alte ECP32-3S',
        'dimensions' => '2400×1000×1600',
        'weight' => 950,
        'country' => 'Россия',
        'start_type' => 'Электрический',
        'noise_level' => 72,
        'warranty' => '12 месяцев',
    ],
    [
        'name' => 'DSA DG-30 Doosan',
        'power' => 30,
        'group' => '16-40 кВт',
        'price' => 1450000,
        'nominal_power' => 37.5,
        'max_power' => 33,
        'engine' => 'Doosan P086TI',
        'engine_manufacturer' => 'Doosan',
        'engine_volume' => 3.4,
        'country_engine' => 'Корея',
        'oil_volume' => 12,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 150,
        'fuel_consumption' => 7.5,
        'generator_model_1' => 'Stamford UCI274E',
        'generator_model_2' => 'Mecc Alte ECP34-2S',
        'dimensions' => '2600×1100×1700',
        'weight' => 1200,
        'country' => 'Россия',
        'start_type' => 'Электрический',
        'noise_level' => 73,
        'warranty' => '18 месяцев',
    ],
    [
        'name' => 'DSA DG-50 Perkins (открытое исполнение)',
        'power' => 50,
        'group' => '40-100 кВт',
        'price' => 1850000,
        'nominal_power' => 63,
        'max_power' => 55,
        'engine' => 'Perkins 1104C-44TAG2',
        'engine_manufacturer' => 'Perkins',
        'engine_volume' => 4.4,
        'country_engine' => 'Великобритания',
        'oil_volume' => 15,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 200,
        'fuel_consumption' => 12.5,
        'generator_model_1' => 'Stamford UCI274F',
        'generator_model_2' => 'Mecc Alte ECP34-3S',
        'dimensions' => '2800×1200×1800',
        'weight' => 1600,
        'country' => 'Россия',
        'start_type' => 'Автоматический',
        'noise_level' => 75,
        'warranty' => '18 месяцев',
    ],
    [
        'name' => 'DSA DG-80 Cummins',
        'power' => 80,
        'group' => '40-100 кВт',
        'price' => 2400000,
        'nominal_power' => 100,
        'max_power' => 88,
        'engine' => 'Cummins 6BT5.9-G2',
        'engine_manufacturer' => 'Cummins',
        'engine_volume' => 5.9,
        'country_engine' => 'США',
        'oil_volume' => 18,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 300,
        'fuel_consumption' => 20,
        'generator_model_1' => 'Stamford UCI274G',
        'generator_model_2' => 'Mecc Alte ECP38-1S',
        'dimensions' => '3000×1300×1900',
        'weight' => 2200,
        'country' => 'Россия',
        'start_type' => 'Автоматический',
        'noise_level' => 76,
        'warranty' => '24 месяца',
    ],
    [
        'name' => 'DSA DG-100 MTU',
        'power' => 100,
        'group' => '100-200 кВт',
        'price' => 3200000,
        'nominal_power' => 125,
        'max_power' => 110,
        'engine' => 'MTU 6R 0183 TC21',
        'engine_manufacturer' => 'MTU',
        'engine_volume' => 12.8,
        'country_engine' => 'Германия',
        'oil_volume' => 45,
        'cylinder_config' => 'V-образный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 500,
        'fuel_consumption' => 25,
        'generator_model_1' => 'Stamford UCI274E',
        'generator_model_2' => 'Mecc Alte ECO40-3S',
        'dimensions' => '3500×1500×2200',
        'weight' => 4500,
        'country' => 'Германия',
        'start_type' => 'Автоматический',
        'noise_level' => 75,
        'warranty' => '24 месяца',
    ],
    [
        'name' => 'DSA DG-150 Perkins',
        'power' => 150,
        'group' => '100-200 кВт',
        'price' => 4500000,
        'nominal_power' => 187.5,
        'max_power' => 165,
        'engine' => 'Perkins 1106A-70TAG4',
        'engine_manufacturer' => 'Perkins',
        'engine_volume' => 7.0,
        'country_engine' => 'Великобритания',
        'oil_volume' => 25,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 600,
        'fuel_consumption' => 35,
        'generator_model_1' => 'Stamford HCI444D',
        'generator_model_2' => 'Mecc Alte ECO43-1S',
        'dimensions' => '3800×1600×2300',
        'weight' => 5200,
        'country' => 'Великобритания',
        'start_type' => 'Автоматический',
        'noise_level' => 77,
        'warranty' => '24 месяца',
    ],
    [
        'name' => 'DSA DG-200 Caterpillar',
        'power' => 200,
        'group' => '200-500 кВт',
        'price' => 6000000,
        'nominal_power' => 250,
        'max_power' => 220,
        'engine' => 'Caterpillar C9',
        'engine_manufacturer' => 'Caterpillar',
        'engine_volume' => 8.8,
        'country_engine' => 'США',
        'oil_volume' => 35,
        'cylinder_config' => 'Рядный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 800,
        'fuel_consumption' => 50,
        'generator_model_1' => 'Stamford HCI544C',
        'generator_model_2' => 'Mecc Alte ECO46-2S',
        'dimensions' => '4200×1800×2500',
        'weight' => 6500,
        'country' => 'США',
        'start_type' => 'Автоматический',
        'noise_level' => 78,
        'warranty' => '36 месяцев',
    ],
    [
        'name' => 'DSA DG-300 MAN',
        'power' => 300,
        'group' => '200-500 кВт',
        'price' => 8500000,
        'nominal_power' => 375,
        'max_power' => 330,
        'engine' => 'MAN D2842LE223',
        'engine_manufacturer' => 'MAN',
        'engine_volume' => 12.4,
        'country_engine' => 'Германия',
        'oil_volume' => 50,
        'cylinder_config' => 'V-образный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 1000,
        'fuel_consumption' => 75,
        'generator_model_1' => 'Stamford HCI634E',
        'generator_model_2' => 'Mecc Alte ECO50-3S',
        'dimensions' => '4800×2000×2700',
        'weight' => 8500,
        'country' => 'Германия',
        'start_type' => 'Автоматический',
        'noise_level' => 80,
        'warranty' => '36 месяцев',
    ],
    [
        'name' => 'DSA DG-500 MTU',
        'power' => 500,
        'group' => '500-1000 кВт',
        'price' => 12000000,
        'nominal_power' => 625,
        'max_power' => 550,
        'engine' => 'MTU 12V 2000 G25',
        'engine_manufacturer' => 'MTU',
        'engine_volume' => 24.0,
        'country_engine' => 'Германия',
        'oil_volume' => 85,
        'cylinder_config' => 'V-образный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 1500,
        'fuel_consumption' => 125,
        'generator_model_1' => 'Stamford PI734G',
        'generator_model_2' => 'Mecc Alte ECO55-1L',
        'dimensions' => '5500×2200×3000',
        'weight' => 12000,
        'country' => 'Германия',
        'start_type' => 'Автоматический',
        'noise_level' => 82,
        'warranty' => '36 месяцев',
    ],
    [
        'name' => 'DSA DG-800 Caterpillar',
        'power' => 800,
        'group' => '500-1000 кВт',
        'price' => 18000000,
        'nominal_power' => 1000,
        'max_power' => 880,
        'engine' => 'Caterpillar C27',
        'engine_manufacturer' => 'Caterpillar',
        'engine_volume' => 27.0,
        'country_engine' => 'США',
        'oil_volume' => 110,
        'cylinder_config' => 'V-образный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 2000,
        'fuel_consumption' => 200,
        'generator_model_1' => 'Stamford PI844G',
        'generator_model_2' => 'Mecc Alte ECO58-3L',
        'dimensions' => '6000×2500×3200',
        'weight' => 16000,
        'country' => 'США',
        'start_type' => 'Автоматический',
        'noise_level' => 85,
        'warranty' => '48 месяцев',
    ],
    [
        'name' => 'DSA DG-1000 MTU',
        'power' => 1000,
        'group' => '1000-2000 кВт',
        'price' => 25000000,
        'nominal_power' => 1250,
        'max_power' => 1100,
        'engine' => 'MTU 16V 2000 G85',
        'engine_manufacturer' => 'MTU',
        'engine_volume' => 32.0,
        'country_engine' => 'Германия',
        'oil_volume' => 150,
        'cylinder_config' => 'V-образный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 3000,
        'fuel_consumption' => 250,
        'generator_model_1' => 'Stamford PI944H',
        'generator_model_2' => 'Mecc Alte ECO65-3L',
        'dimensions' => '7000×3000×3500',
        'weight' => 22000,
        'country' => 'Германия',
        'start_type' => 'Автоматический',
        'noise_level' => 87,
        'warranty' => '48 месяцев',
    ],
    [
        'name' => 'DSA DG-1500 MAN',
        'power' => 1500,
        'group' => '1000-2000 кВт',
        'price' => 35000000,
        'nominal_power' => 1875,
        'max_power' => 1650,
        'engine' => 'MAN 18V32/40',
        'engine_manufacturer' => 'MAN',
        'engine_volume' => 40.0,
        'country_engine' => 'Германия',
        'oil_volume' => 200,
        'cylinder_config' => 'V-образный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 4000,
        'fuel_consumption' => 375,
        'generator_model_1' => 'Stamford HCI1444J',
        'generator_model_2' => 'Mecc Alte ECO70-3L',
        'dimensions' => '8000×3200×4000',
        'weight' => 30000,
        'country' => 'Германия',
        'start_type' => 'Автоматический',
        'noise_level' => 90,
        'warranty' => '60 месяцев',
    ],
    [
        'name' => 'DSA DG-2000 Caterpillar',
        'power' => 2000,
        'group' => '1000-2000 кВт',
        'price' => 50000000,
        'nominal_power' => 2500,
        'max_power' => 2200,
        'engine' => 'Caterpillar 3516B',
        'engine_manufacturer' => 'Caterpillar',
        'engine_volume' => 69.0,
        'country_engine' => 'США',
        'oil_volume' => 280,
        'cylinder_config' => 'V-образный',
        'cooling_type' => 'liquid',
        'rotation_speed' => 1500,
        'voltage' => 400,
        'frequency' => '50 Гц',
        'phases' => '3-фазная',
        'fuel_tank_volume' => 5000,
        'fuel_consumption' => 500,
        'generator_model_1' => 'Stamford HCI1644K',
        'generator_model_2' => 'Mecc Alte ECO75-3L',
        'dimensions' => '9000×3500×4500',
        'weight' => 45000,
        'country' => 'США',
        'start_type' => 'Автоматический',
        'noise_level' => 92,
        'warranty' => '60 месяцев',
    ],
];

$created = 0;
$errors = 0;

echo '<div class="info">📦 Начинаю создание ' . count($test_products) . ' товаров...</div><hr>';

foreach ($test_products as $product_data) {
    try {
        // Создание товара WooCommerce
        $product = new WC_Product_Simple();
        $product->set_name($product_data['name']);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_regular_price($product_data['price']);
        $product->set_manage_stock(false);
        
        // Описание
        $description = sprintf(
            'Дизельная электростанция %s мощностью %d кВт с двигателем %s. %s',
            $product_data['name'],
            $product_data['power'],
            $product_data['engine_manufacturer'],
            'Надежное и экономичное решение для резервного и постоянного электроснабжения.'
        );
        $product->set_description($description);
        $product->set_short_description(
            sprintf('Генератор %d кВт, двигатель %s', $product_data['power'], $product_data['engine_manufacturer'])
        );
        
        // Сохранение товара
        $product_id = $product->save();
        
        if ($product_id) {
            // Заполнение ACF полей (все 24 поля)
            update_field('power', $product_data['power'], $product_id);
            update_field('nominal_power', $product_data['nominal_power'], $product_id);
            update_field('max_power', $product_data['max_power'], $product_id);
            
            // Электрические характеристики (NEW)
            update_field('voltage', $product_data['voltage'], $product_id);
            update_field('frequency', $product_data['frequency'], $product_id);
            update_field('phases', $product_data['phases'], $product_id);
            
            // Двигатель
            update_field('engine', $product_data['engine'], $product_id);
            update_field('engine_manufacturer', $product_data['engine_manufacturer'], $product_id);
            update_field('engine_volume', $product_data['engine_volume'], $product_id);
            update_field('country_engine', $product_data['country_engine'], $product_id);
            update_field('oil_volume', $product_data['oil_volume'], $product_id);
            update_field('cylinder_config', $product_data['cylinder_config'], $product_id);
            update_field('cooling_type', $product_data['cooling_type'], $product_id);
            update_field('rotation_speed', $product_data['rotation_speed'], $product_id);
            
            // Топливо (NEW)
            update_field('fuel_tank_volume', $product_data['fuel_tank_volume'], $product_id);
            update_field('fuel_consumption', $product_data['fuel_consumption'], $product_id);
            
            // Генератор
            update_field('generator_model_1', $product_data['generator_model_1'], $product_id);
            update_field('generator_model_2', $product_data['generator_model_2'], $product_id);
            
            // Габариты
            update_field('dimensions', $product_data['dimensions'], $product_id);
            update_field('weight', $product_data['weight'], $product_id);
            
            // Страна
            update_field('country', $product_data['country'], $product_id);
            
            // Эксплуатация (NEW)
            update_field('start_type', $product_data['start_type'], $product_id);
            update_field('noise_level', $product_data['noise_level'], $product_id);
            update_field('warranty', $product_data['warranty'], $product_id);
            
            $created++;
            echo sprintf(
                '<div class="success">✅ #%d: <strong>%s</strong> (ID: %d, Мощность: %d кВт, Цена: %s ₽)</div>',
                $created,
                $product_data['name'],
                $product_id,
                $product_data['power'],
                number_format($product_data['price'], 0, '.', ' ')
            );
        } else {
            throw new Exception('Не удалось создать товар');
        }
        
    } catch (Exception $e) {
        $errors++;
        echo sprintf(
            '<div class="error">❌ Ошибка при создании "%s": %s</div>',
            $product_data['name'],
            $e->getMessage()
        );
    }
}

echo '<hr>';
echo '<h2>📊 Результаты:</h2>';
echo sprintf('<p class="success">✅ Создано товаров: <strong>%d</strong></p>', $created);
echo sprintf('<p class="error">❌ Ошибок: <strong>%d</strong></p>', $errors);

if ($created > 0) {
    echo '<hr>';
    echo '<h3>🎯 Следующие шаги:</h3>';
    echo '<ol>';
    echo '<li>Перейдите в <strong>Товары</strong> в админ-панели и проверьте созданные товары</li>';
    echo '<li>Откройте каталог на фронтенде (<code>/shop/</code>) и проверьте группировку</li>';
    echo '<li>Попробуйте фильтры по мощности</li>';
    echo '<li><strong>⚠️ ВАЖНО: УДАЛИТЬ ЭТОТ ФАЙЛ (create-test-products.php) после использования!</strong></li>';
    echo '</ol>';
    
    echo '<hr>';
    echo '<h3>📝 Рекомендации:</h3>';
    echo '<ul>';
    echo '<li>Загрузите изображения для товаров (можно массово через Media Library)</li>';
    echo '<li>Добавьте товары в категории (если нужно)</li>';
    echo '<li>Настройте теги для связанных товаров</li>';
    echo '</ul>';
}

echo '<hr>';
echo '<p><a href="' . admin_url('edit.php?post_type=product') . '" style="display:inline-block;padding:10px 20px;background:#0073aa;color:white;text-decoration:none;border-radius:3px;">📦 Перейти к товарам</a></p>';
echo '<p><a href="' . home_url('/shop/') . '" style="display:inline-block;padding:10px 20px;background:#46b450;color:white;text-decoration:none;border-radius:3px;">🛒 Открыть каталог</a></p>';

echo '</body></html>';
