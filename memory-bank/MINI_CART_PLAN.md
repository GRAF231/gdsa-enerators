# ПЛАН РЕАЛИЗАЦИИ: МИНИ-КОРЗИНА И AJAX ОБНОВЛЕНИЯ

**Дата создания:** 1 ноября 2025  
**Версия:** 1.0  
**Статус:** 📋 Планирование  
**Сложность:** Level 2 (Intermediate)  
**Время выполнения:** 4-5 часов

---

## 📊 СТРУКТУРА ЭТАПОВ

```
ЭТАП 1: VAN + PLAN ✅ ЗАВЕРШЕН
├─ VAN анализ проекта ✅
└─ Создание плана и промптов ✅

ЭТАП 2: CREATIVE ⏳ СЛЕДУЮЩИЙ
├─ Архитектурные решения
├─ UX/UI дизайн
└─ Технические спецификации

ЭТАП 3: IMPLEMENT ⏳ ОЖИДАЕТ
├─ Подзадача 3.1: Хелпер функции PHP
├─ Подзадача 3.2: Mini Cart Template
├─ Подзадача 3.3: CSS стили
├─ Подзадача 3.4: JavaScript функции
├─ Подзадача 3.5: Интеграция в header
├─ Подзадача 3.6: Индикаторы количества
└─ Подзадача 3.7: Обновление карточек товаров

ЭТАП 4: QA + TESTING ⏳ ОЖИДАЕТ
├─ Функциональное тестирование
├─ UX тестирование
└─ Кроссбраузерное тестирование
```

---

## 🎯 ЭТАП 2: CREATIVE (1 час)

### Цель
Разработать детальную архитектуру и дизайн решения.

### Задачи

#### 2.1. Архитектурные решения
- Выбрать подход к обновлению (AJAX fragments vs full reload)
- Определить структуру данных
- Спроектировать API endpoints
- Определить события и хуки

#### 2.2. UX/UI Дизайн
- Финальный дизайн мини-корзины
- Выбрать вариант индикатора количества
- Определить анимации и переходы
- Спецификация состояний (loading, error, empty)

#### 2.3. Технические спецификации
- Детальная структура файлов
- CSS классы и naming convention
- JavaScript функции и их сигнатуры
- PHP функции и параметры

### Документ для создания
- `memory-bank/creative/mini-cart-design.md` (~600 строк)

---

## 🔨 ЭТАП 3: IMPLEMENT (2-3 часа)

### Подзадача 3.1: PHP Хелпер функции

**Файл:** `functions.php`  
**Время:** 20 минут  
**Строк:** ~100

#### Функции для создания:

1. **`dsa_get_cart_item_quantity($product_id)`**
   - Получить количество конкретного товара в корзине
   - Возвращает int

2. **`dsa_ajax_update_mini_cart()`**
   - AJAX обработчик обновления мини-корзины
   - Возвращает JSON с HTML, count, total

3. **`dsa_ajax_remove_from_cart()`**
   - AJAX обработчик удаления товара
   - Параметр: cart_item_key

4. **`dsa_ajax_get_product_quantity()`**
   - Получить количество товара для конкретного product_id
   - Используется при динамическом обновлении

5. **`dsa_enqueue_mini_cart_assets()`**
   - Подключение CSS и JS для мини-корзины

#### ПРОМПТ К ЗАДАЧЕ 3.1:

