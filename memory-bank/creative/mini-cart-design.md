# 🎨🎨🎨 CREATIVE PHASE: МИНИ-КОРЗИНА И AJAX ОБНОВЛЕНИЯ

**Дата создания:** 1 ноября 2025  
**Версия:** 1.0  
**Статус:** ✅ ЗАВЕРШЕН

---

## 📋 ОПИСАНИЕ КОМПОНЕНТА

**Компонент:** Мини-корзина (Mini Cart Widget) с AJAX функционалом

**Что это:** Выпадающий виджет в header, который отображает товары в корзине пользователя без перехода на страницу корзины. При добавлении товара через AJAX, мини-корзина автоматически обновляется и показывает актуальное содержимое.

**Функциональность:**
- Отображение списка товаров с миниатюрами, названиями, ценами
- Показ общей суммы и количества товаров
- Удаление товаров из корзины без перезагрузки
- AJAX добавление товаров с любой страницы
- Индикаторы количества на карточках товаров
- Открытие/закрытие виджета по клику

**Контекст интеграции:**
- Проект: WordPress тема с WooCommerce
- Существующая база: AJAX функции уже есть, счетчик корзины работает
- Стиль: Glassmorphism дизайн (как в личном кабинете)
- Технологии: Vanilla JS, PHP, CSS

---

## 🎯 ТРЕБОВАНИЯ И ОГРАНИЧЕНИЯ

### Функциональные требования:
1. **FR-1:** Мини-корзина должна открываться при клике на иконку корзины в header
2. **FR-2:** AJAX добавление товара должно обновлять мини-корзину без перезагрузки
3. **FR-3:** На карточках товаров должно отображаться количество уже добавленных в корзину
4. **FR-4:** Удаление товара из мини-корзины должно работать через AJAX
5. **FR-5:** Универсальная функция `dsaAddToCart()` для всех страниц

### Нефункциональные требования:
1. **NFR-1:** AJAX запросы < 500ms
2. **NFR-2:** Совместимость с существующим WooCommerce кодом
3. **NFR-3:** Адаптивность на всех устройствах
4. **NFR-4:** Доступность (ARIA атрибуты)
5. **NFR-5:** Использование существующих CSS переменных проекта

### Ограничения:
- Нельзя использовать jQuery (проект на Vanilla JS)
- Нельзя переписывать существующие AJAX функции
- Должен работать с авторизованными и неавторизованными пользователями
- Не должен конфликтовать с WooCommerce фрагментами

---

## 🔄 ВАРИАНТЫ АРХИТЕКТУРНЫХ РЕШЕНИЙ

### Вариант 1: WooCommerce Fragments (Стандартный подход)

**Описание:**
Использовать встроенную систему WooCommerce фрагментов для обновления мини-корзины.

#### ✅ Преимущества:
- Стандартный подход WooCommerce
- Автоматическая синхронизация
- Меньше кастомного кода
- Поддержка кэширования из коробки
- Совместимость с плагинами WooCommerce

#### ❌ Недостатки:
- Требует jQuery (конфликт с требованием Vanilla JS)
- Менее гибкий для кастомизации
- Обновляет все фрагменты, не только мини-корзину
- Сложнее отлаживать
- Привязка к API WooCommerce

---

### Вариант 2: Custom AJAX Endpoints (Кастомный подход) ⭐

**Описание:**
Создать собственные AJAX endpoints для обновления мини-корзины. Полный контроль над процессом обмена данными.

#### ✅ Преимущества:
- Полный контроль над процессом
- Vanilla JavaScript (соответствует требованиям)
- Передача только нужных данных
- Легко расширяется и модифицируется
- Независимость от изменений WooCommerce API
- Проще отлаживать

#### ❌ Недостатки:
- Больше кастомного кода
- Нужно самостоятельно управлять синхронизацией
- Потенциальные конфликты с плагинами
- Нужно реализовать обработку ошибок

---

