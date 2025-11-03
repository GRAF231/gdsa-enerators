    <!-- Подвал -->
    <footer class="page-footer">
        <div class="container">
            <div class="footer__hero">
                <div class="footer__hero-content">
                    <div class="footer__logo-section">
                        <div class="footer__logo-wrapper">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="footer__logo-link">
                                <span class="footer__logo-text"><?php echo esc_html(get_field('footer_logo_text', 'option') ?: 'DSA'); ?></span>
                                <span class="footer__logo-accent"><?php echo esc_html(get_field('footer_logo_accent', 'option') ?: 'GENERATORS'); ?></span>
                            </a>
                        </div>
                        <p class="footer__tagline"><?php echo esc_html(get_field('footer_tagline', 'option') ?: 'Производство дизельных электростанций и проектирование систем энергоснабжения'); ?></p>
                    </div>
                    
                    <div class="footer__contact-highlight">
                        <div class="footer__contact-item">
                            <i class="fa-solid fa-phone footer__icon-accent"></i>
                            <div class="footer__contact-info">
                                <span class="footer__contact-label"><?php echo esc_html(get_field('footer_hotline_label', 'option') ?: 'Горячая линия'); ?></span>
                                <a href="tel:<?php echo esc_attr(get_field('header_phone_link', 'option') ?: '+78007707157'); ?>" class="footer__contact-value">
                                    <?php echo esc_html(get_field('header_phone', 'option') ?: '8 (800) 770‑71‑57'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="footer__contact-item">
                            <i class="fa-regular fa-clock footer__icon-accent"></i>
                            <div class="footer__contact-info">
                                <span class="footer__contact-label"><?php echo esc_html(get_field('footer_worktime_label', 'option') ?: 'Время работы'); ?></span>
                                <span class="footer__contact-value"><?php echo esc_html(get_field('footer_worktime_value', 'option') ?: 'Пн-Вс 7:00 - 20:00'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__main">
                <div class="footer__grid">
                
                    <div class="footer__section footer__section_left">
                        <div class="footer__nav-section">
                            <h3 class="footer__section-title">
                                <i class="fa-solid fa-compass footer__title-icon"></i>
                                Навигация
                            </h3>
                            <div class="footer__nav-grid">
                                <div class="footer__nav-group">
                                    <h4 class="footer__nav-subtitle">Продукция</h4>
                                    <?php
                                    if (has_nav_menu('footer-products-menu')) {
                                        wp_nav_menu(array(
                                            'theme_location' => 'footer-products-menu',
                                            'container'      => false,
                                            'menu_class'     => 'footer__nav-list',
                                            'fallback_cb'    => false,
                                            'walker'         => new Footer_Menu_Walker(),
                                        ));
                                    } else {
                                        // Fallback если меню не создано
                                        echo '<ul class="footer__nav-list">';
                                        echo '<li><a href="#" class="footer__nav-link">Дизельные электростанции</a></li>';
                                        echo '<li><a href="#" class="footer__nav-link">Энергокомплексы 3‑50 МВт</a></li>';
                                        echo '<li><a href="#" class="footer__nav-link">Контейнеры для ДГУ</a></li>';
                                        echo '<li><a href="#" class="footer__nav-link">ГПУ</a></li>';
                                        echo '</ul>';
                                    }
                                    ?>
                                </div>
                                <div class="footer__nav-group">
                                    <h4 class="footer__nav-subtitle">Услуги</h4>
                                    <?php
                                    if (has_nav_menu('footer-services-menu')) {
                                        wp_nav_menu(array(
                                            'theme_location' => 'footer-services-menu',
                                            'container'      => false,
                                            'menu_class'     => 'footer__nav-list',
                                            'fallback_cb'    => false,
                                            'walker'         => new Footer_Menu_Walker(),
                                        ));
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="footer__cert-section">
                            <h3 class="footer__section-title">
                                <i class="fa-solid fa-certificate footer__title-icon"></i>
                                Сертификаты
                            </h3>
                            <div class="footer__cert-grid">
                                <?php
                                $certificates = get_field('footer_certificates', 'option');
                                if ($certificates && is_array($certificates)) {
                                    foreach ($certificates as $cert) {
                                        echo '<div class="footer__cert-item">';
                                        echo '<i class="fa-solid fa-check-circle footer__cert-icon"></i>';
                                        echo '<span>' . esc_html($cert['cert_text']) . '</span>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

           
                    <div class="footer__section footer__section_center">
                        <div class="footer__requisites-section">
                            <h3 class="footer__section-title">
                                <i class="fa-solid fa-building footer__title-icon"></i>
                                Реквизиты
                            </h3>
                            <div class="footer__requisites-card">
                                <div class="footer__requisites-header">
                                    <i class="fa-solid fa-shield-alt footer__card-icon"></i>
                                    <span><?php echo esc_html(get_field('footer_company_name', 'option') ?: 'ООО «DSA Generators»'); ?></span>
                                </div>
                                <div class="footer__requisites-details">
                                    <div class="footer__requisites-row">
                                        <span class="footer__requisites-label">ИНН:</span>
                                        <span class="footer__requisites-value"><?php echo esc_html(get_field('footer_inn', 'option') ?: '7840490040'); ?></span>
                                    </div>
                                    <div class="footer__requisites-row">
                                        <span class="footer__requisites-label">КПП:</span>
                                        <span class="footer__requisites-value"><?php echo esc_html(get_field('footer_kpp', 'option') ?: '784201001'); ?></span>
                                    </div>
                                    <div class="footer__requisites-row">
                                        <span class="footer__requisites-label">ОГРН:</span>
                                        <span class="footer__requisites-value"><?php echo esc_html(get_field('footer_ogrn', 'option') ?: '1137847211886'); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="footer__documents">
                                <?php 
                                $requisites_link = get_field('footer_requisites_link', 'option');
                                $licenses_link = get_field('footer_licenses_link', 'option');
                                ?>
                                <a href="<?php echo esc_url($requisites_link ?: '#'); ?>" class="footer__document-link" <?php echo $requisites_link ? 'download' : ''; ?>>
                                    <i class="fa-solid fa-download footer__link-icon"></i>
                                    <span>Скачать реквизиты</span>
                                </a>
                                <a href="<?php echo esc_url($licenses_link ?: '#'); ?>" class="footer__document-link">
                                    <i class="fa-solid fa-file-alt footer__link-icon"></i>
                                    <span>Лицензии компании</span>
                                </a>
                            </div>
                        </div>
                    </div>

                  
                    <div class="footer__section footer__section_right">
                        <div class="footer__contacts-section">
                            <h3 class="footer__section-title">
                                <i class="fa-solid fa-address-book footer__title-icon"></i>
                                Контакты
                            </h3>
                            <div class="footer__contact-cards">
                                <div class="footer__contact-card">
                                    <div class="footer__contact-icon-wrapper">
                                        <i class="fa-solid fa-location-dot footer__contact-icon"></i>
                                    </div>
                                    <div class="footer__contact-content">
                                        <h4 class="footer__contact-title">Адрес</h4>
                                        <p class="footer__contact-text">
                                            <?php 
                                            $city = get_field('header_city', 'option') ?: 'Москва';
                                            $address = get_field('header_address', 'option') ?: 'Щербаковская ул., 3';
                                            echo esc_html($city . ', ' . $address);
                                            ?>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="footer__contact-card">
                                    <div class="footer__contact-icon-wrapper">
                                        <i class="fa-regular fa-envelope footer__contact-icon"></i>
                                    </div>
                                    <div class="footer__contact-content">
                                        <h4 class="footer__contact-title">Email</h4>
                                        <a href="mailto:<?php echo esc_attr(get_field('header_email', 'option') ?: 'order@example.com'); ?>" class="footer__contact-text">
                                            <?php echo esc_html(get_field('header_email', 'option') ?: 'order@example.com'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="footer__social-section">
                            <h3 class="footer__section-title">
                                <i class="fa-solid fa-share-alt footer__title-icon"></i>
                                Мы в соцсетях
                            </h3>
                            <div class="footer__social-grid">
                                <?php 
                                $vk_url = get_field('footer_vk_url', 'option') ?: '#';
                                $telegram_url = get_field('footer_telegram_url', 'option') ?: '#';
                                $max_url = get_field('footer_max_url', 'option') ?: '#';
                                ?>
                                <a href="<?php echo esc_url($vk_url); ?>" class="footer__social-card footer__social_vk" aria-label="ВКонтакте">
                                    <div class="footer__social-icon">
                                        <i class="fa-brands fa-vk"></i>
                                    </div>
                                    <span class="footer__social-name">ВКонтакте</span>
                                </a>
                                <a href="<?php echo esc_url($telegram_url); ?>" class="footer__social-card footer__social_telegram" aria-label="Telegram">
                                    <div class="footer__social-icon">
                                        <i class="fa-brands fa-telegram"></i>
                                    </div>
                                    <span class="footer__social-name">Telegram</span>
                                </a>
                                <a href="<?php echo esc_url($max_url); ?>" class="footer__social-card footer__social_max" aria-label="Max">
                                    <div class="footer__social-icon">
                                        <i class="fa-solid fa-message"></i>
                                    </div>
                                    <span class="footer__social-name">Max</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="footer__bottom-content">
                    <div class="footer__legal-info">
                        <p><?php echo esc_html(get_field('footer_legal_text1', 'option') ?: 'Информация, изложенная на сайте, не является публичной офертой.'); ?></p>
                        <p><?php echo esc_html(get_field('footer_legal_text2', 'option') ?: 'Заполняя любую форму на сайте dsa-generators.ru, вы даете согласие на обработку персональных данных.'); ?></p>
                    </div>
                    <div class="footer__bottom-divider"></div>
                    <p class="footer__copyright"><?php echo esc_html(get_field('footer_copyright', 'option') ?: '© 2016-2025 ООО «DSA Generators». Все права защищены.'); ?></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Модальное окно обратного звонка -->
    <div class="callback-modal" id="callbackModal" role="dialog" aria-labelledby="callbackModalTitle" aria-hidden="true">
        <div class="callback-modal__overlay"></div>
        <div class="callback-modal__container">
            <button class="callback-modal__close" type="button" aria-label="Закрыть модальное окно">
                <i class="fa-solid fa-times"></i>
            </button>
            <div class="callback-modal__content">
                <div class="callback-modal__header">
                    <div class="callback-modal__icon">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <h2 class="callback-modal__title" id="callbackModalTitle">Заказать звонок</h2>
                    <p class="callback-modal__subtitle">Оставьте свой номер телефона и мы перезвоним вам в течение 15 минут</p>
                </div>
                
                <?php echo do_shortcode('[contact-form-7 id="765d8f7" title="Заказать звонок"]'); ?>
                
                <!-- Сообщение об успешной отправке -->
                <div class="callback-modal__success" id="callbackSuccess" style="display: none;">
                    <div class="callback-modal__success-icon">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                    <h3 class="callback-modal__success-title">Заявка отправлена!</h3>
                    <p class="callback-modal__success-text">Мы свяжемся с вами в ближайшее время</p>
                    <button type="button" class="btn btn_type_primary" onclick="closeCallbackModal()">
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
