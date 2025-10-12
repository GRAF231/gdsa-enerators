
<?php
/*
Template Name: О компании
*/
get_header();

// Хлебные крошки
dsa_breadcrumbs();
?>

<main class="main-content">
    <!-- ACF: Блок преимуществ -->
    <section class="section about-advantages" id="advantages">
        <div class="about-advantages__container">
            <!-- Заголовок блока -->
            <div class="about-advantages__header">
                <div class="about-advantages__title-group">
                    <h1 class="about-advantages__title">ООО «DSA Generators»</h1>
                    <h2 class="about-advantages__subtitle">В МОСКВЕ</h2>
                </div>
                <div class="about-advantages__description">
                    <span class="about-advantages__desc-text">ИНН 7840490040</span>
                    <span class="about-advantages__desc-text">НАШИ</span>
                    <span class="about-advantages__desc-text">ПРЕИМУЩЕСТВА</span>
                </div>
            </div>

            <!-- Сетка преимуществ -->
            <div class="about-advantages__grid">
                <!-- Стабильность -->
                <div class="about-advantages__card about-advantages__card_stability" data-aos="fade-up" data-aos-delay="100">
                    <div class="about-advantages__card-header">
                        <div class="about-advantages__card-icon">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <h3 class="about-advantages__card-title">СТАБИЛЬНОСТЬ</h3>
                    </div>
                    <div class="about-advantages__card-content">
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="12">0<span class="about-advantages__stat-suffix">+</span></div>
                            <div class="about-advantages__stat-text">Лет компании, основана в 2013 году</div>
                        </div>
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="110">0<span class="about-advantages__stat-suffix">+</span></div>
                            <div class="about-advantages__stat-text">Сотрудников в штате</div>
                        </div>
                    </div>
                    <div class="about-advantages__card-footer">
                        <div class="about-advantages__progress">
                            <div class="about-advantages__progress-bar" style="width: 95%"></div>
                        </div>
                        <span class="about-advantages__progress-text">Надежность 95%</span>
                    </div>
                </div>

                <!-- Надёжность -->
                <div class="about-advantages__card about-advantages__card_reliability" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-advantages__card-header">
                        <div class="about-advantages__card-icon">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        <h3 class="about-advantages__card-title">НАДЁЖНОСТЬ</h3>
                    </div>
                    <div class="about-advantages__card-content">
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="500">0<span class="about-advantages__stat-suffix">+</span></div>
                            <div class="about-advantages__stat-text">Выполненных проектов по России и миру</div>
                        </div>
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="3.8">0<span class="about-advantages__stat-suffix">МЛРД</span></div>
                            <div class="about-advantages__stat-text">Выручка без НДС в 2024 году</div>
                        </div>
                    </div>
                    <div class="about-advantages__card-footer">
                        <div class="about-advantages__progress">
                            <div class="about-advantages__progress-bar" style="width: 98%"></div>
                        </div>
                        <span class="about-advantages__progress-text">Успешность 98%</span>
                    </div>
                </div>

                <!-- Потенциал -->
                <div class="about-advantages__card about-advantages__card_potential" data-aos="fade-up" data-aos-delay="300">
                    <div class="about-advantages__card-header">
                        <div class="about-advantages__card-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h3 class="about-advantages__card-title">ПОТЕНЦИАЛ</h3>
                    </div>
                    <div class="about-advantages__card-content">
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="100">0<span class="about-advantages__stat-suffix">МВт</span></div>
                            <div class="about-advantages__stat-text">Общая мощность проектов на 2025 год</div>
                        </div>
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="3000">0<span class="about-advantages__stat-suffix">м²</span></div>
                            <div class="about-advantages__stat-text">Площадь собственного производства</div>
                        </div>
                    </div>
                    <div class="about-advantages__card-footer">
                        <div class="about-advantages__progress">
                            <div class="about-advantages__progress-bar" style="width: 92%"></div>
                        </div>
                        <span class="about-advantages__progress-text">Потенциал 92%</span>
                    </div>
                </div>
            </div>

            <!-- Техническая схема -->
            <div class="about-advantages__technical" data-aos="fade-up" data-aos-delay="400">
                <div class="about-advantages__technical-content">
                    <div class="about-advantages__technical-header">
                        <h3 class="about-advantages__technical-title">Наше производство</h3>
                        <p class="about-advantages__technical-subtitle">Полный цикл от проектирования до поставки</p>
                    </div>
                    <div class="about-advantages__technical-grid">
                        <div class="about-advantages__tech-item">
                            <div class="about-advantages__tech-icon">
                                <i class="fa-solid fa-drafting-compass"></i>
                            </div>
                            <span class="about-advantages__tech-text">Проектирование</span>
                        </div>
                        <div class="about-advantages__tech-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="about-advantages__tech-item">
                            <div class="about-advantages__tech-icon">
                                <i class="fa-solid fa-industry"></i>
                            </div>
                            <span class="about-advantages__tech-text">Производство</span>
                        </div>
                        <div class="about-advantages__tech-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="about-advantages__tech-item">
                            <div class="about-advantages__tech-icon">
                                <i class="fa-solid fa-check-circle"></i>
                            </div>
                            <span class="about-advantages__tech-text">Контроль качества</span>
                        </div>
                        <div class="about-advantages__tech-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <div class="about-advantages__tech-item">
                            <div class="about-advantages__tech-icon">
                                <i class="fa-solid fa-truck"></i>
                            </div>
                            <span class="about-advantages__tech-text">Поставка</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Блок 10 причин выбрать DSA Generators -->
    <section class="about-reasons" id="reasons">
        <div class="container">
            <div class="about-reasons__header">
                <h2 class="about-reasons__title">10 причин выбрать «DSA Generators»: какую пользу мы принесем</h2>
            </div>
            
            <div class="about-reasons__list">
                <div class="about-reasons__item">
                    <div class="about-reasons__number">1</div>
                    <div class="about-reasons__text">
                        При поставке оборудования предлагаем взвешенное по цене и качеству решение, основанное на 20-летнем опыте наших инженеров. Разработаем ПД и РД. ЕРС и проектирование.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">2</div>
                    <div class="about-reasons__text">
                        Не завышаем цены ради маржи. Посмотрите наши цены на дизель-генераторы <a href="#" class="about-reasons__link">500 кВт / 1000 кВт / 1500 кВт / 2000 кВт / 3000 кВт / контейнеры</a>.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">3</div>
                    <div class="about-reasons__text">
                        Развиваем свое производство, а также имеем возможность импорта оборудования напрямую с заводов из Турции, Китая, Италии. <a href="#" class="about-reasons__link">Видео и фото с нашего производства</a>.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">4</div>
                    <div class="about-reasons__text">
                        Наш опыт - более 500 выполненных проектов по поставкам ДГУ, в том числе для ЦОД, ГОК, нефтегазовых компаний, складов, отелей. <a href="#" class="about-reasons__link">Смотреть референс с фото</a>.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">5</div>
                    <div class="about-reasons__text">
                        Компания имеет финансовую устойчивость: долгосрочные отношения с банками-партнёрами, банковская гарантия, спецсчет для участия в госзакупках.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">6</div>
                    <div class="about-reasons__text">
                        Гарантируем своевременную поставку оборудования и даем рассрочку платежа. <a href="#" class="about-reasons__link">Обсудить с гендиректором</a>.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">7</div>
                    <div class="about-reasons__text">
                        Допуски СРО на проектирование и СРО на строительство дают нам право заключения договоров на производство строительных работ для различных объектов.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">8</div>
                    <div class="about-reasons__text">
                        Успешно поставляем дизель-генераторы для госзаказчиков по 44-ФЗ и коммерческим структурам по 223-ФЗ. <a href="#" class="about-reasons__link">Референс-лист 250 контрактов</a>.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">9</div>
                    <div class="about-reasons__text">
                        Опыт ПНР, ремонта и ТО дизель-генераторов, в т.ч. для больниц, ЦОД, госструктур. Имеем собственную лицензированную электролабораторию. <a href="#" class="about-reasons__link">Примеры проектов</a>.
                    </div>
                </div>
                
                <div class="about-reasons__item">
                    <div class="about-reasons__number">10</div>
                    <div class="about-reasons__text">
                        Большой опыт строительно-монтажных работ: <a href="#" class="about-reasons__link">посмотрите наши строительные проекты</a>.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Направления деятельности -->
    <section class="section about-directions" id="directions">
        <div class="about-directions__container">
            <div class="about-directions__header">
                <div class="about-directions__title-group">
                    <h2 class="about-directions__title">НАПРАВЛЕНИЯ</h2>
                    <h3 class="about-directions__subtitle">ДЕЯТЕЛЬНОСТИ</h3>
                </div>
                <div class="about-directions__description">
                    <span class="about-directions__desc-text">НАШИ</span>
                    <span class="about-directions__desc-text">ОСНОВНЫЕ</span>
                    <span class="about-directions__desc-text">СФЕРЫ</span>
                    <span class="about-directions__desc-text">РАБОТЫ</span>
                </div>
            </div>
            
            <div class="about-directions__slider">
                <div class="about-directions__slider-container">
                    <div class="about-directions__slider-track">
                        <!-- Карточка направления 1 -->
                        <div class="about-directions__item">
                            <div class="about-directions__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Дизельные электростанции" class="about-directions__img">
                            </div>
                            <div class="about-directions__item-content">
                                <h4 class="about-directions__item-title">Дизельные электростанции</h4>
                                <div class="about-directions__item-specs">
                                    <span class="about-directions__spec">Производство ДГУ</span>
                                    <span class="about-directions__spec">Мощность до 80 МВт</span>
                                </div>
                                <div class="about-directions__item-status">
                                    <span class="about-directions__status">Основное направление</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Карточка направления 2 -->
                        <div class="about-directions__item">
                            <div class="about-directions__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Производство контейнеров" class="about-directions__img">
                            </div>
                            <div class="about-directions__item-content">
                                <h4 class="about-directions__item-title">Производство контейнеров</h4>
                                <div class="about-directions__item-specs">
                                    <span class="about-directions__spec">Металлоконструкции</span>
                                    <span class="about-directions__spec">Покрасочный цех</span>
                                </div>
                                <div class="about-directions__item-status">
                                    <span class="about-directions__status">Собственное производство</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Карточка направления 3 -->
                        <div class="about-directions__item">
                            <div class="about-directions__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Строительно-монтажные работы" class="about-directions__img">
                            </div>
                            <div class="about-directions__item-content">
                                <h4 class="about-directions__item-title">Строительно-монтажные работы</h4>
                                <div class="about-directions__item-specs">
                                    <span class="about-directions__spec">СРО строителей</span>
                                    <span class="about-directions__spec">Полный цикл работ</span>
                                </div>
                                <div class="about-directions__item-status">
                                    <span class="about-directions__status">Лицензированные работы</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Карточка направления 4 -->
                        <div class="about-directions__item">
                            <div class="about-directions__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Проектирование и EPC" class="about-directions__img">
                            </div>
                            <div class="about-directions__item-content">
                                <h4 class="about-directions__item-title">Проектирование и EPC</h4>
                                <div class="about-directions__item-specs">
                                    <span class="about-directions__spec">СРО проектировщиков</span>
                                    <span class="about-directions__spec">Проектная документация</span>
                                </div>
                                <div class="about-directions__item-status">
                                    <span class="about-directions__status">Проектирование</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Карточка направления 5 -->
                        <div class="about-directions__item">
                            <div class="about-directions__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Сервисное обслуживание" class="about-directions__img">
                            </div>
                            <div class="about-directions__item-content">
                                <h4 class="about-directions__item-title">Сервисное обслуживание</h4>
                                <div class="about-directions__item-specs">
                                    <span class="about-directions__spec">Электролаборатория</span>
                                    <span class="about-directions__spec">Техническое обслуживание</span>
                                </div>
                                <div class="about-directions__item-status">
                                    <span class="about-directions__status">Сервис</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Навигация слайдера -->
                <div class="about-directions__navigation">
                    <button class="about-directions__nav-btn about-directions__nav-btn--prev" aria-label="Предыдущий слайд">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="about-directions__nav-btn about-directions__nav-btn--next" aria-label="Следующий слайд">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Качество продукции и гарантии -->
    <section class="about-quality" id="quality">
        <div class="container">
            <div class="about-quality__header">
                <h2 class="about-quality__title">Качество нашей продукции и гарантии</h2>
            </div>
            
            <div class="about-quality__list">
                <div class="about-quality__item">
                    <div class="about-quality__icon">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="about-quality__text">
                        Предоставляем расширенную гарантию 5 лет на выпускаемую продукцию
                    </div>
                </div>
                
                <div class="about-quality__item">
                    <div class="about-quality__icon">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                    <div class="about-quality__text">
                        Применяем собственную лицензированную электролабораторию № 9173 от 10.02.23 г
                    </div>
                </div>
                
                <div class="about-quality__item">
                    <div class="about-quality__icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="about-quality__text">
                        Состоим в СРО проектировщиков (СРО-П-161-09092010) и в СРО строителей (СРО-С-258-11012013)
                    </div>
                </div>
                
                <div class="about-quality__item">
                    <div class="about-quality__icon">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div class="about-quality__text">
                        Применяем систему менеджмента в области охраны труда (OHSAS 18000:2007)
                    </div>
                </div>
                
                <div class="about-quality__item">
                    <div class="about-quality__icon">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div class="about-quality__text">
                        Состоим в Санкт-Петербургской торгово-промышленной палате
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Наше производство -->
    <section class="about-production" id="production">
        <div class="container">
            <div class="about-production__header">
                <h2 class="about-production__title">Наше производство</h2>
            </div>
            
            <div class="about-production__grid">
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="15 лет производственному комплексу" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">15 лет производственному комплексу</h3>
                    </div>
                </div>
                
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Проектно-конструкторское бюро" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">Проектно-конструкторское бюро</h3>
                    </div>
                </div>
                
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Покрасочный цех" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">Покрасочный цех</h3>
                    </div>
                </div>
                
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Площадь 3000 м2" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">Площадь 3000 м²</h3>
                    </div>
                </div>
                
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Современные станки" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">Современные станки</h3>
                    </div>
                </div>
                
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Резка по металлу" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">Резка по металлу</h3>
                    </div>
                </div>
                
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="Отдел технического контроля" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">Отдел технического контроля</h3>
                    </div>
                </div>
                
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider2.webp" alt="Цех сборки электроизделий" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title">Цех сборки электроизделий</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Наши услуги -->
    <section class="about-services" id="services">
        <div class="container">
            <div class="about-services__header">
                <h2 class="about-services__title">Наши услуги:</h2>
            </div>
            
            <div class="about-services__grid">
                <div class="about-services__column">
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-search"></i>
                        </div>
                        <div class="about-services__text">
                            Проводим бесплатные предмонтажные осмотры по всей территории РФ и СНГ
                        </div>
                    </div>
                    
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-drafting-compass"></i>
                        </div>
                        <div class="about-services__text">
                            Разрабатываем проектную документацию, генеральные планы, рабочие чертежи
                        </div>
                    </div>
                    
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div class="about-services__text">
                            Выполняем авторский надзор проектов своими силами
                        </div>
                    </div>
                    
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-file-alt"></i>
                        </div>
                        <div class="about-services__text">
                            Готовим исполнительную документацию
                        </div>
                    </div>
                </div>
                
                <div class="about-services__column">
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-gavel"></i>
                        </div>
                        <div class="about-services__text">
                            Оказываем сопровождение в тендерах, защищаем проекты, составляем уникальные ТЗ
                        </div>
                    </div>
                    
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <div class="about-services__text">
                            Составляем сметную документацию и технико-экономические обоснования проектов
                        </div>
                    </div>
                    
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div class="about-services__text">
                            Организуем приемо-сдаточные испытания
                        </div>
                    </div>
                    
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <div class="about-services__text">
                            Получаем разрешения на допуск в эксплуатацию энергоустановок в Ростехнадзоре
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Лицензии компании -->
    <section class="section about-licenses" id="licenses">
        <div class="about-licenses__container">
            <div class="about-licenses__header">
                <div class="about-licenses__title-group">
                    <h2 class="about-licenses__title">ЛИЦЕНЗИИ</h2>
                    <h3 class="about-licenses__subtitle">КОМПАНИИ</h3>
                </div>
                <div class="about-licenses__description">
                    <span class="about-licenses__desc-text">СЕРТИФИКАТЫ</span>
                    <span class="about-licenses__desc-text">КАЧЕСТВА</span>
                    <span class="about-licenses__desc-text">И</span>
                    <span class="about-licenses__desc-text">СООТВЕТСТВИЯ</span>
                </div>
            </div>
            
            <div class="about-licenses__grid">
                <!-- Карточка лицензии 1 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">Сертификат авторизованного дилера</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">Yuchai в России</span>
                            <span class="about-licenses__spec">ООО «DSA Generators»</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 2 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">Сертификат соответствия</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">СМК ГОСТ Р ИСО 9001-2015</span>
                            <span class="about-licenses__spec">Система менеджмента качества</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 3 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">Сертификат соответствия</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">ГОСТ Р ИСО 45001-2020</span>
                            <span class="about-licenses__spec">Безопасность труда и охрана здоровья</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 4 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">Выписка из Реестра СРО</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">Саморегулируемая организация</span>
                            <span class="about-licenses__spec">Область строительства</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 5 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">Сертификат соответствия</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">ГОСТ Р ИСО 14001-2016</span>
                            <span class="about-licenses__spec">Система экологического менеджмента</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 6 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">Лицензия электролаборатории</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">№ 9173 от 10.02.23 г</span>
                            <span class="about-licenses__spec">Испытания электрооборудования</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 7 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">СРО проектировщиков</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">СРО-П-161-09092010</span>
                            <span class="about-licenses__spec">Проектирование инженерных систем</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 8 -->
                <div class="about-licenses__item">
                    <div class="about-licenses__item-image">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title">СРО строителей</h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec">СРО-С-258-11012013</span>
                            <span class="about-licenses__spec">Строительно-монтажные работы</span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>

