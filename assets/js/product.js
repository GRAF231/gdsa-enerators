// ========================================
// СТРАНИЦА ТОВАРА - ИНТЕРАКТИВНОСТЬ
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    // Инициализация компонентов страницы товара
    initProductPage();
});

function initProductPage() {
    // Инициализация галереи товара
    initProductGallery();
    
    // Инициализация галереи двигателя в сайдбаре
    initEngineGallery();
    
    // Инициализация блока количества
    initQuantityControls();
    
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
// ГАЛЕРЕЯ ТОВАРА
// ========================================
function initProductGallery() {
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.product-thumbnail');
    
    if (!mainImage || thumbnails.length === 0) return;
    
    // Переключение изображений по клику на превью
    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', function() {
            const newImageUrl = this.dataset.image;
            
            if (!newImageUrl) return;
            
            // Убираем активный класс со всех превью
            thumbnails.forEach(t => t.classList.remove('product-thumbnail_active'));
            
            // Добавляем активный класс текущему превью
            this.classList.add('product-thumbnail_active');
            
            // Плавная смена изображения с fade эффектом
            mainImage.style.opacity = '0';
            
            setTimeout(() => {
                mainImage.src = newImageUrl;
                mainImage.dataset.fullImage = newImageUrl;
                mainImage.style.opacity = '1';
            }, 200);
        });
    });
    
    // Лайтбокс для полноэкранного просмотра
    const productImageMain = document.querySelector('.product-image-main');
    if (productImageMain) {
        productImageMain.style.cursor = 'zoom-in';
        
        productImageMain.addEventListener('click', function(e) {
            // Не открывать лайтбокс если кликнули на бейдж
            if (e.target.closest('.product-badge')) return;
            
            // Собираем все изображения для навигации
            const images = [];
            
            // Добавляем главное изображение
            images.push({
                url: mainImage.dataset.fullImage || mainImage.src,
                alt: mainImage.alt
            });
            
            // Добавляем изображения из галереи
            thumbnails.forEach(thumb => {
                const imageUrl = thumb.dataset.image;
                if (imageUrl && imageUrl !== images[0].url) {
                    images.push({
                        url: imageUrl,
                        alt: thumb.querySelector('img')?.alt || 'Изображение товара'
                    });
                }
            });
            
            // Находим текущий индекс
            const currentIndex = images.findIndex(img => img.url === (mainImage.dataset.fullImage || mainImage.src));
            
            openLightbox(images, currentIndex >= 0 ? currentIndex : 0);
        });
    }
}