### Вариант 3: Гибридный подход

**Описание:**
Использовать WooCommerce хуки для добавления товара, но кастомные endpoints для обновления мини-корзины.

#### ✅ Преимущества:
- Использует проверенные WooCommerce функции
- Кастомное обновление UI
- Совместимость с плагинами
- Vanilla JavaScript для UI

#### ❌ Недостатки:
- Сложнее в понимании
- Потенциальная дублирование логики
- Нужно следить за согласованностью

---

### Вариант 4: Event-Driven Architecture

**Описание:**
Использовать систему событий JavaScript для синхронизации.

#### ✅ Преимущества:
- Слабая связанность компонентов
- Легко добавлять новые компоненты
- Масштабируемость

#### ❌ Недостатки:
- Overcomplicated для простой задачи
- Больше кода для поддержки
- Сложнее для новых разработчиков

---

## 🏆 РЕКОМЕНДУЕМЫЙ ПОДХОД: Вариант 2 (Custom AJAX Endpoints)

### Обоснование выбора:

1. ✅ **Соответствует требованиям:** Vanilla JavaScript
2. ✅ **Полный контроль:** Можем передавать именно те данные, которые нужны
3. ✅ **Производительность:** Минимальный объем данных, быстрые запросы
4. ✅ **Простота:** Понятная архитектура, легко читать и модифицировать
5. ✅ **Согласованность:** Соответствует существующему стилю кода (wc-catalog.js)
6. ✅ **Независимость:** Не зависит от изменений в WooCommerce API
7. ✅ **Расширяемость:** Легко добавить новые endpoints или функции

---

## 📐 АРХИТЕКТУРНЫЕ РЕШЕНИЯ

### Структура данных для обмена

#### AJAX Response (обновление мини-корзины):
```json
{
    "success": true,
    "data": {
        "html": "<div class='mini-cart'>...</div>",
        "count": 3,
        "total": "950 000 ₽",
        "subtotal": "950 000 ₽"
    }
}
```

### События и хуки WordPress

**PHP Hooks:**
```php
add_action('wp_ajax_dsa_update_mini_cart', 'dsa_ajax_update_mini_cart');
add_action('wp_ajax_nopriv_dsa_update_mini_cart', 'dsa_ajax_update_mini_cart');
add_action('wp_ajax_dsa_remove_from_cart', 'dsa_ajax_remove_from_cart');
add_action('wp_ajax_nopriv_dsa_remove_from_cart', 'dsa_ajax_remove_from_cart');
add_action('wp_ajax_dsa_get_product_quantity', 'dsa_ajax_get_product_quantity');
add_action('wp_ajax_nopriv_dsa_get_product_quantity', 'dsa_ajax_get_product_quantity');
add_action('wp_enqueue_scripts', 'dsa_enqueue_mini_cart_assets', 25);
```

### Стратегия кэширования

**Решение:** НЕ кэшировать данные корзины на фронтенде

**Обоснование:**
- Корзина - критичные данные, должны быть актуальными
- AJAX запросы достаточно быстрые (< 500ms)
- Риск рассинхронизации при кэшировании

---

## 🎨 UX/UI ДИЗАЙН

### Финальный дизайн мини-корзины

```
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ Корзина (3 товара)           ✕  ┃ ← Header
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃                                  ┃
┃ ┌────┐  Генератор DSA-100      ┃
┃ │Img │  100 кВт                 ┃
┃ │60px│  2 × 250 000 ₽      [✕]  ┃ ← Товар
┃ └────┘                           ┃
┃ ────────────────────────────────  ┃
┃ ┌────┐  Генератор DSA-200      ┃
┃ │Img │  200 кВт                 ┃
┃ │60px│  1 × 350 000 ₽      [✕]  ┃
┃ └────┘                           ┃
┃ ────────────────────────────────  ┃
┃ ┌────┐  Генератор DSA-50       ┃
┃ │Img │  50 кВт                  ┃
┃ │60px│  1 × 180 000 ₽      [✕]  ┃
┃ └────┘                           ┃
┃                                  ┃
┣━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┫
┃ Итого:          1 130 000 ₽     ┃ ← Footer
┃                                  ┃
┃ ┌──────────────────────────────┐ ┃
┃ │   Оформить заказ →          │ ┃
┃ └──────────────────────────────┘ ┃
┃                                  ┃
┃     Перейти в корзину            ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

Размеры:
- Ширина: 380px
- Max высота: 500px (scroll если больше)
- Border-radius: 12px
```

