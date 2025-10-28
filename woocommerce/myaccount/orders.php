
<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders); ?>

<?php if ($has_orders) : ?>

    <div class="wc-account-orders">
        <div class="wc-account-orders__header">
            <h2 class="wc-account-orders__title">
                <i class="fa-solid fa-shopping-bag"></i>
                <?php esc_html_e('Мои заказы', 'woocommerce'); ?>
            </h2>
            <p class="wc-account-orders__subtitle">
                <?php esc_html_e('История всех ваших заказов', 'woocommerce'); ?>
            </p>
        </div>

        <div class="wc-account-orders-table-wrapper">
            <table class="wc-account-orders-table shop_table shop_table_responsive my_account_orders account-orders-table">
                <thead>
                    <tr>
                        <th class="wc-account-orders-table__header wc-account-orders-table__header--order-number">
                            <span class="nobr"><?php esc_html_e('Заказ', 'woocommerce'); ?></span>
                        </th>
                        <th class="wc-account-orders-table__header wc-account-orders-table__header--order-date">
                            <span class="nobr"><?php esc_html_e('Дата', 'woocommerce'); ?></span>
                        </th>
                        <th class="wc-account-orders-table__header wc-account-orders-table__header--order-status">
                            <span class="nobr"><?php esc_html_e('Статус', 'woocommerce'); ?></span>
                        </th>
                        <th class="wc-account-orders-table__header wc-account-orders-table__header--order-total">
                            <span class="nobr"><?php esc_html_e('Итого', 'woocommerce'); ?></span>
                        </th>
                        <th class="wc-account-orders-table__header wc-account-orders-table__header--order-actions">
                            <span class="nobr"><?php esc_html_e('Действия', 'woocommerce'); ?></span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($customer_orders->orders as $customer_order) {
                        $order = wc_get_order($customer_order);
                        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                        ?>
                        <tr class="wc-account-orders-table__row woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr($order->get_status()); ?> order">
                            <td class="wc-account-orders-table__cell wc-account-orders-table__cell--order-number" data-title="<?php esc_attr_e('Заказ', 'woocommerce'); ?>">
                                <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="wc-account-orders-table__order-link">
                                    <span class="wc-account-orders-table__order-number">#<?php echo esc_html($order->get_order_number()); ?></span>
                                </a>
                            </td>
                            <td class="wc-account-orders-table__cell wc-account-orders-table__cell--order-date" data-title="<?php esc_attr_e('Дата', 'woocommerce'); ?>">
                                <time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>">
                                    <?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
                                </time>
                            </td>
                            <td class="wc-account-orders-table__cell wc-account-orders-table__cell--order-status" data-title="<?php esc_attr_e('Статус', 'woocommerce'); ?>">
                                <span class="wc-account-order-status wc-account-order-status--<?php echo esc_attr($order->get_status()); ?>">
                                    <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
                                </span>
                            </td>
                            <td class="wc-account-orders-table__cell wc-account-orders-table__cell--order-total" data-title="<?php esc_attr_e('Итого', 'woocommerce'); ?>">
                                <?php
                                /* translators: 1: formatted order total 2: total order items */
                                echo wp_kses_post(sprintf(_n('%1$s за %2$s товар', '%1$s за %2$s товара', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count));
                                ?>
                            </td>
                            <td class="wc-account-orders-table__cell wc-account-orders-table__cell--order-actions" data-title="<?php esc_attr_e('Действия', 'woocommerce'); ?>">
                                <?php
                                $actions = wc_get_account_orders_actions($order);

                                if (!empty($actions)) {
                                    foreach ($actions as $key => $action) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                                        echo '<a href="' . esc_url($action['url']) . '" class="wc-account-orders-table__action woocommerce-button button ' . sanitize_html_class($key) . '">' . esc_html($action['name']) . '</a>';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php do_action('woocommerce_before_account_orders_pagination'); ?>

        <?php if (1 < $customer_orders->max_num_pages) : ?>
            <div class="wc-account-pagination woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
                <?php if (1 !== $current_page) : ?>
                    <a class="wc-account-pagination__prev woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                        <?php esc_html_e('Назад', 'woocommerce'); ?>
                    </a>
                <?php endif; ?>

                <?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
                    <a class="wc-account-pagination__next woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>">
                        <?php esc_html_e('Вперед', 'woocommerce'); ?>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

<?php else : ?>
    <div class="wc-account-no-orders">
        <div class="wc-account-no-orders__icon">
            <i class="fa-solid fa-shopping-bag"></i>
        </div>
        <h3 class="wc-account-no-orders__title">
            <?php esc_html_e('У вас пока нет заказов', 'woocommerce'); ?>
        </h3>
        <p class="wc-account-no-orders__text">
            <?php esc_html_e('Когда вы оформите заказ, он появится здесь.', 'woocommerce'); ?>
        </p>
        <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" class="wc-account-btn wc-account-btn--primary">
            <?php esc_html_e('Перейти в каталог', 'woocommerce'); ?>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>

