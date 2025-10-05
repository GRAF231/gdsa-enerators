# Общие стили пагинации

## Подключение

Добавьте в `<head>` HTML файла:

```html
<link rel="stylesheet" href="../css/pagination.css">
```

## HTML структура

### Базовая пагинация
```html
<div class="pagination">
    <div class="pagination__nav">
        <button class="pagination__btn pagination__btn_prev" disabled>
            <i class="fa-solid fa-angle-left" aria-hidden="true"></i>
            Предыдущая
        </button>
        <div class="pagination__pages">
            <button class="pagination__page pagination__page_active">1</button>
            <button class="pagination__page">2</button>
            <button class="pagination__page">3</button>
            <span class="pagination__dots">...</span>
            <button class="pagination__page">18</button>
        </div>
        <button class="pagination__btn pagination__btn_next">
            Следующая
            <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
        </button>
    </div>
</div>
```

### Пагинация с настройкой количества элементов
```html
<div class="pagination">
    <div class="pagination__per-page">
        <span class="pagination__per-page-label">Выводить по:</span>
        <div class="pagination__per-page-buttons">
            <button class="pagination__per-page-btn" data-per-page="10">10</button>
            <button class="pagination__per-page-btn pagination__per-page-btn_active" data-per-page="100">100</button>
            <button class="pagination__per-page-btn" data-per-page="all">Все</button>
        </div>
    </div>
    <div class="pagination__nav">
        <!-- навигация как выше -->
    </div>
</div>
```

### Пагинация с информацией о результатах
```html
<div class="pagination">
    <div class="pagination__nav">
        <div class="pagination__results">
            <span class="pagination__results-text">
                Показано 1-100 из 500 проектов
            </span>
        </div>
        <!-- остальная навигация -->
    </div>
</div>
```

## CSS классы

### Основные классы
- `.pagination` - основной контейнер
- `.pagination__nav` - контейнер навигации
- `.pagination__btn` - кнопки "Предыдущая"/"Следующая"
- `.pagination__pages` - контейнер страниц
- `.pagination__page` - кнопка страницы
- `.pagination__page_active` - активная страница
- `.pagination__dots` - многоточие

### Классы для настройки количества
- `.pagination__per-page` - контейнер настроек
- `.pagination__per-page-label` - подпись
- `.pagination__per-page-buttons` - контейнер кнопок
- `.pagination__per-page-btn` - кнопка количества
- `.pagination__per-page-btn_active` - активная кнопка

### Классы для информации о результатах
- `.pagination__results` - контейнер информации
- `.pagination__results-text` - текст информации

## Модификаторы

- `.pagination__btn_prev` - кнопка "Предыдущая"
- `.pagination__btn_next` - кнопка "Следующая"
- `[data-per-page="all"]` - кнопка "Все"

## Использование в JavaScript

```javascript
// Получение элементов
const pagesContainer = document.querySelector('.pagination__pages');
const prevButton = document.querySelector('.pagination__btn_prev');
const nextButton = document.querySelector('.pagination__btn_next');
const perPageButtons = document.querySelectorAll('.pagination__per-page-btn');

// Создание кнопки страницы
const pageButton = document.createElement('button');
pageButton.className = 'pagination__page';
pageButton.textContent = pageNumber;
if (pageNumber === currentPage) {
    pageButton.classList.add('pagination__page_active');
}
```

## Адаптивность

Стили автоматически адаптируются под разные размеры экранов:
- На мобильных устройствах кнопки становятся компактнее
- На планшетах элементы перестраиваются в колонку
- На больших экранах используется горизонтальная компоновка

## Цветовая схема

- Основной цвет: `#0a1855` (темно-синий)
- Акцентный цвет: `#3b5fdb` (синий)
- Границы: `#e2e8f0` (светло-серый)
- Текст: `#3D3D3D` (темно-серый)