### Индикатор количества (Выбранный вариант 3)

**На карточках товара:**
```
┌─────────────────────────────────┐
│  [img] Генератор DSA-100        │
│  100 кВт                         │
│  250 000 ₽                       │
│                                  │
│  ┌─────────────────────────────┐ │
│  │ ✓ В корзине: 2 шт.          │ │ ← Индикатор (зеленый)
│  └─────────────────────────────┘ │
│                                  │
│  ┌─────────────────────────────┐ │
│  │  📦 В корзину               │ │ ← Кнопка
│  └─────────────────────────────┘ │
└─────────────────────────────────┘
```

### Цветовая схема

**Мини-корзина:**
- Фон: `#ffffff`
- Тень: `0 20px 60px rgba(0, 0, 0, 0.15)`
- Border: `1px solid rgba(0, 0, 0, 0.05)`

**Индикатор количества:**
- Фон: `rgba(76, 175, 80, 0.1)`
- Текст: `#4CAF50`
- Border: `1px solid rgba(76, 175, 80, 0.3)`

### Типографика

- **Заголовок:** 18px / 600
- **Название товара:** 14px / 500
- **Характеристики:** 12px / 400
- **Цена:** 14px / 600
- **Итого:** 20px / 700

### Анимации

**Появление мини-корзины:**
```css
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```

### Состояния UI

1. **Default (закрыто):** opacity: 0, pointer-events: none
2. **Open (открыто):** opacity: 1, pointer-events: all
3. **Loading:** overlay + spinner
4. **Error:** shake анимация + красная граница
5. **Empty:** иконка + сообщение + кнопка

---

## 🔧 ТЕХНИЧЕСКИЕ СПЕЦИФИКАЦИИ

### Детальная структура файлов

**1. template-parts/mini-cart.php** (~150 строк)
- Проверка корзины
- Пустая корзина (Empty State)
- Список товаров
- Итого и кнопки

**2. assets/css/mini-cart.css** (~300 строк)
- Variables (10)
- Container & Positioning (40)
- Header (30)
- Items List (50)
- Single Item (60)
- Footer (30)
- Empty State (20)
- Animations (30)
- Responsive (30)

**3. assets/js/mini-cart.js** (~250 строк)
- initMiniCart() (20)
- toggleMiniCart() (10)
- updateMiniCart() (30)
- removeFromCart() (25)
- window.dsaAddToCart() (50)
- updateProductQuantityIndicator() (30)
- Helper functions (85)

### CSS Классы (BEM naming)

**Мини-корзина:**
- `.mini-cart-dropdown` - контейнер dropdown
- `.mini-cart-dropdown.is-open` - открытое состояние
- `.mini-cart-dropdown-inner` - внутренняя обертка
- `.mini-cart` - основной контейнер
- `.mini-cart__header` - заголовок
- `.mini-cart__close` - кнопка закрытия
- `.mini-cart__items` - список товаров
- `.mini-cart__item` - один товар
- `.mini-cart__item-image` - миниатюра
- `.mini-cart__item-info` - информация
- `.mini-cart__item-name` - название
- `.mini-cart__item-meta` - характеристики
- `.mini-cart__item-price` - цена
- `.mini-cart__item-remove` - кнопка удаления
- `.mini-cart__footer` - футер
- `.mini-cart__total` - итоговая сумма
- `.mini-cart__checkout` - кнопка оформления
- `.mini-cart__view-cart` - ссылка на корзину
- `.mini-cart__empty` - пустая корзина

