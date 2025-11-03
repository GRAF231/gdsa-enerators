<?php
/**
 * Template Part: Licenses Block
 * Универсальный блок лицензий компании
 * Данные берутся из настроек сайта (ACF Options Page)
 * 
 * Использование: get_template_part('template-parts/licenses-block');
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Получаем данные из настроек сайта
$licenses_title = get_field('licenses_title', 'option') ?: 'ЛИЦЕНЗИИ';
$licenses = get_field('licenses_list', 'option');
?>

<section class="section about-licenses" id="licenses">
    <div class="about-licenses__container">
        <div class="about-licenses__header">
            <div class="about-licenses__title-group">
                <h2 class="about-licenses__title"><?php echo esc_html($licenses_title); ?></h2>
                <!-- <h3 class="about-licenses__subtitle">КОМПАНИИ</h3> -->
            </div>
            <div class="about-licenses__description">
                <span class="about-licenses__desc-text">СЕРТИФИКАТЫ</span>
                <span class="about-licenses__desc-text">КАЧЕСТВА И</span>
                <!-- <span class="about-licenses__desc-text">И</span> -->
                <span class="about-licenses__desc-text">СООТВЕТСТВИЯ</span>
            </div>
        </div>
        
        <div class="about-licenses__grid">
            <?php 
            if ($licenses && is_array($licenses)) :
                foreach ($licenses as $license) :
            ?>
            <!-- Карточка лицензии -->
            <div class="about-licenses__item" 
                 data-modal-image="<?php echo esc_url($license['license_image']['url'] ?? ''); ?>"
                 data-modal-title="<?php echo esc_attr($license['license_title']); ?>">
                <div class="about-licenses__item-image">
                  
                    <?php if (!empty($license['license_image'])) : ?>
                        <img src="<?php echo esc_url($license['license_image']['url']); ?>" 
                             alt="<?php echo esc_attr($license['license_image']['alt'] ?: $license['license_title']); ?>" 
                             class="about-licenses__img">
                    <?php else : ?>
                        <i class="<?php echo esc_attr($license['license_icon'] ?: 'fa-solid fa-certificate'); ?>"></i>
                    <?php endif; ?>
                </div>
                <div class="about-licenses__item-content">
                    <h4 class="about-licenses__item-title"><?php echo esc_html($license['license_title']); ?></h4>
                    <div class="about-licenses__item-specs">
                        <?php if (!empty($license['license_spec1'])) : ?>
                            <span class="about-licenses__spec"><?php echo esc_html($license['license_spec1']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($license['license_spec2'])) : ?>
                            <span class="about-licenses__spec"><?php echo esc_html($license['license_spec2']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="about-licenses__item-status">
                        <span class="about-licenses__status"><?php echo esc_html($license['license_status'] ?: 'Действующий'); ?></span>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div> 
    </div> 
</section>
 