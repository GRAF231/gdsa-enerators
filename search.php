
<?php
/**
 * The template for displaying search results
 */

get_header();
?>

<main class="main-content search-results-page">
    <!-- Заголовок поиска -->
    <div class="search-header">
        <div class="container">
            <div class="search-header__content">
                <h1 class="search-header__title">
                    <?php if (have_posts()) : ?>
                        Результаты поиска: <span class="search-header__query"><?php echo get_search_query(); ?></span>
                    <?php else : ?>
                        Ничего не найдено
                    <?php endif; ?>
                </h1>
                
                <?php if (have_posts()) : ?>
                    <p class="search-header__count">
                        <?php
                        global $wp_query;
                        $total = $wp_query->found_posts;
                        $text = _n('Найден %s результат', 'Найдено %s результатов', $total, 'dsa-generators');
                        printf($text, '<strong>' . number_format_i18n($total) . '</strong>');
                        ?>
                    </p>
                <?php endif; ?>
                
                <!-- Форма нового поиска -->
                <form role="search" method="get" class="search-header__form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-header__input-wrapper">
                        <input type="search" 
                               class="search-header__input" 
                               placeholder="Попробуйте другой запрос..." 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" 
                               required />
                        <button type="submit" class="search-header__button">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" 
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Найти
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="search-results">
            
            <?php if (have_posts()) : ?>
                
                <!-- Список результатов -->
                <div class="search-results__list">
                    <?php
                    while (have_posts()) :
                        the_post();
                        
                        // Определяем тип контента
                        $post_type = get_post_type();
                        $post_type_object = get_post_type_object($post_type);
                        $post_type_name = $post_type_object ? $post_type_object->labels->singular_name : 'Запись';
                        
                        // Для WooCommerce товаров
                        $is_product = ($post_type === 'product');
                        $is_project = ($post_type === 'project');
                        $is_tender = ($post_type === 'tender');
                        
                        // Определяем иконку и цвет бейджа
                        $badge_class = 'search-result-item__badge';
                        $badge_icon = '';
                        if ($is_product) {
                            $badge_class .= ' search-result-item__badge--product';
                            $badge_icon = '<i class="fa-solid fa-box"></i>';
                        } elseif ($is_project) {
                            $badge_class .= ' search-result-item__badge--project';
                            $badge_icon = '<i class="fa-solid fa-building"></i>';
                        } elseif ($is_tender) {
                            $badge_class .= ' search-result-item__badge--tender';
                            $badge_icon = '<i class="fa-solid fa-file-contract"></i>';
                        } else {
                            $badge_class .= ' search-result-item__badge--default';
                            $badge_icon = '<i class="fa-solid fa-file-lines"></i>';
                        }
                        ?>
                        
                        <article class="search-result-item <?php echo $is_product ? 'search-result-item--product' : ''; ?>">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="search-result-item__image-wrapper">
                                    <a href="<?php the_permalink(); ?>" class="search-result-item__image-link">
                                        <div class="search-result-item__image">
                                            <?php the_post_thumbnail('medium'); ?>
                                            <div class="search-result-item__image-overlay">
                                                <span class="search-result-item__view-text">Смотреть</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="search-result-item__image-wrapper">
                                    <a href="<?php the_permalink(); ?>" class="search-result-item__image-link">
                                        <div class="search-result-item__image search-result-item__image--placeholder">
                                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 19V5C21 3.9 20.1 3 19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19ZM8.5 13.5L11 16.51L14.5 12L19 18H5L8.5 13.5Z" fill="currentColor" opacity="0.3"/>
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="search-result-item__content">
                                <div class="<?php echo esc_attr($badge_class); ?>">
                                    <?php echo $badge_icon; ?>
                                    <span><?php echo esc_html($post_type_name); ?></span>
                                </div>
                                
                                <h2 class="search-result-item__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <?php if ($is_product) : ?>
                                    <?php
                                    $product = wc_get_product(get_the_ID());
                                    if ($product) :
                                        // Получаем мощность из ACF
                                        $power = get_field('power', get_the_ID());
                                    ?>
                                        <div class="search-result-item__product-info">
                                            <?php if ($power) : ?>
                                                <div class="search-result-item__power">
                                                    <i class="fa-solid fa-bolt"></i>
                                                    <span><?php echo esc_html($power); ?> кВт</span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="search-result-item__price">
                                                <?php echo $product->get_price_html(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <div class="search-result-item__excerpt">
                                    <?php 
                                    if (has_excerpt()) {
                                        echo wp_trim_words(get_the_excerpt(), 25, '...');
                                    } else {
                                        echo wp_trim_words(strip_tags(get_the_content()), 25, '...');
                                    }
                                    ?>
                                </div>
                                
                                <div class="search-result-item__footer">
                                    <div class="search-result-item__meta">
                                        <i class="fa-regular fa-calendar"></i>
                                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d.m.Y'); ?></time>
                                        <?php if (!$is_product) : ?>
                                            <span class="separator">•</span>
                                            <i class="fa-regular fa-user"></i>
                                            <span class="author"><?php the_author(); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="search-result-item__link">
                                        Подробнее
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                </div>
                
                <!-- Пагинация -->
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Назад',
                    'next_text' => 'Далее <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">Страница </span>',
                ));
                ?>
                
            <?php else : ?>
                
                <!-- Пустые результаты -->
                <div class="search-no-results">
                    <div class="search-no-results__icon">
                        <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="80" cy="80" r="40" stroke="#3b5fdb" stroke-width="8" fill="none"/>
                            <path d="M110 110L150 150" stroke="#3b5fdb" stroke-width="8" stroke-linecap="round"/>
                            <path d="M65 75L75 85M85 75L75 85" stroke="#ff4444" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    
                    <h2 class="search-no-results__title">По вашему запросу ничего не найдено</h2>
                    <p class="search-no-results__description">
                        Попробуйте изменить поисковый запрос или воспользуйтесь популярными разделами сайта.
                    </p>
                    
                    <div class="search-no-results__suggestions">
                        <h3>Возможно, вас заинтересует:</h3>
                        <ul>
                            <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Каталог электростанций</a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('projects'))); ?>">Выполненные проекты</a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">О компании</a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contacts'))); ?>">Контакты</a></li>
                        </ul>
                    </div>
                </div>
                
            <?php endif; ?>
            
        </div><!-- .search-results -->
    </div><!-- .container -->
</main>

<?php
get_footer();
?>

