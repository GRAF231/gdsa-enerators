/**
 * Production Page JavaScript
 * Интерактивность для страницы производства
 */

class ProductionPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupAnimations();
        this.setupInteractions();
        this.setupAnalytics();
        console.log('Production page initialized');
    }

    /**
     * Настройка анимаций появления элементов
     */
    setupAnimations() {
        // Intersection Observer для анимаций появления
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Наблюдаем за элементами для анимации
        const animateElements = document.querySelectorAll([
            '.production-intro__text',
            '.production-cta',
            '.production-list__item',
            '.workshop-section',
            '.advantage-item',
            '.management-contact',
            '.containers-specs__item',
            '.gallery-item',
            '.machine-card'
        ].join(','));

        animateElements.forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(el);
        });

        // CSS для анимации появления
        const style = document.createElement('style');
        style.textContent = `
            .animate-in {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Настройка интерактивности
     */
    setupInteractions() {
        // Обработка кликов по ссылкам в CTA блоке
        const ctaLinks = document.querySelectorAll('.production-cta__link');
        ctaLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = e.target.getAttribute('href');
                if (href.startsWith('mailto:')) {
                    this.trackEvent('contact', 'email_click', 'production_cta');
                } else if (href.startsWith('tel:')) {
                    this.trackEvent('contact', 'phone_click', 'production_cta');
                }
            });
        });

        // Hover эффекты для элементов списка
        const listItems = document.querySelectorAll('.production-list__item, .workshop-section__equipment-item, .containers-specs__item');
        listItems.forEach((item, index) => {
            item.addEventListener('mouseenter', () => {
                this.animateIcon(item, 'bounce');
            });
        });

        // Интерактивность для галереи
        this.setupGalleryInteractions();

        // Интерактивность для карточек машин
        this.setupMachineCardsInteractions();

        // Параллакс эффект удален
    }

    /**
     * Анимация иконки при наведении
     */
    animateIcon(element, animationType) {
        const icon = element.querySelector('.production-list__icon');
        if (icon) {
            icon.style.animation = 'none';
            icon.offsetHeight; // Trigger reflow
            icon.style.animation = `${animationType} 0.6s ease`;
        }
    }

    /**
     * Настройка аналитики
     */
    setupAnalytics() {
        // Отслеживание времени на странице
        const startTime = Date.now();
        
        window.addEventListener('beforeunload', () => {
            const timeSpent = Math.round((Date.now() - startTime) / 1000);
            this.trackEvent('engagement', 'time_on_page', timeSpent);
        });

        // Отслеживание скролла
        let maxScroll = 0;
        window.addEventListener('scroll', () => {
            const scrollPercent = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
            if (scrollPercent > maxScroll) {
                maxScroll = scrollPercent;
                if (maxScroll % 25 === 0) { // Отслеживаем каждые 25%
                    this.trackEvent('engagement', 'scroll_depth', maxScroll);
                }
            }
        });
    }

    /**
     * Отслеживание событий
     */
    trackEvent(category, action, label = null) {
        const event = {
            category,
            action,
            label,
            timestamp: new Date().toISOString(),
            url: window.location.href
        };
        
        console.log('Event tracked:', event);
        
        // Здесь можно добавить отправку в Google Analytics или другую систему аналитики
        // gtag('event', action, {
        //     event_category: category,
        //     event_label: label,
        //     value: 1
        // });
    }

    /**
     * Настройка интерактивности галереи
     */
    setupGalleryInteractions() {
        const galleryItems = document.querySelectorAll('.gallery-item');
        galleryItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                this.openImageModal(item.querySelector('.gallery-item__img').src, item.querySelector('.gallery-item__img').alt);
                this.trackEvent('gallery', 'image_click', `image_${index + 1}`);
            });
        });
    }

    /**
     * Настройка интерактивности карточек машин
     */
    setupMachineCardsInteractions() {
        const machineCards = document.querySelectorAll('.machine-card');
        machineCards.forEach((card, index) => {
            card.addEventListener('click', () => {
                const title = card.querySelector('.machine-card__title').textContent;
                this.showNotification(`Информация о машине: ${title}`, 'info');
                this.trackEvent('machines', 'card_click', title);
            });
        });
    }

    /**
     * Открыть модальное окно с изображением
     */
    openImageModal(imageSrc, imageAlt) {
        const modal = document.createElement('div');
        modal.className = 'image-modal';
        modal.innerHTML = `
            <div class="image-modal__overlay">
                <div class="image-modal__content">
                    <button class="image-modal__close" aria-label="Закрыть">
                        <i class="fa-solid fa-times"></i>
                    </button>
                    <img src="${imageSrc}" alt="${imageAlt}" class="image-modal__img">
                    <p class="image-modal__caption">${imageAlt}</p>
                </div>
            </div>
        `;

        // Стили для модального окна
        const modalStyles = `
            .image-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .image-modal__overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                backdrop-filter: blur(5px);
            }
            
            .image-modal__content {
                position: relative;
                max-width: 90%;
                max-height: 90%;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }
            
            .image-modal__close {
                position: absolute;
                top: 10px;
                right: 10px;
                background: rgba(0, 0, 0, 0.5);
                color: white;
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1001;
                transition: all 0.3s ease;
            }
            
            .image-modal__close:hover {
                background: rgba(0, 0, 0, 0.8);
                transform: scale(1.1);
            }
            
            .image-modal__img {
                max-width: 100%;
                max-height: 70vh;
                object-fit: contain;
                display: block;
            }
            
            .image-modal__caption {
                padding: 16px;
                margin: 0;
                background: white;
                color: var(--text-dark);
                font-size: var(--fs-sm);
                text-align: center;
            }
        `;

        // Добавляем стили
        if (!document.querySelector('#image-modal-styles')) {
            const style = document.createElement('style');
            style.id = 'image-modal-styles';
            style.textContent = modalStyles;
            document.head.appendChild(style);
        }

        document.body.appendChild(modal);

        // Закрытие модального окна
        const closeModal = () => {
            modal.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(modal);
            }, 300);
        };

        modal.querySelector('.image-modal__close').addEventListener('click', closeModal);
        modal.querySelector('.image-modal__overlay').addEventListener('click', closeModal);

        // Закрытие по ESC
        const handleEsc = (e) => {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', handleEsc);
            }
        };
        document.addEventListener('keydown', handleEsc);

        // Анимация появления
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 100);
    }

    /**
     * Показать уведомление
     */
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification--${type}`;
        notification.innerHTML = `
            <div class="notification__content">
                <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'info-circle'}" aria-hidden="true"></i>
                <span>${message}</span>
            </div>
        `;

        // Стили для уведомления
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#00c851' : '#00c2ff'};
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Анимация появления
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Автоматическое скрытие
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    new ProductionPage();
});

// Экспорт для возможного использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProductionPage;
}
