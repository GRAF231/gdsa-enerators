/**
 * СТРАНИЦА НОВОСТЕЙ
 * Функциональность фильтрации и интерактивности
 */

class NewsPage {
    constructor() {
        this.currentFilter = 'all';
        this.currentPage = 1;
        this.news = [];
        this.filteredNews = [];
        this.useAjax = typeof dsaNewsData !== 'undefined'; // Проверяем доступность AJAX
        
        this.init();
    }

    init() {
        this.initElements();
        this.initNews();
        this.initAnimations();
        this.bindEvents();
        this.bindPaginationEvents();
        
        console.log('✅ NewsPage initialized', this.useAjax ? '(AJAX mode)' : '(Static mode)');
    }

    initElements() {
        this.filterTabs = document.querySelectorAll('.news-filters__tab');
        this.newsCards = document.querySelectorAll('.news-card');
        this.newsGrid = document.querySelector('.news-grid__items');
    }

    initNews() {
        // Сбор данных о новостях
        this.news = Array.from(this.newsCards).map(card => ({
            element: card,
            category: card.dataset.category
        }));

        this.filteredNews = [...this.news];
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

        this.newsCards.forEach(card => {
            observer.observe(card);
        });
    }

    bindEvents() {
        // Фильтры по категориям
        this.filterTabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                this.switchFilter(e.target);
            });
        });

        // Клики по карточкам новостей
        this.newsCards.forEach(card => {
            card.addEventListener('click', (e) => {
                // Если клик не по ссылке, открываем новость
                if (!e.target.closest('.news-card__link')) {
                    const link = card.querySelector('.news-card__link');
                    if (link) {
                        link.click();
                    }
                }
            });
        });

        // Клавиатурная навигация
        document.addEventListener('keydown', (e) => {
            this.handleKeyboard(e);
        });
    }

    switchFilter(tab) {
        // Убираем активный класс с всех вкладок
        this.filterTabs.forEach(t => t.classList.remove('news-filters__tab_active'));
        
        // Добавляем активный класс к выбранной вкладке
        tab.classList.add('news-filters__tab_active');
        
        // Обновляем текущий фильтр
        this.currentFilter = tab.dataset.filter;
        
        // Сбрасываем страницу при смене фильтра
        this.currentPage = 1;
        
        // Применяем фильтр (AJAX или локально)
        if (this.useAjax) {
            this.loadNewsAjax(this.currentFilter, this.currentPage);
        } else {
            this.applyFilter();
        }
        
        // Уведомление
        const filterName = tab.textContent.trim();
        console.log(`🔍 Filter applied: ${this.currentFilter}`);
        this.showNotification(`Применен фильтр: ${filterName}`);
    }

    applyFilter() {
        this.filteredNews = this.news.filter(news => {
            // Если выбрано "Все" или значение пустое, показываем все новости
            return !this.currentFilter || this.currentFilter === 'all' || news.category === this.currentFilter;
        });

        this.updateDisplay();
        
        console.log(`📊 Filtered news: ${this.filteredNews.length} of ${this.news.length}`);
    }

    updateDisplay() {
        this.showNews();
    }

    showNews() {
        // Анимация исчезновения
        this.newsGrid.classList.add('filtering');
        
        setTimeout(() => {
            // Скрываем все новости
            this.newsCards.forEach(card => {
                card.style.display = 'none';
                card.classList.add('hidden');
                card.style.animationDelay = '0s';
            });

            // Показываем отфильтрованные новости с анимацией
            this.filteredNews.forEach((news, index) => {
                news.element.style.display = 'block';
                news.element.classList.remove('hidden');
                news.element.style.animationDelay = `${index * 0.05}s`;
                
                // Принудительно запускаем анимацию
                news.element.style.animation = 'none';
                news.element.offsetHeight; // Принудительный reflow
                news.element.style.animation = null;
            });

            // Убираем класс фильтрации
            this.newsGrid.classList.remove('filtering');
        }, 150);
    }

    handleKeyboard(e) {
        switch (e.key) {
            case '1':
                // Переключение на фильтр "Все"
                const allTab = document.querySelector('.news-filters__tab[data-filter="all"]');
                if (allTab) {
                    this.switchFilter(allTab);
                }
                break;
            case '2':
                // Переключение на фильтр "О компании"
                const companyTab = document.querySelector('.news-filters__tab[data-filter="company"]');
                if (companyTab) {
                    this.switchFilter(companyTab);
                }
                break;
            case '3':
                // Переключение на фильтр "Продукция"
                const productsTab = document.querySelector('.news-filters__tab[data-filter="products"]');
                if (productsTab) {
                    this.switchFilter(productsTab);
                }
                break;
            case '4':
                // Переключение на фильтр "Проекты"
                const projectsTab = document.querySelector('.news-filters__tab[data-filter="projects"]');
                if (projectsTab) {
                    this.switchFilter(projectsTab);
                }
                break;
            case '5':
                // Переключение на фильтр "События"
                const eventsTab = document.querySelector('.news-filters__tab[data-filter="events"]');
                if (eventsTab) {
                    this.switchFilter(eventsTab);
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
    trackFilterUsage(filterType) {
        console.log(`📊 Analytics: Filter used - ${filterType}`);
        // Здесь можно добавить отправку данных в аналитику
    }

    trackNewsView(newsTitle) {
        console.log(`📊 Analytics: News viewed - ${newsTitle}`);
        // Здесь можно добавить отправку данных в аналитику
    }
    
    // ============================================
    // AJAX ФУНКЦИОНАЛ
    // ============================================
    
    /**
     * Загрузка новостей через AJAX
     */
    loadNewsAjax(category = 'all', page = 1) {
        if (!this.useAjax) {
            console.warn('AJAX not available, falling back to static filtering');
            this.applyFilter();
            return;
        }
        
        // Получаем текущее значение per_page из Cookie
        const perPage = this.getPerPageFromCookie();
        
        // Показываем индикатор загрузки
        this.newsGrid.classList.add('loading');
        
        // Подготавливаем данные
        const data = new FormData();
        data.append('action', 'dsa_filter_news');
        data.append('nonce', dsaNewsData.nonce);
        data.append('category', category);
        data.append('paged', page);
        data.append('per_page', perPage);
        
        // Отправляем запрос
        fetch(dsaNewsData.ajaxUrl, {
            method: 'POST',
            body: data
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Обновляем контент
                this.newsGrid.innerHTML = result.data.html;
                
                // Обновляем пагинацию
                const paginationContainer = document.querySelector('.pagination');
                if (paginationContainer && result.data.pagination) {
                    paginationContainer.outerHTML = result.data.pagination;
                    this.bindPaginationEvents(); // Переподключаем события
                }
                
                // Обновляем URL без перезагрузки
                if (history.pushState) {
                    history.pushState({category, page}, '', result.data.url);
                }
                
                // Обновляем переменные
                this.currentPage = page;
                this.currentFilter = category;
                
                // Переинициализируем элементы
                this.newsCards = document.querySelectorAll('.news-card');
                this.initNews();
                this.initAnimations();
                
                // Плавная прокрутка к началу новостей
                const newsSection = document.querySelector('.news-grid');
                if (newsSection) {
                    newsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
                
                console.log(`✅ News loaded: ${result.data.total} items, page ${page}`);
            } else {
                console.error('❌ Error loading news:', result);
                this.showNotification('Ошибка загрузки новостей');
            }
        })
        .catch(error => {
            console.error('❌ AJAX error:', error);
            this.showNotification('Ошибка связи с сервером');
        })
        .finally(() => {
            this.newsGrid.classList.remove('loading');
        });
    }
    
    /**
     * Привязка событий пагинации
     */
    bindPaginationEvents() {
        // Кнопки пагинации (номера страниц)
        const pageLinks = document.querySelectorAll('.pagination__page, .pagination__btn');
        pageLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Получаем номер страницы из href или атрибута
                const href = link.getAttribute('href');
                if (!href || link.disabled) return;
                
                const urlParams = new URLSearchParams(href.split('?')[1] || '');
                const page = parseInt(urlParams.get('paged')) || 1;
                
                if (this.useAjax) {
                    this.loadNewsAjax(this.currentFilter, page);
                } else {
                    window.location.href = href;
                }
            });
        });
        
        // Кнопки "Выводить по"
        const perPageBtns = document.querySelectorAll('.pagination__per-page-btn');
        perPageBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const perPage = parseInt(btn.dataset.perPage);
                
                // Сохраняем в Cookie
                this.setPerPageCookie(perPage);
                
                // Обновляем активный класс
                perPageBtns.forEach(b => b.classList.remove('pagination__per-page-btn_active'));
                btn.classList.add('pagination__per-page-btn_active');
                
                // Перезагружаем с первой страницы
                if (this.useAjax) {
                    this.loadNewsAjax(this.currentFilter, 1);
                } else {
                    window.location.reload();
                }
            });
        });
    }
    
    /**
     * Получить значение per_page из Cookie
     */
    getPerPageFromCookie() {
        const match = document.cookie.match(/news_per_page=(\d+)/);
        return match ? parseInt(match[1]) : 12;
    }
    
    /**
     * Установить значение per_page в Cookie
     */
    setPerPageCookie(value) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000)); // 30 дней
        document.cookie = `news_per_page=${value}; expires=${expires.toUTCString()}; path=/`;
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new NewsPage();
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NewsPage;
}
