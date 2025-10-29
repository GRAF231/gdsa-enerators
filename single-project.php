<?php
/**
 * Single Project Template
 * Шаблон страницы отдельного проекта
 */
get_header();

// Хлебные крошки
dsa_breadcrumbs();

while (have_posts()) : the_post();
    // Получаем ACF поля
    $power = get_field('power');
    $power_range = get_field('power_range');
    $industry = get_field('industry');
    $city = get_field('city');
    $year = get_field('year');
    $client = get_field('client');
    $description_title = get_field('description_title') ?: 'О проекте';
    $description_intro = get_field('description_intro');
    $description_tasks = get_field('description_tasks');
    $description_solution = get_field('description_solution');
    $description_additional = get_field('description_additional');
    $gallery_title = get_field('gallery_title') ?: 'Фотогалерея проекта';
    $gallery = get_field('gallery');
    $characteristics = get_field('characteristics');
    $stages_title = get_field('stages_title') ?: 'Этапы реализации проекта';
    $stages = get_field('stages');
    $results_title = get_field('results_title') ?: 'Результаты проекта';
    $results_intro = get_field('results_intro');
    $results_achievements = get_field('results_achievements');
    $results_advantages = get_field('results_advantages');
    $results_additional = get_field('results_additional');
    $technical_title = get_field('technical_title') ?: 'Технические детали';
    $technical_equipment = get_field('technical_equipment');
    $technical_automation = get_field('technical_automation');
    $technical_installation = get_field('technical_installation');
    $technical_operational = get_field('technical_operational'); 
    $documents_title = get_field('documents_title') ?: 'Документы проекта';
    $documents = get_field('documents');
    $additional_info_title = get_field('additional_info_title') ?: 'Дополнительная информация';
    $additional_info = get_field('additional_info');
    $service_info_title = get_field('service_info_title') ?: 'Сервисное обслуживание';
    $meta_title = get_field('meta_title') ?: 'Информация о проекте';
    $characteristics_title = get_field('characteristics_title') ?: 'Характеристики';
    $contact_title = get_field('contact_title') ?: 'Контакты по проекту';
    $cta_title = get_field('cta_title') ?: 'Нужен похожий проект?';
    $cta_text = get_field('cta_text') ?: 'Свяжитесь с нами для обсуждения вашего проекта';
    $related_title = get_field('related_title') ?: 'Похожие проекты';
    $contact_name = get_field('contact_name');
    $contact_phone = get_field('contact_phone');
    $show_related = get_field('show_related') !== false ? get_field('show_related') : true;
    $related_count = get_field('related_count') ?: 3;
    
    // Маппинг значений для отображения
    $industry_labels = [
        'banks' => 'Банки',
        'business_centers' => 'Бизнес-центры',
        'commercial' => 'Коммерция',
        'construction' => 'Строительство',
        'data_centers' => 'Дата-центры',
        'energy' => 'Энергетика',
        'government' => 'Государственные и силовые структуры',
        'healthcare' => 'Здравоохранение',
        'hospitality' => 'Гостиничный бизнес',
        'hotels' => 'Гостиницы',
        'housing_utilities' => 'ЖКХ и социальная сфера',
        'industrial' => 'Промышленность',
        'mining' => 'Горнодобывающая',
        'oil_gas' => 'Нефтегазовая отрасль',
        'private_sector' => 'Частный сектор',
        'production' => 'Производство',
        'residential' => 'Жилые объекты',
        'science_education' => 'Наука и образование',
        'agriculture' => 'Сельское хозяйство',
        'trade_services' => 'Торговля и услуги',
        'transport' => 'Транспорт',
    ];
    
    $city_labels = [
        'abinsk' => 'Абинск',
        'abkhazia' => 'Абхазия',
        'africa' => 'Африка',
        'archangelsk' => 'Архангельск',
        'achinsk' => 'Ачинск',
        'baikonur' => 'Байконур',
        'bangladesh' => 'Бангладеш',
        'belgorod' => 'Белгородская область',
        'belarus' => 'Республика Беларусь',
        'bryansk' => 'Брянская область',
        'vladimir' => 'Владимирская область',
        'vladivostok' => 'Владивосток',
        'voronezh' => 'Воронеж',
        'vyborg' => 'Выборг',
        'vsevolozhsk' => 'Всеволожск',
        'gelendzhik' => 'Геленджик',
        'gorny_altai' => 'Горно-Алтайск',
        'grozny' => 'Грозный', 
        'gydan' => 'Гыданский полуостров',
        'egypt' => 'Египет',
        'ekaterinburg' => 'Екатеринбург',
        'essentuki' => 'Ессентуки',
        'ivanovo' => 'Ивановская область',
        'izhevsk' => 'Ижевск',
        'irkutsk' => 'Иркутск',
        'irkutsk_region' => 'Иркутская область',
        'kazakhstan' => 'Казахстан',
        'kaluga' => 'Калуга',
        'kaliningrad' => 'Калининград',
        'kamchatka' => 'Камчатский край',
        'karelia' => 'Карелия',
        'kemerovo' => 'Кемеровская область',
        'kirov' => 'Кировская область',
        'krasnodar' => 'Краснодарский край',
        'krasnoyarsk' => 'Красноярский край',
        'crimea' => 'Крым',
        'kursk' => 'Курск',
        'lensk' => 'Ленск',
        'leningrad_region' => 'Ленобласть',
        'lobnya' => 'Лобня',
        'magadan' => 'Магаданская область',
        'mezen' => 'Мезень (Архангельская область)',
        'moscow' => 'Москва',
        'moscow_region' => 'Московская область',
        'murmansk' => 'Мурманск',
        'nalchik' => 'Нальчик',
        'novaya_zemlya' => 'Новая Земля',
        'novorossiysk' => 'Новороссийск',
        'nnovgorod' => 'Нижний Новгород',
        'novy_urengoy' => 'Новый Уренгой',
        'norilsk' => 'Норильск',
        'penza' => 'Пензенская область',
        'primorsky' => 'Приморский край',
        'rostov' => 'Ростов-на-Дону',
        'rostov_region' => 'Ростовская область',
        'samara' => 'Самара',
        'sakhalin' => 'Сахалин',
        'svobodny' => 'Свободный',
        'sverdlovsk' => 'Свердловская область',
        'spb' => 'Санкт-Петербург',
        'syria' => 'Сирия',
        'sochi' => 'Сочи',
        'tazovsky' => 'Тазовский (Ямало-Ненецкий АО)',
        'tver' => 'Тверь',
        'tver_region' => 'Тверская обасть',
        'tomsk' => 'Томск',
        'turkey' => 'Турция',
        'tyumen' => 'Тюмень',
        'ulan_ude' => 'Улан-Удэ',
        'ussuriysk' => 'Уссурийск',
        'ust_ilimsk' => 'Усть-Илимск',
        'ust_kut' => 'Усть-Кут',
        'ust_luga' => 'Усть-Луга',
        'ufa' => 'Уфа',
        'khabarovsk' => 'Хабаровск',
        'khmao_yugra' => 'ХМАО – Югра',
        'cfd' => 'ЦФО (Центральный федеральный округ)',
        'chechnya' => 'Чеченская Республика',
        'chelyabinsk' => 'Челябинская область',
        'chukotka' => 'Чукотский АО',
        'shlisselburg' => 'Шлиссельбург',
        'evenkia' => 'Эвенкия (Таймыр)',
        'yakutia' => 'Якутия',
        'yamal' => 'Ямало-Ненецкий АО',
    ];
    
    $industry_display = isset($industry_labels[$industry]) ? $industry_labels[$industry] : $industry;
    $city_display = isset($city_labels[$city]) ? $city_labels[$city] : ($city ?: '');
    
    // Получаем URL страницы выполненных проектов
    $projects_page = get_pages([
        'meta_key' => '_wp_page_template',
        'meta_value' => 'template-projects.php'
    ]);
    $projects_page_url = !empty($projects_page) ? get_permalink($projects_page[0]->ID) : get_post_type_archive_link('project');
