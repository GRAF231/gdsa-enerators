<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Поддержка функций темы
function dsa_generators_theme_setup() {
    // Поддержка миниатюр записей
    add_theme_support('post-thumbnails');
    
    // Поддержка заголовка документа
    add_theme_support('title-tag');
    
    // Поддержка HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}
add_action('after_setup_theme', 'dsa_generators_theme_setup');

function dsa_generators_assets() {
    $theme_uri = get_template_directory_uri();
    $css_dir = get_template_directory() . '/assets/css/';
    $js_dir = get_template_directory() . '/assets/js/';

    // Enqueue styles
    $css_files = glob( $css_dir . '*.css' );
    foreach ( $css_files as $file ) {
        $handle = 'dsa-' . sanitize_title( basename( $file, '.css' ) );
        $src = $theme_uri . '/assets/css/' . basename( $file );
        wp_enqueue_style( $handle, $src );
    }

    $css_sub_dirs = glob( $css_dir . '*', GLOB_ONLYDIR );
    foreach ($css_sub_dirs as $dir) {
        $css_files = glob( $dir . '/*.css' );
        foreach ( $css_files as $file ) {
            $handle = 'dsa-' . sanitize_title( basename( $dir ) ) . '-' . sanitize_title( basename( $file, '.css' ) );
            $src = $theme_uri . '/assets/css/' . basename($dir) . '/' . basename( $file );
            wp_enqueue_style( $handle, $src );
        }
    }


    // Enqueue scripts
    $js_files = glob( $js_dir . '*.js' );
    foreach ( $js_files as $file ) {
        $handle = 'dsa-' . sanitize_title( basename( $file, '.js' ) );
        $src = $theme_uri . '/assets/js/' . basename( $file );
        wp_enqueue_script( $handle, $src, array(), false, true );
    }

    $js_sub_dirs = glob( $js_dir . '*', GLOB_ONLYDIR );
    foreach ($js_sub_dirs as $dir) {
        $js_files = glob( $dir . '/*.js' );
        foreach ( $js_files as $file ) {
            $handle = 'dsa-' . sanitize_title( basename( $dir ) ) . '-' . sanitize_title( basename( $file, '.js' ) );
            $src = $theme_uri . '/assets/js/' . basename($dir) . '/' . basename( $file );
            wp_enqueue_script( $handle, $src, array(), false, true );
        }
    }

    // Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css' );

    // Google Fonts
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap', array(), null );

}
add_action( 'wp_enqueue_scripts', 'dsa_generators_assets' );

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
    if ( is_front_page() ) {
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
    if ( is_post_type_archive() ) {
        $post_type = get_query_var('post_type');
        if ( is_array($post_type) ) {
            $post_type = reset($post_type);
        }
        $post_type_obj = get_post_type_object($post_type);
        
        if ( $post_type_obj ) {
            dsa_breadcrumb_current($post_type_obj->labels->name);
        }
    }
    // Одиночная запись CPT или стандартного типа
    elseif ( is_singular() ) {
        $post_type = get_post_type();
        
        // Если это не стандартная запись (post) или страница, добавляем ссылку на архив
        if ( $post_type !== 'post' && $post_type !== 'page' ) {
            $post_type_obj = get_post_type_object($post_type);
            $archive_link = get_post_type_archive_link($post_type);
            
            if ( $post_type_obj && $archive_link ) {
                dsa_breadcrumb_link($archive_link, $post_type_obj->labels->name);
            }
        }
        // Для стандартных записей (post) добавляем категорию
        elseif ( $post_type === 'post' ) {
            $categories = get_the_category();
            if ( !empty($categories) ) {
                $category = $categories[0];
                dsa_breadcrumb_link(get_category_link($category->term_id), $category->name);
            }
        }
        
        // Название текущей записи/страницы
        dsa_breadcrumb_current(get_the_title());
    }
    // Архив категории
    elseif ( is_category() ) {
        dsa_breadcrumb_current(single_cat_title('', false));
    }
    // Архив тегов
    elseif ( is_tag() ) {
        dsa_breadcrumb_current(single_tag_title('', false));
    }
    // Страница поиска
    elseif ( is_search() ) {
        dsa_breadcrumb_current('Результаты поиска: ' . get_search_query());
    }
    // Страница 404
    elseif ( is_404() ) {
        dsa_breadcrumb_current('Страница не найдена');
    }
    
    echo '</ol>';
    echo '</div>';
    echo '</nav>';
}

// Регистрация пользовательского типа записи "Проекты"
function register_project_cpt() {
    register_post_type('project', [
        'labels' => [
            'name' => 'Проекты',
            'singular_name' => 'Проект',
            'add_new' => 'Добавить проект',
            'add_new_item' => 'Добавить новый проект',
            'edit_item' => 'Редактировать проект',
            'new_item' => 'Новый проект',
            'view_item' => 'Просмотр проекта',
            'search_items' => 'Искать проекты',
            'not_found' => 'Проекты не найдены',
            'not_found_in_trash' => 'В корзине проектов не найдено',
        ],
        'public' => true,
        'has_archive' => 'projects',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'projects'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-portfolio',
    ]);
}
add_action('init', 'register_project_cpt');

// Регистрация пользовательского типа записи "Тендеры"
function register_tender_cpt() {
    register_post_type('tender', [
        'labels' => [
            'name' => 'Тендеры',
            'singular_name' => 'Тендер',
            'add_new' => 'Добавить тендер',
            'add_new_item' => 'Добавить новый тендер',
            'edit_item' => 'Редактировать тендер',
            'new_item' => 'Новый тендер',
            'view_item' => 'Просмотр тендера',
            'search_items' => 'Искать тендеры',
            'not_found' => 'Тендеры не найдены',
            'not_found_in_trash' => 'В корзине тендеров не найдено',
        ],
        'public' => true,
        'has_archive' => 'tenders',
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'tenders'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-gavel',
    ]);
}
add_action('init', 'register_tender_cpt');

// Автоматический импорт ACF полей из JSON
add_filter('acf/settings/save_json', function($path) {
    return get_stylesheet_directory() . '/acf-exports';
});

add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-exports';
    return $paths;
});

