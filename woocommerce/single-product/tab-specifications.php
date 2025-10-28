<?php
/**
 * Tab: Specifications
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Массив характеристик для вывода
$specs = [
    'engine_volume' => 'Объём двигателя, л',
    'country_engine' => 'Страна производства двигателя',
    'power' => 'Номинальная мощность, кВт',
    'max_power' => 'Максимальная мощность, кВт',
    'voltage' => 'Напряжение, В',
    'frequency' => 'Частота',
    'phases' => 'Количество фаз',
    'oil_volume' => 'Объём масляной системы, л',
    'cylinder_config' => 'Расположение цилиндров',
    'cooling_type' => 'Тип охлаждения двигателя',
    'rotation_speed' => 'Частота вращения, об/мин',
    'fuel_tank_volume' => 'Объём топливного бака, л',
    'fuel_consumption' => 'Расход топлива, л/ч',
    'start_type' => 'Тип запуска',
    'noise_level' => 'Уровень шума, дБ (A)',
    'warranty' => 'Гарантия',
];
?>

<div class="specs-grid">
    <?php
    foreach ($specs as $key => $label) :
        $value = get_field($key);
        if ($value) :
    ?>
        <div class="spec-item">
            <span class="spec-label"><?php echo esc_html($label); ?></span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo esc_html($value); ?></span>
        </div>
    <?php 
        endif;
    endforeach; 
    ?>
</div>

<!-- Генератор переменного тока -->
<?php if (get_field('generator_model_1') || get_field('generator_model_2')) : ?>
<div class="specs-section">
    <h3 class="specs-section__title">Генератор переменного тока</h3>
    <div class="specs-section__content">
        <?php if (get_field('generator_model_1')) : ?>
        <div class="spec-item">
            <span class="spec-label">Модель 1</span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo esc_html(get_field('generator_model_1')); ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (get_field('generator_model_2')) : ?>
        <div class="spec-item">
            <span class="spec-label">Модель 2</span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo esc_html(get_field('generator_model_2')); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Габариты ДЭС -->
<?php if (get_field('dimensions') || get_field('weight')) : ?>
<div class="specs-section">
    <h3 class="specs-section__title">Габариты и вес ДЭС</h3>
    <div class="specs-section__content">
        <?php if (get_field('dimensions')) : ?>
        <div class="spec-item">
            <span class="spec-label">Габариты, мм</span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo esc_html(get_field('dimensions')); ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (get_field('weight')) : ?>
        <div class="spec-item">
            <span class="spec-label">Вес, кг</span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo esc_html(get_field('weight')); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
