# 🎨 CREATIVE PHASE: ИНТЕГРАЦИЯ КАТАЛОГА WOOCOMMERCE

**Дата:** 2025-10-28  
**Компонент:** Каталог товаров WooCommerce  
**Статус:** ✅ Решение принято  
**Рекомендованный подход:** Опция C (Гибридный)

---

## 📋 ОПИСАНИЕ ЗАДАЧИ

Интеграция существующей верстки каталога дизельных электростанций с системой WooCommerce, сохраняя:
- БЭМ методологию
- Существующий дизайн и CSS
- Группировку товаров по диапазонам мощности
- Панель фильтров и сортировки
- **Переключатель видов (табличный/карточный)**
- Адаптивность для всех устройств

### Два вида отображения каталога:

**1. Табличный вид** (`catalog-generators.html`):
- Заголовки таблицы с 6 колонками
- `.catalog-product` с горизонтальной структурой
- Элементы: image, name, engine, power, country, price

**2. Карточный вид** (`catalog-generators-cards.html`):
- Без заголовков таблицы
- `.catalog-product` с вертикальной структурой
- Элементы: 
  - `.catalog-product__image` - изображение сверху
  - `.catalog-product__content`:
    - `.catalog-product__header` - заголовок и цена
    - `.catalog-product__specs` - характеристики с иконками
    - `.catalog-product__actions` - кнопки (корзина, избранное, сравнение)

**Переключатель:** `.catalog-view-toggle` с кнопками `data-view="cards"` и `data-view="list"`

---

## 🔄 РАССМОТРЕННЫЕ ОПЦИИ

### ОПЦИЯ A: Полная замена кастомным шаблоном
**Подход:** Создать полностью кастомный archive-product.php  
**Результат:** ❌ ОТКЛОНЕНА  
**Причина:** Потеря совместимости с экосистемой WooCommerce

### ОПЦИЯ B: Использование хуков WooCommerce
**Подход:** Модификация через систему хуков  
**Результат:** ❌ ОТКЛОНЕНА  
**Причина:** Сложность реализации группировки и точного соответствия дизайну

### ОПЦИЯ C: Гибридный подход ✅
**Подход:** Кастомный шаблон + ключевые хуки WooCommerce  
**Результат:** ✅ ПРИНЯТА  
**Причина:** Оптимальный баланс между контролем и совместимостью

### ОПЦИЯ D: Использование плагина
**Подход:** WooCommerce Product Table plugin  
**Результат:** ❌ ОТКЛОНЕНА  
**Причина:** Зависимость от стороннего плагина

---

## ✅ РЕКОМЕНДОВАННОЕ РЕШЕНИЕ: ГИБРИДНЫЙ ПОДХОД

### Преимущества:
1. ✅ Полный контроль над HTML структурой
2. ✅ Совместимость с основными хуками WooCommerce
3. ✅ Легкая реализация группировки товаров
4. ✅ Баланс между гибкостью и совместимостью
5. ✅ Сохранение БЭМ структуры

### Архитектура:

```
woocommerce/
├── archive-product.php              # Основной шаблон каталога (определяет вид)
├── catalog-filters.php              # Панель фильтров (общая для обоих видов)
├── catalog-product-list.php         # Шаблон товара (табличный вид)
└── catalog-product-cards.php        # Шаблон товара (карточный вид)
```

```php
// functions.php - Секция WooCommerce Catalog

// Основные функции
├── dsa_render_grouped_catalog_products($view)    # Группировка и вывод (с параметром вида)
├── dsa_get_power_ranges()                        # Диапазоны мощности
├── dsa_determine_power_group()                   # Определение группы
├── dsa_get_product_power()                       # Получение мощности

// Вывод товаров по видам
├── dsa_render_catalog_product_list($product)     # Вывод товара (табличный вид)
├── dsa_render_catalog_product_cards($product)    # Вывод товара (карточный вид)

// Переключатель видов
├── dsa_get_catalog_view()                        # Определение текущего вида (GET + Cookie)
└── dsa_catalog_table_header()                    # Заголовки таблицы (только для табличного)
```

---

## 📊 КЛЮЧЕВЫЕ РЕШЕНИЯ

### 1. Группировка товаров

**Решение:** Группировка в PHP после получения всех товаров

**Алгоритм:**
1. Получить все товары через стандартный WooCommerce query
2. Пройти по циклу и сгруппировать по диапазонам мощности
3. Вывести группы с товарами
4. Восстановить query

**Преимущества:**
- Один запрос к БД
- Гибкая группировка
- Простота реализации

---

### 2. Фильтрация и сортировка

**Решение:** Комбинация стандартных механизмов WooCommerce и кастомных фильтров