```
Задача: Добавить PHP хелпер функции для мини-корзины в functions.php

Требования:
1. Добавить функцию dsa_get_cart_item_quantity($product_id) которая:
   - Проверяет существование WC()->cart
   - Перебирает товары в корзине
   - Возвращает quantity для указанного product_id
   - Возвращает 0 если товара нет

2. Добавить AJAX handler dsa_ajax_update_mini_cart() который:
   - Рендерит template-parts/mini-cart.php через ob_start()
   - Получает HTML в переменную
   - Возвращает через wp_send_json_success():
     * html - HTML мини-корзины
     * count - WC()->cart->get_cart_contents_count()
     * total - WC()->cart->get_cart_total()
     * subtotal - WC()->cart->get_cart_subtotal()
   
3. Добавить AJAX handler dsa_ajax_remove_from_cart() который:
   - Получает cart_item_key из $_POST
   - Проверяет nonce для безопасности
   - Вызывает WC()->cart->remove_cart_item($cart_item_key)
   - Вызывает dsa_ajax_update_mini_cart() для обновления

4. Добавить AJAX handler dsa_ajax_get_product_quantity() который:
   - Получает product_id из $_POST
   - Вызывает dsa_get_cart_item_quantity($product_id)
   - Возвращает через wp_send_json(['quantity' => $quantity])

5. Зарегистрировать все AJAX actions для авторизованных и неавторизованных:
   - add_action('wp_ajax_dsa_update_mini_cart', ...)
   - add_action('wp_ajax_nopriv_dsa_update_mini_cart', ...)
   - И так для всех функций

6. Обновить функцию dsa_woocommerce_assets() добавив подключение:
   - CSS: assets/css/mini-cart.css
   - JS: assets/js/mini-cart.js
   - Передать в JS через wp_localize_script:
     * ajaxUrl
     * nonce для безопасности
     * текстовые строки (добавлено, ошибка и т.д.)

Размещение: После существующих AJAX handlers (после строки 1906)
Использовать существующий стиль кода проекта
```

---

### Подзадача 3.2: Mini Cart Template

**Файл:** `template-parts/mini-cart.php` (NEW)  
**Время:** 30 минут  
**Строк:** ~150

#### Структура:

1. **Проверка корзины**
   - Проверить существование WC()->cart
   - Получить товары из корзины

2. **Пустая корзина**
   - Сообщение "Корзина пуста"
   - Ссылка на каталог

3. **Список товаров**
   - Цикл по WC()->cart->get_cart()
   - Для каждого товара:
     * Миниатюра (thumbnail)
     * Название
     * Характеристики (мощность)
     * Цена × количество
     * Кнопка удаления

4. **Итого**
   - Промежуточная сумма
   - Кнопка "Оформить заказ"
   - Ссылка "Перейти в корзину"

#### ПРОМПТ К ЗАДАЧЕ 3.2:

```
Задача: Создать шаблон мини-корзины template-parts/mini-cart.php

Требования:
1. Создать файл template-parts/mini-cart.php
2. Добавить проверку безопасности в начале файла
3. Проверить существование WC()->cart
4. Получить товары через WC()->cart->get_cart()

5. Если корзина пуста, вывести:
   <div class="mini-cart__empty">
     <i class="fa-solid fa-cart-shopping"></i>
     <p>Ваша корзина пуста</p>
     <a href="<?php echo wc_get_page_permalink('shop'); ?>">Перейти в каталог</a>
   </div>

6. Если есть товары, вывести структуру:
   <div class="mini-cart">
     <div class="mini-cart__header">
       <h3>Корзина (<?php echo $count; ?> товаров)</h3>
       <button class="mini-cart__close" aria-label="Закрыть">×</button>
     </div>
     
     <div class="mini-cart__items">
       <?php foreach ($cart_items as $cart_item_key => $cart_item): ?>
         <div class="mini-cart__item" data-cart-item-key="<?php echo $cart_item_key; ?>">
           <!-- Миниатюра -->
           <div class="mini-cart__item-image">
             <?php echo $product->get_image('thumbnail'); ?>
           </div>
           
           <!-- Информация -->
           <div class="mini-cart__item-info">
             <h4><?php echo $product->get_name(); ?></h4>
             <div class="mini-cart__item-meta">
               Мощность: <?php echo dsa_get_product_attribute_value($product_id, 'power'); ?> кВт
             </div>
             <div class="mini-cart__item-price">
               <?php echo $cart_item['quantity']; ?> × 
               <?php echo wc_price($product->get_price()); ?>
             </div>
           </div>
           
           <!-- Удалить -->
           <button class="mini-cart__item-remove" 
                   data-cart-item-key="<?php echo $cart_item_key; ?>"
                   aria-label="Удалить">
             <i class="fa-solid fa-times"></i>
           </button>
         </div>
       <?php endforeach; ?>
     </div>
     
     <div class="mini-cart__footer">
       <div class="mini-cart__total">
         <span>Итого:</span>
         <span><?php echo WC()->cart->get_cart_total(); ?></span>
       </div>
       
       <a href="<?php echo wc_get_checkout_url(); ?>" 
          class="btn btn_type_primary mini-cart__checkout">
         Оформить заказ
       </a>
       
       <a href="<?php echo wc_get_cart_url(); ?>" 
          class="mini-cart__view-cart">
         Перейти в корзину
       </a>
     </div>
   </div>

7. Использовать существующий стиль HTML разметки проекта
8. Добавить все необходимые data-атрибуты для JS
9. Использовать БЭМ naming convention для классов
```

