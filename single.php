<?php
/**
 * Шаблон для отдельной записи (блога/новости)
 */

get_header();

// Проверяем, есть ли посты
if (have_posts()) {
    while (have_posts()) {
        the_post();
        
        // Увеличиваем счетчик просмотров
        dsa_set_post_views(get_the_ID());
        
        // Получаем ACF поля
        $show_hero = get_field('news_show_hero');
        $subtitle = get_field('news_subtitle');
        $hero_image = get_field('news_hero_image');
        
        // Если изображение не задано в ACF, используем миниатюру поста
        if (!$hero_image && has_post_thumbnail()) {
            $hero_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }
        
        // Получаем мета-информацию
        $categories = get_the_category();
        $category_name = !empty($categories) ? $categories[0]->name : 'Новости';
        $date = get_the_date('j F Y');
        $views = dsa_format_post_views(dsa_get_post_views(get_the_ID()));
        ?>
        
        <?php dsa_breadcrumbs(); ?>
        
        <?php if ($show_hero) : ?>
        <!-- Hero -->
        <section class="article-hero">
            <div class="container">
                <div class="article-hero__inner">
                    <div class="article-hero__content">
                        <h1 class="article-hero__title"><?php the_title(); ?></h1>
                        <?php if ($subtitle) : ?>
                        <p class="article-hero__subtitle"><?php echo esc_html($subtitle); ?></p>
                        <?php endif; ?>
                        <div class="article-hero__meta">
                            <time datetime="<?php echo get_the_date('Y-m-d'); ?>" class="article-hero__date">
                                <i class="fa-regular fa-calendar"></i> <?php echo esc_html($date); ?>
                            </time>
                            <span class="article-hero__category">
                                <i class="fa-solid fa-folder"></i> <?php echo esc_html($category_name); ?>
                            </span>
                            <span class="article-hero__views">
                                <i class="fa-regular fa-eye"></i> <?php echo esc_html($views); ?>
                            </span>
                        </div>
                    </div>
                    <?php if ($hero_image) : ?>
                    <div class="article-hero__image">
                        <img src="<?php echo esc_url($hero_image); ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php else : ?>
        <!-- Simple header если Hero отключен -->
        <header class="page-header">
            <div class="container">
                <h1 class="page-header__title"><?php the_title(); ?></h1>
                <div class="page-header__meta">
                    <time datetime="<?php echo get_the_date('Y-m-d'); ?>">
                        <i class="fa-regular fa-calendar"></i> <?php echo esc_html($date); ?>
                    </time>
                    <span><i class="fa-solid fa-folder"></i> <?php echo esc_html($category_name); ?></span>
                    <span><i class="fa-regular fa-eye"></i> <?php echo esc_html($views); ?></span>
                </div>
            </div>
        </header>
        <?php endif; ?>
        
        <main>
            <!-- Контент статьи -->
            <article class="news-article">
                <div class="container">
                    <div class="news-article__grid">
                        <div class="news-article__content">
                            <?php
                            // Проверяем наличие ACF flexible content блоков
                            if (have_rows('news_content_blocks')) {
                                while (have_rows('news_content_blocks')) {
                                    the_row();
                                    $layout = get_row_layout();
                                    
                                    // Рендерим каждый тип блока
                                    include(get_template_directory() . '/template-parts/news-blocks/' . $layout . '.php');
                                }
                            } else {
                                // Если ACF блоков нет, выводим стандартный контент
                                the_content();
                            }
                            ?>
                            
                            <!-- Кнопки "Поделиться" -->
                            <div class="article-share" aria-label="Поделиться">
                                <span class="article-share__label">Поделиться:</span>
                                <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                                   class="article-share__btn" 
                                   aria-label="Поделиться в Telegram" 
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    <i class="fa-brands fa-telegram"></i>
                                </a>
                                <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" 
                                   class="article-share__btn" 
                                   aria-label="Поделиться в WhatsApp" 
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="#" 
                                   class="article-share__btn" 
                                   aria-label="Скопировать ссылку" 
                                   onclick="navigator.clipboard.writeText('<?php echo get_permalink(); ?>'); alert('Ссылка скопирована!'); return false;">
                                    <i class="fa-solid fa-link"></i>
                                </a>
                            </div>
                            
                            <!-- Навигация по записям -->
                            <nav class="article-nav" aria-label="Навигация по новостям">
                                <?php
                                $prev_post = get_previous_post();
                                $next_post = get_next_post();
                                
                                if ($prev_post) {
                                    echo '<a class="article-nav__link article-nav__link_prev" href="' . get_permalink($prev_post) . '">';
                                    echo '<i class="fa-solid fa-arrow-left"></i><span>' . esc_html($prev_post->post_title) . '</span>';
                                    echo '</a>';
                                }
                                
                                // Ссылка на список новостей
                                $news_page_id = get_option('page_for_posts');
                                $news_page_url = $news_page_id ? get_permalink($news_page_id) : home_url('/news/');
                                echo '<a class="article-nav__link article-nav__link_list" href="' . esc_url($news_page_url) . '">';
                                echo '<i class="fa-solid fa-list"></i><span>К списку новостей</span>';
                                echo '</a>';
                                
                                if ($next_post) {
                                    echo '<a class="article-nav__link article-nav__link_next" href="' . get_permalink($next_post) . '">';
                                    echo '<span>' . esc_html($next_post->post_title) . '</span><i class="fa-solid fa-arrow-right"></i>';
                                    echo '</a>';
                                }
                                ?>
                            </nav>
                        </div>
                        
                        <!-- Sidebar -->
                        <aside class="news-article__sidebar">
                            <?php
                            // Похожие материалы
                            $related_posts = get_field('news_sidebar_related');
                            
                            // Если не заданы вручную, получаем автоматически
                            if (empty($related_posts)) {
                                $related_posts = dsa_get_related_posts(get_the_ID(), 3);
                            }
                            
                            if (!empty($related_posts)) :
                            ?>
                            <div class="sidebar-card">
                                <h3 class="sidebar-card__title">Похожие материалы</h3>
                                <ul class="sidebar-list">
                                    <?php foreach ($related_posts as $related) : ?>
                                    <li>
                                        <a href="<?php echo get_permalink($related); ?>" class="sidebar-link">
                                            <?php echo esc_html(get_the_title($related)); ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            
                            <?php
                            // CTA блок
                            $cta_title = get_field('news_sidebar_cta_title') ?: 'Нужна консультация?';
                            $cta_text = get_field('news_sidebar_cta_text') ?: 'Оставьте заявку, и инженер перезвонит в течение 15 минут.';
                            $cta_link = get_field('news_sidebar_cta_link') ?: 'mailto:order@example.com';
                            ?>
                            <div class="sidebar-card sidebar-card_contact">
                                <h3 class="sidebar-card__title"><?php echo esc_html($cta_title); ?></h3>
                                <p class="sidebar-card__text"><?php echo esc_html($cta_text); ?></p>
                                <button type="button" class="btn btn_type_primary sidebar-card__btn" onclick="openCallbackModal()">Связаться</button>
                            </div>
                        </aside>
                    </div>
                </div>
            </article>
        </main>
        
        <?php
    }
}

get_footer();
?>