**Реализация:**
- Сортировка: стандартная WooCommerce (`woocommerce_catalog_orderby`)
- Фильтры: GET параметры + WP_Query модификация
- AJAX: опционально для динамической фильтрации

---

### 3. ACF поля товаров

**Структура полей:**
```
Группа: Технические характеристики
├─ Мощность (power) - Number
├─ Двигатель (engine) - Text
├─ Страна сборки (country) - Select
├─ Производитель двигателя (engine_manufacturer) - Select
└─ Номинальная мощность (nominal_power) - Number
```

**Использование:**
- Отображение в карточках
- Фильтрация
- Группировка

---

### 4. Производительность

**Оптимизации:**
1. Один запрос для получения товаров
2. Группировка в PHP (без дополнительных запросов)
3. Кеширование диапазонов мощности
4. Lazy loading изображений
5. Пагинация (50 товаров на страницу)

---

### 5. CSS Стратегия

**Решение:** Минимальное вмешательство в существующие стили

- Сохранить все БЭМ классы: `.catalog-product`, `.catalog-filters`, и т.д.
- Не изменять `catalog.css`
- Создать `wc-catalog.css` только для WooCommerce-специфичных элементов (цена, кнопки)

---

### 6. Переключатель видов (Табличный/Карточный)

**Решение:** GET параметр + Cookie для сохранения выбора пользователя

**Механизм работы:**
1. GET параметр `?view=cards` или `?view=list` определяет текущий вид
2. Cookie `catalog_view` сохраняет выбор пользователя между сеансами
3. JavaScript обрабатывает клики по кнопкам переключателя
4. PHP функция определяет текущий вид и подключает нужный шаблон

**Структура шаблонов:**
```
woocommerce/
├── archive-product.php              # Основной шаблон (определяет вид)
├── catalog-filters.php              # Панель фильтров (общая)
├── catalog-product-list.php         # Шаблон товара (табличный вид)
└── catalog-product-cards.php        # Шаблон товара (карточный вид)
```

**Функция определения вида:**
```php
function dsa_get_catalog_view() {
    // 1. Проверить GET параметр
    if (isset($_GET['view']) && in_array($_GET['view'], ['list', 'cards'])) {
        $view = $_GET['view'];
        // Сохранить в cookie
        setcookie('catalog_view', $view, time() + (86400 * 30), '/');
        return $view;
    }
    
    // 2. Проверить Cookie
    if (isset($_COOKIE['catalog_view']) && in_array($_COOKIE['catalog_view'], ['list', 'cards'])) {
        return $_COOKIE['catalog_view'];
    }
    
    // 3. Дефолтный вид - табличный
    return 'list';
}
```

**Переключатель в шаблоне:**
```php
$current_view = dsa_get_catalog_view();
$list_class = $current_view === 'list' ? 'catalog-view-toggle__btn_active' : '';
$cards_class = $current_view === 'cards' ? 'catalog-view-toggle__btn_active' : '';
?>

<div class="catalog-view-toggle">
    <button class="catalog-view-toggle__btn <?php echo $cards_class; ?>" 
            type="button" 
            data-view="cards"
            aria-label="Карточный вид">
        <!-- SVG иконка сетки -->
    </button>
    <button class="catalog-view-toggle__btn <?php echo $list_class; ?>" 
            type="button" 
            data-view="list"
            aria-label="Табличный вид">
        <!-- SVG иконка списка -->
    </button>
</div>
```

**JavaScript обработка:**
```javascript
// Обработка клика по кнопкам переключателя
document.querySelectorAll('.catalog-view-toggle__btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const view = this.dataset.view;
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('view', view);
        window.location.href = currentUrl.toString();
    });
});
```

**Условный рендеринг в archive-product.php:**
```php
// Определяем текущий вид
$catalog_view = dsa_get_catalog_view();

// Выводим заголовки таблицы только для табличного вида
if ($catalog_view === 'list') {
    dsa_catalog_table_header();
}

// Выводим группы товаров
dsa_render_grouped_catalog_products($catalog_view);
```

**Модификация функции рендеринга товаров:**
```php
function dsa_render_grouped_catalog_products($view = 'list') {
    // ... группировка товаров ...
    
    foreach ($grouped_products as $group_key => $group_data) {
        if (empty($group_data['products'])) continue;
        
        echo '<div class="catalog-group">';
        echo '<h2 class="catalog-group__title">' . esc_html($group_data['name']) . '</h2>';
        
        // Добавляем класс в зависимости от вида
        $products_class = $view === 'cards' ? 'catalog-products catalog-products_view_cards' : 'catalog-products';
        echo '<div class="' . $products_class . '">';
        
        foreach ($group_data['products'] as $product) {
            // Подключаем нужный шаблон
            if ($view === 'cards') {
                dsa_render_catalog_product_cards($product);
            } else {
                dsa_render_catalog_product_list($product);
            }
        }
        
        echo '</div></div>';
    }
}
```