---

### Подзадача 3.3: CSS Стили

**Файл:** `assets/css/mini-cart.css` (NEW)  
**Время:** 30 минут  
**Строк:** ~300

#### Секции стилей:

1. **Основной контейнер**
   - Позиционирование (absolute)
   - Размеры (380px × max 500px)
   - Фон и тени (glassmorphism)
   - Z-index

2. **Анимации**
   - Появление (slideDown + fadeIn)
   - Исчезновение
   - Hover эффекты

3. **Заголовок**
   - Flexbox layout
   - Кнопка закрытия

4. **Список товаров**
   - Скролл
   - Разделители
   - Hover состояния

5. **Карточка товара**
   - Grid layout
   - Миниатюра, текст, кнопка
   - Адаптивность

6. **Футер**
   - Итоговая сумма
   - Кнопки действий

7. **Адаптивность**
   - Tablet (<1024px)
   - Mobile (<768px)

#### ПРОМПТ К ЗАДАЧЕ 3.3:

```
Задача: Создать CSS стили для мини-корзины assets/css/mini-cart.css

Требования к дизайну:
1. Использовать существующие CSS переменные проекта (var(--primary), var(--radius) и т.д.)
2. Применить glassmorphism эффект как в личном кабинете
3. Плавные анимации 60fps

Структура файла:
1. Основной контейнер .mini-cart-dropdown:
   - position: absolute
   - top: calc(100% + 10px)
   - right: 0
   - width: 380px
   - max-height: 500px
   - background: white
   - border-radius: 12px
   - box-shadow: 0 20px 60px rgba(0,0,0,0.15)
   - z-index: 10000
   - opacity: 0 (по умолчанию скрыт)
   - pointer-events: none
   - transition: opacity 0.3s, transform 0.3s

2. Класс .mini-cart-dropdown.is-open:
   - opacity: 1
   - pointer-events: all
   - transform: translateY(0)

3. Анимации @keyframes:
   - slideInDown (transform + opacity)
   - fadeIn
   - shake (для ошибок)

4. .mini-cart__header:
   - display: flex
   - justify-content: space-between
   - padding: 20px
   - border-bottom: 1px solid rgba(0,0,0,0.1)

5. .mini-cart__items:
   - max-height: 300px
   - overflow-y: auto
   - padding: 16px

6. .mini-cart__item:
   - display: grid
   - grid-template-columns: 60px 1fr auto
   - gap: 12px
   - padding: 12px
   - border-bottom: 1px solid rgba(0,0,0,0.05)
   - transition: background 0.2s
   - hover: background: rgba(0,0,0,0.02)

7. .mini-cart__item-image:
   - width: 60px
   - height: 60px
   - border-radius: 8px
   - overflow: hidden

8. .mini-cart__item-remove:
   - width: 32px
   - height: 32px
   - border-radius: 50%
   - hover: background: rgba(255,0,0,0.1)
   - hover color: red

9. .mini-cart__footer:
   - padding: 20px
   - border-top: 1px solid rgba(0,0,0,0.1)

10. .mini-cart__total:
    - display: flex
    - justify-content: space-between
    - font-size: 18px
    - font-weight: 600
    - margin-bottom: 16px

11. Адаптивность:
    @media (max-width: 768px):
      - width: calc(100vw - 32px)
      - right: 16px
      - max-height: 70vh

12. .mini-cart__empty:
    - text-align: center
    - padding: 40px 20px
    - color: #999

13. Использовать существующие классы кнопок .btn, .btn_type_primary
```

---

### Подзадача 3.4: JavaScript функции

