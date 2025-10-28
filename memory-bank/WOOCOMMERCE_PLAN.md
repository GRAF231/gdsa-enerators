# 🗺️ PLAN: ДЕТАЛЬНЫЙ ПЛАН ИНТЕГРАЦИИ WOOCOMMERCE

**Дата:** 2025-10-28  
**Режим:** PLAN (Planning & Architecture)  
**Сложность:** Level 4 (Enterprise)  
**Статус:** 🔵 В ПРОЦЕССЕ

---

## 📋 EXECUTIVE SUMMARY

Детальный план интеграции WooCommerce с существующей версткой. Определены конкретные шаги, архитектурные решения, структура ACF полей и последовательность реализации.

---

## 🏗️ АРХИТЕКТУРА ИНТЕГРАЦИИ

### 1. ПОДХОД К КАСТОМИЗАЦИИ ШАБЛОНОВ

**Выбранная стратегия:** **Гибридный подход**

#### Обоснование:
- ✅ Полный контроль над разметкой
- ✅ Использование хуков WooCommerce для расширяемости
- ✅ Легкая поддержка и обновление
- ✅ Сохранение совместимости с плагинами

#### Реализация:
```
woocommerce/
├── archive-product.php           # Кастомный шаблон каталога
│   └── Использует: woocommerce_product_loop_start/end
├── single-product.php             # Кастомный шаблон товара
│   └── Использует: woocommerce_single_product_summary
├── cart/cart.php                  # Кастомная корзина
├── checkout/form-checkout.php     # Кастомный чекаут
└── myaccount/                     # Кастомный личный кабинет
```

---

### 2. ИНТЕГРАЦИЯ С СУЩЕСТВУЮЩЕЙ ВЕРСТКОЙ

#### Каталог товаров (archive-product.php)

**Источник верстки:** `src/html/catalog-generators.html` (строки 400-800)

**БЭМ классы для сохранения:**
```css
.catalog-filters          # Панель фильтров
.catalog-filters__row     # Строка с фильтрами
.catalog-filters__sort    # Блок сортировки
.catalog-table           # Таблица товаров
.catalog-table__head     # Заголовок таблицы
.catalog-table__body     # Тело таблицы
.catalog-table__row      # Строка товара
.catalog-table__cell     # Ячейка
.catalog-card            # Карточка товара (альтернатива)
```

**Стратегия интеграции:**
1. Скопировать структуру HTML из `catalog-generators.html`
2. Заменить статические данные на WooCommerce функции:
   - `the_title()` → название товара
   - `get_the_post_thumbnail()` → изображение
   - `wc_get_product()` → объект товара
   - `$product->get_price_html()` → цена
3. Интегрировать WooCommerce хуки:
   - `woocommerce_before_shop_loop` → до списка
   - `woocommerce_after_shop_loop` → после списка
   - `woocommerce_before_shop_loop_item` → до карточки
   - `woocommerce_after_shop_loop_item` → после карточки

**PHP структура:**
```php
<?php
get_header();
dsa_breadcrumbs(); // Существующая функция

// Заголовок страницы
<div class="page-header">
    <h1 class="page-header__title"><?php woocommerce_page_title(); ?></h1>
</div>

// Фильтры и сортировка
<div class="catalog-filters">
    <?php do_action('woocommerce_before_shop_loop'); ?>
</div>

// Таблица товаров
if (woocommerce_product_loop()) {
    <table class="catalog-table">
        <thead class="catalog-table__head">
            <!-- Статические заголовки -->
        </thead>
        <tbody class="catalog-table__body">
            <?php while (have_posts()) : the_post(); ?>
                <tr class="catalog-table__row">
                    <!-- Динамические данные товара -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    // Пагинация
    <?php do_action('woocommerce_after_shop_loop'); ?>
}

get_footer();
?>
```

---

#### Страница товара (single-product.php)

**Источник верстки:** `src/html/product.html` (строки 400-1000)

**БЭМ классы для сохранения:**
```css
.product-header          # Заголовок товара
.product-main            # Основной блок (grid 2 колонки)
.product-gallery         # Галерея изображений
.product-image-main      # Главное фото
.product-thumbnails      # Превью фотографий
.product-info            # Информация о товаре
.product-price           # Блок цены
.product-specs           # Характеристики (краткие)
.product-actions         # Кнопки действий
.product-tabs            # Табы (описание, характеристики, документы)
.product-related         # Похожие товары
```

