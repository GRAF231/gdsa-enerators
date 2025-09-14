/**
 * Главный слайдер - функциональность
 */

class HomeSlider {
    constructor() {
        this.currentSlide = 0;
        this.slides = [];
        this.indicators = [];
        this.autoPlayInterval = null;
        this.isAutoPlaying = true;
        this.autoPlayDelay = 5000; // 5 секунд
        
        this.init();
    }
    
    init() {
        this.cacheElements();
        this.bindEvents();
        this.updateSlideDisplay();
        this.startAutoPlay();
    }
    
    cacheElements() {
        // Слайды
        this.slides = document.querySelectorAll('.home-slider__slide');
        
        // Индикаторы
        this.indicators = document.querySelectorAll('.home-slider__indicator');
        
    }
    
    bindEvents() {
        // Навигация индикаторами
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.stopAutoPlay();
                this.goToSlide(index);
                this.startAutoPlay();
            });
        });
        
        // Пауза автопрокрутки при наведении
        const sliderContainer = document.querySelector('.home-slider');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', () => this.stopAutoPlay());
            sliderContainer.addEventListener('mouseleave', () => this.startAutoPlay());
        }
        
        // Клавиатурная навигация
        document.addEventListener('keydown', (e) => this.handleKeyboard(e));
    }
    
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        this.updateSlideDisplay();
    }
    
    prevSlide() {
        this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1;
        this.updateSlideDisplay();
    }
    
    goToSlide(index) {
        this.currentSlide = index;
        this.updateSlideDisplay();
    }
    
    updateSlideDisplay() {
        // Плавное переключение слайдов
        this.slides.forEach((slide, index) => {
            if (index === this.currentSlide) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });
        
        // Обновляем индикаторы
        this.indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === this.currentSlide);
        });
    }
    
    startAutoPlay() {
        if (this.isAutoPlaying && this.slides.length > 1) {
            this.stopAutoPlay(); // Очищаем предыдущий интервал
            this.autoPlayInterval = setInterval(() => {
                this.nextSlide();
            }, this.autoPlayDelay);
        }
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    

    handleKeyboard(e) {
        // Проверяем, что фокус находится на слайдере
        const sliderContainer = document.querySelector('.home-slider');
        if (!sliderContainer || !sliderContainer.contains(document.activeElement)) {
            return;
        }
        
        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                this.stopAutoPlay();
                this.prevSlide();
                this.startAutoPlay();
                break;
            case 'ArrowRight':
                e.preventDefault();
                this.stopAutoPlay();
                this.nextSlide();
                this.startAutoPlay();
                break;
            case ' ':
                e.preventDefault();
                this.stopAutoPlay();
                this.nextSlide();
                this.startAutoPlay();
                break;
        }
    }
    
    // Очистка ресурсов при уничтожении слайдера
    destroy() {
        this.stopAutoPlay();
        // Удаляем обработчики событий
        this.indicators.forEach((indicator, index) => {
            indicator.removeEventListener('click', () => this.goToSlide(index));
        });
        
        const sliderContainer = document.querySelector('.home-slider');
        if (sliderContainer) {
            sliderContainer.removeEventListener('mouseenter', () => this.stopAutoPlay());
            sliderContainer.removeEventListener('mouseleave', () => this.startAutoPlay());
        }
        
        document.removeEventListener('keydown', (e) => this.handleKeyboard(e));
    }
}

// Инициализация слайдера при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    new HomeSlider();
});

// Экспорт для возможного использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = HomeSlider;
}
