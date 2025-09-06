/**
 * Блок новостей - упрощенная функциональность
 * Включает анимации появления, hover эффекты и аналитику просмотров
 */

class HomeNews {
    constructor() {
        this.container = document.querySelector('.home-news');
        this.cards = document.querySelectorAll('.home-news__card');
        this.showAllBtn = document.querySelector('.home-news__show-all-btn');
        this.newsData = [];
        
        this.init();
    }

    init() {
        if (!this.container) {
            console.error('❌ HomeNews: Контейнер не найден');
            return;
        }
        
        console.log('📰 Найдено карточек:', this.cards.length);
        
        this.setupEventListeners();
        this.setupIntersectionObserver();
        this.loadNewsData();
        this.setupAnalytics();
        
        console.log('✅ HomeNews: Инициализация завершена');
    }

    setupEventListeners() {
        // Обработчик кнопки "Все новости"
        if (this.showAllBtn) {
            this.showAllBtn.addEventListener('click', () => {
                this.handleShowAllClick();
            });
        }

        // Обработчики для карточек новостей
        this.cards.forEach((card, index) => {
            card.addEventListener('click', () => {
                this.handleCardClick(index);
            });

            // Hover эффекты
            card.addEventListener('mouseenter', () => {
                this.handleCardHover(index, true);
            });

            card.addEventListener('mouseleave', () => {
                this.handleCardHover(index, false);
            });
        });
    }

    setupIntersectionObserver() {
        if (!('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    this.trackCardView(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        this.cards.forEach(card => {
            observer.observe(card);
        });
    }

    loadNewsData() {
        // Загружаем данные новостей (можно расширить для динамической загрузки)
        this.newsData = Array.from(this.cards).map((card, index) => ({
            id: index + 1,
            title: card.querySelector('.home-news__card-title')?.textContent || '',
            category: card.querySelector('.home-news__category')?.textContent || '',
            date: card.querySelector('.home-news__date')?.textContent || '',
            views: parseInt(card.querySelector('.home-news__views')?.textContent?.replace(/,/g, '') || '0'),
            image: card.querySelector('.home-news__image')?.src || '',
            link: card.querySelector('.home-news__read-more')?.href || '#'
        }));

        console.log('📰 Загружено новостей:', this.newsData.length);
    }

    setupAnalytics() {
        // Настройка аналитики просмотров
        this.trackSectionView();
    }

    handleShowAllClick() {
        console.log('📰 Клик по кнопке "Все новости"');
        
        // Аналитика
        this.trackButtonClick('show-all');
        
        // Здесь можно добавить логику перехода к странице всех новостей
        // window.location.href = '/news';
    }

    handleCardClick(cardIndex) {
        const card = this.cards[cardIndex];
        const newsItem = this.newsData[cardIndex];
        
        console.log('📰 Клик по карточке:', newsItem.title);
        
        // Аналитика
        this.trackCardClick(cardIndex, newsItem);
        
        // Здесь можно добавить логику перехода к статье
        // window.location.href = newsItem.link;
    }

    handleCardHover(cardIndex, isHover) {
        const card = this.cards[cardIndex];
        
        if (isHover) {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.15)';
        } else {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1), 0 4px 10px rgba(0, 0, 0, 0.05)';
        }
    }

    trackSectionView() {
        // Аналитика просмотра секции
        console.log('📊 Секция новостей просмотрена');
        
        // Здесь можно отправить данные в аналитическую систему
        // analytics.track('news_section_viewed');
    }

    trackCardView(card) {
        const cardIndex = Array.from(this.cards).indexOf(card);
        const newsItem = this.newsData[cardIndex];
        
        console.log('📊 Карточка просмотрена:', newsItem.title);
        
        // Здесь можно отправить данные в аналитическую систему
        // analytics.track('news_card_viewed', { card_id: newsItem.id });
    }

    trackCardClick(cardIndex, newsItem) {
        console.log('📊 Клик по карточке:', newsItem.title);
        
        // Здесь можно отправить данные в аналитическую систему
        // analytics.track('news_card_clicked', { 
        //     card_id: newsItem.id,
        //     title: newsItem.title,
        //     category: newsItem.category
        // });
    }

    trackButtonClick(buttonType) {
        console.log('📊 Клик по кнопке:', buttonType);
        
        // Здесь можно отправить данные в аналитическую систему
        // analytics.track('news_button_clicked', { button_type: buttonType });
    }
}

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    new HomeNews();
});