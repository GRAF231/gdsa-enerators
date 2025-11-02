<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
// Получаем настройки шапки из ACF
$logo_text = get_field('header_logo_text', 'option') ?: 'DSA GENERATORS';
$tagline = get_field('header_tagline', 'option') ?: 'Производство дизельных электростанций и энерго‑комплексов до 80 МВт';
$phone = get_field('header_phone', 'option') ?: '8 (800) 770‑71‑57';
$phone_link = get_field('header_phone_link', 'option') ?: '+78007707157';
$email = get_field('header_email', 'option') ?: 'order@example.com';
$city = get_field('header_city', 'option') ?: 'Москва';
$address = get_field('header_address', 'option') ?: 'Щербаковская ул., 3';
$worktime = get_field('header_worktime', 'option') ?: 'Пн‑Вс <br> 7:00 – 20:00';
$telegram_url = get_field('header_telegram_url', 'option') ?: 'https://t.me/+79216565959';
$whatsapp_url = get_field('header_whatsapp_url', 'option') ?: 'https://wa.me/79216565959';
$max_url = get_field('header_max_url', 'option') ?: '#';
$cta_text = get_field('header_cta_text', 'option') ?: 'Заказать звонок';
$phone_bar_text = get_field('header_phone_bar_text', 'option') ?: 'Заказ оборудования по телефону:';
?>
    <!-- Шапка сайта -->
    <header class="header" role="banner">
        <div class="header__topbar">
            <div class="container header__topbar-inner">
                <nav class="header__top-nav" aria-label="Сервисная навигация">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-top-menu',
                        'container' => false,
                        'menu_class' => 'header__top-list',
                        'fallback_cb' => false,
                        'walker' => new Header_Top_Menu_Walker()
                    ));
                    ?>
                </nav>
                <div class="header__top-actions">
                    <form class="header__search header__search_place_top" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <label class="sr-only" for="site-search-top">Поиск по сайту</label>
                        <i class="fa-solid fa-magnifying-glass header__search-icon" aria-hidden="true"></i>
                        <input id="site-search-top" class="header__search-input" type="search" name="s" placeholder="Введите фразу для поиска" value="<?php echo get_search_query(); ?>">
                    </form>
                </div>
            </div>
        </div>

        <div class="header__mainbar">
            <div class="container header__mainbar-inner">
                <!-- Бургер меню -->
                <button class="header__burger" type="button" aria-label="Открыть меню" aria-expanded="false">
                    <span class="header__burger-line"></span>
                    <span class="header__burger-line"></span>
                    <span class="header__burger-line"></span>
                </button>
                
                <div class="header__logo">
                    <a href="<?php echo home_url('/'); ?>" class="header__logo-link" aria-label="На главную"><?php echo esc_html($logo_text); ?></a>
                    <p class="header__tagline"><?php echo esc_html($tagline); ?></p>
                </div>

                <!-- Кнопка поиска для мобильной версии -->
                <button class="header__search-mobile-btn" type="button" aria-label="Поиск" aria-expanded="false">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <!-- Мобильная форма поиска -->
                <div class="header__search-mobile-panel">
                    <form class="header__search-mobile-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" 
                               class="header__search-mobile-input" 
                               name="s" 
                               placeholder="Поиск по сайту..." 
                               value="<?php echo get_search_query(); ?>"
                               aria-label="Поиск по сайту">
                        <button type="submit" class="header__search-mobile-submit" aria-label="Найти">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button type="button" class="header__search-mobile-close" aria-label="Закрыть поиск">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                </div>

                <div class="header__contact">
                    <div class="header__location">
                        <div> 
                        <button class="header__location-icon-btn" type="button" aria-label="Выбрать город">
                            <i class="fa-solid fa-location-dot header__icon" aria-hidden="true"></i>
                        </button>
                        <button class="header__city" type="button" aria-haspopup="listbox" aria-expanded="false"><?php echo esc_html($city); ?> <i class="fa-solid fa-caret-down" aria-hidden="true"></i></button>
                    </div>
                        <span class="header__location-address"><?php echo esc_html($address); ?></span>
                    </div>
                    <div class="header__worktime">
                        <i class="fa-regular fa-clock header__icon" aria-hidden="true"></i>
                        <span class="header__mobile-contact-value"><?php echo wp_kses_post($worktime); ?></span>
                    </div>
                    <div class="header__messengers" aria-label="Мессенджеры">
                        <a href="<?php echo esc_url($telegram_url); ?>" class="header__messenger" aria-label="Telegram"><i class="fa-brands fa-telegram"></i></a>
                        <a href="<?php echo esc_url($whatsapp_url); ?>" class="header__messenger" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="<?php echo esc_url($max_url); ?>" class="header__messenger" aria-label="Max"><i class="fa-solid fa-message"></i></a>
                    </div>
                    <div class="header__email">
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="header__email-link">
                            <i class="fa-regular fa-envelope header__icon" aria-hidden="true"></i>
                            <span><?php echo esc_html($email); ?></span>
                        </a>
                    </div>
                   
                </div>

                <div class="header__actions">
                    <div class="header__icons" aria-label="Быстрые действия">
                        <?php if (is_user_logged_in()) : ?>
                            <!-- Личный кабинет для авторизованных пользователей -->
                            <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" 
                               class="header__icon-btn" 
                               aria-label="Личный кабинет">
                                <i class="fa-solid fa-user"></i>
                            </a>
                        <?php else : ?>
                            <!-- Кнопка входа для неавторизованных пользователей -->
                            <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="header__icon-btn header__icon-btn_login" aria-label="Войти">
                                <i class="fa-solid fa-user"></i>
                                <span>Войти</span>
                            </a>
                        <?php endif; ?>
                        
                        <!-- Корзина с мини-корзиной (доступна для всех) -->
                        <div class="header__cart-wrapper">
                            <a href="<?php echo wc_get_cart_url(); ?>" 
                               class="header__icon-btn header__cart-toggle" 
                               aria-label="Корзина"
                               aria-expanded="false"
                               aria-haspopup="true"
                               aria-controls="mini-cart-dropdown">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="header__badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            </a>
                            
                            <!-- Выпадающая мини-корзина -->
                            <div class="mini-cart-dropdown" id="mini-cart-dropdown" role="dialog" aria-label="Мини-корзина">
                                <div class="mini-cart-dropdown-inner">
                                    <?php 
                                    if (function_exists('WC') && WC()->cart) {
                                        get_template_part('template-parts/mini-cart');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header__hotline">
                        <a href="tel:<?php echo esc_attr($phone_link); ?>" class="header__hotline-link" aria-label="Позвонить по телефону <?php echo esc_attr($phone); ?>">
                            <i class="fa-solid fa-phone header__icon" aria-hidden="true"></i>
                            <span class="header__hotline-number"><?php echo esc_html($phone); ?></span>
                        </a>
                        <button class="btn btn_type_primary header__cta" type="button"><?php echo esc_html($cta_text); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Нижняя полоса с телефоном для мобильной версии -->
        <div class="header__phone-bar">
            <div class="container header__phone-bar-inner">
                <span class="header__phone-text"><?php echo esc_html($phone_bar_text); ?></span>
                <a href="tel:<?php echo esc_attr($phone_link); ?>" class="header__phone-number"><?php echo esc_html($phone); ?></a>
            </div>
        </div>

        <!-- Навигационное меню -->
        <div class="header__nav">
            <div class="container header__nav_container">
                <nav aria-label="Основное меню" class="header__nav-inner">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-main-menu',
                        'container' => false,
                        'menu_class' => 'header__menu',
                        'fallback_cb' => false,
                        'walker' => new Header_Main_Menu_Walker()
                    ));
                    ?>
                </nav>
            </div>
        </div>
        
        <!-- Мобильное меню -->
        <div class="header__mobile-menu" id="mobileMenu">
            <button class="header__mobile-close" type="button" aria-label="Закрыть меню">
                <i class="fa-solid fa-times"></i>
            </button>
            <div class="header__mobile-menu-inner">
                <!-- Контактная информация сверху -->
                <div class="header__mobile-contact-info">
                    <div class="header__mobile-contact-row">
                        <div class="header__mobile-contact-item">
                            <div class="header__mobile-contact-label">Выбранный город:</div>
                            <div class="header__mobile-city-info">
                                <span class="header__mobile-city-name">📍 <?php echo esc_html($city); ?> <i class="fa-solid fa-caret-down"></i></span>
                                <div class="header__mobile-city-address"><?php echo esc_html($address); ?></div>
                            </div>
                        </div>
                        <div class="header__mobile-contact-item">
                            <div class="header__mobile-contact-label">Электронная почта:</div>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="header__mobile-email-address"><?php echo esc_html($email); ?></a>
                        </div>
                    </div>
                    <div class="header__mobile-messenger-section">
                        <div class="header__mobile-messenger-label">Запрос в мессенджер:</div>
                        <div class="header__mobile-messenger-icons">
                            <div class="header__mobile-messenger-icon telegram">
                                <i class="fa-brands fa-telegram"></i>
                            </div>
                            <div class="header__mobile-messenger-icon whatsapp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div class="header__mobile-messenger-icon max">
                                <i class="fa-solid fa-message"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <!-- Верхняя навигация -->
                <div class="header__mobile-top-nav">
                    <h3 class="header__mobile-section-title">О компании</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-top-menu',
                        'container' => false,
                        'menu_class' => 'header__mobile-menu-list',
                        'fallback_cb' => false,
                    ));
                    ?>
                </div>
                
                <!-- Основная навигация -->
                <nav class="header__mobile-nav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-main-menu',
                        'container' => false,
                        'menu_class' => 'header__mobile-menu-list',
                        'fallback_cb' => false,
                    ));
                    ?>
                </nav>
                
                <!-- Контакты -->
                <div class="header__mobile-contact">
                    <h3 class="header__mobile-section-title">Контакты</h3>
                    <ul class="header__mobile-contact-list">
                        <li class="header__mobile-contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:<?php echo esc_attr($phone_link); ?>"><?php echo esc_html($phone); ?></a>
                        </li>
                        <li class="header__mobile-contact-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?php echo esc_html($city); ?>, <?php echo esc_html($address); ?></span>
                        </li>
                        <li class="header__mobile-contact-item">
                            <i class="fa-regular fa-clock"></i>
                            <span><?php echo wp_kses_post($worktime); ?></span>
                        </li>
                        <li class="header__mobile-contact-item">
                            <i class="fa-regular fa-envelope"></i>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </li>
                    </ul>
                </div>
                
                <!-- Мессенджеры -->
                <div class="header__mobile-messengers">
                    <h3 class="header__mobile-section-title">Мессенджеры</h3>
                    <div class="header__mobile-messengers-grid">
                        <a href="<?php echo esc_url($telegram_url); ?>" class="header__mobile-messenger-link">
                            <i class="fa-brands fa-telegram"></i>
                            <span>Telegram</span>
                        </a>
                        <a href="<?php echo esc_url($whatsapp_url); ?>" class="header__mobile-messenger-link">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                        <a href="<?php echo esc_url($max_url); ?>" class="header__mobile-messenger-link">
                            <i class="fa-solid fa-message"></i>
                            <span>Max</span>
                        </a>
                    </div>
                </div>
                
              <!-- Быстрые действия -->
              <div class="header__mobile-quick-actions">
                <h3 class="header__mobile-section-title">Быстрые действия</h3>
                <div class="header__mobile-quick-buttons">
                    <?php if (is_user_logged_in()) : ?>
                        <!-- Личный кабинет для авторизованных пользователей -->
                        <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="header__mobile-quick-btn" aria-label="Личный кабинет">
                            <i class="fa-solid fa-user"></i>
                            <span>Личный кабинет</span>
                        </a>
                    <?php else : ?>
                        <!-- Кнопка входа для неавторизованных пользователей -->
                        <a href="<?php echo wc_get_page_permalink('myaccount'); ?>" class="header__mobile-quick-btn header__mobile-quick-btn_login" aria-label="Войти">
                            <i class="fa-solid fa-user"></i>
                            <span>Войти</span>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Корзина (доступна для всех) -->
                    <a href="<?php echo wc_get_cart_url(); ?>" class="header__mobile-quick-btn" aria-label="Корзина">
                        <i class="fa-solid fa-shopping-cart"></i>
                        <span>Корзина (<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
                    </a>
                </div>
                <button class="header__mobile-callback-btn" type="button">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    <span><?php echo esc_html($cta_text); ?></span>
                </button>
              </div>
            </div>
        </div>
    </header>
