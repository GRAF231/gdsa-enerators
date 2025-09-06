/**
 * Слайдер популярных товаров
 * Функциональность переключения слайдов с навигацией
 */

class PopularSlider {
    constructor(container) {
        this.container = container;
        this.track = container.querySelector('.home-popular__slider-track');
        this.items = container.querySelectorAll('.home-popular__item');
        this.prevBtn = container.querySelector('.home-popular__nav-btn--prev');
        this.nextBtn = container.querySelector('.home-popular__nav-btn--next');
        this.indicators = container.querySelectorAll('.home-popular__indicator');
        
        this.currentSlide = 0;
        this.slidesToShow = this.getSlidesToShow();
        this.totalSlides = this.items.length;
        // Если карточек меньше или равно количеству видимых, то не листаем
        if (this.totalSlides <= this.slidesToShow) {
            this.maxSlide = 0;
        } else {
            this.maxSlide = this.totalSlides - this.slidesToShow;
        }
        
        this.isAnimating = false;
        this.autoPlayInterval = null;
        this.autoPlayDelay = 5000; // 5 секунд
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.updateSlider();
        this.startAutoPlay();
        this.updateResponsive();
        
        // Обновление при изменении размера окна
        window.addEventListener('resize', this.debounce(() => {
            this.updateResponsive();
            // Принудительно обновляем позицию слайдера
            setTimeout(() => {
                this.updateSlider();
            }, 100);
        }, 250));
    }
    
    getSlidesToShow() {
        const width = window.innerWidth;
        if (width <= 576) return 1;
        if (width <= 992) return 2;
        return 3;
    }
    
    updateResponsive() {
        const newSlidesToShow = this.getSlidesToShow();
        if (newSlidesToShow !== this.slidesToShow) {
            this.slidesToShow = newSlidesToShow;
            // Если карточек меньше или равно количеству видимых, то не листаем
            if (this.totalSlides <= this.slidesToShow) {
                this.maxSlide = 0;
            } else {
                this.maxSlide = this.totalSlides - this.slidesToShow;
            }
            this.currentSlide = Math.min(this.currentSlide, this.maxSlide);
            this.updateSlider();
        }
    }
    
    setupEventListeners() {
        // Кнопки навигации
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => this.prevSlide());
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => this.nextSlide());
        }
        
        // Индикаторы
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => this.goToSlide(index));
        });
        
        // Клавиатурная навигация
        this.container.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                this.prevSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                this.nextSlide();
            }
        });
        
        // Пауза автопрокрутки при наведении
        this.container.addEventListener('mouseenter', () => this.stopAutoPlay());
        this.container.addEventListener('mouseleave', () => this.startAutoPlay());
        
        // Пауза при фокусе на кнопках
        [this.prevBtn, this.nextBtn, ...this.indicators].forEach(element => {
            if (element) {
                element.addEventListener('focus', () => this.stopAutoPlay());
                element.addEventListener('blur', () => this.startAutoPlay());
            }
        });
    }
    
    prevSlide() {
        if (this.isAnimating) return;
        
        this.currentSlide = Math.max(0, this.currentSlide - 1);
        this.updateSlider();
    }
    
    nextSlide() {
        if (this.isAnimating) return;
        
        this.currentSlide = Math.min(this.maxSlide, this.currentSlide + 1);
        this.updateSlider();
    }
    
    goToSlide(slideIndex) {
        if (this.isAnimating) return;
        
        this.currentSlide = Math.max(0, Math.min(slideIndex, this.maxSlide));
        this.updateSlider();
    }
    
    updateSlider() {
        if (this.isAnimating) return;
        
        this.isAnimating = true;
        
        // Получаем ширину контейнера и карточки
        const containerWidth = this.track.parentElement.offsetWidth;
        const gap = this.getGapSize();
        
        // Для мобильных устройств используем простой расчет
        if (this.slidesToShow === 1) {
            const translateX = -(this.currentSlide * containerWidth);
            this.track.style.transform = `translateX(${translateX}px)`;
        } else {
            // Для планшетов и десктопа
            const itemWidth = containerWidth / this.slidesToShow;
            const translateX = -(this.currentSlide * (itemWidth + gap));
            this.track.style.transform = `translateX(${translateX}px)`;
        }
        
        // Обновление состояния кнопок
        this.updateNavigationState();
        
        // Обновление индикаторов
        this.updateIndicators();
        
        // Сброс флага анимации
        setTimeout(() => {
            this.isAnimating = false;
        }, 600);
    }
    
    getGapSize() {
        const width = window.innerWidth;
        if (width <= 576) return 0; // Мобильные - без отступов
        if (width <= 1200) return 16; // Планшеты - 16px
        return 24; // Десктоп - 24px
    }
    
    updateNavigationState() {
        if (this.prevBtn) {
            this.prevBtn.disabled = this.currentSlide === 0;
        }
        
        if (this.nextBtn) {
            this.nextBtn.disabled = this.currentSlide >= this.maxSlide;
        }
    }
    
    updateIndicators() {
        this.indicators.forEach((indicator, index) => {
            // Показываем активный индикатор только если он соответствует текущему слайду
            // и не превышает максимальное количество слайдов
            const isActive = index === this.currentSlide && index <= this.maxSlide;
            indicator.classList.toggle('home-popular__indicator--active', isActive);
        });
    }
    
    startAutoPlay() {
        this.stopAutoPlay();
        this.autoPlayInterval = setInterval(() => {
            if (this.currentSlide >= this.maxSlide) {
                this.currentSlide = 0;
            } else {
                this.currentSlide++;
            }
            this.updateSlider();
        }, this.autoPlayDelay);
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    
    // Утилита для debounce
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Публичные методы для внешнего управления
    destroy() {
        this.stopAutoPlay();
        window.removeEventListener('resize', this.updateResponsive);
    }
    
    getCurrentSlide() {
        return this.currentSlide;
    }
    
    getTotalSlides() {
        return this.totalSlides;
    }
}

// Инициализация слайдера при загрузке DOM
document.addEventListener('DOMContentLoaded', function() {
    const popularSliderContainer = document.querySelector('.home-popular__slider');
    
    if (popularSliderContainer) {
        window.popularSlider = new PopularSlider(popularSliderContainer);
        
        // Добавляем поддержку touch для мобильных устройств
        let startX = 0;
        let startY = 0;
        let isDragging = false;
        
        popularSliderContainer.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            isDragging = true;
            window.popularSlider.stopAutoPlay();
        });
        
        popularSliderContainer.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
        });
        
        popularSliderContainer.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            // Проверяем, что это горизонтальный свайп
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    window.popularSlider.nextSlide();
                } else {
                    window.popularSlider.prevSlide();
                }
            }
            
            isDragging = false;
            window.popularSlider.startAutoPlay();
        });
    }
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PopularSlider;
}
