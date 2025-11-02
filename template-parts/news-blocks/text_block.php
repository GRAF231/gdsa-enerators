<?php
/**
 * Блок: Текстовый контент (WYSIWYG)
 * Layout: text_block
 */

$text = get_sub_field('text');

if ($text) {
    echo '<div class="content-block content-block_text">';
    echo wp_kses_post($text);
    echo '</div>';
}
