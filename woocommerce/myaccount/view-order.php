
<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();
?>

<div class="wc-account-view-order">
    <div class="wc-account-view-order__header">
        <div class="wc-account-view-order__header-content">
            <h2 class="wc-account-view-order__title">
                <?php
                /* translators: 1: order number */
                printf(esc_html__('Заказ #%s', 'woocommerce'), esc_html($order->get_order_number()));
                ?>
            </h2>
            <p class="wc-account-view-order__meta">
                <?php
                /* translators: 1: order date 2: order status */
                printf(
                    esc_html__('Размещен %1$s. Статус: %2$s', 'woocommerce'),
                    '<mark class="wc-account-view-order__date">' . esc_html(wc_format_datetime($order->get_date_created())) . '</mark>',
                    '<mark class="wc-account-view-order__status wc-account-order-status wc-account-order-status--' . esc_attr($order->get_status()) . '">' . esc_html(wc_get_order_status_name($order->get_status())) . '</mark>'
                );
                ?>
            </p>
        </div>
        
        <?php if ($order->has_status('failed')) : ?>
            <p class="wc-account-view-order__notice wc-account-view-order__notice--error">
                <?php esc_html_e('К сожалению, ваш заказ не может быть обработан, поскольку исходный платеж не прошел. Пожалуйста, оформите заказ еще раз.', 'woocommerce'); ?>
            </p>
        <?php endif; ?>
    </div>

    <?php do_action('woocommerce_view_order', $order_id); ?>

    <div class="wc-account-view-order__content">
        <!-- Order Items -->
        <section class="wc-account-order-details">
            <h3 class="wc-account-order-details__title">
                <i class="fa-solid fa-box"></i>
                <?php esc_html_e('Детали заказа', 'woocommerce'); ?>
            </h3>

            <table class="wc-account-order-details-table shop_table order_details">
                <thead>
                    <tr>
                        <th class="wc-account-order-details-table__product-name product-name"><?php esc_html_e('Товар', 'woocommerce'); ?></th>
                        <th class="wc-account-order-details-table__product-total product-total"><?php esc_html_e('Итого', 'woocommerce'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    do_action('woocommerce_order_details_before_order_table_items', $order);

                    foreach ($order->get_items() as $item_id => $item) {
                        $product = $item->get_product();
                        ?>
                        <tr class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'wc-account-order-details-table__row order_item', $item, $order)); ?>">
                            <td class="wc-account-order-details-table__product-name product-name">
                                <div class="wc-account-order-product">
                                    <?php if ($product && $product->get_image_id()) : ?>
                                        <div class="wc-account-order-product__image">
                                            <?php echo wp_kses_post($product->get_image('thumbnail')); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="wc-account-order-product__info">
                                        <?php
                                        $is_visible = $product && $product->is_visible();
                                        $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);

                                        echo wp_kses_post(apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible));

                                        $qty = $item->get_quantity();
                                        $refunded_qty = $order->get_qty_refunded_for_item($item_id);

                                        if ($refunded_qty) {
                                            $qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ($refunded_qty * -1)) . '</ins>';
                                        } else {
                                            $qty_display = esc_html($qty);
                                        }

                                        echo ' <strong class="product-quantity">&times;&nbsp;' . $qty_display . '</strong>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

                                        do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false);

                                        wc_display_item_meta($item);

                                        do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false);
                                        ?>
                                    </div>
                                </div>
                            </td>

                            <td class="wc-account-order-details-table__product-total product-total">
                                <?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?>
                            </td>
                        </tr>
                        <?php
                    }

                    do_action('woocommerce_order_details_after_order_table_items', $order);
                    ?>
                </tbody>

                <tfoot>
                    <?php
                    foreach ($order->get_order_item_totals() as $key => $total) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($total['label']); ?></th>
                            <td><?php echo wp_kses_post($total['value']); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <?php if ($order->get_customer_note()) : ?>
                        <tr>
                            <th><?php esc_html_e('Примечание:', 'woocommerce'); ?></th>
                            <td><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                        </tr>
                    <?php endif; ?>
                </tfoot>
            </table>
        </section>

        <!-- Order Details -->
        <div class="wc-account-order-info-grid">
            <?php do_action('woocommerce_order_details_after_order_table', $order); ?>

            <section class="wc-account-order-info-card">
                <h3 class="wc-account-order-info-card__title">
                    <i class="fa-solid fa-map-marker-alt"></i>
                    <?php esc_html_e('Адрес доставки', 'woocommerce'); ?>
                </h3>
                <address class="wc-account-order-info-card__content">
                    <?php echo wp_kses_post($order->get_formatted_shipping_address(esc_html__('Адрес не указан.', 'woocommerce'))); ?>
                    
                    <?php if ($order->get_shipping_phone()) : ?>
                        <p class="wc-account-order-info-card__phone">
                            <i class="fa-solid fa-phone"></i>
                            <?php echo esc_html($order->get_shipping_phone()); ?>
                        </p>
                    <?php endif; ?>
                </address>
            </section>

            <section class="wc-account-order-info-card">
                <h3 class="wc-account-order-info-card__title">
                    <i class="fa-solid fa-file-invoice"></i>
                    <?php esc_html_e('Адрес выставления счета', 'woocommerce'); ?>
                </h3>
                <address class="wc-account-order-info-card__content">
                    <?php echo wp_kses_post($order->get_formatted_billing_address(esc_html__('Адрес не указан.', 'woocommerce'))); ?>

                    <?php if ($order->get_billing_phone()) : ?>
                        <p class="wc-account-order-info-card__phone">
                            <i class="fa-solid fa-phone"></i>
                            <?php echo esc_html($order->get_billing_phone()); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($order->get_billing_email()) : ?>
                        <p class="wc-account-order-info-card__email">
                            <i class="fa-solid fa-envelope"></i>
                            <?php echo esc_html($order->get_billing_email()); ?>
                        </p>
                    <?php endif; ?>
                </address>
            </section>

            <?php if ($order->get_payment_method_title()) : ?>
                <section class="wc-account-order-info-card">
                    <h3 class="wc-account-order-info-card__title">
                        <i class="fa-solid fa-credit-card"></i>
                        <?php esc_html_e('Способ оплаты', 'woocommerce'); ?>
                    </h3>
                    <div class="wc-account-order-info-card__content">
                        <?php echo wp_kses_post($order->get_payment_method_title()); ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($order->get_shipping_method()) : ?>
                <section class="wc-account-order-info-card">
                    <h3 class="wc-account-order-info-card__title">
                        <i class="fa-solid fa-truck"></i>
                        <?php esc_html_e('Способ доставки', 'woocommerce'); ?>
                    </h3>
                    <div class="wc-account-order-info-card__content">
                        <?php echo wp_kses_post($order->get_shipping_method()); ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($notes) : ?>
        <section class="wc-account-order-updates">
            <h3 class="wc-account-order-updates__title">
                <i class="fa-solid fa-comments"></i>
                <?php esc_html_e('Обновления заказа', 'woocommerce'); ?>
            </h3>
            <ol class="wc-account-order-updates__list commentlist notes">
                <?php foreach ($notes as $note) : ?>
                    <li class="wc-account-order-update note">
                        <div class="wc-account-order-update__meta">
                            <abbr class="wc-account-order-update__date exact-date" title="<?php echo esc_attr($note->date_created->date('c')); ?>">
                                <?php
                                /* translators: %s: note date */
                                printf(esc_html__('добавлено %s', 'woocommerce'), esc_html($note->date_created->date_i18n(get_option('date_format'))));
                                ?>
                            </abbr>
                        </div>
                        <div class="wc-account-order-update__description description">
                            <?php echo wpautop(wptexturize($note->content)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>
    <?php endif; ?>

    <div class="wc-account-view-order__actions">
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="wc-account-btn wc-account-btn--outline">
            <i class="fa-solid fa-arrow-left"></i>
            <?php esc_html_e('Назад к заказам', 'woocommerce'); ?>
        </a>
    </div>
</div>

