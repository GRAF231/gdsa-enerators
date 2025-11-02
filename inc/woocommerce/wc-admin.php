<?php
/**
 * WOOCOMMERCE АДМИН
 * Инструменты администрирования WooCommerce
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ========================================
 * ADMIN: СОЗДАНИЕ ТЕСТОВЫХ ТОВАРОВ
 * ========================================
 */

// Добавление пункта меню в админке
add_action('admin_menu', 'dsa_add_test_products_menu');
function dsa_add_test_products_menu() {
    add_submenu_page(
        'tools.php',
        'Создать тестовые товары',
        'Тестовые товары',
        'manage_options',
        'dsa-create-test-products',
        'dsa_create_test_products_page'
    );
}

// Страница создания тестовых товаров
function dsa_create_test_products_page() {
    // Проверка прав
    if (!current_user_can('manage_options')) {
        wp_die('Недостаточно прав доступа');
    }
    
    // Проверка WooCommerce
    if (!class_exists('WooCommerce')) {
        echo '<div class="notice notice-error"><p>❌ WooCommerce не установлен!</p></div>';
        return;
    }
    
    ?>
    <div class="wrap">
        <h1>🛠️ Создание тестовых товаров WooCommerce</h1>
        
        <?php
        // Обработка создания товаров
        if (isset($_POST['create_products']) && check_admin_referer('dsa_create_products')) {
            $result = dsa_create_test_products();
            
            if ($result['success']) {
                echo '<div class="notice notice-success"><p>✅ Создано товаров: <strong>' . $result['created'] . '</strong></p></div>';
                
                if ($result['errors'] > 0) {
                    echo '<div class="notice notice-warning"><p>⚠️ Ошибок: ' . $result['errors'] . '</p></div>';
                }
                
                // Список созданных товаров
                if (!empty($result['products'])) {
                    echo '<h2>📦 Созданные товары:</h2>';
                    echo '<table class="wp-list-table widefat fixed striped">';
                    echo '<thead><tr><th>№</th><th>Название</th><th>Мощность</th><th>Цена</th><th>ID</th><th>Действия</th></tr></thead>';
                    echo '<tbody>';
                    foreach ($result['products'] as $i => $product) {
                        echo '<tr>';
                        echo '<td>' . ($i + 1) . '</td>';
                        echo '<td><strong>' . esc_html($product['name']) . '</strong></td>';
                        echo '<td>' . $product['power'] . ' кВт</td>';
                        echo '<td>' . number_format($product['price'], 0, '.', ' ') . ' ₽</td>';
                        echo '<td>' . $product['id'] . '</td>';
                        echo '<td>';
                        echo '<a href="' . get_edit_post_link($product['id']) . '" class="button button-small">Редактировать</a> ';
                        echo '<a href="' . get_permalink($product['id']) . '" class="button button-small" target="_blank">Просмотр</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
                }
                
                echo '<hr>';
                echo '<h3>🎯 Следующие шаги:</h3>';
                echo '<ul>';
                echo '<li>✅ Товары созданы и опубликованы</li>';
                echo '<li>📦 <a href="' . admin_url('edit.php?post_type=product') . '">Перейти к списку товаров</a></li>';
                echo '<li>🛒 <a href="' . home_url('/shop/') . '" target="_blank">Открыть каталог на фронтенде</a></li>';
                echo '<li>📝 Используйте <code>WOOCOMMERCE_TESTING_GUIDE.md</code> для тестирования</li>';
                echo '</ul>';
            } else {
                echo '<div class="notice notice-error"><p>❌ Ошибка при создании товаров</p></div>';
            }
        }
        ?>
        
        <div class="card" style="max-width: 800px;">
            <h2>📋 Что будет создано</h2>
            <p>Этот инструмент создаст <strong>15 тестовых товаров WooCommerce</strong> с полным заполнением всех <strong>24 атрибутов продукта</strong>.</p>
            
            <h3>Список товаров:</h3>
            <table class="wp-list-table widefat" style="max-width: 100%;">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Название</th>
                        <th>Мощность</th>
                        <th>Группа</th>
                        <th>Цена</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>DSA DG-10 Kubota</td><td>10 кВт</td><td>До 16 кВт</td><td>850 000 ₽</td></tr>
                    <tr><td>2</td><td>DSA DG-16 Cummins</td><td>16 кВт</td><td>16-40 кВт</td><td>1 040 643 ₽</td></tr>
                    <tr><td>3</td><td>DSA DG-20 Perkins</td><td>20 кВт</td><td>16-40 кВт</td><td>1 200 000 ₽</td></tr>
                    <tr><td>4</td><td>DSA DG-30 Doosan</td><td>30 кВт</td><td>16-40 кВт</td><td>1 450 000 ₽</td></tr>
                    <tr><td>5</td><td>DSA DG-50 Perkins</td><td>50 кВт</td><td>40-100 кВт</td><td>1 850 000 ₽</td></tr>
                    <tr><td>6</td><td>DSA DG-80 Cummins</td><td>80 кВт</td><td>40-100 кВт</td><td>2 400 000 ₽</td></tr>
                    <tr><td>7</td><td>DSA DG-100 MTU</td><td>100 кВт</td><td>100-200 кВт</td><td>3 200 000 ₽</td></tr>
                    <tr><td>8</td><td>DSA DG-150 Perkins</td><td>150 кВт</td><td>100-200 кВт</td><td>4 500 000 ₽</td></tr>
                    <tr><td>9</td><td>DSA DG-200 Caterpillar</td><td>200 кВт</td><td>200-500 кВт</td><td>6 000 000 ₽</td></tr>
                    <tr><td>10</td><td>DSA DG-300 MAN</td><td>300 кВт</td><td>200-500 кВт</td><td>8 500 000 ₽</td></tr>
                    <tr><td>11</td><td>DSA DG-500 MTU</td><td>500 кВт</td><td>500-1000 кВт</td><td>12 000 000 ₽</td></tr>
                    <tr><td>12</td><td>DSA DG-800 Caterpillar</td><td>800 кВт</td><td>500-1000 кВт</td><td>18 000 000 ₽</td></tr>
                    <tr><td>13</td><td>DSA DG-1000 MTU</td><td>1000 кВт</td><td>1000-2000 кВт</td><td>25 000 000 ₽</td></tr>
                    <tr><td>14</td><td>DSA DG-1500 MAN</td><td>1500 кВт</td><td>1000-2000 кВт</td><td>35 000 000 ₽</td></tr>
                    <tr><td>15</td><td>DSA DG-2000 Caterpillar</td><td>2000 кВт</td><td>1000-2000 кВт</td><td>50 000 000 ₽</td></tr>
                </tbody>
            </table>
            
            <hr>
            
            <h3>✅ Что заполняется автоматически:</h3>
            <ul>
                <li><strong>WooCommerce поля:</strong> название, цена, описание, краткое описание</li>
                <li><strong>24 атрибута продукта:</strong> все характеристики (мощность, двигатель, топливо, электрика, габариты и т.д.)</li>
                <li><strong>Статус:</strong> Опубликован</li>
            </ul>
            
            <hr>
            
            <form method="post" style="margin-top: 20px;">
                <?php wp_nonce_field('dsa_create_products'); ?>
                <p>
                    <button type="submit" name="create_products" class="button button-primary button-hero">
                        🚀 Создать 15 тестовых товаров
                    </button>
                </p>
                <p class="description">
                    ⚠️ <strong>Внимание:</strong> Это создаст 15 новых товаров в вашем магазине. 
                    Атрибуты регистрируются автоматически при активации темы.
                </p>
            </form>
        </div>
    </div>
    <?php
}

// Функция создания тестовых товаров
function dsa_create_test_products() {
    // Массив тестовых товаров
    $test_products = [
        ['name' => 'DSA DG-10 Kubota', 'price' => 850000, 'attrs' => ['pa_power' => '10', 'pa_nominal_power' => '12.5', 'pa_max_power' => '11', 'pa_engine' => 'Kubota D1105-BG', 'pa_engine_manufacturer' => 'Kubota', 'pa_engine_volume' => '1.123', 'pa_country_engine' => 'Япония', 'pa_oil_volume' => '4.5', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '50', 'pa_fuel_consumption' => '2.5', 'pa_generator_model_1' => 'Stamford UCI224C', 'pa_generator_model_2' => 'Mecc Alte ECP28-2L', 'pa_dimensions' => '1500×700×1200', 'pa_weight' => '450', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '68', 'pa_warranty' => '12 месяцев']],
        ['name' => 'DSA DG-16 Cummins (в кожухе)', 'price' => 1040643, 'attrs' => ['pa_power' => '16', 'pa_nominal_power' => '20', 'pa_max_power' => '17.6', 'pa_engine' => 'Cummins 4B3.9G11', 'pa_engine_manufacturer' => 'Cummins', 'pa_engine_volume' => '3.9', 'pa_country_engine' => 'США', 'pa_oil_volume' => '10', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '100', 'pa_fuel_consumption' => '4.2', 'pa_generator_model_1' => 'Stamford UCI274C', 'pa_generator_model_2' => 'Mecc Alte ECP32-1S', 'pa_dimensions' => '2200×900×1500', 'pa_weight' => '850', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '70', 'pa_warranty' => '12 месяцев']],
        ['name' => 'DSA DG-20 Perkins', 'price' => 1200000, 'attrs' => ['pa_power' => '20', 'pa_nominal_power' => '25', 'pa_max_power' => '22', 'pa_engine' => 'Perkins 403A-15G1', 'pa_engine_manufacturer' => 'Perkins', 'pa_engine_volume' => '1.5', 'pa_country_engine' => 'Великобритания', 'pa_oil_volume' => '6.5', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '120', 'pa_fuel_consumption' => '5.0', 'pa_generator_model_1' => 'Stamford UCI274D', 'pa_generator_model_2' => 'Mecc Alte ECP32-3S', 'pa_dimensions' => '2400×1000×1600', 'pa_weight' => '950', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '72', 'pa_warranty' => '12 месяцев']],
        ['name' => 'DSA DG-30 Doosan', 'price' => 1450000, 'attrs' => ['pa_power' => '30', 'pa_nominal_power' => '37.5', 'pa_max_power' => '33', 'pa_engine' => 'Doosan P086TI', 'pa_engine_manufacturer' => 'Doosan', 'pa_engine_volume' => '3.4', 'pa_country_engine' => 'Корея', 'pa_oil_volume' => '12', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '150', 'pa_fuel_consumption' => '7.5', 'pa_generator_model_1' => 'Stamford UCI274E', 'pa_generator_model_2' => 'Mecc Alte ECP34-2S', 'pa_dimensions' => '2600×1100×1700', 'pa_weight' => '1200', 'pa_country' => 'Россия', 'pa_start_type' => 'Электрический стартер', 'pa_noise_level' => '73', 'pa_warranty' => '18 месяцев']],
        ['name' => 'DSA DG-50 Perkins (открытое исполнение)', 'price' => 1850000, 'attrs' => ['pa_power' => '50', 'pa_nominal_power' => '63', 'pa_max_power' => '55', 'pa_engine' => 'Perkins 1104C-44TAG2', 'pa_engine_manufacturer' => 'Perkins', 'pa_engine_volume' => '4.4', 'pa_country_engine' => 'Великобритания', 'pa_oil_volume' => '15', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '200', 'pa_fuel_consumption' => '12.5', 'pa_generator_model_1' => 'Stamford UCI274F', 'pa_generator_model_2' => 'Mecc Alte ECP34-3S', 'pa_dimensions' => '2800×1200×1800', 'pa_weight' => '1600', 'pa_country' => 'Россия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '75', 'pa_warranty' => '18 месяцев']],
        ['name' => 'DSA DG-80 Cummins', 'price' => 2400000, 'attrs' => ['pa_power' => '80', 'pa_nominal_power' => '100', 'pa_max_power' => '88', 'pa_engine' => 'Cummins 6BT5.9-G2', 'pa_engine_manufacturer' => 'Cummins', 'pa_engine_volume' => '5.9', 'pa_country_engine' => 'США', 'pa_oil_volume' => '18', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '300', 'pa_fuel_consumption' => '20', 'pa_generator_model_1' => 'Stamford UCI274G', 'pa_generator_model_2' => 'Mecc Alte ECP38-1S', 'pa_dimensions' => '3000×1300×1900', 'pa_weight' => '2200', 'pa_country' => 'Россия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '76', 'pa_warranty' => '24 месяца']],
        ['name' => 'DSA DG-100 MTU', 'price' => 3200000, 'attrs' => ['pa_power' => '100', 'pa_nominal_power' => '125', 'pa_max_power' => '110', 'pa_engine' => 'MTU 6R 0183 TC21', 'pa_engine_manufacturer' => 'MTU', 'pa_engine_volume' => '12.8', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '45', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '500', 'pa_fuel_consumption' => '25', 'pa_generator_model_1' => 'Stamford UCI274E', 'pa_generator_model_2' => 'Mecc Alte ECO40-3S', 'pa_dimensions' => '3500×1500×2200', 'pa_weight' => '4500', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '75', 'pa_warranty' => '24 месяца']],
        ['name' => 'DSA DG-150 Perkins', 'price' => 4500000, 'attrs' => ['pa_power' => '150', 'pa_nominal_power' => '187.5', 'pa_max_power' => '165', 'pa_engine' => 'Perkins 1106A-70TAG4', 'pa_engine_manufacturer' => 'Perkins', 'pa_engine_volume' => '7.0', 'pa_country_engine' => 'Великобритания', 'pa_oil_volume' => '25', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '600', 'pa_fuel_consumption' => '35', 'pa_generator_model_1' => 'Stamford HCI444D', 'pa_generator_model_2' => 'Mecc Alte ECO43-1S', 'pa_dimensions' => '3800×1600×2300', 'pa_weight' => '5200', 'pa_country' => 'Великобритания', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '77', 'pa_warranty' => '24 месяца']],
        ['name' => 'DSA DG-200 Caterpillar', 'price' => 6000000, 'attrs' => ['pa_power' => '200', 'pa_nominal_power' => '250', 'pa_max_power' => '220', 'pa_engine' => 'Caterpillar C9', 'pa_engine_manufacturer' => 'Caterpillar', 'pa_engine_volume' => '8.8', 'pa_country_engine' => 'США', 'pa_oil_volume' => '35', 'pa_cylinder_config' => 'Рядный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '800', 'pa_fuel_consumption' => '50', 'pa_generator_model_1' => 'Stamford HCI544C', 'pa_generator_model_2' => 'Mecc Alte ECO46-2S', 'pa_dimensions' => '4200×1800×2500', 'pa_weight' => '6500', 'pa_country' => 'США', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '78', 'pa_warranty' => '36 месяцев']],
        ['name' => 'DSA DG-300 MAN', 'price' => 8500000, 'attrs' => ['pa_power' => '300', 'pa_nominal_power' => '375', 'pa_max_power' => '330', 'pa_engine' => 'MAN D2842LE223', 'pa_engine_manufacturer' => 'MAN', 'pa_engine_volume' => '12.4', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '50', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '1000', 'pa_fuel_consumption' => '75', 'pa_generator_model_1' => 'Stamford HCI634E', 'pa_generator_model_2' => 'Mecc Alte ECO50-3S', 'pa_dimensions' => '4800×2000×2700', 'pa_weight' => '8500', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '80', 'pa_warranty' => '36 месяцев']],
        ['name' => 'DSA DG-500 MTU', 'price' => 12000000, 'attrs' => ['pa_power' => '500', 'pa_nominal_power' => '625', 'pa_max_power' => '550', 'pa_engine' => 'MTU 12V 2000 G25', 'pa_engine_manufacturer' => 'MTU', 'pa_engine_volume' => '24.0', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '85', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '1500', 'pa_fuel_consumption' => '125', 'pa_generator_model_1' => 'Stamford PI734G', 'pa_generator_model_2' => 'Mecc Alte ECO55-1L', 'pa_dimensions' => '5500×2200×3000', 'pa_weight' => '12000', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '82', 'pa_warranty' => '36 месяцев']],
        ['name' => 'DSA DG-800 Caterpillar', 'price' => 18000000, 'attrs' => ['pa_power' => '800', 'pa_nominal_power' => '1000', 'pa_max_power' => '880', 'pa_engine' => 'Caterpillar C27', 'pa_engine_manufacturer' => 'Caterpillar', 'pa_engine_volume' => '27.0', 'pa_country_engine' => 'США', 'pa_oil_volume' => '110', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '2000', 'pa_fuel_consumption' => '200', 'pa_generator_model_1' => 'Stamford PI844G', 'pa_generator_model_2' => 'Mecc Alte ECO58-3L', 'pa_dimensions' => '6000×2500×3200', 'pa_weight' => '16000', 'pa_country' => 'США', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '85', 'pa_warranty' => '48 месяцев']],
        ['name' => 'DSA DG-1000 MTU', 'price' => 25000000, 'attrs' => ['pa_power' => '1000', 'pa_nominal_power' => '1250', 'pa_max_power' => '1100', 'pa_engine' => 'MTU 16V 2000 G85', 'pa_engine_manufacturer' => 'MTU', 'pa_engine_volume' => '32.0', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '150', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '3000', 'pa_fuel_consumption' => '250', 'pa_generator_model_1' => 'Stamford PI944H', 'pa_generator_model_2' => 'Mecc Alte ECO65-3L', 'pa_dimensions' => '7000×3000×3500', 'pa_weight' => '22000', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '87', 'pa_warranty' => '48 месяцев']],
        ['name' => 'DSA DG-1500 MAN', 'price' => 35000000, 'attrs' => ['pa_power' => '1500', 'pa_nominal_power' => '1875', 'pa_max_power' => '1650', 'pa_engine' => 'MAN 18V32/40', 'pa_engine_manufacturer' => 'MAN', 'pa_engine_volume' => '40.0', 'pa_country_engine' => 'Германия', 'pa_oil_volume' => '200', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '4000', 'pa_fuel_consumption' => '375', 'pa_generator_model_1' => 'Stamford HCI1444J', 'pa_generator_model_2' => 'Mecc Alte ECO70-3L', 'pa_dimensions' => '8000×3200×4000', 'pa_weight' => '30000', 'pa_country' => 'Германия', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '90', 'pa_warranty' => '60 месяцев']],
        ['name' => 'DSA DG-2000 Caterpillar', 'price' => 50000000, 'attrs' => ['pa_power' => '2000', 'pa_nominal_power' => '2500', 'pa_max_power' => '2200', 'pa_engine' => 'Caterpillar 3516B', 'pa_engine_manufacturer' => 'Caterpillar', 'pa_engine_volume' => '69.0', 'pa_country_engine' => 'США', 'pa_oil_volume' => '280', 'pa_cylinder_config' => 'V-образный', 'pa_cooling_type' => 'Жидкостное', 'pa_rotation_speed' => '1500', 'pa_voltage' => '400', 'pa_frequency' => '50 Гц', 'pa_phases' => '3-фазная', 'pa_fuel_tank_volume' => '5000', 'pa_fuel_consumption' => '500', 'pa_generator_model_1' => 'Stamford HCI1644K', 'pa_generator_model_2' => 'Mecc Alte ECO75-3L', 'pa_dimensions' => '9000×3500×4500', 'pa_weight' => '45000', 'pa_country' => 'США', 'pa_start_type' => 'Автоматический запуск', 'pa_noise_level' => '92', 'pa_warranty' => '60 месяцев']],
    ];
    
    $created = 0;
    $errors = 0;
    $products = [];
    
    foreach ($test_products as $product_data) {
        try {
            $product = new WC_Product_Simple();
            $product->set_name($product_data['name']);
            $product->set_status('publish');
            $product->set_catalog_visibility('visible');
            $product->set_regular_price($product_data['price']);
            $product->set_manage_stock(false);
            
            // Получаем мощность для описания
            $power = isset($product_data['attrs']['pa_power']) ? $product_data['attrs']['pa_power'] : '0';
            $engine_manufacturer = isset($product_data['attrs']['pa_engine_manufacturer']) ? $product_data['attrs']['pa_engine_manufacturer'] : 'Unknown';
            
            $description = sprintf(
                'Дизельная электростанция %s мощностью %s кВт с двигателем %s. Надежное и экономичное решение для резервного и постоянного электроснабжения.',
                $product_data['name'],
                $power,
                $engine_manufacturer
            );
            $product->set_description($description);
            $product->set_short_description(
                sprintf('Генератор %s кВт, двигатель %s', $power, $engine_manufacturer)
            );
            
            $product_id = $product->save();
            
            if ($product_id) {
                // Устанавливаем атрибуты WooCommerce
                foreach ($product_data['attrs'] as $attr_slug => $attr_value) {
                    dsa_set_product_attribute($product_id, $attr_slug, $attr_value);
                }
                
                $created++;
                $products[] = [
                    'id' => $product_id,
                    'name' => $product_data['name'],
                    'power' => $power,
                    'price' => $product_data['price']
                ];
            }
        } catch (Exception $e) {
            $errors++;
            error_log('DSA: Ошибка создания товара: ' . $e->getMessage());
        }
    }
    
    return [
        'success' => $created > 0,
        'created' => $created,
        'errors' => $errors,
        'products' => $products
    ];
}

/**
 * Получение уникальных значений атрибута из всех товаров
 * Совместимая функция для обратной совместимости (переименовано для атрибутов)
 * 
 * @param string $attribute_slug Slug атрибута (например: 'pa_power')
 * @param int|null $category_id ID категории для фильтрации (null = все товары)
 * @return array Массив уникальных значений
 */
function dsa_get_unique_product_field_values($attribute_slug, $category_id = null) {
    return array_map(function($item) {
        return $item['name'];
    }, dsa_get_unique_attribute_values($attribute_slug, $category_id));
}

/**
 * Получение диапазонов мощности с количеством товаров в каждом
 * Обновлено для работы с атрибутами WooCommerce
 * 
 * @param int|null $category_id ID категории для фильтрации (null = все товары)
 * @return array Массив диапазонов с количеством товаров
 */
function dsa_get_power_ranges_with_counts($category_id = null) {
    $ranges = dsa_get_power_ranges();
    $ranges_with_counts = [];
    $power_taxonomy = wc_attribute_taxonomy_name('power');
    
    foreach ($ranges as $key => $range) {
        // Получаем все термины мощности в диапазоне
    $terms = get_terms([
            'taxonomy' => $power_taxonomy,
        'hide_empty' => true,
        ]);
        
        $valid_term_ids = [];
        foreach ($terms as $term) {
            $power_value = intval($term->name);
            if ($power_value >= $range['min'] && $power_value < $range['max']) {
                $valid_term_ids[] = $term->term_id;
            }
        }
        
        if (!empty($valid_term_ids)) {
            // Считаем товары с этими терминами
        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
                'tax_query' => [
                    [
                        'taxonomy' => $power_taxonomy,
                        'field' => 'term_id',
                        'terms' => $valid_term_ids,
                        'operator' => 'IN'
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
        
        if ($count > 0) {
            $ranges_with_counts[$key] = [
                'name' => $range['name'],
                'min' => $range['min'],
                'max' => $range['max'],
                'count' => $count
            ];
            }
        }
    }
    
    return $ranges_with_counts;
}

/**
 * Получение опций для фильтра с форматированием
 * Обновлено для работы с атрибутами WooCommerce
 * 
 * @param string $attribute_slug Slug атрибута (например: 'pa_engine_manufacturer')
 * @param array $labels Массив меток для значений (опционально)
 * @param int|null $category_id ID категории для фильтрации (null = все товары)
 * @return array Массив опций вида ['value' => '', 'label' => '', 'count' => 0]
 */
function dsa_get_filter_options($attribute_slug, $labels = [], $category_id = null) {
    $taxonomy = wc_attribute_taxonomy_name($attribute_slug);
    
    // Получаем все термины атрибута
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => false, // Получаем все термины для дальнейшей фильтрации
        'orderby' => 'name',
        'order' => 'ASC'
    ]);
    
    if (is_wp_error($terms) || empty($terms)) {
        return [];
    }
    
    $options = [];
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
        
        // Показываем только опции с товарами
        if ($count > 0) {
            $value = $term->slug;
            $label = isset($labels[$value]) ? $labels[$value] : $term->name;
            
            $options[] = [
                'value' => $value,
                'label' => $label,
                'count' => $count
            ];
        }
    }
    
    return $options;
}
