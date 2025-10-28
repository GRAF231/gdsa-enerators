# ТЕХНИЧЕСКИЙ КОНТЕКСТ

## ТЕХНОЛОГИИ И СТАНДАРТЫ

### Frontend Stack
```
HTML5
├── Семантическая разметка
├── БЭМ методология
├── Accessibility (ARIA)
└── SEO-оптимизация

CSS3
├── CSS Variables
├── Flexbox & Grid
├── Media Queries
├── Animations & Transitions
└── Glassmorphism & Градиенты

JavaScript ES6+
├── Vanilla JS (без фреймворков)
├── ES6 Classes
├── ES6 Modules
├── Async/Await
└── Intersection Observer API
```

### Инструменты
- **Font Awesome 6.5.2** - иконки
- **Google Fonts (Rubik)** - типографика
- **Git** - контроль версий

## БЭМ МЕТОДОЛОГИЯ

### Именование
```
.block { }                    /* Блок */
.block__element { }           /* Элемент */
.block_modifier_value { }     /* Модификатор */
```

### Примеры
```css
.header { }
.header__topbar { }
.header__logo { }
.header__top-item_dropdown { }
```

## СТРУКТУРА CSS

### Система загрузки стилей

**Условная загрузка (с 28.10.2025):**
- Все CSS файлы загружаются условно через `functions.php` на основе типа страницы
- **Базовые стили** (загружаются на всех страницах):
  - variables.css, reset.css, typography.css, layout.css
  - utilities.css, buttons.css, header.css, footer.css
  - breadcrumbs.css, pagination.css, contact-form.css
- **Условные стили** (загружаются только на нужных страницах):
  - Главная: home/*.css (7 файлов)
  - О компании: about/about.css, company-licenses.css
  - Контакты: contacts.css, contact-form.css
  - Производство: production.css
  - Проекты: projects.css
  - Благодарности: gratitude.css
  - Новости: news.css / news-article.css
  - Тендеры: tenders.css
  - Проектирование: design-epc.css

**WooCommerce стили (условная загрузка):**
- Каталог: catalog-table.css ИЛИ catalog-cards.css (в зависимости от режима просмотра)
- Товар: product.css, contact-form.css
- Корзина/Оформление: wc-cart-checkout.css
- Аккаунт: wc-account.css

**Преимущества условной загрузки:**
- Экономия 30-50% трафика на каждой странице
- Улучшение производительности (меньше CSS для парсинга)
- Отсутствие конфликтов стилей между страницами
- Более быстрая загрузка страниц

### Модули
```
assets/css/
├── main.css              # Базовые импорты (НЕ включает каталог и страничные стили)
├── variables.css         # CSS переменные
├── reset.css             # Сброс стилей браузера
├── typography.css        # Шрифты и типографика
├── layout.css            # Сетка и контейнеры
├── utilities.css         # Утилитарные классы
├── buttons.css           # Кнопки
├── header.css            # Шапка сайта
├── footer.css            # Подвал сайта
├── breadcrumbs.css       # Хлебные крошки
├── pagination.css        # Пагинация (кастомная)
├── contact-form.css      # Форма обратной связи
├── home/                 # Модули главной страницы
│   ├── home-slider.css
│   ├── home-catalog.css
│   ├── home-advantages.css
│   ├── home-equipment.css
│   ├── home-popular.css
│   ├── home-projects.css
│   ├── home-news.css
│   └── home-catalog-footer.css
├── about/about.css       # О компании
├── catalog-table.css     # Каталог (табличный вид)
├── catalog-cards.css     # Каталог (карточный вид)
├── catalog-footer.css    # Футер каталога
├── product.css           # Страница товара
├── contacts.css          # Контакты
├── tenders.css           # Тендеры
├── production.css        # Производство
├── projects.css          # Проекты
├── gratitude.css         # Благодарности
├── company-licenses.css  # Лицензии компании
├── design-epc.css        # Проектирование и EPC
└── woocommerce/          # WooCommerce стили
    ├── wc-cart-checkout.css  # Корзина и оформление
    └── wc-account.css         # Личный кабинет
```

### CSS Variables
```css
/* Цвета */
--primary: #0a1855;
--primary-light: #3b5fdb;
--accent: #00c2ff;
--text-dark: #3D3D3D;
--bg-light: #ffffff;

/* Типографика */
--font-main: 'Rubik', sans-serif;
--fs-base: 16px;

/* Spacing */
--spacing-md: 16px;

/* Радиусы */
--radius-lg: 12px;

/* Тени */
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);