**Файл:** `assets/js/mini-cart.js` (NEW)  
**Время:** 40 минут  
**Строк:** ~250

#### Функции для создания:

1. **initMiniCart()** - инициализация
2. **toggleMiniCart()** - открытие/закрытие
3. **updateMiniCart()** - обновление через AJAX
4. **removeFromCart(cartItemKey)** - удаление товара
5. **closeMiniCart()** - закрытие
6. **Global: dsaAddToCart()** - универсальная функция добавления

#### ПРОМПТ К ЗАДАЧЕ 3.4:

```
Задача: Создать JavaScript функции для мини-корзины assets/js/mini-cart.js

Требования:
1. Использовать IIFE для изоляции кода
2. Vanilla JavaScript (без jQuery, как в wc-catalog.js)
3. Создать глобальную функцию window.dsaAddToCart

Структура файла:

(function() {
  'use strict';
  
  // Конфигурация
  const config = {
    ajaxUrl: dsaMiniCartParams.ajaxUrl,
    nonce: dsaMiniCartParams.nonce
  };
  
  // DOM элементы
  let miniCartToggle, miniCartDropdown, miniCartCloseBtn;
  
  // Инициализация при загрузке DOM
  document.addEventListener('DOMContentLoaded', function() {
    initMiniCart();
  });
  
  // 1. Инициализация
  function initMiniCart() {
    // Получить DOM элементы
    miniCartToggle = document.querySelector('.header__cart-toggle');
    miniCartDropdown = document.querySelector('.mini-cart-dropdown');
    miniCartCloseBtn = document.querySelector('.mini-cart__close');
    
    // Навесить обработчики
    if (miniCartToggle) {
      miniCartToggle.addEventListener('click', toggleMiniCart);
    }
    
    if (miniCartCloseBtn) {
      miniCartCloseBtn.addEventListener('click', closeMiniCart);
    }
    
    // Закрытие при клике вне области
    document.addEventListener('click', function(e) {
      if (!miniCartDropdown.contains(e.target) && 
          !miniCartToggle.contains(e.target)) {
        closeMiniCart();
      }
    });
    
    // Обработчики удаления товаров
    initRemoveButtons();
  }
  
  // 2. Открытие/закрытие
  function toggleMiniCart(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const isOpen = miniCartDropdown.classList.contains('is-open');
    
    if (isOpen) {
      closeMiniCart();
    } else {
      openMiniCart();
    }
  }
  
  // 3. Открытие
  function openMiniCart() {
    miniCartDropdown.classList.add('is-open');
    miniCartToggle.setAttribute('aria-expanded', 'true');
  }
  
  // 4. Закрытие
  function closeMiniCart() {
    miniCartDropdown.classList.remove('is-open');
    miniCartToggle.setAttribute('aria-expanded', 'false');
  }
  
  // 5. Обновление мини-корзины через AJAX
  function updateMiniCart() {
    const formData = new FormData();
    formData.append('action', 'dsa_update_mini_cart');
    formData.append('nonce', config.nonce);
    
    fetch(config.ajaxUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Обновить HTML
        const container = document.querySelector('.mini-cart-dropdown-inner');
        if (container) {
          container.innerHTML = data.data.html;
        }
        
        // Обновить счетчик
        updateCartCounter(data.data.count);
        
        // Пере-инициализировать обработчики
        initRemoveButtons();
      }
    })
    .catch(error => console.error('Error:', error));
  }
  
  // 6. Удаление товара
  function removeFromCart(cartItemKey) {
    const formData = new FormData();
    formData.append('action', 'dsa_remove_from_cart');
    formData.append('cart_item_key', cartItemKey);
    formData.append('nonce', config.nonce);
    
    fetch(config.ajaxUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateMiniCart();
        showNotification('Товар удален из корзины', 'success');
      }
    })
    .catch(error => console.error('Error:', error));
  }
  
  // 7. Инициализация кнопок удаления
  function initRemoveButtons() {
    const removeButtons = document.querySelectorAll('.mini-cart__item-remove');
    
    removeButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        const cartItemKey = this.dataset.cartItemKey;
        removeFromCart(cartItemKey);
      });
    });
  }
  
  // 8. Обновление счетчика
  function updateCartCounter(count) {
    const badges = document.querySelectorAll('.header__badge');
    badges.forEach(badge => {
      badge.textContent = count;
    });
  }
  
  // 9. Уведомления
  function showNotification(message, type = 'info') {
    // Использовать существующую функцию из wc-catalog.js
    const notification = document.createElement('div');
    notification.className = `notification notification_${type}`;
    notification.textContent = message;
    notification.style.cssText = `
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 20px;
      background: ${type === 'success' ? '#4CAF50' : '#f44336'};
      color: white;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      z-index: 10001;
      animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.animation = 'slideOut 0.3s ease-out';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
  }
  
  // 10. ГЛОБАЛЬНАЯ функция добавления в корзину
  window.dsaAddToCart = function(button, quantity = 1) {
    if (!button) return;
    
    const productId = button.dataset.productId || button.getAttribute('data-product-id');
    
    if (!productId) {
      console.error('Product ID not found');
      return;
    }
    
    // Loading state
    button.classList.add('loading');
    button.disabled = true;
    
    const formData = new FormData();
    formData.append('action', 'woocommerce_add_to_cart');
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    
    fetch(config.ajaxUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      button.classList.remove('loading');
      button.disabled = false;
      
      if (data.success) {
        // Обновить мини-корзину
        updateMiniCart();
        
        // Показать уведомление
        showNotification('Товар добавлен в корзину', 'success');
        
        // Открыть мини-корзину
        setTimeout(() => openMiniCart(), 100);
        
        // Обновить индикатор количества на кнопке
        updateProductQuantityIndicator(productId, button);
      } else {
        showNotification('Ошибка добавления товара', 'error');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      button.classList.remove('loading');
      button.disabled = false;
      showNotification('Произошла ошибка', 'error');
    });
  };
  
  // 11. Обновление индикатора количества
  function updateProductQuantityIndicator(productId, button) {
    const formData = new FormData();
    formData.append('action', 'dsa_get_product_quantity');
    formData.append('product_id', productId);
    
    fetch(config.ajaxUrl, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      const quantity = data.quantity || 0;
      
      // Найти индикатор рядом с кнопкой
      const indicator = button.parentElement.querySelector('.product-quantity-indicator');
      
      if (indicator) {
        if (quantity > 0) {
          indicator.textContent = `В корзине: ${quantity} шт.`;
          indicator.style.display = 'block';
        } else {
          indicator.style.display = 'none';
        }
      }
    })
    .catch(error => console.error('Error:', error));
  }
  
  // Экспорт функций для использования в других модулях
  window.dsaMiniCart = {
    update: updateMiniCart,
    open: openMiniCart,
    close: closeMiniCart
  };
  
})();
```

---

### Подзадача 3.5: Интеграция в header

**Файл:** `header.php`  
**Время:** 15 минут  
**Строк:** ~20 изменений

#### ПРОМПТ К ЗАДАЧЕ 3.5:

```
Задача: Интегрировать мини-корзину в header.php

