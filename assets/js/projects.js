/**
 * СТРАНИЦА ВЫПОЛНЕННЫХ ПРОЕКТОВ
 * Функциональность фильтрации, пагинации и интерактивности
 */

class ProjectsPage {
    constructor() {
        this.currentFilters = {
            power: null,
            industry: null,
            city: null,
            year: null
        };
        
        this.currentView = 'grid';
        this.currentPage = 1;
        this.perPage = 100;
        
        this.projects = [];
        this.filteredProjects = [];
        
        this.init();
    }

    init() {
        this.initElements();
        this.initFilters();
        this.initPagination();
        this.initViewToggle();
        this.initAnimations();
        this.bindEvents();
        
        console.log('✅ ProjectsPage initialized');
    }

    initElements() {
        this.filterTabs = document.querySelectorAll('.projects-filters__tab');
        this.filterPanels = document.querySelectorAll('.projects-filters__panel');
        this.filterOptions = document.querySelectorAll('.projects-filters__option');
        this.viewButtons = document.querySelectorAll('.projects-filters__view-btn');
        this.projectCards = document.querySelectorAll('.project-card');
        this.paginationButtons = document.querySelectorAll('.pagination__page');
        this.perPageButtons = document.querySelectorAll('.pagination__per-page-btn');
        this.prevButton = document.querySelector('.pagination__btn_prev');
        this.nextButton = document.querySelector('.pagination__btn_next');
        this.projectsGrid = document.querySelector('.projects-grid__items');
        this.paginationControls = document.querySelector('.pagination');
        this.resetButton = document.querySelector('.projects-filters__reset-btn');
    }

    initFilters() {
        // Инициализация активного фильтра
        const activeTab = document.querySelector('.projects-filters__tab_active');
        if (activeTab) {
            this.currentFilters.power = activeTab.dataset.filter;
        }

        // Инициализация фильтров с "Все"
        this.currentFilters = {
            power: 'all',
            industry: 'all',
            city: 'all',
            year: 'all'
        };

        // Активируем все кнопки "Все" изначально
        this.filterOptions.forEach(option => {
            if (option.dataset.value === 'all') {
                option.classList.add('active');
            }
        });

        // Сбор данных о проектах
        this.projects = Array.from(this.projectCards).map(card => ({
            element: card,
            power: card.dataset.power,
            industry: card.dataset.industry,
            city: card.dataset.city,
            year: card.dataset.year
        }));

        this.filteredProjects = [...this.projects];
    }

    initPagination() {
        this.totalProjects = this.filteredProjects.length;
        this.totalPages = Math.ceil(this.totalProjects / this.perPage);
        this.updatePaginationDisplay();
    }

    initViewToggle() {
        // Инициализация переключения вида
        const activeViewButton = document.querySelector('.projects-filters__view-btn_active');
        if (activeViewButton) {
            this.currentView = activeViewButton.dataset.view;
        }
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

        this.projectCards.forEach(card => {
            observer.observe(card);
        });
    }

