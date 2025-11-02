/**
 * Мобильный поиск в header
 */
(function() {
    'use strict';
    
    // Получаем элементы
    const searchBtn = document.querySelector('.header__search-mobile-btn');
    const searchPanel = document.querySelector('.header__search-mobile-panel');
    const searchClose = document.querySelector('.header__search-mobile-close');
    const searchInput = document.querySelector('.header__search-mobile-input');
    
    if (!searchBtn || !searchPanel) {
        return;
    }
    
    /**
     * Открытие панели поиска
     */
    function openSearch() {
        searchPanel.classList.add('active');
        searchBtn.setAttribute('aria-expanded', 'true');
        searchBtn.style.opacity = '0';
        searchBtn.style.pointerEvents = 'none';
        document.body.style.overflow = 'hidden';
        
        // Фокус на поле ввода с небольшой задержкой
        setTimeout(() => {
            if (searchInput) {
                searchInput.focus();
            }
        }, 400);
    }
    
    /**
     * Закрытие панели поиска
     */
    function closeSearch() {
        searchPanel.classList.remove('active');
        searchBtn.setAttribute('aria-expanded', 'false');
        searchBtn.style.opacity = '1';
        searchBtn.style.pointerEvents = 'auto';
        document.body.style.overflow = '';
    }
    
    /**
     * Переключение панели поиска
     */
    function toggleSearch() {
        if (searchPanel.classList.contains('active')) {
            closeSearch();
        } else {
            openSearch();
        }
    }
    
    // Обработчики событий
    searchBtn.addEventListener('click', toggleSearch);
    
    if (searchClose) {
        searchClose.addEventListener('click', closeSearch);
    }
    
    // Закрытие по Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && searchPanel.classList.contains('active')) {
            closeSearch();
        }
    });
    
    // Закрытие при клике вне панели (на overlay)
    searchPanel.addEventListener('click', (e) => {
        if (e.target === searchPanel) {
            closeSearch();
        }
    });
    
})();