**Стратегия интеграции:**
1. Скопировать структуру из `product.html`
2. Интегрировать галерею WooCommerce:
   - `woocommerce_show_product_images()` → галерея
   - Кастомизировать через `woocommerce_single_product_image_thumbnail_html`
3. Вывести характеристики через ACF:
   - `get_field('power')` → Мощность
   - `get_field('engine')` → Двигатель
   - и т.д.
4. Интегрировать форму добавления в корзину:
   - `woocommerce_template_single_add_to_cart()` → кнопка "В корзину"

**PHP структура:**
```php
<?php
get_header();
dsa_breadcrumbs();

while (have_posts()) : the_post();
    global $product;
    
    <div class="product-header">
        <h1 class="product-title"><?php the_title(); ?></h1>
    </div>
    
    <div class="product-main">
        <!-- Галерея -->
        <div class="product-gallery">
            <?php woocommerce_show_product_images(); ?>
        </div>
        
        <!-- Информация -->
        <div class="product-info">
            <div class="product-price">
                <?php echo $product->get_price_html(); ?>
            </div>
            
            <div class="product-specs">
                <!-- ACF поля: Мощность, Двигатель, и т.д. -->
            </div>
            
            <div class="product-actions">
                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>
        </div>
    </div>
    
    <!-- Табы -->
    <div class="product-tabs">
        <?php woocommerce_output_product_data_tabs(); ?>
    </div>
    
    <!-- Похожие товары -->
    <?php woocommerce_output_related_products(); ?>
    
endwhile;

get_footer();
?>
```

---

### 3. СТРУКТУРА ACF ПОЛЕЙ ДЛЯ ТОВАРОВ

#### Группа полей: "Характеристики товара"

**Расположение:** Product (WooCommerce)  
**Порядок отображения:** High (above editor)

