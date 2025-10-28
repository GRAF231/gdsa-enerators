
<?php
/**
 * Edit address form
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

$page_title = ($load_address === 'billing') ? esc_html__('Адрес выставления счета', 'woocommerce') : esc_html__('Адрес доставки', 'woocommerce');

do_action('woocommerce_before_edit_address_form_' . $load_address); ?>

<?php if (!$load_address) : ?>
    <?php wc_get_template('myaccount/my-address.php'); ?>
<?php else : ?>

    <div class="wc-account-edit-address">
        <div class="wc-account-edit-address__header">
            <h2 class="wc-account-edit-address__title">
                <i class="fa-solid fa-<?php echo $load_address === 'billing' ? 'file-invoice' : 'map-marker-alt'; ?>"></i>
                <?php echo esc_html($page_title); ?>
            </h2>
            <p class="wc-account-edit-address__subtitle">
                <?php echo $load_address === 'billing' ? esc_html__('Адрес для выставления счетов', 'woocommerce') : esc_html__('Адрес для доставки товаров', 'woocommerce'); ?>
            </p>
        </div>

        <form method="post" class="wc-account-edit-address-form edit-address">

            <div class="wc-account-edit-address-fields">
                <?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

                <?php foreach ($address as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value'])); ?>
                <?php endforeach; ?>

                <?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>
            </div>

            <div class="wc-account-form-actions">
                <button type="submit" class="wc-account-btn wc-account-btn--primary button" name="save_address" value="<?php esc_attr_e('Сохранить адрес', 'woocommerce'); ?>">
                    <i class="fa-solid fa-check"></i>
                    <?php esc_html_e('Сохранить адрес', 'woocommerce'); ?>
                </button>
                <?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
                <input type="hidden" name="action" value="edit_address" />
            </div>

        </form>
    </div>

<?php endif; ?>

<?php do_action('woocommerce_after_edit_address_form_' . $load_address); ?>