**Header:**
- `.header__cart-wrapper` - обертка
- `.header__cart-toggle` - кнопка-триггер

**Индикаторы:**
- `.product-quantity-indicator` - базовый
- `.product-quantity-indicator_large` - большой
- `.product-quantity-indicator_small` - маленький

### JavaScript функции

```javascript
/**
 * Инициализация мини-корзины
 */
function initMiniCart()

/**
 * Открытие/закрытие
 * @param {Event} e
 */
function toggleMiniCart(e)

/**
 * Обновление через AJAX
 * @returns {Promise<void>}
 */
function updateMiniCart()

/**
 * Удаление товара
 * @param {string} cartItemKey
 * @returns {Promise<void>}
 */
function removeFromCart(cartItemKey)

/**
 * ГЛОБАЛЬНАЯ функция добавления
 * @param {HTMLElement} button
 * @param {number} quantity
 * @returns {Promise<void>}
 */
window.dsaAddToCart = function(button, quantity = 1)

/**
 * Обновление индикатора
 * @param {number} productId
 * @param {HTMLElement} button
 */
function updateProductQuantityIndicator(productId, button)
```

### PHP функции

```php
/**
 * Получить количество товара в корзине
 * @param int $product_id
 * @return int
 */
function dsa_get_cart_item_quantity($product_id)

/**
 * AJAX обновление мини-корзины
 * @return void
 */
function dsa_ajax_update_mini_cart()

/**
 * AJAX удаление из корзины
 * @return void
 */
function dsa_ajax_remove_from_cart()

/**
 * AJAX получение количества
 * @return void
 */
function dsa_ajax_get_product_quantity()

/**
 * Подключение assets
 * @return void
 */
function dsa_enqueue_mini_cart_assets()
```

---

## 🔌 ИНТЕГРАЦИОННЫЕ ТОЧКИ

### 1. header.php (строка 102)

```php
// БЫЛО:
<a href="<?php echo wc_get_cart_url(); ?>" class="header__icon-btn">
    <i class="fa-solid fa-cart-shopping"></i>
    <span class="header__badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
</a>

// СТАНЕТ:
<div class="header__cart-wrapper">
    <a href="<?php echo wc_get_cart_url(); ?>" 
       class="header__icon-btn header__cart-toggle"
       aria-expanded="false">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="header__badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    </a>
    
    <div class="mini-cart-dropdown">
        <div class="mini-cart-dropdown-inner">
            <?php 
            if (function_exists('WC') && WC()->cart) {
                get_template_part('template-parts/mini-cart');
            }
            ?>
        </div>
    </div>
</div>
```

### 2. functions.php (после строки 1906)

- 4 новые функции (~100 строк)
- Регистрация AJAX actions (8 строк)
- Обновление `dsa_woocommerce_assets()` (~20 строк)

### 3. Карточки товаров

**Места интеграции:**
1. `woocommerce/single-product/product-related.php` (строка 97)
2. `woocommerce/single-product/product-info.php` (строка 152)
3. `functions.php` - `dsa_render_grouped_catalog_products()` (строка ~1800)

**Код для добавления:**
```php
<?php 
$cart_quantity = dsa_get_cart_item_quantity($product_id);
if ($cart_quantity > 0): 
?>
<div class="product-quantity-indicator">
    <i class="fa-solid fa-check-circle"></i>
    <span>В корзине: <?php echo $cart_quantity; ?> шт.</span>
</div>
<?php endif; ?>
```

---

## 🛡️ ERROR HANDLING

### Обработка ошибок AJAX

**1. Ошибка сети:**
```javascript
.catch(error => {
    console.error('Network Error:', error);
    showNotification('Ошибка соединения', 'error');
});
```

