<?php
/**
 * Template Name: Благодарности
 * 
 * Шаблон страницы "Благодарности и сертификаты"
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

<main class="main-content">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-header__title">Благодарности и сертификаты</h1>
            <p class="page-header__description">
                Официальные документы, благодарственные письма, сертификаты и награды, 
                подтверждающие высокое качество наших услуг и надежность оборудования
            </p>
        </div>
    </section>

    <!-- ACF: Gratitude Content -->
    <section class="gratitude-content">
        <div class="container">

            <!-- ACF: Statistics -->
            <div class="gratitude-stats">
                <div class="gratitude-stats__item">
                    <div class="gratitude-stats__icon">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div class="gratitude-stats__content">
                        <div class="gratitude-stats__number" data-target="50">0</div>
                        <div class="gratitude-stats__label">Наград и благодарностей</div>
                    </div>
                </div>
                <div class="gratitude-stats__item">
                    <div class="gratitude-stats__icon">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="gratitude-stats__content">
                        <div class="gratitude-stats__number" data-target="15">0</div>
                        <div class="gratitude-stats__label">Сертификатов качества</div>
                    </div>
                </div>
                <div class="gratitude-stats__item">
                    <div class="gratitude-stats__icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="gratitude-stats__content">
                        <div class="gratitude-stats__number" data-target="10">0</div>
                        <div class="gratitude-stats__label">Лет безупречной работы</div>
                    </div>
                </div>
                <div class="gratitude-stats__item">
                    <div class="gratitude-stats__icon">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div class="gratitude-stats__content">
                        <div class="gratitude-stats__number" data-target="100">0</div>
                        <div class="gratitude-stats__label">Довольных партнеров</div>
                    </div>
                </div>
            </div>

            <!-- ACF: Gallery -->
            <div class="gratitude-gallery">
                <div class="gratitude-gallery__grid" id="galleryGrid">
                    <!-- Gratitude Letters -->
                    <div class="gratitude-item" data-category="gratitude" data-year="2024">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr1.webp'); ?>" alt="Благодарственное письмо от ООО 'ЭнергоТех'" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Благодарственное письмо от ООО "ЭнергоТех"</h3>
                            <p class="gratitude-item__description">За качественную поставку и монтаж дизельной электростанции 500 кВт</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="gratitude-item" data-category="certificates" data-year="2023">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr.webp'); ?>" alt="Сертификат соответствия ГОСТ Р ИСО 9001-2015" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Сертификат соответствия ГОСТ Р ИСО 9001-2015</h3>
                            <p class="gratitude-item__description">Система менеджмента качества</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2023</span>
                            </div>
                        </div>
                    </div>

                    <div class="gratitude-item" data-category="gratitude" data-year="2023">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr2.webp'); ?>" alt="Благодарственное письмо от ПАО 'Газпром'" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Благодарственное письмо от ПАО "Газпром"</h3>
                            <p class="gratitude-item__description">За надежную работу энергокомплекса 10 МВт</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2023</span>
                            </div>
                        </div>
                    </div>

                    <div class="gratitude-item" data-category="diplomas" data-year="2022">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr3.webp'); ?>" alt="Диплом участника выставки 'Энергетика и электротехника'" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Диплом участника выставки "Энергетика и электротехника"</h3>
                            <p class="gratitude-item__description">За инновационные решения в области энергетики</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2022</span>
                            </div>
                        </div>
                    </div>

                    <div class="gratitude-item" data-category="awards" data-year="2024">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr.webp'); ?>" alt="Награда 'Лучший поставщик года'" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Награда "Лучший поставщик года"</h3>
                            <p class="gratitude-item__description">Ассоциация энергетических компаний России</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2024</span>
                            </div>
                        </div>
                    </div>

                    <div class="gratitude-item" data-category="licenses" data-year="2023">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr1.webp'); ?>" alt="Лицензия на производство электрооборудования" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Лицензия на производство электрооборудования</h3>
                            <p class="gratitude-item__description">Ростехнадзор РФ</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2023</span>
                            </div>
                        </div>
                    </div>

                    <div class="gratitude-item" data-category="gratitude" data-year="2022">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr.webp'); ?>" alt="Благодарственное письмо от АО 'Россети'" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Благодарственное письмо от АО "Россети"</h3>
                            <p class="gratitude-item__description">За качественную поставку резервного энергооборудования</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2022</span>
                            </div>
                        </div>
                    </div>

                    <div class="gratitude-item" data-category="certificates" data-year="2024">
                        <div class="gratitude-item__image">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/gratitude/gr1.webp'); ?>" alt="Сертификат соответствия техническому регламенту" loading="lazy">
                            <div class="gratitude-item__overlay">
                                <button class="gratitude-item__zoom-btn" type="button" aria-label="Увеличить">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="gratitude-item__content">
                            <h3 class="gratitude-item__title">Сертификат соответствия техническому регламенту</h3>
                            <p class="gratitude-item__description">Таможенного союза ЕАЭС</p>
                            <div class="gratitude-item__meta">
                                <span class="gratitude-item__date">2024</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
    </div>

            <!-- ACF: CTA Block -->
            <div class="gratitude-cta">
                <div class="gratitude-cta__content">
                    <h2 class="gratitude-cta__title">Станьте нашим партнером!</h2>
                    <p class="gratitude-cta__description">
                        Присоединяйтесь к числу компаний, которые доверяют нам. 
                        Гарантируем качество, подтвержденное многолетним опытом и наградами.
                    </p>
                    <div class="gratitude-cta__buttons">
                        <a href="<?php echo esc_url(home_url('/contacts')); ?>" class="btn btn--primary btn--lg">
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                            <span>Связаться с нами</span>
                        </a>
                        <a href="<?php echo esc_url(home_url('/catalog')); ?>" class="btn btn--secondary btn--lg">
                            <i class="fa-solid fa-file-invoice" aria-hidden="true"></i>
                            <span>Каталог продукции</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>

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
