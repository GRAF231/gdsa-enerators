<?php
/**
 * Template Name: Контакты
 * 
 * Шаблон страницы контактов с ACF полями
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

<!-- Заголовок страницы -->
<div class="page-header">
    <div class="container">
        <h1 class="page-header__title"><?php echo esc_html(get_field('contacts_page_title') ?: 'Контакты ООО «DSA Generators» в Москве'); ?></h1>
    </div>
</div>

<!-- Основной контент -->
<main class="main-content" role="main">
    <div class="container">
        <!-- Основные контакты -->
        <section class="contacts-main">
            <div class="contacts-main__grid">
                <!-- Левая колонка - Контактная информация -->
                <div class="contacts-main__info">
                    <div class="contacts-info">
                        <h2 class="contacts-info__title"><?php echo esc_html(get_field('contacts_info_title') ?: 'Контактная информация'); ?></h2>
                        
                        <?php 
                        $contacts_info_items = get_field('contacts_info_items');
                        if ($contacts_info_items) :
                            foreach ($contacts_info_items as $item) :
                        ?>
                        <div class="contacts-info__item">
                            <div class="contacts-info__icon">
                                <i class="<?php echo esc_attr($item['contact_info_icon'] ?: 'fa-solid fa-info-circle'); ?>" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-info__content">
                                <h3 class="contacts-info__label"><?php echo esc_html($item['contact_info_label']); ?></h3>
                                
                                <?php if ($item['contact_info_type'] === 'phone') : ?>
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $item['contact_info_value'])); ?>" class="contacts-info__value contacts-info__value_phone">
                                        <?php echo esc_html($item['contact_info_value']); ?>
                                    </a>
                                <?php elseif ($item['contact_info_type'] === 'email') : ?>
                                    <a href="mailto:<?php echo esc_attr($item['contact_info_value']); ?>" class="contacts-info__value contacts-info__value_email">
                                        <?php echo esc_html($item['contact_info_value']); ?>
                                    </a>
                                <?php elseif ($item['contact_info_type'] === 'details') : ?>
                                    <div class="contacts-info__details">
                                        <?php echo wp_kses_post($item['contact_info_value']); ?>
                                    </div>
                                <?php elseif ($item['contact_info_type'] === 'links') : ?>
                                    <div class="contacts-info__links">
                                        <?php echo wp_kses_post($item['contact_info_value']); ?>
                                    </div>
                                <?php else : ?>
                                    <p class="contacts-info__value"><?php echo esc_html($item['contact_info_value']); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($item['contact_info_note']) : ?>
                                    <p class="contacts-info__note"><?php echo esc_html($item['contact_info_note']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        else :
                            // Дефолтные элементы контактной информации, если ACF поля не заполнены
                            $default_contacts = [
                                [
                                    'icon' => 'fa-solid fa-phone',
                                    'label' => 'Бесплатный телефон',
                                    'value' => '8 (800) 551-83-94',
                                    'note' => '(бесплатный звонок по России)',
                                    'type' => 'phone'
                                ],
                                [
                                    'icon' => 'fa-solid fa-clock',
                                    'label' => 'График работы',
                                    'value' => 'ежедневно, 8:00-20:00',
                                    'note' => '',
                                    'type' => 'text'
                                ],
                                [
                                    'icon' => 'fa-solid fa-building',
                                    'label' => 'Реквизиты компании',
                                    'value' => '<p><strong>ИНН:</strong> 7840490040</p><p><strong>ОГРН:</strong> 1137847211886</p><p><strong>КПП:</strong> 784201001</p>',
                                    'note' => '',
                                    'type' => 'details'
                                ],
                                [
                                    'icon' => 'fa-solid fa-download',
                                    'label' => 'Документы',
                                    'value' => '<a href="#" class="contacts-info__link">Скачать реквизиты (обновлены 25.06.2025)</a><a href="#" class="contacts-info__link">Лицензии и дилерские сертификаты</a>',
                                    'note' => '',
                                    'type' => 'links'
                                ],
                                [
                                    'icon' => 'fa-solid fa-envelope',
                                    'label' => 'Email',
                                    'value' => 'order@dsa-generators.ru',
                                    'note' => '',
                                    'type' => 'email'
                                ]
                            ];
                            
                            foreach ($default_contacts as $contact) :
                        ?>
                        <div class="contacts-info__item">
                            <div class="contacts-info__icon">
                                <i class="<?php echo esc_attr($contact['icon']); ?>" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-info__content">
                                <h3 class="contacts-info__label"><?php echo esc_html($contact['label']); ?></h3>
                                
                                <?php if ($contact['type'] === 'phone') : ?>
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $contact['value'])); ?>" class="contacts-info__value contacts-info__value_phone">
                                        <?php echo esc_html($contact['value']); ?>
                                    </a>
                                <?php elseif ($contact['type'] === 'email') : ?>
                                    <a href="mailto:<?php echo esc_attr($contact['value']); ?>" class="contacts-info__value contacts-info__value_email">
                                        <?php echo esc_html($contact['value']); ?>
                                    </a>
                                <?php elseif ($contact['type'] === 'details') : ?>
                                    <div class="contacts-info__details">
                                        <?php echo wp_kses_post($contact['value']); ?>
                                    </div>
                                <?php elseif ($contact['type'] === 'links') : ?>
                                    <div class="contacts-info__links">
                                        <?php echo wp_kses_post($contact['value']); ?>
                                    </div>
                                <?php else : ?>
                                    <p class="contacts-info__value"><?php echo esc_html($contact['value']); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($contact['note']) : ?>
                                    <p class="contacts-info__note"><?php echo esc_html($contact['note']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php 
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Правая колонка - Офис продаж и карта -->
                <div class="contacts-main__office">
                    <div class="contacts-office">
                        <h2 class="contacts-office__title"><?php echo esc_html(get_field('contacts_office_title') ?: 'Офис продаж в Москве'); ?></h2>
                        
                        <div class="contacts-office__address">
                            <div class="contacts-office__icon">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-office__content">
                                <p class="contacts-office__street"><?php echo esc_html(get_field('contacts_office_address') ?: 'Щербаковская ул., 3'); ?></p>
                                <p class="contacts-office__metro"><?php echo esc_html(get_field('contacts_office_metro') ?: 'м. Семёновская'); ?></p>
                            </div>
                        </div>

                        <div class="contacts-office__phone">
                            <div class="contacts-office__icon">
                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-office__content">
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', get_field('contacts_office_phone') ?: '+74959666111')); ?>" class="contacts-office__phone-link">
                                    <?php echo esc_html(get_field('contacts_office_phone') ?: '+7 495 966-61-11'); ?>
                                </a>
                            </div>
                        </div>

                        <!-- Карта -->
                        <div class="contacts-office__map">
                            <div class="contacts-map">
                                <div class="contacts-map__placeholder">
                                    <div class="contacts-map__icon">
                                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                                    </div>
                                    <h3 class="contacts-map__title"><?php echo esc_html(get_field('contacts_map_title') ?: 'Интерактивная карта'); ?></h3>
                                    <p class="contacts-map__description"><?php echo esc_html(get_field('contacts_map_description') ?: 'Щербаковская ул., 3, Москва'); ?></p>
                                    <p class="contacts-map__metro"><?php echo esc_html(get_field('contacts_office_metro') ?: 'м. Семёновская'); ?></p>
                                    <button class="contacts-map__button" type="button">
                                        <i class="fa-solid fa-external-link-alt" aria-hidden="true"></i>
                                        <span><?php echo esc_html(get_field('contacts_map_button_text') ?: 'Открыть в Яндекс Картах'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Филиалы в регионах -->
        <section class="contacts-branches">
            <div class="contacts-branches__header">
                <h2 class="contacts-branches__title"><?php echo esc_html(get_field('contacts_branches_title') ?: 'Филиалы в регионах'); ?></h2>
                <p class="contacts-branches__subtitle"><?php echo esc_html(get_field('contacts_branches_subtitle') ?: 'Наши представительства по всей России'); ?></p>
            </div>

            <div class="contacts-branches__grid">
                <?php 
                $branches = get_field('contacts_branches_list');
                if ($branches) :
                    $delay = 100;
                    foreach ($branches as $branch) :
                ?>
                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <h3 class="contacts-branch__city"><?php echo esc_html($branch['branch_city']); ?></h3>
                    <p class="contacts-branch__address"><?php echo esc_html($branch['branch_address']); ?></p>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $branch['branch_phone'])); ?>" class="contacts-branch__phone">
                        <?php echo esc_html($branch['branch_phone']); ?>
                    </a>
                </div>
                <?php 
                    $delay += 100;
                    endforeach;
                else :
                    // Дефолтные филиалы, если ACF поля не заполнены
                    $default_branches = [
                        ['city' => 'Санкт-Петербург', 'address' => 'Митрофаньевское шоссе, 8А, Лит. Б', 'phone' => '+7 (812) 207-52-94'],
                        ['city' => 'Москва', 'address' => 'Щербаковская ул., 3', 'phone' => '+7 495 966-61-11'],
                        ['city' => 'Волгоград', 'address' => 'Мира ул., д. 19', 'phone' => '+7 844 268-48-25'],
                        ['city' => 'Воронеж', 'address' => 'Московский пр., д. 4', 'phone' => '+7 473 201-60-99'],
                        ['city' => 'Екатеринбург', 'address' => 'Антона Валека ул., д. 13', 'phone' => '+7 343 302-00-42'],
                        ['city' => 'Казань', 'address' => 'Проточная ул., д. 8', 'phone' => '+7 843 207-28-35'],
                        ['city' => 'Краснодар', 'address' => 'Карасунская ул., д. 60', 'phone' => '+7 861 211-72-34'],
                        ['city' => 'Красноярск', 'address' => 'Взлётная ул., д. 57', 'phone' => '+7 391 229-59-39'],
                        ['city' => 'Курск', 'address' => 'ул. Радищева, 5', 'phone' => '+7 471 278-50-30'],
                        ['city' => 'Магадан', 'address' => 'Парковая ул., 13', 'phone' => '+7 964 236-42-65'],
                        ['city' => 'Нижний Новгород', 'address' => 'Максима Горького, д. 260', 'phone' => '+7 831 288-54-50'],
                        ['city' => 'Новосибирск', 'address' => 'Гаранина ул., д. 15', 'phone' => '+7 383 312-14-04'],
                        ['city' => 'Новый Уренгой', 'address' => 'пр. Губкина, 14A', 'phone' => '8 (800) 770-71-57'],
                        ['city' => 'Оренбург', 'address' => 'Шоссейная ул., 24А', 'phone' => '+7 353 248-64-94'],
                        ['city' => 'Пермь', 'address' => 'Аркадия Гайдара ул., д. 8Б', 'phone' => '+7 342 233-83-04'],
                        ['city' => 'Ростов-на-Дону', 'address' => 'Максима Горького ул., д. 295', 'phone' => '+7 863 309-21-51'],
                        ['city' => 'Самара', 'address' => 'Скляренко ул., д. 26', 'phone' => '+7 846 215-16-17'],
                        ['city' => 'Сургут', 'address' => '30 лет Победы ул., 44Б', 'phone' => '+7 346 276-92-88'],
                        ['city' => 'Тюмень', 'address' => 'Пермякова ул., д. 1', 'phone' => '+7 345 256-43-32'],
                        ['city' => 'Улан-Удэ', 'address' => 'ул. Ербанова, 11', 'phone' => '+7 301 248-08-58'],
                        ['city' => 'Уфа', 'address' => 'Кирова ул, д. 107', 'phone' => '+7 347 225-34-97'],
                        ['city' => 'Хабаровск', 'address' => 'ул. Карла Маркса, 96А', 'phone' => '+7 421 252-90-77'],
                        ['city' => 'Челябинск', 'address' => 'Победы пр., д. 160', 'phone' => '+7 351 225-72-62'],
                        ['city' => 'Якутск', 'address' => 'Короленко ул., 25', 'phone' => '+7 411 250-55-80'],
                        ['city' => 'Ярославль', 'address' => 'Некрасова ул., д. 41А', 'phone' => '+7 4852 27-52-34']
                    ];
                    
                    $delay = 100;
                    foreach ($default_branches as $branch) :
                ?>
                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                    <h3 class="contacts-branch__city"><?php echo esc_html($branch['city']); ?></h3>
                    <p class="contacts-branch__address"><?php echo esc_html($branch['address']); ?></p>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $branch['phone'])); ?>" class="contacts-branch__phone">
                        <?php echo esc_html($branch['phone']); ?>
                    </a>
                </div>
                <?php 
                    $delay += 100;
                    endforeach;
                endif;
                ?>
            </div>
        </section>

        <!-- Форма запроса -->
        <div class="contact-form">
            <!-- <h2 class="contact-form__title"><?php echo esc_html(get_field('contact_form_title') ?: 'Оставьте заявку на расчет цены проекта дизельного генератора 16 кВт'); ?></h2> -->
            <?php echo do_shortcode('[contact-form-7 id="66a6e0c" title="Оставьте заявку"]'); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>