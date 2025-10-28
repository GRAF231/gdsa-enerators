<?php
/**
 * Related Products
 *
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

// Получаем похожие товары
$related_ids = wc_get_related_products($product->get_id(), 4);

if (empty($related_ids)) {
    return;
}

$args = array(
    'post_type' => 'product',
    'post__in' => $related_ids,
    'posts_per_page' => 4,
    'orderby' => 'post__in'
);

$related_query = new WP_Query($args);

if (!$related_query->have_posts()) {
    return;
}
?>

<div class="product-similar">
    <h2 class="product-similar__title">Похожие товары</h2>
    <p class="product-similar__subtitle">Рекомендуем также рассмотреть эти дизельные электростанции</p>
    
    <div class="similar-grid">
        <?php
        while ($related_query->have_posts()) : $related_query->the_post();
            $related_product = wc_get_product(get_the_ID());
            
            // Получаем ACF поля
            $related_power = get_field('power');
            $related_engine = get_field('engine');
        ?>
            <div class="similar-card">
                <div class="similar-card__image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', ['class' => 'similar-card__img', 'loading' => 'lazy']); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(wc_placeholder_img_src('medium')); ?>" 
                             alt="<?php the_title_attribute(); ?>" 
                             class="similar-card__img">
                    <?php endif; ?>
                    
                    <?php if ($related_product->is_in_stock()) : ?>
                        <div class="similar-card__badge">
                            <span class="similar-card__badge-text">В наличии</span>
                        </div>
                    <?php else : ?>
                        <div class="similar-card__badge similar-card__badge_type_backorder">
                            <span class="similar-card__badge-text">Под заказ</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="similar-card__content">
                    <h3 class="similar-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    
                    <div class="similar-card__specs">
                        <?php if ($related_power) : ?>
                            <div class="similar-card__spec">
                                <span class="similar-card__spec-label">Мощность:</span>
                                <span class="similar-card__spec-value"><?php echo esc_html($related_power); ?> кВт</span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($related_engine) : ?>
                            <div class="similar-card__spec">
                                <span class="similar-card__spec-label">Двигатель:</span>
                                <span class="similar-card__spec-value"><?php echo esc_html($related_engine); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="similar-card__price">
                        <span class="similar-card__price-label">Цена с НДС</span>
                        <span class="similar-card__price-value"><?php echo $related_product->get_price_html(); ?></span>
                    </div>
                    
                    <div class="similar-card__actions">
                        <a href="<?php the_permalink(); ?>" class="btn btn_type_primary similar-card__btn">
                            <i class="fa-solid fa-eye"></i>
                            <span>Подробнее</span>
                        </a>
                        <button class="btn btn_type_secondary similar-card__btn" 
                                type="button" 
                                data-product-id="<?php echo esc_attr($related_product->get_id()); ?>" 
                                onclick="dsaAddToCart(this);">
                            <i class="fa-solid fa-cart-plus"></i>
                            <span>В корзину</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    
    <div class="similar-actions">
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn_type_primary similar-actions__btn">
            <i class="fa-solid fa-th-large"></i>
            <span>Смотреть все дизельные электростанции</span>
        </a>
    </div>
</div>

<?php
wp_reset_postdata();
?>
