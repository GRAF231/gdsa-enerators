
<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header();
?>

<main class="main-content error-404-page">
    <div class="container">
        <div class="error-404">
            <div class="error-404__visual">
                <div class="error-404__number">404</div>
                <div class="error-404__icon">
                    <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Генератор с грустным лицом -->
                        <rect x="40" y="60" width="120" height="100" rx="8" fill="url(#generator-gradient)" stroke="#0a1855" stroke-width="3"/>
                        <!-- Панель управления -->
                        <rect x="50" y="70" width="100" height="60" rx="4" fill="#fff" opacity="0.2"/>
                        <!-- Грустные глаза -->
                        <circle cx="75" cy="95" r="8" fill="#0a1855"/>
                        <circle cx="125" cy="95" r="8" fill="#0a1855"/>
                        <!-- Грустный рот -->
                        <path d="M 70 120 Q 100 110 130 120" stroke="#0a1855" stroke-width="3" fill="none" stroke-linecap="round"/>
                        <!-- Ножки генератора -->
                        <rect x="50" y="160" width="20" height="25" rx="4" fill="#3b5fdb"/>
                        <rect x="130" y="160" width="20" height="25" rx="4" fill="#3b5fdb"/>
                        
                        <defs>
                            <linearGradient id="generator-gradient" x1="40" y1="60" x2="160" y2="160" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="#3b5fdb"/>
                                <stop offset="100%" stop-color="#00c2ff"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>

            <div class="error-404__content">
                <h1 class="error-404__title">Страница не найдена</h1>
                <p class="error-404__description">
                    К сожалению, страница которую вы ищете не существует или была перемещена.
                    Возможно, она была удалена или вы ввели неправильный адрес.
                </p>

                <div class="error-404__search">
                    <form role="search" method="get" class="error-404__search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" 
                               class="error-404__search-input" 
                               placeholder="Поиск по сайту..." 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" />
                        <button type="submit" class="error-404__search-button">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" 
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="error-404__actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" 
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        На главную
                    </a>
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn--secondary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" 
                                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        В каталог
                    </a>
                </div>

                <div class="error-404__suggestions">
                    <h2 class="error-404__suggestions-title">Популярные разделы</h2>
                    <ul class="error-404__suggestions-list">
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Каталог электростанций</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('projects'))); ?>">Выполненные проекты</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>">О компании</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('contacts'))); ?>">Контакты</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>

