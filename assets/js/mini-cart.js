/**
 * Mini Cart JavaScript
 * Управление мини-корзиной и AJAX функционалом
 * 
 * @package DSA_Generators
 * @since 1.0
 */

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
    
    /**
     * 1. Инициализация мини-корзины
     */
    function initMiniCart() {
        // Получить DOM элементы
        miniCartToggle = document.querySelector('.header__cart-toggle');
        miniCartDropdown = document.querySelector('.mini-cart-dropdown');
        miniCartCloseBtn = document.querySelector('.mini-cart__close');
        
        if (!miniCartToggle || !miniCartDropdown) {
            return; // Мини-корзина не найдена на странице
        }
        
        // Обработчики наведения для открытия
        let hoverTimeout;
        
        miniCartToggle.addEventListener('mouseenter', function() {
            // Небольшая задержка перед открытием
            hoverTimeout = setTimeout(() => {
                openMiniCart();
            }, 200);
        });
        
        miniCartToggle.addEventListener('mouseleave', function() {
            clearTimeout(hoverTimeout);
        });
        
        // Держим мини-корзину открытой при наведении на неё
        miniCartDropdown.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
        });
        
        miniCartDropdown.addEventListener('mouseleave', function() {
            // Закрываем с небольшой задержкой
            hoverTimeout = setTimeout(() => {
                closeMiniCart();
            }, 300);
        });
        
        // Дополнительно: клик для мобильных устройств
        miniCartToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleMiniCart(e);
        });
        
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
        
        // Keyboard navigation (Escape для закрытия)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && miniCartDropdown.classList.contains('is-open')) {
                closeMiniCart();
            }
        });
    }
    
    /**
     * 2. Открытие/закрытие мини-корзины
     * @param {Event} e
     */
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
    
    /**
     * 3. Открытие мини-корзины
     */
    function openMiniCart() {
        miniCartDropdown.classList.add('is-open');
        miniCartToggle.setAttribute('aria-expanded', 'true');
    }
    
    /**
     * 4. Закрытие мини-корзины
     */
    function closeMiniCart() {
        miniCartDropdown.classList.remove('is-open');
        if (miniCartToggle) {
            miniCartToggle.setAttribute('aria-expanded', 'false');
        }
    }
    
    /**
     * 5. Обновление мини-корзины через AJAX
     * @returns {Promise<void>}
     */
    function updateMiniCart() {
        const formData = new FormData();
        formData.append('action', 'dsa_update_mini_cart');
        formData.append('nonce', config.nonce);
        
        return fetch(config.ajaxUrl, {
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
                miniCartCloseBtn = document.querySelector('.mini-cart__close');
                if (miniCartCloseBtn) {
                    miniCartCloseBtn.addEventListener('click', closeMiniCart);
                }
                initRemoveButtons();
            }
        })
        .catch(error => {
            console.error('Error updating mini cart:', error);
            showNotification('Ошибка обновления корзины', 'error');
        });
    }
    
    /**
     * 6. Удаление товара из корзины
     * @param {string} cartItemKey
     * @returns {Promise<void>}
     */
    function removeFromCart(cartItemKey) {
        const formData = new FormData();
        formData.append('action', 'dsa_remove_from_cart');
        formData.append('cart_item_key', cartItemKey);
        formData.append('nonce', config.nonce);
        
        return fetch(config.ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Обновляем мини-корзину (сервер уже вернул обновленные данные)
                const container = document.querySelector('.mini-cart-dropdown-inner');
                if (container) {
                    container.innerHTML = data.data.html;
                }
                
                // Обновить счетчик
                updateCartCounter(data.data.count);
                
                // Если мы на странице товара, обновляем каунтер
                const removedProductId = data.data.product_id;
                if (removedProductId) {
                    updatePageQuantityCounter(removedProductId);
                    
                    // НОВОЕ: Генерируем событие для product.js
                    const event = new CustomEvent('dsa-cart-item-removed', {
                        detail: { productId: removedProductId }
                    });
                    document.dispatchEvent(event);
                }
                
                // Пере-инициализировать обработчики
                miniCartCloseBtn = document.querySelector('.mini-cart__close');
                if (miniCartCloseBtn) {
                    miniCartCloseBtn.addEventListener('click', closeMiniCart);
                }
                initRemoveButtons();
                
                showNotification('Товар удален из корзины', 'success');
            } else {
                showNotification(data.data.message || 'Ошибка удаления товара', 'error');
            }
        })
        .catch(error => {
            console.error('Error removing from cart:', error);
            showNotification('Ошибка соединения', 'error');
        });
    }
    
    /**
     * 7. Инициализация кнопок удаления
     */
    function initRemoveButtons() {
        const removeButtons = document.querySelectorAll('.mini-cart__item-remove');
        
        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const cartItemKey = this.dataset.cartItemKey;
                if (cartItemKey) {
                    removeFromCart(cartItemKey);
                }
            });
        });
    }
    
    /**
     * 8. Обновление счетчика корзины в header
     * @param {number} count
     */
    function updateCartCounter(count) {
        const badges = document.querySelectorAll('.header__badge');
        badges.forEach(badge => {
            badge.textContent = count;
            
            // Анимация обновления
            badge.style.transform = 'scale(1.3)';
            setTimeout(() => {
                badge.style.transform = 'scale(1)';
            }, 200);
        });
    }
    
    /**
     * 9. Показ уведомлений
     * @param {string} message
     * @param {string} type - 'success', 'error', 'info'
     */
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification_${type}`;
        notification.textContent = message;
        
        // Стили уведомления
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10001;
            animation: slideIn 0.3s ease-out;
            font-size: 14px;
            max-width: 300px;
        `;
        
        document.body.appendChild(notification);
        
        // Автоудаление через 3 секунды
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    /**
     * 10. ГЛОБАЛЬНАЯ функция добавления в корзину
     * Доступна везде как window.dsaAddToCart()
     * @param {HTMLElement} button - Кнопка добавления
     * @param {number} quantity - Количество товара
     * @returns {Promise<void>}
     */
    window.dsaAddToCart = function(button, quantity = 1) {
        if (!button) {
            console.error('Button element is required');
            return;
        }
        
        const productId = button.dataset.productId || button.getAttribute('data-product-id');
        
        if (!productId || isNaN(productId)) {
            console.error('Invalid product ID:', productId);
            showNotification('Ошибка: не указан ID товара', 'error');
            return;
        }
        
        // Loading state
        button.classList.add('loading');
        button.disabled = true;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        
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
            // Восстанавливаем кнопку
            button.classList.remove('loading');
            button.disabled = false;
            button.innerHTML = originalText;
            
            if (data.success) {
                // Обновить мини-корзину
                updateMiniCart().then(() => {
                    // Открыть мини-корзину после обновления
                    setTimeout(() => openMiniCart(), 100);
                });
                
                // Показать уведомление
                showNotification('Товар добавлен в корзину', 'success');
                
                // Обновить индикатор количества на кнопке
                updateProductQuantityIndicator(productId, button);
            } else {
                showNotification(data.data?.message || 'Ошибка добавления товара', 'error');
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            button.classList.remove('loading');
            button.disabled = false;
            button.innerHTML = originalText;
            showNotification('Произошла ошибка соединения', 'error');
        });
    };
    
    /**
     * 11. Обновление индикатора количества товара
     * @param {number} productId
     * @param {HTMLElement} button
     */
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
            
            // Найти или создать индикатор рядом с кнопкой
            let indicator = button.parentElement.querySelector('.product-quantity-indicator');
            
            if (quantity > 0) {
                if (!indicator) {
                    // Создаем индикатор если его нет
                    indicator = document.createElement('div');
                    indicator.className = 'product-quantity-indicator';
                    button.parentElement.insertBefore(indicator, button);
                }
                
                indicator.innerHTML = `
                    <i class="fa-solid fa-check-circle"></i>
                    <span>В корзине: ${quantity} шт.</span>
                `;
                indicator.style.display = 'inline-flex';
            } else if (indicator) {
                // Скрываем индикатор если товара нет в корзине
                indicator.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error updating quantity indicator:', error);
        });
    }
    
    /**
     * 12. Обновление каунтера на странице товара при удалении
     * Если мы находимся на странице удаленного товара, сбрасываем каунтер на 1
     * @param {number} productId - ID удаленного товара
     */
    function updatePageQuantityCounter(productId) {
        // Проверяем, есть ли на странице input с name="add-to-cart"
        const addToCartInput = document.querySelector('[name="add-to-cart"]');
        
        if (!addToCartInput) {
            return; // Мы не на странице товара
        }
        
        const currentPageProductId = parseInt(addToCartInput.value);
        
        // Проверяем, совпадает ли ID удаленного товара с текущей страницей
        if (currentPageProductId !== parseInt(productId)) {
            return; // Удален другой товар
        }
        
        // Находим каунтер и сбрасываем на 1
        const quantityInput = document.querySelector('.product-actions .quantity input.qty');
        if (quantityInput) {
            quantityInput.value = 1;
            
            // Обновляем состояние кнопок +/-
            const minusBtn = quantityInput.parentElement.querySelector('.quantity-minus');
            const plusBtn = quantityInput.parentElement.querySelector('.quantity-plus');
            if (minusBtn) minusBtn.disabled = true;
            if (plusBtn) plusBtn.disabled = false;
            
            console.log('Каунтер товара сброшен на 1');
        }
    }
    
    /**
     * 13. Экспорт функций для использования в других модулях
     */
    window.dsaMiniCart = {
        update: updateMiniCart,
        open: openMiniCart,
        close: closeMiniCart,
        showNotification: showNotification,
        removeFromCart: removeFromCart,
        initRemoveButtons: initRemoveButtons
    };
    
})();