// Открытие лайтбокса с навигацией
function openLightbox(images, startIndex = 0) {
    // Если передана строка вместо массива, конвертируем
    if (typeof images === 'string') {
        images = [{ url: images, alt: 'Изображение' }];
        startIndex = 0;
    }
    
    let currentIndex = startIndex;
    
    // Создание overlay лайтбокса
    const lightbox = document.createElement('div');
    lightbox.className = 'product-lightbox';
    
    // Создание изображения
    const img = document.createElement('img');
    img.src = images[currentIndex].url;
    img.alt = images[currentIndex].alt;
    
    // Создание кнопки закрытия
    const closeBtn = document.createElement('button');
    closeBtn.className = 'product-lightbox__close';
    closeBtn.innerHTML = '<i class="fa-solid fa-times"></i>';
    closeBtn.setAttribute('aria-label', 'Закрыть');
    
    // Кнопки навигации (только если больше одного изображения)
    let prevBtn, nextBtn, counter;
    
    if (images.length > 1) {
        // Кнопка "Назад"
        prevBtn = document.createElement('button');
        prevBtn.className = 'product-lightbox__nav product-lightbox__nav_prev';
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
        prevBtn.setAttribute('aria-label', 'Предыдущее изображение');
        
        // Кнопка "Вперед"
        nextBtn = document.createElement('button');
        nextBtn.className = 'product-lightbox__nav product-lightbox__nav_next';
        nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
        nextBtn.setAttribute('aria-label', 'Следующее изображение');
        
        // Счетчик изображений
        counter = document.createElement('div');
        counter.className = 'product-lightbox__counter';
        counter.textContent = `${currentIndex + 1} / ${images.length}`;
    }
    
    // Функция обновления изображения
    const updateImage = (newIndex) => {
        if (newIndex < 0 || newIndex >= images.length) return;
        
        currentIndex = newIndex;
        
        // Плавная смена изображения
        img.style.opacity = '0';
        
        setTimeout(() => {
            img.src = images[currentIndex].url;
            img.alt = images[currentIndex].alt;
            img.style.opacity = '1';
            
            // Обновляем счетчик
            if (counter) {
                counter.textContent = `${currentIndex + 1} / ${images.length}`;
            }
            
            // Обновляем состояние кнопок
            if (prevBtn) {
                prevBtn.disabled = currentIndex === 0;
            }
            if (nextBtn) {
                nextBtn.disabled = currentIndex === images.length - 1;
            }
        }, 200);
    };
    
    // Обработчики навигации
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            updateImage(currentIndex - 1);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            updateImage(currentIndex + 1);
        });
    }
    
    // Добавление элементов
    lightbox.appendChild(img);
    lightbox.appendChild(closeBtn);
    
    if (prevBtn && nextBtn) {
        lightbox.appendChild(prevBtn);
        lightbox.appendChild(nextBtn);
        lightbox.appendChild(counter);
        
        // Устанавливаем начальное состояние кнопок
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === images.length - 1;
    }
    
    document.body.appendChild(lightbox);
    
    // Закрытие лайтбокса
    const closeLightbox = () => {
        lightbox.classList.add('closing');
        setTimeout(() => {
            lightbox.remove();
            document.removeEventListener('keydown', keyHandler);
        }, 300);
    };
    
    // Закрытие по клику
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox || e.target === closeBtn || e.target.closest('.product-lightbox__close')) {
            closeLightbox();
        }
    });
    
    // Обработка клавиш клавиатуры
    const keyHandler = (e) => {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft' && currentIndex > 0) {
            updateImage(currentIndex - 1);
        } else if (e.key === 'ArrowRight' && currentIndex < images.length - 1) {
            updateImage(currentIndex + 1);
        }
    };
    document.addEventListener('keydown', keyHandler);
}

