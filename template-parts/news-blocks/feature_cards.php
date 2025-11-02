<?php
/**
 * Блок: Карточки с иконками
 * Layout: feature_cards
 */

$cards = get_sub_field('cards');

if ($cards) {
    echo '<div class="feature-cards">';
    
    foreach ($cards as $card) {
        $icon = $card['icon'] ?: 'fa-solid fa-star';
        $title = $card['title'];
        $text = $card['text'];
        ?>
        <div class="feature-card">
            <div class="feature-card__icon"><i class="<?php echo esc_attr($icon); ?>"></i></div>
            <div class="feature-card__content">
                <h3 class="feature-card__title"><?php echo esc_html($title); ?></h3>
                <p class="feature-card__text"><?php echo esc_html($text); ?></p>
            </div>
        </div>
        <?php
    }
    
    echo '</div>';
}
