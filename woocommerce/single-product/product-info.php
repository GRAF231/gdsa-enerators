<?php
/**
 * Single Product Info (Price, Details, Actions)
 *
 * @package DSA_Generators
 * @version 2.0.0 - Использует WooCommerce атрибуты вместо ACF
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

// Получаем атрибуты WooCommerce
$product_id = $product->get_id();
$country = dsa_get_product_attribute_value($product_id, 'country');
$power = dsa_get_product_attribute_value($product_id, 'power');
$nominal_power = dsa_get_product_attribute_value($product_id, 'nominal_power');
$engine = dsa_get_product_attribute_value($product_id, 'engine');
$engine_country = dsa_get_product_attribute_value($product_id, 'country_engine');
$engine_manufacturer = dsa_get_product_attribute_value($product_id, 'engine_manufacturer');

// Получаем количество товара в корзине
$cart_quantity = dsa_get_cart_item_quantity($product_id);
?>

<div class="product-info">
    <!-- Основные характеристики -->
    <div class="product-details">
        
        <?php if ($country) : ?>
        <div class="product-detail">
            <span class="product-detail__label">Производитель:</span>
            <span class="product-detail__value">DSA GENERATORS (<?php echo esc_html($country); ?>)</span>
        </div>
        <?php endif; ?>
        
        <?php if ($power || $nominal_power) : ?>
        <div class="product-detail">
            <span class="product-detail__label">Номинальная мощность:</span>
            <span class="product-detail__value">
                <?php 
                if ($power) echo esc_html($power) . ' кВт';
                if ($power && $nominal_power) echo ' / ';
                if ($nominal_power) echo esc_html($nominal_power) . ' кВА';
                ?>
            </span>
            <button class="product-detail__help" type="button" aria-label="Подробнее о мощности" title="Подробнее о мощности">
                <i class="fa-solid fa-question-circle"></i>
            </button>
        </div>
        <?php endif; ?>
        
        <?php 
        // Получаем ACF поля максимальной мощности
        $max_power = dsa_get_product_attribute_value($product_id, 'max_power');
        if ($max_power) : 
        ?>
        <div class="product-detail">
            <span class="product-detail__label">Максимальная мощность:</span>
            <span class="product-detail__value"><?php echo esc_html($max_power); ?> кВт</span>
        </div>
        <?php endif; ?>
        
        <?php if ($engine) : ?>
        <div class="product-detail">
            <span class="product-detail__label">Двигатель:</span>
            <span class="product-detail__value">
                <?php 
                echo esc_html($engine);
                if ($engine_country) {
                    echo ' (' . esc_html($engine_country) . ')';
                }
                ?>
            </span>
        </div>
        <?php endif; ?>
        
        <?php 
        // Электрические характеристики из атрибутов
        $voltage = dsa_get_product_attribute_value($product_id, 'voltage');
        $frequency = dsa_get_product_attribute_value($product_id, 'frequency');
        $phases = dsa_get_product_attribute_value($product_id, 'phases');
        
        if ($voltage || $frequency || $phases) : 
        ?>
        <div class="product-detail">
            <span class="product-detail__label">Параметры сети:</span>
            <span class="product-detail__value">
                <?php 
                $params = [];
                if ($voltage) $params[] = esc_html($voltage) . ' В';
                if ($frequency) $params[] = esc_html($frequency);
                if ($phases) $params[] = esc_html($phases);
                echo implode(' / ', $params);
                ?>
            </span>
        </div>
        <?php endif; ?>
        
        <?php 
        // Примечание: Дополнительные опции остаются в ACF,
        // так как они являются индивидуальными для каждого товара (repeater поле)
        // и не подходят для системы атрибутов WooCommerce
        if (have_rows('additional_options')) :
            $options_text = [];
            while (have_rows('additional_options')) : the_row();
                $option_text = get_sub_field('option_text');
                if ($option_text) {
                    // Берем только первые 50 символов для краткости
                    $short_text = wp_trim_words($option_text, 4, '...');
                    $options_text[] = $short_text;
                }
            endwhile;
            
            if (!empty($options_text)) :
        ?>
        <div class="product-detail">
            <span class="product-detail__label">Дополнительные опции:</span>
            <span class="product-detail__value"><?php echo esc_html(implode(' / ', $options_text)); ?></span>
        </div>
        <?php 
            endif;
        endif; 
        ?>
        
    </div>

    <!-- Блок покупки -->
    <div class="product-purchase">
        <!-- Цена -->
        <div class="product-price">
            <span class="product-price__label">Цена с НДС</span>
            <div class="product-price__value">
                <?php echo $product->get_price_html(); ?>
            </div>
        </div>
        
        <!-- Наличие -->
        <div class="product-stock">
            <?php if ($product->is_in_stock()) : ?>
                <i class="fa-solid fa-check-circle"></i>
                <span>в наличии на складе</span>
            <?php elseif ($product->is_on_backorder()) : ?>
                <i class="fa-solid fa-clock"></i>
                <span>доступно под заказ</span>
            <?php else : ?>
                <i class="fa-solid fa-times-circle"></i>
                <span>нет в наличии</span>
            <?php endif; ?>
        </div>
        
        <!-- Кнопки действий -->
        <div class="product-actions">
            <?php 
            /**
             * Форма добавления в корзину
             * Каунтер всегда виден, но кнопка меняется на ссылку если товар уже в корзине
             */
            ?>
            <form class="cart" method="post" enctype="multipart/form-data" data-product-id="<?php echo esc_attr($product_id); ?>">
                <?php
                /**
                 * Каунтер количества - всегда показываем
                 */
                woocommerce_quantity_input(
                    array(
                        'min_value'   => 1,
                        'max_value'   => $product->get_max_purchase_quantity(),
                        'input_value' => $cart_quantity > 0 ? $cart_quantity : 1,
                    ),
                    $product
                );
                ?>
                
                <?php if ($cart_quantity > 0) : ?>
                    <!-- Ссылка "Перейти в корзину" (когда товар уже в корзине) -->
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" 
                       class="btn btn_type_primary product-cart-link"
                       data-product-id="<?php echo esc_attr($product_id); ?>">
                        <i class="fa-solid fa-shopping-cart"></i>
                        <span>Перейти в корзину</span>
                    </a>
                <?php else : ?>
                    <!-- Кнопка "Добавить в корзину" (когда товара нет в корзине) -->
                    <button type="submit" 
                            name="add-to-cart" 
                            value="<?php echo esc_attr($product_id); ?>" 
                            class="single_add_to_cart_button btn btn_type_primary"
                            data-product-id="<?php echo esc_attr($product_id); ?>">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Добавить в корзину</span>
                    </button>
                <?php endif; ?>
            </form>
            
            <!-- Кнопка "Запросить КП" -->
            <button class="btn btn_type_secondary product-btn-quote" type="button" onclick="document.querySelector('.contact-form').scrollIntoView({behavior: 'smooth'});">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Запросить КП</span>
            </button>
        </div>
        
        <?php
        /**
         * Метаданные товара (SKU, категории, теги)
         */
        if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) :
        ?>
        <div class="product-meta">
            <?php if ($product->get_sku()) : ?>
                <span class="product-meta__item">
                    <span class="product-meta__label">Артикул:</span>
                    <span class="product-meta__value"><?php echo esc_html($product->get_sku()); ?></span>
                </span>
            <?php endif; ?>
            
            <?php 
            $categories = wc_get_product_category_list($product->get_id(), ', ');
            if ($categories) :
            ?>
                <span class="product-meta__item">
                    <span class="product-meta__label">Категория:</span>
                    <span class="product-meta__value"><?php echo wp_kses_post($categories); ?></span>
                </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