/* Переходы */
--transition-base: 0.3s ease;
```

## СТРУКТУРА JAVASCRIPT

### Система загрузки скриптов

**Условная загрузка (с 28.10.2025):**
- Все JS файлы загружаются условно через `functions.php` на основе типа страницы
- **Базовый скрипт** (загружается на всех страницах):
  - main.js - Header, Footer, общий функционал
- **Условные скрипты** (загружаются только на нужных страницах):
  - Главная: home-slider.js, home-popular.js, home-projects.js
  - О компании: about.js
  - Контакты: contacts.js
  - Производство: production.js
  - Проекты: projects.js
  - Тендеры: tenders.js
  - Проектирование: design-epc.js
  - Благодарности: gratitude.js
  - Новости: news.js

**WooCommerce скрипты (условная загрузка):**
- Каталог: wc-catalog.js (фильтры, переключение видов, кнопки "Выводить по")
- Товар: product.js (галерея, форма консультации)
- Корзина/Оформление: wc-unified-checkout.js (AJAX, валидация, маски)

### Модули
```
assets/js/
├── main.js              # Header, Footer, общее (всегда загружается)
├── home-slider.js       # Главный слайдер
├── home-popular.js      # Популярные товары
├── home-projects.js     # Галерея проектов
├── about.js             # О компании
├── contacts.js          # Контакты
├── production.js        # Производство
├── projects.js          # Проекты
├── tenders.js           # Тендеры
├── product.js           # Страница товара
├── gratitude.js         # Благодарности
├── design-epc.js        # Проектирование и EPC
├── news.js              # Новости
├── catalog.js           # Каталог (устаревший, для справки)
└── woocommerce/         # WooCommerce скрипты
    ├── wc-catalog.js           # Каталог (фильтры, переключение видов, "Выводить по")
    └── wc-unified-checkout.js  # Корзина и оформление (AJAX, валидация)
```

### Архитектура
```javascript
// Классовый подход ES6
class ComponentName {
  constructor(selector) {
    this.element = document.querySelector(selector);
    this.init();
  }
  
  init() {
    this.setupEventListeners();
    this.setupObservers();
  }
}

// Инициализация
document.addEventListener('DOMContentLoaded', () => {
  new ComponentName('.component');
});
```

## АДАПТИВНОСТЬ

### Брейкпоинты
```css
/* Desktop Large */
@media (max-width: 1400px) { }

/* Desktop Medium */
@media (max-width: 1200px) { }

/* Tablet */
@media (max-width: 992px) { }

/* Tablet Small */
@media (max-width: 768px) { }

/* Mobile */
@media (max-width: 576px) { }

