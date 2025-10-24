/* DSA Generators - JavaScript для страницы "О компании" */

class AboutPage {
    constructor() {
        this.init();
    }
    
    init() {
        // Инициализация направлений деятельности (если есть слайдер)
        this.initDirectionsSlider();
        
        // Анимации при скролле
        this.initScrollAnimations();
    }
    
    initDirectionsSlider() {
        const directionsSlider = document.querySelector('.about-directions__slider');
        if (directionsSlider) {
            window.aboutDirectionsSlider = new AboutDirectionsSlider(directionsSlider);
            
            // Принудительное обновление после инициализации
            setTimeout(() => {
                window.aboutDirectionsSlider.updateSlider();
            }, 100);
        }
    }
    
    initScrollAnimations() {
        // Анимации появления элементов при скролле
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    
                    // Запускаем анимацию счетчиков для карточек преимуществ
                    if (entry.target.classList.contains('about-advantages__card')) {
                        this.animateCounters(entry.target);
                    }
                }
            });
        }, observerOptions);
        
        // Наблюдаем за карточками лицензий
        const licenseItems = document.querySelectorAll('.about-licenses__item');
        licenseItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
            observer.observe(item);
        });
        
        // Наблюдаем за другими блоками
        const sections = document.querySelectorAll('.about-advantages__card, .about-reasons__item, .about-quality__item, .about-production__item, .about-services__item');
        sections.forEach(section => {
            observer.observe(section);
        });
    }

    animateCounters(card) {
        const counters = card.querySelectorAll('.about-advantages__stat-number[data-count]');
        
        counters.forEach(counter => {
            const target = parseFloat(counter.getAttribute('data-count'));
            const suffix = counter.querySelector('.about-advantages__stat-suffix');
            const suffixText = suffix ? suffix.textContent : '';
            const duration = 2000; // 2 секунды
            const increment = target / (duration / 16); // 60 FPS
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    const displayValue = Math.floor(current);
                    counter.innerHTML = `${displayValue}<span class="about-advantages__stat-suffix">${suffixText}</span>`;
                    requestAnimationFrame(updateCounter);
                } else {
                    const finalValue = target % 1 === 0 ? target : target.toFixed(1);
                    counter.innerHTML = `${finalValue}<span class="about-advantages__stat-suffix">${suffixText}</span>`;
                }
            };
            
            // Небольшая задержка для красивого эффекта
            setTimeout(updateCounter, 500);
        });
    }
}

class AboutDirectionsSlider {
    constructor(container) {
        this.container = container;
        this.track = container.querySelector('.about-directions__slider-track');
        this.items = container.querySelectorAll('.about-directions__item');
        this.prevBtn = container.querySelector('.about-directions__nav-btn--prev');
        this.nextBtn = container.querySelector('.about-directions__nav-btn--next');
        
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
        if (width <= 1200) return 2;
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
        } else {
            // Всегда обновляем слайдер при изменении размера окна
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
        [this.prevBtn, this.nextBtn].forEach(element => {
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
        
        // Проверяем, что все элементы существуют
        if (!this.track || !this.track.parentElement || this.items.length === 0) {
            return;
        }
        
        this.isAnimating = true;
        
        // Получаем ширину контейнера
        const containerWidth = this.track.parentElement.offsetWidth;
        const gap = this.getGapSize();
        
        // Рассчитываем ширину одной карточки с учетом отступов
        const itemWidth = (containerWidth - gap * (this.slidesToShow - 1)) / this.slidesToShow;
        
        // Устанавливаем ширину карточек через JavaScript для точного контроля
        this.items.forEach(item => {
            item.style.width = `${itemWidth}px`;
            item.style.flexShrink = '0';
            item.style.flex = '0 0 auto';
        });
        
        // Рассчитываем смещение для текущего слайда
        const translateX = -(this.currentSlide * (itemWidth + gap));
        
        // Применяем трансформацию
        this.track.style.transform = `translateX(${translateX}px)`;
        
        // Обновление состояния кнопок
        this.updateNavigationState();
        
        // Сброс флага анимации
        setTimeout(() => {
            this.isAnimating = false;
        }, 600);
    }
    
    getGapSize() {
        const width = window.innerWidth;
        if (width <= 576) return 0; // Мобильные - без отступов
        if (width <= 1200) return 24; // Планшеты - 24px
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

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    new AboutPage();
    
    // Добавляем поддержку touch для мобильных устройств для направлений деятельности
    const directionsSliderContainer = document.querySelector('.about-directions__slider');
    
    if (directionsSliderContainer) {
        let startX = 0;
        let startY = 0;
        let isDragging = false;
        let startTime = 0;
        
        directionsSliderContainer.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            startTime = Date.now();
            isDragging = true;
            // Останавливаем автопрокрутку
            const slider = window.aboutDirectionsSlider;
            if (slider) slider.stopAutoPlay();
        }, { passive: true });
        
        directionsSliderContainer.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            
            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;
            const diffX = startX - currentX;
            const diffY = startY - currentY;
            
            // Если это горизонтальный свайп, предотвращаем скролл страницы
            if (Math.abs(diffX) > Math.abs(diffY)) {
                e.preventDefault();
            }
        }, { passive: false });
        
