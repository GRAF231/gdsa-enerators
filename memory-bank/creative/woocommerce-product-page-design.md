# 🎨 CREATIVE PHASE: СТРАНИЦА ТОВАРА WOOCOMMERCE

**Дата:** 2025-10-28  
**Компонент:** Страница товара (single-product)  
**Статус:** ✅ Решение принято  
**Рекомендованный подход:** Опция C (Модульный подход с табами)

---

## 📋 ОПИСАНИЕ КОМПОНЕНТА

### Что это?
Страница товара WooCommerce для дизельных электростанций - детальная карточка товара с техническими характеристиками, галереей изображений, формой заказа и дополнительными блоками.

### Что должно делать?
1. **Отображать всю информацию о товаре:**
   - Галерея изображений с превью
   - Цена и наличие
   - Кнопка "В корзину"
   - Технические характеристики
   - Описание товара
   - Документация для скачивания

2. **Интегрироваться с WooCommerce:**
   - Корректная работа корзины
   - Обработка вариаций (если есть)
   - Связанные/похожие товары
   - Breadcrumbs

3. **Использовать существующий дизайн:**
   - Сохранить верстку из `product.html`
   - БЭМ методология
   - Адаптивность
   - Формы и блоки команды

4. **Интегрировать ACF поля:**
   - Дополнительные характеристики
   - Документация
   - Галерея двигателя
   - Дополнительные опции

---

## 🎯 ТРЕБОВАНИЯ И ОГРАНИЧЕНИЯ

### Функциональные требования:
- ✅ Сохранить все элементы из существующей верстки
- ✅ Работа корзины WooCommerce
- ✅ Галерея с лайтбоксом
- ✅ Табы: Описание / Характеристики / Документация
- ✅ Форма "Получить консультацию"
- ✅ Блок команды (6 сотрудников)
- ✅ Похожие товары
- ✅ Дополнительные опции (6 блоков)

### Технические ограничения:
- ✅ Должны работать хуки WooCommerce
- ✅ Совместимость с плагинами WooCommerce
- ✅ БЭМ методология в именовании классов
- ✅ Существующие CSS стили (product.css)
- ✅ JavaScript для галереи и табов

### UX/UI требования:
- ✅ Адаптивность: Desktop (1920px), Tablet (768px), Mobile (320px+)
- ✅ Быстрая загрузка изображений
- ✅ Понятная навигация
- ✅ Четкие CTA (Call To Action)

---

## 🔄 АНАЛИЗ СУЩЕСТВУЮЩЕЙ ВЕРСТКИ

### Структура `product.html` (1214 строк):

```
1. Header (строки 32-400) - используется из header.php ✅
2. Breadcrumbs (строки 403-422) - функция dsa_breadcrumbs() ✅
3. ОСНОВНОЙ КОНТЕНТ (строки 425-997):
   
   A. Заголовок товара (428-430)
      └── h1.product-title
   
   B. Основная информация (433-491)
      ├── .product-gallery
      │   └── .product-image-main + .product-badge
      └── .product-info
          ├── .product-details (5 характеристик)
          └── .product-purchase
              ├── .product-price
              ├── .product-stock
              └── .product-actions (2 кнопки)
   
   C. Технические характеристики (494-596)
      ├── .product-specs__content
      │   ├── Заголовок и подзаголовок
      │   ├── .specs-grid (8 характеристик)
      │   ├── .specs-section "Генератор" (2 модели)
      │   └── .specs-section "Габариты"
      └── .product-sidebar
          ├── Документация (3 PDF)
          └── Галерея двигателя
   
   D. Описание товара (599-605)
      └── .product-description
   
   E. Форма запроса (608-647)
      └── .contact-form (4 поля + чекбокс)
   
   F. Дополнительные опции (650-702)
      └── .product-options (6 опций с иконками)
   
   G. Команда (705-829)
      └── .product-team (6 карточек сотрудников)
   
   H. Похожие товары (832-988)
      └── .product-similar (4 карточки)
   
   I. Контакты (991-996)
      └── .product-contact

4. Footer (строки 1000-1207) - используется из footer.php ✅
```