/* Mobile Small */
@media (max-width: 360px) { }
```

### Подход
- **Mobile-First** - базовые стили для мобильных
- **Progressive Enhancement** - улучшения для больших экранов
- **Flexbox & Grid** - современные раскладки
- **Responsive Images** - адаптивные изображения

## ПРОИЗВОДИТЕЛЬНОСТЬ

### Оптимизация
- Минификация CSS и JS
- Lazy Loading изображений
- Debouncing для resize/scroll
- requestAnimationFrame для анимаций
- Критичный CSS в `<head>`
- Удаление неиспользуемого CSS

### Web Vitals
- **LCP** (Largest Contentful Paint) < 2.5s
- **FID** (First Input Delay) < 100ms
- **CLS** (Cumulative Layout Shift) < 0.1

## ДОСТУПНОСТЬ (A11Y)

### ARIA
```html
<nav aria-label="Основная навигация">
<button aria-haspopup="true" aria-expanded="false">
<div role="dialog" aria-modal="true">
<input aria-required="true" aria-invalid="false">
```

### Клавиатурная навигация
- Tab - следующий элемент
- Shift+Tab - предыдущий элемент
- Enter/Space - активация
- Escape - закрытие модальных окон
- Arrow keys - навигация в слайдерах

### Focus Management
```css
*:focus-visible {
  outline: 2px solid var(--accent);
  outline-offset: 2px;
}
```

## SEO

### Семантика
```html
<header>, <nav>, <main>, <article>, <section>, <aside>, <footer>
```

### Мета-теги
```html
<title>...</title>
<meta name="description" content="...">
<meta property="og:title" content="...">
<link rel="canonical" href="...">
```

### Структурированные данные
```json
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "...",
  "description": "...",
  "image": "...",
  "offers": { ... }
}
```

## WORDPRESS ИНТЕГРАЦИЯ

### Структура темы
```
/ (корень проекта)
├── style.css              # Информация о теме
├── functions.php          # Функции темы (условная загрузка стилей/скриптов)
├── header.php             # Шапка
├── footer.php             # Подвал
├── sidebar.php            # Боковая панель
├── front-page.php         # Главная страница
├── page.php               # Стандартная страница
├── single.php             # Одиночная запись
├── template-about.php     # Шаблон страницы "О компании"
├── template-contacts.php  # Шаблон страницы "Контакты"
├── template-production.php # Шаблон страницы "Производство"
├── template-projects.php  # Шаблон страницы "Проекты"
├── template-tenders.php   # Шаблон страницы "Тендеры"
├── template-gratitude.php # Шаблон страницы "Благодарности"
├── template-design-epc.php # Шаблон страницы "Проектирование и EPC"
├── single-project.php     # Шаблон отдельного проекта
├── single-tender.php      # Шаблон отдельного тендера
├── archive-project.php    # Архив проектов
├── archive-tender.php     # Архив тендеров
├── search.php             # Поиск
├── 404.php                # Ошибка 404
├── woocommerce/           # Шаблоны WooCommerce (кастомные)
│   ├── archive-product.php         # Каталог товаров (кастомная структура)
│   ├── catalog-filters.php         # Панель фильтров (кастомная сортировка)
│   ├── single-product.php          # Страница товара
│   ├── content-single-product.php  # Контент товара
│   ├── cart-checkout-unified.php   # Объединенная корзина и оформление
│   ├── cart/
│   │   ├── cart-items.php          # Товары в корзине
│   │   └── cart-totals.php         # Итоговая сумма
│   ├── checkout/
│   │   ├── form-checkout.php       # Форма оформления
│   │   └── thankyou.php            # Страница благодарности
│   ├── myaccount/                   # Личный кабинет
│   │   ├── dashboard.php
│   │   ├── orders.php
│   │   ├── view-order.php
│   │   ├── form-edit-account.php
│   │   └── form-edit-address.php
│   └── single-product/              # Компоненты страницы товара
│       ├── product-gallery.php
│       ├── product-info.php
│       ├── product-options.php
│       ├── product-tabs.php
│       ├── product-contact-form.php
│       ├── product-team.php
│       ├── product-related.php
│       ├── tab-specifications.php
│       └── tab-documentation.php
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── acf-exports/           # Экспорты ACF полей
│   ├── group_home_page_fields.json
│   ├── group_about-page-fields.json
│   ├── group_contacts-page-fields.json
│   ├── group_production-page-fields.json
│   ├── group_tenders-page-fields.json
│   ├── group_gratitude-page-fields.json
│   ├── group_project-fields.json
│   ├── group_tender-fields.json
│   └── group_product-fields.json     # 24 ACF поля для товаров
└── memory-bank/           # Документация проекта
    ├── projectbrief.md
    ├── techContext.md
    ├── systemPatterns.md
    ├── productContext.md
    ├── tasks.md
    ├── progress.md
    ├── activeContext.md
    ├── WOOCOMMERCE_PLAN.md
    ├── WOOCOMMERCE_VAN_REPORT.md
    └── creative/          # CREATIVE режим документы
        ├── woocommerce-catalog-design.md
        ├── woocommerce-product-page-design.md
        ├── woocommerce-unified-checkout-design.md
        └── woocommerce-acf-fields-design.md
