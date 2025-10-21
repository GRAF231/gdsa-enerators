<?php
/**
 * Template Name: Выполненные проекты
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

    <!-- Основной контент -->
    <main class="">
  


        <!-- Заголовок страницы -->
        <header class="page-header">
            <div class="container">
                <h1 class="page-header__title">Выполненные проекты за 2014 - 2025 годы</h1>
            </div>
        </header>

        <!-- Фильтры -->
        <section class="projects-filters">
            <div class="container">
                <div class="projects-filters__tabs">
                    <button class="projects-filters__tab projects-filters__tab_active" data-filter="power">
                        Диапазон мощности
                    </button>
                    <button class="projects-filters__tab" data-filter="industry">
                        Отрасль применения
                    </button>
                    <button class="projects-filters__tab" data-filter="city">
                        Город
                    </button>
                    <button class="projects-filters__tab" data-filter="year">
                        Год
                    </button>
                </div>

                <div class="projects-filters__content">
                    <div class="projects-filters__panel projects-filters__panel_active" data-panel="power">
                        <div class="projects-filters__options">
                            <button class="projects-filters__option projects-filters__option_active" data-value="all">Все</button>
                            <button class="projects-filters__option" data-value="16-40">16-40 кВт</button>
                            <button class="projects-filters__option" data-value="40-80">40-80 кВт</button>
                            <button class="projects-filters__option" data-value="80-100">80-100 кВт</button>
                            <button class="projects-filters__option" data-value="100-150">100-150 кВт</button>
                            <button class="projects-filters__option" data-value="150-200">150-200 кВт</button>
                            <button class="projects-filters__option" data-value="200-300">200-300 кВт</button>
                            <button class="projects-filters__option" data-value="300-500">300-500 кВт</button>
                            <button class="projects-filters__option" data-value="500-700">500-700 кВт</button>
                            <button class="projects-filters__option" data-value="800-1000">800-1000 кВт</button>
                            <button class="projects-filters__option" data-value="1000-1500">1000-1500 кВт</button>
                            <button class="projects-filters__option" data-value="1500-2000">1500-2000 кВт</button>
                            <button class="projects-filters__option" data-value="2000-3000">2000-3000 кВт</button>
                            <button class="projects-filters__option" data-value="3000-6000">3000-6000 кВт</button>
                            <button class="projects-filters__option" data-value="6000-12000">6000-12000 кВт</button>
                        </div>
                    </div>

                    <div class="projects-filters__panel" data-panel="industry">
                        <div class="projects-filters__options">
                            <button class="projects-filters__option projects-filters__option_active" data-value="all">Все</button>
                            <button class="projects-filters__option" data-value="industrial">Промышленность</button>
                            <button class="projects-filters__option" data-value="commercial">Коммерция</button>
                            <button class="projects-filters__option" data-value="residential">Жилые объекты</button>
                            <button class="projects-filters__option" data-value="mining">Горнодобывающая</button>
                            <button class="projects-filters__option" data-value="hospitality">Гостиничный бизнес</button>
                            <button class="projects-filters__option" data-value="healthcare">Здравоохранение</button>
                        </div>
                    </div>

                    <div class="projects-filters__panel" data-panel="city">
                        <div class="projects-filters__options">
                            <button class="projects-filters__option projects-filters__option_active" data-value="all">Все</button>
                            <button class="projects-filters__option" data-value="moscow">Москва</button>
                            <button class="projects-filters__option" data-value="spb">Санкт-Петербург</button>
                            <button class="projects-filters__option" data-value="krasnodar">Краснодарский край</button>
                            <button class="projects-filters__option" data-value="sochi">Сочи</button>
                            <button class="projects-filters__option" data-value="chukotka">Чукотский АО</button>
                            <button class="projects-filters__option" data-value="magadan">Магаданская область</button>
                            <button class="projects-filters__option" data-value="belgorod">Белгородская область</button>
                            <button class="projects-filters__option" data-value="yakutia">Якутия</button>
                        </div>
                    </div>

                    <div class="projects-filters__panel" data-panel="year">
                        <div class="projects-filters__options">
                            <button class="projects-filters__option projects-filters__option_active" data-value="all">Все</button>
                            <button class="projects-filters__option" data-value="2025">2025</button>
                            <button class="projects-filters__option" data-value="2024">2024</button>
                            <button class="projects-filters__option" data-value="2023">2023</button>
                            <button class="projects-filters__option" data-value="2022">2022</button>
                            <button class="projects-filters__option" data-value="2021">2021</button>
                            <button class="projects-filters__option" data-value="2020">2020</button>
                            <button class="projects-filters__option" data-value="2019">2019</button>
                            <button class="projects-filters__option" data-value="2018">2018</button>
                            <button class="projects-filters__option" data-value="2017">2017</button>
                            <button class="projects-filters__option" data-value="2016">2016</button>
                            <button class="projects-filters__option" data-value="2015">2015</button>
                            <button class="projects-filters__option" data-value="2014">2014</button>
                        </div>
                    </div>
                </div>

                <div class="projects-filters__actions">
                    <button class="projects-filters__reset-btn" type="button">
                        <i class="fa-solid fa-refresh" aria-hidden="true"></i>
                        Сбросить все фильтры
                    </button>
                    <div class="projects-filters__view">
                        <button class="projects-filters__view-btn projects-filters__view-btn_active" data-view="grid" aria-label="Сетка">
                            <i class="fa-solid fa-th" aria-hidden="true"></i>
                        </button>
                        <button class="projects-filters__view-btn" data-view="list" aria-label="Список">
                            <i class="fa-solid fa-list" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Проекты -->
        <section class="projects-grid">
            <div class="container">
                <div class="projects-grid__items">
                    <!-- Проект 1 -->
                    <article class="project-card" data-power="6000-12000" data-industry="industrial" data-city="krasnodar" data-year="2024">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="ДГУ 12 МВт для промышленного предприятия" loading="lazy">
                            <div class="project-card__power">12000 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Поставка и ПНР шести ДГУ 12 МВт для промышленного предприятия ЮФО</h3>
                            <p class="project-card__client">Промышленное предприятие ЮФО</p>
                        </div>
                    </article>

                    <!-- Проект 2 -->
                    <article class="project-card" data-power="6000-12000" data-industry="hospitality" data-city="sochi" data-year="2023">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="ДГУ 8.8 МВт для отеля в Сочи" loading="lazy">
                            <div class="project-card__power">8800 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Шесть ДГУ на 8,8 МВт в составе энергоцентра для отеля в Сочи</h3>
                            <p class="project-card__client">Отель Сочи</p>
                        </div>
                    </article>

                    <!-- Проект 3 -->
                    <article class="project-card" data-power="3000-6000" data-industry="mining" data-city="chukotka" data-year="2022">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="ДЭС 6 МВт для рудника Каральвеем" loading="lazy">
                            <div class="project-card__power">6000 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Поставка и ПНР трех ДЭС 6 МВт для рудника «Каральвеем» (Чукотский АО)</h3>
                            <p class="project-card__client">АО «Рудник Каральвеем»</p>
                        </div>
                    </article>

                    <!-- Проект 4 -->
                    <article class="project-card" data-power="3000-6000" data-industry="industrial" data-city="krasnodar" data-year="2024">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="Передвижные ДГУ 6000 кВт" loading="lazy">
                            <div class="project-card__power">6000 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Поставка, ПНР и ШМР трех передвижных ДГУ 6000 кВт для крупного промышленного предприятия ЮФО</h3>
                            <p class="project-card__client">Промышленное предприятие (ЮФО)</p>
                        </div>
                    </article>

                    <!-- Проект 5 -->
                    <article class="project-card" data-power="3000-6000" data-industry="residential" data-city="magadan" data-year="2021">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="Энергокомплекс 6 МВт для поселка Талая" loading="lazy">
                            <div class="project-card__power">6000 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Демонтаж советских ДГ72, СМР и установка высоковольтного энергокомплекса 6 МВт для поселка Талая Магаданской области</h3>
                            <p class="project-card__client">КЖТ АХМО Магаданской области</p>
                        </div>
                    </article>

                    <!-- Проект 6 -->
                    <article class="project-card" data-power="3000-6000" data-industry="mining" data-city="belgorod" data-year="2020">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="Энергокомплекс Cummins 5x1000 кВт" loading="lazy">
                            <div class="project-card__power">5000 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Энергокомплекс Cummins 5x1000 кВт для Яковлевского ГОК в Белгородской области</h3>
                            <p class="project-card__client">Яковлевский ГОК</p>
                        </div>
                    </article>

                    <!-- Проект 7 -->
                    <article class="project-card" data-power="1000-1500" data-industry="industrial" data-city="moscow" data-year="2023">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="ДГУ 1200 кВт для завода" loading="lazy">
                            <div class="project-card__power">1200 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Поставка и монтаж ДГУ 1200 кВт для металлургического завода</h3>
                            <p class="project-card__client">Металлургический завод</p>
                        </div>
                    </article>

                    <!-- Проект 8 -->
                    <article class="project-card" data-power="200-300" data-industry="commercial" data-city="moscow" data-year="2024">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="ДГУ 250 кВт для бизнес-центра" loading="lazy">
                            <div class="project-card__power">250 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Резервное энергоснабжение 250 кВт для бизнес-центра</h3>
                            <p class="project-card__client">Бизнес-центр "Столичный"</p>
                        </div>
                    </article>

                    <!-- Проект 9 -->
                    <article class="project-card" data-power="80-100" data-industry="residential" data-city="spb" data-year="2022">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="ДГУ 100 кВт для коттеджного поселка" loading="lazy">
                            <div class="project-card__power">100 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Автономное энергоснабжение 100 кВт для коттеджного поселка</h3>
                            <p class="project-card__client">Коттеджный поселок "Северный"</p>
                        </div>
                    </article>

                    <!-- Проект 10 -->
                    <article class="project-card" data-power="300-500" data-industry="healthcare" data-city="moscow" data-year="2021">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="ДГУ 400 кВт для больницы" loading="lazy">
                            <div class="project-card__power">400 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Резервное питание 400 кВт для городской больницы</h3>
                            <p class="project-card__client">Городская больница №15</p>
                        </div>
                    </article>

                    <!-- Проект 11 -->
                    <article class="project-card" data-power="500-700" data-industry="industrial" data-city="yakutia" data-year="2020">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="ДГУ 600 кВт для алмазного рудника" loading="lazy">
                            <div class="project-card__power">600 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Энергоснабжение 600 кВт для алмазного рудника в Якутии</h3>
                            <p class="project-card__client">Алмазный рудник "Удачный"</p>
                        </div>
                    </article>

                    <!-- Проект 12 -->
                    <article class="project-card" data-power="150-200" data-industry="commercial" data-city="moscow" data-year="2019">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="ДГУ 180 кВт для торгового центра" loading="lazy">
                            <div class="project-card__power">180 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Резервное энергоснабжение 180 кВт для торгового центра</h3>
                            <p class="project-card__client">ТЦ "Мегаполис"</p>
                        </div>
                    </article>

                    <!-- Проект 13 -->
                    <article class="project-card" data-power="40-80" data-industry="residential" data-city="moscow" data-year="2018">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="ДГУ 60 кВт для частного дома" loading="lazy">
                            <div class="project-card__power">60 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Автономное энергоснабжение 60 кВт для частного дома</h3>
                            <p class="project-card__client">Частный дом, Подмосковье</p>
                        </div>
                    </article>

                    <!-- Проект 14 -->
                    <article class="project-card" data-power="1000-1500" data-industry="industrial" data-city="spb" data-year="2017">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="ДГУ 1400 кВт для нефтеперерабатывающего завода" loading="lazy">
                            <div class="project-card__power">1400 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Резервное питание 1400 кВт для нефтеперерабатывающего завода</h3>
                            <p class="project-card__client">НПЗ "Северный"</p>
                        </div>
                    </article>

                    <!-- Проект 15 -->
                    <article class="project-card" data-power="2000-3000" data-industry="mining" data-city="yakutia" data-year="2016">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="ДГУ 2500 кВт для золотого рудника" loading="lazy">
                            <div class="project-card__power">2500 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Энергоснабжение 2500 кВт для золотого рудника</h3>
                            <p class="project-card__client">Золотой рудник "Алдан"</p>
                        </div>
                    </article>

                    <!-- Проект 16 -->
                    <article class="project-card" data-power="800-1000" data-industry="hospitality" data-city="sochi" data-year="2015">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" alt="ДГУ 900 кВт для санатория" loading="lazy">
                            <div class="project-card__power">900 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Резервное энергоснабжение 900 кВт для санатория</h3>
                            <p class="project-card__client">Санаторий "Морской берег"</p>
                        </div>
                    </article>

                    <!-- Проект 17 -->
                    <article class="project-card" data-power="1500-2000" data-industry="industrial" data-city="moscow" data-year="2014">
                        <div class="project-card__image">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=300&fit=crop&crop=center" alt="ДГУ 1800 кВт для химического завода" loading="lazy">
                            <div class="project-card__power">1800 кВт</div>
                        </div>
                        <div class="project-card__content">
                            <h3 class="project-card__title">Резервное питание 1800 кВт для химического завода</h3>
                            <p class="project-card__client">Химический завод "Восток"</p>
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
                        <button class="pagination__per-page-btn" type="button">50</button>
                        <button class="pagination__per-page-btn pagination__per-page-btn_active" type="button">100</button>
                        <button class="pagination__per-page-btn" type="button">200</button>
                        <button class="pagination__per-page-btn" type="button">500</button>
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
                        <button class="pagination__page" type="button">18</button>
                    </div>
                    <button class="pagination__btn pagination__btn_next" type="button">
                        <span>Следующая</span>
                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>


    </main>

    <?php get_footer(); ?>