
<?php
/**
 * Edit account form
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form'); ?>

<div class="wc-account-edit">
    <div class="wc-account-edit__header">
        <h2 class="wc-account-edit__title">
            <i class="fa-solid fa-user-edit"></i>
            <?php esc_html_e('Данные учетной записи', 'woocommerce'); ?>
        </h2>
        <p class="wc-account-edit__subtitle">
            <?php esc_html_e('Управляйте своей личной информацией', 'woocommerce'); ?>
        </p>
    </div>

    <form class="wc-account-edit-form edit-account" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>

        <?php do_action('woocommerce_edit_account_form_start'); ?>

        <div class="wc-account-form-section">
            <h3 class="wc-account-form-section__title">
                <i class="fa-solid fa-id-card"></i>
                <?php esc_html_e('Личная информация', 'woocommerce'); ?>
            </h3>

            <div class="wc-account-form-row">
                <div class="wc-account-form-group">
                    <label for="account_first_name" class="wc-account-form-group__label">
                        <?php esc_html_e('Имя', 'woocommerce'); ?> <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="wc-account-form-group__input woocommerce-Input woocommerce-Input--text input-text" 
                           name="account_first_name" 
                           id="account_first_name" 
                           autocomplete="given-name" 
                           value="<?php echo esc_attr($user->first_name); ?>" 
                           required />
                </div>

                <div class="wc-account-form-group">
                    <label for="account_last_name" class="wc-account-form-group__label">
                        <?php esc_html_e('Фамилия', 'woocommerce'); ?> <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="wc-account-form-group__input woocommerce-Input woocommerce-Input--text input-text" 
                           name="account_last_name" 
                           id="account_last_name" 
                           autocomplete="family-name" 
                           value="<?php echo esc_attr($user->last_name); ?>" 
                           required />
                </div>
            </div>

            <div class="wc-account-form-group">
                <label for="account_display_name" class="wc-account-form-group__label">
                    <?php esc_html_e('Отображаемое имя', 'woocommerce'); ?> <span class="required">*</span>
                </label>
                <input type="text" 
                       class="wc-account-form-group__input woocommerce-Input woocommerce-Input--text input-text" 
                       name="account_display_name" 
                       id="account_display_name" 
                       value="<?php echo esc_attr($user->display_name); ?>" 
                       required />
                <span class="wc-account-form-group__description">
                    <?php esc_html_e('Это имя будет отображаться на вашей учетной записи и в отзывах.', 'woocommerce'); ?>
                </span>
            </div>
        </div>

        <div class="wc-account-form-section">
            <h3 class="wc-account-form-section__title">
                <i class="fa-solid fa-envelope"></i>
                <?php esc_html_e('Контактная информация', 'woocommerce'); ?>
            </h3>

            <div class="wc-account-form-group">
                <label for="account_email" class="wc-account-form-group__label">
                    <?php esc_html_e('Адрес email', 'woocommerce'); ?> <span class="required">*</span>
                </label>
                <input type="email" 
                       class="wc-account-form-group__input woocommerce-Input woocommerce-Input--email input-text" 
                       name="account_email" 
                       id="account_email" 
                       autocomplete="email" 
                       value="<?php echo esc_attr($user->user_email); ?>" 
                       required />
            </div>
        </div>

        <div class="wc-account-form-section">
            <h3 class="wc-account-form-section__title">
                <i class="fa-solid fa-lock"></i>
                <?php esc_html_e('Изменить пароль', 'woocommerce'); ?>
            </h3>
            <p class="wc-account-form-section__description">
                <?php esc_html_e('Оставьте поля пустыми, если не хотите менять пароль.', 'woocommerce'); ?>
            </p>

            <div class="wc-account-form-group">
                <label for="password_current" class="wc-account-form-group__label">
                    <?php esc_html_e('Текущий пароль (оставьте пустым, если не изменяете)', 'woocommerce'); ?>
                </label>
                <div class="wc-account-form-group__password-wrapper">
                    <input type="password" 
                           class="wc-account-form-group__input woocommerce-Input woocommerce-Input--password input-text" 
                           name="password_current" 
                           id="password_current" 
                           autocomplete="off" />
                    <button type="button" class="wc-account-form-group__toggle-password" aria-label="<?php esc_attr_e('Показать пароль', 'woocommerce'); ?>">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="wc-account-form-group">
                <label for="password_1" class="wc-account-form-group__label">
                    <?php esc_html_e('Новый пароль (оставьте пустым, если не изменяете)', 'woocommerce'); ?>
                </label>
                <div class="wc-account-form-group__password-wrapper">
                    <input type="password" 
                           class="wc-account-form-group__input woocommerce-Input woocommerce-Input--password input-text" 
                           name="password_1" 
                           id="password_1" 
                           autocomplete="off" />
                    <button type="button" class="wc-account-form-group__toggle-password" aria-label="<?php esc_attr_e('Показать пароль', 'woocommerce'); ?>">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="wc-account-form-group">
                <label for="password_2" class="wc-account-form-group__label">
                    <?php esc_html_e('Подтвердите новый пароль', 'woocommerce'); ?>
                </label>
                <div class="wc-account-form-group__password-wrapper">
                    <input type="password" 
                           class="wc-account-form-group__input woocommerce-Input woocommerce-Input--password input-text" 
                           name="password_2" 
                           id="password_2" 
                           autocomplete="off" />
                    <button type="button" class="wc-account-form-group__toggle-password" aria-label="<?php esc_attr_e('Показать пароль', 'woocommerce'); ?>">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <?php do_action('woocommerce_edit_account_form'); ?>

        <div class="wc-account-form-actions">
            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
            <button type="submit" class="wc-account-btn wc-account-btn--primary woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e('Сохранить изменения', 'woocommerce'); ?>">
                <i class="fa-solid fa-check"></i>
                <?php esc_html_e('Сохранить изменения', 'woocommerce'); ?>
            </button>
            <input type="hidden" name="action" value="save_account_details" />
        </div>

        <?php do_action('woocommerce_edit_account_form_end'); ?>
    </form>
</div>

<?php do_action('woocommerce_after_edit_account_form'); ?>

