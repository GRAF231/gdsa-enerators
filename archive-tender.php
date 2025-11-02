<?php
/**
 * Архив тендеров
 * 
 * @package DSA_Generators
 */

get_header();

dsa_breadcrumbs();
?>

<!-- Заголовок страницы -->
<section class="page-header">
    <div class="container">
        <?php 
        // Получаем заголовок из системных настроек ACF
        $page_title = get_field('tenders_archive_title', 'option');
        if (!$page_title) {
            $page_title = 'Референс-лист контрактов DSA Generators по 44-ФЗ и 223-ФЗ';
        }
        ?>
        <h1 class="page-header__title"><?php echo esc_html($page_title); ?></h1>
    </div>
</section>

<!-- Основной контент -->
<main class="main-content tenders-content" role="main">
    <div class="container">
        <!-- Вводный текст -->
        <div class="tenders-intro">
            <?php 
            $intro_text = get_field('tenders_intro_text', 'option');
            if (!$intro_text) {
                $intro_text = 'DSA Generators является активным участником государственных закупок, в том числе государственного оборонного заказа на территории России. За период с 2013 по 2023 гг. нами выполнено более 200 контрактов по 44-ФЗ и 223-ФЗ на общую сумму более 3,5 млрд рублей.';
            }
            ?>
            <p class="tenders-intro__text">
                <?php echo esc_html($intro_text); ?>
            </p>
        </div>

        <!-- Контракты по 44-ФЗ -->
        <div class="tenders-section">
            <?php 
            $title_44fz = get_field('tenders_44fz_title', 'option');
            if (!$title_44fz) {
                $title_44fz = 'Контракты DSA Generators, выполненные по 44-ФЗ';
            }
            ?>
            <h2 class="tenders-section__title"><?php echo esc_html($title_44fz); ?></h2>
            
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

        <!-- Контракты по 223-ФЗ -->
        <div class="tenders-section">
            <?php 
            $title_223fz = get_field('tenders_223fz_title', 'option');
            if (!$title_223fz) {
                $title_223fz = 'Контракты DSA Generators по 223-ФЗ';
            }
            ?>
            <h2 class="tenders-section__title"><?php echo esc_html($title_223fz); ?></h2>
            
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

        <!-- Статистика -->
        <div class="tenders-stats">
            <div class="tenders-stats__grid">
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_contracts', 'option') ?: '200+'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_contracts_label', 'option') ?: 'Выполненных контрактов'); ?></div>
                </div>
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_amount', 'option') ?: '3,5+ млрд ₽'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_amount_label', 'option') ?: 'Общая сумма контрактов'); ?></div>
                </div>
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_experience', 'option') ?: '10 лет'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_experience_label', 'option') ?: 'Опыт работы с госзакупками'); ?></div>
                </div>
                <div class="tenders-stats__item">
                    <div class="tenders-stats__number"><?php echo esc_html(get_field('tenders_stats_success', 'option') ?: '100%'); ?></div>
                    <div class="tenders-stats__label"><?php echo esc_html(get_field('tenders_stats_success_label', 'option') ?: 'Успешное выполнение'); ?></div>
                </div>
            </div>
        </div>

        <!-- CTA блок -->
        <div class="tenders-cta">
            <div class="tenders-cta__content">
                <h3 class="tenders-cta__title"><?php echo esc_html(get_field('tenders_cta_title', 'option') ?: 'Участвуем в тендерах и государственных закупках'); ?></h3>
                <p class="tenders-cta__text">
                    <?php echo esc_html(get_field('tenders_cta_text', 'option') ?: 'Готовы предоставить качественное оборудование и услуги для ваших проектов. Имеем опыт работы с крупнейшими государственными и коммерческими заказчиками.'); ?>
                </p>
                <div class="tenders-cta__actions">
                    <?php 
                    $button1_url = get_field('tenders_cta_button1_url', 'option');
                    $button1_text = get_field('tenders_cta_button1_text', 'option') ?: 'Связаться с нами';
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
                    $button2_url = get_field('tenders_cta_button2_url', 'option');
                    $button2_text = get_field('tenders_cta_button2_text', 'option') ?: 'Запросить КП';
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
</main>

<?php get_footer(); ?>