?>

<main class="">
    <!-- Заголовок страницы -->
    <header class="page-header">
        <div class="container">
            <h1 class="page-header__title"><?php the_title(); ?></h1>
        </div>
    </header>

    <!-- Контент проекта -->
    <section class="project-single">
        <div class="container">
            <div class="project-single__wrapper">
                
                <!-- Основная информация -->
                <div class="project-single__main">
                    
                    <!-- Главное изображение проекта -->
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="project-single__image">
                            <?php the_post_thumbnail('large', [
                                'alt' => get_the_title(),
                                'class' => 'project-single__image-img'
                            ]); ?>
                            <?php if ($power) : ?>
                                <div class="project-single__power-badge">
                                    <?php echo esc_html(number_format($power, 0, '.', ' ') . ' кВт'); ?>
                    </div>
                <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Описание проекта -->
                    <?php if ($description_intro || $description_tasks || $description_solution || $description_additional || get_the_content()) : ?>
                        <div class="project-single__description">
                            <h2 class="project-single__section-title"><?php echo esc_html($description_title); ?></h2>
                            <div class="project-single__text">
                                <?php if ($description_intro) : ?>
                                    <p><?php echo wp_kses_post($description_intro); ?></p>
                                    <?php if ($power || $client || $year) : ?>
                                    <?php endif; ?>
                                <?php elseif (get_the_content()) : ?>
                                    <?php the_content(); ?>
                                <?php else : ?>
                                    <p>Компания DSA Generators успешно реализовала комплексный проект по обеспечению надежного энергоснабжения объекта.</p>
                                <?php endif; ?>
                                
                                <?php if ($description_tasks) : ?>
                                    <h3>Задачи проекта:</h3>
                                    <?php echo wp_kses_post($description_tasks); ?>
                                <?php endif; ?>
                                
                                <?php if ($description_solution) : ?>
                                    <h3>Решение:</h3>
                                    <?php echo wp_kses_post($description_solution); ?>
                                <?php endif; ?>
                                
                                <?php if ($description_additional) : ?>
                                    <?php echo wp_kses_post($description_additional); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Галерея изображений -->
                    <?php if ($gallery && is_array($gallery) && count($gallery) > 0) : ?>
                        <div class="project-single__gallery">
                            <h2 class="project-single__section-title"><?php echo esc_html($gallery_title); ?></h2>
                            <div class="project-single__gallery-grid">
                                <?php foreach ($gallery as $image) : 
                                    $image_url = $image['sizes']['large'] ?? $image['url'];
                                    $image_alt = $image['alt'] ?? get_the_title();
                                    $image_caption = $image['caption'] ?? '';
                                ?>
                                    <div class="project-single__gallery-item">
                                        <a href="<?php echo esc_url($image['url']); ?>" 
                                           class="project-single__gallery-link"
                                           data-lightbox="project-gallery"
                                           <?php if ($image_caption) : ?>
                                               data-title="<?php echo esc_attr($image_caption); ?>"
                                           <?php endif; ?>>
                                            <img src="<?php echo esc_url($image_url); ?>" 
                                                 alt="<?php echo esc_attr($image_alt); ?>" 
                                                 loading="lazy"
                                                 class="project-single__gallery-img">
                                        </a>
                                        <?php if ($image_caption) : ?>
                                            <p class="project-single__gallery-caption"><?php echo esc_html($image_caption); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php elseif (has_post_thumbnail()) : ?>
                        <!-- Показываем мини-галерею из главного изображения, если нет отдельной галереи -->
                        <div class="project-single__gallery">
                            <h2 class="project-single__section-title"><?php echo esc_html($gallery_title); ?></h2>
                            <div class="project-single__gallery-grid">
                                <div class="project-single__gallery-item">
                                    <a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" 
                                       class="project-single__gallery-link"
                                       data-lightbox="project-gallery"
                                       data-title="<?php echo esc_attr(get_the_title()); ?>">
                                        <?php the_post_thumbnail('medium_large', [
                                            'alt' => get_the_title(),
                                            'class' => 'project-single__gallery-img'
                                        ]); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Этапы реализации -->
                    <div class="project-single__stages">
                        <h2 class="project-single__section-title"><?php echo esc_html($stages_title); ?></h2>
                        <div class="project-single__stages-list">
                            <?php if ($stages && is_array($stages) && count($stages) > 0) : ?>
                                <?php foreach ($stages as $index => $stage) : 
                                    $stage_title = $stage['title'] ?? '';
                                    $stage_description = $stage['description'] ?? '';
                                    $stage_image = $stage['image'] ?? null;
                                ?>
                                    <?php if ($stage_title) : ?>
                                        <div class="project-single__stage">
                                            <div class="project-single__stage-number"><?php echo esc_html($index + 1); ?></div>
                                            <div class="project-single__stage-content">
                                                <h3 class="project-single__stage-title"><?php echo esc_html($stage_title); ?></h3>
                                                <?php if ($stage_description) : ?>
                                                    <div class="project-single__stage-text">
                                                        <?php echo wp_kses_post(wpautop($stage_description)); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($stage_image && isset($stage_image['url'])) : ?>
                                                <div class="project-single__stage-image">
                                                    <img src="<?php echo esc_url($stage_image['sizes']['medium'] ?? $stage_image['url']); ?>" 
                                                         alt="<?php echo esc_attr($stage_image['alt'] ?? $stage_title); ?>" 
                                                         loading="lazy">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Дефолтные этапы, если не заполнены в ACF -->
                                <div class="project-single__stage">
                                    <div class="project-single__stage-number">1</div>
                                    <div class="project-single__stage-content">
                                        <h3 class="project-single__stage-title">Проектирование и разработка технического решения</h3>
                                        <div class="project-single__stage-text">
                                            <p>На первом этапе наши инженеры провели детальный анализ требований заказчика и разработали оптимальное техническое решение. Были выполнены все необходимые расчеты, согласованы технические параметры и подготовлена проектная документация.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="project-single__stage">
                                    <div class="project-single__stage-number">2</div>
                                    <div class="project-single__stage-content">
                                        <h3 class="project-single__stage-title">Изготовление и производство оборудования</h3>
                                        <div class="project-single__stage-text">
                                            <p>Оборудование было изготовлено на нашем производстве с использованием современных технологий и материалов. На всех этапах производства осуществлялся строгий контроль качества. Готовое оборудование прошло комплексное тестирование на соответствие всем техническим параметрам.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="project-single__stage">
                                    <div class="project-single__stage-number">3</div>
                                    <div class="project-single__stage-content">
                                        <h3 class="project-single__stage-title">Поставка и монтаж</h3>
                                        <div class="project-single__stage-text">
                                            <p>Доставка оборудования была выполнена в установленные сроки специальным транспортом. Специализированная бригада выполнила монтаж и подключение всех систем в соответствии с проектной документацией и требованиями безопасности.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="project-single__stage">
                                    <div class="project-single__stage-number">4</div>
                                    <div class="project-single__stage-content">
                                        <h3 class="project-single__stage-title">Пуско-наладка и ввод в эксплуатацию</h3>
                                        <div class="project-single__stage-text">
                                            <p>На завершающем этапе была выполнена пуско-наладочная работа всех систем, проведено комплексное тестирование в различных режимах работы. Оборудование успешно введено в эксплуатацию и работает в штатном режиме. Заказчику была передана вся необходимая документация и проведен инструктаж по эксплуатации.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Технические детали -->
                    <?php if ($technical_equipment || $technical_automation || $technical_installation || $technical_operational) : ?>
                        <div class="project-single__technical">
                            <h2 class="project-single__section-title"><?php echo esc_html($technical_title); ?></h2>
                            <div class="project-single__text">
                                <?php if ($technical_equipment) : ?>
                                    <h3>Комплектация оборудования</h3>
                                    <?php echo wp_kses_post($technical_equipment); ?>
                                <?php endif; ?>
                                
                                <?php if ($technical_automation) : ?>
                                    <h3>Система автоматизации</h3>
                                    <?php echo wp_kses_post($technical_automation); ?>
                                <?php endif; ?>
                                
                                <?php if ($technical_installation) : ?>
                                    <h3>Требования к установке</h3>
                                    <?php echo wp_kses_post($technical_installation); ?>
                                <?php endif; ?>
                                
                                <?php if ($technical_operational) : ?>
                                    <h3>Эксплуатационные характеристики</h3>
                                    <?php echo wp_kses_post($technical_operational); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Результаты проекта -->
                    <?php if ($results_intro || $results_achievements || $results_advantages || $results_additional) : ?>
                        <div class="project-single__results">
                            <h2 class="project-single__section-title"><?php echo esc_html($results_title); ?></h2>
                            <div class="project-single__text">
                                <?php if ($results_intro) : ?>
                                    <p><?php echo wp_kses_post($results_intro); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($results_achievements) : ?>
                                    <h3>Основные достижения:</h3>
                                    <?php echo wp_kses_post($results_achievements); ?>
                                <?php endif; ?>
                                
                                <?php if ($results_advantages) : ?>
                                    <h3>Преимущества реализованного решения:</h3>
                                    <?php echo wp_kses_post($results_advantages); ?>
                                <?php endif; ?>
                                
                                <?php if ($results_additional) : ?>
                                    <?php echo wp_kses_post($results_additional); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Дополнительная информация -->
                    <?php if ($additional_info) : ?>
                        <div class="project-single__additional">
                            <h2 class="project-single__section-title"><?php echo esc_html($additional_info_title); ?></h2>
                            <div class="project-single__text">
                                <?php echo wp_kses_post($additional_info); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Информация о сервисе (показываем всегда) -->
                    <div class="project-single__service-info">
                        <h2 class="project-single__section-title"><?php echo esc_html($service_info_title); ?></h2>
                        <div class="project-single__text">
                            <p>Компания DSA Generators предоставляет полный спектр сервисных услуг для установленного оборудования:</p>
                            
                            <ul>
                                <li><strong>Плановое техническое обслуживание</strong> - регулярные осмотры и профилактические работы для обеспечения бесперебойной работы оборудования</li>
                                <li><strong>Ремонт и замена комплектующих</strong> - оперативное устранение неисправностей с использованием оригинальных запасных частей</li>
                                <li><strong>Мониторинг и диагностика</strong> - удаленный контроль параметров работы и предупреждение возможных сбоев</li>
                                <li><strong>Консультационная поддержка</strong> - помощь специалистов по всем вопросам эксплуатации и оптимизации работы систем</li>
                                <li><strong>Обучение персонала</strong> - проведение инструктажей и тренингов для операторов оборудования</li>
                            </ul>
                            
                            <p>Наши специалисты готовы быстро реагировать на любые запросы и обеспечивать высокий уровень сервисной поддержки на протяжении всего жизненного цикла оборудования.</p>
                        </div>
                    </div>

                    <!-- Документы проекта -->
                    <?php if ($documents && is_array($documents) && count($documents) > 0) : ?>
                        <div class="project-single__documents">
                            <h2 class="project-single__section-title"><?php echo esc_html($documents_title); ?></h2>
                            <div class="project-single__documents-list">
                                <?php foreach ($documents as $document) : 
                                    $doc_name = $document['name'] ?? '';
                                    $doc_file = $document['file'] ?? null;
                                    $doc_icon = $document['icon'] ?? 'fa-solid fa-file-pdf';
                                    if ($doc_file && isset($doc_file['url'])) :
                                ?>
                                    <a href="<?php echo esc_url($doc_file['url']); ?>" 
                                       class="project-single__document"
                                       target="_blank"
                                       rel="noopener">
                                        <i class="<?php echo esc_attr($doc_icon); ?>" aria-hidden="true"></i>
                                        <span class="project-single__document-name"><?php echo esc_html($doc_name); ?></span>
                                        <span class="project-single__document-size">
                                            <?php if (isset($doc_file['filesize'])) : ?>
                                                (<?php echo esc_html(size_format($doc_file['filesize'])); ?>)
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                <?php endif; endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Боковая панель с информацией -->
                <aside class="project-single__sidebar">
                    
                    <!-- Метаинформация проекта -->
                    <div class="project-single__meta">
                        <h3 class="project-single__meta-title"><?php echo esc_html($meta_title); ?></h3>
                        <div class="project-single__meta-list">
                            <?php if ($power) : ?>
                                <div class="project-single__meta-item">
                                    <i class="fa-solid fa-bolt project-single__meta-icon" aria-hidden="true"></i>
                                    <div class="project-single__meta-content">
                                        <span class="project-single__meta-label">Мощность</span>
                                        <span class="project-single__meta-value"><?php echo esc_html(number_format($power, 0, '.', ' ') . ' кВт'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($industry_display) : ?>
                                <div class="project-single__meta-item">
                                    <i class="fa-solid fa-industry project-single__meta-icon" aria-hidden="true"></i>
                                    <div class="project-single__meta-content">
                                        <span class="project-single__meta-label">Отрасль</span>
                                        <span class="project-single__meta-value"><?php echo esc_html($industry_display); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($city_display) : ?>
                                <div class="project-single__meta-item">
                                    <i class="fa-solid fa-location-dot project-single__meta-icon" aria-hidden="true"></i>
                                    <div class="project-single__meta-content">
                                        <span class="project-single__meta-label">Город/Регион</span>
                                        <span class="project-single__meta-value"><?php echo esc_html($city_display); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($year) : ?>
                                <div class="project-single__meta-item">
                                    <i class="fa-solid fa-calendar project-single__meta-icon" aria-hidden="true"></i>
                                    <div class="project-single__meta-content">
                                        <span class="project-single__meta-label">Год реализации</span>
                                        <span class="project-single__meta-value"><?php echo esc_html($year); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($client) : ?>
                        <div class="project-single__meta-item">
                                    <i class="fa-solid fa-building project-single__meta-icon" aria-hidden="true"></i>
                                    <div class="project-single__meta-content">
                                        <span class="project-single__meta-label">Клиент</span>
                                        <span class="project-single__meta-value"><?php echo esc_html($client); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Характеристики проекта -->
                    <div class="project-single__characteristics">
                        <h3 class="project-single__characteristics-title"><?php echo esc_html($characteristics_title); ?></h3>
                        <div class="project-single__characteristics-list">
                            <?php if ($characteristics && is_array($characteristics) && count($characteristics) > 0) : ?>
                                <?php foreach ($characteristics as $char) : 
                                    $char_label = $char['label'] ?? '';
                                    $char_value = $char['value'] ?? '';
                                    if ($char_label && $char_value) :
                                ?>
                                    <div class="project-single__characteristic">
                                        <span class="project-single__characteristic-label"><?php echo esc_html($char_label); ?>:</span>
                                        <span class="project-single__characteristic-value"><?php echo esc_html($char_value); ?></span>
                                    </div>
                                <?php endif; endforeach; ?>
                            <?php else : ?>
                                <!-- Дефолтные характеристики, если не заполнены в ACF -->
                                <?php if ($power) : ?>
                                    <div class="project-single__characteristic">
                                        <span class="project-single__characteristic-label">Номинальная мощность:</span>
                                        <span class="project-single__characteristic-value"><?php echo esc_html(number_format($power, 0, '.', ' ') . ' кВт'); ?></span>
                                    </div>
                                <?php endif; ?>
                                <div class="project-single__characteristic">
                                    <span class="project-single__characteristic-label">Тип установки:</span>
                                    <span class="project-single__characteristic-value">Дизельная электростанция</span>
                                </div>
                                <div class="project-single__characteristic">
                                    <span class="project-single__characteristic-label">Режим работы:</span>
                                    <span class="project-single__characteristic-value">Резервный / Основной</span>
                                </div>
                                <div class="project-single__characteristic">
                                    <span class="project-single__characteristic-label">Уровень автоматизации:</span>
                                    <span class="project-single__characteristic-value">Полная автоматизация</span>
                                </div>
                                <div class="project-single__characteristic">
                                    <span class="project-single__characteristic-label">Система управления:</span>
                                    <span class="project-single__characteristic-value">Модернизированная панель управления</span>
                        </div>
                    <?php endif; ?>
                        </div>
                    </div>

                    <!-- Контактная информация -->
                    <div class="project-single__contact">
                        <h3 class="project-single__contact-title"><?php echo esc_html($contact_title); ?></h3>
                        <div class="project-single__contact-info">
                            <?php if ($contact_name) : ?>
                                <div class="project-single__contact-item">
                                    <i class="fa-solid fa-user project-single__contact-icon" aria-hidden="true"></i>
                                    <span><?php echo esc_html($contact_name); ?></span>
                                </div>
                            <?php else : ?>
                                <div class="project-single__contact-item">
                                    <i class="fa-solid fa-user project-single__contact-icon" aria-hidden="true"></i>
                                    <span>Менеджер проекта</span>
                                </div>
                            <?php endif; ?>
                            <?php if ($contact_phone) : 
                                $phone_clean = preg_replace('/[^0-9+]/', '', $contact_phone);
                            ?>
                                <div class="project-single__contact-item">
                                    <i class="fa-solid fa-phone project-single__contact-icon" aria-hidden="true"></i>
                                    <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="project-single__contact-link">
                                        <?php echo esc_html($contact_phone); ?>
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="project-single__contact-item">
                                    <i class="fa-solid fa-phone project-single__contact-icon" aria-hidden="true"></i>
                                    <a href="tel:+74959666111" class="project-single__contact-link">
                                        +7 (495) 966-61-11
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="project-single__contact-item">
                                <i class="fa-solid fa-envelope project-single__contact-icon" aria-hidden="true"></i>
                                <a href="mailto:info@dsa-generators.ru" class="project-single__contact-link">
                                    info@dsa-generators.ru
                                </a>
                            </div>
                        </div>
                </div>

                    <!-- CTA блок -->
                    <div class="project-single__cta">
                        <h3 class="project-single__cta-title"><?php echo esc_html($cta_title); ?></h3>
                        <p class="project-single__cta-text"><?php echo esc_html($cta_text); ?></p>
                        <a href="<?php echo esc_url(home_url('/contacts')); ?>" class="project-single__cta-btn">
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                            <span>Связаться с нами</span>
                        </a>
                </div>

                </aside>

            </div>
        </div>
    </section>

                <!-- Навигация между проектами -->
    <section class="project-single__navigation-section">
        <div class="container">
                <div class="project-single__navigation">
                    <div class="project-single__nav-prev">
                        <?php 
                        $prev_post = get_previous_post();
                    if ($prev_post) : ?>
                        <a href="<?php echo get_permalink($prev_post); ?>" class="project-single__nav-link project-single__nav-link_prev">
                                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                            <div class="project-single__nav-content">
                                <span class="project-single__nav-label">Предыдущий проект</span>
                                <span class="project-single__nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                            </div>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="project-single__nav-back">
                    <a href="<?php echo esc_url($projects_page_url); ?>" class="project-single__nav-link project-single__nav-link_back">
                            <i class="fa-solid fa-th" aria-hidden="true"></i>
                            <span>Все проекты</span>
                        </a>
                    </div>
                    
                    <div class="project-single__nav-next">
                        <?php 
                        $next_post = get_next_post();
                    if ($next_post) : ?>
                        <a href="<?php echo get_permalink($next_post); ?>" class="project-single__nav-link project-single__nav-link_next">
                            <div class="project-single__nav-content">
                                <span class="project-single__nav-label">Следующий проект</span>
                                <span class="project-single__nav-title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                            </div>
                                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Похожие проекты -->
    <?php if ($show_related) : 
        $related_query = dsa_get_related_projects(get_the_ID(), $related_count);
        if ($related_query->have_posts()) :
    ?>
        <section class="project-single__related">
            <div class="container">
                <h2 class="project-single__related-title"><?php echo esc_html($related_title); ?></h2>
                <div class="project-single__related-grid">
                    <?php while ($related_query->have_posts()) : $related_query->the_post();
                        $related_power = get_field('power');
                        $related_image_url = '';
                        if (has_post_thumbnail()) {
                            $related_image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                        } else {
                            $related_image_url = 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center';
                        }
                    ?>
                        <article class="project-single__related-card">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="project-single__related-link">
                                <div class="project-single__related-image">
                                    <img src="<?php echo esc_url($related_image_url); ?>" 
                                         alt="<?php echo esc_attr(get_the_title()); ?>" 
                                         loading="lazy">
                                    <?php if ($related_power) : ?>
                                        <div class="project-single__related-power">
                                            <?php echo esc_html(number_format($related_power, 0, '.', ' ') . ' кВт'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="project-single__related-content">
                                    <h3 class="project-single__related-title"><?php echo esc_html(get_the_title()); ?></h3>
                                    <?php if (get_field('client')) : ?>
                                        <p class="project-single__related-client"><?php echo esc_html(get_field('client')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; 
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; endif; ?>

</main>

<?php endwhile; ?>

<?php get_footer(); ?>
