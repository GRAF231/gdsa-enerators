<?php
/**
 * CONTACT FORM 7 INTEGRATION
 * Интеграция с Contact Form 7
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Отключение автоматического добавления тегов <p> и <br> в Contact Form 7
 * Это необходимо для корректной работы с кастомной версткой модального окна
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Удаление лишних тегов из вывода CF7
 */
add_filter('wpcf7_form_elements', function($content) {
    // Удаляем пустые теги <p>
    $content = preg_replace('/<p>\s*<\/p>/i', '', $content);
    // Удаляем одиночные <br>
    $content = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/i', '', $content);
    return $content;
});