### Ключевые элементы для интеграции:

#### 1. **Галерея** (требует доработки для WooCommerce):
- Текущая: одно изображение `.product-main-img`
- Нужна: галерея с превью + лайтбокс (WooCommerce gallery)

#### 2. **Характеристики** (нужна интеграция с ACF):
- `.product-details` - основные (существующие ACF поля)
- `.specs-grid` - технические (новые ACF поля)

#### 3. **Цена и корзина** (интеграция с WooCommerce):
- `.product-price__value` - должна быть динамической
- `.product-btn-cart` - должна работать с WooCommerce

#### 4. **Документация** (ACF Repeater):
- 3 PDF файла → ACF repeater с file полями

#### 5. **Дополнительные опции** (ACF Repeater):
- 6 опций → ACF repeater с icon + text

#### 6. **Команда** (можно оставить статической или сделать ACF):
- 6 сотрудников - пока статично

---

## 🔄 РАССМОТРЕННЫЕ ОПЦИИ

### ОПЦИЯ A: Полная замена стандартного шаблона

**Подход:** Создать `single-product.php` и полностью заменить HTML

**Преимущества:**
- ✅ Полный контроль над структурой
- ✅ Точное соответствие дизайну
- ✅ Легко переносить верстку

**Недостатки:**
- ❌ Потеря совместимости с плагинами WooCommerce
- ❌ Не работают многие хуки
- ❌ Проблемы с обновлениями WooCommerce
- ❌ Сложность с вариациями товаров

**Результат:** ❌ ОТКЛОНЕНА  
**Причина:** Критическая потеря функциональности WooCommerce

---

### ОПЦИЯ B: Использование хуков WooCommerce

**Подход:** Модифицировать стандартный шаблон через систему хуков

**Преимущества:**
- ✅ Полная совместимость с WooCommerce
- ✅ Работают все плагины
- ✅ Автоматические обновления

**Недостатки:**
- ❌ Очень сложно достичь точного соответствия дизайну
- ❌ Много хуков для изучения
- ❌ Запутанная логика с приоритетами
- ❌ Сложно контролировать порядок элементов

**Результат:** ❌ ОТКЛОНЕНА  
**Причина:** Невозможность точно воспроизвести существующий дизайн

---

### ОПЦИЯ C: Модульный подход с табами ✅

**Подход:** Кастомный `single-product.php` + `content-single-product.php` с модульной структурой

**Архитектура:**
```
woocommerce/
├── single-product.php              # Обертка (header + breadcrumbs + footer)
├── content-single-product.php      # Основной контент товара
└── single-product/
    ├── product-gallery.php         # Галерея изображений
    ├── product-info.php            # Блок информации (цена, кнопки)
    ├── product-tabs.php            # Табы (описание, характеристики, документация)
    ├── product-options.php         # Дополнительные опции
    ├── product-team.php            # Команда
    ├── product-related.php         # Похожие товары
    └── product-contact-form.php    # Форма консультации
```

**Преимущества:**
- ✅ Баланс между контролем и совместимостью
- ✅ Сохраняем ключевые хуки WooCommerce (корзина, цена, галерея)
- ✅ Модульная структура - легко поддерживать
- ✅ Точное соответствие дизайну
- ✅ Возможность использовать табы для организации контента

**Недостатки:**
- ⚠️ Нужно тестировать совместимость с плагинами
- ⚠️ Требуется грамотная интеграция хуков

**Результат:** ✅ ПРИНЯТА  
**Причина:** Оптимальный баланс функциональности и дизайна

---

### ОПЦИЯ D: Использование Page Builder

**Подход:** Elementor/WPBakery для построения страницы

**Преимущества:**
- ✅ Визуальное редактирование
- ✅ Легко для клиента менять

**Недостатки:**
- ❌ Зависимость от стороннего плагина
- ❌ Раздутый код
- ❌ Медленная загрузка
- ❌ Не соответствует методологии проекта

**Результат:** ❌ ОТКЛОНЕНА  
**Причина:** Не соответствует архитектуре проекта

