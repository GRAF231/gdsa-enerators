<?php
/**
 * BREADCRUMBS
 * Функции для хлебных крошек
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Вспомогательная функция: добавляет разделитель хлебных крошек
 */
function dsa_breadcrumb_separator() {
    echo '<li class="breadcrumbs__separator" aria-hidden="true">»</li>';
}

/**
 * Вспомогательная функция: добавляет ссылку в хлебных крошках
 */
function dsa_breadcrumb_link($url, $title) {
    dsa_breadcrumb_separator();
    echo '<li class="breadcrumbs__item">';
    echo '<a href="' . esc_url($url) . '" class="breadcrumbs__link">';
    echo '<span>' . esc_html($title) . '</span>';
    echo '</a>';
    echo '</li>';
}

/**
 * Вспомогательная функция: добавляет текущий элемент хлебных крошек
 */
function dsa_breadcrumb_current($title) {
    dsa_breadcrumb_separator();
    echo '<li class="breadcrumbs__item breadcrumbs__item_current">';
    echo '<span class="breadcrumbs__current">' . esc_html($title) . '</span>';
    echo '</li>';
}

/**
 * Универсальная функция вывода хлебных крошек
 * Автоматически определяет тип страницы и использует названия из WordPress
 * Использование: dsa_breadcrumbs();
 */
function dsa_breadcrumbs() {
    // Не показываем хлебные крошки на главной странице
    if (is_front_page()) {
        return;
    }
    
    echo '<nav class="breadcrumbs" aria-label="Навигационная цепочка">';
    echo '<div class="container">';
    echo '<ol class="breadcrumbs__list">';
    
    // Главная страница (всегда первая)
    echo '<li class="breadcrumbs__item">';
    echo '<a href="' . esc_url(home_url()) . '" class="breadcrumbs__link">';
    echo '<i class="fa-solid fa-home breadcrumbs__icon" aria-hidden="true"></i>';
    echo '<span>Главная</span>';
    echo '</a>';
    echo '</li>';
    
    // Архив пользовательского типа записи (CPT)
    if (is_post_type_archive()) {
        $post_type = get_query_var('post_type');
        if (is_array($post_type)) {
            $post_type = reset($post_type);
        }
        $post_type_obj = get_post_type_object($post_type);
        
        if ($post_type_obj) {
            dsa_breadcrumb_current($post_type_obj->labels->name);
        }
    }
    // Одиночная запись CPT или стандартного типа
    elseif (is_singular()) {
        $post_type = get_post_type();
        
        // Если это не стандартная запись (post) или страница, добавляем ссылку на архив
        if ($post_type !== 'post' && $post_type !== 'page') {
            // Специальная обработка для типа "project" - используем страницу "Выполненные проекты"
            if ($post_type === 'project') {
                $projects_page = get_pages([
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'template-projects.php'
                ]);
                
                if (!empty($projects_page)) {
                    $projects_page_url = get_permalink($projects_page[0]->ID);
                    $projects_page_title = get_the_title($projects_page[0]->ID);
                    dsa_breadcrumb_link($projects_page_url, $projects_page_title);
                } else {
                    // Если страница не найдена, используем стандартный архив
                    $post_type_obj = get_post_type_object($post_type);
                    $archive_link = get_post_type_archive_link($post_type);
                    if ($post_type_obj && $archive_link) {
                        dsa_breadcrumb_link($archive_link, $post_type_obj->labels->name);
                    }
                }
            } else {
                // Для других CPT используем стандартный архив
                $post_type_obj = get_post_type_object($post_type);
                $archive_link = get_post_type_archive_link($post_type);
                
                if ($post_type_obj && $archive_link) {
                    dsa_breadcrumb_link($archive_link, $post_type_obj->labels->name);
                }
            }
        }
        // Для стандартных записей (post) добавляем категорию
        elseif ($post_type === 'post') {
            $categories = get_the_category();
            if (!empty($categories)) {
                $category = $categories[0];
                dsa_breadcrumb_link(get_category_link($category->term_id), $category->name);
            }
        }
        
        // Название текущей записи/страницы
        dsa_breadcrumb_current(get_the_title());
    }
    // Архив категории
    elseif (is_category()) {
        dsa_breadcrumb_current(single_cat_title('', false));
    }
    // Архив тегов
    elseif (is_tag()) {
        dsa_breadcrumb_current(single_tag_title('', false));
    }
    // Страница поиска
    elseif (is_search()) {
        dsa_breadcrumb_current('Результаты поиска: ' . get_search_query());
    }
    // Страница 404
    elseif (is_404()) {
        dsa_breadcrumb_current('Страница не найдена');
    }
    
    echo '</ol>';
    echo '</div>';
    echo '</nav>';
}
