<?php
/**
 * Template Name: Тендеры
 * 
 * Шаблон страницы тендеров с ACF полями
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

<!-- Заголовок страницы -->
<section class="page-header">
    <div class="container">
        <h1 class="page-header__title"><?php echo esc_html(get_field('tenders_page_title') ?: 'Референс-лист контрактов DSA Generators по 44-ФЗ и 223-ФЗ'); ?></h1>
    </div>
</section>

<!-- Основной контент -->
<section class="tenders-content">
    <div class="container">
        <!-- Вводный текст -->
        <div class="tenders-intro">
            <p class="tenders-intro__text">
                <?php echo esc_html(get_field('tenders_intro_text') ?: 'DSA Generators является активным участником государственных закупок, в том числе государственного оборонного заказа на территории России. За период с 2013 по 2023 гг. нами выполнено более 200 контрактов по 44-ФЗ и 223-ФЗ на общую сумму более 3,5 млрд рублей.'); ?>
            </p>
        </div>

        <!-- Контракты по 44-ФЗ -->
        <div class="tenders-section">
            <h2 class="tenders-section__title"><?php echo esc_html(get_field('tenders_44fz_title') ?: 'Контракты DSA Generators, выполненные по 44-ФЗ'); ?></h2>
            
            <div class="tenders-table">
                <div class="tenders-table__header">
                    <div class="tenders-table__col tenders-table__col--amount">Сумма</div>
                    <div class="tenders-table__col tenders-table__col--customer">Заказчик</div>
                    <div class="tenders-table__col tenders-table__col--subject">Предмет контракта</div>
                    <div class="tenders-table__col tenders-table__col--date">Дата</div>
                </div>
                
                <div class="tenders-table__body">
                    <?php 
                    $contracts_44fz = get_field('tenders_44fz_contracts');
                    if ($contracts_44fz) :
                        foreach ($contracts_44fz as $contract) :
                    ?>
                    <div class="tenders-table__row">
                        <div class="tenders-table__cell tenders-table__cell--amount"><?php echo esc_html($contract['contract_amount']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--customer"><?php echo esc_html($contract['contract_customer']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--subject"><?php echo esc_html($contract['contract_subject']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--date"><?php echo esc_html($contract['contract_date']); ?></div>
                    </div>
                    <?php 
                        endforeach;
                    else :
                        // Дефолтные контракты по 44-ФЗ, если ACF поля не заполнены
                        $default_44fz_contracts = [
                            [
                                'amount' => '114 730 845 ₽',
                                'customer' => 'Комитет жизнеобеспечения территории администрации Хасынского городского округа',
                                'subject' => 'Демонтаж советских ДГ72, СМР и установка высоковольтного энергокомплекса 6 МВт для поселка Талая (Магадан)',
                                'date' => '26.07.2022'
                            ],
                            [
                                'amount' => '61 149 442 ₽',
                                'customer' => 'ФГБУ "Санкт-Петербургский Научно-исследовательский институт Фтизиопульмонологии" Минздрава России',
                                'subject' => 'Реконструкция газовой котельной 7 МВт и инженерных сетей санатория "Плес"',
                                'date' => '10.08.2015'
                            ],
                            [
                                'amount' => '49 173 883 ₽',
                                'customer' => 'СПб ГКУ "Дирекция транспортного строительства"',
                                'subject' => 'Ремонт асфальта: тоннель Большеохтинского моста, Восточный и западный путепровод у Пулковского шоссе, Силин мост, Ново-Московский мост, Кантемировский мост',
                                'date' => '06.08.2015'
                            ],
                            [
                                'amount' => '35 582 216 ₽',
                                'customer' => 'СПб ГКУ "Дирекция транспортного строительства"',
                                'subject' => 'Капитальный ремонт проезжей части и тротуара ул. Тихая Невского района Санкт-Петербурга',
                                'date' => '07.11.2017'
                            ],
                            [
                                'amount' => '35 620 800 ₽',
                                'customer' => 'ФГБУ Национальный медицинский исследовательский центр им. В.А. Алмазова Минздрава России',
                                'subject' => 'ДЭС 800 кВт и монтаж системы вентиляции для биобанка Центра Алмазова в Солнечном',
                                'date' => '22.08.2022'
                            ],
                            [
                                'amount' => '35 430 000 ₽',
                                'customer' => 'Фонд капитального строительства и реконструкции',
                                'subject' => 'Разборка аварийных конструкций зданий по адресам: Санкт-Петербург, Тележная ул., дома №№ 21,23, 25-27, 29 Лит. А, Г',
                                'date' => '05.12.2017'
                            ]
                        ];
                        
                        foreach ($default_44fz_contracts as $contract) :
                    ?>
                    <div class="tenders-table__row">
                        <div class="tenders-table__cell tenders-table__cell--amount"><?php echo esc_html($contract['amount']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--customer"><?php echo esc_html($contract['customer']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--subject"><?php echo esc_html($contract['subject']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--date"><?php echo esc_html($contract['date']); ?></div>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <!-- Контракты по 223-ФЗ -->
        <div class="tenders-section">
            <h2 class="tenders-section__title"><?php echo esc_html(get_field('tenders_223fz_title') ?: 'Контракты DSA Generators по 223-ФЗ'); ?></h2>
            
            <div class="tenders-table">
                <div class="tenders-table__header">
                    <div class="tenders-table__col tenders-table__col--amount">Сумма</div>
                    <div class="tenders-table__col tenders-table__col--customer">Заказчик</div>
                    <div class="tenders-table__col tenders-table__col--subject">Предмет контракта</div>
                    <div class="tenders-table__col tenders-table__col--date">Дата</div>
                </div>
                
                <div class="tenders-table__body">
                    <?php 
                    $contracts_223fz = get_field('tenders_223fz_contracts');
                    if ($contracts_223fz) :
                        foreach ($contracts_223fz as $contract) :
                    ?>
                    <div class="tenders-table__row">
                        <div class="tenders-table__cell tenders-table__cell--amount"><?php echo esc_html($contract['contract_223fz_amount']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--customer"><?php echo esc_html($contract['contract_223fz_customer']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--subject"><?php echo esc_html($contract['contract_223fz_subject']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--date"><?php echo esc_html($contract['contract_223fz_date']); ?></div>
                    </div>
                    <?php 
                        endforeach;
                    else :
                        // Дефолтные контракты по 223-ФЗ, если ACF поля не заполнены
                        $default_223fz_contracts = [
                            [
                                'amount' => '307 500 000 ₽',
                                'customer' => 'TİTAN 2 IC Ictas Insaat A.S',
                                'subject' => '2 ДЭС по 250 и 4 ДЭС по 2000 кВт для здания 02UYX, 10-40 UKD для сооружения энергоблоков № 1, 2, 3, 4 АЭС "Аккую"',
                                'date' => '14.06.2022'
                            ],
                            [
                                'amount' => '149 887 043 ₽',
                                'customer' => 'АО "Атомстройэкспорт"',
                                'subject' => 'Две передвижные альтернативные ДЭС 4 МВт для АЭС "Руппур" в Бангладеш',
                                'date' => '20.04.2021'
                            ],
                            [
                                'amount' => '89 734 845 ₽',
                                'customer' => 'АО "Концерн Титан-2"',
                                'subject' => 'Нагревательный комплекс системы циркуляции свинцового теплоносителя для Стенда ПСИ ГЦНА РУ БРЕСТ-ОД-300',
                                'date' => '22.02.2023'
                            ],
                            [
                                'amount' => '60 251 000 ₽',
                                'customer' => 'АО "Дальневосточная Распределительная Сетевая Компания"',
                                'subject' => '25 дизель-генераторов мощностью 250 кВт в кожухе на шасси',
                                'date' => '14.10.2022'
                            ],
                            [
                                'amount' => '45 320 000 ₽',
                                'customer' => 'АО "Золото Селигдара"',
                                'subject' => 'Поставка дизельной электростанции 1000 кВт с автоматическим вводом резерва',
                                'date' => '18.03.2023'
                            ],
                            [
                                'amount' => '38 750 000 ₽',
                                'customer' => 'ПАО "Газпром нефть"',
                                'subject' => 'Комплексная поставка резервного электроснабжения для нефтеперерабатывающего завода',
                                'date' => '12.09.2022'
                            ]
                        ];
                        
                        foreach ($default_223fz_contracts as $contract) :
                    ?>
                    <div class="tenders-table__row">
                        <div class="tenders-table__cell tenders-table__cell--amount"><?php echo esc_html($contract['amount']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--customer"><?php echo esc_html($contract['customer']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--subject"><?php echo esc_html($contract['subject']); ?></div>
                        <div class="tenders-table__cell tenders-table__cell--date"><?php echo esc_html($contract['date']); ?></div>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <!-- Статистика -->
        <div class="tenders-stats">
            <div class="tenders-stats__grid">
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_contracts') ?: '200+'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_contracts_label') ?: 'Выполненных контрактов'); ?></div>
                </div>
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_amount') ?: '3,5+ млрд ₽'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_amount_label') ?: 'Общая сумма контрактов'); ?></div>
                </div>
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_experience') ?: '10 лет'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_experience_label') ?: 'Опыт работы с госзакупками'); ?></div>
                </div>
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_success') ?: '100%'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_success_label') ?: 'Успешное выполнение'); ?></div>
                </div>
            </div>
        </div>

        <!-- CTA блок -->
        <div class="tenders-cta">
            <div class="tenders-cta__content">
                <h3 class="tenders-cta__title"><?php echo esc_html(get_field('tenders_cta_title') ?: 'Участвуем в тендерах и государственных закупках'); ?></h3>
                <p class="tenders-cta__text">
                    <?php echo esc_html(get_field('tenders_cta_text') ?: 'Готовы предоставить качественное оборудование и услуги для ваших проектов. Имеем опыт работы с крупнейшими государственными и коммерческими заказчиками.'); ?>
                </p>
                <div class="tenders-cta__actions">
                    <?php 
                    $button1_url = get_field('tenders_cta_button1_url');
                    $button1_text = get_field('tenders_cta_button1_text') ?: 'Связаться с нами';
                    if ($button1_url) :
                    ?>
                    <a href="<?php echo esc_url($button1_url); ?>" class="btn btn--primary btn--lg">
                        <i class="fas fa-phone"></i>
                        <span><?php echo esc_html($button1_text); ?></span>
                    </a>
                    <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/contacts')); ?>" class="btn btn--primary btn--lg">
                        <i class="fas fa-phone"></i>
                        <span><?php echo esc_html($button1_text); ?></span>
                    </a>
                    <?php endif; ?>
                    
                    <?php 
                    $button2_url = get_field('tenders_cta_button2_url');
                    $button2_text = get_field('tenders_cta_button2_text') ?: 'Запросить КП';
                    if ($button2_url) :
                    ?>
                    <a href="<?php echo esc_url($button2_url); ?>" class="btn btn--secondary btn--lg">
                        <i class="fas fa-file-alt"></i>
                        <span><?php echo esc_html($button2_text); ?></span>
                    </a>
                    <?php else : ?>
                    <a href="#" class="btn btn--secondary btn--lg">
                        <i class="fas fa-file-alt"></i>
                        <span><?php echo esc_html($button2_text); ?></span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>