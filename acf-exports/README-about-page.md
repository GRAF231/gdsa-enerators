# Поля ACF для страницы "О компании"

## Группа полей: About Page Fields

**Привязка:** К шаблону страницы = "О компании"

---

## Структура полей

### 1. Блок преимуществ (Advantages Section)

#### Заголовок компании
- **Название поля:** `advantages_company_name`
- **Тип:** Text
- **По умолчанию:** "ООО «DSA Generators»"
- **Обязательное:** Да

#### Подзаголовок
- **Название поля:** `advantages_subtitle`
- **Тип:** Text
- **По умолчанию:** "В МОСКВЕ"

#### ИНН
- **Название поля:** `advantages_inn`
- **Тип:** Text
- **По умолчанию:** "ИНН 7840490040"

#### Карточка 1 - Стабильность (Repeater)
- **Название поля:** `advantages_stability`
- **Тип:** Group
  - `years_count` (Number) - Количество лет
  - `years_text` (Text) - Описание лет
  - `employees_count` (Number) - Количество сотрудников
  - `employees_text` (Text) - Описание сотрудников
  - `progress_percent` (Number) - Процент надежности

#### Карточка 2 - Надёжность (Repeater)
- **Название поля:** `advantages_reliability`
- **Тип:** Group
  - `projects_count` (Number) - Количество проектов
  - `projects_text` (Text) - Описание проектов
  - `revenue_amount` (Text) - Выручка
  - `revenue_text` (Text) - Описание выручки
  - `progress_percent` (Number) - Процент успешности

#### Карточка 3 - Потенциал (Repeater)
- **Название поля:** `advantages_potential`
- **Тип:** Group
  - `power_amount` (Number) - Мощность в МВт
  - `power_text` (Text) - Описание мощности
  - `area_amount` (Number) - Площадь производства
  - `area_text` (Text) - Описание площади
  - `progress_percent` (Number) - Процент потенциала

---

### 2. Блок "10 причин" (Reasons Section)

#### Заголовок
- **Название поля:** `reasons_title`
- **Тип:** Text
- **По умолчанию:** "10 причин выбрать «DSA Generators»: какую пользу мы принесем"

#### Список причин
- **Название поля:** `reasons_list`
- **Тип:** Repeater
  - **Подполя:**
    - `reason_number` (Number) - Номер причины
    - `reason_text` (Wysiwyg) - Текст причины с возможностью ссылок

---

### 3. Направления деятельности (Directions Section)

#### Заголовок
- **Название поля:** `directions_title`
- **Тип:** Text
- **По умолчанию:** "НАПРАВЛЕНИЯ ДЕЯТЕЛЬНОСТИ"

#### Список направлений
- **Название поля:** `directions_list`
- **Тип:** Repeater
  - **Подполя:**
    - `direction_image` (Image) - Изображение направления
    - `direction_title` (Text) - Название направления
    - `direction_spec1` (Text) - Спецификация 1
    - `direction_spec2` (Text) - Спецификация 2
    - `direction_status` (Text) - Статус направления

---

### 4. Качество продукции (Quality Section)

#### Заголовок
- **Название поля:** `quality_title`
- **Тип:** Text
- **По умолчанию:** "Качество нашей продукции и гарантии"

#### Список пунктов качества
- **Название поля:** `quality_list`
- **Тип:** Repeater
  - **Подполя:**
    - `quality_icon` (Text) - Класс Font Awesome иконки
    - `quality_text` (Textarea) - Текст пункта

---

### 5. Наше производство (Production Section)

#### Заголовок
- **Название поля:** `production_title`
- **Тип:** Text
- **По умолчанию:** "Наше производство"

#### Галерея производства
- **Название поля:** `production_items`
- **Тип:** Repeater
  - **Подполя:**
    - `production_image` (Image) - Изображение
    - `production_title` (Text) - Заголовок элемента

---

### 6. Наши услуги (Services Section)

#### Заголовок
- **Название поля:** `services_title`
- **Тип:** Text
- **По умолчанию:** "Наши услуги:"

#### Список услуг - Колонка 1
- **Название поля:** `services_column1`
- **Тип:** Repeater
  - **Подполя:**
    - `service_icon` (Text) - Класс Font Awesome иконки
    - `service_text` (Textarea) - Текст услуги

#### Список услуг - Колонка 2
- **Название поля:** `services_column2`
- **Тип:** Repeater
  - **Подполя:**
    - `service_icon` (Text) - Класс Font Awesome иконки
    - `service_text` (Textarea) - Текст услуги

---

### 7. Лицензии компании (Licenses Section)

#### Заголовок
- **Название поля:** `licenses_title`
- **Тип:** Text
- **По умолчанию:** "ЛИЦЕНЗИИ КОМПАНИИ"

#### Список лицензий
- **Название поля:** `licenses_list`
- **Тип:** Repeater
  - **Подполя:**
    - `license_icon` (Text) - Класс Font Awesome иконки
    - `license_title` (Text) - Название лицензии
    - `license_spec1` (Text) - Спецификация 1
    - `license_spec2` (Text) - Спецификация 2
    - `license_status` (Text) - Статус (По умолчанию: "Действующий")

---

## Инструкции по созданию

1. Зайдите в админ-панель WordPress
2. Перейдите в **Custom Fields → Field Groups**
3. Нажмите **Add New**
4. Создайте группу полей с названием "About Page Fields"
5. Добавьте все поля согласно структуре выше
6. В настройках **Location Rules** установите:
   - **Page Template** is equal to **О компании**
7. Сохраните группу полей
8. Перейдите в **Custom Fields → Tools**
9. Выберите вкладку **Export**
10. Выберите группу "About Page Fields"
11. Нажмите **Generate export code**
12. Скопируйте JSON код
13. Сохраните в файл `acf-exports/about-page-fields.json`

---

## Примечание

После экспорта полей ACF в JSON, файл будет автоматически импортирован при активации темы благодаря коду в `functions.php`, который загружает все JSON файлы из папки `acf-exports/`.
