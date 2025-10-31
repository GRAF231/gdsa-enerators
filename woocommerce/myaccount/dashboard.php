
<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$current_user = wp_get_current_user();

$allowed_html = array(
    'a' => array(
        'href' => array(),
    ),
);
?>

<div class="wc-account-dashboard">
    <!-- Welcome Section -->
    <div class="wc-account-welcome">
        <div class="wc-account-welcome__icon">
            <i class="fa-solid fa-user-circle"></i>
        </div>
        <div class="wc-account-welcome__content">
            <h2 class="wc-account-welcome__title">
                <?php
                printf(
                    /* translators: 1: user display name */
                    esc_html__('Добро пожаловать, %1$s!', 'woocommerce'),
                    '<strong>' . esc_html($current_user->display_name) . '</strong>'
                );
                ?>
            </h2>
            <p class="wc-account-welcome__text">
                <?php esc_html_e('В вашем личном кабинете вы можете просматривать свои последние заказы, управлять адресами доставки и выставления счетов, а также изменять пароль и данные учетной записи.', 'woocommerce'); ?>
            </p>
        </div>
    </div>

    <!-- Quick Stats -->
    <?php
    $customer_orders = wc_get_orders(array(
        'customer' => get_current_user_id(),
        'limit' => -1,
    ));
    
    $total_orders = count($customer_orders);
    $total_spent = 0;
    $processing_orders = 0;
    
    foreach ($customer_orders as $order) {
        $total_spent += $order->get_total();
        if ($order->get_status() === 'processing') {
            $processing_orders++;
        }
    }
    ?>
    
    <!-- Верхняя строка: 2 карточки -->
    <div class="wc-account-stats wc-account-stats--top">
        <div class="wc-account-stat">
            <div class="wc-account-stat__icon">
                <i class="fa-solid fa-shopping-bag"></i>
            </div>
            <div class="wc-account-stat__content">
                <div class="wc-account-stat__value"><?php echo esc_html($total_orders); ?></div>
                <div class="wc-account-stat__label"><?php esc_html_e('Всего заказов', 'woocommerce'); ?></div>
            </div>
        </div>
        
        <div class="wc-account-stat">
            <div class="wc-account-stat__icon">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div class="wc-account-stat__content">
                <div class="wc-account-stat__value"><?php echo esc_html($processing_orders); ?></div>
                <div class="wc-account-stat__label"><?php esc_html_e('В обработке', 'woocommerce'); ?></div>
            </div>
        </div>
    </div>
    
    <!-- Нижняя строка: Общая сумма на всю ширину -->
    <div class="wc-account-stats wc-account-stats--bottom">
        <div class="wc-account-stat wc-account-stat--total">
            <div class="wc-account-stat__icon">
                <i class="fa-solid fa-ruble-sign"></i>
            </div>
            <div class="wc-account-stat__content">
                <div class="wc-account-stat__value"><?php echo esc_html(dsa_format_price_smart($total_spent)); ?></div>
                <div class="wc-account-stat__label"><?php esc_html_e('Общая сумма', 'woocommerce'); ?></div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="wc-account-actions">
        <h3 class="wc-account-actions__title"><?php esc_html_e('Быстрые действия', 'woocommerce'); ?></h3>
        
        <div class="wc-account-actions__grid">
            <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="wc-account-action">
                <div class="wc-account-action__icon">
                    <i class="fa-solid fa-list"></i>
                </div>
                <div class="wc-account-action__content">
                    <h4 class="wc-account-action__title"><?php esc_html_e('Мои заказы', 'woocommerce'); ?></h4>
                    <p class="wc-account-action__desc"><?php esc_html_e('Просмотр истории заказов', 'woocommerce'); ?></p>
                </div>
                <i class="fa-solid fa-chevron-right wc-account-action__arrow"></i>
            </a>
            
            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="wc-account-action">
                <div class="wc-account-action__icon">
                    <i class="fa-solid fa-map-marker-alt"></i>
                </div>
                <div class="wc-account-action__content">
                    <h4 class="wc-account-action__title"><?php esc_html_e('Адреса', 'woocommerce'); ?></h4>
                    <p class="wc-account-action__desc"><?php esc_html_e('Управление адресами', 'woocommerce'); ?></p>
                </div>
                <i class="fa-solid fa-chevron-right wc-account-action__arrow"></i>
            </a>
            
            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="wc-account-action">
                <div class="wc-account-action__icon">
                    <i class="fa-solid fa-user-edit"></i>
                </div>
                <div class="wc-account-action__content">
                    <h4 class="wc-account-action__title"><?php esc_html_e('Профиль', 'woocommerce'); ?></h4>
                    <p class="wc-account-action__desc"><?php esc_html_e('Редактировать данные', 'woocommerce'); ?></p>
                </div>
                <i class="fa-solid fa-chevron-right wc-account-action__arrow"></i>
            </a>
            
            <a href="<?php echo esc_url(home_url('/shop')); ?>" class="wc-account-action">
                <div class="wc-account-action__icon">
                    <i class="fa-solid fa-shopping-cart"></i>
                </div>
                <div class="wc-account-action__content">
                    <h4 class="wc-account-action__title"><?php esc_html_e('Каталог', 'woocommerce'); ?></h4>
                    <p class="wc-account-action__desc"><?php esc_html_e('Перейти к покупкам', 'woocommerce'); ?></p>
                </div>
                <i class="fa-solid fa-chevron-right wc-account-action__arrow"></i>
            </a>
        </div>
    </div>

    <!-- Recent Orders -->
    <?php if ($customer_orders) : ?>
        <div class="wc-account-recent-orders">
            <h3 class="wc-account-recent-orders__title"><?php esc_html_e('Последние заказы', 'woocommerce'); ?></h3>
            
            <div class="wc-account-orders-table">
                <?php
                $recent_orders = array_slice($customer_orders, 0, 5);
                foreach ($recent_orders as $order) :
                    $item_count = $order->get_item_count();
                    $order_date = $order->get_date_created();
                ?>
                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="wc-account-order-item">
                        <div class="wc-account-order-item__status">
                            <span class="wc-account-order-status wc-account-order-status--<?php echo esc_attr($order->get_status()); ?>">
                                <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
                            </span>
                        </div>
                        <div class="wc-account-order-item__number">
                            <strong><?php esc_html_e('Заказ', 'woocommerce'); ?> #<?php echo esc_html($order->get_order_number()); ?></strong>
                        </div>
                        <div class="wc-account-order-item__date">
                            <?php echo esc_html($order_date->date_i18n('d.m.Y')); ?>
                        </div>
                        <div class="wc-account-order-item__items">
                            <?php
                            printf(
                                /* translators: %s: item count */
                                esc_html(_n('%s товар', '%s товара', $item_count, 'woocommerce')),
                                esc_html($item_count)
                            );
                            ?>
                        </div>
                        <div class="wc-account-order-item__total">
                            <?php echo wp_kses_post($order->get_formatted_order_total()); ?>
                        </div>
                        <i class="fa-solid fa-chevron-right wc-account-order-item__arrow"></i>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <div class="wc-account-recent-orders__footer">
                <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="wc-account-btn wc-account-btn--outline">
                    <?php esc_html_e('Посмотреть все заказы', 'woocommerce'); ?>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <?php
    /**
     * My Account dashboard.
     *
     * @since 2.6.0
     */
    do_action('woocommerce_account_dashboard');

    /**
     * Deprecated woocommerce_before_my_account action.
     *
     * @deprecated 2.6.0
     */
    do_action('woocommerce_before_my_account');

    /**
     * Deprecated woocommerce_after_my_account action.
     *
     * @deprecated 2.6.0
     */
    do_action('woocommerce_after_my_account');
    ?>
</div>

