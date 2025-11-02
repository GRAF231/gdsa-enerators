<?php
/**
 * Блок: Кейсы/Примеры проектов
 * Layout: case_cards
 */

$cases = get_sub_field('cases');

if ($cases) {
    echo '<div class="case-cards">';
    
    foreach ($cases as $case) {
        $title = $case['title'];
        $meta = $case['meta'];
        $description = $case['description'];
        ?>
        <div class="case-card">
            <h3 class="case-card__title"><?php echo esc_html($title); ?></h3>
            <?php if ($meta) : ?>
            <div class="case-card__meta"><?php echo esc_html($meta); ?></div>
            <?php endif; ?>
            <p><?php echo esc_html($description); ?></p>
        </div>
        <?php
    }
    
    echo '</div>';
}
