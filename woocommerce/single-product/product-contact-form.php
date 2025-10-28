<?php
/**
 * Product Contact Form
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;
$power = get_field('power');
?>

<div class="contact-form">
    <h2 class="contact-form__title">
        Оставьте заявку на расчет цены проекта дизельного генератора<?php echo $power ? ' ' . esc_html($power) . ' кВт' : ''; ?>
    </h2>
    
    <?php
    /**
     * Интеграция с Contact Form 7
     * Если плагин установлен, выводим форму
     */
    if (function_exists('wpcf7_enqueue_scripts')) {
        // ID формы Contact Form 7 - нужно создать форму в админке
        // После создания формы замените ID на актуальный
        $cf7_id = get_option('dsa_product_contact_form_id', 0);
        
        if ($cf7_id) {
            echo do_shortcode('[contact-form-7 id="' . $cf7_id . '" title="Product Contact Form"]');
        } else {
            // Fallback: стандартная HTML форма
            ?>
            <form class="contact-form__form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="dsa_product_inquiry">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($product->get_id()); ?>">
                <input type="hidden" name="product_name" value="<?php echo esc_attr($product->get_name()); ?>">
                <?php wp_nonce_field('dsa_product_inquiry', 'dsa_inquiry_nonce'); ?>
                
                <div class="contact-form__fields">
                    <div class="contact-form__column">
                        <div class="form-group">
                            <label for="inquiry-name" class="form-label">Имя <span class="required">*</span></label>
                            <input type="text" 
                                   id="inquiry-name" 
                                   name="inquiry_name" 
                                   class="form-input" 
                                   placeholder="Введите ваше имя" 
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="inquiry-email" class="form-label">E-mail <span class="required">*</span></label>
                            <input type="email" 
                                   id="inquiry-email" 
                                   name="inquiry_email" 
                                   class="form-input" 
                                   placeholder="Введите ваш email" 
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="inquiry-phone" class="form-label">Телефон <span class="required">*</span></label>
                            <input type="tel" 
                                   id="inquiry-phone" 
                                   name="inquiry_phone" 
                                   class="form-input" 
                                   placeholder="+7 (___) ___-__-__" 
                                   required>
                        </div>
                    </div>
                    <div class="contact-form__column">
                        <div class="form-group">
                            <label for="inquiry-message" class="form-label">Сообщение</label>
                            <textarea id="inquiry-message" 
                                      name="inquiry_message" 
                                      class="form-textarea" 
                                      placeholder="Опишите ваши требования"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form__footer">
                    <div class="form-checkbox">
                        <input type="checkbox" 
                               id="inquiry-consent" 
                               name="inquiry_consent" 
                               class="form-checkbox__input" 
                               required>
                        <label for="inquiry-consent" class="form-checkbox__label">
                            Настоящим подтверждаю, что я ознакомлен и согласен с условиями 
                            <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="form-checkbox__link">обработки персональных данных</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn_type_primary contact-form__submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Отправить запрос</span>
                    </button>
                </div>
            </form>
            <?php
        }
    } else {
        echo '<p class="contact-form__notice">Для отправки заявки, пожалуйста, свяжитесь с нами по телефону <a href="tel:+78007707157">8 (800) 770-71-57</a> или email <a href="mailto:order@dsa-generators.ru">order@dsa-generators.ru</a></p>';
    }
    ?>
</div>
