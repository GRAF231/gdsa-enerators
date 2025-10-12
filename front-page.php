<?php
/**
 * Template Name: Главная страница
 * Description: Шаблон главной страницы сайта DSA Generators
 */

get_header(); ?>

<main class="main-content">
    <!-- Основной контент --> 
    <div class="container">
        <!-- ACF: Home Slider -->
        <section class="section home-slider">
            <div class="home-slider__container">
                <!-- Левая панель с контентом слайдера -->
                <div class="home-slider__content">
                    <div class="home-slider__slides-container">
                        <div class="home-slider__slide active">
                            <div class="home-slider__text">
                                <h1 class="home-slider__title">Дизельные электростанции: производство и обслуживание</h1>
                                <p class="home-slider__subtitle">Единичная мощность ДГУ до 2500 кВт, напряжение от 0,4 кВ до 6/10 кВ</p>
                                <div class="home-slider__divider"></div>
                            </div>
                            <div class="home-slider__image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Дизельный генератор" class="home-slider__img">
                            </div>
                        </div>
                        
                        <div class="home-slider__slide">
                            <div class="home-slider__text">
                                <h1 class="home-slider__title">Профессиональные дизельные генераторы</h1>
                                <p class="home-slider__subtitle">Надежное энергоснабжение для промышленных объектов и коммерческих предприятий</p>
                                <div class="home-slider__divider"></div>
                            </div>
                            <div class="home-slider__image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Дизельный генератор" class="home-slider__img">
                            </div>
                        </div>
                        
                        <div class="home-slider__slide">
                            <div class="home-slider__text">
                                <h1 class="home-slider__title">Сервисное обслуживание и ремонт</h1>
                                <p class="home-slider__subtitle">Полный спектр услуг по техническому обслуживанию и модернизации оборудования</p>
                                <div class="home-slider__divider"></div>
                            </div>
                            <div class="home-slider__image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Дизельный генератор" class="home-slider__img">
                            </div>
                        </div>
                        
                        <!-- Индикаторы слайдов -->
                        <div class="home-slider__indicators">
                            <button class="home-slider__indicator active" aria-label="Слайд 1"></button>
                            <button class="home-slider__indicator" aria-label="Слайд 2"></button>
                            <button class="home-slider__indicator" aria-label="Слайд 3"></button>
                        </div>
                    </div>
                    
                    <!-- Правая панель с фильтрами -->
                    <div class="home-slider__filters">
                        <h2 class="home-slider__filters-title">ДИЗЕЛЬНЫЕ ЭЛЕКТРОСТАНЦИИ</h2>
                        <div class="home-slider__power-grid">
                            <a href="/catalog?power=40" class="home-slider__power-btn">40 кВт</a>
                            <a href="/catalog?power=60" class="home-slider__power-btn">60 кВт</a>
                            <a href="/catalog?power=80" class="home-slider__power-btn">80 кВт</a>
                            <a href="/catalog?power=100" class="home-slider__power-btn">100 кВт</a>
                            <a href="/catalog?power=200" class="home-slider__power-btn">200 кВт</a>
                            <a href="/catalog?power=300" class="home-slider__power-btn">300 кВт</a>
                            <a href="/catalog?power=400" class="home-slider__power-btn">400 кВт</a>
                            <a href="/catalog?power=500" class="home-slider__power-btn">500 кВт</a>
                            <a href="/catalog?power=600" class="home-slider__power-btn">600 кВт</a>
                            <a href="/catalog?power=800" class="home-slider__power-btn">800 кВт</a>
                            <a href="/catalog?power=1000" class="home-slider__power-btn">1000 кВт</a>
                            <a href="/catalog?power=1200" class="home-slider__power-btn">1200 кВт</a>
                            <a href="/catalog?power=1500" class="home-slider__power-btn">1500 кВт</a>
                            <a href="/catalog?power=1800" class="home-slider__power-btn">1800 кВт</a>
                            <a href="/catalog?power=2000" class="home-slider__power-btn">2000 кВт</a>
                            <a href="/catalog?power=2400" class="home-slider__power-btn">2400 кВт</a>
                            <a href="/catalog?power=2500" class="home-slider__power-btn">2500 кВт</a>
                            <a href="/catalog?power=3000" class="home-slider__power-btn">3000 кВт</a>
                        </div>
                        <a href="/catalog?voltage=high" class="home-slider__voltage-text">Высоковольтные 6,3 и 10,5 кВ</a>
                        <a href="/catalog" class="home-slider__search-btn">Поиск по каталогу ДЭС</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACF: Home Catalog -->
        <section class="section home-catalog">
            <div class="home-catalog__container">
                <div class="home-catalog__header">
                    <h2 class="home-catalog__title">Дизельные электростанции</h2>
                    <p class="home-catalog__subtitle">поставка с заводов и нашего производства</p>
                </div>
                
                <div class="home-catalog__grid">
                    <!-- Категория 1: ДЭС 24-800 кВт -->
                    <a href="/catalog/des-24-800" class="home-catalog__item">
                        <div class="home-catalog__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="ДЭС 24-800 кВт" class="home-catalog__img">
                        </div>
                        <div class="home-catalog__item-content">
                            <h3 class="home-catalog__item-title">ДЭС 24 - 800 кВт</h3>
                            <p class="home-catalog__item-description">поставка с заводов и нашего производства</p>
                            <span class="home-catalog__item-link">Подробнее</span>
                        </div>
                    </a>

                    <!-- Категория 2: ДЭС 1-2 МВт -->
                    <a href="/catalog/des-1-2-mw" class="home-catalog__item">
                        <div class="home-catalog__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="ДЭС 1-2 МВт" class="home-catalog__img">
                        </div>
                        <div class="home-catalog__item-content">
                            <h3 class="home-catalog__item-title">ДЭС 1 - 2 МВт</h3>
                            <p class="home-catalog__item-description">единичная мощность до 2500 кВт + параллель</p>
                            <span class="home-catalog__item-link">Подробнее</span>
                        </div>
                    </a>

                    <!-- Категория 3: Энергокомплексы 3-50 МВт -->
                    <a href="/catalog/energy-complexes" class="home-catalog__item">
                        <div class="home-catalog__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Энергокомплексы 3-50 МВт" class="home-catalog__img">
                        </div>
                        <div class="home-catalog__item-content">
                            <h3 class="home-catalog__item-title">Энергокомплексы 3 - 50 МВт</h3>
                            <p class="home-catalog__item-description">ДЭС 1 - 2 МВт в параллели</p>
                            <span class="home-catalog__item-link">Подробнее</span>
                        </div>
                    </a>

                    <!-- Категория 4: Шумозащитный кожух и капот -->
                    <a href="/catalog/soundproof-housing" class="home-catalog__item">
                        <div class="home-catalog__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Шумозащитный кожух и капот" class="home-catalog__img">
                        </div>
                        <div class="home-catalog__item-content">
                            <h3 class="home-catalog__item-title">Шумозащитный кожух и капот</h3>
                            <p class="home-catalog__item-description">Шумопоглощение 55 дБ (А)</p>
                            <span class="home-catalog__item-link">Подробнее</span>
                        </div>
                    </a>

                    <!-- Категория 5: Контейнеры для оборудования -->
                    <a href="/catalog/equipment-containers" class="home-catalog__item">
                        <div class="home-catalog__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Контейнеры для оборудования" class="home-catalog__img">
                        </div>
                        <div class="home-catalog__item-content">
                            <h3 class="home-catalog__item-title">Контейнеры для оборудования</h3>
                            <p class="home-catalog__item-description">КТП, ЗРУ, МЦОД, азотные, водоподготовка</p>
                            <span class="home-catalog__item-link">Подробнее</span>
                        </div>
                    </a>

                    <!-- Категория 6: Высоковольтные ДГУ -->
                    <a href="/catalog/high-voltage-dgu" class="home-catalog__item">
                        <div class="home-catalog__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Высоковольтные ДГУ" class="home-catalog__img">
                        </div>
                        <div class="home-catalog__item-content">
                            <h3 class="home-catalog__item-title">Высоковольтные ДГУ</h3>
                            <p class="home-catalog__item-description">6,3 и 10,5 кВ</p>
                            <span class="home-catalog__item-link">Подробнее</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- ACF: Home Advantages -->
        <section class="section home-advantages">
            <div class="home-advantages__container">
                <div class="home-advantages__header">
                    <h2 class="home-advantages__title">Наши преимущества</h2>
                    <p class="home-advantages__subtitle">Почему выбирают именно нас</p>
                </div>
                
                <div class="home-advantages__grid">
                    <div class="home-advantages__item">
                        <div class="home-advantages__icon">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <h3 class="home-advantages__item-title">Качество</h3>
                        <p class="home-advantages__item-description">Только проверенные производители и сертифицированная продукция</p>
                    </div>
                    
                    <div class="home-advantages__item">
                        <div class="home-advantages__icon">
                            <i class="fa-solid fa-tools"></i>
                        </div>
                        <h3 class="home-advantages__item-title">Сервис</h3>
                        <p class="home-advantages__item-description">Полное техническое сопровождение и гарантийное обслуживание</p>
                    </div>
                    
                    <div class="home-advantages__item">
                        <div class="home-advantages__icon">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <h3 class="home-advantages__item-title">Доставка</h3>
                        <p class="home-advantages__item-description">Быстрая доставка по всей России и странам СНГ</p>
                    </div>
                    
                    <div class="home-advantages__item">
                        <div class="home-advantages__icon">
                            <i class="fa-solid fa-cog"></i>
                        </div>
                        <h3 class="home-advantages__item-title">Производство</h3>
                        <p class="home-advantages__item-description">Собственное производство и контроль качества на каждом этапе</p>
                    </div>
                    
                    <div class="home-advantages__item">
                        <div class="home-advantages__icon">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h3 class="home-advantages__item-title">Сроки</h3>
                        <p class="home-advantages__item-description">Соблюдение сроков поставки и выполнения работ</p>
                    </div>
                    
                    <div class="home-advantages__item">
                        <div class="home-advantages__icon">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <h3 class="home-advantages__item-title">Поддержка</h3>
                        <p class="home-advantages__item-description">Круглосуточная техническая поддержка и консультации</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACF: Home Equipment -->
        <section class="section home-equipment">
            <div class="home-equipment__container">
                <div class="home-equipment__header">
                    <h2 class="home-equipment__title">Комплектующие и электротехническое оборудование</h2>
                </div>
                
                <div class="home-equipment__row">
                    <a href="/catalog/load-modules" class="home-equipment__item">
                        <div class="home-equipment__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Нагрузочные модули" class="home-equipment__img">
                        </div>
                        <div class="home-equipment__item-content">
                            <h3 class="home-equipment__item-title">Нагрузочные модули</h3>
                            <p class="home-equipment__item-subtitle">100-6000 кВт</p>
                        </div>
                    </a>

                    <a href="/catalog/ups" class="home-equipment__item">
                        <div class="home-equipment__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="ИБП" class="home-equipment__img">
                        </div>
                        <div class="home-equipment__item-content">
                            <h3 class="home-equipment__item-title">ИБП</h3>
                            <p class="home-equipment__item-subtitle">20-300 кВт</p>
                        </div>
                    </a>

                    <a href="/catalog/air-dryers" class="home-equipment__item">
                        <div class="home-equipment__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Осушители сжатого воздуха" class="home-equipment__img">
                        </div>
                        <div class="home-equipment__item-content">
                            <h3 class="home-equipment__item-title">Осушители сжатого воздуха</h3>
                        </div>
                    </a>

                    <a href="/catalog/nitrogen-generators" class="home-equipment__item">
                        <div class="home-equipment__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Генераторы азота модульные" class="home-equipment__img">
                        </div>
                        <div class="home-equipment__item-content">
                            <h3 class="home-equipment__item-title">Генераторы азота модульные, две башни</h3>
                        </div>
                    </a>

                    <a href="/catalog/compressors" class="home-equipment__item">
                        <div class="home-equipment__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Компрессоры винтовые, поршневые" class="home-equipment__img">
                        </div>
                        <div class="home-equipment__item-content">
                            <h3 class="home-equipment__item-title">Компрессоры винтовые, поршневые</h3>
                        </div>
                    </a>

                    <a href="/catalog/oxygen-generators" class="home-equipment__item">
                        <div class="home-equipment__item-image">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Генераторы кислорода серия DGO" class="home-equipment__img">
                        </div>
                        <div class="home-equipment__item-content">
                            <h3 class="home-equipment__item-title">Генераторы кислорода серия DGO</h3>
                        </div>
                    </a>
                </div>
            </div>
        </section>  

        <!-- ACF: Home Popular Products -->
        <section class="section home-popular">
            <div class="home-popular__container">
                <div class="home-popular__header">
                    <div class="home-popular__title-group">
                        <h2 class="home-popular__title">ПОПУЛЯРНЫЕ</h2>
                        <h3 class="home-popular__subtitle">ТОВАРЫ</h3>
                    </div>
                    <div class="home-popular__description">
                        <span class="home-popular__desc-text">ДИЗЕЛЬНЫЕ</span>
                        <span class="home-popular__desc-text">ЭЛЕКТРОГЕНЕРАТОРЫ</span>
                        <span class="home-popular__desc-text">ВЫСОКОГО</span>
                        <span class="home-popular__desc-text">КАЧЕСТВА</span>
                    </div>
                </div>
                
                <div class="home-popular__slider">
                    <div class="home-popular__slider-container">
                        <div class="home-popular__slider-track">
                            <!-- Карточка товара 1 -->
                            <div class="home-popular__item">
                                <div class="home-popular__item-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Дизельный генератор 10 кВт" class="home-popular__img">
                                </div>
                                <div class="home-popular__item-content">
                                    <h4 class="home-popular__item-title">Дизельный генератор 10 кВт</h4>
                                    <div class="home-popular__item-specs">
                                        <span class="home-popular__spec">Мощность: 10 кВт</span>
                                        <span class="home-popular__spec">Топливо: Дизель</span>
                                    </div>
                                    <div class="home-popular__item-price">
                                        <span class="home-popular__price">от 450 000 ₽</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Карточка товара 2 -->
                            <div class="home-popular__item">
                                <div class="home-popular__item-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Дизельный генератор 20 кВт" class="home-popular__img">
                                </div>
                                <div class="home-popular__item-content">
                                    <h4 class="home-popular__item-title">Дизельный генератор 20 кВт</h4>
                                    <div class="home-popular__item-specs">
                                        <span class="home-popular__spec">Мощность: 20 кВт</span>
                                        <span class="home-popular__spec">Топливо: Дизель</span>
                                    </div>
                                    <div class="home-popular__item-price">
                                        <span class="home-popular__price">от 780 000 ₽</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Карточка товара 3 -->
                            <div class="home-popular__item">
                                <div class="home-popular__item-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Дизельный генератор 50 кВт" class="home-popular__img">
                                </div>
                                <div class="home-popular__item-content">
                                    <h4 class="home-popular__item-title">Дизельный генератор 50 кВт</h4>
                                    <div class="home-popular__item-specs">
                                        <span class="home-popular__spec">Мощность: 50 кВт</span>
                                        <span class="home-popular__spec">Топливо: Дизель</span>
                                    </div>
                                    <div class="home-popular__item-price">
                                        <span class="home-popular__price">от 1 200 000 ₽</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Карточка товара 4 -->
                            <div class="home-popular__item">
                                <div class="home-popular__item-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Дизельный генератор 100 кВт" class="home-popular__img">
                                </div>
                                <div class="home-popular__item-content">
                                    <h4 class="home-popular__item-title">Дизельный генератор 100 кВт</h4>
                                    <div class="home-popular__item-specs">
                                        <span class="home-popular__spec">Мощность: 100 кВт</span>
                                        <span class="home-popular__spec">Топливо: Дизель</span>
                                    </div>
                                    <div class="home-popular__item-price">
                                        <span class="home-popular__price">от 2 500 000 ₽</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Карточка товара 5 -->
                            <div class="home-popular__item">
                                <div class="home-popular__item-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Дизельный генератор 200 кВт" class="home-popular__img">
                                </div>
                                <div class="home-popular__item-content">
                                    <h4 class="home-popular__item-title">Дизельный генератор 200 кВт</h4>
                                    <div class="home-popular__item-specs">
                                        <span class="home-popular__spec">Мощность: 200 кВт</span>
                                        <span class="home-popular__spec">Топливо: Дизель</span>
                                    </div>
                                    <div class="home-popular__item-price">
                                        <span class="home-popular__price">от 4 800 000 ₽</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Навигация слайдера -->
                    <div class="home-popular__navigation">
                        <button class="home-popular__nav-btn home-popular__nav-btn--prev" aria-label="Предыдущий слайд">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button class="home-popular__nav-btn home-popular__nav-btn--next" aria-label="Следующий слайд">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACF: Home Projects -->
        <section class="section home-projects">
            <div class="home-projects__container">
                <!-- Заголовок блока -->
                <div class="home-projects__header">
                    <div class="home-projects__title-group">
                        <h2 class="home-projects__title">ВЫПОЛНЕННЫЕ</h2>
                        <h2 class="home-projects__subtitle">ПРОЕКТЫ</h2>
                    </div>
                    <div class="home-projects__description">
                        <p class="home-projects__desc-text">Наши успешные</p>
                        <p class="home-projects__desc-text">реализации</p>
                    </div>
                </div>


                <!-- Галерея проектов -->
                <div class="home-projects__gallery">
                    <div class="home-projects__project" data-category="industrial">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Завод по производству" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Завод по производству</h3>
                                    <p class="home-projects__project-desc">Дизельный генератор 500 кВт</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">500 кВт</span>
                                        <span class="home-projects__stat">2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="home-projects__project" data-category="commercial">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Торговый центр" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Торговый центр</h3>
                                    <p class="home-projects__project-desc">Система резервного питания</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">200 кВт</span>
                                        <span class="home-projects__stat">2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="home-projects__project" data-category="residential">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Частный дом" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Частный дом</h3>
                                    <p class="home-projects__project-desc">Автономное электроснабжение</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">50 кВт</span>
                                        <span class="home-projects__stat">2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="home-projects__project" data-category="industrial">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1581094306765-c2c6b8e3c9c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Нефтеперерабатывающий завод" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Нефтеперерабатывающий завод</h3>
                                    <p class="home-projects__project-desc">Система аварийного питания</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">1000 кВт</span>
                                        <span class="home-projects__stat">2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="home-projects__project" data-category="commercial">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Офисный комплекс" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Офисный комплекс</h3>
                                    <p class="home-projects__project-desc">Резервное питание серверов</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">150 кВт</span>
                                        <span class="home-projects__stat">2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="home-projects__project" data-category="residential">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Коттеджный поселок" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Коттеджный поселок</h3>
                                    <p class="home-projects__project-desc">Централизованное питание</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">300 кВт</span>
                                        <span class="home-projects__stat">2022</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="home-projects__project" data-category="industrial">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1586864387967-d02ef85d93e8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Металлургический завод" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Металлургический завод</h3>
                                    <p class="home-projects__project-desc">Полная автоматизация производственных процессов</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">500 кВт</span>
                                        <span class="home-projects__stat">2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="home-projects__project" data-category="commercial">
                        <div class="home-projects__project-image">
                            <img src="https://images.unsplash.com/photo-1577495508048-b635879837f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Бизнес-центр" loading="lazy">
                            <div class="home-projects__project-overlay">
                                <div class="home-projects__project-info">
                                    <h3 class="home-projects__project-title">Бизнес-центр</h3>
                                    <p class="home-projects__project-desc">Современное офисное здание с энергоэффективными решениями</p>
                                    <div class="home-projects__project-stats">
                                        <span class="home-projects__stat">200 кВт</span>
                                        <span class="home-projects__stat">2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Дополнительные проекты -->
                

                <!-- Кнопка "Показать все" -->
                <div class="home-projects__show-more">
                    <button class="home-projects__show-more-btn">
                        <span>Показать все проекты</span>
                    </button>
                </div>
            </div>
        </section>


        <!-- ACF: Home News - WordPress Integration -->
        <section class="section home-news">
            <div class="home-news__container">
                <!-- Заголовок блока -->
                <div class="home-news__header">
                    <h2 class="home-news__title">НОВОСТИ И СТАТЬИ</h2>
                    <p class="home-news__subtitle">
                        Следите за последними новостями в области энергетики, новинками оборудования и важными событиями нашей компании
                    </p>
                </div>

                <!-- Контейнер прокрутки -->
                <div class="home-news__slider-container">
                    <!-- Сетка новостей -->
                    <div class="home-news__grid">
                    <?php
                    // WP_Query для вывода последних 6 новостей
                    $news_query = new WP_Query([
                        'post_type' => 'post',
                        'posts_per_page' => 6,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ]);
                    
                    if ($news_query->have_posts()) :
                        while ($news_query->have_posts()) : $news_query->the_post();
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: 'https://via.placeholder.com/400x250';
                            $category = get_the_category();
                            $category_name = !empty($category) ? esc_html($category[0]->name) : 'Новость';
                    ?>
                        <a href="<?php the_permalink(); ?>" class="home-news__card">
                            <img src="<?php echo esc_url($thumbnail_url); ?>" 
                                    alt="<?php the_title_attribute(); ?>" 
                                    class="home-news__image">
                            <div class="home-news__content">
                                <span class="home-news__category"><?php echo $category_name; ?></span>
                                <h3 class="home-news__card-title"><?php the_title(); ?></h3>
                                <p class="home-news__description">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>
                                <div class="home-news__meta">
                                    <span class="home-news__date"><?php echo get_the_date('d.m.Y'); ?></span>
                                    <span class="home-news__views"><?php echo get_post_meta(get_the_ID(), 'views_count', true) ?: '0'; ?></span>
                                </div>
                                <span class="home-news__read-more">Читать далее</span>
                            </div>
                        </a>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <p class="home-news__no-posts">Новостей пока нет.</p>
                    <?php endif; ?>
                    </div>
                </div>

                <!-- Кнопка "Все новости" -->
                <div class="home-news__show-all">
                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="home-news__show-all-btn">
                        <span>Все новости</span>
                    </a>
                </div>
            </div>
        </section>


        <!-- ACF: Catalog Section -->
        <section class="catalog-section">
            <div class="catalog">
                <div class="catalog__header">
                    <h2 class="catalog__title">Дизельные электростанции:</h2>
                    <div class="catalog__tabs">
                        <button class="catalog__tab catalog__tab_active" data-tab="power">
                            <i class="fa-solid fa-bolt"></i>
                            <span>По мощности</span>
                        </button>
                        <button class="catalog__tab" data-tab="manufacturer">
                            <i class="fa-solid fa-industry"></i>
                            <span>По производителю</span>
                        </button>
                        <button class="catalog__tab" data-tab="engine">
                            <i class="fa-solid fa-cog"></i>
                            <span>По двигателю</span>
                        </button>
                    </div>
                </div>
                
                <div class="catalog__content">
                    
                    <div class="catalog__panel catalog__panel_active" data-panel="power">
                        <div class="catalog__grid">
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные генераторы 40-100 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">40 кВт</a>
                                    <a href="#" class="catalog__option">80 кВт</a>
                                    <a href="#" class="catalog__option">100 кВт</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные генераторы 150-250 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">150 кВт</a>
                                    <a href="#" class="catalog__option">200 кВт</a>
                                    <a href="#" class="catalog__option">250 кВт</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные генераторы 300-500 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">300 кВт</a>
                                    <a href="#" class="catalog__option">400 кВт</a>
                                    <a href="#" class="catalog__option">500 кВт</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные генераторы 600-800 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">600 кВт</a>
                                    <a href="#" class="catalog__option">700 кВт</a>
                                    <a href="#" class="catalog__option">800 кВт</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные электростанции 1000-1200 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">1000 кВт</a>
                                    <a href="#" class="catalog__option">1100 кВт</a>
                                    <a href="#" class="catalog__option">1200 кВт</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные генераторы 1300-1500 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">1300 кВт</a>
                                    <a href="#" class="catalog__option">1400 кВт</a>
                                    <a href="#" class="catalog__option">1500 кВт</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные электростанции 1600-1800 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">1600 кВт</a>
                                    <a href="#" class="catalog__option">1700 кВт</a>
                                    <a href="#" class="catalog__option">1800 кВт</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Дизельные генераторы 2000-2500 кВт</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">2000 кВт</a>
                                    <a href="#" class="catalog__option">2200 кВт</a>
                                    <a href="#" class="catalog__option">2500 кВт</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="catalog__panel" data-panel="manufacturer">
                        <div class="catalog__grid">
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Популярные производители</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">DSA Generators</a>
                                    <a href="#" class="catalog__option">AKSA</a>
                                    <a href="#" class="catalog__option">CTM</a>
                                    <a href="#" class="catalog__option">Cummins</a>
                                    <a href="#" class="catalog__option">JCB</a>
                                    <a href="#" class="catalog__option">Wilson</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Европейские бренды</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">EMSA</a>
                                    <a href="#" class="catalog__option">Energo</a>
                                    <a href="#" class="catalog__option">Fogo</a>
                                    <a href="#" class="catalog__option">Inmesol</a>
                                    <a href="#" class="catalog__option">Pramac</a>
                                    <a href="#" class="catalog__option">Green Power</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Международные производители</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">HERTZ</a>
                                    <a href="#" class="catalog__option">Himoinsa</a>
                                    <a href="#" class="catalog__option">PowerLink</a>
                                    <a href="#" class="catalog__option">Weichai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                
                    <div class="catalog__panel" data-panel="engine">
                        <div class="catalog__grid">
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Бюджетные</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">Baudouin</a>
                                    <a href="#" class="catalog__option">Weichai</a>
                                    <a href="#" class="catalog__option">Ricardo</a>
                                    <a href="#" class="catalog__option">TSS Diesel</a>
                                    <a href="#" class="catalog__option">ЯМЗ</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Оптимальные по качеству и цене</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">Perkins</a>
                                    <a href="#" class="catalog__option">Doosan</a>
                                    <a href="#" class="catalog__option">Scania</a>
                                    <a href="#" class="catalog__option">Deutz</a>
                                    <a href="#" class="catalog__option">Volvo</a>
                                    <a href="#" class="catalog__option">Mitsubishi</a>
                                </div>
                            </div>
                            
                            <div class="catalog__category">
                                <h3 class="catalog__category-title">Премиальные</h3>
                                <div class="catalog__options">
                                    <a href="#" class="catalog__option">Cummins</a>
                                    <a href="#" class="catalog__option">John Deere</a>
                                    <a href="#" class="catalog__option">MTU</a>
                                    <a href="#" class="catalog__option">Caterpillar</a>
                                    <a href="#" class="catalog__option">MAN</a>
                                    <a href="#" class="catalog__option">ABC</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>