    bindEvents() {
        // Фильтры по вкладкам
        this.filterTabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                this.switchFilterTab(e.target);
            });
        });

        // Опции фильтров
        this.filterOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                this.toggleFilterOption(e.target);
            });
        });

        // Переключение вида
        this.viewButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.switchView(e.target);
            });
        });

        // Пагинация будет обрабатываться динамически через createPageButton

        // Кнопки "Предыдущая" и "Следующая"
        if (this.prevButton) {
            this.prevButton.addEventListener('click', () => {
                this.goToPage(this.currentPage - 1);
            });
        }

        if (this.nextButton) {
            this.nextButton.addEventListener('click', () => {
                this.goToPage(this.currentPage + 1);
            });
        }

        // Кнопки "Выводить по"
        this.perPageButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                this.changePerPage(parseInt(e.target.dataset.perPage));
            });
        });

        // Кнопка сброса фильтров
        if (this.resetButton) {
            this.resetButton.addEventListener('click', () => {
                this.resetAllFilters();
            });
        }

        // Клики по карточкам проектов
        this.projectCards.forEach(card => {
            card.addEventListener('click', (e) => {
                this.openProjectModal(card);
            });
        });

        // Клавиатурная навигация
        document.addEventListener('keydown', (e) => {
            this.handleKeyboard(e);
        });
    }

    switchFilterTab(tab) {
        // Убираем активный класс с всех вкладок
        this.filterTabs.forEach(t => t.classList.remove('projects-filters__tab_active'));
        
        // Добавляем активный класс к выбранной вкладке
        tab.classList.add('projects-filters__tab_active');
        
        // Переключаем панели
        const filterType = tab.dataset.filter;
        this.filterPanels.forEach(panel => {
            panel.classList.remove('projects-filters__panel_active');
            if (panel.dataset.panel === filterType) {
                panel.classList.add('projects-filters__panel_active');
            }
        });

        // Уведомление
        console.log(`🔄 Switched to ${filterType} filter`);
        this.showNotification(`Переключен фильтр: ${tab.textContent.trim()}`);
    }

    toggleFilterOption(option) {
        const filterType = option.closest('.projects-filters__panel').dataset.panel;
        const filterValue = option.dataset.value;
        
        // Убираем активный класс с других опций этого фильтра
        const panel = option.closest('.projects-filters__panel');
        panel.querySelectorAll('.projects-filters__option').forEach(opt => {
            opt.classList.remove('active');
        });
        
        // Добавляем активный класс к выбранной опции
        option.classList.add('active');
        
        // Обновляем фильтр
        this.currentFilters[filterType] = filterValue;
        
        // Применяем фильтры
        this.applyFilters();
        
        // Уведомление
        const filterName = option.textContent.trim();
        console.log(`🔍 Filter applied: ${filterType} = ${filterValue}`);
        this.showNotification(`Применен фильтр: ${filterName}`);
    }

    applyFilters() {
        this.filteredProjects = this.projects.filter(project => {
            return Object.entries(this.currentFilters).every(([key, value]) => {
                // Если выбрано "Все" или значение пустое, показываем все проекты
                return !value || value === 'all' || project[key] === value;
            });
        });

        this.currentPage = 1;
        this.updateDisplay();
        
        console.log(`📊 Filtered projects: ${this.filteredProjects.length} of ${this.projects.length}`);
    }

    resetAllFilters() {
        // Сбрасываем все фильтры на "Все"
        this.currentFilters = {
            power: 'all',
            industry: 'all',
            city: 'all',
            year: 'all'
        };

        // Убираем активный класс со всех опций
        this.filterOptions.forEach(option => {
            option.classList.remove('active');
        });

        // Активируем кнопки "Все"
        this.filterOptions.forEach(option => {
            if (option.dataset.value === 'all') {
                option.classList.add('active');
            }
        });

        // Применяем фильтры
        this.applyFilters();

        // Уведомление
        console.log(`🔄 All filters reset to "All"`);
        this.showNotification(`Все фильтры сброшены`);
    }

    switchView(button) {
        // Убираем активный класс с всех кнопок
        this.viewButtons.forEach(btn => btn.classList.remove('projects-filters__view-btn_active'));
        
        // Добавляем активный класс к выбранной кнопке
        button.classList.add('projects-filters__view-btn_active');
        
        // Обновляем текущий вид
        this.currentView = button.dataset.view;
        
        // Применяем новый вид
        this.applyView();
        
        // Уведомление
        const viewName = this.currentView === 'grid' ? 'Сетка' : 'Список';
        console.log(`👁️ View switched to: ${viewName}`);
        this.showNotification(`Вид изменен на: ${viewName}`);
    }

    applyView() {
        if (this.currentView === 'list') {
            this.projectsGrid.classList.add('projects-grid__items_list');
        } else {
            this.projectsGrid.classList.remove('projects-grid__items_list');
        }
    }

    goToPage(page) {
        if (page < 1 || page > this.totalPages || page === this.currentPage) return;
        
        this.currentPage = page;
        this.updateDisplay();
        
        // Плавная прокрутка к началу списка проектов
        this.scrollToProjects();
        
        console.log(`📄 Navigated to page: ${page}`);
        this.showNotification(`Страница ${page} из ${this.totalPages}`);
        
        // Аналитика
        this.trackPaginationUsage(page);
    }

    scrollToProjects() {
        const projectsSection = document.querySelector('.projects-grid');
        if (projectsSection) {
            projectsSection.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }
    }

    changePerPage(perPage) {
        // Убираем активный класс с всех кнопок
        this.perPageButtons.forEach(btn => btn.classList.remove('pagination__per-page-btn_active'));
        
        // Добавляем активный класс к выбранной кнопке
        const activeButton = Array.from(this.perPageButtons).find(btn => 
            btn.dataset.perPage === perPage.toString()
        );
        if (activeButton) {
            activeButton.classList.add('pagination__per-page-btn_active');
        }
        
        // Обрабатываем опцию "Все"
        if (perPage === 'all') {
            this.perPage = this.filteredProjects.length;
        } else {
            this.perPage = parseInt(perPage);
        }
        
        this.currentPage = 1;
        this.updateDisplay();
        
        const displayValue = perPage === 'all' ? 'Все' : perPage;
        console.log(`📊 Items per page changed to: ${displayValue}`);
        this.showNotification(`Показывать по: ${displayValue} проектов`);
    }

    updateDisplay() {
        this.updatePagination();
        this.showProjects();
    }

    updatePagination() {
        this.totalPages = Math.ceil(this.filteredProjects.length / this.perPage);
        this.updatePaginationDisplay();
    }

    updatePaginationDisplay() {
        const pagesContainer = document.querySelector('.pagination__pages');
        if (!pagesContainer) return;

        // Очищаем контейнер страниц
        pagesContainer.innerHTML = '';

        // Генерируем кнопки страниц
        this.generatePaginationButtons(pagesContainer);

        // Обновляем состояние кнопок "Предыдущая" и "Следующая"
        if (this.prevButton) {
            this.prevButton.disabled = this.currentPage === 1;
        }
        if (this.nextButton) {
            this.nextButton.disabled = this.currentPage === this.totalPages;
        }

        // Показываем/скрываем кнопки пагинации в зависимости от количества страниц
        if (this.totalPages <= 1) {
            // Скрываем только навигацию по страницам, но оставляем информацию о количестве
            const navContainer = document.querySelector('.pagination__nav');
            if (navContainer) {
                const pagesContainer = navContainer.querySelector('.pagination__pages');
                const btnContainer = navContainer.querySelector('.pagination__btn');
                
                if (pagesContainer) pagesContainer.style.display = 'none';
                if (btnContainer) btnContainer.style.display = 'none';
            }
        } else {
            // Показываем все элементы пагинации
            const navContainer = document.querySelector('.pagination__nav');
            if (navContainer) {
                const pagesContainer = navContainer.querySelector('.pagination__pages');
                const btnContainer = navContainer.querySelector('.pagination__btn');
                
                if (pagesContainer) pagesContainer.style.display = 'flex';
                if (btnContainer) btnContainer.style.display = 'flex';
            }
        }

        // Добавляем информацию о текущих результатах
        this.updateResultsInfo();
    }

    generatePaginationButtons(container) {
        const maxVisiblePages = 7; // Максимальное количество видимых страниц
        let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(this.totalPages, startPage + maxVisiblePages - 1);

        // Корректируем начальную страницу, если мы близко к концу
        if (endPage - startPage < maxVisiblePages - 1) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }

        // Добавляем первую страницу и многоточие, если нужно
        if (startPage > 1) {
            this.createPageButton(container, 1);
            if (startPage > 2) {
                this.createDotsButton(container);
            }
        }

        // Добавляем видимые страницы
        for (let i = startPage; i <= endPage; i++) {
            this.createPageButton(container, i);
        }

        // Добавляем многоточие и последнюю страницу, если нужно
        if (endPage < this.totalPages) {
            if (endPage < this.totalPages - 1) {
                this.createDotsButton(container);
            }
            this.createPageButton(container, this.totalPages);
        }
    }

    createPageButton(container, pageNumber) {
        const button = document.createElement('button');
        button.className = 'pagination__page';
        button.textContent = pageNumber;
        button.dataset.page = pageNumber;

        if (pageNumber === this.currentPage) {
            button.classList.add('pagination__page_active');
        }

        button.addEventListener('click', () => {
            this.goToPage(pageNumber);
        });

        container.appendChild(button);
    }

    createDotsButton(container) {
        const dots = document.createElement('span');
        dots.className = 'pagination__dots';
        dots.textContent = '...';
        container.appendChild(dots);
    }

    updateResultsInfo() {
        // Удаляем существующую информацию о результатах, если есть
        let resultsInfo = document.querySelector('.projects-pagination__results');
        if (resultsInfo) {
            resultsInfo.remove();
        }

        // Создаем новую информацию о результатах
        const startItem = (this.currentPage - 1) * this.perPage + 1;
        const endItem = Math.min(this.currentPage * this.perPage, this.filteredProjects.length);
        const totalItems = this.filteredProjects.length;

        resultsInfo = document.createElement('div');
        resultsInfo.className = 'pagination__results';
        resultsInfo.innerHTML = `
            <span class="pagination__results-text">
                Показано ${startItem}-${endItem} из ${totalItems} проектов
            </span>
        `;

        // Вставляем информацию о результатах перед кнопками пагинации
        const navContainer = document.querySelector('.pagination__nav');
        if (navContainer) {
            navContainer.insertBefore(resultsInfo, navContainer.firstChild);
        }
    }

    showProjects() {
        const startIndex = (this.currentPage - 1) * this.perPage;
        const endIndex = startIndex + this.perPage;
        const projectsToShow = this.filteredProjects.slice(startIndex, endIndex);

        // Анимация исчезновения
        this.projectsGrid.classList.add('filtering');
        
        setTimeout(() => {
            // Скрываем все проекты
            this.projectCards.forEach(card => {
                card.style.display = 'none';
                card.classList.add('hidden');
                card.style.animationDelay = '0s';
            });

            // Показываем нужные проекты с анимацией
            projectsToShow.forEach((project, index) => {
                project.element.style.display = 'block';
                project.element.classList.remove('hidden');
                project.element.style.animationDelay = `${index * 0.05}s`;
                
                // Принудительно запускаем анимацию
                project.element.style.animation = 'none';
                project.element.offsetHeight; // Принудительный reflow
                project.element.style.animation = null;
            });

            // Убираем класс фильтрации
            this.projectsGrid.classList.remove('filtering');
        }, 150);
    }

    openProjectModal(projectCard) {
        // Получаем данные о проекте
        const title = projectCard.querySelector('.project-card__title').textContent;
        const client = projectCard.querySelector('.project-card__client').textContent;
        const power = projectCard.querySelector('.project-card__power').textContent;
        const image = projectCard.querySelector('.project-card__image img').src;

        // Создаем модальное окно
        const modal = this.createModal({
            title,
            client,
            power,
            image
        });

        // Показываем модальное окно
        document.body.appendChild(modal);
        modal.classList.add('modal_show');

        // Аналитика
        console.log(`🔍 Project modal opened: ${title}`);
        this.showNotification(`Открыт проект: ${title}`);
    }

    createModal(data) {
        const modal = document.createElement('div');
        modal.className = 'project-modal';
        modal.innerHTML = `
            <div class="project-modal__backdrop"></div>
            <div class="project-modal__content">
                <button class="project-modal__close" aria-label="Закрыть">
                    <i class="fa-solid fa-times" aria-hidden="true"></i>
                </button>
                <div class="project-modal__image">
                    <img src="${data.image}" alt="${data.title}" loading="lazy">
                    <div class="project-modal__power">${data.power}</div>
                </div>
                <div class="project-modal__info">
                    <h2 class="project-modal__title">${data.title}</h2>
                    <p class="project-modal__client"><strong>Заказчик:</strong> ${data.client}</p>
                    <div class="project-modal__details">
                        <h3>Детали проекта</h3>
                        <ul>
                            <li><strong>Мощность:</strong> ${data.power}</li>
                            <li><strong>Статус:</strong> Завершен</li>
                            <li><strong>Срок реализации:</strong> 6 месяцев</li>
                            <li><strong>Гарантия:</strong> 24 месяца</li>
                        </ul>
                    </div>
                    <div class="project-modal__actions">
                        <button class="project-modal__btn project-modal__btn_primary">
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            Связаться с нами
                        </button>
                        <button class="project-modal__btn project-modal__btn_secondary">
                            <i class="fa-solid fa-download" aria-hidden="true"></i>
                            Скачать презентацию
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Добавляем обработчики событий
        const closeBtn = modal.querySelector('.project-modal__close');
        const backdrop = modal.querySelector('.project-modal__backdrop');

        closeBtn.addEventListener('click', () => this.closeModal(modal));
        backdrop.addEventListener('click', () => this.closeModal(modal));

        return modal;
    }

    closeModal(modal) {
        modal.classList.remove('modal_show');
        setTimeout(() => {
            if (modal.parentNode) {
                modal.parentNode.removeChild(modal);
            }
        }, 300);
    }

    handleKeyboard(e) {
        switch (e.key) {
            case 'Escape':
                const openModal = document.querySelector('.project-modal_show');
                if (openModal) {
                    this.closeModal(openModal);
                }
                break;
            case 'ArrowLeft':
            case 'ArrowUp':
                if (this.currentPage > 1) {
                    this.goToPage(this.currentPage - 1);
                }
                break;
            case 'ArrowRight':
            case 'ArrowDown':
                if (this.currentPage < this.totalPages) {
                    this.goToPage(this.currentPage + 1);
                }
                break;
            case 'Home':
                if (this.currentPage > 1) {
                    this.goToPage(1);
                }
                break;
            case 'End':
                if (this.currentPage < this.totalPages) {
                    this.goToPage(this.totalPages);
                }
                break;
            case 'PageUp':
                const prevPage = Math.max(1, this.currentPage - 5);
                if (prevPage !== this.currentPage) {
                    this.goToPage(prevPage);
                }
                break;
            case 'PageDown':
                const nextPage = Math.min(this.totalPages, this.currentPage + 5);
                if (nextPage !== this.currentPage) {
                    this.goToPage(nextPage);
                }
                break;
        }
    }

    showNotification(message) {
        // Создаем уведомление
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        
        // Добавляем стили
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            background: 'linear-gradient(135deg, #0a1855 0%, #3b5fdb 100%)',
            color: '#ffffff',
            padding: '12px 20px',
            borderRadius: '8px',
            boxShadow: '0 8px 25px rgba(10, 24, 85, 0.3)',
            zIndex: '10000',
            fontSize: '14px',
            fontWeight: '500',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease'
        });
        
        document.body.appendChild(notification);
        
        // Анимация появления
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Удаляем через 3 секунды
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Методы для аналитики
    trackFilterUsage(filterType, filterValue) {
        console.log(`📊 Analytics: Filter used - ${filterType}: ${filterValue}`);
        // Здесь можно добавить отправку данных в аналитику
    }

    trackProjectView(projectTitle) {
        console.log(`📊 Analytics: Project viewed - ${projectTitle}`);
        // Здесь можно добавить отправку данных в аналитику
    }

    trackPaginationUsage(page) {
        console.log(`📊 Analytics: Page navigated - ${page}`);
        // Здесь можно добавить отправку данных в аналитику
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new ProjectsPage();
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ProjectsPage;
}
