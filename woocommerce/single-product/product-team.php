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

// Получаем данные из настроек сайта (ACF Options Page)
$team_title = get_field('product_team_title', 'option');
if (empty($team_title)) {
    $team_title = 'Наша команда поможет выбрать дизель-генератор, подготовить проектную документацию и осметить СМР';
}

$team_members = get_field('product_team_members', 'option');

// Отладка (раскомментируйте при необходимости для проверки)
// error_log('Team Title: ' . $team_title);
// error_log('Team Members: ' . print_r($team_members, true));
?>

<div class="product-team">
    <h2 class="product-team__title"><?php echo esc_html($team_title); ?></h2>
    
    <?php if ($team_members && is_array($team_members) && count($team_members) > 0) : ?>
        <div class="team-grid">
            <?php foreach ($team_members as $member) : 
                // Получаем данные участника
                $member_name = '';
                $member_position = '';
                $member_phone = '';
                $member_phone_text = '';
                $member_email = '';
                $member_photo = null;
                
                // Обрабатываем данные в зависимости от формата ACF
                if (is_array($member)) {
                    $member_name = isset($member['team_member_name']) ? trim($member['team_member_name']) : '';
                    $member_position = isset($member['team_member_position']) ? trim($member['team_member_position']) : '';
                    $member_phone = isset($member['team_member_phone']) ? trim($member['team_member_phone']) : '';
                    $member_phone_text = isset($member['team_member_phone_text']) ? trim($member['team_member_phone_text']) : $member_phone;
                    $member_email = isset($member['team_member_email']) ? trim($member['team_member_email']) : '';
                    $member_photo = isset($member['team_member_photo']) ? $member['team_member_photo'] : null;
                }
                
                // Пропускаем пустые записи
                if (empty($member_name)) {
                    continue;
                }
                
                // Определяем путь к изображению (ACF может вернуть ID, массив или URL)
                $photo_url = '';
                if ($member_photo) {
                    if (is_array($member_photo)) {
                        // ACF возвращает массив с данными изображения
                        $photo_url = isset($member_photo['url']) ? $member_photo['url'] : 
                                    (isset($member_photo['sizes']['medium']) ? $member_photo['sizes']['medium'] : '');
                    } elseif (is_numeric($member_photo)) {
                        // ACF возвращает ID изображения
                        $photo_url = wp_get_attachment_image_url($member_photo, 'medium');
                        if (!$photo_url) {
                            $photo_url = wp_get_attachment_url($member_photo);
                        }
                    } elseif (is_string($member_photo)) {
                        // ACF возвращает URL напрямую
                        $photo_url = $member_photo;
                    }
                }
            ?>
                <div class="team-card">
                    <?php if ($photo_url) : ?>
                        <div class="team-card__photo">
                            <img src="<?php echo esc_url($photo_url); ?>" 
                                 alt="<?php echo esc_attr($member_name); ?>" 
                                 class="team-card__img"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="team-card__info">
                        <?php if ($member_name) : ?>
                            <h3 class="team-card__name"><?php echo esc_html($member_name); ?></h3>
                        <?php endif; ?>
                        <?php if ($member_position) : ?>
                            <p class="team-card__position"><?php echo esc_html($member_position); ?></p>
                        <?php endif; ?>
                        <div class="team-card__contacts">
                            <?php if ($member_phone) : ?>
                                <a href="tel:<?php echo esc_attr($member_phone); ?>" class="team-card__phone">
                                    <i class="fa-solid fa-phone"></i>
                                    <?php echo esc_html($member_phone_text); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ($member_email) : ?>
                                <a href="mailto:<?php echo esc_attr($member_email); ?>" class="team-card__email">
                                    <i class="fa-solid fa-envelope"></i>
                                    Написать сотруднику на Email
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="product-team__empty">Команда не настроена. Добавьте участников команды в настройках сайта.</p>
        <?php 
        // Отладочная информация (для администраторов)
        if (current_user_can('administrator')) {
            echo '<div style="background: #f0f0f0; padding: 15px; margin: 20px 0; border: 1px solid #ccc; border-radius: 5px;">';
            echo '<strong style="display: block; margin-bottom: 10px;">🔍 Отладочная информация:</strong>';
            echo '<pre style="margin: 0; font-size: 12px; overflow: auto;">';
            echo 'Team Title Type: ' . gettype($team_title) . "\n";
            echo 'Team Title Value: ' . var_export($team_title, true) . "\n\n";
            echo 'Team Members Type: ' . gettype($team_members) . "\n";
            echo 'Team Members Count: ' . (is_array($team_members) ? count($team_members) : 'N/A') . "\n";
            echo 'Team Members Value: ' . "\n";
            print_r($team_members);
            echo "\n\nACF Field Check:\n";
            echo 'get_field("product_team_title", "option"): ' . var_export(get_field('product_team_title', 'option'), true) . "\n";
            echo 'get_field("product_team_members", "option"): ' . "\n";
            print_r(get_field('product_team_members', 'option'));
            echo '</pre>';
            echo '</div>';
        }
        ?>
    <?php endif; ?>
</div>
