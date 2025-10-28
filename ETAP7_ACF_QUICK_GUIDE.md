# 🚀 ЭТАП 7: ACF ПОЛЯ - БЫСТРОЕ РУКОВОДСТВО

**Дата:** 2025-10-28  
**Статус:** CREATIVE ✅ ЗАВЕРШЕН | IMPLEMENT ⏳ СЛЕДУЮЩИЙ

---

## 📋 РЕЗЮМЕ CREATIVE ФАЗЫ

### ✅ Что решено:
- **Добавить 8 новых полей:** voltage, frequency, phases, fuel_tank_volume, fuel_consumption, start_type, noise_level, warranty
- **Исправить 1 поле:** cooling_type (return_format: value → label)
- **Итоговая структура:** 24 поля ACF (было 16 → стало 24)
- **Покрытие требований:** 90%

### 📄 Документация:
- **Полная CREATIVE фаза:** `memory-bank/creative/woocommerce-acf-fields-design.md`
- **Текущий README ACF:** `acf-exports/README-product-fields.md`

---

## 🎯 ЧТО ДЕЛАТЬ В IMPLEMENT ФАЗЕ

### Шаг 1: Обновить ACF в админке (15 минут)

**Где:** WordPress Admin → ACF → Custom Fields → "Характеристики товара"

**Добавить 8 полей в таком порядке:**

1. **После max_power** добавить 3 поля:
   ```
   voltage (number) - Напряжение | default: 400 | append: "В"
   frequency (select) - Частота | choices: 50 Гц / 60 Гц | return: label
   phases (select) - Фазы | choices: 1-фазная / 3-фазная | return: label
   ```

2. **После rotation_speed** добавить 2 поля:
   ```
   fuel_tank_volume (number) - Объем топливного бака | append: "л"
   fuel_consumption (number) - Расход топлива | append: "л/ч"
   ```

3. **После country** добавить 3 поля:
   ```
   start_type (select) - Тип запуска | choices: Ручной/Электрический/Автоматический
   noise_level (number) - Уровень шума | append: "дБ (A)"
   warranty (text) - Гарантия | default: "12 месяцев"
   ```

4. **Исправить cooling_type:**
   ```
   Return Format: value → label
   ```

5. **Сохранить** → JSON автоматически экспортируется

---

### Шаг 2: Обновить tab-specifications.php (5 минут)

**Файл:** `woocommerce/single-product/tab-specifications.php`

**В массив $specs (строка 14) добавить:**
```php
'voltage' => 'Напряжение, В',
'frequency' => 'Частота',
'phases' => 'Количество фаз',
'fuel_tank_volume' => 'Объём топливного бака, л',
'fuel_consumption' => 'Расход топлива, л/ч',
'start_type' => 'Тип запуска',
'noise_level' => 'Уровень шума, дБ (A)',
'warranty' => 'Гарантия',
```

---

### Шаг 3: Обновить product-info.php (10 минут)

**Файл:** `woocommerce/single-product/product-info.php`

**После строки 73 (блок двигателя) добавить:**
```php
<?php 
// Электрические характеристики
$voltage = get_field('voltage');
$frequency = get_field('frequency');
$phases = get_field('phases');

if ($voltage || $frequency || $phases) : 
?>
<div class="product-detail">
    <span class="product-detail__label">Параметры сети:</span>
    <span class="product-detail__value">
        <?php 
        $params = [];
        if ($voltage) $params[] = esc_html($voltage) . ' В';
        if ($frequency) $params[] = esc_html($frequency);
        if ($phases) $params[] = esc_html($phases);
        echo implode(' / ', $params);
        ?>
    </span>
</div>
<?php endif; ?>
```

---

### Шаг 4: Обновить README (15 минут)

**Файл:** `acf-exports/README-product-fields.md`

**Изменения:**
1. Строка 9: "20+" → "24"
2. Добавить секции для новых блоков:
   - Блок 3: Электрические характеристики (voltage, frequency, phases)
   - Блок 4: Топливо (fuel_tank_volume, fuel_consumption)
   - Блок 5: Эксплуатация (start_type, noise_level, warranty)

**Детали в:** `memory-bank/creative/woocommerce-acf-fields-design.md` (Шаг 4)

---

### Шаг 5: Тестирование (15 минут)

**Checklist:**
- [ ] ACF поля видны в админке
- [ ] JSON обновлен (`acf-exports/group_product-fields.json`)
- [ ] Новые поля выводятся на странице товара
- [ ] cooling_type показывает "Воздушное" вместо "air"
- [ ] Placeholders работают
- [ ] Default values работают
- [ ] Нет PHP ошибок

---

## ⚡ БЫСТРЫЙ СТАРТ

### Если у вас есть всего 30 минут:

1. **ACF Admin (15 мин):** Добавить 8 полей + исправить cooling_type
2. **tab-specifications.php (5 мин):** Добавить поля в массив
3. **Тест (10 мин):** Проверить вывод на странице товара

### Если у вас есть 1 час:

+ **product-info.php (10 мин):** Добавить электрические характеристики
+ **README (15 мин):** Обновить документацию
+ **Полное тестирование (20 мин):** Все пункты чеклиста

---

## 📊 НОВЫЕ ПОЛЯ - ШПАРГАЛКА

| Поле | Тип | Default | Append | Where |
|------|-----|---------|--------|-------|
| voltage | number | 400 | В | После max_power |
| frequency | select | 50 | - | После max_power |
| phases | select | 3 | - | После max_power |
| fuel_tank_volume | number | - | л | После rotation_speed |
| fuel_consumption | number | - | л/ч | После rotation_speed |
| start_type | select | electric | - | После country |
| noise_level | number | - | дБ (A) | После country |
| warranty | text | 12 месяцев | - | После country |

---

## 🔗 ССЫЛКИ НА ДОКУМЕНТАЦИЮ

- **Полная CREATIVE фаза:** `memory-bank/creative/woocommerce-acf-fields-design.md`
- **Текущий README:** `acf-exports/README-product-fields.md`
- **Tasks:** `memory-bank/tasks.md`
- **План интеграции:** `WOOCOMMERCE_INTEGRATION_PLAN.md`

---

## 🆘 TROUBLESHOOTING

### Проблема: Поля не появляются в админке
**Решение:** Очистить кеш WordPress + проверить активность ACF Pro

### Проблема: JSON не обновляется
**Решение:** Проверить права на запись в `acf-exports/`, пересохранить поля

### Проблема: Cooling_type показывает "air" вместо "Воздушное"
**Решение:** Изменить Return Format на "Label" и пересохранить

### Проблема: Поля не выводятся на фронтенде
**Решение:** Проверить имена полей в `get_field('field_name')`

---

**Автор:** DSA Generators Development Team  
**Версия:** 1.0  
**Последнее обновление:** 2025-10-28
