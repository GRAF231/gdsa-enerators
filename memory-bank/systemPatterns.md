# СИСТЕМНЫЕ ПАТТЕРНЫ И АРХИТЕКТУРА

## АРХИТЕКТУРНЫЕ ПРИНЦИПЫ

### Подход
**Mobile-First Progressive Enhancement** - сначала мобильная версия, затем улучшения для больших экранов

### Технологический стек
- **HTML5** - семантическая разметка
- **CSS3** - БЭМ, переменные, Flexbox, Grid
- **JavaScript ES6+** - Vanilla JS, классы, модули
- **WordPress + WooCommerce** - будущая интеграция

## БЭМ МЕТОДОЛОГИЯ

### Структура
```
Блок__Элемент_Модификатор

.header { }
.header__logo { }
.header_type_fixed { }
```

### Примеры из проекта
```html
<header class="header">
  <div class="header__topbar">
    <nav class="header__top-nav">
      <ul class="header__top-list">
        <li class="header__top-item header__top-item_dropdown">
```

## CSS АРХИТЕКТУРА

### Структура файлов
```
src/css/
├── main.css              # Главный с импортами
├── variables.css         # CSS переменные
├── reset.css             # Сброс стилей
├── typography.css        # Типографика
├── layout.css            # Сетка
├── utilities.css         # Утилиты
├── buttons.css           # Кнопки
├── header.css            # Шапка
├── footer.css            # Подвал
├── home/                 # Модули главной
└── about/                # О компании
```

### CSS Variables
```css
--primary: #0a1855;
--accent: #00c2ff;
--font-main: 'Rubik', sans-serif;
--spacing-md: 16px;
--radius-lg: 12px;
--shadow-md: 0 4px 6px rgba(0,0,0,0.1);
--transition-base: 0.3s ease;
```

### Брейкпоинты
```css
@media (max-width: 1400px) { /* Большие десктопы */ }
@media (max-width: 1200px) { /* Средние десктопы */ }
@media (max-width: 992px)  { /* Планшеты */ }
@media (max-width: 768px)  { /* Маленькие планшеты */ }
@media (max-width: 576px)  { /* Телефоны */ }
```

## JAVASCRIPT АРХИТЕКТУРА

### Module Pattern (классы ES6)
```javascript
class HomeSlider {
  constructor(selector) {
    this.slider = document.querySelector(selector);
    this.init();
  }
  
  init() {
    this.setupSlides();
    this.setupNavigation();
    this.startAutoplay();
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new HomeSlider('.home-slider');
});
```

### Общие паттерны
1. **Intersection Observer** - анимации появления
2. **Debounce** - оптимизация resize
3. **Touch Support** - свайпы для слайдеров
4. **Modal Manager** - управление модальными окнами

## ДИЗАЙН-ПАТТЕРНЫ

### Glassmorphism
```css
.glass-card {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(20px) saturate(180%);
  border: 1px solid rgba(255, 255, 255, 0.2);
}
```

### Градиенты
```css
.gradient-primary {
  background: linear-gradient(90deg, #1A1F7B 0%, #09B6CE 100%);
}
```

### Hover эффекты
```css
.card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: var(--shadow-xl);
}
```

## ПРОИЗВОДИТЕЛЬНОСТЬ

### Оптимизация
- Critical CSS в `<head>`
- Минификация CSS/JS
- Lazy Loading изображений
- Debouncing для событий
- requestAnimationFrame для анимаций

### Accessibility
- ARIA атрибуты
- Клавиатурная навигация
- Focus management
- Screen reader поддержка

## SEO

### Мета-теги
```html
<title>DSA Generators - Дизельные электрогенераторы</title>
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
  "offers": { ... }
}
```

## ПОСЛЕДНЕЕ ОБНОВЛЕНИЕ
**28 октября 2025**