```json
{
  "key": "group_product_specs",
  "title": "Характеристики товара",
  "fields": [
    // === ОСНОВНЫЕ ХАРАКТЕРИСТИКИ ===
    {
      "key": "field_power",
      "label": "Мощность (кВт)",
      "name": "power",
      "type": "number",
      "required": 1,
      "min": 1,
      "max": 5000,
      "step": 1
    },
    {
      "key": "field_voltage",
      "label": "Напряжение (В)",
      "name": "voltage",
      "type": "select",
      "choices": {
        "220": "220В",
        "380": "380В",
        "220_380": "220/380В"
      },
      "default_value": "380"
    },
    {
      "key": "field_frequency",
      "label": "Частота (Гц)",
      "name": "frequency",
      "type": "select",
      "choices": {
        "50": "50 Гц",
        "60": "60 Гц"
      },
      "default_value": "50"
    },
    
    // === ДВИГАТЕЛЬ ===
    {
      "key": "field_engine_manufacturer",
      "label": "Производитель двигателя",
      "name": "engine_manufacturer",
      "type": "select",
      "choices": {
        "cummins": "Cummins",
        "perkins": "Perkins",
        "doosan": "Doosan",
        "volvo": "Volvo",
        "mtu": "MTU",
        "deutz": "Deutz"
      }
    },
    {
      "key": "field_engine_model",
      "label": "Модель двигателя",
      "name": "engine_model",
      "type": "text"
    },
    {
      "key": "field_engine_volume",
      "label": "Объем двигателя (л)",
      "name": "engine_volume",
      "type": "number",
      "step": 0.1
    },
    {
      "key": "field_engine_cylinders",
      "label": "Количество цилиндров",
      "name": "engine_cylinders",
      "type": "number",
      "min": 1,
      "max": 24
    },
    
    // === ХАРАКТЕРИСТИКИ ЭКСПЛУАТАЦИИ ===
    {
      "key": "field_fuel_tank",
      "label": "Объем топливного бака (л)",
      "name": "fuel_tank",
      "type": "number"
    },
    {
      "key": "field_fuel_consumption",
      "label": "Расход топлива (л/час)",
      "name": "fuel_consumption",
      "type": "number",
      "step": 0.1
    },
    {
      "key": "field_noise_level",
      "label": "Уровень шума (дБ)",
      "name": "noise_level",
      "type": "number"
    },
    {
      "key": "field_cooling_type",
      "label": "Тип охлаждения",
      "name": "cooling_type",
      "type": "select",
      "choices": {
        "air": "Воздушное",
        "liquid": "Жидкостное"
      }
    },
    
    // === ГАБАРИТЫ И ВЕС ===
    {
      "key": "field_dimensions",
      "label": "Габариты",
      "name": "dimensions",
      "type": "group",
      "sub_fields": [
        {
          "key": "field_length",
          "label": "Длина (мм)",
          "name": "length",
          "type": "number"
        },
        {
          "key": "field_width",
          "label": "Ширина (мм)",
          "name": "width",
          "type": "number"
        },
        {
          "key": "field_height",
          "label": "Высота (мм)",
          "name": "height",
          "type": "number"
        }
      ]
    },
    {
      "key": "field_weight",
      "label": "Вес (кг)",
      "name": "weight",
      "type": "number"
    },
    
    // === ДОПОЛНИТЕЛЬНО ===
    {
      "key": "field_warranty",
      "label": "Гарантия",
      "name": "warranty",
      "type": "text",
      "placeholder": "12 месяцев"
    },
    {
      "key": "field_country",
      "label": "Страна производства",
      "name": "country",
      "type": "text"
    },
    {
      "key": "field_start_type",
      "label": "Тип запуска",
      "name": "start_type",
      "type": "checkbox",
      "choices": {
        "manual": "Ручной",
        "electric": "Электрический",
        "automatic": "Автоматический"
      }
    },
    
    // === ДОКУМЕНТАЦИЯ ===
    {
      "key": "field_manual",
      "label": "Инструкция по эксплуатации",
      "name": "manual",
      "type": "file",
      "return_format": "array",
      "mime_types": "pdf"
    },
    {
      "key": "field_certificate",
      "label": "Сертификаты",
      "name": "certificates",
      "type": "gallery",
      "return_format": "array"
    },
    {
      "key": "field_passport",
      "label": "Технический паспорт",
      "name": "passport",
      "type": "file",
      "return_format": "array",
      "mime_types": "pdf"
    },
    
    // === ДОПОЛНИТЕЛЬНЫЕ ОПЦИИ ===
    {
      "key": "field_options",
      "label": "Дополнительные опции",
      "name": "options",
      "type": "repeater",
      "layout": "table",
      "button_label": "Добавить опцию",
      "sub_fields": [
        {
          "key": "field_option_name",
          "label": "Название опции",
          "name": "name",
          "type": "text"
        },
        {
          "key": "field_option_value",
          "label": "Значение",
          "name": "value",
          "type": "text"
        }
      ]
    },
    
    // === ПРЕИМУЩЕСТВА ===
    {
      "key": "field_advantages",
      "label": "Преимущества",
      "name": "advantages",
      "type": "repeater",
      "layout": "block",
      "button_label": "Добавить преимущество",
      "sub_fields": [
        {
          "key": "field_advantage_text",
          "label": "Текст преимущества",
          "name": "text",
          "type": "text"
        },
        {
          "key": "field_advantage_icon",
          "label": "Иконка (Font Awesome класс)",
          "name": "icon",
          "type": "text",
          "placeholder": "fa-solid fa-check"
        }
      ]
    }
  ],
  "location": [
    [
      {
        "param": "post_type",
        "operator": "==",
        "value": "product"
      }
    ]
  ]
}
```

#### Места отображения ACF полей:

**На странице товара:**
1. **Краткие характеристики** (в `.product-specs`):
   - Мощность
   - Напряжение
   - Частота
   - Производитель двигателя
   - Расход топлива

2. **В табе "Характеристики"**:
   - Все поля в виде таблицы
   - Группировка по категориям

3. **В табе "Документация"**:
   - Ссылки на PDF файлы
   - Галерея сертификатов

**В каталоге (таблице):**
- Мощность (как основной параметр)
- Напряжение
- Производитель двигателя

---

### 4. ФИЛЬТРЫ И СОРТИРОВКА

#### Фильтры для каталога:

**Реализация:** WooCommerce Product Filters + Custom AJAX

