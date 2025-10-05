/**
 * СТРАНИЦА НОВОСТЕЙ
 * Функциональность фильтрации и интерактивности
 */

class NewsPage {
    constructor() {
        this.currentFilter = 'all';
        this.news = [];
        this.filteredNews = [];
        
        this.init();
    }

    init() {
        this.initElements();
        this.initNews();
        this.initAnimations();
        this.bindEvents();
        
        console.log('✅ NewsPage initialized');
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
        
        // Применяем фильтр
        this.applyFilter();
        
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
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new NewsPage();
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NewsPage;
}