// ============================================
// WOOCOMMERCE INTEGRATION
// ============================================

/**
 * Поддержка WooCommerce в теме
 */
function dsa_add_woocommerce_support() {
    // Базовая поддержка WooCommerce
    add_theme_support('woocommerce');
    
    // Поддержка галереи товара
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'dsa_add_woocommerce_support');

/**
 * Отключение стандартных стилей WooCommerce
 * Используем собственные стили для полного контроля над дизайном
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Подключение кастомных стилей и скриптов WooCommerce
 */
function dsa_woocommerce_assets() {
    if (class_exists('WooCommerce')) {
        $theme_uri = get_template_directory_uri();
        
        // WooCommerce CSS
        $wc_css_dir = get_template_directory() . '/assets/css/woocommerce/';
        if (is_dir($wc_css_dir)) {
            $wc_css_files = glob($wc_css_dir . '*.css');
            foreach ($wc_css_files as $file) {
                $handle = 'dsa-wc-' . sanitize_title(basename($file, '.css'));
                $src = $theme_uri . '/assets/css/woocommerce/' . basename($file);
                wp_enqueue_style($handle, $src, array(), filemtime($file));
            }
        }
        
        // WooCommerce JS
        $wc_js_dir = get_template_directory() . '/assets/js/woocommerce/';
        if (is_dir($wc_js_dir)) {
            $wc_js_files = glob($wc_js_dir . '*.js');
            foreach ($wc_js_files as $file) {
                $handle = 'dsa-wc-' . sanitize_title(basename($file, '.js'));
                $src = $theme_uri . '/assets/js/woocommerce/' . basename($file);
                wp_enqueue_script($handle, $src, array('jquery'), filemtime($file), true);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'dsa_woocommerce_assets', 20);

/**
 * Настройка базовых параметров WooCommerce
 */
function dsa_woocommerce_setup() {
    // Количество товаров на странице каталога
    add_filter('loop_shop_per_page', function() {
        return 12; // 12 товаров на странице
    });
    
    // Количество связанных товаров
    add_filter('woocommerce_output_related_products_args', function($args) {
        $args['posts_per_page'] = 4;
        $args['columns'] = 4;
        return $args;
    });
}
add_action('init', 'dsa_woocommerce_setup');

/**
 * Хлебные крошки WooCommerce - использовать нашу функцию
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

/**
 * Обертка контента WooCommerce
 */
function dsa_woocommerce_wrapper_start() {
    echo '<div class="main-content">';
    echo '<div class="container">';
}
add_action('woocommerce_before_main_content', 'dsa_woocommerce_wrapper_start', 10);

function dsa_woocommerce_wrapper_end() {
    echo '</div>'; // container
    echo '</div>'; // main-content
}
add_action('woocommerce_after_main_content', 'dsa_woocommerce_wrapper_end', 10);

// ============================================
// WOOCOMMERCE CATALOG FUNCTIONS
// ============================================

/**
 * Определение текущего вида каталога (табличный или карточный)
 * Использует GET параметр и Cookie для сохранения выбора
 * 
 * @return string 'list' или 'cards'
 */
function dsa_get_catalog_view() {
    // 1. Проверить GET параметр
    if (isset($_GET['view']) && in_array($_GET['view'], ['list', 'cards'])) {
        $view = sanitize_text_field($_GET['view']);
        // Сохранить в cookie на 30 дней
        setcookie('catalog_view', $view, time() + (86400 * 30), '/');
        return $view;
    }
    
    // 2. Проверить Cookie
    if (isset($_COOKIE['catalog_view']) && in_array($_COOKIE['catalog_view'], ['list', 'cards'])) {
        return sanitize_text_field($_COOKIE['catalog_view']);
    }
    
    // 3. Дефолтный вид - табличный
    return 'list';
}

/**
 * Получение диапазонов мощности для группировки товаров
 * 
 * @return array Ассоциативный массив диапазонов
 */
function dsa_get_power_ranges() {
    return [
        '16-40' => ['name' => '16-40 кВт', 'min' => 16, 'max' => 40],
        '40-100' => ['name' => '40-100 кВт', 'min' => 40, 'max' => 100],
        '100-200' => ['name' => '100-200 кВт', 'min' => 100, 'max' => 200],
        '200-500' => ['name' => '200-500 кВт', 'min' => 200, 'max' => 500],
        '500-1000' => ['name' => '500-1000 кВт', 'min' => 500, 'max' => 1000],
        '1000-2000' => ['name' => '1000-2000 кВт', 'min' => 1000, 'max' => 2000],
        '2000-3000' => ['name' => '2000-3000 кВт', 'min' => 2000, 'max' => 3000],
    ];
}

/**
 * Получение мощности товара из ACF поля
 * 
 * @param WC_Product $product Объект товара
 * @return int Мощность в кВт
 */
function dsa_get_product_power($product) {
    $power = get_field('power', $product->get_id());
    return $power ? intval($power) : 0;
}

/**
 * Определение группы мощности для товара
 * 
 * @param int $power Мощность в кВт
 * @return string|null Ключ группы или null
 */
function dsa_determine_power_group($power) {
    $ranges = dsa_get_power_ranges();
    
    foreach ($ranges as $key => $range) {
        if ($power >= $range['min'] && $power < $range['max']) {
            return $key;
        }
    }
    
    return null;
}

/**
 * Вывод заголовков таблицы для табличного вида
 */
function dsa_catalog_table_header() {
    ?>
    <div class="catalog-table-header">
        <div class="catalog-table-header__col catalog-table-header__col_image"></div>
        <div class="catalog-table-header__col catalog-table-header__col_name">Название модели</div>
        <div class="catalog-table-header__col catalog-table-header__col_engine">Двигатель</div>
        <div class="catalog-table-header__col catalog-table-header__col_power">Мощность</div>
        <div class="catalog-table-header__col catalog-table-header__col_country">Страна сборки</div>
        <div class="catalog-table-header__col catalog-table-header__col_price">Цена</div>
    </div>
    <?php
}

/**
 * Вывод товара в табличном виде
 * 
 * @param WC_Product $product Объект товара
 */
function dsa_render_catalog_product_list($product) {
    // Получение данных товара
    $product_id = $product->get_id();
    $title = $product->get_name();
    $permalink = $product->get_permalink();
    $image = $product->get_image('medium');
    $price = $product->get_price_html();
    
    // ACF поля
    $engine = get_field('engine', $product_id) ?: '—';
    $power = get_field('power', $product_id) ?: '—';
    $nominal_power = get_field('nominal_power', $product_id) ?: '';
    $country = get_field('country', $product_id) ?: '—';
    
    // Формат мощности
    $power_display = $power !== '—' ? $power . ' кВт' : '—';
    if ($nominal_power) {
        $power_display .= ' (' . $nominal_power . ' кВА)';
    }
    ?>
    <div class="catalog-product">
        <div class="catalog-product__image">
            <a href="<?php echo esc_url($permalink); ?>">
                <?php echo $image; ?>
            </a>
        </div>
        <div class="catalog-product__name">
            <h3 class="catalog-product__title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>
        </div>
        <div class="catalog-product__engine">
            <span class="catalog-product__engine-text"><?php echo esc_html($engine); ?></span>
        </div>
        <div class="catalog-product__power">
            <span class="catalog-product__power-text"><?php echo esc_html($power_display); ?></span>
        </div>
        <div class="catalog-product__country">
            <span class="catalog-product__country-text"><?php echo esc_html($country); ?></span>
        </div>
        <div class="catalog-product__price">
            <?php echo $price; ?>
        </div>
    </div>
    <?php
}

/**
 * Вывод товара в карточном виде
 * 
 * @param WC_Product $product Объект товара
 */
function dsa_render_catalog_product_cards($product) {
    // Получение данных товара
    $product_id = $product->get_id();
    $title = $product->get_name();
    $permalink = $product->get_permalink();
    $image = $product->get_image('medium');
    $price = $product->get_price_html();
    
    // ACF поля
    $engine = get_field('engine', $product_id) ?: '—';
    $power = get_field('power', $product_id) ?: '—';
    $nominal_power = get_field('nominal_power', $product_id) ?: '';
    $country = get_field('country', $product_id) ?: '—';
    
    // Формат мощности
    $power_display = $power !== '—' ? $power . ' кВт' : '—';
    if ($nominal_power) {
        $power_display .= ' (' . $nominal_power . ' кВА)';
    }
    ?>
    <div class="catalog-product">
        <div class="catalog-product__image">
            <a href="<?php echo esc_url($permalink); ?>" class="catalog-product__image-link">
                <?php echo $image; ?>
            </a>
        </div>
        <div class="catalog-product__content">
            <div class="catalog-product__header">
                <h3 class="catalog-product__title">
                    <a href="<?php echo esc_url($permalink); ?>" class="catalog-product__title-link">
                        <?php echo esc_html($title); ?>
                    </a>
                </h3>
                <div class="catalog-product__price">
                    <?php echo $price; ?>
                </div>
            </div>
            <div class="catalog-product__specs">
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-cog catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Двигатель:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($engine); ?></span>
                </div>
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-bolt catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Мощность:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($power_display); ?></span>
                </div>
                <div class="catalog-product__spec">
                    <i class="fa-solid fa-flag catalog-product__spec-icon" aria-hidden="true"></i>
                    <span class="catalog-product__spec-label">Страна:</span>
                    <span class="catalog-product__spec-value"><?php echo esc_html($country); ?></span>
                </div>
            </div>
            <div class="catalog-product__actions">
                <button class="catalog-product__btn catalog-product__btn_primary" 
                        type="button"
                        data-product-id="<?php echo esc_attr($product_id); ?>">
                    <i class="fa-solid fa-cart-plus"></i>
                    <span>В корзину</span>
                </button>
                <button class="catalog-product__btn catalog-product__btn_secondary" 
                        type="button"
                        aria-label="Добавить в избранное">
                    <i class="fa-solid fa-heart"></i>
                </button>
                <button class="catalog-product__btn catalog-product__btn_secondary" 
                        type="button"
                        aria-label="Добавить к сравнению">
                    <i class="fa-solid fa-chart-line"></i>
                </button>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Основная функция вывода каталога с группировкой по мощности
 * 
 * @param string $view Вид отображения ('list' или 'cards')
 */
function dsa_render_grouped_catalog_products($view = 'list') {
    global $wp_query;
    
    if (!$wp_query->have_posts()) {
        echo '<p class="woocommerce-info">Товары не найдены.</p>';
        return;
    }
    
    // Получаем все товары из текущего запроса
    $products = [];
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        $product = wc_get_product(get_the_ID());
        if ($product) {
            $products[] = $product;
        }
    }
    wp_reset_postdata();
    
    // Группируем товары по мощности
    $grouped_products = [];
    $ranges = dsa_get_power_ranges();
    
    // Инициализация групп
    foreach ($ranges as $key => $range) {
        $grouped_products[$key] = [
            'name' => 'Группа мощности ' . $range['name'],
            'products' => []
        ];
    }
    
    // Распределение товаров по группам
    foreach ($products as $product) {
        $power = dsa_get_product_power($product);
        $group_key = dsa_determine_power_group($power);
        
        if ($group_key && isset($grouped_products[$group_key])) {
            $grouped_products[$group_key]['products'][] = $product;
        }
    }
    
    // Вывод групп с товарами
    foreach ($grouped_products as $group_key => $group_data) {
        // Пропускаем пустые группы
        if (empty($group_data['products'])) {
            continue;
        }
        
        echo '<div class="catalog-group">';
        echo '<h2 class="catalog-group__title">' . esc_html($group_data['name']) . '</h2>';
        
        // Класс контейнера зависит от вида
        $products_class = $view === 'cards' ? 'catalog-products catalog-products_view_cards' : 'catalog-products';
        echo '<div class="' . esc_attr($products_class) . '">';
        
        // Вывод товаров
        foreach ($group_data['products'] as $product) {
            if ($view === 'cards') {
                dsa_render_catalog_product_cards($product);
            } else {
                dsa_render_catalog_product_list($product);
            }
        }
        
        echo '</div>'; // .catalog-products
        echo '</div>'; // .catalog-group
    }
}

// ============================================
// WOOCOMMERCE AJAX HANDLERS
// ============================================

/**
 * AJAX handler для получения количества товаров в корзине
 */
function dsa_get_cart_count() {
    if (class_exists('WooCommerce')) {
        $count = WC()->cart->get_cart_contents_count();
        wp_send_json(['count' => $count]);
    } else {
        wp_send_json(['count' => 0]);
    }
}
add_action('wp_ajax_get_cart_count', 'dsa_get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'dsa_get_cart_count');

/**
 * Обработка добавления товара в корзину через AJAX
 */
function dsa_add_to_cart_handler() {
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(['message' => 'Product ID is required']);
        return;
    }

    $product_id = absint($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;

    if (class_exists('WooCommerce')) {
        $result = WC()->cart->add_to_cart($product_id, $quantity);
        
        if ($result) {
            $cart_count = WC()->cart->get_cart_contents_count();
            wp_send_json_success([
                'message' => 'Product added to cart',
                'cart_count' => $cart_count,
                'cart_hash' => WC()->cart->get_cart_hash()
            ]);
        } else {
            wp_send_json_error(['message' => 'Failed to add product to cart']);
        }
    } else {
        wp_send_json_error(['message' => 'WooCommerce is not active']);
    }
}
add_action('wp_ajax_woocommerce_add_to_cart', 'dsa_add_to_cart_handler');
add_action('wp_ajax_nopriv_woocommerce_add_to_cart', 'dsa_add_to_cart_handler');

// ============================================
// UNIFIED CART & CHECKOUT
// ============================================

/**
 * Перенаправление стандартной страницы корзины на unified checkout
 */
function dsa_redirect_cart_to_unified() {
    if (is_cart() && !is_checkout()) {
        // Получаем URL страницы unified checkout
        // Можно создать страницу с шаблоном "Unified Cart & Checkout"
        // или использовать кастомный endpoint
        wp_safe_redirect(wc_get_checkout_url());
        exit;
    }
}
add_action('template_redirect', 'dsa_redirect_cart_to_unified', 10);

/**
 * Настройка способов оплаты
 */
function dsa_setup_payment_gateways() {
    // По умолчанию WooCommerce предоставляет:
    // - COD (Cash on Delivery / Оплата при получении)
    // - BACS (Bank Transfer / Банковский перевод)
    // - Cheque (Check Payment / Чек)
    
    // Настройки уже доступны через админку WooCommerce
    // WooCommerce → Настройки → Платежи
}

/**
 * Настройка способов доставки
 */
function dsa_setup_shipping_methods() {
    // WooCommerce предоставляет стандартные методы:
    // - Flat Rate (Фиксированная ставка)
    // - Free Shipping (Бесплатная доставка)
    // - Local Pickup (Самовывоз)
    
    // Кастомные зоны доставки настраиваются через админку:
    // WooCommerce → Настройки → Доставка
}

/**
 * Добавление кастомного класса к body для unified checkout
 */
function dsa_unified_checkout_body_class($classes) {
    if (is_checkout() && !is_wc_endpoint_url('order-received')) {
        $classes[] = 'unified-checkout-page';
    }
    return $classes;
}
add_filter('body_class', 'dsa_unified_checkout_body_class');

/**
 * Изменение количества колонок для связанных товаров
 */
function dsa_related_products_columns() {
    return 4; // 4 товара в ряд
}
add_filter('woocommerce_related_products_columns', 'dsa_related_products_columns');

/**
 * Отключение стандартного поля купона в чекауте
 * (мы выводим его в cart-totals.php)
 */
function dsa_remove_checkout_coupon_form() {
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
}
add_action('woocommerce_before_checkout_form', 'dsa_remove_checkout_coupon_form', 9);

/**
 * Локализация текстов для JavaScript
 */
function dsa_wc_localize_scripts() {
    if (is_checkout()) {
        wp_localize_script('dsa-wc-wc-unified-checkout', 'dsaWCData', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'cartUrl' => wc_get_cart_url(),
            'checkoutUrl' => wc_get_checkout_url(),
            'nonce' => wp_create_nonce('dsa_wc_nonce'),
            'strings' => array(
                'updating' => __('Обновление корзины...', 'dsa-generators'),
                'processing' => __('Обработка заказа...', 'dsa-generators'),
                'error' => __('Произошла ошибка. Попробуйте снова.', 'dsa-generators'),
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'dsa_wc_localize_scripts', 25);
