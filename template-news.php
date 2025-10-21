<?php
/**
 * Template Name: Новости
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

    <!-- Основной контент -->
    <main class="">
        

        <!-- Заголовок страницы -->
        <header class="page-header">
            <div class="container">
                <h1 class="page-header__title">Новости и события</h1>
                <p class="page-header__subtitle">Актуальная информация о нашей компании, новых продуктах и проектах</p>
            </div>
        </header>

        <!-- Фильтры новостей -->
        <section class="news-filters">
            <div class="container">
                <div class="news-filters__tabs">
                    <button class="news-filters__tab news-filters__tab_active" data-filter="all">
                        Все новости
                    </button>
                    <button class="news-filters__tab" data-filter="company">
                        О компании
                    </button>
                    <button class="news-filters__tab" data-filter="products">
                        Продукция
                    </button>
                    <button class="news-filters__tab" data-filter="projects">
                        Проекты
                    </button>
                    <button class="news-filters__tab" data-filter="events">
                        События
                    </button>
                </div>
            </div>
        </section>

        <!-- Новости -->
        <section class="news-grid">
            <div class="container">
                <div class="news-grid__items">
                    <!-- Новость 1 -->
                    <article class="news-card" data-category="company">
                        <div class="news-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="Расширение производственных мощностей" loading="lazy">
                            <div class="news-card__category">О компании</div>
                        </div>
                        <div class="news-card__content">
                            <div class="news-card__meta">
                                <time class="news-card__date" datetime="2024-12-15">15 декабря 2024</time>
                                <span class="news-card__views">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    1,234
                                </span>
                            </div>
                            <h3 class="news-card__title">Расширение производственных мощностей DSA Generators</h3>
                            <p class="news-card__excerpt">Компания DSA Generators объявляет о запуске нового производственного цеха, что позволит увеличить объемы выпуска дизельных электростанций на 40%.</p>
                            <a href="#" class="news-card__link">Читать далее</a>
                        </div>
                    </article>

                    <!-- Новость 2 -->
                    <article class="news-card" data-category="products">
                        <div class="news-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="Новая линейка генераторов" loading="lazy">
                            <div class="news-card__category">Продукция</div>
                        </div>
                        <div class="news-card__content">
                            <div class="news-card__meta">
                                <time class="news-card__date" datetime="2024-12-10">10 декабря 2024</time>
                                <span class="news-card__views">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    2,567
                                </span>
                            </div>
                            <h3 class="news-card__title">Презентация новой линейки генераторов Cummins</h3>
                            <p class="news-card__excerpt">Представляем новую серию дизельных генераторов Cummins с улучшенными характеристиками энергоэффективности и экологичности.</p>
                            <a href="#" class="news-card__link">Читать далее</a>
                        </div>
                    </article>

                    <!-- Новость 3 -->
                    <article class="news-card" data-category="projects">
                        <div class="news-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="Завершение проекта в Сочи" loading="lazy">
                            <div class="news-card__category">Проекты</div>
                        </div>
                        <div class="news-card__content">
                            <div class="news-card__meta">
                                <time class="news-card__date" datetime="2024-12-05">5 декабря 2024</time>
                                <span class="news-card__views">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    3,891
                                </span>
                            </div>
                            <h3 class="news-card__title">Завершен проект энергоснабжения отеля в Сочи</h3>
                            <p class="news-card__excerpt">Успешно завершена поставка и монтаж шести ДГУ общей мощностью 8,8 МВт для премиального отеля в Сочи.</p>
                            <a href="#" class="news-card__link">Читать далее</a>
                        </div>
                    </article>

                    <!-- Новость 4 -->
                    <article class="news-card" data-category="events">
                        <div class="news-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="Участие в выставке" loading="lazy">
                            <div class="news-card__category">События</div>
                        </div>
                        <div class="news-card__content">
                            <div class="news-card__meta">
                                <time class="news-card__date" datetime="2024-11-28">28 ноября 2024</time>
                                <span class="news-card__views">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    1,756
                                </span>
                            </div>
                            <h3 class="news-card__title">DSA Generators на выставке "Энергетика и электротехника"</h3>
                            <p class="news-card__excerpt">Компания приняла участие в крупнейшей отраслевой выставке, представив инновационные решения в области энергоснабжения.</p>
                            <a href="#" class="news-card__link">Читать далее</a>
                        </div>
                    </article>

                    <!-- Новость 5 -->
                    <article class="news-card" data-category="company">
                        <div class="news-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="Сертификация ISO" loading="lazy">
                            <div class="news-card__category">О компании</div>
                        </div>
                        <div class="news-card__content">
                            <div class="news-card__meta">
                                <time class="news-card__date" datetime="2024-11-20">20 ноября 2024</time>
                                <span class="news-card__views">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    987
                                </span>
                            </div>
                            <h3 class="news-card__title">Получена сертификация ISO 9001:2015</h3>
                            <p class="news-card__excerpt">DSA Generators успешно прошла сертификацию системы менеджмента качества по международному стандарту ISO 9001:2015.</p>
                            <a href="#" class="news-card__link">Читать далее</a>
                        </div>
                    </article>

                    <!-- Новость 6 -->
                    <article class="news-card" data-category="products">
                        <div class="news-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="Новые контейнеры" loading="lazy">
                            <div class="news-card__category">Продукция</div>
                        </div>
                        <div class="news-card__content">
                            <div class="news-card__meta">
                                <time class="news-card__date" datetime="2024-11-15">15 ноября 2024</time>
                                <span class="news-card__views">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                    2,134
                                </span>
                            </div>
                            <h3 class="news-card__title">Запуск производства контейнерных ДГУ</h3>
                            <p class="news-card__excerpt">Начато производство новых контейнерных дизельных генераторных установок с улучшенной звукоизоляцией и климат-контролем.</p>
                            <a href="#" class="news-card__link">Читать далее</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Пагинация -->
        <div class="container">
            <div class="pagination">
                <!-- Показывать по -->
                <div class="pagination__per-page">
                    <span class="pagination__per-page-label">Выводить по:</span>
                    <div class="pagination__per-page-buttons">
                        <button class="pagination__per-page-btn" type="button">6</button>
                        <button class="pagination__per-page-btn pagination__per-page-btn_active" type="button">12</button>
                        <button class="pagination__per-page-btn" type="button">24</button>
                        <button class="pagination__per-page-btn" type="button">48</button>
                    </div>
                </div>
                <div class="pagination__nav">
                    <button class="pagination__btn pagination__btn_prev" type="button" disabled>
                        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                        <span>Предыдущая</span>
                    </button>
                    <div class="pagination__pages">
                        <button class="pagination__page pagination__page_active" type="button">1</button>
                        <button class="pagination__page" type="button">2</button>
                        <button class="pagination__page" type="button">3</button>
                        <span class="pagination__dots">...</span>
                        <button class="pagination__page" type="button">8</button>
                    </div>
                    <button class="pagination__btn pagination__btn_next" type="button">
                        <span>Следующая</span>
                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Форма обратной связи -->
        <section class="news-contact">
            <div class="container">
                <div class="contact-form">
                    <h2 class="contact-form__title">Подпишитесь на наши новости</h2>
                    <p class="contact-form__subtitle">Получайте актуальную информацию о новых продуктах, проектах и событиях компании</p>
                    <form class="contact-form__form">
                        <div class="contact-form__fields">
                            <div class="contact-form__column">
                                <div class="form-group">
                                    <label for="news-name" class="form-label">Имя</label>
                                    <input type="text" id="news-name" class="form-input" placeholder="Введите ваше имя" required>
                                </div>
                                <div class="form-group">
                                    <label for="news-email" class="form-label">E-mail</label>
                                    <input type="email" id="news-email" class="form-input" placeholder="Введите ваш email" required>
                                </div>
                                <div class="form-group">
                                    <label for="news-company" class="form-label">Компания</label>
                                    <input type="text" id="news-company" class="form-input" placeholder="Название вашей компании">
                                </div>
                            </div>
                            <div class="contact-form__column">
                                <div class="form-group">
                                    <label for="news-interests" class="form-label">Интересы</label>
                                    <textarea id="news-interests" class="form-textarea" placeholder="Какие темы вас интересуют? (продукция, проекты, события и т.д.)"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="contact-form__footer">
                            <div class="form-checkbox">
                                <input type="checkbox" id="news-consent" class="form-checkbox__input" required>
                                <label for="news-consent" class="form-checkbox__label">
                                    Согласен на получение новостной рассылки и 
                                    <a href="#" class="form-checkbox__link">обработку персональных данных</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn_type_primary contact-form__submit">
                                <i class="fa-solid fa-bell"></i>
                                <span>Подписаться на новости</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php get_footer(); ?>