/**
 * СТРАНИЦА ПРОЕКТИРОВАНИЯ И EPC
 * Интерактивность и анимации
 */

class DesignEPCPage {
    constructor() {
        this.init();
    }

    init() {
        this.initAnimations();
        this.bindEvents();
        
        console.log('✅ DesignEPCPage initialized');
    }

    initAnimations() {
        // Инициализация анимаций появления
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        // Наблюдаем за элементами с анимациями
        const animatedElements = document.querySelectorAll('.license-card, .service-card, .process-step, .service-item, .option-item');
        animatedElements.forEach(element => {
            observer.observe(element);
        });
    }

    bindEvents() {
        // Обработка формы
        const form = document.querySelector('.contact-form__form');
        if (form) {
            form.addEventListener('submit', (e) => {
                this.handleFormSubmit(e);
            });
        }
    } 

    handleFormSubmit(e) {
        e.preventDefault();
        
        // Получаем данные формы
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        
        // Валидация
        if (!this.validateForm(data)) {
            return;
        }

        // Показываем состояние загрузки
        const submitBtn = e.target.querySelector('.contact-form__submit');
        this.setLoadingState(submitBtn, true);

        // Имитация отправки
        setTimeout(() => {
            this.setLoadingState(submitBtn, false);
            this.showSuccessMessage();
            e.target.reset();
        }, 2000);

        console.log('📧 Form submitted:', data);
    }

    validateForm(data) {
        const requiredFields = ['epc-name', 'epc-email', 'epc-phone'];
        let isValid = true;

        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!data[fieldName] || data[fieldName].trim() === '') {
                this.showFieldError(field, 'Это поле обязательно для заполнения');
                isValid = false;
            } else {
                this.clearFieldError(field);
            }
        });

        // Проверка email
        const emailField = document.getElementById('epc-email');
        if (data['epc-email'] && !this.isValidEmail(data['epc-email'])) {
            this.showFieldError(emailField, 'Введите корректный email адрес');
            isValid = false;
        }

        // Проверка согласия
        const consentField = document.getElementById('epc-consent');
        if (!data['epc-consent']) {
            this.showFieldError(consentField, 'Необходимо согласие на обработку данных');
            isValid = false;
        }

        return isValid;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    showFieldError(field, message) {
        const formGroup = field.closest('.form-group');
        formGroup.classList.add('error');
        
        let errorElement = formGroup.querySelector('.form-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'form-error';
            formGroup.appendChild(errorElement);
        }
        errorElement.textContent = message;
    }

    clearFieldError(field) {
        const formGroup = field.closest('.form-group');
        formGroup.classList.remove('error');
        
        const errorElement = formGroup.querySelector('.form-error');
        if (errorElement) {
            errorElement.remove();
        }
    }

    setLoadingState(button, isLoading) {
        if (isLoading) {
            button.classList.add('loading');
            button.disabled = true;
        } else {
            button.classList.remove('loading');
            button.disabled = false;
        }
    }

    showSuccessMessage() {
        this.showNotification('Заявка успешно отправлена! Наш менеджер свяжется с вами в ближайшее время.', 'success');
    }

    showNotification(message, type = 'info') {
        // Создаем уведомление
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        
        // Добавляем стили в зависимости от типа
        const styles = {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '12px 20px',
            borderRadius: '8px',
            boxShadow: '0 8px 25px rgba(0, 0, 0, 0.3)',
            zIndex: '10000',
            fontSize: '14px',
            fontWeight: '500',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease'
        };

        if (type === 'success') {
            styles.background = 'linear-gradient(135deg, #38a169 0%, #2f855a 100%)';
            styles.color = '#ffffff';
        } else {
            styles.background = 'linear-gradient(135deg, #0a1855 0%, #3b5fdb 100%)';
            styles.color = '#ffffff';
        }
        
        Object.assign(notification.style, styles);
        
        document.body.appendChild(notification);
        
        // Анимация появления
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Удаляем через 4 секунды
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new DesignEPCPage();
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = DesignEPCPage;
}
