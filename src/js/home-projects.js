/**
 * Блок выполненных проектов - Интерактивная галерея
 * Включает фильтрацию, анимации и современные эффекты
 */

class HomeProjects {
    constructor() {
        this.container = document.querySelector('.home-projects');
        this.projects = document.querySelectorAll('.home-projects__project');
        this.showMoreBtn = document.querySelector('.home-projects__show-more-btn');
        this.gallery = document.querySelector('.home-projects__gallery');
        
        this.maxVisibleProjects = 9;
        this.totalProjects = this.projects.length;
        
        this.init();
    }
    
    init() {
        if (!this.container) return;
        
        this.setupEventListeners();
        this.setupIntersectionObserver();
        this.setupParallaxEffect();
        this.setupProjectCards();
        this.limitVisibleProjects();
        
        console.log('HomeProjects initialized');
    }
    
    setupEventListeners() {
        // Кнопка "Показать все"
        if (this.showMoreBtn) {
            this.showMoreBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleShowMore();
            });
        }
        
        // Карточки проектов
        this.projects.forEach(project => {
            project.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleProjectClick(project);
            });
        });
    }
    
    setupIntersectionObserver() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    this.animateProjectCards();
                }
            });
        }, observerOptions);
        
        if (this.container) {
            observer.observe(this.container);
        }
    }
    
    setupParallaxEffect() {
        let ticking = false;
        
        const updateParallax = () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = this.container.querySelectorAll('.home-projects__project');
            
            parallaxElements.forEach((element, index) => {
                const speed = 0.5 + (index * 0.1);
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
            
            ticking = false;
        };
        
        const requestTick = () => {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        };
        
        window.addEventListener('scroll', requestTick);
    }
    
    setupProjectCards() {
        this.projects.forEach((project, index) => {
            // Добавляем случайную задержку для анимации
            const delay = Math.random() * 0.5;
            project.style.animationDelay = `${delay}s`;
            
            // Добавляем hover эффекты
            project.addEventListener('mouseenter', () => {
                this.animateCardHover(project, true);
            });
            
            project.addEventListener('mouseleave', () => {
                this.animateCardHover(project, false);
            });
        });
    }
    
    
    animateProjectIn(project, index) {
        project.style.animation = 'none';
        project.offsetHeight; // Trigger reflow
        project.style.animation = `projectSlideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards`;
        project.style.animationDelay = `${index * 0.1}s`;
    }
    
    animateProjectCards() {
        this.projects.forEach((project, index) => {
            setTimeout(() => {
                project.style.opacity = '1';
                project.style.transform = 'translateY(0)';
            }, index * 150);
        });
    }
    
    animateCardHover(project, isHovering) {
        const overlay = project.querySelector('.home-projects__project-overlay');
        const image = project.querySelector('.home-projects__project-image img');
        
        if (isHovering) {
            overlay.style.opacity = '1';
            image.style.transform = 'scale(1.1)';
        } else {
            overlay.style.opacity = '0';
            image.style.transform = 'scale(1)';
        }
    }
    
    handleProjectClick(project) {
        const title = project.querySelector('.home-projects__project-title').textContent;
        const desc = project.querySelector('.home-projects__project-desc').textContent;
        
        // Анимация клика
        project.style.transform = 'scale(0.95)';
        setTimeout(() => {
            project.style.transform = '';
        }, 150);
        
        // Показываем модальное окно или переходим на страницу проекта
        this.showProjectModal(title, desc);
        
        // Аналитика (если нужно)
        this.trackProjectView(title);
    }
    
    handleShowMore() {
        // Анимация кнопки
        this.showMoreBtn.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.showMoreBtn.style.transform = '';
        }, 150);
        
        // Показываем все проекты или переходим на страницу портфолио
        this.showAllProjects();
    }
    
    showProjectModal(title, description) {
        // Создаем модальное окно
        const modal = document.createElement('div');
        modal.className = 'project-modal';
        modal.innerHTML = `
            <div class="project-modal__overlay">
                <div class="project-modal__content">
                    <button class="project-modal__close">&times;</button>
                    <h3 class="project-modal__title">${title}</h3>
                    <p class="project-modal__description">${description}</p>
                    <div class="project-modal__actions">
                        <button class="btn btn--primary">Подробнее</button>
                        <button class="btn btn--secondary">Закрыть</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Анимация появления
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
        
        // Обработчики закрытия
        const closeBtn = modal.querySelector('.project-modal__close');
        const overlay = modal.querySelector('.project-modal__overlay');
        const closeActionBtn = modal.querySelector('.btn--secondary');
        
        const closeModal = () => {
            modal.classList.remove('active');
            setTimeout(() => {
                document.body.removeChild(modal);
            }, 300);
        };
        
        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);
        closeActionBtn.addEventListener('click', closeModal);
        
        // ESC для закрытия
        document.addEventListener('keydown', function escHandler(e) {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        });
    }
    
    showAllProjects() {
        // Переход на страницу портфолио или показ всех проектов
        window.location.href = '/portfolio';
    }
    
    
    showNotification(message) {
        // Создаем уведомление
        const notification = document.createElement('div');
        notification.className = 'project-notification';
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Анимация появления
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Автоматическое скрытие
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    trackProjectView(projectTitle) {
        // Аналитика просмотра проекта
        console.log(`Project viewed: ${projectTitle}`);
        
        // Здесь можно добавить отправку данных в аналитику
        // gtag('event', 'project_view', {
        //     'project_title': projectTitle
        // });
    }
    
    // Публичные методы для внешнего управления
    getVisibleProjectsCount() {
        return document.querySelectorAll('.home-projects__project:not(.hidden)').length;
    }
    
    limitVisibleProjects() {
        // Скрываем все проекты
        this.projects.forEach(project => {
            project.classList.add('hidden');
        });
        
        // Показываем только первые maxVisibleProjects проектов
        const visibleProjects = Array.from(this.projects).slice(0, this.maxVisibleProjects);
        visibleProjects.forEach((project, index) => {
            project.classList.remove('hidden');
            project.style.animationDelay = `${index * 0.05}s`;
        });
    }
}

// Инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    new HomeProjects();
});

// Экспорт для использования в других модулях
if (typeof module !== 'undefined' && module.exports) {
    module.exports = HomeProjects;
}
