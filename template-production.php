<?php
/**
 * Template Name: Производство
 * 
 * Шаблон страницы производства с ACF полями
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

    <!-- Заголовок страницы -->
    <section class="page-header">
        <div class="container">
        <h1 class="page-header__title"><?php echo esc_html(get_field('production_page_title') ?: 'Производство электростанций, контейнеров и электрощитов'); ?></h1>
        </div>
    </section>

<!-- Основной блок производства -->
    <section class="production-intro">
        <div class="container">
            <div class="production-intro__content">
                <p class="production-intro__text">
                <?php echo wp_kses_post(get_field('production_intro_text1') ?: '«DSA Generators» - один из крупнейших производителей электростанций и контейнеров на Северо-Западе. Производственные цеха ООО «DSA Generators» находятся в Выборгском районе Санкт-Петербурга и занимают площадь <strong>3000 м²</strong>. Производство работает с <strong>2008 года</strong>.'); ?>
                </p>
                <p class="production-intro__text">
                <?php echo wp_kses_post(get_field('production_intro_text2') ?: 'Объем производства: <strong>400 агрегатов в год</strong>. На производстве задействовано <strong>40 рабочих</strong> разных специальностей: инженеры-конструкторы, сборщики контейнеров и ДГУ, аттестованные сварщики, резчики по металлу, маляры, электрики.'); ?>
                </p>
                <p class="production-intro__text">
                <?php echo wp_kses_post(get_field('production_intro_text3') ?: 'Производство контейнеров для дизельных электроаграторов, шумозащитный кожух и на шасси. Устанавливаем системы освещения оборудования, отопления и вентиляции, газовыхлопа, автоматического пожаротушения и сигнализации, силовые шкафы, АВР, системы дистанционного мониторинга и управления.'); ?>
                </p>
            </div>
            
        <!-- CTA блок -->
            <div class="production-cta">
                <div class="production-cta__content">
                <h3 class="production-cta__title"><?php echo esc_html(get_field('production_cta_title') ?: 'Хотите экскурсию по нашему производству?'); ?></h3>
                    <p class="production-cta__text">
                    <?php 
                    $cta_text = get_field('production_cta_text') ?: 'Отправьте заявку на order+79336@dsa-generators.ru или позвоните 8 (800) 770-71-57';
                    // Автоматическое форматирование email и телефона
                    $cta_text = preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="production-cta__link">$1</a>', $cta_text);
                    $cta_text = preg_replace('/(\+?[0-9\s\-\(\)]{10,})/', '<a href="tel:$1" class="production-cta__link">$1</a>', $cta_text);
                    echo wp_kses_post($cta_text);
                    ?>
                    </p>
                </div>
            </div>

        <!-- Список производимой продукции -->
            <div class="production-list">
            <h3 class="production-list__title"><?php echo esc_html(get_field('production_list_title') ?: 'Мы производим и монтируем:'); ?></h3>
                <ul class="production-list__items">
                <?php 
                $production_items = get_field('production_list_items');
                if ($production_items) :
                    foreach ($production_items as $item) :
                ?>
                    <li class="production-list__item">
                        <i class="fa-solid fa-check production-list__icon" aria-hidden="true"></i>
                    <?php echo esc_html($item['production_item_text']); ?>
                    </li>
                <?php 
                    endforeach;
                else :
                    // Дефолтные элементы списка продукции, если ACF поля не заполнены
                    $default_production_items = [
                        'Контейнеры (цельнометаллические и из сэндвич-панелей) длиной от 2 до 20 м.',
                        'Противопожарные двери, ворота, клапаны, глушители (сертифицированные).',
                        'Топливные баки объемом от 500 до 15000 л.',
                        'Трубопроводы и воздуховоды.',
                        'Электрощитовое оборудование (ЩСН, РУ, ГРЩ, ЩАУ).'
                    ];
                    
                    foreach ($default_production_items as $item) :
                ?>
                    <li class="production-list__item">
                        <i class="fa-solid fa-check production-list__icon" aria-hidden="true"></i>
                    <?php echo esc_html($item); ?>
                    </li>
                <?php 
                    endforeach;
                endif;
                ?>
                </ul>
            </div>
        </div>
    </section>

<!-- Блок цехов и оборудования -->
    <section class="production-workshops">
        <div class="container">
        <?php 
        $workshops = get_field('production_workshops');
        if ($workshops) :
            foreach ($workshops as $workshop) :
                $title = esc_html($workshop['workshop_title']);
                $type = esc_attr($workshop['workshop_type']);
                $description = wp_kses_post($workshop['workshop_description']);
                $additional_text = wp_kses_post($workshop['workshop_additional_text']);
                $equipment = $workshop['workshop_equipment'];
                $machines = $workshop['workshop_machines'];
                $stats = $workshop['workshop_stats'];
                $images = $workshop['workshop_images'];
        ?>
            <div class="workshop-section">
            <h2 class="workshop-section__title"><?php echo $title; ?></h2>
                <div class="workshop-section__content">
                <?php if ($description) : ?>
                <p class="workshop-section__text">
                    <?php echo $description; ?>
                </p>
                <?php endif; ?>
                
                <?php if ($additional_text) : ?>
                    <p class="workshop-section__text">
                    <?php echo $additional_text; ?>
                </p>
                <?php endif; ?>
                
                <?php if ($equipment) : ?>
                    <ul class="workshop-section__equipment">
                    <?php foreach ($equipment as $item) : ?>
                        <li class="workshop-section__equipment-item">
                            <i class="fa-solid fa-check workshop-section__icon" aria-hidden="true"></i>
                        <?php echo esc_html($item['equipment_name']); ?>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                
                <?php if ($machines && $type === 'modern_machines') : ?>
                    <div class="machines-grid">
                    <?php foreach ($machines as $machine) : ?>
                        <div class="machine-card">
                        <h3 class="machine-card__title"><?php echo esc_html($machine['machine_title']); ?></h3>
                            <p class="machine-card__description">
                            <?php echo esc_html($machine['machine_description']); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <?php if ($stats) : ?>
                <div class="workshop-stats">
                    <?php foreach ($stats as $stat) : ?>
                    <p class="workshop-section__text">
                        <strong><?php echo esc_html($stat['stat_label']); ?>:</strong> <?php echo esc_html($stat['stat_value']); ?>
                    </p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($images) : ?>
                <div class="workshop-section__gallery">
                    <div class="gallery-grid">
                    <?php foreach ($images as $image) : ?>
                        <div class="gallery-item">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $title); ?>" class="gallery-item__img">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php 
            endforeach;
        else :
            // Дефолтные цеха, если ACF поля не заполнены
            $default_workshops = [
                [
                    'title' => 'Цех резки по металлу',
                    'description' => 'На участке обрабатывается листовой прокат, фасонный прокат, трубный прокат, сортовой прокат, сетка арматурная, нержавеющий прокат. Марки используемых материалов: Ст3, Ст08, 09Г2С, 12Х18Н10Т, сталь тонколистовая оцинкованная. Входной контроль поставляемого металлопроката осуществляется на участке в зоне склада металла. Производительность участка – <strong>30 тонн металла в месяц</strong>. Кадровый состав – <strong>7 человек</strong>. Организовано хранение металла и его обработка на станках:',
                    'equipment' => [
                        'гидравлические гильотинные ножницы Jordi CH-310 для резки листового металла толщиной до 10 мм;',
                        'гидравлический пресс Jordi PH-31025 для гибки металлических листов без предварительного нагрева металла;',
                        'ленточнопильные станки MetalMaster BSG 255 и WE-270DS для распила металлических заготовок;',
                        'сверлильные станки Metaltool MT-120 и КТК LG-25A.'
                    ]
                ],
                [
                    'title' => 'Современные машины 2022 года',
                    'description' => 'В 2022 году для увеличения объема производства, скорости и автоматизации введены в эксплуатацию новые современные машины:',
                    'machines' => [
                        [
                            'title' => 'Ленточнопильный станок Ergonomic 320.258 DG',
                            'description' => 'Ручной станок для резки профильного металла. Углы реза от -45° до +60°. Интегрированная система подачи СОЖ. Производится в Чехии.'
                        ],
                        [
                            'title' => 'Гильотинные ножницы SB 6/3200',
                            'description' => 'Оборудование для резки листового металла – промышленные ножницы с ЧПУ и автоматической подачей заготовок. До 3200 мм ширины и 20 мм толщины.'
                        ],
                        [
                            'title' => 'Листогибочный пресс MVD Inan iBend B175-3700',
                            'description' => 'Высокопроизводительная гидравлическая машина повышенной точности для гибки стальных листов. Производится в Турции.'
                        ],
                        [
                            'title' => 'Лазерный станок G-Weike LF3015CN 1500W',
                            'description' => 'Волоконный станок лазерной резки металла. Точность резки 0.01 мм для листов толщиной от 0 до 20 мм.'
                        ]
                    ]
                ],
                [
                    'title' => 'Сборочный цех',
                    'description' => 'Сварка и сборка изделий из ранее подготовленных листового металла и нарезанных заготовок. Используемые профессиональные сварочные аппараты: Kuhtreiber KIT 305, MAXI 315, EWM Picomig 180 Puls, ПДГ-312-5, Сварог CUT 70. При сборке контейнеров и металлоконструкций используются мостовые краны грузоподъемностью 5 и 10 тонн. Также в данном участке производится утепление и обшивка контейнеров. Количество рабочих на участке – <strong>7 человек</strong>.'
                ],
                [
                    'title' => 'Покрасочная камера',
                    'description' => 'В покрасочном участке производится окраска контейнеров, металлоконструкций и топливных баков. Площадь участка <strong>150 м²</strong>, высота <strong>6 м</strong>, включает в себя зону хранения лакокрасочных материалов. Перед покраской на очищенный металл наносится тонкий слой реактивного кислотного грунта (ортофосфорная кислота в растворе поливинилбутирального полимера), который обеспечивает антикоррозионные свойства.',
                    'additional_text' => 'Отдельные элементы окрашиваются в камере порошковой покраски. Используемое оборудование безвоздушного распыления: установка поршневого типа Contracor ASP-451 с пневмоприводом, ChemBalt CB-1195, аппарат безвоздушного электрического GRACO Ultra Max 695 производительностью 3 л/мин.'
                ],
                [
                    'title' => 'Цех сборки электрощитовой продукции',
                    'description' => 'Поддерживаем в запасе номенклатуру товаров, необходимую для сборки распределительных электрощитов, шкафов управления и автоматизации. Количество рабочих на участке – <strong>6 человек</strong> (с учётом привлечения персонала – до <strong>15 человек</strong>).'
                ],
                [
                    'title' => 'Конструкторский отдел',
                    'description' => 'На производстве работают конструкторы, которые не только проектируют контейнеры и металлоконструкции, но и осуществляют авторский надзор за результатами работы.'
                ],
                [
                    'title' => 'Цех изготовления топливных и масляных баков',
                    'description' => 'Количество рабочих на участке – <strong>3 человека</strong>. Производятся сборка топливно-масляных систем, систем охлаждения, систем выпуска отработанных газов.'
                ]
            ];
            
            foreach ($default_workshops as $workshop) :
        ?>
            <div class="workshop-section">
            <h2 class="workshop-section__title"><?php echo esc_html($workshop['title']); ?></h2>
                <div class="workshop-section__content">
                    <p class="workshop-section__text">
                    <?php echo wp_kses_post($workshop['description']); ?>
                </p>
                
                <?php if (isset($workshop['additional_text'])) : ?>
                    <p class="workshop-section__text">
                    <?php echo wp_kses_post($workshop['additional_text']); ?>
                </p>
                <?php endif; ?>
                
                <?php if (isset($workshop['equipment'])) : ?>
                <ul class="workshop-section__equipment">
                    <?php foreach ($workshop['equipment'] as $item) : ?>
                    <li class="workshop-section__equipment-item">
                        <i class="fa-solid fa-check workshop-section__icon" aria-hidden="true"></i>
                        <?php echo esc_html($item); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                
                <?php if (isset($workshop['machines'])) : ?>
                <div class="machines-grid">
                    <?php foreach ($workshop['machines'] as $machine) : ?>
                    <div class="machine-card">
                        <h3 class="machine-card__title"><?php echo esc_html($machine['title']); ?></h3>
                        <p class="machine-card__description">
                            <?php echo esc_html($machine['description']); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php 
            endforeach;
        endif;
        ?>
        </div>
    </section>

<!-- Преимущества производства -->
    <section class="production-advantages">
        <div class="container">
        <h2 class="production-advantages__title"><?php echo esc_html(get_field('production_advantages_title') ?: 'Преимущества производства'); ?></h2>
            <div class="advantages-grid">
            <?php 
            $advantages = get_field('production_advantages');
            if ($advantages) :
                foreach ($advantages as $advantage) :
            ?>
                <div class="advantage-item">
                    <i class="fa-solid fa-check advantage-item__icon" aria-hidden="true"></i>
                <p class="advantage-item__text"><?php echo esc_html($advantage['advantage_text']); ?></p>
                </div>
            <?php 
                endforeach;
            else :
                // Дефолтные преимущества, если ACF поля не заполнены
                $default_advantages = [
                    'Быстрое изготовление при максимально высоком качестве.',
                    'Решение всех вопросов по принципу «единого окна».',
                    'Полный цикл: проектирование, изготовление, покраска, монтаж, технический контроль.',
                    'Конструкторы с опытом работы более 15 лет.',
                    'Современные профессиональные станки.'
                ];
                
                foreach ($default_advantages as $advantage) :
            ?>
                <div class="advantage-item">
                    <i class="fa-solid fa-check advantage-item__icon" aria-hidden="true"></i>
                <p class="advantage-item__text"><?php echo esc_html($advantage); ?></p>
            </div>
            <?php 
                endforeach;
            endif;
            ?>
            </div>
        </div>
    </section>

<!-- Менеджмент и план-график работ -->
    <section class="production-management">
        <div class="container">
        <h2 class="production-management__title"><?php echo esc_html(get_field('production_management_title') ?: 'Менеджмент и план-график работ'); ?></h2>
            <div class="management-content">
                <p class="management-text">
                <?php echo wp_kses_post(get_field('production_management_text1') ?: 'ООО «DSA Generators» развивает производство совместно с ООО «Энерго Резерв» (ИНН 7811485655). В рамках совместной инвестиционной программы двух компаний в 2020 г. произошло расширение площадей производственных цехов.'); ?>
                </p>
                <p class="management-text">
                <?php echo wp_kses_post(get_field('production_management_text2') ?: 'Производство загружено заказами на изготовление технически сложных контейнеров не только для ДГУ, но и для частотных преобразователей, трансформаторов, стоек ИТ-оборудования, военных радиолокационных станций.'); ?>
                </p>
                <p class="management-text">
                <?php echo wp_kses_post(get_field('production_management_text3') ?: 'Главное преимущество нашего производства заключается в высоком качестве обработки и сборки металлоконструкций и контейнеров, поэтому нам доверяют изготовление изделий для нефтегазовых компаний и предприятий военно-промышленного комплекса.'); ?>
                </p>
                <div class="management-contacts">
                    <div class="management-contact">
                    <h3 class="management-contact__title"><?php echo esc_html(get_field('production_management_contact1_title') ?: 'План-график работ'); ?></h3>
                        <p class="management-contact__text">
                        <?php 
                        $contact1_text = get_field('production_management_contact1_text') ?: 'План-график работ и текущую загруженность производства можно узнать у генерального директора ООО «DSA Generators» по почте: director@dsa-generators.ru';
                        // Автоматическое форматирование email
                        $contact1_text = preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="management-contact__link">$1</a>', $contact1_text);
                        echo wp_kses_post($contact1_text);
                        ?>
                        </p>
                    </div>
                    <div class="management-contact">
                    <h3 class="management-contact__title"><?php echo esc_html(get_field('production_management_contact2_title') ?: 'Технические вопросы'); ?></h3>
                        <p class="management-contact__text">
                        <?php 
                        $contact2_text = get_field('production_management_contact2_text') ?: 'Технические вопросы и ТЗ можно присылать генеральному директору ООО «Энерго Резерв» по почте: zhukov@energorezerv.org';
                        // Автоматическое форматирование email
                        $contact2_text = preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', '<a href="mailto:$1" class="management-contact__link">$1</a>', $contact2_text);
                        echo wp_kses_post($contact2_text);
                        ?>
                    </p>
                </div>
                </div>
            </div>
        </div>
    </section>

<!-- Информация о контейнерах -->
    <section class="production-containers">
        <div class="container">
        <h2 class="production-containers__title"><?php echo esc_html(get_field('production_containers_title') ?: 'Узнать больше о производстве контейнеров:'); ?></h2>
            <p class="production-containers__text">
            <?php 
            $containers_link_url = get_field('production_containers_link_url');
            $containers_link_text = get_field('production_containers_link_text') ?: 'Техническая спецификация, комплектация, ТЗ на контейнеры для нефтегазовой отрасли, фотогалерея с производства 2020 г.';
            if ($containers_link_url) :
            ?>
            <a href="<?php echo esc_url($containers_link_url); ?>" class="production-containers__link"><?php echo esc_html($containers_link_text); ?></a>
            <?php else : ?>
            <a href="#" class="production-containers__link"><?php echo esc_html($containers_link_text); ?></a>
            <?php endif; ?>
            </p>
            <p class="production-containers__description">
            <?php echo esc_html(get_field('production_containers_description') ?: 'Контейнер цельносварной производится из комплектующих собственного производства:'); ?>
            </p>
            <ul class="containers-specs">
            <?php 
            $container_specs = get_field('production_containers_specs');
            if ($container_specs) :
                foreach ($container_specs as $spec) :
            ?>
                <li class="containers-specs__item">
                    <i class="fa-solid fa-check containers-specs__icon" aria-hidden="true"></i>
                <?php echo esc_html($spec['container_spec_text']); ?>
                </li>
            <?php 
                endforeach;
            else :
                // Дефолтные спецификации контейнеров, если ACF поля не заполнены
                $default_container_specs = [
                    'стойка несущая угловая из стальной квадрат-трубы 100х50х6 мм, обработанная огнезащитной краской "ОГРАКС-МСК";',
                    'панель стеновая: с наружной стороны облицована металлическим профилированным листом толщиной 1,5 мм с покрытием из эмали, с утеплителем из минераловатных плит толщиной 100 мм плотностью 30 кг/м³, с внутренней стороны облицована металлическим профилированным листом С-10 толщиной 0,5 мм;',
                    'конструкция кровельная: облицована с наружной стороны металлическим гладким листом толщиной 1,5 мм, с внешним покрытием из эмали, с утеплителем из минераловатных плит, плотностью 90 кг/м³, толщиной 100 мм, с внутренней стороны облицована металлическим профилированным листом С-10 толщиной 0,5 мм.'
                ];
                
                foreach ($default_container_specs as $spec) :
            ?>
                <li class="containers-specs__item">
                    <i class="fa-solid fa-check containers-specs__icon" aria-hidden="true"></i>
                <?php echo esc_html($spec); ?>
                </li>
            <?php 
                endforeach;
            endif;
            ?>
            </ul>
            <p class="containers-certification">
            <?php echo wp_kses_post(get_field('production_containers_certification') ?: 'Контейнер имеет вторую степень огнестойкости и выпускается по ТУ 25.11.23-001-99672874-2017. Скачать сертификат соответствия требованиям пожарной безопасности.'); ?>
            </p>
            <div class="certificate-link">
                <i class="fa-solid fa-certificate certificate-link__icon" aria-hidden="true"></i>
            <?php 
            $certificate_url = get_field('production_containers_certificate_url');
            $certificate_text = get_field('production_containers_certificate_text') ?: 'Сертификат соответствия на блок-контейнеры "DSA Generators">>>';
            if ($certificate_url) :
            ?>
            <a href="<?php echo esc_url($certificate_url); ?>" class="certificate-link__text"><?php echo esc_html($certificate_text); ?></a>
            <?php else : ?>
            <a href="#" class="certificate-link__text"><?php echo esc_html($certificate_text); ?></a>
            <?php endif; ?>
        </div>
        </div>
    </section>

<?php get_footer(); ?>