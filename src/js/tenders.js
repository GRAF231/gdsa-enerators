/**
 * Tenders Page JavaScript
 * Интерактивность для страницы тендеров
 */

class TendersPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupAnimations();
        this.setupScrollEffects();
        this.setupTableInteractions();
        this.setupStatistics();
        this.setupAnalytics();
        this.setupAccessibility();
        
        console.log('✅ TendersPage initialized');
    }

    /**
     * Настройка анимаций появления элементов
     */
    setupAnimations() {
        // Intersection Observer для анимаций
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    
                    // Анимация для статистики
                    if (entry.target.classList.contains('tenders-stats__item')) {
                        this.animateCounter(entry.target);
                    }
                }
            });
        }, observerOptions);

        // Наблюдение за элементами
        const animatedElements = document.querySelectorAll(`
            .tenders-intro,
            .tenders-section,
            .tenders-table,
            .tenders-stats__item,
            .tenders-cta
        `);

        animatedElements.forEach(el => {
            el.classList.add('fade-in-up');
            observer.observe(el);
        });

        console.log('🎬 Animations setup complete');
    }

    /**
     * Настройка эффектов скролла
     */
    setupScrollEffects() {
        let ticking = false;

        const updateScrollEffects = () => {
            const scrollY = window.scrollY;
            const windowHeight = window.innerHeight;
            
            // Параллакс эффект удален
            
            // Эффект появления для таблицы
            const table = document.querySelector('.tenders-table');
            if (table) {
                const tableRect = table.getBoundingClientRect();
                const isVisible = tableRect.top < windowHeight && tableRect.bottom > 0;
                
                if (isVisible) {
                    table.style.opacity = '1';
                    table.style.transform = 'translateY(0)';
                }
            }

            ticking = false;
        };

        const requestScrollUpdate = () => {
            if (!ticking) {
                requestAnimationFrame(updateScrollEffects);
                ticking = true;
            }
        };

        window.addEventListener('scroll', requestScrollUpdate, { passive: true });
        
        console.log('📜 Scroll effects setup complete');
    }

    /**
     * Настройка интерактивности таблицы
     */
    setupTableInteractions() {
        const tableRows = document.querySelectorAll('.tenders-table__row');
        
        tableRows.forEach((row, index) => {
            // Задержка анимации для каждой строки
            row.style.animationDelay = `${index * 0.1}s`;
            
            // Hover эффекты
            row.addEventListener('mouseenter', () => {
                row.style.transform = 'translateX(5px) scale(1.02)';
                row.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.15)';
            });
            
            row.addEventListener('mouseleave', () => {
                row.style.transform = 'translateX(0) scale(1)';
                row.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
            });

            // Клик для детальной информации
            row.addEventListener('click', () => {
                this.showContractDetails(row);
            });

            // Keyboard navigation
            row.setAttribute('tabindex', '0');
            row.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.showContractDetails(row);
                }
            });
        });

        console.log('📊 Table interactions setup complete');
    }

    /**
     * Показать детали контракта
     */
    showContractDetails(row) {
        const cells = row.querySelectorAll('.tenders-table__cell');
        const amount = cells[0]?.textContent || 'Не указана';
        const customer = cells[1]?.textContent || 'Не указан';
        const subject = cells[2]?.textContent || 'Не указан';
        const date = cells[3]?.textContent || 'Не указана';

        // Создание модального окна
        const modal = document.createElement('div');
        modal.className = 'contract-modal';
        modal.innerHTML = `
            <div class="contract-modal__overlay">
                <div class="contract-modal__content">
                    <div class="contract-modal__header">
                        <h3 class="contract-modal__title">Детали контракта</h3>
                        <button class="contract-modal__close" aria-label="Закрыть">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="contract-modal__body">
                        <div class="contract-detail">
                            <label class="contract-detail__label">Сумма:</label>
                            <span class="contract-detail__value contract-detail__value--amount">${amount}</span>
                        </div>
                        <div class="contract-detail">
                            <label class="contract-detail__label">Заказчик:</label>
                            <span class="contract-detail__value">${customer}</span>
                        </div>
                        <div class="contract-detail">
                            <label class="contract-detail__label">Предмет контракта:</label>
                            <span class="contract-detail__value">${subject}</span>
                        </div>
                        <div class="contract-detail">
                            <label class="contract-detail__label">Дата:</label>
                            <span class="contract-detail__value">${date}</span>
                        </div>
                    </div>
                    <div class="contract-modal__footer">
                        <button class="btn btn--primary contract-modal__action">
                            <i class="fas fa-phone"></i>
                            <span>Связаться с нами</span>
                        </button>
                        <button class="btn btn--secondary contract-modal__action">
                            <i class="fas fa-file-alt"></i>
                            <span>Запросить КП</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Добавление стилей для модального окна
        const style = document.createElement('style');
        style.textContent = `
            .contract-modal {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }
            
            .contract-modal__overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(10px);
                animation: fadeIn 0.3s ease;
            }
            
            .contract-modal__content {
                position: relative;
                background: #ffffff;
                border-radius: 20px;
                max-width: 600px;
                width: 100%;
                max-height: 80vh;
                overflow-y: auto;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                animation: slideInUp 0.3s ease;
            }
            
            .contract-modal__header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 25px 30px;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .contract-modal__title {
                font-size: 1.5rem;
                font-weight: 700;
                color: #1A1F7B;
                margin: 0;
            }
            
            .contract-modal__close {
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #718096;
                cursor: pointer;
                padding: 5px;
                border-radius: 50%;
                transition: all 0.3s ease;
            }
            
            .contract-modal__close:hover {
                background: #f1f5f9;
                color: #1A1F7B;
            }
            
            .contract-modal__body {
                padding: 30px;
            }
            
            .contract-detail {
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid #f1f5f9;
            }
            
            .contract-detail:last-child {
                border-bottom: none;
                margin-bottom: 0;
            }
            
            .contract-detail__label {
                display: block;
                font-weight: 600;
                color: #1A1F7B;
                margin-bottom: 5px;
                font-size: 0.9rem;
            }
            
            .contract-detail__value {
                font-size: 1rem;
                color: #3D3D3D;
                line-height: 1.5;
            }
            
            .contract-detail__value--amount {
                font-weight: 700;
                color: #1A1F7B;
                font-size: 1.1rem;
            }
            
            .contract-modal__footer {
                padding: 25px 30px;
                border-top: 1px solid #e2e8f0;
                display: flex;
                gap: 15px;
                justify-content: center;
            }
            
            .contract-modal__action {
                flex: 1;
                max-width: 200px;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @media (max-width: 768px) {
                .contract-modal__content {
                    margin: 10px;
                    max-height: 90vh;
                }
                
                .contract-modal__header,
                .contract-modal__body,
                .contract-modal__footer {
                    padding: 20px;
                }
                
                .contract-modal__footer {
                    flex-direction: column;
                }
                
                .contract-modal__action {
                    max-width: none;
                }
            }
        `;

        document.head.appendChild(style);
        document.body.appendChild(modal);

        // Обработчики событий
        const closeBtn = modal.querySelector('.contract-modal__close');
        const overlay = modal.querySelector('.contract-modal__overlay');
        const actionBtns = modal.querySelectorAll('.contract-modal__action');

        const closeModal = () => {
            modal.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(modal);
                document.head.removeChild(style);
            }, 300);
        };

        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal();
        });

        actionBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.textContent.trim();
                console.log(`📞 Contract action: ${action}`);
                
                if (action.includes('Связаться')) {
                    window.location.href = '../html/contacts.html';
                } else if (action.includes('Запросить')) {
                    // Здесь можно добавить логику для запроса КП
                    console.log('📄 Request for proposal initiated');
                }
                
                closeModal();
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        console.log('📋 Contract details modal opened');
    }

    /**
     * Анимация счетчиков статистики
     */
    animateCounter(element) {
        const numberEl = element.querySelector('.tenders-stats__number');
        if (!numberEl) return;

        const text = numberEl.textContent;
        const number = parseFloat(text.replace(/[^\d.,]/g, '').replace(',', '.'));
        const suffix = text.replace(/[\d.,]/g, '');

        if (isNaN(number)) return;

        let current = 0;
        const increment = number / 60; // 60 кадров анимации
        const duration = 2000; // 2 секунды
        const stepTime = duration / 60;

        const timer = setInterval(() => {
            current += increment;
            if (current >= number) {
                current = number;
                clearInterval(timer);
            }

            let displayValue;
            if (number >= 1000000000) {
                displayValue = (current / 1000000000).toFixed(1) + ' млрд';
            } else if (number >= 1000000) {
                displayValue = (current / 1000000).toFixed(0) + ' млн';
            } else if (number >= 1000) {
                displayValue = Math.floor(current / 1000) + ' тыс';
            } else {
                displayValue = Math.floor(current);
            }

            numberEl.textContent = displayValue + suffix;
        }, stepTime);

        console.log('🔢 Counter animation started for:', text);
    }

    /**
     * Настройка аналитики
     */
    setupAnalytics() {
        // Отслеживание просмотров таблиц
        const tables = document.querySelectorAll('.tenders-table');
        tables.forEach((table, index) => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        console.log(`📊 Table ${index + 1} viewed`);
                        // Здесь можно отправить данные в аналитику
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(table);
        });

        // Отслеживание кликов по CTA кнопкам
        const ctaButtons = document.querySelectorAll('.tenders-cta__actions .btn');
        ctaButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const action = btn.textContent.trim();
                console.log(`🎯 CTA clicked: ${action}`);
                // Здесь можно отправить данные в аналитику
            });
        });

        console.log('📈 Analytics setup complete');
    }

    /**
     * Настройка доступности
     */
    setupAccessibility() {
        // ARIA labels для таблицы
        const table = document.querySelector('.tenders-table');
        if (table) {
            table.setAttribute('role', 'table');
            table.setAttribute('aria-label', 'Таблица контрактов по 44-ФЗ и 223-ФЗ');
        }

        // ARIA labels для статистики
        const statsItems = document.querySelectorAll('.tenders-stats__item');
        statsItems.forEach((item, index) => {
            const number = item.querySelector('.tenders-stats__number');
            const label = item.querySelector('.tenders-stats__label');
            
            if (number && label) {
                item.setAttribute('aria-label', `${number.textContent} ${label.textContent}`);
            }
        });

        // Keyboard navigation для статистики
        statsItems.forEach(item => {
            item.setAttribute('tabindex', '0');
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    item.click();
                }
            });
        });

        console.log('♿ Accessibility setup complete');
    }
}

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    new TendersPage();
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TendersPage;
}