// ========================================
// ГАЛЕРЕЯ ДВИГАТЕЛЯ В САЙДБАРЕ
// ========================================
function initEngineGallery() {
    const engineItems = document.querySelectorAll('.engine-gallery__item');
    
    if (engineItems.length === 0) return;
    
    // Собираем все изображения двигателя
    const engineImages = Array.from(engineItems).map(item => ({
        url: item.dataset.image,
        alt: item.querySelector('img')?.alt || 'Фотография двигателя'
    }));
    
    engineItems.forEach((item, index) => {
        // Клик для открытия лайтбокса с навигацией
        item.addEventListener('click', function() {
            openLightbox(engineImages, index);
        });
        
        // Hover эффект для overlay
        item.addEventListener('mouseenter', function() {
            const overlay = this.querySelector('.engine-gallery__overlay');
            if (overlay) {
                overlay.classList.add('visible');
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const overlay = this.querySelector('.engine-gallery__overlay');
            if (overlay) {
                overlay.classList.remove('visible');
            }
        });
    });
}

// ========================================
// БЛОК КОЛИЧЕСТВА С КНОПКАМИ + И -
// ========================================
function initQuantityControls() {
    const quantityInputs = document.querySelectorAll('.product-actions .quantity input.qty');
    
    quantityInputs.forEach(input => {
        const quantityWrapper = input.closest('.quantity');
        if (!quantityWrapper) return;
        
        // Проверяем, не добавлены ли уже кнопки
        if (quantityWrapper.querySelector('.quantity-btn')) return;
        
        const min = parseInt(input.getAttribute('min')) || 1;
        const max = parseInt(input.getAttribute('max')) || 999;
        const step = parseInt(input.getAttribute('step')) || 1;
        
        // Создаем кнопку минус
        const minusBtn = document.createElement('button');
        minusBtn.type = 'button';
        minusBtn.className = 'quantity-btn quantity-minus';
        minusBtn.innerHTML = '<i class="fa-solid fa-minus"></i>';
        minusBtn.setAttribute('aria-label', 'Уменьшить количество');
        
        // Создаем кнопку плюс
        const plusBtn = document.createElement('button');
        plusBtn.type = 'button';
        plusBtn.className = 'quantity-btn quantity-plus';
        plusBtn.innerHTML = '<i class="fa-solid fa-plus"></i>';
        plusBtn.setAttribute('aria-label', 'Увеличить количество');
        
        // Вставляем кнопки
        quantityWrapper.insertBefore(minusBtn, input);
        quantityWrapper.appendChild(plusBtn);
        
        // Функция обновления состояния кнопок
        const updateButtons = () => {
            const currentValue = parseInt(input.value) || min;
            minusBtn.disabled = currentValue <= min;
            plusBtn.disabled = currentValue >= max;
        };
        
        // Обработчик кнопки минус
        minusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let currentValue = parseInt(input.value) || min;
            
            if (currentValue > min) {
                input.value = currentValue - step;
                input.dispatchEvent(new Event('change', { bubbles: true }));
                updateButtons();
            }
        });
        
        // Обработчик кнопки плюс
        plusBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let currentValue = parseInt(input.value) || min;
            
            if (currentValue < max) {
                input.value = currentValue + step;
                input.dispatchEvent(new Event('change', { bubbles: true }));
                updateButtons();
            }
        });
        
        // Обработчик изменения значения в поле
        input.addEventListener('change', function() {
            let value = parseInt(this.value) || 0;
            
            // Проверяем границы
            if (value < min) value = 0;
            if (value > max) value = max;
            this.value = value;
            updateButtons();
            
            // AJAX обновление количества в корзине (для страницы товара)
            const cartForm = this.closest('form.cart');
            if (cartForm) {
                // Получаем productId из data-атрибута формы, кнопки или ссылки
                let productId = cartForm.getAttribute('data-product-id');
                
                if (!productId) {
                    // Пробуем получить из кнопки
                    const submitBtn = cartForm.querySelector('[name="add-to-cart"]');
                    if (submitBtn) {
                        productId = submitBtn.value;
                    }
                }
                
                if (!productId) {
                    // Пробуем получить из ссылки
                    const cartLink = cartForm.querySelector('.product-cart-link');
                    if (cartLink) {
                        productId = cartLink.getAttribute('data-product-id');
                    }
                }
                
                if (productId) {
                    updateCartQuantity(productId, value);
                }
            }
        });
        
        // Обработчик ввода (для ограничения символов)
        input.addEventListener('input', function() {
            // Разрешаем только цифры
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Инициализация состояния кнопок
        updateButtons();
    });
}

// ========================================
// ДОБАВЛЕНИЕ В КОРЗИНУ (AJAX)
// ========================================

