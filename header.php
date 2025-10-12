<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Шапка сайта -->
    <header class="header" role="banner">
        <div class="header__topbar">
            <div class="container header__topbar-inner">
                <nav class="header__top-nav" aria-label="Сервисная навигация">
                    <ul class="header__top-list">
                        <li class="header__top-item header__top-item_dropdown">
                            <a href="about.html" class="header__top-link">
                                О компании
                                <i class="fa-solid fa-caret-down header__dropdown-icon" aria-hidden="true"></i>
                            </a>
                            <ul class="header__dropdown-menu">
                              
                                <li class="header__dropdown-item">
                                    <a href="contacts.html" class="header__dropdown-link">
                                        <i class="fa-solid fa-address-book header__dropdown-icon" aria-hidden="true"></i>
                                        <span>Контакты</span>
                                    </a>
                                </li>
                            <li class="header__dropdown-item">
                                <a href="tenders.html" class="header__dropdown-link">
                                    <i class="fa-solid fa-gavel header__dropdown-icon" aria-hidden="true"></i>
                                    <span>Тендеры</span>
                                </a>
                            </li>
                            <li class="header__dropdown-item">
                                <a href="gratitude.html" class="header__dropdown-link">
                                    <i class="fa-solid fa-certificate header__dropdown-icon" aria-hidden="true"></i>
                                    <span>Благодарности</span>
                                </a>
                            </li>
                            <li class="header__dropdown-item">
                                <a href="production.html" class="header__dropdown-link">
                                    <i class="fa-solid fa-industry header__dropdown-icon" aria-hidden="true"></i>
                                    <span>Производство</span>
                                </a>
                            </li>
                            </ul>
                        </li>
                        <li class="header__top-item"><a href="projects.html" class="header__top-link">Выполненные проекты</a></li>
                        <li class="header__top-item"><a href="news.html" class="header__top-link">Новости</a></li>
                        <li class="header__top-item"><a href="design-epc.html" class="header__top-link">Проектирование и EPC</a></li>
                    </ul>
                </nav>
                <div class="header__top-actions">
                    <form class="header__search header__search_place_top" role="search">
                        <label class="sr-only" for="site-search-top">Поиск по сайту</label>
                        <i class="fa-solid fa-magnifying-glass header__search-icon" aria-hidden="true"></i>
                        <input id="site-search-top" class="header__search-input" type="search" placeholder="Введите фразу для поиска">
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
                    <a href="index.html" class="header__logo-link" aria-label="На главную">DSA GENERATORS</a>
                    <p class="header__tagline">Производство дизельных электростанций и энерго‑комплексов до 80 МВт</p>
                </div>

                <!-- Кнопка поиска для мобильной версии -->
                <button class="header__search-mobile-btn" type="button" aria-label="Поиск">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <div class="header__contact">
                    <div class="header__location">
                        <div> 
                        <i class="fa-solid fa-location-dot header__icon" aria-hidden="true"></i>
                        <button class="header__city" type="button" aria-haspopup="listbox" aria-expanded="false">Москва <i class="fa-solid fa-caret-down" aria-hidden="true"></i></button>
                    </div>
                        <span class="header__location-address">Щербаковская ул., 3</span>
                    </div>
                    <div class="header__worktime">
                        <i class="fa-regular fa-clock header__icon" aria-hidden="true"></i>
                        <span class="header__mobile-contact-value">Пн‑Вс <br> 7:00 – 20:00</span>
                    </div>
                    <div class="header__messengers" aria-label="Мессенджеры">
                        <a href="https://t.me/+79216565959" class="header__messenger" aria-label="Telegram"><i class="fa-brands fa-telegram"></i></a>
                        <a href="https://wa.me/79216565959" class="header__messenger" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#" class="header__messenger" aria-label="Max"><i class="fa-solid fa-message"></i></a>
                    </div>
                    <div class="header__email">
                        <i class="fa-regular fa-envelope header__icon" aria-hidden="true"></i>
                        <a href="mailto:order@example.com">order@example.com</a>
                    </div>
                   
                </div>

                <div class="header__actions">
                    <div class="header__icons" aria-label="Быстрые действия">
                        <a href="#" class="header__icon-btn" aria-label="Сравнение"><i class="fa-solid fa-chart-column"></i><span class="header__badge">0</span></a>
                        <a href="#" class="header__icon-btn" aria-label="Избранное"><i class="fa-regular fa-heart"></i><span class="header__badge">0</span></a>
                        <a href="#" class="header__icon-btn" aria-label="Корзина"><i class="fa-solid fa-cart-shopping"></i><span class="header__badge">0</span></a>
                    </div>
                    <div class="header__hotline">
                        <i class="fa-solid fa-phone header__icon" aria-hidden="true"></i>
                        <a href="tel:+78007707157" class="header__hotline-number">8 (800) 770‑71‑57</a>
                        <button class="btn btn_type_primary header__cta" type="button">Заказать звонок</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Нижняя полоса с телефоном для мобильной версии -->
        <div class="header__phone-bar">
            <div class="container header__phone-bar-inner">
                <span class="header__phone-text">Заказ оборудования по телефону:</span>
                <a href="tel:+78007707157" class="header__phone-number">8 (800) 770‑71‑57</a>
            </div>
        </div>

        <!-- Навигационное меню -->
        <div class="header__nav">
            <div class="container header__nav_container">
                <nav aria-label="Основное меню" class="header__nav-inner">
                    <ul class="header__menu">
                        <li class="header__menu-item">
                            <a href="#" class="header__menu-link">
                                <i class="fa-solid fa-server"></i>
                                <span>Контейнерные ЦОД</span>
                            </a>
                        </li>
                        <li class="header__menu-item">
                            <a href="catalog-generators.html" class="header__menu-link">
                                <i class="fa-solid fa-industry"></i>
                                <span>Дизельные электростанции</span>
                            </a>
                        </li>
                        <li class="header__menu-item">
                            <a href="#" class="header__menu-link">
                                <i class="fa-solid fa-plug"></i>
                                <span>Энергокомплексы 3‑50 МВт</span>
                            </a>
                        </li>
                        <li class="header__menu-item">
                            <a href="#" class="header__menu-link">
                                <i class="fa-solid fa-box"></i>
                                <span>Контейнеры для ДГУ</span>
                            </a>
                        </li>
                        <li class="header__menu-item">
                            <a href="#" class="header__menu-link">
                                <i class="fa-solid fa-fire"></i>
                                <span>ГПУ</span>
                            </a>
                        </li>
                        <li class="header__menu-item">
                            <a href="#" class="header__menu-link">
                                <i class="fa-solid fa-database"></i>
                                <span>ДЭС для ЦОД</span>
                            </a>
                        </li>
                    </ul>
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
                                <span class="header__mobile-city-name">📍 Москва <i class="fa-solid fa-caret-down"></i></span>
                                <div class="header__mobile-city-address">Щербаковская ул., 3</div>
                            </div>
                        </div>
                        <div class="header__mobile-contact-item">
                            <div class="header__mobile-contact-label">Электронная почта:</div>
                            <a href="mailto:order+59072@tech-expo.ru" class="header__mobile-email-address">order+59072@tech-expo.ru</a>
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
                    <ul class="header__mobile-menu-list">
                        <li class="header__mobile-menu-item">
                            <a href="about.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-info-circle"></i>
                                <span>О нас</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="contacts.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-address-book"></i>
                                <span>Контакты</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="tenders.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-gavel"></i>
                                <span>Тендеры</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="gratitude.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-certificate"></i>
                                <span>Благодарности</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="production.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-industry"></i>
                                <span>Производство</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="projects.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-project-diagram"></i>
                                <span>Выполненные проекты</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="news.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-newspaper"></i>
                                <span>Новости</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                        <a href="design-epc.html" class="header__mobile-menu-link">
                            <i class="fa-solid fa-drafting-compass"></i>
                            <span>Проектирование и EPC</span>
                        </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Основная навигация -->
                <nav class="header__mobile-nav">
                    <!-- <h3 class="header__mobile-section-title">Продукция</h3> -->
                    <ul class="header__mobile-menu-list">
                        <li class="header__mobile-menu-item">
                            <a href="#" class="header__mobile-menu-link">
                                <i class="fa-solid fa-server"></i>
                                <span>Контейнерные ЦОД</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="catalog-generators.html" class="header__mobile-menu-link">
                                <i class="fa-solid fa-industry"></i>
                                <span>Дизельные электростанции</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="#" class="header__mobile-menu-link">
                                <i class="fa-solid fa-plug"></i>
                                <span>Энергокомплексы 3‑50 МВт</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="#" class="header__mobile-menu-link">
                                <i class="fa-solid fa-box"></i>
                                <span>Контейнеры для ДГУ</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="#" class="header__mobile-menu-link">
                                <i class="fa-solid fa-fire"></i>
                                <span>ГПУ</span>
                            </a>
                        </li>
                        <li class="header__mobile-menu-item">
                            <a href="#" class="header__mobile-menu-link">
                                <i class="fa-solid fa-database"></i>
                                <span>ДЭС для ЦОД</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Контакты -->
                <div class="header__mobile-contact">
                    <h3 class="header__mobile-section-title">Контакты</h3>
                    <ul class="header__mobile-contact-list">
                        <li class="header__mobile-contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:+78007707157">8 (800) 770‑71‑57</a>
                        </li>
                        <li class="header__mobile-contact-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Москва, Щербаковская ул., 3</span>
                        </li>
                        <li class="header__mobile-contact-item">
                            <i class="fa-regular fa-clock"></i>
                            <span>Пн‑Вс 7:00 – 20:00</span>
                        </li>
                        <li class="header__mobile-contact-item">
                            <i class="fa-regular fa-envelope"></i>
                            <a href="mailto:order@example.com">order@example.com</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Мессенджеры -->
                <div class="header__mobile-messengers">
                    <h3 class="header__mobile-section-title">Мессенджеры</h3>
                    <div class="header__mobile-messengers-grid">
                        <a href="https://t.me/+79216565959" class="header__mobile-messenger-link">
                            <i class="fa-brands fa-telegram"></i>
                            <span>Telegram</span>
                        </a>
                        <a href="https://wa.me/79216565959" class="header__mobile-messenger-link">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                        <a href="#" class="header__mobile-messenger-link">
                            <i class="fa-solid fa-message"></i>
                            <span>Max</span>
                        </a>
                    </div>
                </div>
                
              <!-- Быстрые действия -->
              <div class="header__mobile-quick-actions">
                <h3 class="header__mobile-section-title">Быстрые действия</h3>
                <div class="header__mobile-quick-buttons">
                    <button class="header__mobile-quick-btn" type="button" aria-label="Сравнение">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Сравнение</span>
                    </button>
                    <button class="header__mobile-quick-btn" type="button" aria-label="Избранное">
                        <i class="fa-solid fa-heart"></i>
                        <span>Избранное</span>
                    </button>
                    <button class="header__mobile-quick-btn" type="button" aria-label="Корзина">
                        <i class="fa-solid fa-shopping-cart"></i>
                        <span>Корзина</span>
                    </button>
                </div>
                <button class="header__mobile-callback-btn" type="button">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    <span>Заказать звонок</span>
                </button>
            </div>
            
            </div>
        </div>
    </header>
    <main class="main-content">
