/**
 * DSA Generators - Модальное окно обратного звонка
 * Управление открытием/закрытием модалки
 * Работает с Contact Form 7
 */

(function() {
    'use strict';

    // Глобальные функции для использования в inline событиях
    window.openCallbackModal = openCallbackModal;
    window.closeCallbackModal = closeCallbackModal;
    window.openQuoteModal = openQuoteModal;
    window.closeQuoteModal = closeQuoteModal;

    // Инициализация при загрузке DOM
    document.addEventListener('DOMContentLoaded', function() {
        initCallbackModal();
        initQuoteModal();
        initPhoneMask();
    });

    /** 
     * Инициализация модального окна
     */
    function initCallbackModal() {
        const modal = document.getElementById('callbackModal');
        if (!modal) return;
        
        const closeBtn = modal.querySelector('.callback-modal__close');
        const overlay = modal.querySelector('.callback-modal__overlay');
        
        // Находим все кнопки "Заказать звонок", CTA кнопки и кнопки в сайдбаре
        const callbackButtons = document.querySelectorAll('.header__cta, .header__mobile-callback-btn, .cta__btn, .sidebar-card__btn');
        
        // Добавляем обработчик на каждую кнопку
        callbackButtons.forEach(button => {
            // Пропускаем кнопки с onclick="openCallbackModal()" - они уже имеют обработчик
            if (!button.hasAttribute('onclick')) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    openCallbackModal();
                });
            }
        });
        
        // Закрытие по клику на кнопку закрытия
        if (closeBtn) {
            closeBtn.addEventListener('click', closeCallbackModal);
        }
        
        // Закрытие по клику на оверлей
        if (overlay) {
            overlay.addEventListener('click', closeCallbackModal);
        }
        
        // Закрытие по клавише ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeCallbackModal();
            }
        });
    }

    /**
     * Открытие модального окна
     */
    function openCallbackModal() {
        const modal = document.getElementById('callbackModal');
        const body = document.body;
        
        if (modal) {
            // Сохраняем текущую позицию скролла
            const scrollY = window.scrollY;
            
            // Добавляем класс и стили
            body.classList.add('modal-open');
            body.style.top = `-${scrollY}px`;
            
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            
            // Фокус на первое поле формы
            setTimeout(() => {
                const firstInput = modal.querySelector('input[name="your-name"]');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 300);
        }
    }

    /**
     * Закрытие модального окна
     */
    function closeCallbackModal() {
        const modal = document.getElementById('callbackModal');
        const body = document.body;
        const form = modal ? modal.querySelector('.wpcf7-form') : null;
        const formContent = modal ? modal.querySelector('.callback-modal__content .wpcf7') : null;
        const successMessage = document.getElementById('callbackSuccess');
        
        if (modal) {
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            
            // Восстанавливаем скролл
            const scrollY = body.style.top;
            body.classList.remove('modal-open');
            body.style.top = '';
            
            if (scrollY) {
                window.scrollTo(0, parseInt(scrollY || '0') * -1);
            }
            
            // Сброс формы через небольшую задержку
            setTimeout(() => {
                if (form) {
                    form.reset();
                    // Очистка сообщений об ошибках CF7
                    const responseOutputs = form.querySelectorAll('.wpcf7-response-output');
                    responseOutputs.forEach(output => {
                        output.style.display = 'none';
                    });
                }
                if (formContent && successMessage) {
                    formContent.style.display = '';
                    successMessage.style.display = 'none';
                }
            }, 300);
        }
    }

    /**
     * Обработчик успешной отправки CF7
     */
    document.addEventListener('wpcf7mailsent', function(event) {
        // Определяем, в каком модальном окне находится форма
        // event.target может быть формой или её контейнером
        const formElement = event.target.closest ? event.target.closest('form') : event.target;
        const formContainer = formElement ? formElement.closest('.wpcf7') : null;
        
        const callbackModal = document.getElementById('callbackModal');
        const quoteModal = document.getElementById('quoteModal');
        
        let formContent = null;
        let successMessage = null;
        let modal = null;
        let eventLabel = '';
        let goalName = '';
        
        // Проверяем, находится ли форма в модальном окне "Заказать звонок"
        if (callbackModal && formContainer && callbackModal.contains(formContainer)) {
            modal = callbackModal;
            formContent = callbackModal.querySelector('.callback-modal__content .wpcf7');
            successMessage = document.getElementById('callbackSuccess');
            eventLabel = 'callback_modal';
            goalName = 'callback_request';
        }
        // Проверяем, находится ли форма в модальном окне "Запросить КП"
        else if (quoteModal && formContainer && quoteModal.contains(formContainer)) {
            modal = quoteModal;
            formContent = quoteModal.querySelector('.callback-modal__content .wpcf7');
            successMessage = document.getElementById('quoteSuccess');
            eventLabel = 'quote_modal';
            goalName = 'quote_request';
        }
        
        // Показываем сообщение об успехе, если форма в модальном окне
        if (formContent && successMessage && modal) {
            formContent.style.display = 'none';
            successMessage.style.display = 'block';
            
            // Google Analytics / Яндекс.Метрика
            if (typeof gtag !== 'undefined') {
                gtag('event', goalName, {
                    'event_category': 'form',
                    'event_label': eventLabel
                });
            }
            
            if (typeof ym !== 'undefined' && typeof yaCounterId !== 'undefined') {
                ym(yaCounterId, 'reachGoal', goalName);
            }
        }
    }, false);

    /**
     * Инициализация маски для телефона
     */
    function initPhoneMask() {
        const phoneInput = document.getElementById('callbackPhone');
        
        if (!phoneInput) return;
        
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            // Ограничиваем длину
            if (value.length > 11) {
                value = value.slice(0, 11);
            }
            
            // Форматирование
            let formattedValue = '';
            
            if (value.length > 0) {
                formattedValue = '+7';
                
                if (value.length > 1) {
                    formattedValue += ' (' + value.substring(1, 4);
                }
                
                if (value.length >= 5) {
                    formattedValue += ') ' + value.substring(4, 7);
                }
                
                if (value.length >= 8) {
                    formattedValue += '-' + value.substring(7, 9);
                }
                
                if (value.length >= 10) {
                    formattedValue += '-' + value.substring(9, 11);
                }
            }
            
            e.target.value = formattedValue;
        });
        
        // Автоматически добавляем +7 при фокусе
        phoneInput.addEventListener('focus', function(e) {
            if (!e.target.value) {
                e.target.value = '+7 ';
            }
        });
        
        // Не даем удалить +7
        phoneInput.addEventListener('keydown', function(e) {
            if (e.target.value === '+7 ' && (e.key === 'Backspace' || e.key === 'Delete')) {
                e.preventDefault();
            }
        });
    }

    /**
     * Открытие модального окна для запроса КП
     */
    function openQuoteModal() {
        const modal = document.getElementById('quoteModal');
        const body = document.body;
        
        if (modal) {
            // Сохраняем текущую позицию скролла
            const scrollY = window.scrollY;
            
            // Добавляем класс и стили
            body.classList.add('modal-open');
            body.style.top = `-${scrollY}px`;
            
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            
            // Фокус на первое поле формы
            setTimeout(() => {
                const firstInput = modal.querySelector('input[type="text"], input[type="email"], input[type="tel"]');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 300);
        }
    }

    /**
     * Закрытие модального окна для запроса КП
     */
    function closeQuoteModal() {
        const modal = document.getElementById('quoteModal');
        const body = document.body;
        const form = modal ? modal.querySelector('.wpcf7-form') : null;
        const formContent = modal ? modal.querySelector('.callback-modal__content .wpcf7') : null;
        const successMessage = document.getElementById('quoteSuccess');
        
        if (modal) {
            // Убираем классы
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            
            // Восстанавливаем позицию скролла
            const scrollY = body.style.top;
            body.classList.remove('modal-open');
            body.style.top = '';
            
            if (scrollY) {
                window.scrollTo(0, parseInt(scrollY || '0') * -1);
            }
            
            // Сброс формы через небольшую задержку
            setTimeout(() => {
                if (form) {
                    form.reset();
                    // Очистка сообщений об ошибках CF7
                    const responseOutputs = form.querySelectorAll('.wpcf7-response-output');
                    responseOutputs.forEach(output => {
                        output.style.display = 'none';
                    });
                }
                if (formContent && successMessage) {
                    formContent.style.display = '';
                    successMessage.style.display = 'none';
                }
            }, 300);
        }
    }

    /**
     * Инициализация модального окна для КП
     */
    function initQuoteModal() {
        const modal = document.getElementById('quoteModal');
        if (!modal) return;
        
        const closeBtn = modal.querySelector('.callback-modal__close');
        const overlay = modal.querySelector('.callback-modal__overlay');
        
        // Закрытие по клику на кнопку закрытия
        if (closeBtn && !closeBtn.hasAttribute('onclick')) {
            closeBtn.addEventListener('click', closeQuoteModal);
        }
        
        // Закрытие по клику на оверлей
        if (overlay) {
            overlay.addEventListener('click', closeQuoteModal);
        }
        
        // Закрытие по клавише ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeQuoteModal();
            }
        });
    }

})();
