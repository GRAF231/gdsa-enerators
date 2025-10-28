
<?php
/**
 * Cart Items Template
 * Отображает список товаров в корзине
 * 
 * @package DSA_Generators
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_cart_contents');
?>

<div class="cart-items">
    
    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
            
            <div class="cart-item" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
                
                <!-- Изображение товара -->
                <div class="cart-item__image">
                    <?php
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    
                    if (!$product_permalink) {
                        echo $thumbnail;
                    } else {
                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                    }
                    ?>
                </div>
                
                <!-- Информация о товаре -->
                <div class="cart-item__info">
                    
                    <!-- Название товара -->
                    <div class="cart-item__name">
                        <?php
                        if (!$product_permalink) {
                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key));
                        } else {
                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                        }
                        ?>
                    </div>
                    
                    <!-- Дополнительные данные (вариации, атрибуты) -->
                    <?php
                    echo wc_get_formatted_cart_item_data($cart_item);
                    
                    // Backorder notification
                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                    }
                    ?>
                    
                    <!-- Цена за единицу -->
                    <div class="cart-item__unit-price">
                        <span class="cart-item__unit-price-label">Цена:</span>
                        <span class="cart-item__unit-price-value">
                            <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                        </span>
                    </div>
                    
                </div>
                
                <!-- Контролы количества и цены -->
                <div class="cart-item__actions">
                    
                    <!-- Количество товара -->
                    <div class="cart-item__quantity">
                        <?php
                        if ($_product->is_sold_individually()) {
                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                        } else {
                            $product_quantity = woocommerce_quantity_input(
                                array(
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                    'min_value'    => '0',
                                    'product_name' => $_product->get_name(),
                                ),
                                $_product,
                                false
                            );
                        }

                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                        ?>
                    </div>
                    
                    <!-- Общая цена за товар -->
                    <div class="cart-item__total">
                        <span class="cart-item__total-label">Сумма:</span>
                        <span class="cart-item__total-value">
                            <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                        </span>
                    </div>
                    
                    <!-- Кнопка удаления -->
                    <div class="cart-item__remove">
                        <?php
                        echo apply_filters(
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="cart-item__remove-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-cart_item_key="%s">
                                    <i class="fas fa-trash-alt"></i>
                                </a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_html__('Remove this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($_product->get_sku()),
                                esc_attr($cart_item_key)
                            ),
                            $cart_item_key
                        );
                        ?>
                    </div>
                    
                </div>
                
            </div>
            
        <?php endif;
    endforeach; ?>
    
</div>

<?php do_action('woocommerce_after_cart_contents'); ?>

