/**
 * КАТАЛОГ ТОВАРОВ - ДИЗЕЛЬНЫЕ ЭЛЕКТРОСТАНЦИИ
 * Функциональность фильтрации, сортировки и пагинации
 */

class CatalogManager {
    constructor() {
        this.filters = {
            power: '',
            engine: '',
            manufacturer: '',
            country: '',
            nominalPower: ''
        };
        this.sortBy = 'default';
        this.currentPage = 1;
        this.itemsPerPage = 9;
        this.totalItems = 156;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.updatePagination();
        this.updateFilterCount();
    }

    bindEvents() {
        // Переключение панели фильтров
        const toggleBtn = document.querySelector('.catalog-filters__toggle-btn');
        const filterPanel = document.querySelector('.catalog-filters__panel');
        
        if (toggleBtn && filterPanel) {
            toggleBtn.addEventListener('click', () => {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                filterPanel.setAttribute('aria-expanded', !isExpanded);
                
                if (!isExpanded) {
                    filterPanel.style.display = 'block';
                } else {
                    filterPanel.style.display = 'none';
                }
            });
        }

        // Сортировка
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.sortBy = e.target.value;
                this.applyFilters();
            });
        }

        // Фильтры
        const filterSelects = document.querySelectorAll('.catalog-filters__select:not(#sort-select)');
        filterSelects.forEach(select => {
            select.addEventListener('change', (e) => {
                const filterName = e.target.id.replace('-filter', '');
                this.filters[filterName] = e.target.value;
                this.applyFilters();
            });
        });

        // Кнопки управления фильтрами
        const resetBtn = document.querySelector('.catalog-filters__reset-btn');
        const applyBtn = document.querySelector('.catalog-filters__apply-btn');
        
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                this.resetFilters();
            });
        }

        if (applyBtn) {
            applyBtn.addEventListener('click', () => {
                this.applyFilters();
            });
        }

        // Пагинация
        const paginationBtns = document.querySelectorAll('.catalog-pagination__page, .catalog-pagination__btn');
        paginationBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(btn.textContent);
                if (!isNaN(page)) {
                    this.goToPage(page);
                } else if (btn.classList.contains('catalog-pagination__btn_next')) {
                    this.goToPage(this.currentPage + 1);
                } else if (btn.classList.contains('catalog-pagination__btn_prev')) {
                    this.goToPage(this.currentPage - 1);
                }
            });
        });
    }

    applyFilters() {
        console.log('Применение фильтров:', this.filters);
        console.log('Сортировка:', this.sortBy);
        
        // Здесь будет логика фильтрации товаров
        // Пока что просто обновляем счетчик
        this.updateFilterCount();
        this.updatePagination();
        
        // Показываем уведомление
        this.showNotification('Фильтры применены');
    }

    resetFilters() {
        // Сбрасываем все фильтры
        Object.keys(this.filters).forEach(key => {
            this.filters[key] = '';
        });
        this.sortBy = 'default';
        this.currentPage = 1;

        // Сбрасываем значения в форме
        const filterSelects = document.querySelectorAll('.catalog-filters__select');
        filterSelects.forEach(select => {
            select.value = '';
        });

        // Скрываем панель фильтров
        const toggleBtn = document.querySelector('.catalog-filters__toggle-btn');
        const filterPanel = document.querySelector('.catalog-filters__panel');
        if (toggleBtn && filterPanel) {
            toggleBtn.setAttribute('aria-expanded', 'false');
            filterPanel.setAttribute('aria-expanded', 'false');
            filterPanel.style.display = 'none';
        }

        this.applyFilters();
        this.showNotification('Фильтры сброшены');
    }

    goToPage(page) {
        if (page < 1 || page > this.getTotalPages()) return;
        
        this.currentPage = page;
        this.updatePagination();
        
        // Прокручиваем к началу каталога
        const catalogSection = document.querySelector('.catalog-group');
        if (catalogSection) {
            catalogSection.scrollIntoView({ behavior: 'smooth' });
        }
        
        console.log('Переход на страницу:', page);
    }

    getTotalPages() {
        return Math.ceil(this.totalItems / this.itemsPerPage);
    }

    updatePagination() {
        const totalPages = this.getTotalPages();
        const startItem = (this.currentPage - 1) * this.itemsPerPage + 1;
        const endItem = Math.min(this.currentPage * this.itemsPerPage, this.totalItems);
        
        // Обновляем информацию о товарах
        const paginationText = document.querySelector('.catalog-pagination__text');
        if (paginationText) {
            paginationText.textContent = `Показано ${startItem}-${endItem} из ${this.totalItems} товаров`;
        }

        // Обновляем кнопки пагинации
        const prevBtn = document.querySelector('.catalog-pagination__btn_prev');
        const nextBtn = document.querySelector('.catalog-pagination__btn_next');
        
        if (prevBtn) {
            prevBtn.disabled = this.currentPage === 1;
        }
        
        if (nextBtn) {
            nextBtn.disabled = this.currentPage === totalPages;
        }

        // Обновляем активную страницу
        const pageBtns = document.querySelectorAll('.catalog-pagination__page');
        pageBtns.forEach(btn => {
            btn.classList.remove('catalog-pagination__page_active');
            if (parseInt(btn.textContent) === this.currentPage) {
                btn.classList.add('catalog-pagination__page_active');
            }
        });
    }

    updateFilterCount() {
        const activeFilters = Object.values(this.filters).filter(value => value !== '').length;
        const toggleBtn = document.querySelector('.catalog-filters__toggle-btn');
        
        if (toggleBtn && activeFilters > 0) {
            const existingBadge = toggleBtn.querySelector('.catalog-filters__badge');
            if (existingBadge) {
                existingBadge.textContent = activeFilters;
            } else {
                const badge = document.createElement('span');
                badge.className = 'catalog-filters__badge';
                badge.textContent = activeFilters;
                toggleBtn.appendChild(badge);
            }
        } else if (toggleBtn) {
            const existingBadge = toggleBtn.querySelector('.catalog-filters__badge');
            if (existingBadge) {
                existingBadge.remove();
            }
        }
    }

    showNotification(message) {
        // Создаем уведомление
        const notification = document.createElement('div');
        notification.className = 'catalog-notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #0a1855;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-20px);
            transition: all 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Анимация появления
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 100);
        
        // Удаляем через 3 секунды
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    // Проверяем, что мы на странице каталога
    if (document.querySelector('.catalog-filters')) {
        new CatalogManager();
        console.log('Каталог инициализирован');
    }
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CatalogManager;
}
