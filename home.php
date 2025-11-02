<?php
get_header(); 

// Параметры запроса
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$category_slug = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Формируем аргументы запроса
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 12, // Будет переопределено в pre_get_posts
    'paged' => $paged,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

// Добавляем фильтр по категории
if ($category_slug && $category_slug !== 'all') {
    $args['category_name'] = $category_slug;
}

$news_query = new WP_Query($args);
?>

<?php dsa_breadcrumbs(); ?>

<header class="page-header">
    <div class="container">
        <h1 class="page-header__title">Новости и события</h1>
        <p class="page-header__subtitle">Актуальная информация о нашей компании, новых продуктах и проектах</p>
    </div>
</header>

<!-- Основной контент -->
<main class="main-content" role="main">
    <!-- Фильтры новостей -->
    <section class="news-filters">
        <div class="container">
            <div class="news-filters__tabs">
                <?php
                // Кнопка "Все новости"
                $all_active = (!$category_slug || $category_slug === 'all') ? ' news-filters__tab_active' : '';
                echo '<button class="news-filters__tab' . $all_active . '" data-filter="all">Все новости</button>';
                
                // Получаем категории
                $categories = dsa_get_news_categories();
                
                foreach ($categories as $category) {
                    $active_class = ($category_slug === $category->slug) ? ' news-filters__tab_active' : '';
                    echo '<button class="news-filters__tab' . $active_class . '" data-filter="' . esc_attr($category->slug) . '">';
                    echo esc_html($category->name);
                    echo '</button>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Новости -->
    <section class="news-grid">
        <div class="container">
            <div class="news-grid__items">
                <?php
                if ($news_query->have_posts()) {
                    while ($news_query->have_posts()) {
                        $news_query->the_post();
                        echo dsa_render_news_card(get_post());
                    }
                } else {
                    // Красивый блок "ничего не найдено"
                    echo dsa_render_no_news_found($category_slug);
                }
                
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>

    <!-- Пагинация -->
    <?php if ($news_query->max_num_pages > 1) : ?>
    <div class="container">
        <?php dsa_news_pagination($news_query); ?>
    </div>
    <?php endif; ?>

    <!-- Форма обратной связи -->
    <section class="news-contact">
        <div class="container">
            <div class="contact-form">
                <h2 class="contact-form__title">Подпишитесь на наши новости</h2>
                <p class="contact-form__subtitle">Получайте актуальную информацию о новых продуктах, проектах и событиях компании</p>
                <?php
                // Проверяем наличие Contact Form 7
                if (function_exists('wpcf7') && defined('WPCF7_VERSION')) {
                    // TODO: Заменить на реальный ID формы после её создания
                    // echo do_shortcode('[contact-form-7 id="XXX" title="Подписка на новости"]');
                    
                    // Временный fallback HTML форма
                    ?>
                    <form class="contact-form__form" method="post" action="">
                        <div class="contact-form__fields">
                            <div class="contact-form__column">
                                <div class="form-group">
                                    <label for="news-name" class="form-label">Имя</label>
                                    <input type="text" id="news-name" name="news-name" class="form-input" placeholder="Введите ваше имя" required>
                                </div>
                                <div class="form-group">
                                    <label for="news-email" class="form-label">E-mail</label>
                                    <input type="email" id="news-email" name="news-email" class="form-input" placeholder="Введите ваш email" required>
                                </div>
                                <div class="form-group">
                                    <label for="news-company" class="form-label">Компания</label>
                                    <input type="text" id="news-company" name="news-company" class="form-input" placeholder="Название вашей компании">
                                </div>
                            </div>
                            <div class="contact-form__column">
                                <div class="form-group">
                                    <label for="news-interests" class="form-label">Интересы</label>
                                    <textarea id="news-interests" name="news-interests" class="form-textarea" placeholder="Какие темы вас интересуют? (продукция, проекты, события и т.д.)"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="contact-form__footer">
                            <div class="form-checkbox">
                                <input type="checkbox" id="news-consent" name="news-consent" class="form-checkbox__input" required>
                                <label for="news-consent" class="form-checkbox__label">
                                    Согласен на получение новостной рассылки и 
                                    <a href="<?php echo home_url('/privacy-policy/'); ?>" class="form-checkbox__link">обработку персональных данных</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn_type_primary contact-form__submit">
                                <i class="fa-solid fa-bell"></i>
                                <span>Подписаться на новости</span>
                            </button>
                        </div>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>