// Добавление в корзину
function initAddToCart() {
    const cartForm = document.querySelector('.product-actions form.cart');
    
    if (!cartForm) return;
    
    cartForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('.single_add_to_cart_button');
        const productId = this.querySelector('[name="add-to-cart"]').value;
        const quantity = this.querySelector('[name="quantity"]').value || 1;
        
        // Сохраняем оригинальное содержимое кнопки
        const originalHTML = submitBtn.innerHTML;
        
        // Анимация кнопки - начало загрузки
        submitBtn.style.transform = 'scale(0.95)';
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Добавляем...</span>';
        submitBtn.disabled = true;
        
        // Формируем данные для отправки
        const formData = new FormData();
        formData.append('action', 'woocommerce_add_to_cart');
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        
        // AJAX запрос
        fetch(wc_add_to_cart_params.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Ошибка
                submitBtn.style.transform = 'scale(1)';
                submitBtn.innerHTML = '<i class="fa-solid fa-times"></i><span>Ошибка</span>';
                submitBtn.style.background = 'linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)';
                
                showNotification(data.product_url || 'Не удалось добавить товар', 'error');
                
                // Возврат к исходному состоянию
                setTimeout(() => {
                    submitBtn.innerHTML = originalHTML;
                    submitBtn.style.background = '';
                    submitBtn.style.transform = '';
                    submitBtn.disabled = false;
                }, 2000);
            } else {
                // Успех!
                submitBtn.style.transform = 'scale(1)';
                submitBtn.innerHTML = '<i class="fa-solid fa-check"></i><span>Добавлено!</span>';
                submitBtn.style.background = 'linear-gradient(135deg, #00c851 0%, #00a041 100%)';
                
                // Обновление мини-корзины и счетчика через нашу функцию
                if (typeof window.dsaMiniCart !== 'undefined' && typeof window.dsaMiniCart.update === 'function') {
                    // Используем функцию обновления мини-корзины
                    window.dsaMiniCart.update();
                } else {
                    // Fallback: обновляем только счетчик
                    updateCartCounter(quantity);
                }
                
                // Синхронизируем каунтер на странице товара с корзиной
                syncQuantityWithCart(productId);
                
                // Показ уведомления
                showNotification('Товар добавлен в корзину!', 'success');
                
                // Триггер события для WooCommerce
                jQuery(document.body).trigger('added_to_cart', [data.fragments, data.cart_hash]);
                
                // НОВОЕ: Переключаем кнопку на ссылку "Перейти в корзину"
                setTimeout(() => {
                    switchToCartLink(productId);
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Ошибка добавления в корзину:', error);
            
            // Показываем ошибку
            submitBtn.style.transform = 'scale(1)';
            submitBtn.innerHTML = '<i class="fa-solid fa-times"></i><span>Ошибка</span>';
            submitBtn.style.background = 'linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)';
            
            showNotification('Произошла ошибка. Попробуйте еще раз.', 'error');
            
            // Возврат к исходному состоянию
            setTimeout(() => {
                submitBtn.innerHTML = originalHTML;
                submitBtn.style.background = '';
                submitBtn.style.transform = '';
                submitBtn.disabled = false;
            }, 2000);
        });
    });
}

// Обновление счетчика корзины
function updateCartCounter(quantity = 1) {
    const cartBadges = document.querySelectorAll('.header__badge');
    
    cartBadges.forEach(badge => {
        const currentCount = parseInt(badge.textContent) || 0;
        badge.textContent = currentCount + parseInt(quantity);
        
        // Анимация обновления
        badge.style.transform = 'scale(1.3)';
        badge.style.transition = 'transform 0.3s ease';
        
        setTimeout(() => {
            badge.style.transform = 'scale(1)';
        }, 300);
    });
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
    
    // Определяем цвет в зависимости от типа
    let bgColor = '#0a1855'; // info
    if (type === 'success') bgColor = '#00c851';
    if (type === 'error') bgColor = '#dc2626';
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${bgColor};
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

// ========================================
// AJAX ОБНОВЛЕНИЕ КОЛИЧЕСТВА В КОРЗИНЕ
// ========================================
/**
 * Обновление количества товара в корзине через AJAX
 * Вызывается при изменении значения в каунтере на странице товара
 */
let updateCartTimeout = null;

function updateCartQuantity(productId, quantity) {
    // Дебаунс для предотвращения множественных запросов
    if (updateCartTimeout) {
        clearTimeout(updateCartTimeout);
    }
    
    updateCartTimeout = setTimeout(() => {
        // Получаем параметры из глобального объекта mini-cart
        const ajaxUrl = typeof dsaMiniCartParams !== 'undefined' 
            ? dsaMiniCartParams.ajaxUrl 
            : (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.ajax_url : '/wp-admin/admin-ajax.php');
        
        const nonce = typeof dsaMiniCartParams !== 'undefined' 
            ? dsaMiniCartParams.nonce 
            : '';
        
        const formData = new FormData();
        formData.append('action', 'dsa_update_cart_quantity');
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        formData.append('nonce', nonce);
        
        // Показываем индикатор загрузки (опционально)
        const quantityInput = document.querySelector('.product-actions .quantity input.qty');
        if (quantityInput) {
            quantityInput.style.opacity = '0.6';
        }
        
        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (quantityInput) {
                quantityInput.style.opacity = '1';
            }
            
            if (data.success) {
                // Обновляем счетчик в header
                const badges = document.querySelectorAll('.header__badge');
                badges.forEach(badge => {
                    badge.textContent = data.data.count;
                    
                    // Анимация обновления
                    badge.style.transform = 'scale(1.3)';
                    setTimeout(() => {
                        badge.style.transform = 'scale(1)';
                    }, 200);
                });
                
                // Обновляем содержимое мини-корзины
                const miniCartContainer = document.querySelector('.mini-cart-dropdown-inner');
                if (miniCartContainer) {
                    miniCartContainer.innerHTML = data.data.html;
                    
                    // Пере-инициализируем обработчики удаления
                    if (typeof window.dsaMiniCart !== 'undefined' && window.dsaMiniCart.initRemoveButtons) {
                        // Если есть публичный метод для инициализации кнопок
                        const removeButtons = document.querySelectorAll('.mini-cart__item-remove');
                        removeButtons.forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                const cartItemKey = this.dataset.cartItemKey;
                                if (cartItemKey && typeof window.dsaMiniCart.removeFromCart === 'function') {
                                    window.dsaMiniCart.removeFromCart(cartItemKey);
                                }
                            });
                        });
                    }
                }
                
                // НОВОЕ: Переключаем кнопку/ссылку в зависимости от количества
                if (quantity === 0) {
                    // Товар удален - переключаем на кнопку
                    console.log('Товар удален из корзины');
                    switchToAddToCartButton(productId);
                    
                    // Сбрасываем каунтер на 1
                    if (quantityInput) {
                        quantityInput.value = 1;
                        // Обновляем состояние кнопок +/-
                        const minusBtn = quantityInput.parentElement.querySelector('.quantity-minus');
                        const plusBtn = quantityInput.parentElement.querySelector('.quantity-plus');
                        if (minusBtn) minusBtn.disabled = true;
                        if (plusBtn) plusBtn.disabled = false;
                    }
                } else {
                    // Товар есть в корзине - переключаем на ссылку (если еще не переключено)
                    const hasButton = document.querySelector('.product-actions .single_add_to_cart_button');
                    if (hasButton) {
                        switchToCartLink(productId);
                    }
                    console.log('Количество обновлено: ' + quantity);
                }
            } else {
                console.error('Ошибка обновления корзины:', data.data?.message);
            }
        })
        .catch(error => {
            console.error('Ошибка AJAX запроса:', error);
            if (quantityInput) {
                quantityInput.style.opacity = '1';
            }
        });
    }, 500); // Задержка 500ms
}

