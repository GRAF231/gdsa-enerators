<?php
/**
 * Template Name: Благодарности
 * 
 * Шаблон страницы благодарности с ACF полями
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

<!-- Заголовок страницы -->
<section class="page-header">
    <div class="container">
        <h1 class="page-header__title"><?php echo esc_html(get_field('gratitude_page_title') ?: 'Благодарности и сертификаты'); ?></h1>
        <p class="page-header__description">
            <?php echo esc_html(get_field('gratitude_page_description') ?: 'Официальные документы, благодарственные письма, сертификаты и награды, подтверждающие высокое качество наших услуг и надежность оборудования'); ?>
        </p>
    </div>
</section>

<!-- Основной контент -->
<section class="gratitude-content">
    <div class="container">
        <!-- Статистика -->
        <div class="gratitude-stats">
            <div class="gratitude-stats__item">
                <div class="gratitude-stats__icon">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div class="gratitude-stats__content">
                    <div class="gratitude-stats__number" data-target="<?php echo esc_attr(get_field('gratitude_stats_awards') ?: '50'); ?>">0</div>
                    <div class="gratitude-stats__label"><?php echo esc_html(get_field('gratitude_stats_awards_label') ?: 'Наград и благодарностей'); ?></div>
                </div>
            </div>
            <div class="gratitude-stats__item">
                <div class="gratitude-stats__icon">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <div class="gratitude-stats__content">
                    <div class="gratitude-stats__number" data-target="<?php echo esc_attr(get_field('gratitude_stats_certificates') ?: '15'); ?>">0</div>
                    <div class="gratitude-stats__label"><?php echo esc_html(get_field('gratitude_stats_certificates_label') ?: 'Сертификатов качества'); ?></div>
                </div>
            </div>
            <div class="gratitude-stats__item">
                <div class="gratitude-stats__icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="gratitude-stats__content">
                    <div class="gratitude-stats__number" data-target="<?php echo esc_attr(get_field('gratitude_stats_years') ?: '10'); ?>">0</div>
                    <div class="gratitude-stats__label"><?php echo esc_html(get_field('gratitude_stats_years_label') ?: 'Лет безупречной работы'); ?></div>
                </div>
            </div>
            <div class="gratitude-stats__item">
                <div class="gratitude-stats__icon">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div class="gratitude-stats__content">
                    <div class="gratitude-stats__number" data-target="<?php echo esc_attr(get_field('gratitude_stats_partners') ?: '100'); ?>">0</div>
                    <div class="gratitude-stats__label"><?php echo esc_html(get_field('gratitude_stats_partners_label') ?: 'Довольных партнеров'); ?></div>
                </div>
            </div>
        </div>

        <!-- Галерея -->
        <div class="gratitude-gallery">
            <div class="gratitude-gallery__grid" id="galleryGrid">
                <?php 
                $gratitude_items = get_field('gratitude_items');
                if ($gratitude_items) :
                    foreach ($gratitude_items as $item) :
                        $image = $item['gratitude_item_image'];
                        $title = esc_html($item['gratitude_item_title']);
                        $description = esc_html($item['gratitude_item_description']);
                        $year = esc_html($item['gratitude_item_year']);
                        $category = esc_attr($item['gratitude_item_category']);
                        
                        if ($image) :
                            $image_url = esc_url($image['url']);
                            $image_alt = esc_attr($image['alt'] ?: $title);
                        else :
                            $image_url = esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr.webp');
                            $image_alt = esc_attr($title);
                        endif;
                ?>
                <div class="gratitude-item" data-category="<?php echo $category; ?>" data-year="<?php echo $year; ?>">
                    <div class="gratitude-item__image">
                        <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" loading="lazy">
                        <div class="gratitude-item__overlay">
                            <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="gratitude-item__content">
                        <h3 class="gratitude-item__title"><?php echo $title; ?></h3>
                        <p class="gratitude-item__description"><?php echo $description; ?></p>
                        <div class="gratitude-item__meta">
                            <span class="gratitude-item__date"><?php echo $year; ?></span>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                else :
                    // Дефолтные элементы галереи, если ACF поля не заполнены
                    $default_gratitude_items = [
                        [
                            'image' => 'gr1.webp',
                            'title' => 'Благодарственное письмо от ООО "ЭнергоТех"',
                            'description' => 'За качественную поставку и монтаж дизельной электростанции 500 кВт',
                            'year' => '2024',
                            'category' => 'gratitude'
                        ],
                        [
                            'image' => 'gr.webp',
                            'title' => 'Сертификат соответствия ГОСТ Р ИСО 9001-2015',
                            'description' => 'Система менеджмента качества',
                            'year' => '2023',
                            'category' => 'certificates'
                        ],
                        [
                            'image' => 'gr2.webp',
                            'title' => 'Благодарственное письмо от ПАО "Газпром"',
                            'description' => 'За надежную работу энергокомплекса 10 МВт',
                            'year' => '2023',
                            'category' => 'gratitude'
                        ],
                        [
                            'image' => 'gr3.webp',
                            'title' => 'Диплом участника выставки "Энергетика и электротехника"',
                            'description' => 'За инновационные решения в области энергетики',
                            'year' => '2022',
                            'category' => 'diplomas'
                        ],
                        [
                            'image' => 'gr.webp',
                            'title' => 'Награда "Лучший поставщик года"',
                            'description' => 'Ассоциация энергетических компаний России',
                            'year' => '2024',
                            'category' => 'awards'
                        ],
                        [
                            'image' => 'gr1.webp',
                            'title' => 'Лицензия на производство электрооборудования',
                            'description' => 'Ростехнадзор РФ',
                            'year' => '2023',
                            'category' => 'licenses'
                        ],
                        [
                            'image' => 'gr.webp',
                            'title' => 'Благодарственное письмо от АО "Россети"',
                            'description' => 'За качественную поставку резервного энергооборудования',
                            'year' => '2022',
                            'category' => 'gratitude'
                        ],
                        [
                            'image' => 'gr1.webp',
                            'title' => 'Сертификат соответствия техническому регламенту',
                            'description' => 'Таможенного союза ЕАЭС',
                            'year' => '2024',
                            'category' => 'certificates'
                        ]
                    ];
                    
                    foreach ($default_gratitude_items as $item) :
                        $image_url = esc_url(get_template_directory_uri() . '/assets/img/gratitude/' . $item['image']);
                        $title = esc_html($item['title']);
                        $description = esc_html($item['description']);
                        $year = esc_html($item['year']);
                        $category = esc_attr($item['category']);
                ?>
                <div class="gratitude-item" data-category="<?php echo $category; ?>" data-year="<?php echo $year; ?>">
                    <div class="gratitude-item__image">
                        <img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
                        <div class="gratitude-item__overlay">
                            <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="gratitude-item__content">
                        <h3 class="gratitude-item__title"><?php echo $title; ?></h3>
                        <p class="gratitude-item__description"><?php echo $description; ?></p>
                        <div class="gratitude-item__meta">
                            <span class="gratitude-item__date"><?php echo $year; ?></span>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
            </div>
        </div>

        <!-- CTA блок -->
        <div class="gratitude-cta">
            <div class="gratitude-cta__content">
                <h2 class="gratitude-cta__title"><?php echo esc_html(get_field('gratitude_cta_title') ?: 'Станьте нашим партнером!'); ?></h2>
                <p class="gratitude-cta__description">
                    <?php echo esc_html(get_field('gratitude_cta_description') ?: 'Присоединяйтесь к числу компаний, которые доверяют нам. Гарантируем качество, подтвержденное многолетним опытом и наградами.'); ?>
                </p>
                <div class="gratitude-cta__buttons">
                    <?php 
                    $button1_url = get_field('gratitude_cta_button1_url');
                    $button1_text = get_field('gratitude_cta_button1_text') ?: 'Связаться с нами';
                    if ($button1_url) :
                    ?>
                    <a href="<?php echo esc_url($button1_url); ?>" class="btn btn--primary btn--lg">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <span><?php echo esc_html($button1_text); ?></span>
                    </a>
                    <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/contacts')); ?>" class="btn btn--primary btn--lg">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <span><?php echo esc_html($button1_text); ?></span>
                    </a>
                    <?php endif; ?>
                    
                    <?php 
                    $button2_url = get_field('gratitude_cta_button2_url');
                    $button2_text = get_field('gratitude_cta_button2_text') ?: 'Каталог продукции';
                    if ($button2_url) :
                    ?>
                    <a href="<?php echo esc_url($button2_url); ?>" class="btn btn--secondary btn--lg">
                        <i class="fa-solid fa-file-invoice" aria-hidden="true"></i>
                        <span><?php echo esc_html($button2_text); ?></span>
                    </a>
                    <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/catalog')); ?>" class="btn btn--secondary btn--lg">
                        <i class="fa-solid fa-file-invoice" aria-hidden="true"></i>
                        <span><?php echo esc_html($button2_text); ?></span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div class="lightbox" id="lightbox">
    <div class="lightbox__overlay"></div>
    <div class="lightbox__content">
        <button class="lightbox__close" type="button" aria-label="Закрыть">
            <i class="fa-solid fa-times"></i>
        </button>
        <button class="lightbox__prev" type="button" aria-label="Предыдущее">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button class="lightbox__next" type="button" aria-label="Следующее">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
        <div class="lightbox__image-container">
            <img class="lightbox__image" src="" alt="">
        </div>
        <div class="lightbox__caption">
            <h3 class="lightbox__title"></h3>
            <p class="lightbox__description"></p>
        </div>
    </div>
</div>

<?php get_footer(); ?>