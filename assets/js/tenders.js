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

            // Убрана функциональность модального окна при клике на строки таблицы
            // Строки таблицы больше не интерактивны
        });

        console.log('📊 Table interactions setup complete');
    }

    // Функция showContractDetails удалена - модальное окно больше не показывается

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
