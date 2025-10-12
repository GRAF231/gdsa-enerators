<?php
/**
 * Архив тендеров
 * 
 * @package DSA_Generators
 */

get_header();

// Хлебные крошки
dsa_breadcrumbs();
?>

<main class="main-content">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="page-header__title">Референс-лист контрактов DSA Generators по 44-ФЗ и 223-ФЗ</h1>
        </div>
    </section>

    <!-- Tenders Content -->
    <section class="tenders-content">
        <div class="container">
            <!-- Introduction -->
            <div class="tenders-intro">
                <p class="tenders-intro__text">
                    DSA Generators является активным участником государственных закупок, в том числе государственного оборонного заказа на территории России. 
                    За период с 2013 по 2023 гг. нами выполнено более 200 контрактов по 44-ФЗ и 223-ФЗ на общую сумму более 3,5 млрд рублей.
                </p>
            </div>

            <!-- 44-FZ Contracts -->
            <div class="tenders-section">
                <h2 class="tenders-section__title">Контракты DSA Generators, выполненные по 44-ФЗ</h2>
                
                <div class="tenders-table">
                    <div class="tenders-table__header">
                        <div class="tenders-table__col tenders-table__col--amount">Сумма</div>
                        <div class="tenders-table__col tenders-table__col--customer">Заказчик</div>
                        <div class="tenders-table__col tenders-table__col--subject">Предмет контракта</div>
                        <div class="tenders-table__col tenders-table__col--date">Дата</div>
                    </div>
                    
                    <div class="tenders-table__body">
                        <?php
                        // Запрос для тендеров 44-ФЗ
                        $tenders_44fz = new WP_Query([
                            'post_type' => 'tender',
                            'posts_per_page' => -1,
                            'meta_key' => 'law_type',
                            'meta_value' => '44fz',
                            'orderby' => 'meta_value_num',
                            'meta_key' => 'contract_date',
                            'order' => 'DESC'
                        ]);

                        if ($tenders_44fz->have_posts()) :
                            while ($tenders_44fz->have_posts()) : $tenders_44fz->the_post();
                                $amount = get_field('contract_amount');
                                $customer = get_field('customer_name');
                                $subject = get_field('contract_subject');
                                $date = get_field('contract_date');
                        ?>
                                <div class="tenders-table__row">
                                    <div class="tenders-table__cell tenders-table__cell--amount"><?php echo esc_html($amount); ?></div>
                                    <div class="tenders-table__cell tenders-table__cell--customer"><?php echo esc_html($customer); ?></div>
                                    <div class="tenders-table__cell tenders-table__cell--subject"><?php echo esc_html($subject); ?></div>
                                    <div class="tenders-table__cell tenders-table__cell--date"><?php echo esc_html($date); ?></div>
                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                        ?>
                            <div class="tenders-table__row">
                                <div class="tenders-table__cell" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                                    <p>Тендеров по 44-ФЗ пока нет.</p>
                                </div>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- 223-FZ Contracts -->
            <div class="tenders-section">
                <h2 class="tenders-section__title">Контракты DSA Generators по 223-ФЗ</h2>
                
                <div class="tenders-table">
                    <div class="tenders-table__header">
                        <div class="tenders-table__col tenders-table__col--amount">Сумма</div>
                        <div class="tenders-table__col tenders-table__col--customer">Заказчик</div>
                        <div class="tenders-table__col tenders-table__col--subject">Предмет контракта</div>
                        <div class="tenders-table__col tenders-table__col--date">Дата</div>
                    </div>
                    
                    <div class="tenders-table__body">
                        <?php
                        // Запрос для тендеров 223-ФЗ
                        $tenders_223fz = new WP_Query([
                            'post_type' => 'tender',
                            'posts_per_page' => -1,
                            'meta_key' => 'law_type',
                            'meta_value' => '223fz',
                            'orderby' => 'meta_value_num',
                            'meta_key' => 'contract_date',
                            'order' => 'DESC'
                        ]);

                        if ($tenders_223fz->have_posts()) :
                            while ($tenders_223fz->have_posts()) : $tenders_223fz->the_post();
                                $amount = get_field('contract_amount');
                                $customer = get_field('customer_name');
                                $subject = get_field('contract_subject');
                                $date = get_field('contract_date');
                        ?>
                                <div class="tenders-table__row">
                                    <div class="tenders-table__cell tenders-table__cell--amount"><?php echo esc_html($amount); ?></div>
                                    <div class="tenders-table__cell tenders-table__cell--customer"><?php echo esc_html($customer); ?></div>
                                    <div class="tenders-table__cell tenders-table__cell--subject"><?php echo esc_html($subject); ?></div>
                                    <div class="tenders-table__cell tenders-table__cell--date"><?php echo esc_html($date); ?></div>
                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                        ?>
                            <div class="tenders-table__row">
                                <div class="tenders-table__cell" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                                    <p>Тендеров по 223-ФЗ пока нет.</p>
                                </div>
                            </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="tenders-stats">
                <div class="tenders-stats__grid">
                    <div class="tenders-stats__item">
                        <div class="tenders-stats__number">200+</div>
                        <div class="tenders-stats__label">Выполненных контрактов</div>
                    </div>
                    <div class="tenders-stats__item">
                        <div class="tenders-stats__number">3,5+ млрд ₽</div>
                        <div class="tenders-stats__label">Общая сумма контрактов</div>
                    </div>
                    <div class="tenders-stats__item">
                        <div class="tenders-stats__number">10 лет</div>
                        <div class="tenders-stats__label">Опыт работы с госзакупками</div>
                    </div>
                    <div class="tenders-stats__item">
                        <div class="tenders-stats__number">100%</div>
                        <div class="tenders-stats__label">Успешное выполнение</div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="tenders-cta">
                <div class="tenders-cta__content">
                    <h3 class="tenders-cta__title">Участвуем в тендерах и государственных закупках</h3>
                    <p class="tenders-cta__text">
                        Готовы предоставить качественное оборудование и услуги для ваших проектов. 
                        Имеем опыт работы с крупнейшими государственными и коммерческими заказчиками.
                    </p>
                    <div class="tenders-cta__actions">
                        <a href="<?php echo home_url('/contacts'); ?>" class="btn btn--primary btn--lg">
                            <i class="fas fa-phone"></i>
                            <span>Связаться с нами</span>
                        </a>
                        <a href="#" class="btn btn--secondary btn--lg">
                            <i class="fas fa-file-alt"></i>
                            <span>Запросить КП</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
?>