**Преимущества решения:**
- ✅ GET параметр позволяет делиться ссылками с нужным видом
- ✅ Cookie сохраняет выбор пользователя
- ✅ Один URL для каталога (SEO-friendly)
- ✅ Простая логика переключения
- ✅ Совместимость с фильтрами и сортировкой

---

## 📝 IMPLEMENTATION GUIDELINES

### Шаг 1: Создать основной шаблон
**Файл:** `woocommerce/archive-product.php`
- Использовать хуки `woocommerce_before_main_content` и `woocommerce_after_main_content`
- Вызывать функции группировки и вывода товаров
- Добавить стандартную пагинацию WooCommerce

### Шаг 2: Добавить функции в functions.php
**Функции:**
- `dsa_render_grouped_catalog_products()` - основная функция группировки
- `dsa_get_power_ranges()` - определение диапазонов
- `dsa_determine_power_group()` - логика группировки
- `dsa_render_catalog_product_item()` - вывод одного товара

### Шаг 3: Создать шаблоны товаров (два вида)
**Файл 1:** `woocommerce/catalog-product-list.php` (табличный вид)
- Использовать БЭМ классы из catalog-generators.html
- Горизонтальная структура с 6 элементами
- Интегрировать ACF поля
- Добавить ссылки на страницу товара

**Файл 2:** `woocommerce/catalog-product-cards.php` (карточный вид)
- Использовать БЭМ классы из catalog-generators-cards.html
- Вертикальная структура с изображением сверху
- Блоки: header, specs, actions
- Кнопки: корзина, избранное, сравнение

### Шаг 4: Создать панель фильтров
**Файл:** `woocommerce/catalog-filters.php`
- Перенести HTML структуру фильтров
- Интегрировать с WooCommerce сортировкой
- Добавить обработку GET параметров

### Шаг 5: Настроить ACF поля
- Создать группу полей для товаров
- Добавить поля: мощность, двигатель, страна, производитель
- Экспортировать в JSON

### Шаг 6: Реализовать переключатель видов
- Добавить функцию `dsa_get_catalog_view()` в functions.php
- Интегрировать переключатель в catalog-filters.php
- Добавить JavaScript обработку кликов
- Настроить условный рендеринг в archive-product.php

### Шаг 7: Создать тестовые товары
- Минимум 10 товаров
- Разные диапазоны мощности
- Все характеристики заполнены
- С изображениями

### Шаг 8: Протестировать оба вида
- Проверить табличный вид
- Проверить карточный вид
- Проверить сохранение выбора в Cookie
- Проверить работу с фильтрами и сортировкой

---

## ✅ VERIFICATION CHECKLIST

- [x] Решение соответствует требованиям
- [x] Архитектура определена
- [x] Файлы для создания перечислены
- [x] Функции спроектированы
- [x] ACF поля определены
- [x] Производительность учтена
- [x] CSS стратегия определена
- [x] Готово к реализации

---

## 🎯 ГОТОВО К IMPLEMENT РЕЖИМУ

**Следующий шаг:** Переход в IMPLEMENT MODE для реализации спроектированного решения.

**Промпт для продолжения:**
```
Начинаем реализацию каталога товаров. Режим IMPLEMENT.

На основе решения из CREATIVE режима (Опция C - Гибридный подход + переключатель видов):

ЗАДАЧИ:
1. Создать woocommerce/archive-product.php с определением вида (GET + Cookie)
2. Добавить 8 функций в functions.php:
   - dsa_render_grouped_catalog_products($view)
   - dsa_get_power_ranges()
   - dsa_determine_power_group()
   - dsa_get_product_power()
   - dsa_render_catalog_product_list($product) - табличный вид
   - dsa_render_catalog_product_cards($product) - карточный вид
   - dsa_get_catalog_view() - определение вида
   - dsa_catalog_table_header()
3. Создать woocommerce/catalog-product-list.php (табличный вид)
4. Создать woocommerce/catalog-product-cards.php (карточный вид)
5. Создать woocommerce/catalog-filters.php с переключателем видов
6. Настроить ACF поля (power, engine, country, engine_manufacturer, nominal_power)
7. Добавить JavaScript для переключателя
8. Создать тестовые товары (минимум 10 шт.)
9. Протестировать оба вида

Документация: memory-bank/creative/woocommerce-catalog-design.md

Запусти IMPLEMENT режим.
```
