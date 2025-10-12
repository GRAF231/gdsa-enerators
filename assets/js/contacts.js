/**
 * DSA Generators - Страница контактов
 * JavaScript функциональность для страницы контактов
 */

class ContactsPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupFormValidation();
        this.setupMapInteraction();
        this.setupAnimations();
        this.setupPhoneMask();
        this.setupAnalytics();
        
        console.log('✅ ContactsPage инициализирован');
    }

    /**
     * Настройка валидации формы
     */
    setupFormValidation() {
        const form = document.querySelector('.contacts-form__form');
        if (!form) return;

        const inputs = form.querySelectorAll('input, textarea');
        const submitBtn = form.querySelector('.contacts-form__submit');

        // Валидация в реальном времени
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });

        // Отправка формы
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleFormSubmit(form);
        });

        // Валидация при изменении
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                this.updateSubmitButton(form, submitBtn);
            });
        });
    }

    /**
     * Валидация отдельного поля
     */
    validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';

        // Удаляем предыдущие ошибки
        this.clearFieldError(field);

        // Проверка обязательных полей
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Это поле обязательно для заполнения';
        }

        // Специфичная валидация
        switch (fieldName) {
            case 'name':
                if (value && value.length < 2) {
                    isValid = false;
                    errorMessage = 'Имя должно содержать минимум 2 символа';
                }
                break;
            case 'phone':
                if (value && !this.isValidPhone(value)) {
                    isValid = false;
                    errorMessage = 'Введите корректный номер телефона';
                }
                break;
            case 'email':
                if (value && !this.isValidEmail(value)) {
                    isValid = false;
                    errorMessage = 'Введите корректный email адрес';
                }
                break;
        }

        if (!isValid) {
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    /**
     * Показать ошибку поля
     */
    showFieldError(field, message) {
        field.classList.add('contacts-form__input_error');
        
        const errorElement = document.createElement('div');
        errorElement.className = 'contacts-form__error';
        errorElement.textContent = message;
        
        field.parentNode.appendChild(errorElement);
    }

    /**
     * Очистить ошибку поля
     */
    clearFieldError(field) {
        field.classList.remove('contacts-form__input_error');
        
        const errorElement = field.parentNode.querySelector('.contacts-form__error');
        if (errorElement) {
            errorElement.remove();
        }
    }

    /**
     * Проверка валидности телефона
     */
    isValidPhone(phone) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
        return phoneRegex.test(phone);
    }

    /**
     * Проверка валидности email
     */
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Обновление состояния кнопки отправки
     */
    updateSubmitButton(form, submitBtn) {
        const requiredFields = form.querySelectorAll('input[required], textarea[required]');
        let allValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allValid = false;
            }
        });

        submitBtn.disabled = !allValid;
        submitBtn.style.opacity = allValid ? '1' : '0.6';
    }

    /**
     * Обработка отправки формы
     */
    handleFormSubmit(form) {
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Валидация всех полей
        const inputs = form.querySelectorAll('input, textarea');
        let isFormValid = true;

        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isFormValid = false;
            }
        });

        if (!isFormValid) {
            this.showNotification('Пожалуйста, исправьте ошибки в форме', 'error');
            return;
        }

        // Показываем состояние загрузки
        const submitBtn = form.querySelector('.contacts-form__submit');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Отправка...</span>';
        submitBtn.disabled = true;

        // Имитация отправки (в реальном проекте здесь будет AJAX запрос)
        setTimeout(() => {
            this.showNotification('Сообщение успешно отправлено! Мы свяжемся с вами в течение 15 минут.', 'success');
            form.reset();
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            // Аналитика
            this.trackEvent('form_submit', {
                form_type: 'contacts',
                fields_filled: Object.keys(data).length
            });
        }, 2000);
    }

    /**
     * Настройка взаимодействия с картой
     */
    setupMapInteraction() {
        const mapButton = document.querySelector('.contacts-map__button');
        if (!mapButton) return;

        mapButton.addEventListener('click', () => {
            // В реальном проекте здесь будет открытие Яндекс.Карт
            const address = 'Щербаковская ул., 3, Москва';
            const yandexMapsUrl = `https://yandex.ru/maps/?text=${encodeURIComponent(address)}`;
            
            window.open(yandexMapsUrl, '_blank');
            
            this.trackEvent('map_open', {
                address: address
            });
        });
    }

    /**
     * Настройка анимаций
     */
    setupAnimations() {
        // Анимация появления элементов при скролле
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    
                    // Анимация для карточек филиалов
                    if (entry.target.classList.contains('contacts-branch')) {
                        const delay = entry.target.dataset.aosDelay || '0';
                        setTimeout(() => {
                            entry.target.classList.add('contacts-branch_animated');
                        }, parseInt(delay));
                    }
                }
            });
        }, observerOptions);

        // Наблюдаем за элементами
        const animatedElements = document.querySelectorAll('.contacts-branch, .contacts-info, .contacts-office');
        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    /**
     * Настройка маски телефона
     */
    setupPhoneMask() {
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        
        phoneInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 0) {
                    if (value.startsWith('8')) {
                        value = value.replace(/^8/, '+7');
                    } else if (value.startsWith('7')) {
                        value = '+' + value;
                    } else if (!value.startsWith('+')) {
                        value = '+7' + value;
                    }
                    
                    // Форматирование
                    if (value.length > 1) {
                        value = value.replace(/(\+\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/, '$1 ($2) $3-$4-$5');
                    }
                }
                
                e.target.value = value;
            });
        });
    }

    /**
     * Показать уведомление
     */
    showNotification(message, type = 'info') {
        // Удаляем предыдущие уведомления
        const existingNotifications = document.querySelectorAll('.contacts-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className = `contacts-notification contacts-notification_${type}`;
        notification.innerHTML = `
            <div class="contacts-notification__content">
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
                <button class="contacts-notification__close" type="button">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        `;

        // Стили для уведомления
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#00c851' : type === 'error' ? '#ff4444' : '#00c2ff'};
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            max-width: 400px;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Анимация появления
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Закрытие по клику
        const closeBtn = notification.querySelector('.contacts-notification__close');
        closeBtn.addEventListener('click', () => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        });

        // Автоматическое закрытие
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    /**
     * Настройка аналитики
     */
    setupAnalytics() {
        // Отслеживание кликов по телефонам
        const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
        phoneLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.trackEvent('phone_click', {
                    phone: link.href.replace('tel:', ''),
                    location: link.closest('.contacts-branch')?.querySelector('.contacts-branch__city')?.textContent || 'main'
                });
            });
        });

        // Отслеживание кликов по email
        const emailLinks = document.querySelectorAll('a[href^="mailto:"]');
        emailLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.trackEvent('email_click', {
                    email: link.href.replace('mailto:', '')
                });
            });
        });

        // Отслеживание кликов по документам
        const documentLinks = document.querySelectorAll('.contacts-info__link');
        documentLinks.forEach(link => {
            link.addEventListener('click', () => {
                this.trackEvent('document_click', {
                    document: link.textContent.trim()
                });
            });
        });
    }

    /**
     * Отслеживание событий
     */
    trackEvent(eventName, eventData = {}) {
        console.log(`📊 Analytics: ${eventName}`, eventData);
        
        // В реальном проекте здесь будет отправка в Google Analytics, Яндекс.Метрику и т.д.
        if (typeof gtag !== 'undefined') {
            gtag('event', eventName, eventData);
        }
        
        if (typeof ym !== 'undefined') {
            ym(12345678, 'reachGoal', eventName, eventData);
        }
    }
}

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    new ContactsPage();
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ContactsPage;
}
