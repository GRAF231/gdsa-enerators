<?php
/**
 * Блок: Список
 * Layout: list
 */

$list_type = get_sub_field('list_type') ?: 'ul';
$list_items = get_sub_field('list_items');

if ($list_items) {
    $list_class = ($list_type === 'ol') ? 'list list--ordered' : 'list';
    
    echo '<' . esc_attr($list_type) . ' class="' . esc_attr($list_class) . '">';
    
    foreach ($list_items as $item) {
        echo '<li>' . esc_html($item['item_text']) . '</li>';
    }
    
    echo '</' . esc_attr($list_type) . '>';
}
