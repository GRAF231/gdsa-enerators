<?php
/**
 * Блок: Таблица характеристик
 * Layout: specs_table
 */

$specs_title = get_sub_field('specs_title');
$specs_rows = get_sub_field('specs_rows');

if ($specs_rows) {
    if ($specs_title) {
        echo '<h3 class="specs__title">' . esc_html($specs_title) . '</h3>';
    }
    
    echo '<div class="specs">';
    echo '<div class="specs__grid">';
    
    foreach ($specs_rows as $row) {
        echo '<div class="specs__row">';
        echo '<span class="specs__label">' . esc_html($row['label']) . '</span>';
        echo '<span class="specs__value">' . esc_html($row['value']) . '</span>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
}
