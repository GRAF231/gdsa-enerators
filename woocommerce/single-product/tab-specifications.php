<?php
/**
 * Tab: Specifications
 *
 * @package DSA_Generators
 * @version 2.0.0 - Использует WooCommerce атрибуты с группировкой
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;
$product_id = $product->get_id();

// Получаем все атрибуты товара, сгруппированные по категориям
$grouped_attributes = dsa_get_product_attributes_grouped($product_id);

if (empty($grouped_attributes)) {
    echo '<p>Характеристики не указаны.</p>';
    return;
}

// Выводим каждую группу характеристик
foreach ($grouped_attributes as $group_name => $attributes) {
    if (empty($attributes)) {
        continue;
    }
    ?>
    <div class="specs-section">
        <h3 class="specs-section__title"><?php echo esc_html($group_name); ?></h3>
        <div class="specs-grid">
            <?php foreach ($attributes as $attr) : ?>
            <div class="spec-item" title="<?php echo esc_attr($attr['note']); ?>">
                <span class="spec-label"><?php echo esc_html($attr['label']); ?></span>
                <span class="spec-dots"></span>
                <span class="spec-value"><?php echo esc_html($attr['value']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
?>