Требования:
1. Найти блок с иконкой корзины (строки 98-102)

2. Обернуть в контейнер с относительным позиционированием:
   <div class="header__cart-wrapper">
     <!-- Существующая ссылка корзины -->
     <a href="..." class="header__icon-btn header__cart-toggle">
       ...
     </a>
     
     <!-- Новый контейнер для мини-корзины -->
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

3. Добавить класс .header__cart-toggle к ссылке корзины

4. Добавить aria-expanded="false" к ссылке корзины

5. Сохранить все существующие классы и структуру

6. Применить изменения только для авторизованных пользователей (если is_user_logged_in())
```

---

### Подзадача 3.6: Индикаторы количества в PHP шаблонах

**Файлы:** 
- `woocommerce/single-product/product-related.php`
- `woocommerce/single-product/product-info.php`

**Время:** 20 минут  
**Строк:** ~40 изменений

#### ПРОМПТ К ЗАДАЧЕ 3.6:

```
Задача: Добавить индикаторы количества товара в корзине на страницу товара и похожие товары

Часть 1: product-related.php
1. В цикле похожих товаров (строка 42), после получения $related_id
2. Добавить получение количества:
   $cart_quantity = dsa_get_cart_item_quantity($related_id);

3. В блоке .similar-card__actions (строки 97-109), ПЕРЕД кнопками добавить:
   <?php if ($cart_quantity > 0): ?>
     <div class="product-quantity-indicator">
       <i class="fa-solid fa-check-circle"></i>
       <span>В корзине: <?php echo $cart_quantity; ?> шт.</span>
     </div>
   <?php endif; ?>

