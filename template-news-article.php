<?php
/**
 * Template Name: Новость
 */

get_header(); ?>

<?php dsa_breadcrumbs(); ?>


  <main>

    <!-- Hero -->
    <section class="article-hero">
      <div class="container">
        <div class="article-hero__inner">
          <div class="article-hero__content">
            <h1 class="article-hero__title">Промышленные решения для металлургии</h1>
            <p class="article-hero__subtitle">Специальные генераторы для металлургических предприятий с повышенной надежностью и производительностью в экстремальных условиях.</p>
            <div class="article-hero__meta">
              <time datetime="2025-10-22" class="article-hero__date"><i class="fa-regular fa-calendar"></i> 22 октября 2025</time>
              <span class="article-hero__category"><i class="fa-solid fa-industry"></i> Промышленность</span>
              <span class="article-hero__views"><i class="fa-regular fa-eye"></i> 1 842</span>
            </div>
          </div>
          <div class="article-hero__image">
            <img src="../img/slider1.webp" alt="Генераторы для металлургической отрасли">
          </div>
        </div>
      </div>
    </section>

    <!-- Контент статьи -->
    <article class="news-article">
      <div class="container">
        <div class="news-article__grid">
          <div class="news-article__content">
            <p>Металлургическая отрасль предъявляет повышенные требования к устойчивости и надежности источников электроснабжения. Наши решения проектируются с учетом экстремальных температур, запыленности, вибраций и непрерывных циклов работы.</p>

            <h2>Ключевые особенности решений</h2>
            <ul class="list">
              <li>Устойчивость к высоким температурам и агрессивной среде цехов.</li>
              <li>Модульные контейнерные исполнения с утеплением и климат‑контролем.</li>
              <li>Автоматический ввод резерва (АВР) и параллельная работа агрегатов.</li>
              <li>Системы шумопоглощения 55 дБ(А) и искрогашения для безопасности.</li>
              <li>Интеграция с АСУ ТП и дистанционный мониторинг (IoT).</li>
            </ul>

            <h2>Рекомендуемые конфигурации</h2>
            <div class="feature-cards">
              <div class="feature-card">
                <div class="feature-card__icon"><i class="fa-solid fa-bolt"></i></div>
                <div class="feature-card__content">
                  <h3 class="feature-card__title">Мощность 1–2 МВт</h3>
                  <p class="feature-card__text">Для прокатных станов, печей нагрева и участков непрерывного литья заготовок.</p>
                </div>
              </div>
              <div class="feature-card">
                <div class="feature-card__icon"><i class="fa-solid fa-temperature-high"></i></div>
                <div class="feature-card__content">
                  <h3 class="feature-card__title">Климатическое исполнение</h3>
                  <p class="feature-card__text">Работа при −45…+50 °C, обогрев РЩ и подогрев ОЖ, фильтрация воздуха.</p>
                </div>
              </div>
              <div class="feature-card">
                <div class="feature-card__icon"><i class="fa-solid fa-network-wired"></i></div>
                <div class="feature-card__content">
                  <h3 class="feature-card__title">Параллель и масштабирование</h3>
                  <p class="feature-card__text">Гибкое наращивание мощности без остановки производства.</p>
                </div>
              </div>
            </div>

            <h2>Сферы применения на металлургических предприятиях</h2>
            <ol class="list list--ordered">
              <li>Резерв и пик покрытия для дуговых и индукционных печей.</li>
              <li>Энергоснабжение компрессорных, насосных и систем пылеулавливания.</li>
              <li>Резерв серверных/ЦОД и критической автоматики АСУ ТП.</li>
            </ol>

            <blockquote class="quote">
              <p>Правильный подбор генераторной установки снижает риски простоев и помогает стабилизировать качество продукции даже в условиях нестабильного энергоснабжения.</p>
            </blockquote>

            <h2>Технические характеристики типовой поставки</h2>
            <div class="specs">
              <div class="specs__grid">
                <div class="specs__row"><span class="specs__label">Диапазон мощности</span><span class="specs__value">400 кВт — 2 МВт</span></div>
                <div class="specs__row"><span class="specs__label">Напряжение</span><span class="specs__value">0,4 кВ / 6,3 кВ / 10,5 кВ</span></div>
                <div class="specs__row"><span class="specs__label">Рабочая среда</span><span class="specs__value">−45…+50 °C, пыль, вибрации</span></div>
                <div class="specs__row"><span class="specs__label">Шумозащита</span><span class="specs__value">до 55 дБ(А)</span></div>
                <div class="specs__row"><span class="specs__label">Автоматика</span><span class="specs__value">АВР/АПА, параллель</span></div>
                <div class="specs__row"><span class="specs__label">Мониторинг</span><span class="specs__value">IoT/SCADA, удаленный доступ</span></div>
              </div>
            </div>

            <h2>Кейсы внедрения</h2>
            <div class="case-cards">
              <div class="case-card">
                <h3 class="case-card__title">Прокатный стан — 2×1 МВт</h3>
                <div class="case-card__meta">Москва • 2024</div>
                <p>Две ДГУ 1 МВт в параллели для покрытия пиков и резервирования критических линий. Введены в работу без остановки производства.</p>
              </div>
              <div class="case-card">
                <h3 class="case-card__title">Пылеулавливание и компрессорная — 800 кВт</h3>
                <div class="case-card__meta">Череповец • 2023</div>
                <p>Контейнерное исполнение, фильтрация воздуха, искрогашение выхлопа, интеграция с АСУ ТП.</p>
              </div>
              <div class="case-card">
                <h3 class="case-card__title">Резерв ЦОД и АСУ ТП — 500 кВт</h3>
                <div class="case-card__meta">Липецк • 2025</div>
                <p>Низкошумный режим, двойное питание шин, удаленный мониторинг, SLA 24/7.</p>
              </div>
            </div>

            <h2>Галерея решений</h2>
            <div class="gallery">
              <img src="https://images.unsplash.com/photo-1581094306765-c2c6b8e3c9c0?w=800&q=80" alt="Энергетическое оборудование">
              <img src="https://images.unsplash.com/photo-1586864387967-d02ef85d93e8?w=800&q=80" alt="Металлургический цех">
              <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=800&q=80" alt="Генераторная установка">
              <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80" alt="Инфраструктура предприятия">
            </div>

            <h2>Частые вопросы</h2>
            <div class="faq">
              <details>
                <summary>Можно ли нарастить мощность без остановки производства?</summary>
                <p>Да. Параллельная работа агрегатов позволяет масштабирование в «горячем» режиме.</p>
              </details>
              <details>
                <summary>Как обслуживать оборудование в запыленной среде?</summary>
                <p>Используем усиленную фильтрацию воздуха, увеличенные интервалы ТО и датчики загрязнения фильтров.</p>
              </details>
              <details>
                <summary>Делаете ли вы высоковольтные решения?</summary>
                <p>Да, реализуем 6,3 и 10,5 кВ, поставляем комплект РУНН/РУВН и трансформаторные решения.</p>
              </details>
            </div>

            <!-- Дополнительные текстовые блоки -->
            <h2>Почему генераторы для металлургии отличаются</h2>
            <p>В металлургии повышенная запыленность, вибрации и резкие перепады температуры считаются нормой технологического процесса. Поэтому стандартные решения без адаптации быстро теряют надежность: перегреваются, засоряются фильтры, растет износ узлов. Мы применяем промышленную комплектацию, рассчитанную на экстремальные режимы, и проектируем инженерную обвязку под конкретные цеха и площадки.</p>
            <ul class="list">
              <li>Усиленная вентиляция и фильтрация приточного воздуха.</li>
              <li>Термозащита и подогревы узлов для запуска в мороз.</li>
              <li>Виброизолированные опоры и усиленные рамы.</li>
              <li>Шумозащита, искрогашение и огнестойкие материалы.</li>
            </ul>

            <h2>Требования к размещению и безопасности</h2>
            <ul class="list">
              <li>Безопасные расстояния до технологического оборудования и путей эвакуации.</li>
              <li>Организация приточно‑вытяжной вентиляции с учетом теплоизбытков.</li>
              <li>Системы обнаружения дыма и огнетушащие средства в зоне ДГУ.</li>
              <li>Правильная организация выхлопа: искрогасители, температурные экраны.</li>
              <li>Заземление, молниезащита, разделение силовых и сигнальных цепей.</li>
            </ul>

            <h2>Эксплуатация и сервис</h2>
            <p>Эксплуатация строится вокруг регламентов ТО и мониторинга состояния. Мы поставляем понятные регламенты, обучаем персонал и обеспечиваем доступ 24/7 к сервисной линии.</p>
            <ul class="list">
              <li>Регулярная замена фильтров с учетом запыленности.</li>
              <li>Плановые проверки системы подачи воздуха и топлива.</li>
              <li>Удаленный мониторинг параметров и предупреждение инцидентов.</li>
              <li>Склад ЗИП и расходников на площадке клиента или у сервиса.</li>
            </ul>

            <h2>Этапы реализации проекта</h2>
            <ol class="list list--ordered">
              <li>Обследование площадки и сбор исходных данных.</li>
              <li>Техническое решение и предварительный расчет.</li>
              <li>Проектирование, согласование с охраной труда и ПБ.</li>
              <li>Производство/поставка, строительно‑монтажные работы.</li>
              <li>ПНР, обучение, ввод в эксплуатацию, передача документации.</li>
            </ol>

            <h2>Экономический эффект</h2>
            <p>Правильный подбор мощности и режимов работы снижает простой линий и издержки на аварийное восстановление. Дополнительно параллельная схема позволяет масштабировать мощность по мере роста потребностей без «переинвестирования» на старте.</p>
            <ul class="list">
              <li>Сокращение простоев и брака за счет гарантированного питания.</li>
              <li>Оптимизация расходов ТО и топлива благодаря мониторингу.</li>
              <li>Гибкое наращивание мощности — инвестиции по мере роста.</li>
            </ul>

            <div class="cta">
              <div class="cta__content">
                <h3 class="cta__title">Нужен расчет под вашу задачу?</h3>
                <p class="cta__text">Подготовим технико‑коммерческое предложение в течение 24 часов.</p>
              </div>
              <a class="btn btn_type_primary cta__btn" href="mailto:order@example.com">Запросить ТКП</a>
            </div>

            <form class="lead-form" aria-label="Заявка на расчет">
              <div class="lead-form__row">
                <div class="lead-form__field">
                  <label class="lead-form__label" for="lead-name">Имя</label>
                  <input class="lead-form__input" id="lead-name" type="text" placeholder="Ваше имя">
                </div>
                <div class="lead-form__field">
                  <label class="lead-form__label" for="lead-email">E-mail</label>
                  <input class="lead-form__input" id="lead-email" type="email" placeholder="name@example.com">
                </div>
              </div>
              <div class="lead-form__row">
                <div class="lead-form__field">
                  <label class="lead-form__label" for="lead-power">Требуемая мощность</label>
                  <input class="lead-form__input" id="lead-power" type="text" placeholder="Например, 2 × 1 МВт">
                </div>
                <div class="lead-form__field">
                  <label class="lead-form__label" for="lead-voltage">Напряжение</label>
                  <input class="lead-form__input" id="lead-voltage" type="text" placeholder="0,4 / 6,3 / 10,5 кВ">
                </div>
              </div>
              <div class="lead-form__field">
                <label class="lead-form__label" for="lead-comment">Комментарий</label>
                <textarea class="lead-form__textarea" id="lead-comment" placeholder="Кратко опишите задачу и условия эксплуатации"></textarea>
              </div>
              <button type="submit" class="btn btn_type_primary lead-form__submit">Отправить запрос</button>
            </form>

            <div class="article-share" aria-label="Поделиться">
              <span class="article-share__label">Поделиться:</span>
              <a href="#" class="article-share__btn" aria-label="Поделиться в Telegram"><i class="fa-brands fa-telegram"></i></a>
              <a href="#" class="article-share__btn" aria-label="Поделиться в WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
              <a href="#" class="article-share__btn" aria-label="Скопировать ссылку"><i class="fa-solid fa-link"></i></a>
            </div>

            <nav class="article-nav" aria-label="Навигация по новостям">
              <a class="article-nav__link article-nav__link_prev" href="news.html"><i class="fa-solid fa-arrow-left"></i><span>К списку новостей</span></a>
            </nav>
          </div>

          <aside class="news-article__sidebar">
            <div class="sidebar-card">
              <h3 class="sidebar-card__title">Похожие материалы</h3>
              <ul class="sidebar-list">
                <li><a href="#" class="sidebar-link">Энергокомплексы 3–50 МВт для тяжелой промышленности</a></li>
                <li><a href="#" class="sidebar-link">Высоковольтные решения 6,3 и 10,5 кВ</a></li>
                <li><a href="#" class="sidebar-link">Шумозащитные контейнеры для ДГУ</a></li>
              </ul>
            </div>

            <div class="sidebar-card sidebar-card_contact">
              <h3 class="sidebar-card__title">Нужна консультация?</h3>
              <p class="sidebar-card__text">Оставьте заявку, и инженер перезвонит в течение 15 минут.</p>
              <a href="mailto:order@example.com" class="btn btn_type_primary sidebar-card__btn">Связаться</a>
            </div>
          </aside>
        </div>
      </div>
    </article>
  </main>

  <?php get_footer(); ?>
