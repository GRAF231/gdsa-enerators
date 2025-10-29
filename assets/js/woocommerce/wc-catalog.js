/**
 * WooCommerce Catalog Scripts
 * 
 * Функционал для каталога товаров:
 * - Переключение видов отображения (табличный/карточный)
 * - Работа с фильтрами
 * - Добавление товаров в корзину
 */

(function() {
    'use strict';

    /**
     * Инициализация при загрузке DOM
     */
    document.addEventListener('DOMContentLoaded', function() {
        initCatalogFilters();
        initAddToCart();
        initPerPageButtons();
        initViewToggle();
    });

    /**
     * Инициализация переключателя видов каталога
     */
    function initViewToggle() {
        const viewButtons = document.querySelectorAll('[data-view]');
        
        if (viewButtons.length === 0) return;
        
        viewButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const view = this.getAttribute('data-view');
                
                // Сохраняем в localStorage
                localStorage.setItem('catalog_view', view);
                
                // Сохраняем в cookie
                document.cookie = `catalog_view=${view}; path=/; max-age=${30 * 24 * 60 * 60}`;
                
                // Получаем текущий URL
                const url = new URL(window.location.href);
                
                // Устанавливаем параметр view
                url.searchParams.set('view', view);
                
                // Перезагружаем страницу с новым видом
                window.location.href = url.toString();
            });
        });
        
        // Восстанавливаем вид из localStorage при загрузке
        const savedView = localStorage.getItem('catalog_view');
        if (savedView && !window.location.search.includes('view=')) {
            // Если нет параметра view в URL, но есть сохраненный вид
            const url = new URL(window.location.href);
            url.searchParams.set('view', savedView);
            window.location.replace(url.toString());
        }
    }

    /**
     * Инициализация фильтров каталога
     */
    function initCatalogFilters() {
        const toggleBtn = document.querySelector('.catalog-filters__toggle-btn');
        const panel = document.querySelector('.catalog-filters__panel');

        if (toggleBtn && panel) {
            // Переключение видимости панели фильтров
            toggleBtn.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                panel.setAttribute('aria-expanded', !isExpanded);
                
                if (!isExpanded) {
                    panel.style.display = 'block';
                } else {
                    panel.style.display = 'none';
                }
            });
        }

        // Автоматическая отправка формы при изменении фильтров (опционально)
        const filterSelects = document.querySelectorAll('.catalog-filters__select');
        filterSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                // Можно включить автоматическую фильтрацию:
                // select.closest('form').submit();
            });
        });
    }

    /**
     * Инициализация кнопок "Выводить по"
     */
    function initPerPageButtons() {
        const perPageButtons = document.querySelectorAll('.pagination__per-page-btn');
        
        if (perPageButtons.length === 0) return;
        
        perPageButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const perPage = parseInt(this.textContent);
                
                // Получаем текущий URL
                const url = new URL(window.location.href);
                
                // Устанавливаем параметр per_page
                url.searchParams.set('per_page', perPage);
                
                // Сбрасываем на первую страницу при изменении количества
                url.pathname = url.pathname.replace(/\/page\/\d+\/?/, '/');
                
                // Перезагружаем страницу с новыми параметрами
                window.location.href = url.toString();
            });
        });
    }

    /**
     * Инициализация кнопок добавления в корзину
     */
    function initAddToCart() {
        const addToCartButtons = document.querySelectorAll('.catalog-product__btn_primary');

        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const productId = this.getAttribute('data-product-id');
                
                if (!productId) {
                    console.error('Product ID not found');
                    return;
                }

                // Добавляем класс загрузки
                this.classList.add('loading');
                this.disabled = true;

                // AJAX запрос для добавления в корзину
                addProductToCart(productId, this);
            });
        });
    }

    /**
     * Добавление товара в корзину через AJAX
     * 
     * @param {string} productId - ID товара
     * @param {HTMLElement} button - Кнопка, которая была нажата
     */
    function addProductToCart(productId, button) {
        // Используем стандартный WooCommerce AJAX
        const data = {
            action: 'woocommerce_add_to_cart',
            product_id: productId,
            quantity: 1
        };

        fetch(wc_add_to_cart_params.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data)
        })
        .then(response => response.json())
        .then(data => {
            // Убираем класс загрузки
            button.classList.remove('loading');
            button.disabled = false;

            if (data.error) {
                // Показываем ошибку
                showNotification('Ошибка добавления в корзину', 'error');
            } else {
                // Успешно добавлено
                showNotification('Товар добавлен в корзину', 'success');
                
                // Обновляем счетчик корзины в шапке (если есть)
                updateCartCount();
                
                // Триггерим событие для других скриптов
                document.dispatchEvent(new CustomEvent('added_to_cart', {
                    detail: { productId: productId }
                }));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.classList.remove('loading');
            button.disabled = false;
            showNotification('Произошла ошибка', 'error');
        });
    }

    /**
     * Обновление счетчика товаров в корзине
     */
    function updateCartCount() {
        // Получаем количество товаров в корзине
        fetch(wc_add_to_cart_params.ajax_url + '?action=get_cart_count')
            .then(response => response.json())
            .then(data => {
                const badges = document.querySelectorAll('.header__badge');
                badges.forEach(function(badge) {
                    if (badge.closest('[aria-label="Корзина"]')) {
                        badge.textContent = data.count || 0;
                    }
                });
            })
            .catch(error => console.error('Error updating cart count:', error));
    }

    /**
     * Показ уведомления пользователю
     * 
     * @param {string} message - Текст сообщения
     * @param {string} type - Тип сообщения (success, error, info)
     */
    function showNotification(message, type = 'info') {
        // Создаем элемент уведомления
        const notification = document.createElement('div');
        notification.className = `notification notification_${type}`;
        notification.textContent = message;
        
        // Добавляем стили (если нет глобального CSS)
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
            color: white;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        `;

        document.body.appendChild(notification);

        // Удаляем через 3 секунды
        setTimeout(function() {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Добавляем CSS анимации для уведомлений
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        .catalog-product__btn.loading {
            opacity: 0.6;
            cursor: wait;
        }
    `;
    document.head.appendChild(style);

})();
