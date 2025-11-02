<?php
/**
 * ============================================
 * ГЕНЕРАТОР ТЕСТОВЫХ НОВОСТЕЙ
 * ============================================
 * 
 * Скрипт для генерации тестовых статей с ACF полями
 * для проверки работы страницы новостей
 * 
 * @package DSA_Generators
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Добавляем пункт меню в админке
add_action('admin_menu', 'dsa_news_generator_menu');

function dsa_news_generator_menu() {
    add_management_page(
        'Генератор тестовых новостей',
        'Тестовые новости',
        'manage_options',
        'dsa-news-generator',
        'dsa_news_generator_page'
    );
}

// Страница генератора в админке
function dsa_news_generator_page() {
    ?>
    <div class="wrap">
        <h1>Генератор тестовых новостей</h1>
        <p>Создание тестовых статей для проверки работы страницы новостей с ACF полями.</p>
        
        <div class="card" style="max-width: 600px; margin-top: 20px;">
            <h2>Генерация статей</h2>
            <p>Будет создано 4 тестовые статьи с разными категориями и ACF блоками:</p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li>Статья о компании</li>
                <li>Статья о продукции</li>
                <li>Статья о проектах</li>
                <li>Статья о событиях</li>
            </ul>
            
            <p><strong>Категории будут созданы автоматически, если их нет.</strong></p>
            
            <button type="button" id="generate-news-btn" class="button button-primary button-large" style="margin-top: 20px;">
                <span class="dashicons dashicons-plus" style="margin-top: 3px;"></span>
                Сгенерировать тестовые новости
            </button>
            
            <div id="generator-result" style="margin-top: 20px;"></div>
        </div>
        
        <div class="card" style="max-width: 600px; margin-top: 20px; background: #fff3cd; border-left: 4px solid #ffc107;">
            <h2>⚠️ Удаление тестовых новостей</h2>
            <p>Удалит все статьи с тегом "test-news"</p>
            
            <button type="button" id="delete-news-btn" class="button button-secondary" style="margin-top: 10px;">
                <span class="dashicons dashicons-trash" style="margin-top: 3px;"></span>
                Удалить тестовые новости
            </button>
        </div>
    </div>
    
    <style>
        #generator-result {
            padding: 15px;
            border-radius: 4px;
            display: none;
        }
        #generator-result.success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            display: block;
        }
        #generator-result.error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            display: block;
        }
        #generator-result.loading {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            display: block;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        $('#generate-news-btn').on('click', function() {
            var btn = $(this);
            var result = $('#generator-result');
            
            btn.prop('disabled', true);
            result.removeClass('success error').addClass('loading').html('⏳ Генерация статей...').show();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'dsa_generate_test_news',
                    nonce: '<?php echo wp_create_nonce('dsa_generate_news_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        result.removeClass('loading').addClass('success').html('✅ ' + response.data.message);
                    } else {
                        result.removeClass('loading').addClass('error').html('❌ ' + response.data.message);
                    }
                    btn.prop('disabled', false);
                },
                error: function() {
                    result.removeClass('loading').addClass('error').html('❌ Ошибка при генерации новостей');
                    btn.prop('disabled', false);
                }
            });
        });
        
        $('#delete-news-btn').on('click', function() {
            if (!confirm('Вы уверены что хотите удалить все тестовые новости?')) {
                return;
            }
            
            var btn = $(this);
            var result = $('#generator-result');
            
            btn.prop('disabled', true);
            result.removeClass('success error').addClass('loading').html('⏳ Удаление статей...').show();
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'dsa_delete_test_news',
                    nonce: '<?php echo wp_create_nonce('dsa_delete_news_nonce'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        result.removeClass('loading').addClass('success').html('✅ ' + response.data.message);
                    } else {
                        result.removeClass('loading').addClass('error').html('❌ ' + response.data.message);
                    }
                    btn.prop('disabled', false);
                },
                error: function() {
                    result.removeClass('loading').addClass('error').html('❌ Ошибка при удалении новостей');
                    btn.prop('disabled', false);
                }
            });
        });
    });
    </script>
    <?php
}

// AJAX обработчик генерации
add_action('wp_ajax_dsa_generate_test_news', 'dsa_generate_test_news_ajax');

function dsa_generate_test_news_ajax() {
    check_ajax_referer('dsa_generate_news_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'Недостаточно прав'));
    }
    
    $result = dsa_generate_test_news();
    
    if ($result['success']) {
        wp_send_json_success(array('message' => $result['message']));
    } else {
        wp_send_json_error(array('message' => $result['message']));
    }
}

// AJAX обработчик удаления
add_action('wp_ajax_dsa_delete_test_news', 'dsa_delete_test_news_ajax');

function dsa_delete_test_news_ajax() {
    check_ajax_referer('dsa_delete_news_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'Недостаточно прав'));
    }
    
    $result = dsa_delete_test_news();
    
    if ($result['success']) {
        wp_send_json_success(array('message' => $result['message']));
    } else {
        wp_send_json_error(array('message' => $result['message']));
    }
}

// Основная функция генерации
function dsa_generate_test_news() {
    // Создаем категории если их нет
    $categories = array(
        'o-kompanii' => 'О компании',
        'produktsiya' => 'Продукция',
        'proekty' => 'Проекты',
        'sobytiya' => 'События'
    );
    
    $category_ids = array();
    foreach ($categories as $slug => $name) {
        $term = term_exists($name, 'category');
        if (!$term) {
            $term = wp_insert_term($name, 'category', array('slug' => $slug));
        }
        if (!is_wp_error($term)) {
            $category_ids[$slug] = is_array($term) ? $term['term_id'] : $term;
        }
    }
    
    // Данные для статей
    $articles = array(
        array(
            'title' => 'Расширение производственных мощностей DSA Generators',
            'category' => 'o-kompanii',
            'excerpt' => 'Компания DSA Generators объявляет о запуске нового производственного цеха, что позволит увеличить объемы выпуска дизельных электростанций на 40%.',
            'image' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=1200&h=800&fit=crop',
        ),
        array(
            'title' => 'Презентация новой линейки генераторов Cummins',
            'category' => 'produktsiya',
            'excerpt' => 'Представляем новую серию дизельных генераторов Cummins с улучшенными характеристиками энергоэффективности и экологичности.',
            'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&h=800&fit=crop',
        ),
        array(
            'title' => 'Завершен проект энергоснабжения отеля в Сочи',
            'category' => 'proekty',
            'excerpt' => 'Успешно завершена поставка и монтаж шести ДГУ общей мощностью 8,8 МВт для премиального отеля в Сочи.',
            'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=1200&h=800&fit=crop',
        ),
        array(
            'title' => 'DSA Generators на выставке "Энергетика и электротехника"',
            'category' => 'sobytiya',
            'excerpt' => 'Компания приняла участие в крупнейшей отраслевой выставке, представив инновационные решения в области энергоснабжения.',
            'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200&h=800&fit=crop',
        ),
    );
    
    $created = 0;
    $errors = array();
    
    foreach ($articles as $article) {
        // Создаем пост
        $post_data = array(
            'post_title' => $article['title'],
            'post_excerpt' => $article['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_category' => array($category_ids[$article['category']]),
            'tags_input' => array('test-news') // Тег для идентификации тестовых постов
        );
        
        $post_id = wp_insert_post($post_data);
        
        if (is_wp_error($post_id)) {
            $errors[] = $article['title'];
            continue;
        }
        
        // Устанавливаем featured image (заглушка)
        // В реальности здесь можно загрузить изображение
        
        // Добавляем ACF поля
        update_field('news_show_hero', true, $post_id);
        update_field('news_subtitle', $article['excerpt'], $post_id);
        
        // Создаем ACF flexible content блоки - РАСШИРЕННАЯ ВЕРСИЯ
        $blocks = array();
        
        // БЛОК 1: Вводный текст
        $blocks[] = array(
            'acf_fc_layout' => 'text_block',
            'text' => '<p><strong>В условиях современного рынка</strong> электрогенерирующего оборудования компания DSA Generators продолжает укреплять свои позиции как один из ведущих производителей дизельных электростанций в России и странах СНГ. ' . $article['excerpt'] . '</p><p>Наша компания специализируется на проектировании, производстве и поставке электрогенерирующего оборудования мощностью от 10 кВт до 3 МВт. За годы работы мы реализовали более 500 проектов в различных отраслях промышленности, жилищно-коммунальном хозяйстве и коммерческой недвижимости.</p>'
        );
        
        // БЛОК 2: Заголовок H2
        $blocks[] = array(
            'acf_fc_layout' => 'heading',
            'heading_text' => 'Основные направления деятельности',
            'heading_level' => 'h2'
        );
        
        // БЛОК 3: Feature Cards (Карточки с иконками)
        $blocks[] = array(
            'acf_fc_layout' => 'feature_cards',
            'cards' => array(
                array(
                    'icon' => 'fa-solid fa-industry',
                    'title' => 'Промышленные решения',
                    'text' => 'Комплексные энергетические решения для промышленных предприятий с высокими требованиями к надежности и мощности'
                ),
                array(
                    'icon' => 'fa-solid fa-building',
                    'title' => 'Коммерческая недвижимость',
                    'text' => 'Системы резервного и основного электроснабжения для бизнес-центров, торговых комплексов и отелей'
                ),
                array(
                    'icon' => 'fa-solid fa-bolt',
                    'title' => 'Автономное энергоснабжение',
                    'text' => 'Решения для объектов с отсутствием централизованного электроснабжения или его нестабильностью'
                )
            )
        );
        
        // БЛОК 4: Текстовый блок
        $blocks[] = array(
            'acf_fc_layout' => 'text_block',
            'text' => '<p>Современные дизельные электростанции DSA Generators оснащены передовыми системами управления и мониторинга, что позволяет обеспечить максимальную эффективность работы и минимизировать эксплуатационные расходы. Все наши установки проходят многоступенчатый контроль качества и испытания перед отгрузкой заказчику.</p>'
        );
        
        // БЛОК 5: Заголовок H2
        $blocks[] = array(
            'acf_fc_layout' => 'heading',
            'heading_text' => 'Технические характеристики и преимущества',
            'heading_level' => 'h2'
        );
        
        // БЛОК 6: Specs Table (Таблица характеристик)
        $blocks[] = array(
            'acf_fc_layout' => 'specs_table',
            'specs_title' => 'Основные технические параметры',
            'specs_rows' => array(
                array('label' => 'Диапазон мощности', 'value' => '10 кВт — 3 МВт'),
                array('label' => 'Напряжение', 'value' => '220/380 В, 6 кВ, 10 кВ'),
                array('label' => 'Частота', 'value' => '50 Гц'),
                array('label' => 'Тип двигателя', 'value' => 'Дизельный, 4-тактный'),
                array('label' => 'Система охлаждения', 'value' => 'Жидкостная/воздушная'),
                array('label' => 'Шумозащита', 'value' => 'до 55 дБ(А) на расстоянии 7м'),
                array('label' => 'Степень автоматизации', 'value' => 'Полностью автоматическая'),
                array('label' => 'Гарантия', 'value' => 'до 3 лет или 3000 м/ч')
            )
        );
        
        // БЛОК 7: Список преимуществ
        $blocks[] = array(
            'acf_fc_layout' => 'heading',
            'heading_text' => 'Ключевые преимущества наших решений',
            'heading_level' => 'h2'
        );
        
        $blocks[] = array(
            'acf_fc_layout' => 'list',
            'list_type' => 'ul',
            'list_items' => array(
                array('item_text' => 'Использование двигателей ведущих мировых производителей: Cummins, Perkins, MTU, Volvo Penta'),
                array('item_text' => 'Современные системы управления и мониторинга с возможностью удаленного доступа'),
                array('item_text' => 'Автоматический ввод резерва (АВР) с временем переключения менее 10 секунд'),
                array('item_text' => 'Возможность параллельной работы нескольких установок для увеличения мощности'),
                array('item_text' => 'Контейнерное или капотированное исполнение с эффективной шумоизоляцией'),
                array('item_text' => 'Адаптация к экстремальным климатическим условиям (от -50°C до +50°C)'),
                array('item_text' => 'Полный комплекс сервисного обслуживания и технической поддержки 24/7'),
                array('item_text' => 'Гибкая система расчетов и возможность лизинговых схем приобретения')
            )
        );
        
        // БЛОК 8: Цитата
        $blocks[] = array(
            'acf_fc_layout' => 'quote',
            'quote_text' => 'Правильно подобранная и качественно установленная дизельная электростанция обеспечивает бесперебойную работу предприятия на десятилетия, окупая первоначальные инвестиции уже в первые годы эксплуатации.',
            'quote_author' => 'Технический директор DSA Generators'
        );
        
        // БЛОК 9: Процесс работы (нумерованный список)
        $blocks[] = array(
            'acf_fc_layout' => 'heading',
            'heading_text' => 'Этапы реализации проекта',
            'heading_level' => 'h2'
        );
        
        $blocks[] = array(
            'acf_fc_layout' => 'list',
            'list_type' => 'ol',
            'list_items' => array(
                array('item_text' => 'Анализ потребностей заказчика и обследование объекта нашими специалистами'),
                array('item_text' => 'Разработка технического решения и подбор оптимальной конфигурации оборудования'),
                array('item_text' => 'Подготовка коммерческого предложения с детальной сметой и сроками реализации'),
                array('item_text' => 'Проектирование системы электроснабжения и согласование с контролирующими органами'),
                array('item_text' => 'Производство и комплектация оборудования в соответствии с техническим заданием'),
                array('item_text' => 'Доставка, монтаж и пусконаладочные работы силами наших специалистов'),
                array('item_text' => 'Обучение персонала заказчика работе с оборудованием и системами управления'),
                array('item_text' => 'Передача объекта в эксплуатацию с полным комплектом документации'),
                array('item_text' => 'Сервисное обслуживание в течение всего срока эксплуатации')
            )
        );
        
        // БЛОК 10: Case Cards (Примеры проектов)
        $blocks[] = array(
            'acf_fc_layout' => 'heading',
            'heading_text' => 'Реализованные проекты',
            'heading_level' => 'h2'
        );
        
        $blocks[] = array(
            'acf_fc_layout' => 'case_cards',
            'cases' => array(
                array(
                    'title' => 'Металлургический комбинат — 2×2 МВт',
                    'meta' => 'Магнитогорск • 2024',
                    'description' => 'Установка двух дизельных электростанций общей мощностью 4 МВт для обеспечения резервного питания критически важных производственных линий. Реализована система автоматического ввода резерва с синхронизацией работы установок.'
                ),
                array(
                    'title' => 'Бизнес-центр класса А — 1500 кВт',
                    'meta' => 'Москва • 2024',
                    'description' => 'Комплексное решение для резервного электроснабжения офисного комплекса площадью 45,000 м². Контейнерное исполнение с пониженным уровнем шума для размещения в центре города.'
                ),
                array(
                    'title' => 'Горнодобывающее предприятие — 3×800 кВт',
                    'meta' => 'Якутия • 2023',
                    'description' => 'Автономная система электроснабжения для вахтового поселка и производственных объектов в условиях Крайнего Севера. Специальное климатическое исполнение для работы при температурах до -50°C.'
                )
            )
        );
        
        // БЛОК 11: Дополнительный текст
        $blocks[] = array(
            'acf_fc_layout' => 'text_block',
            'text' => '<p>За 15 лет работы на рынке электрогенерирующего оборудования мы накопили уникальный опыт реализации проектов различной сложности — от компактных резервных установок для загородных домов до масштабных энергетических комплексов для промышленных предприятий.</p><p>Наша производственная база оснащена современным оборудованием, что позволяет осуществлять полный цикл работ — от сборки и тестирования до отгрузки готовой продукции. Собственный конструкторский отдел разрабатывает нестандартные решения под специфические требования заказчиков.</p>'
        );
        
        // БЛОК 12: FAQ (Частые вопросы)
        $blocks[] = array(
            'acf_fc_layout' => 'heading',
            'heading_text' => 'Часто задаваемые вопросы',
            'heading_level' => 'h2'
        );
        
        $blocks[] = array(
            'acf_fc_layout' => 'faq',
            'faq_items' => array(
                array(
                    'question' => 'Как правильно рассчитать необходимую мощность электростанции?',
                    'answer' => 'Для точного расчета необходимо учесть суммарную мощность всех электроприборов, коэффициент одновременности их работы и пусковые токи. Наши специалисты проведут бесплатный анализ и подберут оптимальное решение.'
                ),
                array(
                    'question' => 'Какой срок службы у дизельных электростанций?',
                    'answer' => 'При правильной эксплуатации и своевременном техническом обслуживании дизельная электростанция может проработать 20-30 лет. Ресурс двигателя составляет 15,000-40,000 моточасов в зависимости от модели.'
                ),
                array(
                    'question' => 'Возможна ли работа электростанции в автоматическом режиме?',
                    'answer' => 'Да, все наши установки оснащены системами автоматического запуска и могут работать без участия оператора. При пропадании сетевого питания станция автоматически запускается и подает электроэнергию в течение 10-15 секунд.'
                ),
                array(
                    'question' => 'Какие двигатели вы используете в своем оборудовании?',
                    'answer' => 'Мы работаем только с проверенными производителями: Cummins, Perkins, MTU, Volvo Penta, Ricardo. Выбор двигателя зависит от требуемой мощности, условий эксплуатации и бюджета проекта.'
                ),
                array(
                    'question' => 'Предоставляете ли вы гарантию и сервисное обслуживание?',
                    'answer' => 'На все оборудование предоставляется гарантия от 1 до 3 лет. Мы осуществляем полный комплекс сервисных работ, включая плановое ТО, ремонт и поставку запасных частей. Служба поддержки работает 24/7.'
                )
            )
        );
        
        // БЛОК 13: Заключительный текст
        $blocks[] = array(
            'acf_fc_layout' => 'text_block',
            'text' => '<p>Компания DSA Generators постоянно развивается и совершенствует свою продукцию, следуя современным тенденциям в области энергетики. Мы инвестируем в исследования и разработки, чтобы предлагать нашим клиентам наиболее эффективные и экономичные решения.</p><p>Наша команда — это высококвалифицированные инженеры, технологи и сервисные специалисты, которые готовы решать самые сложные задачи в области автономного электроснабжения. Мы гордимся тем, что наше оборудование работает на объектах по всей России и в странах СНГ.</p>'
        );
        
        // БЛОК 14: CTA блок
        $blocks[] = array(
            'acf_fc_layout' => 'cta_block',
            'cta_title' => 'Готовы обсудить ваш проект?',
            'cta_text' => 'Свяжитесь с нами для получения бесплатной консультации и расчета стоимости. Наши специалисты ответят на все ваши вопросы и помогут подобрать оптимальное решение.',
            'cta_button_text' => 'Получить консультацию',
            'cta_button_link' => home_url('/contacts/')
        );
        
        update_field('news_content_blocks', $blocks, $post_id);
        
        // Sidebar поля
        update_field('news_sidebar_cta_title', 'Нужна консультация?', $post_id);
        update_field('news_sidebar_cta_text', 'Оставьте заявку, и инженер перезвонит в течение 15 минут.', $post_id);
        update_field('news_sidebar_cta_link', home_url('/contacts/'), $post_id);
        
        $created++;
    }
    
    if ($created > 0) {
        return array(
            'success' => true,
            'message' => "Успешно создано {$created} тестовых статей!"
        );
    } else {
        return array(
            'success' => false,
            'message' => 'Ошибка при создании статей: ' . implode(', ', $errors)
        );
    }
}

// Функция удаления тестовых новостей
function dsa_delete_test_news() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'tag' => 'test-news',
        'post_status' => 'any'
    );
    
    $posts = get_posts($args);
    $deleted = 0;
    
    foreach ($posts as $post) {
        wp_delete_post($post->ID, true);
        $deleted++;
    }
    
    if ($deleted > 0) {
        return array(
            'success' => true,
            'message' => "Удалено {$deleted} тестовых статей"
        );
    } else {
        return array(
            'success' => true,
            'message' => 'Тестовых статей не найдено'
        );
    }
}
