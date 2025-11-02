<?php
/**
 * Блок: Цитата
 * Layout: quote
 */

$quote_text = get_sub_field('quote_text');
$quote_author = get_sub_field('quote_author');

if ($quote_text) {
    echo '<blockquote class="quote">';
    echo '<p>' . esc_html($quote_text) . '</p>';
    
    if ($quote_author) {
        echo '<cite>' . esc_html($quote_author) . '</cite>';
    }
    
    echo '</blockquote>';
}