```php
// Фильтр по мощности
<div class="catalog-filter">
    <label>Мощность (кВт):</label>
    <select name="power_filter">
        <option value="">Все</option>
        <option value="16-50">16-50 кВт</option>
        <option value="51-100">51-100 кВт</option>
        <option value="101-200">101-200 кВт</option>
        <option value="201-500">201-500 кВт</option>
        <option value="500+">500+ кВт</option>
    </select>
</div>

// Фильтр по производителю
<div class="catalog-filter">
    <label>Производитель:</label>
    <select name="manufacturer_filter">
        <option value="">Все</option>
        <option value="cummins">Cummins</option>
        <option value="perkins">Perkins</option>
        <option value="doosan">Doosan</option>
        <!-- и т.д. -->
    </select>
</div>

// Фильтр по цене
<?php woocommerce_catalog_ordering(); ?>
```

**JavaScript для AJAX фильтрации:**
```javascript
// assets/js/woocommerce/wc-catalog.js
class CatalogFilters {
    constructor() {
        this.form = document.querySelector('.catalog-filters');
        this.init();
    }
    
    init() {
        this.form.addEventListener('change', (e) => {
            this.filterProducts();
        });
    }
    
    filterProducts() {
        const formData = new FormData(this.form);
        
        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            this.updateProducts(data.html);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new CatalogFilters();
});
```

#### Сортировка:

**Стандартные опции WooCommerce:**
- По умолчанию (популярности)
- По цене: от низкой к высокой
- По цене: от высокой к низкой
- По новизне

**Кастомная сортировка:**
- По мощности: от меньшей к большей
- По мощности: от большей к меньшей

```php
// functions.php
add_filter('woocommerce_catalog_orderby', 'dsa_custom_catalog_ordering');
function dsa_custom_catalog_ordering($sortby) {
    $sortby['power_asc'] = 'Мощность: по возрастанию';
    $sortby['power_desc'] = 'Мощность: по убыванию';
    return $sortby;
}
```

---

### 5. КОРЗИНА И ОФОРМЛЕНИЕ ЗАКАЗА

#### Корзина (cart/cart.php)

**Дизайн:** Современный, карточный стиль

**Структура:**
```
<div class="wc-cart">
    <div class="wc-cart__items">
        <!-- Карточка товара в корзине -->
        <div class="wc-cart__item">
            <img> Фото
            <div> Название
            <div> Количество (input)
            <div> Цена
            <button> Удалить
        </div>
    </div>
    
    <div class="wc-cart__summary">
        <div> Подытог
        <div> Доставка
        <div> Итого
        <button> Оформить заказ
    </div>
</div>
```

**БЭМ классы:**
```css
.wc-cart                  # Контейнер корзины
.wc-cart__items           # Список товаров
.wc-cart__item            # Карточка товара
.wc-cart__item-image      # Фото товара
.wc-cart__item-title      # Название
.wc-cart__item-qty        # Количество
.wc-cart__item-price      # Цена
.wc-cart__item-remove     # Кнопка удаления
.wc-cart__summary         # Итоговый блок
.wc-cart__total           # Общая сумма
```

---

#### Оформление заказа (checkout/form-checkout.php)

**Дизайн:** Многошаговая форма (опционально) или одностраничная

**Структура:**
```
<div class="wc-checkout">
    <div class="wc-checkout__form">
        <h2> Контактные данные
        <input> Имя
        <input> Email
        <input> Телефон
        
        <h2> Адрес доставки
        <input> Город
        <input> Адрес
        
        <h2> Способ доставки
        <radio> Самовывоз
        <radio> Доставка по Москве
        <radio> Доставка по России
        
        <h2> Способ оплаты
        <radio> Оплата при получении
        <radio> Банковский перевод
    </div>
    
    <div class="wc-checkout__summary">
        <h3> Ваш заказ
        <div> Товары (3)
        <div> Доставка
        <div> Итого
        <button> Оформить заказ
    </div>
</div>
```

**Валидация:** JavaScript в реальном времени

```javascript
// assets/js/woocommerce/wc-checkout.js
class CheckoutValidation {
    constructor() {
        this.form = document.querySelector('.wc-checkout__form');
        this.init();
    }
    
    init() {
        // Валидация email
        // Валидация телефона
        // Проверка обязательных полей
    }
}
```

---

### 6. СПОСОБЫ ОПЛАТЫ И ДОСТАВКИ

#### Способы оплаты:

1. **Оплата при получении** (по умолчанию)
   - Настройка через WooCommerce → Settings → Payments
   - Включить "Cash on Delivery"

2. **Банковский перевод**
   - Настройка через WooCommerce → Settings → Payments
   - Включить "Direct Bank Transfer"
   - Добавить реквизиты компании

