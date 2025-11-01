<?php
/**
 * MENU WALKERS
 * Кастомные Walker классы для WordPress меню
 * 
 * @package DSA_Generators
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// КАСТОМНЫЕ MENU WALKERS
// ============================================

/**
 * Кастомный Walker для верхнего меню (с поддержкой dropdown)
 */
class Header_Top_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="header__dropdown-menu">';
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Определяем, есть ли у элемента дочерние
        $has_children = in_array('menu-item-has-children', $classes);
        
        if ($depth === 0) {
            $class_names = $has_children ? 'header__top-item header__top-item_dropdown' : 'header__top-item';
            $output .= '<li class="' . esc_attr($class_names) . '">';
            
            $attributes  = ' class="header__top-link"';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            
            $output .= '<a' . $attributes . '>';
            $output .= esc_html($item->title);
            
            if ($has_children) {
                $output .= ' <i class="fa-solid fa-caret-down header__dropdown-icon" aria-hidden="true"></i>';
            }
            
            $output .= '</a>';
        } else {
            // Подменю
            $output .= '<li class="header__dropdown-item">';
            
            $attributes  = ' class="header__dropdown-link"';
            $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
            
            // Сначала проверяем кастомное поле иконки
            $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
            
            // Если нет кастомного поля, ищем в CSS классах
            if (empty($icon_class)) {
                $icon_class = 'fa-solid fa-circle';
                foreach ($classes as $class) {
                    if (strpos($class, 'fa-') === 0) {
                        $icon_class = $class;
                        break;
                    }
                }
            }
            
            $output .= '<a' . $attributes . '>';
            $output .= '<i class="' . esc_attr($icon_class) . ' header__dropdown-icon" aria-hidden="true"></i>';
            $output .= '<span>' . esc_html($item->title) . '</span>';
            $output .= '</a>';
        }
    }
}

/**
 * Кастомный Walker для основного меню (с иконками)
 */
class Header_Main_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        $output .= '<li class="header__menu-item">';
        
        $attributes  = ' class="header__menu-link"';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        // Сначала проверяем кастомное поле иконки
        $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
        
        // Если нет кастомного поля, ищем в CSS классах
        if (empty($icon_class)) {
            $icon_class = 'fa-solid fa-circle';
            foreach ($classes as $class) {
                if (strpos($class, 'fa-') === 0) {
                    $icon_class = $class;
                    break;
                }
            }
        }
        
        $output .= '<a' . $attributes . '>';
        $output .= '<i class="' . esc_attr($icon_class) . '"></i>';
        $output .= '<span>' . esc_html($item->title) . '</span>';
        $output .= '</a>';
    }
}

/**
 * Кастомный Walker для меню футера (простые ссылки)
 */
class Footer_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<li>';
        
        $attributes  = ' class="footer__nav-link"';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $output .= '<a' . $attributes . '>';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }
}

// ============================================
// КАСТОМНЫЕ ПОЛЯ ДЛЯ МЕНЮ (ИКОНКИ)
// ============================================

/**
 * Добавляет поле для иконки в редакторе пунктов меню
 */
function dsa_add_menu_item_icon_field($item_id, $item, $depth, $args) {
    $icon_value = get_post_meta($item_id, '_menu_item_icon', true);
    ?>
    <p class="field-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <?php _e('Иконка Font Awesome'); ?><br>
            <input 
                type="text" 
                id="edit-menu-item-icon-<?php echo $item_id; ?>" 
                class="widefat edit-menu-item-icon" 
                name="menu-item-icon[<?php echo $item_id; ?>]" 
                value="<?php echo esc_attr($icon_value); ?>" 
                placeholder="fa-solid fa-home"
            />
            <span class="description">Например: fa-solid fa-home, fa-solid fa-industry</span>
        </label>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'dsa_add_menu_item_icon_field', 10, 4);

/**
 * Сохраняет значение иконки при сохранении меню
 */
function dsa_save_menu_item_icon($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        $icon_value = sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_icon', $icon_value);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_icon');
    }
}
add_action('wp_update_nav_menu_item', 'dsa_save_menu_item_icon', 10, 3);