4. Обновить кнопку добавления:
   - Заменить onclick="dsaAddToCart(this);"
   - На onclick="dsaAddToCart(this, 1);"

Часть 2: product-info.php
1. В начале файла, после получения $product_id (строка 16):
   $cart_quantity = dsa_get_cart_item_quantity($product_id);

2. В блоке .product-actions (строки 152-166), ПЕРЕД кнопками добавить:
   <?php if ($cart_quantity > 0): ?>
     <div class="product-quantity-indicator product-quantity-indicator_large">
       <i class="fa-solid fa-check-circle"></i>
       <span>Уже в корзине: <?php echo $cart_quantity; ?> шт.</span>
     </div>
   <?php endif; ?>

3. Сохранить все существующие классы и структуру
```

---

### Подзадача 3.7: Обновление функций рендеринга каталога

**Файл:** `functions.php` (функция `dsa_render_grouped_catalog_products`)  
**Время:** 30 минут  
**Строк:** ~50 изменений

#### ПРОМПТ К ЗАДАЧЕ 3.7:

```
Задача: Добавить отображение количества товара в корзине в функцию рендеринга каталога

Требования:
1. Найти функцию dsa_render_grouped_catalog_products() в functions.php (около строки 1780)

2. В цикле товаров (while loop внутри foreach по группам):
   - После получения $product
   - Добавить: $cart_quantity = dsa_get_cart_item_quantity($product->get_id());

3. Для карточного вида (.catalog-card):
   - Найти блок с кнопками (.catalog-card__actions или аналогичный)
   - ПЕРЕД кнопками добавить:
     <?php if ($cart_quantity > 0): ?>
       <div class="product-quantity-indicator">
         <i class="fa-solid fa-check-circle"></i>
         <span>В корзине: <?php echo $cart_quantity; ?> шт.</span>
       </div>
     <?php endif; ?>

4. Для табличного вида (.catalog-table__row):
   - В ячейке с кнопкой добавления
   - Добавить аналогичный индикатор

5. Обновить все кнопки добавления:
   - Добавить data-product-id="<?php echo $product->get_id(); ?>"
   - Добавить onclick="dsaAddToCart(this);"

6. Проверить что класс кнопки catalog-product__btn_primary существует

Примечание: Если функции рендеринга сложные и разбросаны, 
сначала найти все места где выводятся карточки товаров и 
применить изменения ко всем.
```

---

## 📊 ЭТАП 4: QA + TESTING (1 час)

### Чек-лист функционального тестирования

#### Мини-корзина
- [ ] Открывается при клике на иконку корзины
- [ ] Закрывается при клике на крестик
- [ ] Закрывается при клике вне области
- [ ] Показывает корректное количество товаров
- [ ] Отображает миниатюры товаров
- [ ] Показывает правильную сумму
- [ ] Кнопка "Оформить заказ" ведет на checkout
- [ ] Пустая корзина показывает сообщение

#### AJAX добавление
- [ ] Товар добавляется без перезагрузки (каталог)
- [ ] Товар добавляется без перезагрузки (страница товара)
- [ ] Товар добавляется без перезагрузки (похожие товары)
- [ ] Счетчик обновляется моментально
- [ ] Мини-корзина открывается после добавления
- [ ] Показывается уведомление об успехе
- [ ] Кнопка показывает loading состояние
- [ ] Обрабатываются ошибки (товар не в наличии)

#### Индикатор количества
- [ ] Показывается при первой загрузке страницы
- [ ] Обновляется после добавления товара
- [ ] Показывает правильное количество
- [ ] Скрывается если quantity = 0
- [ ] Работает на всех типах страниц

#### Удаление из мини-корзины
- [ ] Кнопка удаления работает
- [ ] Товар удаляется из корзины
- [ ] Мини-корзина обновляется
- [ ] Счетчик уменьшается
- [ ] Показывается уведомление

### UX тестирование
- [ ] Анимации плавные
- [ ] Нет задержек при взаимодействии
- [ ] Кнопки отзывчивые
- [ ] Текст читаемый
- [ ] Иконки понятные
- [ ] Цвета соответствуют дизайну

### Адаптивность
- [ ] Desktop (1920px) - корректное отображение
- [ ] Laptop (1366px) - корректное отображение
- [ ] Tablet (768px) - адаптированный дизайн
- [ ] Mobile (375px) - мобильная версия

### Кроссбраузерность
- [ ] Chrome - работает
- [ ] Firefox - работает
- [ ] Safari - работает
- [ ] Edge - работает

### Производительность
- [ ] AJAX запросы < 500ms
- [ ] Нет утечек памяти
- [ ] Плавная прокрутка списка товаров

---

## 📝 ПРОМПТЫ ДЛЯ CREATIVE РЕЖИМА

### Промпт для создания creative/mini-cart-design.md

```
Задача: Создать детальный дизайн-документ для мини-корзины

