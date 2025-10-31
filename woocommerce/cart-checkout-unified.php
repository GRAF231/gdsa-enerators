
<?php
/**
 * Template Name: Unified Cart & Checkout
 * Description: Объединенная страница корзины и оформления заказа
 * 
 * @package DSA_Generators
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();
?>

<div class="unified-checkout">
    <div class="container">
        
        <?php
        // Хлебные крошки
        dsa_breadcrumbs();
        
        // Проверяем состояние для определения контента
        $cart_is_empty = WC()->cart->is_empty();
        $is_thank_you = is_wc_endpoint_url('order-received');
        ?>
        
        <!-- Заголовок страницы -->
        <div class="page-header">
            <h1 class="page-header__title">
                <?php 
                if ($is_thank_you) {
                    echo 'Заказ оформлен';
                } else {
                    echo 'Оформление заказа';
                }
                ?>
            </h1>
        </div>
        
        <!-- Индикатор шагов оформления -->
        <div class="checkout-steps">
            <div class="checkout-steps__item checkout-steps__item_active<?php echo $is_thank_you ? ' checkout-steps__item_completed' : ''; ?>">
                <span class="checkout-steps__number">1</span>
                <span class="checkout-steps__label">Корзина</span>
            </div>
            <div class="checkout-steps__separator"></div>
            <div class="checkout-steps__item<?php echo (!$cart_is_empty || $is_thank_you) ? ' checkout-steps__item_active' : ''; ?><?php echo $is_thank_you ? ' checkout-steps__item_completed' : ''; ?>">
                <span class="checkout-steps__number">2</span>
                <span class="checkout-steps__label">Оформление</span>
            </div>
            <div class="checkout-steps__separator"></div>
            <div class="checkout-steps__item<?php echo $is_thank_you ? ' checkout-steps__item_active' : ''; ?>">
                <span class="checkout-steps__number">3</span>
                <span class="checkout-steps__label">Подтверждение</span>
            </div>
        </div>
        
        <?php 
        // Проверка на страницу благодарности (order-received endpoint)
        if (is_wc_endpoint_url('order-received')) :
            // Получаем ID заказа
            global $wp;
            $order_id = isset($wp->query_vars['order-received']) ? absint($wp->query_vars['order-received']) : 0;
            $order = $order_id ? wc_get_order($order_id) : false;
            
            // Подключаем шаблон страницы благодарности
            wc_get_template('checkout/thankyou.php', array('order' => $order));
            
        elseif ($cart_is_empty) : ?>
            
            <!-- Пустая корзина -->
            <div class="cart-empty">
                <div class="cart-empty__icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2 class="cart-empty__title">Ваша корзина пуста</h2>
                <p class="cart-empty__text">Добавьте товары в корзину, чтобы оформить заказ</p>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn_primary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Перейти в каталог</span>
                </a>
            </div>
            
        <?php else : ?>
            
            <!-- Двухколоночный layout: Корзина + Форма -->
            <div class="checkout-grid">
                
                <!-- Левая колонка: Корзина (40%) -->
                <div class="checkout-grid__cart">
                    
                    <!-- Форма корзины для обновления количества -->
                    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                        <?php do_action('woocommerce_before_cart_table'); ?>
                        
                        <div class="checkout-cart">
                            
                            <!-- Заголовок корзины -->
                            <div class="checkout-cart__header">
                                <h2 class="checkout-cart__title">Ваша корзина</h2>
                                <span class="checkout-cart__count">
                                    <?php echo WC()->cart->get_cart_contents_count(); ?> 
                                    <?php echo _n('товар', 'товара', WC()->cart->get_cart_contents_count(), 'dsa-generators'); ?>
                                </span>
                            </div>
                            
                            <!-- Товары корзины -->
                            <?php wc_get_template('cart/cart-items.php'); ?>
                            
                            <!-- Скрытые элементы для автообновления -->
                            <?php do_action('woocommerce_cart_actions'); ?>
                            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                            
                            <?php do_action('woocommerce_after_cart_table'); ?>
                            
                            <!-- Итоговая сумма корзины -->
                            <?php wc_get_template('cart/cart-totals.php'); ?>
                            
                        </div>
                    </form>
                    
                </div>
                
                <!-- Правая колонка: Форма оформления (60%) -->
                <div class="checkout-grid__form">
                    <?php 
                    // Выводим форму оформления заказа
                    echo do_shortcode('[woocommerce_checkout]');
                    ?>
                </div>
                
            </div>
            
        <?php endif; ?>
        
    </div>
</div>

<?php
get_footer();
?>