        directionsSliderContainer.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            const diffX = startX - endX;
            const diffY = startY - endY;
            const duration = Date.now() - startTime;
            
            // Проверяем, что это горизонтальный свайп с достаточной скоростью
            const isHorizontalSwipe = Math.abs(diffX) > Math.abs(diffY);
            const isFastEnough = Math.abs(diffX) > 30 || (Math.abs(diffX) > 20 && duration < 300);
            
            if (isHorizontalSwipe && isFastEnough) {
                const slider = window.aboutDirectionsSlider;
                if (slider) {
                    if (diffX > 0) {
                        slider.nextSlide();
                    } else {
                        slider.prevSlide();
                    }
                }
            }
            
            isDragging = false;
            // Возобновляем автопрокрутку
            const slider = window.aboutDirectionsSlider;
            if (slider) slider.startAutoPlay();
        }, { passive: true });
    }
});

/* ========================================
   МОДАЛЬНОЕ ОКНО ДЛЯ ЛИЦЕНЗИЙ
======================================== */

class LicensesModal {
    constructor() {
        this.modal = document.getElementById('licensesModal');
        this.modalImage = this.modal?.querySelector('.licenses-modal__image');
        this.modalTitle = this.modal?.querySelector('.licenses-modal__title');
        this.closeBtn = this.modal?.querySelector('.licenses-modal__close');
        this.overlay = this.modal?.querySelector('.licenses-modal__overlay');
        
        if (this.modal) {
            this.init();
        }
    }
    
    init() {
        // Обработчики событий
        this.closeBtn?.addEventListener('click', () => this.close());
        this.overlay?.addEventListener('click', () => this.close());
        
        // Закрытие по клавише ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.classList.contains('active')) {
                this.close();
            }
        });
        
        // Обработчики для карточек лицензий
        this.initLicenseCards();
    }
    
    initLicenseCards() {
        const licenseItems = document.querySelectorAll('.about-licenses__item[data-modal-image]');
        
        licenseItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const imageUrl = item.getAttribute('data-modal-image');
                const imageTitle = item.getAttribute('data-modal-title');
                
                if (imageUrl) {
                    this.open(imageUrl, imageTitle);
                }
            });
        });
    }
    
    open(imageUrl, title = '') {
        if (!this.modal || !this.modalImage) return;
        
        // Устанавливаем изображение и заголовок
        this.modalImage.src = imageUrl;
        this.modalImage.alt = title;
        this.modalTitle.textContent = title;
        
        // Показываем модальное окно
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Анимация появления
        setTimeout(() => {
            this.modal.style.opacity = '1';
        }, 10);
        
        // Аналитика
        console.log('Лицензия открыта:', title);
    }
    
    close() {
        if (!this.modal) return;
        
        // Скрываем модальное окно
        this.modal.classList.remove('active');
        document.body.style.overflow = '';
        
        // Очищаем данные после анимации
        setTimeout(() => {
            if (!this.modal.classList.contains('active')) {
                this.modalImage.src = '';
                this.modalImage.alt = '';
                this.modalTitle.textContent = '';
            }
        }, 300);
    }
}

// Инициализация модального окна при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    window.licensesModal = new LicensesModal();
});