Создай файл memory-bank/creative/mini-cart-design.md со следующими разделами:

1. АРХИТЕКТУРНЫЕ РЕШЕНИЯ
   - Выбор между AJAX fragments vs custom endpoints (рекомендация: custom для большей гибкости)
   - Структура данных для обмена
   - События и хуки WordPress
   - Стратегия кэширования

2. UX/UI ДИЗАЙН
   - Финальный дизайн мини-корзины (ASCII схема)
   - Выбранный вариант индикатора количества (Вариант 3)
   - Цветовая схема
   - Типографика
   - Анимации (появление, исчезновение, hover)
   - Состояния (default, loading, error, empty)

3. ТЕХНИЧЕСКИЕ СПЕЦИФИКАЦИИ
   - Детальная структура всех файлов
   - CSS классы (полный список с описанием)
   - JavaScript функции (сигнатуры, параметры, возвращаемые значения)
   - PHP функции (параметры, типы, возвращаемые значения)
   - AJAX endpoints (action, параметры, response)

4. API SPECIFICATION
   - Endpoint 1: dsa_update_mini_cart
     * Request: { action, nonce }
     * Response: { success, data: { html, count, total, subtotal } }
   
   - Endpoint 2: dsa_remove_from_cart
     * Request: { action, cart_item_key, nonce }
     * Response: { success, data: { ... } }
   
   - Endpoint 3: dsa_get_product_quantity
     * Request: { action, product_id }
     * Response: { quantity }

5. ИНТЕГРАЦИОННЫЕ ТОЧКИ
   - Где и как интегрируется в header.php
   - Как обновляются карточки товаров
   - Взаимодействие с существующим JS

6. ERROR HANDLING
   - Обработка ошибок AJAX
   - Валидация данных
   - Fallback сценарии

7. ACCESSIBILITY
   - ARIA атрибуты
   - Keyboard navigation
   - Screen reader support

Используй стиль документации проекта (как в WOOCOMMERCE_PLAN.md)
Размер: ~600 строк
```

---

## 🔗 СВЯЗАННЫЕ ДОКУМЕНТЫ

- **VAN Report:** `memory-bank/MINI_CART_VAN_REPORT.md` - анализ проекта
- **Tasks:** `memory-bank/tasks.md` - трекер задач
- **Progress:** `memory-bank/progress.md` - история
- **Tech Context:** `memory-bank/techContext.md` - техническая база

---

## ✅ CHECKLIST ГОТОВНОСТИ К IMPLEMENT

Перед началом IMPLEMENT убедись что:

- [x] VAN анализ завершен
- [x] PLAN создан с промптами
- [ ] CREATIVE документ создан
- [ ] Все архитектурные решения приняты
- [ ] UX/UI дизайн утвержден
- [ ] Технические спецификации детализированы
- [ ] Промпты к подзадачам готовы

---

**Статус:** ✅ PLAN завершен  
**Следующий шаг:** CREATIVE режим  
**Готовность к реализации:** 90%
