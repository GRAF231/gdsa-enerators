<?php
/**
 * Product Team Section
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Массив команды (в будущем можно вынести в настройки или ACF)
$team_members = [
    [
        'name' => 'Константин Новиков',
        'position' => 'Руководитель отдела продаж',
        'phone' => '+780055115977,703',
        'phone_text' => '8 (800) 511-59-77, доб. 703',
        'email' => 'novikov@dsa-generators.ru',
        'photo' => 'novikov.webp'
    ],
    [
        'name' => 'Максим Резенко',
        'position' => 'Руководитель направления продаж ДГУ',
        'phone' => '+780055115977,709',
        'phone_text' => '8 (800) 511-59-77, доб. 709',
        'email' => 'rezenko@dsa-generators.ru',
        'photo' => 'rezenko.webp'
    ],
    [
        'name' => 'Борис Михайлов',
        'position' => 'Специалист отдела продаж',
        'phone' => '+780055115977,710',
        'phone_text' => '8 (800) 511-59-77, доб. 710',
        'email' => 'mikhailov@dsa-generators.ru',
        'photo' => 'mikhailov.webp'
    ],
    [
        'name' => 'Игорь Ишин',
        'position' => 'Главный инженер проектов',
        'phone' => '+780055115977,715',
        'phone_text' => '8 (800) 511-59-77, доб. 715',
        'email' => 'ishin@dsa-generators.ru',
        'photo' => 'ishin.webp'
    ],
    [
        'name' => 'Дарина Максимова',
        'position' => 'Руководитель отдела продаж спецпроектов',
        'phone' => '+780055115977,702',
        'phone_text' => '8 (800) 511-59-77, доб. 702',
        'email' => 'maksimova@dsa-generators.ru',
        'photo' => 'maksimova.webp'
    ],
    [
        'name' => 'Филипп Крекотень',
        'position' => 'Руководитель направления продаж сервисных услуг',
        'phone' => '+780055115977,705',
        'phone_text' => '8 (800) 511-59-77, доб. 705',
        'email' => 'krekoten@dsa-generators.ru',
        'photo' => 'krekoten.webp'
    ],
];
?>

<div class="product-team">
    <h2 class="product-team__title">Наша команда поможет выбрать дизель-генератор, подготовить проектную документацию и осметить СМР</h2>
    
    <div class="team-grid">
        <?php foreach ($team_members as $member) : ?>
            <div class="team-card">
                <div class="team-card__photo">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/team/' . $member['photo']); ?>" 
                         alt="<?php echo esc_attr($member['name']); ?>" 
                         class="team-card__img"
                         loading="lazy">
                </div>
                <div class="team-card__info">
                    <h3 class="team-card__name"><?php echo esc_html($member['name']); ?></h3>
                    <p class="team-card__position"><?php echo esc_html($member['position']); ?></p>
                    <div class="team-card__contacts">
                        <a href="tel:<?php echo esc_attr($member['phone']); ?>" class="team-card__phone">
                            <i class="fa-solid fa-phone"></i>
                            <?php echo esc_html($member['phone_text']); ?>
                        </a>
                        <a href="mailto:<?php echo esc_attr($member['email']); ?>" class="team-card__email">
                            <i class="fa-solid fa-envelope"></i>
                            Написать сотруднику на Email
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