3. **Онлайн оплата** (опционально, на будущее)
   - Яндекс.Касса
   - Сбербанк
   - Robokassa

#### Способы доставки:

1. **Самовывоз** (бесплатно)
   - WooCommerce → Settings → Shipping → Local Pickup
   - Адрес: Москва, Щербаковская ул., 3

2. **Доставка по Москве** (рассчитывается)
   - Flat Rate Shipping
   - Стоимость: от 2000₽

3. **Доставка по России** (рассчитывается)
   - Транспортная компания
   - Расчет индивидуально

---

### 7. ЛИЧНЫЙ КАБИНЕТ

#### Структура страниц:

1. **Дашборд** (myaccount/dashboard.php)
   - Приветствие пользователя
   - Статистика заказов
   - Быстрые ссылки

2. **Заказы** (myaccount/orders.php)
   - Таблица всех заказов
   - Статус, дата, сумма
   - Ссылка на детали

3. **Детали заказа** (myaccount/view-order.php)
   - Номер заказа
   - Товары
   - Адрес доставки
   - Статус

4. **Редактирование профиля** (myaccount/form-edit-account.php)
   - Имя, фамилия
   - Email
   - Смена пароля

5. **Адреса** (myaccount/form-edit-address.php)
   - Адрес доставки
   - Адрес выставления счета

**БЭМ классы:**
```css
.wc-account                  # Контейнер личного кабинета
.wc-account__nav             # Навигация
.wc-account__content         # Контент
.wc-account__orders          # Таблица заказов
.wc-account__order-item      # Строка заказа
```

---

### 8. EMAIL УВЕДОМЛЕНИЯ

#### Кастомизация шаблонов:

```
woocommerce/emails/
├── customer-completed-order.php      # Заказ выполнен
├── customer-invoice.php              # Счет на оплату
├── customer-new-account.php          # Новый аккаунт
├── customer-processing-order.php     # Заказ принят
└── email-header.php                  # Хедер письма
```

