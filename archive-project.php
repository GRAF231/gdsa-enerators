<?php
/**
 * Archive template for Projects
 */
get_header(); ?>

    <!-- Хлебные крошки -->
    <nav class="breadcrumbs" aria-label="Навигационная цепочка">
        <div class="container">
            <ol class="breadcrumbs__list">
                <li class="breadcrumbs__item">
                    <a href="<?php echo home_url(); ?>" class="breadcrumbs__link">
                        <i class="fa-solid fa-home breadcrumbs__icon" aria-hidden="true"></i>
                        <span>Главная</span>
                    </a>
                </li>
                <li class="breadcrumbs__separator" aria-hidden="true">»</li>
                <li class="breadcrumbs__item breadcrumbs__item_current">
                    <span class="breadcrumbs__current">Выполненные проекты</span>
                </li>
            </ol>
        </div>
    </nav>

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
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); 
                        // Получаем ACF поля
                        $power = get_field('power');
                        $industry = get_field('industry');
                        $city = get_field('city');
                        $year = get_field('year');
                        $client = get_field('client');
                        $power_range = get_field('power_range');
                    ?>
                        <article class="project-card" 
                            data-power="<?php echo esc_attr($power_range); ?>" 
                            data-industry="<?php echo esc_attr($industry); ?>" 
                            data-city="<?php echo esc_attr($city); ?>" 
                            data-year="<?php echo esc_attr($year); ?>">
                            <div class="project-card__image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('medium', ['alt' => get_the_title(), 'loading' => 'lazy']); ?>
                                <?php else : ?>
                                    <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&crop=center" 
                                         alt="<?php the_title(); ?>" 
                                         loading="lazy">
                                <?php endif; ?>
                                <?php if ( $power ) : ?>
                                    <div class="project-card__power"><?php echo esc_html($power); ?> кВт</div>
                                <?php endif; ?>
                            </div>
                            <div class="project-card__content">
                                <h3 class="project-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <?php if ( $client ) : ?>
                                    <p class="project-card__client"><?php echo esc_html($client); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>Проекты не найдены.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Пагинация -->
    <div class="container">
        <?php
        // Стандартная пагинация WordPress
        the_posts_pagination( array(
            'mid_size'  => 2,
            'prev_text' => '<i class="fa-solid fa-chevron-left"></i> Предыдущая',
            'next_text' => 'Следующая <i class="fa-solid fa-chevron-right"></i>',
        ) );
        ?>
    </div>

<?php get_footer(); ?>