---

## ✅ РЕКОМЕНДОВАННОЕ РЕШЕНИЕ: МОДУЛЬНЫЙ ПОДХОД

### Структура файлов:

```
woocommerce/
├── single-product.php                      # Главный шаблон (обертка)
├── content-single-product.php              # Основной контент
└── single-product/
    ├── product-gallery.php                 # Галерея WooCommerce
    ├── product-info.php                    # Цена + кнопки + характеристики
    ├── product-tabs.php                    # Табы контента
    │   ├── tab-description.php             # Таб "Описание"
    │   ├── tab-specifications.php          # Таб "Характеристики"
    │   └── tab-documentation.php           # Таб "Документация"
    ├── product-options.php                 # Дополнительные опции (ACF)
    ├── product-team.php                    # Наша команда
    ├── product-related.php                 # Похожие товары
    └── product-contact-form.php            # Форма запроса
```

### Ключевые хуки WooCommerce (сохраняем):

```php
// В product-info.php
woocommerce_template_single_title()         // Название товара
woocommerce_template_single_price()         // Цена
woocommerce_template_single_add_to_cart()   // Кнопка в корзину
woocommerce_template_single_meta()          // Метаданные (SKU, категории)

// В product-gallery.php
woocommerce_show_product_images()           // Галерея изображений

// В product-related.php
woocommerce_output_related_products()       // Похожие товары
```

### Новые ACF поля (расширенные):

#### Группа 1: "Технические характеристики" (продолжение)
```json
{
  "engine_volume": "number",           // Объем двигателя (л)
  "country_engine": "text",            // Страна двигателя
  "max_power": "number",               // Максимальная мощность (кВт)
  "oil_volume": "number",              // Объем масла (л)
  "cylinder_config": "text",           // Расположение цилиндров
  "cooling_type": "select",            // Тип охлаждения
  "rotation_speed": "number",          // Частота вращения (об/мин)
  "generator_model_1": "text",         // Модель генератора 1
  "generator_model_2": "text",         // Модель генератора 2
  "dimensions": "text",                // Габариты (ДxШxВ мм)
  "weight": "number"                   // Вес (кг)
}
```

#### Группа 2: "Документация"
```json
{
  "documents": "repeater" [
    {
      "doc_title": "text",             // Название документа
      "doc_file": "file"               // PDF файл
    }
  ]
}
```

#### Группа 3: "Галерея двигателя"
```json
{
  "engine_gallery": "gallery"          // Галерея изображений двигателя
}
```

#### Группа 4: "Дополнительные опции"
```json
{
  "additional_options": "repeater" [
    {
      "option_icon": "text",           // FontAwesome класс иконки
      "option_text": "textarea"        // Текст опции
    }
  ]
}
```

#### Группа 5: "Описание товара"
```json
{
  "full_description": "wysiwyg"        // Полное описание
}
```

### Интеграция с существующими стилями:

**CSS:** Используем `assets/css/product.css` (1400 строк)
- Все классы БЭМ сохраняются
- Дополнительные стили для WooCommerce элементов

**JavaScript:** Используем `assets/js/product.js`
- Галерея (если нужна кастомная логика)
- Табы
- Формы

---

## 📐 ДЕТАЛЬНАЯ АРХИТЕКТУРА

### 1. single-product.php (Обертка)

```php
<?php
get_header();

// Breadcrumbs
if (function_exists('dsa_breadcrumbs')) {
    dsa_breadcrumbs();
}
?>

<main class="main-content">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            wc_get_template_part('content', 'single-product');
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
```

### 2. content-single-product.php (Основной контент)