```

### WooCommerce: Кастомизации и особенности

#### Каталог товаров

**Два режима отображения:**
- **Табличный вид** (`?view=list`) - catalog-table.css
- **Карточный вид** (`?view=cards`) - catalog-cards.css
- Переключение через GET параметр + Cookie (30 дней)
- Функция `dsa_get_catalog_view()` определяет текущий режим

**Кастомная пагинация:**
- Функция `dsa_woocommerce_pagination()` заменяет стандартную
- Использует класс `.pagination` вместо `.woocommerce-pagination`
- Структура: `.pagination__nav`, `.pagination__pages`, `.pagination__btn`
- Сохраняет параметр `view` при переходе между страницами
- Генерирует URL в формате `/shop/page/2/?view=list`

**Блок "Выводить по":**
- Опции: 50, 100, 200, 500 товаров на странице
- По умолчанию: 100 товаров
- Сохранение в Cookie (`catalog_per_page`, 30 дней)
- JavaScript обработка в `wc-catalog.js`

**Кастомная сортировка:**
- Функция в `catalog-filters.php` заменяет `woocommerce_catalog_ordering()`
- Структура: `<label>` + `<select>` с классом `.catalog-filters__select`
- Отключена стандартная: `remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30)`
- Отключен счетчик результатов: `remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20)`
- Сохраняет параметр `view` при смене сортировки

#### Условная загрузка стилей WooCommerce

```php
// В functions.php
function dsa_woocommerce_assets() {
    // Каталог: загружается catalog-table.css ИЛИ catalog-cards.css
    if (is_shop() || is_product_category() || is_product_tag()) {
        $catalog_view = dsa_get_catalog_view();
        wp_enqueue_style('dsa-catalog-' . $catalog_view, ...);
        wp_enqueue_script('dsa-wc-catalog', ...);
    }
    
    // Товар: загружается product.css
    if (is_product()) {
        wp_enqueue_style('dsa-product', ...);
        wp_enqueue_script('dsa-product', ...);
    }
    
    // Корзина/Оформление
    if (is_cart() || is_checkout()) {
        wp_enqueue_style('dsa-wc-cart-checkout', ...);
        wp_enqueue_script('dsa-wc-unified-checkout', ...);
    }
    
    // Личный кабинет
    if (is_account_page()) {
        wp_enqueue_style('dsa-wc-account', ...);
    }
}
```

#### ACF Интеграция для товаров

**24 поля в 7 категориях:**
1. Основные характеристики (power, voltage, frequency, phases, power_factor, cos_phi)
2. Двигатель (engine_manufacturer, engine_model, engine_displacement, engine_cylinders)
3. Эксплуатация (fuel_tank, fuel_consumption, noise_level, cooling_system)
4. Габариты и вес (dimensions_length, dimensions_width, dimensions_height, weight)
5. Дополнительно (warranty, country, start_type)
6. Документация (instruction_manual, certificates, data_sheet)
7. Опции и преимущества (repeater fields)

### Функции в functions.php

#### Условная загрузка ресурсов

```php
// Главная функция загрузки стилей и скриптов
function dsa_generators_assets() {
    // Базовые стили (всегда)
    $base_styles = array('variables', 'reset', 'typography', ...);
    
    // Условные стили (по типу страницы)
    if (is_front_page()) { /* загрузка home/*.css */ }
    if (is_page_template('template-about.php')) { /* загрузка about/about.css */ }
    // ...
}

// WooCommerce функция загрузки
function dsa_woocommerce_assets() {
    // Условная загрузка WooCommerce стилей
    if (is_shop()) { /* каталог */ }
    if (is_product()) { /* товар */ }
    if (is_cart() || is_checkout()) { /* корзина/оформление */ }
    if (is_account_page()) { /* личный кабинет */ }
}
```

#### WooCommerce настройки

```php
// Количество товаров на странице (динамическое)
add_filter('loop_shop_per_page', function() {
    $allowed = array(50, 100, 200, 500);
    $default = 100;
    
    // GET параметр → Cookie → default
    if (isset($_GET['per_page'])) { /* ... */ }
    if (isset($_COOKIE['catalog_per_page'])) { /* ... */ }
    
    return $default;
});

// Определение режима каталога
function dsa_get_catalog_view() {
    // GET параметр ?view= (приоритет)
    // Cookie catalog_view (сохранение)
    // По умолчанию: 'list'
}

// Кастомная пагинация
function dsa_woocommerce_pagination() {
    // Генерирует URL с сохранением view
    // Использует класс .pagination
    // Структура: .pagination__nav, .pagination__pages
}
```

## СТАНДАРТЫ КОДА

### HTML
- Семантическая разметка
- БЭМ именование классов
- Валидный HTML5
- Accessibility атрибуты

### CSS
- БЭМ методология
- CSS Variables для переменных
- Mobile-First подход
- Модульная структура

### JavaScript
- ES6+ синтаксис
- Классовая архитектура
- Модульная структура
- JSDoc комментарии
- Обработка ошибок

## ПОСЛЕДНЕЕ ОБНОВЛЕНИЕ
**28 октября 2025**

### Ключевые изменения:
- ✅ Внедрена условная загрузка стилей и скриптов (экономия 30-50% трафика)
- ✅ Переименованы CSS файлы каталога: catalog-table.css, catalog-cards.css
- ✅ Добавлен блок "Выводить по" с опциями 50, 100, 200, 500 товаров
- ✅ Создана кастомная пагинация WooCommerce с сохранением режима просмотра
- ✅ Создана кастомная сортировка WooCommerce
- ✅ Исправлена структура каталога (page-header, catalog-filters)
- ✅ Изменено количество товаров по умолчанию с 12 на 100
