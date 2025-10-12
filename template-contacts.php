<?php
/*
Template Name: Контакты
*/

get_header(); ?>

<?php dsa_breadcrumbs(); ?>

<!-- Заголовок страницы -->
<div class="page-header">
    <div class="container">
        <h1 class="page-header__title">Контакты ООО «DSA Generators» в Москве</h1>
    </div>
</div>

<!-- Основной контент -->
<main class="main-content" role="main">
    <div class="container">
        <!-- ACF: Основные контакты -->
        <!-- Основные контакты -->
        <section class="contacts-main">
            <div class="contacts-main__grid">
                <!-- Левая колонка - Контактная информация -->
                <div class="contacts-main__info">
                    <div class="contacts-info">
                        <h2 class="contacts-info__title">Контактная информация</h2>
                        
                        <div class="contacts-info__item">
                            <div class="contacts-info__icon">
                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-info__content">
                                <h3 class="contacts-info__label">Бесплатный телефон</h3>
                                <a href="tel:88007707157" class="contacts-info__value contacts-info__value_phone">8 (800) 770‑71‑57</a>
                                <p class="contacts-info__note">(бесплатный звонок по России)</p>
                            </div>
                        </div>

                        <div class="contacts-info__item">
                            <div class="contacts-info__icon">
                                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-info__content">
                                <h3 class="contacts-info__label">График работы</h3>
                                <p class="contacts-info__value">ежедневно, 8:00-20:00</p>
                            </div>
                        </div>

                        <div class="contacts-info__item">
                            <div class="contacts-info__icon">
                                <i class="fa-solid fa-building" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-info__content">
                                <h3 class="contacts-info__label">Реквизиты компании</h3>
                                <div class="contacts-info__details">
                                    <p><strong>ИНН:</strong> 7840490040</p>
                                    <p><strong>ОГРН:</strong> 1137847211886</p>
                                    <p><strong>КПП:</strong> 784201001</p>
                                </div>
                            </div>
                        </div>

                        <div class="contacts-info__item">
                            <div class="contacts-info__icon">
                                <i class="fa-solid fa-download" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-info__content">
                                <h3 class="contacts-info__label">Документы</h3>
                                <div class="contacts-info__links">
                                    <a href="#" class="contacts-info__link">Скачать реквизиты (обновлены 25.06.2025)</a>
                                    <a href="#" class="contacts-info__link">Лицензии и дилерские сертификаты</a>
                                </div>
                            </div>
                        </div>

                        <div class="contacts-info__item">
                            <div class="contacts-info__icon">
                                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-info__content">
                                <h3 class="contacts-info__label">Email</h3>
                                <a href="mailto:order@dsa-generators.ru" class="contacts-info__value contacts-info__value_email">order@dsa-generators.ru</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Правая колонка - Офис продаж и карта -->
                <div class="contacts-main__office">
                    <div class="contacts-office">
                        <h2 class="contacts-office__title">Офис продаж в Москве</h2>
                        
                        <div class="contacts-office__address">
                            <div class="contacts-office__icon">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-office__content">
                                <p class="contacts-office__street">Щербаковская ул., 3</p>
                                <p class="contacts-office__metro">м. Семёновская</p>
                            </div>
                        </div>

                        <div class="contacts-office__phone">
                            <div class="contacts-office__icon">
                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="contacts-office__content">
                                <a href="tel:+74959666111" class="contacts-office__phone-link">+7 495 966-61-11</a>
                            </div>
                        </div>

                        <!-- ACF: Интерактивная карта -->
                        <!-- Карта -->
                        <div class="contacts-office__map">
                            <div class="contacts-map">
                                <div class="contacts-map__placeholder">
                                    <div class="contacts-map__icon">
                                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                                    </div>
                                    <h3 class="contacts-map__title">Интерактивная карта</h3>
                                    <p class="contacts-map__description">Щербаковская ул., 3, Москва</p>
                                    <p class="contacts-map__metro">м. Семёновская</p>
                                    <button class="contacts-map__button" type="button">
                                        <i class="fa-solid fa-external-link-alt" aria-hidden="true"></i>
                                        <span>Открыть в Яндекс Картах</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACF: Филиалы в регионах -->
        <!-- Филиалы в регионах -->
        <section class="contacts-branches">
            <div class="contacts-branches__header">
                <h2 class="contacts-branches__title">Филиалы в регионах</h2>
                <p class="contacts-branches__subtitle">Наши представительства по всей России</p>
            </div>

            <div class="contacts-branches__grid">
                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="contacts-branch__city">Санкт-Петербург</h3>
                    <p class="contacts-branch__address">Митрофаньевское шоссе, 8А, Лит. Б</p>
                    <a href="tel:+78122075294" class="contacts-branch__phone">+7 (812) 207-52-94</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="contacts-branch__city">Москва</h3>
                    <p class="contacts-branch__address">Щербаковская ул., 3</p>
                    <a href="tel:+74959666111" class="contacts-branch__phone">+7 495 966-61-11</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="contacts-branch__city">Волгоград</h3>
                    <p class="contacts-branch__address">Мира ул., д. 19</p>
                    <a href="tel:+78442684825" class="contacts-branch__phone">+7 844 268-48-25</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="400">
                    <h3 class="contacts-branch__city">Воронеж</h3>
                    <p class="contacts-branch__address">Московский пр., д. 4</p>
                    <a href="tel:+74732016099" class="contacts-branch__phone">+7 473 201-60-99</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="500">
                    <h3 class="contacts-branch__city">Екатеринбург</h3>
                    <p class="contacts-branch__address">Антона Валека ул., д. 13</p>
                    <a href="tel:+73433020042" class="contacts-branch__phone">+7 343 302-00-42</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="600">
                    <h3 class="contacts-branch__city">Казань</h3>
                    <p class="contacts-branch__address">Проточная ул., д. 8</p>
                    <a href="tel:+78432072835" class="contacts-branch__phone">+7 843 207-28-35</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="700">
                    <h3 class="contacts-branch__city">Краснодар</h3>
                    <p class="contacts-branch__address">Карасунская ул., д. 60</p>
                    <a href="tel:+78612117234" class="contacts-branch__phone">+7 861 211-72-34</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="800">
                    <h3 class="contacts-branch__city">Красноярск</h3>
                    <p class="contacts-branch__address">Взлётная ул., д. 57</p>
                    <a href="tel:+73912295939" class="contacts-branch__phone">+7 391 229-59-39</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="900">
                    <h3 class="contacts-branch__city">Курск</h3>
                    <p class="contacts-branch__address">ул. Радищева, 5</p>
                    <a href="tel:+74712785030" class="contacts-branch__phone">+7 471 278-50-30</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1000">
                    <h3 class="contacts-branch__city">Магадан</h3>
                    <p class="contacts-branch__address">Парковая ул., 13</p>
                    <a href="tel:+79642364265" class="contacts-branch__phone">+7 964 236-42-65</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1100">
                    <h3 class="contacts-branch__city">Нижний Новгород</h3>
                    <p class="contacts-branch__address">Максима Горького, д. 260</p>
                    <a href="tel:+78312885450" class="contacts-branch__phone">+7 831 288-54-50</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1200">
                    <h3 class="contacts-branch__city">Новосибирск</h3>
                    <p class="contacts-branch__address">Гаранина ул., д. 15</p>
                    <a href="tel:+73833121404" class="contacts-branch__phone">+7 383 312-14-04</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1300">
                    <h3 class="contacts-branch__city">Новый Уренгой</h3>
                    <p class="contacts-branch__address">пр. Губкина, 14A</p>
                    <a href="tel:88007707157" class="contacts-branch__phone">8 (800) 770-71-57</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1400">
                    <h3 class="contacts-branch__city">Оренбург</h3>
                    <p class="contacts-branch__address">Шоссейная ул., 24А</p>
                    <a href="tel:+73532486494" class="contacts-branch__phone">+7 353 248-64-94</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1500">
                    <h3 class="contacts-branch__city">Пермь</h3>
                    <p class="contacts-branch__address">Аркадия Гайдара ул., д. 8Б</p>
                    <a href="tel:+73422338304" class="contacts-branch__phone">+7 342 233-83-04</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1600">
                    <h3 class="contacts-branch__city">Ростов-на-Дону</h3>
                    <p class="contacts-branch__address">Максима Горького ул., д. 295</p>
                    <a href="tel:+78633092151" class="contacts-branch__phone">+7 863 309-21-51</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1700">
                    <h3 class="contacts-branch__city">Самара</h3>
                    <p class="contacts-branch__address">Скляренко ул., д. 26</p>
                    <a href="tel:+78462151617" class="contacts-branch__phone">+7 846 215-16-17</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1800">
                    <h3 class="contacts-branch__city">Сургут</h3>
                    <p class="contacts-branch__address">30 лет Победы ул., 44Б</p>
                    <a href="tel:+73462769288" class="contacts-branch__phone">+7 346 276-92-88</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="1900">
                    <h3 class="contacts-branch__city">Тюмень</h3>
                    <p class="contacts-branch__address">Пермякова ул., д. 1</p>
                    <a href="tel:+73452564332" class="contacts-branch__phone">+7 345 256-43-32</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="2000">
                    <h3 class="contacts-branch__city">Улан-Удэ</h3>
                    <p class="contacts-branch__address">ул. Ербанова, 11</p>
                    <a href="tel:+73012480858" class="contacts-branch__phone">+7 301 248-08-58</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="2100">
                    <h3 class="contacts-branch__city">Уфа</h3>
                    <p class="contacts-branch__address">Кирова ул, д. 107</p>
                    <a href="tel:+73472253497" class="contacts-branch__phone">+7 347 225-34-97</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="2200">
                    <h3 class="contacts-branch__city">Хабаровск</h3>
                    <p class="contacts-branch__address">ул. Карла Маркса, 96А</p>
                    <a href="tel:+74212529077" class="contacts-branch__phone">+7 421 252-90-77</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="2300">
                    <h3 class="contacts-branch__city">Челябинск</h3>
                    <p class="contacts-branch__address">Победы пр., д. 160</p>
                    <a href="tel:+73512257262" class="contacts-branch__phone">+7 351 225-72-62</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="2400">
                    <h3 class="contacts-branch__city">Якутск</h3>
                    <p class="contacts-branch__address">Короленко ул., 25</p>
                    <a href="tel:+74112505580" class="contacts-branch__phone">+7 411 250-55-80</a>
                </div>

                <div class="contacts-branch" data-aos="fade-up" data-aos-delay="2500">
                    <h3 class="contacts-branch__city">Ярославль</h3>
                    <p class="contacts-branch__address">Некрасова ул., д. 41А</p>
                    <a href="tel:+74852275234" class="contacts-branch__phone">+7 4852 27-52-34</a>
                </div>
            </div>
        </section>

        <!-- ACF: Форма обратной связи (CF7) -->
        <!-- Форма запроса -->
        <div class="contact-form">
            <h2 class="contact-form__title">Оставьте заявку на расчет цены проекта дизельного генератора 16 кВт</h2>
            <!-- Здесь будет интегрирована форма Contact Form 7 через шорткод -->
            <form class="contact-form__form">
                <div class="contact-form__fields">
                    <div class="contact-form__column">
                        <div class="form-group">
                            <label for="request-name" class="form-label">Имя</label>
                            <input type="text" id="request-name" class="form-input" placeholder="Введите ваше имя">
                        </div>
                        <div class="form-group">
                            <label for="request-email" class="form-label">E-mail</label>
                            <input type="email" id="request-email" class="form-input" placeholder="Введите ваш email">
                        </div>
                        <div class="form-group">
                            <label for="request-phone" class="form-label">Телефон</label>
                            <input type="tel" id="request-phone" class="form-input" placeholder="Введите ваш телефон">
                        </div>
                    </div>
                    <div class="contact-form__column">
                        <div class="form-group">
                            <label for="request-message" class="form-label">Сообщение</label>
                            <textarea id="request-message" class="form-textarea" placeholder="Опишите ваши требования"></textarea>
                        </div>
                    </div>
                </div>
                <div class="contact-form__footer">
                    <div class="form-checkbox">
                        <input type="checkbox" id="request-consent" class="form-checkbox__input">
                        <label for="request-consent" class="form-checkbox__label">
                            Настоящим подтверждаю, что я ознакомлен и согласен с условиями 
                            <a href="#" class="form-checkbox__link">обработки персональных данных</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn_type_primary contact-form__submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Отправить запрос</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>
