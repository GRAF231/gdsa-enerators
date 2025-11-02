<?php
/**
 * Блок: Заголовок
 * Layout: heading
 */

$heading_text = get_sub_field('heading_text');
$heading_level = get_sub_field('heading_level') ?: 'h2';

if ($heading_text) {
    echo '<' . esc_attr($heading_level) . ' class="content-heading">';
    echo esc_html($heading_text);
    echo '</' . esc_attr($heading_level) . '>';
}
