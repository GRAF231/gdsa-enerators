<?php
/**
 * ASSETS MANAGEMENT
 * Управление подключением стилей и скриптов
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Подключение стилей и скриптов темы
 */
function dsa_generators_assets() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    
    // ============================================
    // БАЗОВЫЕ СТИЛИ (загружаются на всех страницах)
    // ============================================
    $base_styles = array(
        'variables',
        'reset',
        'typography',
        'layout',
        'utilities',
        'buttons',
        'header',
        'footer',
        'breadcrumbs',
        'pagination',
        'contact-form',
        'callback-modal',
        'page'
    );
    
    foreach ($base_styles as $style) {
        $file = $theme_dir . '/assets/css/' . $style . '.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-' . $style, $theme_uri . '/assets/css/' . $style . '.css', array(), filemtime($file));
        }
    }
    
    // ============================================
    // УСЛОВНЫЕ СТИЛИ (загружаются на специфичных страницах)
    // ============================================
    
    // Главная страница
    if (is_front_page() || is_home()) {
        $home_styles = array('home-slider', 'home-catalog', 'home-advantages', 'home-equipment', 'home-popular', 'home-projects', 'home-news', 'home-catalog-footer');
        foreach ($home_styles as $style) {
            $file = $theme_dir . '/assets/css/home/' . $style . '.css';
            if (file_exists($file)) {
                wp_enqueue_style('dsa-' . $style, $theme_uri . '/assets/css/home/' . $style . '.css', array(), filemtime($file));
            }
        }
        
        // JS для главной
        $home_scripts = array('home-slider', 'home-popular', 'home-projects');
        foreach ($home_scripts as $script) {
            $file = $theme_dir . '/assets/js/' . $script . '.js';
            if (file_exists($file)) {
                wp_enqueue_script('dsa-' . $script, $theme_uri . '/assets/js/' . $script . '.js', array('jquery'), filemtime($file), true);
            }
        }
    }
    
    // О компании
    if (is_page_template('template-about.php')) {
        $file = $theme_dir . '/assets/css/about/about.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-about', $theme_uri . '/assets/css/about/about.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/about.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-about', $theme_uri . '/assets/js/about.js', array('jquery'), filemtime($file), true);
        }
        // Лицензии
        $file = $theme_dir . '/assets/css/company-licenses.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-company-licenses', $theme_uri . '/assets/css/company-licenses.css', array(), filemtime($file));
        }
    }
    
    // Контакты
    if (is_page_template('template-contacts.php')) {
        $file = $theme_dir . '/assets/css/contacts.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-contacts', $theme_uri . '/assets/css/contacts.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/contacts.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-contacts', $theme_uri . '/assets/js/contacts.js', array('jquery'), filemtime($file), true);
        }
        $file = $theme_dir . '/assets/css/contact-form.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-contact-form', $theme_uri . '/assets/css/contact-form.css', array(), filemtime($file));
        }
    }
    
    // Производство
    if (is_page_template('template-production.php')) {
        $file = $theme_dir . '/assets/css/production.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-production', $theme_uri . '/assets/css/production.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/production.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-production', $theme_uri . '/assets/js/production.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Проекты
    if (is_page_template('template-projects.php') || is_singular('project')) {
        $file = $theme_dir . '/assets/css/projects.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-projects', $theme_uri . '/assets/css/projects.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/projects.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-projects', $theme_uri . '/assets/js/projects.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Благодарности
    if (is_page_template('template-gratitude.php')) {
        $file = $theme_dir . '/assets/css/gratitude.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-gratitude', $theme_uri . '/assets/css/gratitude.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/gratitude.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-gratitude', $theme_uri . '/assets/js/gratitude.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Новости
    if (is_page_template('template-news.php')) {
        $file = $theme_dir . '/assets/css/news.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-news', $theme_uri . '/assets/css/news.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/news.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-news', $theme_uri . '/assets/js/news.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Статья новости
    if (is_page_template('template-news-article.php')) {
        $file = $theme_dir . '/assets/css/news-article.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-news-article', $theme_uri . '/assets/css/news-article.css', array(), filemtime($file));
        }
    }
    
    // Тендеры
    if (is_page_template('template-tenders.php') || is_singular('tender')) {
        $file = $theme_dir . '/assets/css/tenders.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-tenders', $theme_uri . '/assets/css/tenders.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/tenders.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-tenders', $theme_uri . '/assets/js/tenders.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Проектирование и EPC
    if (is_page_template('template-design-epc.php')) {
        $file = $theme_dir . '/assets/css/design-epc.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-design-epc', $theme_uri . '/assets/css/design-epc.css', array(), filemtime($file));
        }
        $file = $theme_dir . '/assets/js/design-epc.js';
        if (file_exists($file)) {
            wp_enqueue_script('dsa-design-epc', $theme_uri . '/assets/js/design-epc.js', array('jquery'), filemtime($file), true);
        }
    }
    
    // Страница 404
    if (is_404()) {
        $file = $theme_dir . '/assets/css/error-404.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-error-404', $theme_uri . '/assets/css/error-404.css', array(), filemtime($file));
        }
    }
    
    // Страница результатов поиска
    if (is_search()) {
        $file = $theme_dir . '/assets/css/search.css';
        if (file_exists($file)) {
            wp_enqueue_style('dsa-search', $theme_uri . '/assets/css/search.css', array(), filemtime($file));
        }
    }
    
    // ============================================
    // БАЗОВЫЙ JS (на всех страницах)
    // ============================================
    $file = $theme_dir . '/assets/js/main.js';
    if (file_exists($file)) {
        wp_enqueue_script('dsa-main', $theme_uri . '/assets/js/main.js', array('jquery'), filemtime($file), true);
    }
    
    // Мобильный поиск
    $file = $theme_dir . '/assets/js/mobile-search.js';
    if (file_exists($file)) {
        wp_enqueue_script('dsa-mobile-search', $theme_uri . '/assets/js/mobile-search.js', array(), filemtime($file), true);
    }
    
    // Модальное окно обратного звонка
    $file = $theme_dir . '/assets/js/callback-modal.js';
    if (file_exists($file)) {
        wp_enqueue_script('dsa-callback-modal', $theme_uri . '/assets/js/callback-modal.js', array(), filemtime($file), true);
        
        // Передаем данные для AJAX
        wp_localize_script('dsa-callback-modal', 'dsaCallbackData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dsa_callback_nonce')
        ));
    }
    
    // ============================================
    // ВНЕШНИЕ БИБЛИОТЕКИ
    // ============================================
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap', array(), null);

    wp_enqueue_style('dsa-style', $theme_uri . '/style.css', array(), null);
}
add_action('wp_enqueue_scripts', 'dsa_generators_assets');