```php
<?php
global $product;
?>

<!-- Заголовок товара -->
<div class="product-header">
    <h1 class="product-title"><?php the_title(); ?></h1>
</div>

<!-- Основная информация -->
<div class="product-main">
    <?php 
    // Галерея
    wc_get_template('single-product/product-gallery.php');
    
    // Информация и покупка
    wc_get_template('single-product/product-info.php');
    ?>
</div>

<!-- Технические характеристики -->
<?php wc_get_template('single-product/product-tabs.php'); ?>

<!-- Описание -->
<div class="product-description">
    <?php the_content(); ?>
</div>

<!-- Форма консультации -->
<?php wc_get_template('single-product/product-contact-form.php'); ?>

<!-- Дополнительные опции -->
<?php wc_get_template('single-product/product-options.php'); ?>

<!-- Команда -->
<?php wc_get_template('single-product/product-team.php'); ?>

<!-- Похожие товары -->
<?php wc_get_template('single-product/product-related.php'); ?>

<!-- Контакты -->
<div class="product-contact">
    <div class="contact-info">
        <p class="contact-text">Подбор оборудования, КП с детализацией цены...</p>
        <a href="mailto:order@dsa-generators.ru" class="contact-email">order@dsa-generators.ru</a>
    </div>
</div>
```

### 3. product-info.php (Цена + характеристики + кнопки)

```php
<div class="product-info">
    <!-- Основные характеристики -->
    <div class="product-details">
        <?php
        // Производитель
        $country = get_field('country');
        // Мощность
        $power = get_field('power');
        $nominal_power = get_field('nominal_power');
        // Двигатель
        $engine = get_field('engine');
        $engine_country = get_field('country_engine');
        // Опции
        $options = get_field('additional_options');
        
        // Вывод характеристик
        ?>
    </div>

    <!-- Блок покупки -->
    <div class="product-purchase">
        <div class="product-price">
            <span class="product-price__label">Цена с НДС</span>
            <?php echo $product->get_price_html(); ?>
        </div>
        
        <div class="product-stock">
            <?php if ($product->is_in_stock()) : ?>
                <i class="fa-solid fa-check-circle"></i>
                <span>в наличии на складе</span>
            <?php else : ?>
                <i class="fa-solid fa-clock"></i>
                <span>под заказ</span>
            <?php endif; ?>
        </div>
        
        <div class="product-actions">
            <?php woocommerce_template_single_add_to_cart(); ?>
            
            <button class="btn btn_type_secondary product-btn-quote" type="button">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Запросить КП</span>
            </button>
        </div>
    </div>
</div>
```

### 4. product-tabs.php (Табы)

```php
<div class="product-specs">
    <div class="product-tabs">
        <div class="product-tabs__nav">
            <button class="product-tabs__btn active" data-tab="description">Описание</button>
            <button class="product-tabs__btn" data-tab="specifications">Характеристики</button>
            <button class="product-tabs__btn" data-tab="documentation">Документация</button>
        </div>
        
        <div class="product-tabs__content">
            <!-- Таб "Описание" -->
            <div class="product-tabs__panel active" data-panel="description">
                <?php wc_get_template('single-product/tab-description.php'); ?>
            </div>
            
            <!-- Таб "Характеристики" -->
            <div class="product-tabs__panel" data-panel="specifications">
                <?php wc_get_template('single-product/tab-specifications.php'); ?>
            </div>
            
            <!-- Таб "Документация" -->
            <div class="product-tabs__panel" data-panel="documentation">
                <?php wc_get_template('single-product/tab-documentation.php'); ?>
            </div>
        </div>
    </div>
    
    <!-- Sidebar (галерея двигателя) -->
    <div class="product-sidebar">
        <?php
        $engine_gallery = get_field('engine_gallery');
        if ($engine_gallery) :
        ?>
            <div class="sidebar-section">
                <h3 class="sidebar-section__title">Фотографии двигателя</h3>
                <div class="engine-gallery">
                    <?php foreach ($engine_gallery as $image) : ?>
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
```

### 5. tab-specifications.php (Характеристики)

