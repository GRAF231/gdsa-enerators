
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
                    <h1 class="about-advantages__title"><?php echo esc_html(get_field('advantages_company_name') ?: 'ООО «DSA Generators»'); ?></h1>
                    <h2 class="about-advantages__subtitle"><?php echo esc_html(get_field('advantages_subtitle') ?: 'В МОСКВЕ'); ?></h2>
                </div>
                <div class="about-advantages__description">
                    <span class="about-advantages__desc-text"><?php echo esc_html(get_field('advantages_inn') ?: 'ИНН 7840490040'); ?></span>
                    <span class="about-advantages__desc-text">НАШИ</span>
                    <span class="about-advantages__desc-text">ПРЕИМУЩЕСТВА</span>
                </div>
            </div>

            <!-- Сетка преимуществ -->
            <div class="about-advantages__grid">
                <?php 
                $stability = get_field('advantages_stability');
                $reliability = get_field('advantages_reliability');
                $potential = get_field('advantages_potential');
                ?>
                
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
                            <div class="about-advantages__stat-number" data-count="<?php echo esc_attr($stability['years_count'] ?? 12); ?>">0<span class="about-advantages__stat-suffix">+</span></div>
                            <div class="about-advantages__stat-text"><?php echo esc_html($stability['years_text'] ?? 'Лет компании, основана в 2013 году'); ?></div>
                        </div>
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="<?php echo esc_attr($stability['employees_count'] ?? 110); ?>">0<span class="about-advantages__stat-suffix">+</span></div>
                            <div class="about-advantages__stat-text"><?php echo esc_html($stability['employees_text'] ?? 'Сотрудников в штате'); ?></div>
                        </div>
                    </div>
                    <div class="about-advantages__card-footer">
                        <div class="about-advantages__progress">
                            <div class="about-advantages__progress-bar" style="width: <?php echo esc_attr($stability['progress_percent'] ?? 95); ?>%"></div>
                        </div>
                        <span class="about-advantages__progress-text">Надежность <?php echo esc_html($stability['progress_percent'] ?? 95); ?>%</span>
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
                            <div class="about-advantages__stat-number" data-count="<?php echo esc_attr($reliability['projects_count'] ?? 500); ?>">0<span class="about-advantages__stat-suffix">+</span></div>
                            <div class="about-advantages__stat-text"><?php echo esc_html($reliability['projects_text'] ?? 'Выполненных проектов по России и миру'); ?></div>
                        </div>
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="<?php echo esc_attr($reliability['revenue_amount'] ?? '3.8'); ?>">0<span class="about-advantages__stat-suffix">МЛРД</span></div>
                            <div class="about-advantages__stat-text"><?php echo esc_html($reliability['revenue_text'] ?? 'Выручка без НДС в 2024 году'); ?></div>
                        </div>
                    </div>
                    <div class="about-advantages__card-footer">
                        <div class="about-advantages__progress">
                            <div class="about-advantages__progress-bar" style="width: <?php echo esc_attr($reliability['progress_percent'] ?? 98); ?>%"></div>
                        </div>
                        <span class="about-advantages__progress-text">Успешность <?php echo esc_html($reliability['progress_percent'] ?? 98); ?>%</span>
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
                            <div class="about-advantages__stat-number" data-count="<?php echo esc_attr($potential['power_amount'] ?? 100); ?>">0<span class="about-advantages__stat-suffix">МВт</span></div>
                            <div class="about-advantages__stat-text"><?php echo esc_html($potential['power_text'] ?? 'Общая мощность проектов на 2025 год'); ?></div>
                        </div>
                        <div class="about-advantages__stat">
                            <div class="about-advantages__stat-number" data-count="<?php echo esc_attr($potential['area_amount'] ?? 3000); ?>">0<span class="about-advantages__stat-suffix">м²</span></div>
                            <div class="about-advantages__stat-text"><?php echo esc_html($potential['area_text'] ?? 'Площадь собственного производства'); ?></div>
                        </div>
                    </div>
                    <div class="about-advantages__card-footer">
                        <div class="about-advantages__progress">
                            <div class="about-advantages__progress-bar" style="width: <?php echo esc_attr($potential['progress_percent'] ?? 92); ?>%"></div>
                        </div>
                        <span class="about-advantages__progress-text">Потенциал <?php echo esc_html($potential['progress_percent'] ?? 92); ?>%</span>
                    </div>
                </div>
            </div>

            <!-- ACF: Техническая схема -->
            <div class="about-advantages__technical" data-aos="fade-up" data-aos-delay="400">
                <div class="about-advantages__technical-content">
                    <div class="about-advantages__technical-header">
                        <h3 class="about-advantages__technical-title"><?php echo esc_html(get_field('technical_title') ?: 'Наше производство'); ?></h3>
                        <p class="about-advantages__technical-subtitle"><?php echo esc_html(get_field('technical_subtitle') ?: 'Полный цикл от проектирования до поставки'); ?></p>
                    </div>
                    <div class="about-advantages__technical-grid">
                        <?php 
                        $technical_steps = get_field('technical_steps');
                        if ($technical_steps) :
                            $step_count = 0;
                            foreach ($technical_steps as $step) :
                                $step_count++;
                        ?>
                        <div class="about-advantages__tech-item">
                            <div class="about-advantages__tech-icon">
                                <i class="<?php echo esc_attr($step['technical_step_icon'] ?: 'fa-solid fa-cog'); ?>"></i>
                            </div>
                            <span class="about-advantages__tech-text"><?php echo esc_html($step['technical_step_title']); ?></span>
                        </div>
                        <?php if ($step_count < count($technical_steps)) : ?>
                        <div class="about-advantages__tech-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <?php endif; ?>
                        <?php 
                            endforeach;
                        else :
                            // Дефолтные этапы технической схемы, если ACF поля не заполнены
                            $default_steps = [
                                ['icon' => 'fa-solid fa-drafting-compass', 'title' => 'Проектирование'],
                                ['icon' => 'fa-solid fa-industry', 'title' => 'Производство'],
                                ['icon' => 'fa-solid fa-check-circle', 'title' => 'Контроль качества'],
                                ['icon' => 'fa-solid fa-truck', 'title' => 'Поставка']
                            ];
                            
                            $step_count = 0;
                            foreach ($default_steps as $step) :
                                $step_count++;
                        ?>
                        <div class="about-advantages__tech-item">
                            <div class="about-advantages__tech-icon">
                                <i class="<?php echo esc_attr($step['icon']); ?>"></i>
                            </div>
                            <span class="about-advantages__tech-text"><?php echo esc_html($step['title']); ?></span>
                        </div>
                        <?php if ($step_count < count($default_steps)) : ?>
                        <div class="about-advantages__tech-arrow">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                        <?php endif; ?>
                        <?php 
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Блок 10 причин выбрать DSA Generators -->
    <section class="about-reasons" id="reasons">
        <div class="container">
            <div class="about-reasons__header">
                <h2 class="about-reasons__title"><?php echo esc_html(get_field('reasons_title') ?: '10 причин выбрать «DSA Generators»: какую пользу мы принесем'); ?></h2>
            </div>
            
            <div class="about-reasons__list">
                <?php 
                $reasons = get_field('reasons_list');
                if ($reasons) :
                    foreach ($reasons as $reason) :
                ?>
                <div class="about-reasons__item">
                    <div class="about-reasons__number"><?php echo esc_html($reason['reason_number']); ?></div>
                    <div class="about-reasons__text">
                        <?php echo wp_kses_post($reason['reason_text']); ?>
                    </div>
                </div>
                <?php 
                    endforeach;
                else :
                    // Дефолтные причины, если ACF поля не заполнены
                    $default_reasons = [
                        'При поставке оборудования предлагаем взвешенное по цене и качеству решение, основанное на 20-летнем опыте наших инженеров. Разработаем ПД и РД. ЕРС и проектирование.',
                        'Не завышаем цены ради маржи. Посмотрите наши цены на дизель-генераторы <a href="#" class="about-reasons__link">500 кВт / 1000 кВт / 1500 кВт / 2000 кВт / 3000 кВт / контейнеры</a>.',
                        'Развиваем свое производство, а также имеем возможность импорта оборудования напрямую с заводов из Турции, Китая, Италии. <a href="#" class="about-reasons__link">Видео и фото с нашего производства</a>.',
                        'Наш опыт - более 500 выполненных проектов по поставкам ДГУ, в том числе для ЦОД, ГОК, нефтегазовых компаний, складов, отелей. <a href="#" class="about-reasons__link">Смотреть референс с фото</a>.',
                        'Компания имеет финансовую устойчивость: долгосрочные отношения с банками-партнёрами, банковская гарантия, спецсчет для участия в госзакупках.',
                        'Гарантируем своевременную поставку оборудования и даем рассрочку платежа. <a href="#" class="about-reasons__link">Обсудить с гендиректором</a>.',
                        'Допуски СРО на проектирование и СРО на строительство дают нам право заключения договоров на производство строительных работ для различных объектов.',
                        'Успешно поставляем дизель-генераторы для госзаказчиков по 44-ФЗ и коммерческим структурам по 223-ФЗ. <a href="#" class="about-reasons__link">Референс-лист 250 контрактов</a>.',
                        'Опыт ПНР, ремонта и ТО дизель-генераторов, в т.ч. для больниц, ЦОД, госструктур. Имеем собственную лицензированную электролабораторию. <a href="#" class="about-reasons__link">Примеры проектов</a>.',
                        'Большой опыт строительно-монтажных работ: <a href="#" class="about-reasons__link">посмотрите наши строительные проекты</a>.'
                    ];
                    
                    foreach ($default_reasons as $index => $reason_text) :
                ?>
                <div class="about-reasons__item">
                    <div class="about-reasons__number"><?php echo $index + 1; ?></div>
                    <div class="about-reasons__text">
                        <?php echo wp_kses_post($reason_text); ?>
                    </div>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- ACF: Направления деятельности -->
    <section class="section about-directions" id="directions">
        <div class="about-directions__container">
            <div class="about-directions__header">
                <div class="about-directions__title-group">
                    <h2 class="about-directions__title"><?php echo esc_html(get_field('directions_title') ?: 'НАПРАВЛЕНИЯ'); ?></h2>
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
                        <?php 
                        $directions = get_field('directions_list');
                        if ($directions) :
                            foreach ($directions as $direction) :
                                $image = $direction['direction_image'];
                        ?>
                        <!-- Карточка направления -->
                        <div class="about-directions__item">
                            <div class="about-directions__item-image">
                                <?php if ($image) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $direction['direction_title']); ?>" class="about-directions__img">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="<?php echo esc_attr($direction['direction_title']); ?>" class="about-directions__img">
                                <?php endif; ?>
                            </div>
                            <div class="about-directions__item-content">
                                <h4 class="about-directions__item-title"><?php echo esc_html($direction['direction_title']); ?></h4>
                                <div class="about-directions__item-specs">
                                    <?php if ($direction['direction_spec1']) : ?>
                                        <span class="about-directions__spec"><?php echo esc_html($direction['direction_spec1']); ?></span>
                                    <?php endif; ?>
                                    <?php if ($direction['direction_spec2']) : ?>
                                        <span class="about-directions__spec"><?php echo esc_html($direction['direction_spec2']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="about-directions__item-status">
                                    <span class="about-directions__status"><?php echo esc_html($direction['direction_status'] ?: 'Основное направление'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        else :
                            // Дефолтные направления, если ACF поля не заполнены
                            $default_directions = [
                                [
                                    'title' => 'Дизельные электростанции',
                                    'spec1' => 'Производство ДГУ',
                                    'spec2' => 'Мощность до 80 МВт',
                                    'status' => 'Основное направление'
                                ],
                                [
                                    'title' => 'Производство контейнеров',
                                    'spec1' => 'Металлоконструкции',
                                    'spec2' => 'Покрасочный цех',
                                    'status' => 'Собственное производство'
                                ],
                                [
                                    'title' => 'Строительно-монтажные работы',
                                    'spec1' => 'СРО строителей',
                                    'spec2' => 'Полный цикл работ',
                                    'status' => 'Лицензированные работы'
                                ],
                                [
                                    'title' => 'Проектирование и EPC',
                                    'spec1' => 'СРО проектировщиков',
                                    'spec2' => 'Проектная документация',
                                    'status' => 'Проектирование'
                                ],
                                [
                                    'title' => 'Сервисное обслуживание',
                                    'spec1' => 'Электролаборатория',
                                    'spec2' => 'Техническое обслуживание',
                                    'status' => 'Сервис'
                                ]
                            ];
                            
                            foreach ($default_directions as $direction) :
                        ?>
                        <!-- Карточка направления -->
                        <div class="about-directions__item">
                            <div class="about-directions__item-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="<?php echo esc_attr($direction['title']); ?>" class="about-directions__img">
                            </div>
                            <div class="about-directions__item-content">
                                <h4 class="about-directions__item-title"><?php echo esc_html($direction['title']); ?></h4>
                                <div class="about-directions__item-specs">
                                    <span class="about-directions__spec"><?php echo esc_html($direction['spec1']); ?></span>
                                    <span class="about-directions__spec"><?php echo esc_html($direction['spec2']); ?></span>
                                </div>
                                <div class="about-directions__item-status">
                                    <span class="about-directions__status"><?php echo esc_html($direction['status']); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        endif;
                        ?>
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
                <h2 class="about-quality__title"><?php echo esc_html(get_field('quality_title') ?: 'Качество нашей продукции и гарантии'); ?></h2>
            </div>
            
            <div class="about-quality__list">
                <?php 
                $quality_items = get_field('quality_list');
                if ($quality_items) :
                    foreach ($quality_items as $item) :
                ?>
                <div class="about-quality__item">
                    <div class="about-quality__icon">
                        <i class="<?php echo esc_attr($item['quality_icon'] ?: 'fa-solid fa-calendar-check'); ?>"></i>
                    </div>
                    <div class="about-quality__text">
                        <?php echo esc_html($item['quality_text']); ?>
                    </div>
                </div>
                <?php 
                    endforeach;
                else :
                    // Дефолтные пункты качества, если ACF поля не заполнены
                    $default_quality = [
                        [
                            'icon' => 'fa-solid fa-calendar-check',
                            'text' => 'Предоставляем расширенную гарантию 5 лет на выпускаемую продукцию'
                        ],
                        [
                            'icon' => 'fa-solid fa-flask-vial',
                            'text' => 'Применяем собственную лицензированную электролабораторию № 9173 от 10.02.23 г'
                        ],
                        [
                            'icon' => 'fa-solid fa-users',
                            'text' => 'Состоим в СРО проектировщиков (СРО-П-161-09092010) и в СРО строителей (СРО-С-258-11012013)'
                        ],
                        [
                            'icon' => 'fa-solid fa-shield-check',
                            'text' => 'Применяем систему менеджмента в области охраны труда (OHSAS 18000:2007)'
                        ],
                        [
                            'icon' => 'fa-solid fa-building-columns',
                            'text' => 'Состоим в Санкт-Петербургской торгово-промышленной палате'
                        ]
                    ];
                    
                    foreach ($default_quality as $item) :
                ?>
                <div class="about-quality__item">
                    <div class="about-quality__icon">
                        <i class="<?php echo esc_attr($item['icon']); ?>"></i>
                    </div>
                    <div class="about-quality__text">
                        <?php echo esc_html($item['text']); ?>
                    </div>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- ACF: Наше производство -->
    <section class="about-production" id="production">
        <div class="container">
            <div class="about-production__header">
                <h2 class="about-production__title"><?php echo esc_html(get_field('production_title') ?: 'Наше производство'); ?></h2>
            </div>
            
            <div class="about-production__grid">
                <?php 
                $production_items = get_field('production_items');
                if ($production_items) :
                    foreach ($production_items as $item) :
                        $image = $item['production_image'];
                ?>
                <div class="about-production__item">
                    <div class="about-production__image">
                        <?php if ($image) : ?>
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $item['production_title']); ?>" class="about-production__img">
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="<?php echo esc_attr($item['production_title']); ?>" class="about-production__img">
                        <?php endif; ?>
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title"><?php echo esc_html($item['production_title']); ?></h3>
                    </div>
                </div>
                <?php 
                    endforeach;
                else :
                    // Дефолтные элементы производства, если ACF поля не заполнены
                    $default_production = [
                        '15 лет производственному комплексу',
                        'Проектно-конструкторское бюро',
                        'Покрасочный цех',
                        'Площадь 3000 м²',
                        'Современные станки',
                        'Резка по металлу',
                        'Отдел технического контроля',
                        'Цех сборки электроизделий'
                    ];
                    
                    foreach ($default_production as $title) :
                ?>
                <div class="about-production__item">
                    <div class="about-production__image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/slider1.webp" alt="<?php echo esc_attr($title); ?>" class="about-production__img">
                    </div>
                    <div class="about-production__content">
                        <h3 class="about-production__item-title"><?php echo esc_html($title); ?></h3>
                    </div>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>


    <!-- ACF: Наши услуги -->
    <section class="about-services" id="services">
        <div class="container">
            <div class="about-services__header">
                <h2 class="about-services__title"><?php echo esc_html(get_field('services_title') ?: 'Наши услуги:'); ?></h2>
            </div>
            
            <div class="about-services__grid">
                <div class="about-services__column">
                    <?php 
                    $services_column1 = get_field('services_column1');
                    if ($services_column1) :
                        foreach ($services_column1 as $service) :
                    ?>
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="<?php echo esc_attr($service['service_icon'] ?: 'fa-solid fa-search'); ?>"></i>
                        </div>
                        <div class="about-services__text">
                            <?php echo esc_html($service['service_text']); ?>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else :
                        // Дефолтные услуги для первой колонки
                        $default_services1 = [
                            [
                                'icon' => 'fa-solid fa-search',
                                'text' => 'Проводим бесплатные предмонтажные осмотры по всей территории РФ и СНГ'
                            ],
                            [
                                'icon' => 'fa-solid fa-drafting-compass',
                                'text' => 'Разрабатываем проектную документацию, генеральные планы, рабочие чертежи'
                            ],
                            [
                                'icon' => 'fa-solid fa-eye',
                                'text' => 'Выполняем авторский надзор проектов своими силами'
                            ],
                            [
                                'icon' => 'fa-solid fa-file-alt',
                                'text' => 'Готовим исполнительную документацию'
                            ]
                        ];
                        
                        foreach ($default_services1 as $service) :
                    ?>
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="<?php echo esc_attr($service['icon']); ?>"></i>
                        </div>
                        <div class="about-services__text">
                            <?php echo esc_html($service['text']); ?>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
                
                <div class="about-services__column">
                    <?php 
                    $services_column2 = get_field('services_column2');
                    if ($services_column2) :
                        foreach ($services_column2 as $service) :
                    ?>
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="<?php echo esc_attr($service['service_icon'] ?: 'fa-solid fa-gavel'); ?>"></i>
                        </div>
                        <div class="about-services__text">
                            <?php echo esc_html($service['service_text']); ?>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else :
                        // Дефолтные услуги для второй колонки
                        $default_services2 = [
                            [
                                'icon' => 'fa-solid fa-gavel',
                                'text' => 'Оказываем сопровождение в тендерах, защищаем проекты, составляем уникальные ТЗ'
                            ],
                            [
                                'icon' => 'fa-solid fa-calculator',
                                'text' => 'Составляем сметную документацию и технико-экономические обоснования проектов'
                            ],
                            [
                                'icon' => 'fa-solid fa-clipboard-check',
                                'text' => 'Организуем приемо-сдаточные испытания'
                            ],
                            [
                                'icon' => 'fa-solid fa-certificate',
                                'text' => 'Получаем разрешения на допуск в эксплуатацию энергоустановок в Ростехнадзоре'
                            ]
                        ];
                        
                        foreach ($default_services2 as $service) :
                    ?>
                    <div class="about-services__item">
                        <div class="about-services__icon">
                            <i class="<?php echo esc_attr($service['icon']); ?>"></i>
                        </div>
                        <div class="about-services__text">
                            <?php echo esc_html($service['text']); ?>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Лицензии компании -->
    <section class="section about-licenses" id="licenses">
        <div class="about-licenses__container">
            <div class="about-licenses__header">
                <div class="about-licenses__title-group">
                    <h2 class="about-licenses__title"><?php echo esc_html(get_field('licenses_title') ?: 'ЛИЦЕНЗИИ'); ?></h2>
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
                <?php 
                $licenses = get_field('licenses_list');
                if ($licenses) :
                    foreach ($licenses as $license) :
                ?>
                <!-- Карточка лицензии -->
                <div class="about-licenses__item" 
                     data-modal-image="<?php echo esc_url($license['license_image']['url'] ?? ''); ?>"
                     data-modal-title="<?php echo esc_attr($license['license_title']); ?>">
                    <div class="about-licenses__item-image">
                        <?php if ($license['license_image']) : ?>
                            <img src="<?php echo esc_url($license['license_image']['url']); ?>" 
                                 alt="<?php echo esc_attr($license['license_image']['alt'] ?: $license['license_title']); ?>" 
                                 class="about-licenses__img">
                        <?php else : ?>
                            <i class="<?php echo esc_attr($license['license_icon'] ?: 'fa-solid fa-certificate'); ?>"></i>
                        <?php endif; ?>
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title"><?php echo esc_html($license['license_title']); ?></h4>
                        <div class="about-licenses__item-specs">
                            <?php if ($license['license_spec1']) : ?>
                                <span class="about-licenses__spec"><?php echo esc_html($license['license_spec1']); ?></span>
                            <?php endif; ?>
                            <?php if ($license['license_spec2']) : ?>
                                <span class="about-licenses__spec"><?php echo esc_html($license['license_spec2']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status"><?php echo esc_html($license['license_status'] ?: 'Действующий'); ?></span>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                else :
                    // Дефолтные лицензии, если ACF поля не заполнены
                    $default_licenses = [
                        [
                            'title' => 'Сертификат авторизованного дилера',
                            'spec1' => 'Yuchai в России',
                            'spec2' => 'ООО «DSA Generators»',
                            'status' => 'Действующий'
                        ],
                        [
                            'title' => 'Сертификат соответствия',
                            'spec1' => 'СМК ГОСТ Р ИСО 9001-2015',
                            'spec2' => 'Система менеджмента качества',
                            'status' => 'Действующий'
                        ],
                        [
                            'title' => 'Сертификат соответствия',
                            'spec1' => 'ГОСТ Р ИСО 45001-2020',
                            'spec2' => 'Безопасность труда и охрана здоровья',
                            'status' => 'Действующий'
                        ],
                        [
                            'title' => 'Выписка из Реестра СРО',
                            'spec1' => 'Саморегулируемая организация',
                            'spec2' => 'Область строительства',
                            'status' => 'Действующий'
                        ],
                        [
                            'title' => 'Сертификат соответствия',
                            'spec1' => 'ГОСТ Р ИСО 14001-2016',
                            'spec2' => 'Система экологического менеджмента',
                            'status' => 'Действующий'
                        ],
                        [
                            'title' => 'Лицензия электролаборатории',
                            'spec1' => '№ 9173 от 10.02.23 г',
                            'spec2' => 'Испытания электрооборудования',
                            'status' => 'Действующий'
                        ],
                        [
                            'title' => 'СРО проектировщиков',
                            'spec1' => 'СРО-П-161-09092010',
                            'spec2' => 'Проектирование инженерных систем',
                            'status' => 'Действующий'
                        ],
                        [
                            'title' => 'СРО строителей',
                            'spec1' => 'СРО-С-258-11012013',
                            'spec2' => 'Строительно-монтажные работы',
                            'status' => 'Действующий'
                        ]
                    ];
                    
                    foreach ($default_licenses as $license) :
                ?>
                <!-- Карточка лицензии -->
                <div class="about-licenses__item" 
                     data-modal-image="<?php echo get_template_directory_uri(); ?>/assets/img/gratitude/gr1.webp"
                     data-modal-title="<?php echo esc_attr($license['title']); ?>">
                    <div class="about-licenses__item-image">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gratitude/gr1.webp" 
                             alt="<?php echo esc_attr($license['title']); ?>" 
                             class="about-licenses__img">
                    </div>
                    <div class="about-licenses__item-content">
                        <h4 class="about-licenses__item-title"><?php echo esc_html($license['title']); ?></h4>
                        <div class="about-licenses__item-specs">
                            <span class="about-licenses__spec"><?php echo esc_html($license['spec1']); ?></span>
                            <span class="about-licenses__spec"><?php echo esc_html($license['spec2']); ?></span>
                        </div>
                        <div class="about-licenses__item-status">
                            <span class="about-licenses__status"><?php echo esc_html($license['status']); ?></span>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
</main>

<!-- Модальное окно для просмотра изображений лицензий -->
<div class="licenses-modal" id="licensesModal">
    <div class="licenses-modal__overlay"></div>
    <div class="licenses-modal__content">
        <button class="licenses-modal__close" aria-label="Закрыть модальное окно">
            <i class="fa-solid fa-times"></i>
        </button>
        <div class="licenses-modal__image-container">
            <img class="licenses-modal__image" src="" alt="">
        </div>
        <div class="licenses-modal__title"></div>
    </div>
</div>

<?php get_footer(); ?>