**2. Ошибка сервера:**
```php
try {
    // код
} catch (Exception $e) {
    error_log('DSA Mini Cart Error: ' . $e->getMessage());
    wp_send_json_error(['message' => 'Произошла ошибка']);
}
```

**3. Товар недоступен:**
```php
if (!$product->is_purchasable()) {
    wp_send_json_error(['message' => 'Товар недоступен']);
}
```

### Валидация данных

**JavaScript:**
```javascript
if (!productId || isNaN(productId)) {
    console.error('Invalid product ID');
    return;
}
```

**PHP:**
```php
if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'dsa-mini-cart')) {
    wp_send_json_error(['message' => 'Security check failed']);
}
```

### Fallback сценарии

**1. JavaScript отключен:** Обычные ссылки работают

**2. AJAX timeout:**
```javascript
const controller = new AbortController();
setTimeout(() => controller.abort(), 5000);
```

**3. Пустая корзина:**
```php
if (WC()->cart->is_empty()) {
    // Показать Empty State
}
```

---

## ♿ ACCESSIBILITY

### ARIA атрибуты

```html
<a href="..." 
   class="header__cart-toggle"
   aria-expanded="false"
   aria-haspopup="true"
   aria-controls="mini-cart-dropdown"
   aria-label="Корзина. Товаров: 3">
</a>

<div class="mini-cart-dropdown" 
     id="mini-cart-dropdown"
     role="dialog"
     aria-label="Мини-корзина">
</div>
```

### Keyboard Navigation

- `Tab` - навигация
- `Escape` - закрыть
- `Enter/Space` - активировать
- Focus trap внутри мини-корзины

### Screen Reader Support

```html
<div class="sr-only" role="status" aria-live="polite">
    <!-- Уведомления для screen readers -->
</div>
```

---

## 📊 VERIFICATION CHECKPOINT

| Требование | Статус | Решение |
|------------|--------|---------|
| FR-1: Открывается по клику | ✅ | `toggleMiniCart()` |
| FR-2: AJAX обновление | ✅ | Custom endpoints |
| FR-3: Индикаторы количества | ✅ | `dsa_get_cart_item_quantity()` |
| FR-4: Удаление через AJAX | ✅ | `removeFromCart()` |
| FR-5: Универсальная функция | ✅ | `window.dsaAddToCart()` |
| NFR-1: AJAX < 500ms | ✅ | Минимальные данные |
| NFR-2: Совместимость WC | ✅ | Использует WC()->cart |
| NFR-3: Адаптивность | ✅ | Media queries |
| NFR-4: Доступность | ✅ | ARIA + keyboard |
| NFR-5: CSS переменные | ✅ | `var(--primary)` |

---

## 📝 IMPLEMENTATION GUIDELINES

### Порядок реализации (рекомендуемый)

**Шаг 1:** PHP хелпер функции (functions.php)  
**Шаг 2:** Mini Cart Template  
**Шаг 3:** CSS стили  
**Шаг 4:** JavaScript  
**Шаг 5:** Интеграция в header  
**Шаг 6:** Индикаторы количества  
**Шаг 7:** Тестирование  

### Советы по реализации

1. Использовать существующие паттерны проекта
2. Тестировать инкрементально
3. Обработка ошибок с самого начала
4. Логировать важные события
5. Nonce для безопасности

---

# 🎨🎨🎨 EXITING CREATIVE PHASE

## Итоговое резюме

**Выбранное решение:** Custom AJAX Endpoints (Вариант 2)

**Ключевые преимущества:**
1. Vanilla JavaScript
2. Полный контроль
3. Оптимальная производительность
4. Простота поддержки
5. Независимость от WooCommerce API

**Готовность к реализации:** ✅ 100%

**Следующий шаг:** IMPLEMENT режим

---

**Статус:** ✅ CREATIVE PHASE ЗАВЕРШЕН  
**Дата:** 1 ноября 2025  
**Готов к реализации:** Да
