/**
 * Главный слайдер - функциональность
 */

class HomeSlider {
    constructor() {
        this.currentSlide = 0;
        this.slides = [];
        this.indicators = [];
        
        this.init();
    }
    
    init() {
        this.cacheElements();
        this.bindEvents();
        this.updateSlideDisplay();
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
            indicator.addEventListener('click', () => this.goToSlide(index));
        });
        
        
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
    

    handleKeyboard(e) {
        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                this.prevSlide();
                break;
            case 'ArrowRight':
                e.preventDefault();
                this.nextSlide();
                break;
            case ' ':
                e.preventDefault();
                this.nextSlide();
                break;
        }
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
