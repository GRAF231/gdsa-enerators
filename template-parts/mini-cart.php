<?php
/**
 * Template: Mini Cart Widget
 * Description: Выпадающий виджет мини-корзины в header
 * 
 * @package DSA_Generators
 * @since 1.0
 */

// Проверка безопасности
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Проверяем существование WooCommerce и корзины
if (!class_exists('WooCommerce') || !WC()->cart) {
    return;
}

// Получаем товары из корзины
$cart_items = WC()->cart->get_cart();
$cart_count = WC()->cart->get_cart_contents_count();
$is_empty = WC()->cart->is_empty();

?>

<?php if ($is_empty): ?>
    <!-- Пустая корзина -->
    <div class="mini-cart__empty">
        <i class="fa-solid fa-cart-shopping"></i>
        <p>Ваша корзина пуста</p>
        <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="btn btn_type_outline">
            Перейти в каталог
        </a>
    </div>
<?php else: ?>
    <!-- Мини-корзина с товарами -->
    <div class="mini-cart">
        <!-- Заголовок -->
        <div class="mini-cart__header">
            <h3>Корзина (<?php echo $cart_count; ?> <?php echo _n('товар', 'товара', $cart_count, 'dsa-generators'); ?>)</h3>
            <button class="mini-cart__close" aria-label="Закрыть">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <!-- Список товаров -->
        <div class="mini-cart__items">
            <?php foreach ($cart_items as $cart_item_key => $cart_item): ?>
                <?php
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                    
                    if (!$_product || !$_product->exists() || $cart_item['quantity'] == 0 || !apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        continue;
                    }
                    
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    
                    // Получаем характеристики для отображения
                    $power = '';
                    if (function_exists('dsa_get_product_attribute_value')) {
                        $power = dsa_get_product_attribute_value($product_id, 'power');
                    }
                ?>
                
                <div class="mini-cart__item" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
                    <!-- Миниатюра -->
                    <div class="mini-cart__item-image">
                        <?php echo $thumbnail; ?>
                    </div>
                    
                    <!-- Информация о товаре -->
                    <div class="mini-cart__item-info">
                        <h4 class="mini-cart__item-name">
                            <?php echo esc_html($product_name); ?>
                        </h4>
                        
                        <?php if ($power): ?>
                            <div class="mini-cart__item-meta">
                                Мощность: <?php echo esc_html($power); ?> кВт
                            </div>
                        <?php endif; ?>
                        
                        <div class="mini-cart__item-price">
                            <?php echo $cart_item['quantity']; ?> × 
                            <?php echo $product_price; ?>
                        </div>
                    </div>
                    
                    <!-- Кнопка удаления -->
                    <button class="mini-cart__item-remove" 
                            data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>"
                            aria-label="Удалить <?php echo esc_attr($product_name); ?>">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Футер с итоговой суммой и кнопками -->
        <div class="mini-cart__footer">
            <!-- Итоговая сумма -->
            <div class="mini-cart__total">
                <span>Итого:</span>
                <span class="mini-cart__total-amount"><?php echo WC()->cart->get_cart_total(); ?></span>
            </div>
            
            <!-- Кнопка "Перейти в корзину" -->
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" 
               class="btn btn_type_primary mini-cart__checkout">
                Перейти в корзину
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
<?php endif; ?>