```php
<div class="specs-grid">
    <?php
    // Массив характеристик для вывода
    $specs = [
        'engine_volume' => 'Объём двигателя, л',
        'country_engine' => 'Страна',
        'power' => 'Номинальная мощность',
        'max_power' => 'Максимальная мощность, кВт',
        'oil_volume' => 'Объём масляной системы, л',
        'cylinder_config' => 'Расположение цилиндров',
        'cooling_type' => 'Тип охлаждения двигателя',
        'rotation_speed' => 'Частота вращения, об/мин'
    ];
    
    foreach ($specs as $key => $label) :
        $value = get_field($key);
        if ($value) :
    ?>
        <div class="spec-item">
            <span class="spec-label"><?php echo esc_html($label); ?></span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo esc_html($value); ?></span>
        </div>
    <?php 
        endif;
    endforeach; 
    ?>
</div>

<!-- Генератор -->
<?php if (get_field('generator_model_1') || get_field('generator_model_2')) : ?>
<div class="specs-section">
    <h3 class="specs-section__title">Генератор переменного тока</h3>
    <div class="specs-section__content">
        <?php if (get_field('generator_model_1')) : ?>
        <div class="spec-item">
            <span class="spec-label">Модель 1</span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo get_field('generator_model_1'); ?></span>
        </div>
        <?php endif; ?>
        
        <?php if (get_field('generator_model_2')) : ?>
        <div class="spec-item">
            <span class="spec-label">Модель 2</span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo get_field('generator_model_2'); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Габариты -->
<?php if (get_field('dimensions')) : ?>
<div class="specs-section">
    <h3 class="specs-section__title">Габариты ДЭС</h3>
    <div class="specs-section__content">
        <div class="spec-item">
            <span class="spec-label">Габариты, мм</span>
            <span class="spec-dots"></span>
            <span class="spec-value"><?php echo get_field('dimensions'); ?></span>
        </div>
    </div>
</div>
<?php endif; ?>
```

### 6. tab-documentation.php (Документация)

```php
<?php
$documents = get_field('documents');

if ($documents) :
?>
<div class="documents-list">
    <?php foreach ($documents as $doc) : ?>
        <a href="<?php echo esc_url($doc['doc_file']['url']); ?>" class="document-item" target="_blank">
            <i class="fa-solid fa-file-pdf"></i>
            <span><?php echo esc_html($doc['doc_title']); ?></span>
        </a>
    <?php endforeach; ?>
</div>
<?php else : ?>
    <p>Документация для данного товара отсутствует.</p>
<?php endif; ?>
```

---

## 🎨 СТИЛИСТИЧЕСКИЕ РЕШЕНИЯ

### Галерея изображений:
- **WooCommerce Gallery:** Использовать стандартную галерею с поддержкой zoom/lightbox
- **Превью:** 4 миниатюры под главным изображением
- **Лайтбокс:** Встроенный в WooCommerce

### Табы:
- **Дизайн:** Горизонтальные табы с подчеркиванием активного
- **Анимация:** Плавное появление контента
- **Адаптив:** На мобильных - аккордеон

### Кнопки:
- **"В корзину":** `btn btn_type_primary` (синяя)
- **"Запросить КП":** `btn btn_type_secondary` (белая с рамкой)

---

## 📱 АДАПТИВНОСТЬ

### Desktop (1920px+):
- Двухколоночная сетка (галерея + инфо)
- Характеристики: 2 колонки
- Команда: 3 колонки
- Похожие товары: 4 карточки

### Tablet (768px - 1199px):
- Двухколоночная сетка сохраняется
- Характеристики: 1 колонка
- Команда: 2 колонки
- Похожие товары: 3 карточки

### Mobile (320px - 767px):
- Одна колонка
- Галерея на всю ширину
- Характеристики: список
- Команда: 1 колонка (прокрутка)
- Похожие товары: 2 карточки

---

## ✅ ПРЕИМУЩЕСТВА ВЫБРАННОГО РЕШЕНИЯ

### 1. Совместимость:
- ✅ Работают хуки WooCommerce (корзина, цена, галерея)
- ✅ Совместимость с плагинами (WooCommerce PDF Invoices, etc.)
- ✅ Сохранена структура WooCommerce

### 2. Гибкость:
- ✅ Модульная архитектура - легко изменять отдельные части
- ✅ ACF поля - клиент может редактировать через админку
- ✅ Табы - организация большого объема контента