**Дизайн писем:**
- Фирменные цвета (градиент #0a1855 → #00c2ff)
- Логотип компании
- Адаптивная верстка
- Кнопки призыва к действию

---

## 📝 ПОСЛЕДОВАТЕЛЬНОСТЬ РЕАЛИЗАЦИИ

### ЭТАП 2: Базовая настройка (1 день)

**IMPLEMENT режим:**
1. ✅ Установить WooCommerce
2. ✅ Добавить поддержку WC в functions.php
3. ✅ Отключить стандартные стили WC
4. ✅ Создать директорию `woocommerce/` в теме
5. ✅ Настроить базовые страницы (Магазин, Корзина, Оформление)

**Проверка (REFLECT):**
- WooCommerce работает
- Стандартные стили отключены
- Базовые страницы созданы

---

### ЭТАП 3: Каталог товаров (3-4 дня)

**CREATIVE режим (1 день):**
- Определить стратегию интеграции верстки
- Спроектировать структуру фильтров
- Создать документ `creative/woocommerce-catalog-design.md`

**IMPLEMENT режим (2 дня):**
1. Создать `woocommerce/archive-product.php`
2. Перенести верстку из `catalog-generators.html`
3. Интегрировать WooCommerce loop
4. Добавить фильтры и сортировку
5. Создать `assets/css/woocommerce/wc-catalog.css`
6. Создать `assets/js/woocommerce/wc-catalog.js`

**REFLECT режим (1 день):**
- Тестирование фильтров
- Проверка пагинации
- Адаптивность

---

### ЭТАП 4: Страница товара (3-4 дня)

**CREATIVE режим (1 день):**
- Спроектировать интеграцию галереи
- Определить места вывода ACF полей
- Создать документ `creative/woocommerce-product-page-design.md`

**IMPLEMENT режим (2 дня):**
1. Создать `woocommerce/single-product.php`
2. Перенести верстку из `product.html`
3. Интегрировать галерею WooCommerce
4. Добавить вывод ACF полей
5. Интегрировать табы
6. Добавить форму "Получить консультацию"
7. Создать `assets/css/woocommerce/wc-product.css`
8. Создать `assets/js/woocommerce/wc-product.js`

**REFLECT режим (1 день):**
- Тестирование галереи
- Проверка кнопки "В корзину"
- Тест ACF полей
- Адаптивность

---

### ЭТАП 5: Корзина и оформление (4-5 дней)

**CREATIVE режим (1 день):**
- Спроектировать UX процесса покупки
- Определить дизайн форм
- Создать документ `creative/woocommerce-checkout-design.md`

**IMPLEMENT режим (3 дня):**
1. Создать `woocommerce/cart/cart.php`
2. Создать `woocommerce/checkout/form-checkout.php`
3. Создать `woocommerce/checkout/thankyou.php`
4. Настроить способы оплаты
5. Настроить способы доставки
6. Создать `assets/css/woocommerce/wc-cart.css`
7. Создать `assets/css/woocommerce/wc-checkout.css`
8. Создать `assets/js/woocommerce/wc-checkout.js` (валидация)

**REFLECT режим (1 день):**
- Тестирование процесса покупки
- Проверка email уведомлений
- Тест способов оплаты/доставки

---

### ЭТАП 6: Дополнительные страницы (2-3 дня)

**IMPLEMENT режим (2 дня):**
1. Создать `woocommerce/myaccount/dashboard.php`
2. Создать `woocommerce/myaccount/orders.php`
3. Создать `woocommerce/myaccount/view-order.php`
4. Создать `woocommerce/myaccount/form-edit-account.php`
5. Создать `woocommerce/myaccount/form-edit-address.php`
6. Создать `assets/css/woocommerce/wc-account.css`

**REFLECT режим (1 день):**
- Тестирование регистрации/авторизации
- Проверка функционала личного кабинета

---

### ЭТАП 7: Интеграция ACF (2-3 дня)

**CREATIVE режим (1 день):**
- Финализация структуры ACF полей
- Определение мест отображения
- Создать документ `creative/woocommerce-acf-fields.md`

**IMPLEMENT режим (1-2 дня):**
1. Создать группу полей ACF для товаров
2. Экспортировать в `acf-exports/group_product-fields.json`
3. Интегрировать вывод полей на странице товара
4. Интегрировать поля в фильтры каталога
5. Создать документацию `acf-exports/README-product-fields.md`

---

### ЭТАП 8: Финальное тестирование (2-3 дня)

**REFLECT режим (2 дня):**
- Комплексное тестирование всех функций
- Тестирование производительности
- Проверка адаптивности
- Тест безопасности

**ARCHIVE режим (1 день):**
- Создание финальной документации
- Обновление README.md
- Создание `WOOCOMMERCE_SETUP.md`
- Архивация creative документов

---

## ⚠️ ПОТЕНЦИАЛЬНЫЕ ПРОБЛЕМЫ И РЕШЕНИЯ

### 1. Конфликт стилей

**Проблема:** Стили WooCommerce перезаписывают существующие

**Решение:**
```php
// functions.php
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
```

### 2. Производительность фильтров

**Проблема:** Медленная AJAX фильтрация

**Решение:**
- Использовать кеширование результатов
- Оптимизировать SQL запросы
- Добавить debounce в JavaScript

### 3. Адаптивность галереи

**Проблема:** Галерея WooCommerce плохо адаптируется

**Решение:**
- Переписать шаблон галереи
- Использовать собственные стили
- Добавить touch события для мобильных

---

## 📊 МЕТРИКИ УСПЕХА PLAN РЕЖИМА

**Достигнуто:**
- ✅ Определена архитектура интеграции
- ✅ Спланирована структура ACF полей (42 поля)
- ✅ Определена последовательность из 8 этапов
- ✅ Составлен список из 24 файлов
- ✅ Выявлены риски и решения
- ✅ Создан timeline на 2-3 недели

---

## 🎯 СЛЕДУЮЩИЕ ШАГИ

**Текущий статус:** PLAN режим завершается

**Следующий этап:** ЭТАП 2 - Базовая настройка WooCommerce

**Режим:** IMPLEMENT

**Промпт для продолжения:**
```
Начинаем ЭТАП 2: Базовая настройка WooCommerce. Режим IMPLEMENT.

ЗАДАЧИ:
1. Добавить поддержку WooCommerce в functions.php
2. Настроить базовые хуки и фильтры
3. Отключить стандартные стили WooCommerce
4. Создать структуру директорий для кастомных шаблонов
5. Настроить базовые параметры магазина

Выполни эти действия в IMPLEMENT режиме.
```

---

**Документ создан:** 2025-10-28  
**Режим:** PLAN (Planning & Architecture)  
**Статус:** ✅ ЗАВЕРШЕН  
**Прогресс проекта:** 10%
