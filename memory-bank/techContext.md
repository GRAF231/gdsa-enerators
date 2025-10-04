# ТЕХНИЧЕСКИЙ КОНТЕКСТ

## ТЕХНОЛОГИИ И СТАНДАРТЫ

### Frontend Stack
```
HTML5
├── Семантическая разметка
├── БЭМ методология
├── Accessibility (ARIA)
└── SEO-оптимизация

CSS3
├── CSS Variables
├── Flexbox & Grid
├── Media Queries
├── Animations & Transitions
└── Glassmorphism & Градиенты

JavaScript ES6+
├── Vanilla JS (без фреймворков)
├── ES6 Classes
├── ES6 Modules
├── Async/Await
└── Intersection Observer API
```

### Инструменты
- **Font Awesome 6.5.2** - иконки
- **Google Fonts (Rubik)** - типографика
- **Git** - контроль версий

## БЭМ МЕТОДОЛОГИЯ

### Именование
```
.block { }                    /* Блок */
.block__element { }           /* Элемент */
.block_modifier_value { }     /* Модификатор */
```

### Примеры
```css
.header { }
.header__topbar { }
.header__logo { }
.header__top-item_dropdown { }
```

## СТРУКТУРА CSS

### Модули
```
src/css/
├── main.css              # Импорты всех модулей
├── variables.css         # CSS переменные
├── reset.css             # Сброс стилей браузера
├── typography.css        # Шрифты и типографика
├── layout.css            # Сетка и контейнеры
├── utilities.css         # Утилитарные классы
├── buttons.css           # Кнопки
├── header.css            # Шапка сайта
├── footer.css            # Подвал сайта
├── breadcrumbs.css       # Хлебные крошки
├── home/                 # Модули главной страницы
│   ├── home-slider.css
│   ├── home-advantages.css
│   ├── home-equipment.css
│   ├── home-popular.css
│   ├── home-projects.css
│   └── home-news.css
├── about/about.css       # О компании
├── catalog.css           # Каталог
├── product.css           # Страница товара
├── contacts.css          # Контакты
├── tenders.css           # Тендеры
├── production.css        # Производство
└── projects.css          # Проекты
```

### CSS Variables
```css
/* Цвета */
--primary: #0a1855;
--primary-light: #3b5fdb;
--accent: #00c2ff;
--text-dark: #3D3D3D;
--bg-light: #ffffff;

/* Типографика */
--font-main: 'Rubik', sans-serif;
--fs-base: 16px;

/* Spacing */
--spacing-md: 16px;

/* Радиусы */
--radius-lg: 12px;

/* Тени */
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);

/* Переходы */
--transition-base: 0.3s ease;
```

## СТРУКТУРА JAVASCRIPT

### Модули
```
src/js/
├── main.js              # Header, Footer, общее
├── home-slider.js       # Главный слайдер
├── home-popular.js      # Популярные товары
├── home-projects.js     # Галерея проектов
├── about.js             # О компании
├── contacts.js          # Контакты
├── production.js        # Производство
├── projects.js          # Проекты
├── tenders.js           # Тендеры
├── product.js           # Страница товара
└── catalog.js           # Каталог
```

### Архитектура
```javascript
// Классовый подход ES6
class ComponentName {
  constructor(selector) {
    this.element = document.querySelector(selector);
    this.init();
  }
  
  init() {
    this.setupEventListeners();
    this.setupObservers();
  }
}

// Инициализация
document.addEventListener('DOMContentLoaded', () => {
  new ComponentName('.component');
});
```

## АДАПТИВНОСТЬ

### Брейкпоинты
```css
/* Desktop Large */
@media (max-width: 1400px) { }

/* Desktop Medium */
@media (max-width: 1200px) { }

/* Tablet */
@media (max-width: 992px) { }

/* Tablet Small */
@media (max-width: 768px) { }

/* Mobile */
@media (max-width: 576px) { }

/* Mobile Small */
@media (max-width: 360px) { }
```

### Подход
- **Mobile-First** - базовые стили для мобильных
- **Progressive Enhancement** - улучшения для больших экранов
- **Flexbox & Grid** - современные раскладки
- **Responsive Images** - адаптивные изображения

## ПРОИЗВОДИТЕЛЬНОСТЬ

### Оптимизация
- Минификация CSS и JS
- Lazy Loading изображений
- Debouncing для resize/scroll
- requestAnimationFrame для анимаций
- Критичный CSS в `<head>`
- Удаление неиспользуемого CSS

### Web Vitals
- **LCP** (Largest Contentful Paint) < 2.5s
- **FID** (First Input Delay) < 100ms
- **CLS** (Cumulative Layout Shift) < 0.1

## ДОСТУПНОСТЬ (A11Y)

### ARIA
```html
<nav aria-label="Основная навигация">
<button aria-haspopup="true" aria-expanded="false">
<div role="dialog" aria-modal="true">
<input aria-required="true" aria-invalid="false">
```

### Клавиатурная навигация
- Tab - следующий элемент
- Shift+Tab - предыдущий элемент
- Enter/Space - активация
- Escape - закрытие модальных окон
- Arrow keys - навигация в слайдерах

### Focus Management
```css
*:focus-visible {
  outline: 2px solid var(--accent);
  outline-offset: 2px;
}
```

## SEO

### Семантика
```html
<header>, <nav>, <main>, <article>, <section>, <aside>, <footer>
```

### Мета-теги
```html
<title>...</title>
<meta name="description" content="...">
<meta property="og:title" content="...">
<link rel="canonical" href="...">
```

### Структурированные данные
```json
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "...",
  "description": "...",
  "image": "...",
  "offers": { ... }
}
```

## WORDPRESS ИНТЕГРАЦИЯ (ПЛАНИРУЕТСЯ)

### Структура темы
```
wp-content/themes/dsa-generators/
├── style.css              # Информация о теме
├── functions.php          # Функции темы
├── header.php             # Шапка
├── footer.php             # Подвал
├── sidebar.php            # Боковая панель
├── front-page.php         # Главная страница
├── page.php               # Стандартная страница
├── single.php             # Одиночная запись
├── archive.php            # Архив
├── search.php             # Поиск
├── 404.php                # Ошибка 404
├── woocommerce/           # Шаблоны WooCommerce
│   ├── archive-product.php
│   ├── single-product.php
│   ├── cart/
│   └── checkout/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
└── inc/                   # Дополнительные файлы
    ├── customizer.php
    ├── template-functions.php
    └── woocommerce.php
```

## СТАНДАРТЫ КОДА

### HTML
- Семантическая разметка
- БЭМ именование классов
- Валидный HTML5
- Accessibility атрибуты

### CSS
- БЭМ методология
- CSS Variables для переменных
- Mobile-First подход
- Модульная структура

### JavaScript
- ES6+ синтаксис
- Классовая архитектура
- Модульная структура
- JSDoc комментарии
- Обработка ошибок

## ПОСЛЕДНЕЕ ОБНОВЛЕНИЕ
**04 октября 2025, 18:03**
