
<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="woocommerce-no-products-found">
    <div class="no-products-message">
        <h2 class="no-products-message__title">Товары не найдены</h2>
        <p class="no-products-message__description">
            К сожалению, по вашему запросу ничего не найдено. 
            Попробуйте изменить параметры фильтрации или воспользуйтесь другими разделами каталога.
        </p>
        
        <div class="no-products-message__actions">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn--primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M4 7H20M10 11V17M14 11V17M5 7L6 19C6 19.5304 6.21071 20.0391 6.58579 20.4142C6.96086 20.7893 7.46957 21 8 21H16C16.5304 21 17.0391 20.7893 17.4142 20.4142C17.7893 20.0391 18 19.5304 18 19L19 7M9 7V4C9 3.73478 9.10536 3.48043 9.29289 3.29289C9.48043 3.10536 9.73478 3 10 3H14C14.2652 3 14.5196 3.10536 14.7071 3.29289C14.8946 3.48043 15 3.73478 15 4V7" 
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Сбросить фильтры
            </a>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--secondary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" 
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                На главную
            </a>
        </div>
        
        <?php
        // Показываем популярные категории если они есть
        $product_categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => 5
        ));
        
        if (!empty($product_categories) && !is_wp_error($product_categories)) :
        ?>
        <div class="no-products-suggestions">
            <h3 class="no-products-suggestions__title">Популярные категории</h3>
            <ul class="no-products-suggestions__list">
                <?php foreach ($product_categories as $category) : ?>
                    <li>
                        <a href="<?php echo esc_url(get_term_link($category)); ?>">
                            <?php echo esc_html($category->name); ?>
                            <span class="count">(<?php echo esc_html($category->count); ?>)</span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>

