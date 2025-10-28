// ========================================
// СТРАНИЦА ТОВАРА - ИНТЕРАКТИВНОСТЬ
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    // Инициализация компонентов страницы товара
    initProductPage();
});

function initProductPage() {
    // Инициализация табов характеристик
    initProductTabs();
    
    // Инициализация кнопки "В корзину"
    initAddToCart();
    
    // Инициализация формы запроса
    initRequestForm();
    
    // Инициализация дополнительных опций
    initProductOptions();
    
    // Инициализация подсказок
    initProductHelp();
    
    // Инициализация кнопки "Запросить КП"
    initQuoteRequest();
}

// ========================================
// ТАБЫ ХАРАКТЕРИСТИК
// ========================================
function initProductTabs() {
    const tabButtons = document.querySelectorAll('.product-tabs__btn');
    const tabPanels = document.querySelectorAll('.product-tabs__panel');
    
    if (tabButtons.length === 0) return;
    
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Деактивация всех кнопок и панелей
            tabButtons.forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            
            tabPanels.forEach(panel => {
                panel.classList.remove('active');
                panel.style.display = 'none';
            });
            
            // Активация выбранной кнопки и панели
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            
            const targetPanel = document.querySelector(`[data-panel="${targetTab}"]`);
            if (targetPanel) {
                targetPanel.classList.add('active');
                targetPanel.style.display = 'block';
                
                // Плавная анимация появления
                targetPanel.style.opacity = '0';
                targetPanel.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    targetPanel.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    targetPanel.style.opacity = '1';
                    targetPanel.style.transform = 'translateY(0)';
                }, 10);
            }
            
            // Анимация кнопки
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
}

// ========================================
// ДОБАВЛЕНИЕ В КОРЗИНУ
// ========================================

// Добавление в корзину
function initAddToCart() {
    const addToCartBtn = document.querySelector('.product-btn-cart');
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Анимация кнопки
            this.style.transform = 'scale(0.95)';
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Добавляем...</span>';
            
            // Симуляция добавления в корзину
            setTimeout(() => {
                this.style.transform = 'scale(1)';
                this.innerHTML = '<i class="fa-solid fa-check"></i><span>Добавлено!</span>';
                this.style.background = 'linear-gradient(135deg, #00c851 0%, #00a041 100%)';
                
                // Обновление счетчика корзины в header
                updateCartCounter();
                
                // Показ уведомления
                showNotification('Товар добавлен в корзину!', 'success');
                
                // Возврат к исходному состоянию через 2 секунды
                setTimeout(() => {
                    this.innerHTML = '<i class="fa-solid fa-cart-plus"></i><span>В корзину</span>';
                    this.style.background = 'linear-gradient(135deg, #0a1855 0%, #3b5fdb 100%)';
                }, 2000);
            }, 1000);
        });
    }
}

// Обновление счетчика корзины
function updateCartCounter() {
    const cartBadge = document.querySelector('.header__badge');
    if (cartBadge) {
        const currentCount = parseInt(cartBadge.textContent) || 0;
        cartBadge.textContent = currentCount + 1;
        
        // Анимация обновления
        cartBadge.style.transform = 'scale(1.2)';
        setTimeout(() => {
            cartBadge.style.transform = 'scale(1)';
        }, 200);
    }
}

// Форма запроса
function initRequestForm() {
    const requestForm = document.querySelector('.request-form');
    
    if (requestForm) {
        requestForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.request-form__submit');
            const originalText = submitBtn.innerHTML;
            
            // Валидация формы
            if (!validateRequestForm(this)) {
                return;
            }
            
            // Анимация отправки
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Отправляем...</span>';
            submitBtn.disabled = true;
            
            // Симуляция отправки
            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fa-solid fa-check"></i><span>Отправлено!</span>';
                submitBtn.style.background = 'linear-gradient(135deg, #00c851 0%, #00a041 100%)';
                
                // Показ уведомления
                showNotification('Заявка успешно отправлена!', 'success');
                
                // Очистка формы
                this.reset();
                
                // Возврат к исходному состоянию через 2 секунды
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.style.background = '';
                    submitBtn.disabled = false;
                }, 2000);
            }, 1500);
        });
    }
}