/**
 * Синхронизация каунтера на странице товара с количеством в корзине
 * Вызывается после добавления товара через кнопку "В корзину"
 */
function syncQuantityWithCart(productId) {
    const ajaxUrl = typeof dsaMiniCartParams !== 'undefined' 
        ? dsaMiniCartParams.ajaxUrl 
        : (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.ajax_url : '/wp-admin/admin-ajax.php');
    
    const formData = new FormData();
    formData.append('action', 'dsa_get_product_quantity');
    formData.append('product_id', productId);
    
    fetch(ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const quantity = data.quantity || 0;
        const quantityInput = document.querySelector('.product-actions .quantity input.qty');
        
        if (quantityInput && quantity > 0) {
            quantityInput.value = quantity;
            
            // Обновляем состояние кнопок +/-
            const min = parseInt(quantityInput.getAttribute('min')) || 1;
            const max = parseInt(quantityInput.getAttribute('max')) || 999;
            const minusBtn = quantityInput.parentElement.querySelector('.quantity-minus');
            const plusBtn = quantityInput.parentElement.querySelector('.quantity-plus');
            
            if (minusBtn) minusBtn.disabled = quantity <= min;
            if (plusBtn) plusBtn.disabled = quantity >= max;
        }
    })
    .catch(error => {
        console.error('Ошибка синхронизации количества:', error);
    });
}

// ========================================
// LAZY LOADING
// ========================================

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

// ========================================
// ПЕРЕКЛЮЧЕНИЕ КНОПКИ / ССЫЛКИ КОРЗИНЫ
// ========================================

/**
 * Переключение кнопки "Добавить в корзину" на ссылку "Перейти в корзину"
 * Вызывается после добавления товара в корзину
 * @param {number} productId - ID товара
 */
