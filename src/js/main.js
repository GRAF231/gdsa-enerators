/**
 * DSA Generators - Основной JavaScript файл
 * Модульная структура без использования ES6 модулей
 *
 * Примечание: Для работы этого файла необходимо подключить все модули в HTML перед этим файлом:
 */

// Инициализация всех компонентов при загрузке DOM
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация компонентов
    initCatalog();
    initMobileMenu();
    initMobileSearch();
    console.log('DSA Generators - компоненты инициализированы');
});

/**
 * Инициализация каталога с табами
 */
function initCatalog() {
    const tabs = document.querySelectorAll('.catalog__tab');
    const panels = document.querySelectorAll('.catalog__panel');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Убираем активный класс со всех табов и панелей
            tabs.forEach(t => t.classList.remove('catalog__tab_active'));
            panels.forEach(p => p.classList.remove('catalog__panel_active'));
            
            // Добавляем активный класс к выбранному табу и панели
            this.classList.add('catalog__tab_active');
            const targetPanel = document.querySelector(`[data-panel="${targetTab}"]`);
            if (targetPanel) {
                targetPanel.classList.add('catalog__panel_active');
            }
        });
    });
    
    // Добавляем обработчики для опций в каталоге
    const options = document.querySelectorAll('.catalog__option');
    options.forEach(option => {
        option.addEventListener('click', function(e) {
            // Здесь можно добавить логику для перехода на страницу товара
            // или открытия модального окна с подробной информацией
            console.log('Выбрана опция:', this.textContent);
            
            // Добавляем визуальный эффект при клике
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
            
            // Если нужно предотвратить переход по ссылке для демонстрации
            // e.preventDefault();
        });
    });
}

/**
 * Инициализация мобильного меню
 */
function initMobileMenu() {
    const burger = document.querySelector('.header__burger');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileClose = document.querySelector('.header__mobile-close');
    const body = document.body;
    
    if (!burger || !mobileMenu) return;
    
    // Функция закрытия меню
    function closeMenu() {
        burger.classList.remove('active');
        mobileMenu.classList.remove('active');
        burger.setAttribute('aria-expanded', 'false');
        body.style.overflow = '';
    }
    
    // Функция открытия меню
    function openMenu() {
        burger.classList.add('active');
        mobileMenu.classList.add('active');
        burger.setAttribute('aria-expanded', 'true');
        body.style.overflow = 'hidden';
    }
    
    burger.addEventListener('click', function() {
        const isActive = burger.classList.contains('active');
        
        if (isActive) {
            closeMenu();
        } else {
            openMenu();
        }
    });
    
    // Закрываем меню при клике на кнопку закрытия
    if (mobileClose) {
        mobileClose.addEventListener('click', closeMenu);
    }
    
    // Закрываем меню при клике на ссылку
    const mobileLinks = mobileMenu.querySelectorAll('.header__mobile-menu-link');
    mobileLinks.forEach(link => {
        link.addEventListener('click', closeMenu);
    });
    
    // Закрываем меню при клике вне меню
    document.addEventListener('click', function(e) {
        if (!burger.contains(e.target) && !mobileMenu.contains(e.target)) {
            closeMenu();
        }
    });
    
    // Закрываем меню при нажатии Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
            closeMenu();
        }
    });
}

/**
 * Инициализация мобильного поиска
 */
function initMobileSearch() {
    const searchBtn = document.querySelector('.header__search-mobile-btn');
    
    if (!searchBtn) return;
    
    searchBtn.addEventListener('click', function() {
        // Здесь можно добавить логику для открытия поиска
        // Например, показать модальное окно поиска или перейти на страницу поиска
        console.log('Мобильный поиск активирован');
        
        // Временное решение - показываем alert
        const searchQuery = prompt('Введите поисковый запрос:');
        if (searchQuery) {
            // Здесь можно добавить логику поиска
            console.log('Поиск по запросу:', searchQuery);
        }
    });
}
