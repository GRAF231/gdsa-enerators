<?php
/*
Template Name: Design & EPC
*/

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

<!-- Заголовок страницы -->
<header class="page-header">
    <div class="container">
        <h1 class="page-header__title">Энергокомплексы под ключ: проектирование, производство, СМР, ПНР</h1>
        <p class="page-header__subtitle">Полный цикл создания энергосистем от проектирования до ввода в эксплуатацию</p>
    </div>
</header> 

<!-- Основной контент -->
<main class="main-content">
    <!-- ACF: Основная информация -->
    <!-- Основная информация -->
    <section class="epc-intro">
        <div class="container">
            <div class="epc-intro__content">
                <div class="epc-intro__text">
                    <h2>DSA Generators как генеральный подрядчик</h2>
                    <p>ООО «DSA Generators» предоставляет услуги энергоснабжения «под ключ», выступая в роли генерального подрядчика. Мы выполняем работы по фиксированной цене и берем на себя риски от этапа проектирования до сдачи готового объекта заказчику.</p>
                    
                    <p>Мы являемся не только производителем энергокомплексов (дизельных электростанций в кожухах и контейнерах), но и интегратором энергетических решений, включая строительные, монтажные и электромонтажные работы.</p>
                </div>
                <div class="epc-intro__image">
                    <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=600&h=400&fit=crop&crop=center" alt="Энергокомплекс под ключ" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Лицензии и разрешения -->
    <!-- Лицензии и разрешения -->
    <section class="epc-licenses">
        <div class="container">
            <h2 class="section-title">Лицензии и разрешения</h2>
            <div class="licenses-grid">
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
            </div>
        </div>
    </section>

    <!-- ACF: Производственные возможности -->
    <!-- Производственные возможности -->
    <section class="epc-production">
        <div class="container">
            <h2 class="section-title">Производственные возможности</h2>
            <div class="production-stats">
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
            </div>
            <div class="production-description">
                <p>Наш производственный комплекс изготавливает 300 изделий в год, включая контейнеры, дизельные генераторные установки (ДГУ) и автоматические вводы резерва (АВР) для дизельных генераторов.</p>
                <p>Дизельные генераторные установки, производимые ООО «DSA Generators», разработаны согласно специальным техническим условиям: ТУ 27.11.31-001-23041585-2018.</p>
            </div>
        </div>
    </section>

    <!-- ACF: Услуги инженерного центра -->
    <!-- Услуги инженерного центра -->
    <section class="epc-services">
        <div class="container">
            <h2 class="section-title">Услуги инженерного центра</h2>
            <div class="services-grid">
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
            </div>
        </div>
    </section>

    <!-- ACF: Как выгодно приобрести -->
    <!-- Как выгодно приобрести -->
    <section class="epc-process">
        <div class="container">
            <h2 class="section-title">Как выгодно приобрести дизельную электростанцию под ключ</h2>
            <div class="process-steps">
                <div class="process-step">
                    <div class="process-step__number">1</div>
                    <div class="process-step__content">
                        <h3>Вызов инженера</h3>
                        <p>Вызвать инженера DSA Generators на ваш объект для оценки технических параметров ДЭС и требований к установке.</p>
                    </div>
                </div>
                <div class="process-step">
                    <div class="process-step__number">2</div>
                    <div class="process-step__content">
                        <h3>Определение мощности</h3>
                        <p>Определить требуемую номинальную мощность от потребителей. В случае высоких пусковых токов добавить необходимый коэффициент запаса по мощности.</p>
                    </div>
                </div>
                <div class="process-step">
                    <div class="process-step__number">3</div>
                    <div class="process-step__content">
                        <h3>Разработка документации</h3>
                        <p>Заказать у DSA Generators разработку проектной и рабочей документации.</p>
                    </div>
                </div>
                <div class="process-step">
                    <div class="process-step__number">4</div>
                    <div class="process-step__content">
                        <h3>Заключение договора</h3>
                        <p>Согласовать бюджет и заключить договор с DSA Generators на поставку ДЭС и комплекс строительных и электромонтажных работ.</p>
                    </div>
                </div>
                <div class="process-step">
                    <div class="process-step__number">5</div>
                    <div class="process-step__content">
                        <h3>Подготовка площадки</h3>
                        <p>Подготовить площадку для начала работы специалистов DSA Generators.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Дополнительные опции -->
    <!-- Дополнительные опции -->
    <section class="epc-options">
        <div class="container">
            <h2 class="section-title">Выберите дополнительно для дизельной электростанции</h2>
            <div class="options-grid">
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Контейнер цельносварной</h3>
                        <p>С электрикой, ЩСН, отоплением, вентиляцией, пожарной и охранной сигнализацией</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-oil-can"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Опции для ДГУ</h3>
                        <p>Топливный бак до 10000 л с датчиками уровня, система автоподкачки топлива, дополнительный масляный бак 500 л</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Высоковольтные ДГУ</h3>
                        <p>6/10 кВ, КСО с вакуумным выключателем, повышающий трансформатор, модуль управления</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-truck"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Шасси</h3>
                        <p>С осевой нагрузкой до 20 тонн</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-volume-down"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Шумозащитный кожух</h3>
                        <p>С критическим глушителем 55 дБ (А)</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-desktop"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>АСУ ТП</h3>
                        <p>С внедрением SCADA, удаленный мониторинг и управление ДГУ</p>
                    </div>
                </div>
                <div class="option-item option-item_highlighted">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-exchange-alt"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>АВР и параллельная работа</h3>
                        <p>Нескольких ДГУ</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-plug"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Интеграция с КТП</h3>
                        <p>ДГУ с комплектной трансформаторной подстанцией</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-battery-full"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>ИБП</h3>
                        <p>От 20 до 500 кВА: Online с АВР, ВРУ и ДГУ для потребителей I категории надежности</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-drafting-compass"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Проектирование и РД</h3>
                        <p>Техническая экспертиза, электролаборатория до 10 кВ</p>
                    </div>
                </div>
                <div class="option-item">
                    <div class="option-item__icon">
                        <i class="fa-solid fa-tools"></i>
                    </div>
                    <div class="option-item__content">
                        <h3>Строительно-монтажные работы</h3>
                        <p>Прокладка кабельной трассы, установка РУ, допуск от Ростехнадзора</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Сервисная служба -->
    <!-- Сервисная служба -->
    <section class="epc-service">
        <div class="container">
            <h2 class="section-title">Сервисная служба DSA Generators</h2>
            <p class="section-subtitle">Осуществляет строительные и электромонтажные работы</p>
            <div class="service-list">
                <div class="service-item">
                    <div class="service-item__number">1</div>
                    <div class="service-item__content">
                        <h3>Земляные работы</h3>
                        <p>Разработка грунта, устройство песчаного основания, устройство бетонной подготовки, устройство армирования фундамента, заливка бетона, гидроизоляция.</p>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-item__number">2</div>
                    <div class="service-item__content">
                        <h3>Строительные работы</h3>
                        <p>Капитальный ремонт зданий (имеем лицензию от КГИОП СПб – Минкультуры РФ), алмазное бурение в железобетонных перекрытиях, демонтаж аварийных конструкций, укладка асфальта, благоустройство.</p>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-item__number">3</div>
                    <div class="service-item__content">
                        <h3>Монтаж дополнительного оборудования</h3>
                        <p>Прокладка трубопроводов, установка топливных емкостей, систем газовыхлопа, драйкулеров, пожарно-охранной сигнализации, автоматических систем пожаротушения (аэрозоль и газ), сплит-систем кондиционирования, автоматической приточно-вытяжной вентиляции.</p>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-item__number">4</div>
                    <div class="service-item__content">
                        <h3>Электромонтажные работы</h3>
                        <p>Прокладка кабельной трассы от ДГУ, установка контура заземления фундамента, сборка и подключение щитов АВР.</p>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-item__number">5</div>
                    <div class="service-item__content">
                        <h3>Пуско-наладочные работы</h3>
                        <p>Тестирование нагрузочными модулями мощностью до 2 МВт, приемо-сдаточные испытания и получение допуска Ростехнадзора.</p>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-item__number">6</div>
                    <div class="service-item__content">
                        <h3>Сервисное обслуживание</h3>
                        <p>ДГУ, ГПУ, ИБП, ДИБП, трансформаторных подстанций (проверка ячеек, измерения, протяжка контактных соединений).</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACF: Форма обратной связи (CF7) -->
    <!-- Форма обратной связи -->
    <section class="epc-contact">
        <div class="container">
            <div class="contact-form">
                <h2 class="contact-form__title">Получите консультацию по проектированию энергокомплекса</h2>
                <p class="contact-form__subtitle">Наши инженеры помогут определить оптимальное решение для вашего объекта</p>
                <!-- Здесь будет интегрирована форма Contact Form 7 через шорткод -->
                <form class="contact-form__form">
                    <div class="contact-form__fields">
                        <div class="contact-form__column">
                            <div class="form-group">
                                <label for="epc-name" class="form-label">Имя</label>
                                <input type="text" id="epc-name" class="form-input" placeholder="Введите ваше имя" required>
                            </div>
                            <div class="form-group">
                                <label for="epc-email" class="form-label">E-mail</label>
                                <input type="email" id="epc-email" class="form-input" placeholder="Введите ваш email" required>
                            </div>
                            <div class="form-group">
                                <label for="epc-phone" class="form-label">Телефон</label>
                                <input type="tel" id="epc-phone" class="form-input" placeholder="Введите ваш телефон" required>
                            </div>
                        </div>
                        <div class="contact-form__column">
                            <div class="form-group">
                                <label for="epc-company" class="form-label">Компания</label>
                                <input type="text" id="epc-company" class="form-input" placeholder="Название вашей компании">
                            </div>
                            <div class="form-group">
                                <label for="epc-power" class="form-label">Требуемая мощность</label>
                                <input type="text" id="epc-power" class="form-input" placeholder="Например: 1000 кВт">
                            </div>
                            <div class="form-group">
                                <label for="epc-message" class="form-label">Описание проекта</label>
                                <textarea id="epc-message" class="form-textarea" placeholder="Опишите ваш проект, требования и особенности объекта"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="contact-form__footer">
                        <div class="form-checkbox">
                            <input type="checkbox" id="epc-consent" class="form-checkbox__input" required>
                            <label for="epc-consent" class="form-checkbox__label">
                                Согласен на обработку персональных данных и получение коммерческого предложения
                            </label>
                        </div>
                        <button type="submit" class="btn btn_type_primary contact-form__submit">
                            <i class="fa-solid fa-calculator"></i>
                            <span>Получить расчет</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- ACF: Лицензии компании -->
    <!-- Лицензии компании -->
    <section class="company-licenses">
        <div class="company-licenses__container">
            <div class="company-licenses__header">
                <div class="company-licenses__title-group">
                    <h2 class="company-licenses__title">ЛИЦЕНЗИИ</h2>
                    <h3 class="company-licenses__subtitle">КОМПАНИИ</h3>
                </div>
                <div class="company-licenses__description">
                    <span class="company-licenses__desc-text">СЕРТИФИКАТЫ</span>
                    <span class="company-licenses__desc-text">КАЧЕСТВА</span>
                    <span class="company-licenses__desc-text">И</span>
                    <span class="company-licenses__desc-text">СООТВЕТСТВИЯ</span>
                </div>
            </div>
            
            <div class="company-licenses__grid">
                <!-- Карточка лицензии 1 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">Сертификат авторизованного дилера</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">Cummins в России</span>
                            <span class="company-licenses__spec">ООО «DSA Generators»</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 2 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">Сертификат соответствия</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">СМК ГОСТ Р ИСО 9001-2015</span>
                            <span class="company-licenses__spec">Система менеджмента качества</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 3 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">Сертификат соответствия</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">ГОСТ Р ИСО 45001-2020</span>
                            <span class="company-licenses__spec">Безопасность труда и охрана здоровья</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 4 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">Выписка из Реестра СРО</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">Саморегулируемая организация</span>
                            <span class="company-licenses__spec">Область строительства</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 5 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">Сертификат соответствия</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">ГОСТ Р ИСО 14001-2016</span>
                            <span class="company-licenses__spec">Система экологического менеджмента</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 6 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">Лицензия электролаборатории</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">№ 9173 от 10.02.23 г</span>
                            <span class="company-licenses__spec">Испытания электрооборудования</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 7 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">СРО проектировщиков</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">СРО-П-161-09092010</span>
                            <span class="company-licenses__spec">Проектирование инженерных систем</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
                
                <!-- Карточка лицензии 8 -->
                <div class="company-licenses__item">
                    <div class="company-licenses__item-image">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="company-licenses__item-content">
                        <h4 class="company-licenses__item-title">СРО строителей</h4>
                        <div class="company-licenses__item-specs">
                            <span class="company-licenses__spec">СРО-С-258-11012013</span>
                            <span class="company-licenses__spec">Строительно-монтажные работы</span>
                        </div>
                        <div class="company-licenses__item-status">
                            <span class="company-licenses__status">Действующий</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