function switchToCartLink(productId) {
    const submitBtn = document.querySelector('.product-actions .single_add_to_cart_button');
    
    if (!submitBtn) return;
    
    // Получаем URL корзины
    const cartUrl = typeof wc_add_to_cart_params !== 'undefined' 
        ? wc_add_to_cart_params.wc_ajax_url.replace('%%endpoint%%', 'get_refreshed_fragments').replace('/wc-ajax/get_refreshed_fragments', '/cart/')
        : '/cart/';
    
    // Создаем новую ссылку
    const cartLink = document.createElement('a');
    cartLink.href = cartUrl;
    cartLink.className = 'btn btn_type_primary product-cart-link';
    cartLink.setAttribute('data-product-id', productId);
    cartLink.innerHTML = `
        <i class="fa-solid fa-shopping-cart"></i>
        <span>Перейти в корзину</span>
    `;
    
    // Плавное исчезновение кнопки
    submitBtn.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    submitBtn.style.opacity = '0';
    submitBtn.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
        // Заменяем кнопку на ссылку (в том же месте в форме)
        submitBtn.parentNode.replaceChild(cartLink, submitBtn);
        
        // Плавное появление ссылки
        cartLink.style.opacity = '0';
        cartLink.style.transform = 'scale(0.95)';
        cartLink.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            cartLink.style.opacity = '1';
            cartLink.style.transform = 'scale(1)';
        }, 50);
    }, 300);
}

/**
 * Переключение ссылки "Перейти в корзину" обратно на кнопку "Добавить в корзину"
 * Вызывается при удалении товара из корзины
 * @param {number} productId - ID товара
 */
function switchToAddToCartButton(productId) {
    const cartLink = document.querySelector('.product-actions .product-cart-link');
    
    if (!cartLink) return;
    
    // Получаем информацию о текущей странице товара
    const cartForm = document.querySelector('.product-actions form.cart');
    
    if (!cartForm) return;
    
    // Создаем новую кнопку
    const submitBtn = document.createElement('button');
    submitBtn.type = 'submit';
    submitBtn.name = 'add-to-cart';
    submitBtn.value = productId;
    submitBtn.className = 'single_add_to_cart_button btn btn_type_primary';
    submitBtn.setAttribute('data-product-id', productId);
    submitBtn.innerHTML = `
        <i class="fa-solid fa-cart-plus"></i>
        <span>Добавить в корзину</span>
    `;
    
    // Плавное исчезновение ссылки
    cartLink.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    cartLink.style.opacity = '0';
    cartLink.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
        // Заменяем ссылку на кнопку (в том же месте в форме)
        cartLink.parentNode.replaceChild(submitBtn, cartLink);
        
        // Плавное появление кнопки
        submitBtn.style.opacity = '0';
        submitBtn.style.transform = 'scale(0.95)';
        submitBtn.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        
        setTimeout(() => {
            submitBtn.style.opacity = '1';
            submitBtn.style.transform = 'scale(1)';
            
            // Пере-инициализируем обработчик формы
            initAddToCart();
        }, 50);
    }, 300);
}

/**
 * Глобальный обработчик событий удаления товара из корзины
 * Слушаем событие от mini-cart.js
 */
document.addEventListener('DOMContentLoaded', function() {
    // Подписываемся на события мини-корзины
    document.addEventListener('dsa-cart-item-removed', function(e) {
        const removedProductId = e.detail.productId;
        
        if (removedProductId) {
            // Проверяем, есть ли товар еще в корзине
            checkProductInCartAndSwitch(removedProductId);
        }
    });
});

/**
 * Проверка наличия товара в корзине и переключение кнопки/ссылки
 * @param {number} productId - ID товара
 */
function checkProductInCartAndSwitch(productId) {
    const ajaxUrl = typeof dsaMiniCartParams !== 'undefined' 
        ? dsaMiniCartParams.ajaxUrl 
        : (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.ajax_url : '/wp-admin/admin-ajax.php');
    
    const formData = new FormData();
    formData.append('action', 'dsa_get_product_quantity');
    formData.append('product_id', productId);
    
    fetch(ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const quantity = data.quantity || 0;
        
        if (quantity === 0) {
            // Товара нет в корзине - переключаем на кнопку
            switchToAddToCartButton(productId);
        } else {
            // Товар есть в корзине - оставляем ссылку
            // (ничего не делаем, ссылка уже там)
        }
    })
    .catch(error => {
        console.error('Ошибка проверки количества товара:', error);
    });
}

