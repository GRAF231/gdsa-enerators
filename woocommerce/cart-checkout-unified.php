
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
        ?>
        
        <!-- Заголовок страницы -->
        <div class="page-header">
            <h1 class="page-header__title">Оформление заказа</h1>
        </div>
        
        <!-- Индикатор шагов оформления -->
        <div class="checkout-steps">
            <div class="checkout-steps__item checkout-steps__item_active">
                <span class="checkout-steps__number">1</span>
                <span class="checkout-steps__label">Корзина</span>
            </div>
            <div class="checkout-steps__separator"></div>
            <div class="checkout-steps__item checkout-steps__item_active">
                <span class="checkout-steps__number">2</span>
                <span class="checkout-steps__label">Оформление</span>
            </div>
            <div class="checkout-steps__separator"></div>
            <div class="checkout-steps__item">
                <span class="checkout-steps__number">3</span>
                <span class="checkout-steps__label">Подтверждение</span>
            </div>
        </div>
        
        <?php if (WC()->cart->is_empty()) : ?>
            
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
                        
                        <!-- Итоговая сумма корзины -->
                        <?php wc_get_template('cart/cart-totals.php'); ?>
                        
                    </div>
                </div>
                
                <!-- Правая колонка: Форма оформления (60%) -->
                <div class="checkout-grid__form">
                    <?php woocommerce_checkout(); ?>
                </div>
                
            </div>
            
        <?php endif; ?>
        
    </div>
</div>

<?php
get_footer();
?>