### 3. Производительность:
- ✅ Ленивая загрузка изображений
- ✅ Минимум JS
- ✅ CSS от существующей верстки

### 4. Поддержка:
- ✅ Чистый код
- ✅ Комментарии в PHP
- ✅ БЭМ методология
- ✅ Документация ACF полей

---

## 📋 IMPLEMENTATION GUIDELINES (Для IMPLEMENT режима)

### Шаг 1: Создать ACF поля
1. Расширить `group_product-fields.json`
2. Добавить группы: "Технические характеристики (расширенные)", "Документация", "Галерея двигателя", "Дополнительные опции"
3. Экспортировать в JSON

### Шаг 2: Создать файлы шаблонов
1. `woocommerce/single-product.php`
2. `woocommerce/content-single-product.php`
3. Модули в `woocommerce/single-product/`:
   - `product-gallery.php`
   - `product-info.php`
   - `product-tabs.php`
   - `tab-description.php`
   - `tab-specifications.php`
   - `tab-documentation.php`
   - `product-contact-form.php`
   - `product-options.php`
   - `product-team.php`
   - `product-related.php`

### Шаг 3: Интегрировать стили
1. Проверить `assets/css/product.css` - все классы должны совпадать
2. Добавить стили для табов (если нужно)
3. Добавить стили для WooCommerce элементов

### Шаг 4: Добавить JavaScript
1. Табы (переключение)
2. Форма консультации (валидация)
3. Галерея (если кастомная логика)

### Шаг 5: Тестирование
1. Добавление в корзину
2. Цена корректно отображается
3. Галерея работает
4. Табы переключаются
5. ACF поля выводятся
6. Похожие товары показываются
7. Адаптивность на всех устройствах

---

## 🔍 VERIFICATION CHECKPOINT

### ✅ Проверка соответствия требованиям:

- [x] Определены все компоненты страницы товара
- [x] Рассмотрены 4 опции интеграции
- [x] Выбран оптимальный подход (Модульный)
- [x] Определена структура ACF полей
- [x] Разработана архитектура файлов
- [x] Описана интеграция с WooCommerce хуками
- [x] Определена адаптивность
- [x] Созданы implementation guidelines

### ✅ Проверка архитектуры:

- [x] Сохранены все элементы из `product.html`
- [x] Интегрированы хуки WooCommerce
- [x] Модульная структура
- [x] БЭМ методология
- [x] Совместимость с существующими стилями

### ✅ Проверка UX:

- [x] Понятная навигация (табы)
- [x] Быстрый доступ к характеристикам
- [x] Четкие CTA кнопки
- [x] Адаптивность для всех устройств

---

## 📊 МЕТРИКИ УСПЕХА

После реализации должны выполняться:

1. **Функциональность:**
   - ✅ Кнопка "В корзину" добавляет товар
   - ✅ Цена отображается корректно
   - ✅ Галерея работает (zoom/lightbox)
   - ✅ Табы переключаются
   - ✅ ACF поля выводятся

2. **Дизайн:**
   - ✅ 100% соответствие макету `product.html`
   - ✅ Все стили применяются
   - ✅ Адаптивность работает

3. **Производительность:**
   - ✅ Загрузка страницы < 3 сек
   - ✅ Lazy loading изображений
   - ✅ Нет лишних запросов к БД

4. **SEO:**
   - ✅ Правильные h1, h2, h3
   - ✅ Микроразметка товара
   - ✅ Alt теги изображений

---

## 🎯 NEXT STEPS (Для IMPLEMENT режима)

1. **Создать расширенные ACF поля** (15-20 полей)
2. **Создать модульные шаблоны** (10 файлов)
3. **Интегрировать с WooCommerce хуками**
4. **Добавить JavaScript для табов**
5. **Тестировать на тестовых товарах**

---

🎨🎨🎨 **EXITING CREATIVE PHASE**

**Решение принято:** Модульный подход с табами  
**Следующий режим:** IMPLEMENT MODE  
**Готовность к реализации:** ✅ 100%

**Дата завершения:** 2025-10-28  
**Автор:** AI Assistant (CREATIVE MODE)