// Валидация формы запроса
function validateRequestForm(form) {
    const name = form.querySelector('#request-name').value.trim();
    const email = form.querySelector('#request-email').value.trim();
    const phone = form.querySelector('#request-phone').value.trim();
    const consent = form.querySelector('#request-consent').checked;
    
    let isValid = true;
    
    // Очистка предыдущих ошибок
    clearFormErrors(form);
    
    if (!name) {
        showFieldError(form.querySelector('#request-name'), 'Введите ваше имя');
        isValid = false;
    }
    
    if (!email || !isValidEmail(email)) {
        showFieldError(form.querySelector('#request-email'), 'Введите корректный email');
        isValid = false;
    }
    
    if (!phone) {
        showFieldError(form.querySelector('#request-phone'), 'Введите ваш телефон');
        isValid = false;
    }
    
    if (!consent) {
        showFieldError(form.querySelector('#request-consent'), 'Необходимо согласие на обработку данных');
        isValid = false;
    }
    
    return isValid;
}

// Показать ошибку поля
function showFieldError(field, message) {
    field.style.borderColor = '#dc2626';
    
    // Создание элемента ошибки
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.textContent = message;
    errorElement.style.color = '#dc2626';
    errorElement.style.fontSize = '12px';
    errorElement.style.marginTop = '4px';
    
    field.parentNode.appendChild(errorElement);
}

// Очистка ошибок формы
function clearFormErrors(form) {
    const errorElements = form.querySelectorAll('.field-error');
    errorElements.forEach(el => el.remove());
    
    const fields = form.querySelectorAll('.form-input, .form-textarea');
    fields.forEach(field => {
        field.style.borderColor = '#e2e8f0';
    });
}

// Валидация email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Дополнительные опции
function initProductOptions() {
    const optionItems = document.querySelectorAll('.option-item');
    
    optionItems.forEach(item => {
        item.addEventListener('click', function() {
            // Переключение активного состояния
            this.classList.toggle('option-item_active');
            
            // Анимация клика
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Обновление счетчика выбранных опций
            updateSelectedOptionsCount();
        });
    });
}

// Обновление счетчика выбранных опций
function updateSelectedOptionsCount() {
    const selectedOptions = document.querySelectorAll('.option-item_active');
    const count = selectedOptions.length;
    
    // Можно добавить индикатор количества выбранных опций
    console.log(`Выбрано опций: ${count}`);
}

// Подсказки для характеристик
function initProductHelp() {
    const helpButtons = document.querySelectorAll('.product-detail__help');
    
    helpButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const tooltip = createTooltip('Номинальная мощность - это мощность, которую генератор может выдавать непрерывно в течение длительного времени при стандартных условиях эксплуатации.');
            showTooltip(this, tooltip);
        });
    });
}

// Создание подсказки
function createTooltip(text) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = text;
    tooltip.style.cssText = `
        position: absolute;
        background: #0a1855;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        max-width: 200px;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    `;
    
    return tooltip;
}

// Показать подсказку
function showTooltip(element, tooltip) {
    // Удаление существующих подсказок
    const existingTooltips = document.querySelectorAll('.tooltip');
    existingTooltips.forEach(t => t.remove());
    
    // Добавление подсказки
    document.body.appendChild(tooltip);
    
    // Позиционирование
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + 'px';
    tooltip.style.top = (rect.top - tooltip.offsetHeight - 8) + 'px';
    
    // Автоматическое скрытие через 3 секунды
    setTimeout(() => {
        tooltip.remove();
    }, 3000);
    
    // Скрытие при клике вне подсказки
    document.addEventListener('click', function hideTooltip(e) {
        if (!tooltip.contains(e.target) && e.target !== element) {
            tooltip.remove();
            document.removeEventListener('click', hideTooltip);
        }
    });
}

// Запрос коммерческого предложения
function initQuoteRequest() {
    const quoteBtn = document.querySelector('.product-btn-quote');
    
    if (quoteBtn) {
        quoteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Прокрутка к форме запроса
            const requestForm = document.querySelector('.product-request');
            if (requestForm) {
                requestForm.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Подсветка формы
                requestForm.style.boxShadow = '0 0 0 3px rgba(10, 24, 85, 0.2)';
                setTimeout(() => {
                    requestForm.style.boxShadow = '';
                }, 2000);
            }
        });
    }
}

// Показ уведомлений
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification_${type}`;
    notification.textContent = message;
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#00c851' : '#0a1855'};
        color: white;
        padding: 16px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Анимация появления
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Автоматическое скрытие
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Плавная прокрутка для якорных ссылок
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Lazy loading для изображений
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// Инициализация lazy loading
initLazyLoading();
