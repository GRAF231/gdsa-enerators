<?php
/*
Template Name: Design & EPC
*/

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

<!-- Заголовок страницы -->
<header class="page-header">
    <div class="container">
        <h1 class="page-header__title"><?php echo esc_html(get_field('design_epc_page_title') ?: 'Энергокомплексы под ключ: проектирование, производство, СМР, ПНР'); ?></h1>
        <p class="page-header__subtitle"><?php echo esc_html(get_field('design_epc_page_subtitle') ?: 'Полный цикл создания энергосистем от проектирования до ввода в эксплуатацию'); ?></p>
    </div>
</header>

<!-- Основной контент -->
<main class="main-content">
    <!-- Основная информация -->
    <section class="epc-intro">
        <div class="container">
            <div class="epc-intro__content">
                <div class="epc-intro__text">
                    <h2><?php echo esc_html(get_field('design_epc_intro_title') ?: 'DSA Generators как генеральный подрядчик'); ?></h2>
                    <p><?php echo esc_html(get_field('design_epc_intro_text_1') ?: 'ООО «DSA Generators» предоставляет услуги энергоснабжения «под ключ», выступая в роли генерального подрядчика. Мы выполняем работы по фиксированной цене и берем на себя риски от этапа проектирования до сдачи готового объекта заказчику.'); ?></p>
                    
                    <p><?php echo esc_html(get_field('design_epc_intro_text_2') ?: 'Мы являемся не только производителем энергокомплексов (дизельных электростанций в кожухах и контейнерах), но и интегратором энергетических решений, включая строительные, монтажные и электромонтажные работы.'); ?></p>
                </div>
                <div class="epc-intro__image">
                    <?php 
                    $intro_image = get_field('design_epc_intro_image');
                    if ($intro_image) : ?>
                        <img src="<?php echo esc_url($intro_image['url']); ?>" alt="<?php echo esc_attr($intro_image['alt'] ?: 'Энергокомплекс под ключ'); ?>" loading="lazy">
                    <?php else : ?>
                        <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=600&h=400&fit=crop&crop=center" alt="Энергокомплекс под ключ" loading="lazy">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Лицензии и разрешения -->
    <section class="epc-licenses">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('design_epc_licenses_title') ?: 'Лицензии и разрешения'); ?></h2>
            <div class="licenses-grid">
                <?php 
                $licenses = get_field('design_epc_licenses_list');
                if ($licenses) :
                    foreach ($licenses as $license) : ?>
                        <div class="license-card">
                            <div class="license-card__icon">
                                <i class="fa-solid <?php echo esc_attr($license['license_icon'] ?: 'fa-certificate'); ?>"></i>
                            </div>
                            <div class="license-card__content">
                                <h3><?php echo esc_html($license['license_title']); ?></h3>
                                <p><?php echo esc_html($license['license_description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                else : ?>
                    <div class="license-card">
                        <div class="license-card__icon">
                            <i class="fa-solid fa-drafting-compass"></i>
                        </div>
                        <div class="license-card__content">
                            <h3>Проектные работы</h3>
                            <p>Разрешение на выполнение проектных работ позволяет нам проводить инженерные изыскания и готовить проектную документацию для объектов стоимостью до 25 млн рублей.</p>
                        </div>
                    </div>
                    <div class="license-card">
                        <div class="license-card__icon">
                            <i class="fa-solid fa-hammer"></i>
                        </div>
                        <div class="license-card__content">
                            <h3>Строительные работы</h3>
                            <p>Разрешение на выполнение строительных работ дает нам право выполнять строительство, реконструкцию и капитальный ремонт объектов стоимостью до 500 млн рублей.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Производственные возможности -->
    <section class="epc-production">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('design_epc_production_title') ?: 'Производственные возможности'); ?></h2>
            <div class="production-stats">
                <?php 
                $stats = get_field('design_epc_production_stats');
                if ($stats) :
                    foreach ($stats as $stat) : ?>
                        <div class="stat-card">
                            <div class="stat-card__number"><?php echo esc_html($stat['stat_number']); ?></div>
                            <div class="stat-card__label"><?php echo esc_html($stat['stat_label']); ?></div>
                        </div>
                    <?php endforeach;
                else : ?>
                    <div class="stat-card">
                        <div class="stat-card__number">300</div>
                        <div class="stat-card__label">изделий в год</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card__number">80</div>
                        <div class="stat-card__label">МВт мощность</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card__number">12</div>
                        <div class="stat-card__label">лет опыта</div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="production-description">
                <p><?php echo esc_html(get_field('design_epc_production_text_1') ?: 'Наш производственный комплекс изготавливает 300 изделий в год, включая контейнеры, дизельные генераторные установки (ДГУ) и автоматические вводы резерва (АВР) для дизельных генераторов.'); ?></p>
                <p><?php echo esc_html(get_field('design_epc_production_text_2') ?: 'Дизельные генераторные установки, производимые ООО «DSA Generators», разработаны согласно специальным техническим условиям: ТУ 27.11.31-001-23041585-2018.'); ?></p>
            </div>
        </div>
    </section>

    <!-- Услуги инженерного центра -->
    <section class="epc-services">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('design_epc_services_title') ?: 'Услуги инженерного центра'); ?></h2>
            <div class="services-grid">
                <?php 
                $services = get_field('design_epc_services_list');
                if ($services) :
                    foreach ($services as $service) : ?>
                        <div class="service-card">
                            <div class="service-card__icon">
                                <i class="fa-solid <?php echo esc_attr($service['service_icon'] ?: 'fa-bolt'); ?>"></i>
                            </div>
                            <h3><?php echo esc_html($service['service_title']); ?></h3>
                            <p><?php echo esc_html($service['service_description']); ?></p>
                        </div>
                    <?php endforeach;
                else : ?>
                    <div class="service-card">
                        <div class="service-card__icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <h3>Дизельные энергокомплексы</h3>
                        <p>Проектирование дизельных энергокомплексов с источниками бесперебойного питания (ИБП) для потребителей I категории надежности.</p>
                    </div>
                    <div class="service-card">
                        <div class="service-card__icon">
                            <i class="fa-solid fa-plug"></i>
                        </div>
                        <h3>Трансформаторные подстанции</h3>
                        <p>Проектирование трансформаторных подстанций типа РУНН, КСО, ВРУ, АВР.</p>
                    </div>
                    <div class="service-card">
                        <div class="service-card__icon">
                            <i class="fa-solid fa-desktop"></i>
                        </div>
                        <h3>Системы диспетчеризации</h3>
                        <p>Проектирование систем диспетчеризации и удаленного мониторинга, включая параллельную работу дизельных генераторных установок (ДГУ).</p>
                    </div>
                    <div class="service-card">
                        <div class="service-card__icon">
                            <i class="fa-solid fa-cogs"></i>
                        </div>
                        <h3>АСУ ТП</h3>
                        <p>Проектирование автоматизированных систем управления технологическими процессами (АСУ ТП) с внедрением SCADA, программированием панелей управления ДГУ, организацией удаленного мониторинга и интеграцией систем видеонаблюдения.</p>
                    </div>
                    <div class="service-card">
                        <div class="service-card__icon">
                            <i class="fa-solid fa-search"></i>
                        </div>
                        <h3>Техническая экспертиза</h3>
                        <p>Инструментальные обследования для определения фактических нагрузок и воздействий на конструкции, поверочные расчеты фундаментной плиты под объект, техническое обследование фундамента и грунтов основания сооружения.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Как выгодно приобрести -->
    <section class="epc-process">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('design_epc_process_title') ?: 'Как выгодно приобрести дизельную электростанцию под ключ'); ?></h2>
            <div class="process-steps">
                <?php 
                $steps = get_field('design_epc_process_steps');
                if ($steps) :
                    $step_number = 1;
                    foreach ($steps as $step) : ?>
                        <div class="process-step">
                            <div class="process-step__number"><?php echo $step_number++; ?></div>
                            <div class="process-step__content">
                                <h3><?php echo esc_html($step['step_title']); ?></h3>
                                <p><?php echo esc_html($step['step_description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                else : 
                    $default_steps = [
                        ['title' => 'Вызов инженера', 'description' => 'Вызвать инженера DSA Generators на ваш объект для оценки технических параметров ДЭС и требований к установке.'],
                        ['title' => 'Определение мощности', 'description' => 'Определить требуемую номинальную мощность от потребителей. В случае высоких пусковых токов добавить необходимый коэффициент запаса по мощности.'],
                        ['title' => 'Разработка документации', 'description' => 'Заказать у DSA Generators разработку проектной и рабочей документации.'],
                        ['title' => 'Заключение договора', 'description' => 'Согласовать бюджет и заключить договор с DSA Generators на поставку ДЭС и комплекс строительных и электромонтажных работ.'],
                        ['title' => 'Подготовка площадки', 'description' => 'Подготовить площадку для начала работы специалистов DSA Generators.']
                    ];
                    $step_number = 1;
                    foreach ($default_steps as $step) : ?>
                        <div class="process-step">
                            <div class="process-step__number"><?php echo $step_number++; ?></div>
                            <div class="process-step__content">
                                <h3><?php echo esc_html($step['title']); ?></h3>
                                <p><?php echo esc_html($step['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

    <!-- Дополнительные опции -->
    <section class="epc-options">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('design_epc_options_title') ?: 'Выберите дополнительно для дизельной электростанции'); ?></h2>
            <div class="options-grid">
                <?php 
                $options = get_field('design_epc_options_list');
                if ($options) :
                    foreach ($options as $option) : 
                        $highlighted_class = ($option['option_highlighted']) ? ' option-item_highlighted' : '';
                        ?>
                        <div class="option-item<?php echo esc_attr($highlighted_class); ?>">
                            <div class="option-item__icon">
                                <i class="fa-solid <?php echo esc_attr($option['option_icon'] ?: 'fa-box'); ?>"></i>
                            </div>
                            <div class="option-item__content">
                                <h3><?php echo esc_html($option['option_title']); ?></h3>
                                <p><?php echo esc_html($option['option_description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                else : 
                    $default_options = [
                        ['icon' => 'fa-box', 'title' => 'Контейнер цельносварной', 'description' => 'С электрикой, ЩСН, отоплением, вентиляцией, пожарной и охранной сигнализацией', 'highlighted' => false],
                        ['icon' => 'fa-oil-can', 'title' => 'Опции для ДГУ', 'description' => 'Топливный бак до 10000 л с датчиками уровня, система автоподкачки топлива, дополнительный масляный бак 500 л', 'highlighted' => false],
                        ['icon' => 'fa-bolt', 'title' => 'Высоковольтные ДГУ', 'description' => '6/10 кВ, КСО с вакуумным выключателем, повышающий трансформатор, модуль управления', 'highlighted' => false],
                        ['icon' => 'fa-truck', 'title' => 'Шасси', 'description' => 'С осевой нагрузкой до 20 тонн', 'highlighted' => false],
                        ['icon' => 'fa-volume-down', 'title' => 'Шумозащитный кожух', 'description' => 'С критическим глушителем 55 дБ (А)', 'highlighted' => false],
                        ['icon' => 'fa-desktop', 'title' => 'АСУ ТП', 'description' => 'С внедрением SCADA, удаленный мониторинг и управление ДГУ', 'highlighted' => false],
                        ['icon' => 'fa-exchange-alt', 'title' => 'АВР и параллельная работа', 'description' => 'Нескольких ДГУ', 'highlighted' => true],
                        ['icon' => 'fa-plug', 'title' => 'Интеграция с КТП', 'description' => 'ДГУ с комплектной трансформаторной подстанцией', 'highlighted' => false],
                        ['icon' => 'fa-battery-full', 'title' => 'ИБП', 'description' => 'От 20 до 500 кВА: Online с АВР, ВРУ и ДГУ для потребителей I категории надежности', 'highlighted' => false],
                        ['icon' => 'fa-drafting-compass', 'title' => 'Проектирование и РД', 'description' => 'Техническая экспертиза, электролаборатория до 10 кВ', 'highlighted' => false],
                        ['icon' => 'fa-tools', 'title' => 'Строительно-монтажные работы', 'description' => 'Прокладка кабельной трассы, установка РУ, допуск от Ростехнадзора', 'highlighted' => false]
                    ];
                    foreach ($default_options as $option) : 
                        $highlighted_class = ($option['highlighted']) ? ' option-item_highlighted' : '';
                        ?>
                        <div class="option-item<?php echo esc_attr($highlighted_class); ?>">
                            <div class="option-item__icon">
                                <i class="fa-solid <?php echo esc_attr($option['icon']); ?>"></i>
                            </div>
                            <div class="option-item__content">
                                <h3><?php echo esc_html($option['title']); ?></h3>
                                <p><?php echo esc_html($option['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

    <!-- Сервисная служба -->
    <section class="epc-service">
        <div class="container">
            <h2 class="section-title"><?php echo esc_html(get_field('design_epc_service_title') ?: 'Сервисная служба DSA Generators'); ?></h2>
            <p class="section-subtitle"><?php echo esc_html(get_field('design_epc_service_subtitle') ?: 'Осуществляет строительные и электромонтажные работы'); ?></p>
            <div class="service-list">
                <?php 
                $service_list = get_field('design_epc_service_list');
                if ($service_list) :
                    $service_number = 1;
                    foreach ($service_list as $service) : ?>
                        <div class="service-item">
                            <div class="service-item__number"><?php echo $service_number++; ?></div>
                            <div class="service-item__content">
                                <h3><?php echo esc_html($service['service_item_title']); ?></h3>
                                <p><?php echo esc_html($service['service_item_description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                else : 
                    $default_service_items = [
                        ['title' => 'Земляные работы', 'description' => 'Разработка грунта, устройство песчаного основания, устройство бетонной подготовки, устройство армирования фундамента, заливка бетона, гидроизоляция.'],
                        ['title' => 'Строительные работы', 'description' => 'Капитальный ремонт зданий (имеем лицензию от КГИОП СПб – Минкультуры РФ), алмазное бурение в железобетонных перекрытиях, демонтаж аварийных конструкций, укладка асфальта, благоустройство.'],
                        ['title' => 'Монтаж дополнительного оборудования', 'description' => 'Прокладка трубопроводов, установка топливных емкостей, систем газовыхлопа, драйкулеров, пожарно-охранной сигнализации, автоматических систем пожаротушения (аэрозоль и газ), сплит-систем кондиционирования, автоматической приточно-вытяжной вентиляции.'],
                        ['title' => 'Электромонтажные работы', 'description' => 'Прокладка кабельной трассы от ДГУ, установка контура заземления фундамента, сборка и подключение щитов АВР.'],
                        ['title' => 'Пуско-наладочные работы', 'description' => 'Тестирование нагрузочными модулями мощностью до 2 МВт, приемо-сдаточные испытания и получение допуска Ростехнадзора.'],
                        ['title' => 'Сервисное обслуживание', 'description' => 'ДГУ, ГПУ, ИБП, ДИБП, трансформаторных подстанций (проверка ячеек, измерения, протяжка контактных соединений).']
                    ];
                    $service_number = 1;
                    foreach ($default_service_items as $service) : ?>
                        <div class="service-item">
                            <div class="service-item__number"><?php echo $service_number++; ?></div>
                            <div class="service-item__content">
                                <h3><?php echo esc_html($service['title']); ?></h3>
                                <p><?php echo esc_html($service['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

    <!-- Форма обратной связи -->
    <div class="contact-form">
        <?php echo do_shortcode('[contact-form-7 id="66a6e0c" title="Оставьте заявку"]'); ?>
    </div>  

</main>
   
<?php get_footer(); ?>
