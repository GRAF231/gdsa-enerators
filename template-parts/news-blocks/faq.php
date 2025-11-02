<?php
/**
 * Блок: FAQ (Частые вопросы)
 * Layout: faq
 */

$faq_items = get_sub_field('faq_items');

if ($faq_items) {
    echo '<div class="faq">';
    
    foreach ($faq_items as $faq) {
        $question = $faq['question'];
        $answer = $faq['answer'];
        ?>
        <details>
            <summary><?php echo esc_html($question); ?></summary>
            <p><?php echo esc_html($answer); ?></p>
        </details>
        <?php
    }
    
    echo '</div>';
}
