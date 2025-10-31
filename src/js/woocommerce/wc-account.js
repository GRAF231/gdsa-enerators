/**
 * WooCommerce Account Page JavaScript
 * Функциональность для личного кабинета
 */

(function($) {
    'use strict';

    /**
     * Переключение видимости пароля
     */
    function initPasswordToggle() {
        $('.wc-account-form-group__toggle-password').on('click', function() {
            const $button = $(this);
            const $wrapper = $button.closest('.wc-account-form-group__password-wrapper');
            const $input = $wrapper.find('input[type="password"], input[type="text"]');
            const $icon = $button.find('i');

            if ($input.attr('type') === 'password') {
                // Показать пароль
                $input.attr('type', 'text');
                $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                $button.attr('aria-label', 'Скрыть пароль');
            } else {
                // Скрыть пароль
                $input.attr('type', 'password');
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                $button.attr('aria-label', 'Показать пароль');
            }
        });
    }

    // Инициализация при загрузке страницы
    $(document).ready(function() {
        initPasswordToggle();
    });

})(jQuery);
