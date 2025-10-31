
/**
 * Unified Checkout JavaScript
 * Функциональность объединенной страницы корзины и оформления заказа
 * 
 * @package DSA_Generators
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Класс для управления объединенной страницей чекаута
     */
    class UnifiedCheckout {
        constructor() {
            this.init();
        }

        init() {
            // Инициализация компонентов
            this.setupCartUpdates();
            this.setupQuantityControls();
            this.setupCouponForm();
            this.setupCheckoutForm();
            this.setupSmoothScrolling();
            this.setupLoadingStates();
            
            console.log('✅ Unified Checkout initialized');
        }

        /**
         * Настройка автоматического обновления корзины
         */
        setupCartUpdates() {
            const self = this;
            
            // Обновление при изменении количества
            $(document).on('change', '.cart-item__quantity input[type="number"]', function() {
                self.updateCart();
            });

            // Удаление товара из корзины
            $(document).on('click', '.cart-item__remove-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const cartItemKey = $btn.data('cart_item_key');
                
                self.removeCartItem(cartItemKey, $btn);
            });
        }

        /**
         * Обновление корзины через AJAX (БЕЗ перезагрузки страницы)
         */
        updateCart() {
            const $form = $('form.woocommerce-cart-form');
            const $cartItems = $('.cart-items');
            const $cartTotals = $('.cart-totals');
            
            if (!$form.length) {
                console.warn('⚠️ Cart form not found');
                return;
            }
            
            // Показываем loading состояние
            $cartItems.addClass('processing');
            $cartTotals.addClass('processing');

            // Создаём скрытое поле для update_cart
            const $updateInput = $('<input>', {
                type: 'hidden',
                name: 'update_cart',
                value: 'Update cart'
            });
            
            $form.append($updateInput);
            
            // Отправляем форму через AJAX
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(response) {
                    // Парсим HTML ответ
                    const $response = $(response);
                    
                    // Обновляем список товаров корзины
                    const $newCartItems = $response.find('.cart-items');
                    if ($newCartItems.length) {
                        $cartItems.html($newCartItems.html());
                    }
                    
                    // Обновляем итоги корзины
                    const $newCartTotals = $response.find('.cart-totals');
                    if ($newCartTotals.length) {
                        $cartTotals.html($newCartTotals.html());
                    }
                    
                    // Обновляем счётчик товаров в шапке
                    const $newCount = $response.find('.checkout-cart__count');
                    if ($newCount.length) {
                        $('.checkout-cart__count').html($newCount.html());
                    }
                    
                    // Триггерим обновление checkout (для пересчёта доставки)
                    $(document.body).trigger('update_checkout');
                    $(document.body).trigger('updated_cart_totals');
                    
                    console.log('✅ Cart updated successfully (no reload)');
                },
                error: function(xhr, status, error) {
                    console.error('❌ Cart update failed:', error);
                    // При ошибке всё же перезагружаем
                    location.reload();
                },
                complete: function() {
                    // Убираем скрытое поле
                    $updateInput.remove();
                    
                    // Убираем loading состояние
                    setTimeout(() => {
                        $cartItems.removeClass('processing');
                        $cartTotals.removeClass('processing');
                    }, 300);
                }
            });

            console.log('🔄 Cart updating via AJAX...');
        }

        /**
         * Удаление товара из корзины
         */
        removeCartItem(cartItemKey, $btn) {
            const $cartItem = $btn.closest('.cart-item');
            
            // Анимация удаления
            $cartItem.css({
                opacity: 0,
                transform: 'translateX(-20px)'
            });

            setTimeout(() => {
                window.location.href = $btn.attr('href');
            }, 300);

            console.log('🗑️ Removing item from cart:', cartItemKey);
        }

        /**
         * Настройка контролов количества товара
         */
        setupQuantityControls() {
            // Добавляем кнопки +/- для quantity input
            $('.cart-item__quantity .quantity').each(function() {
                const $quantity = $(this);
                const $input = $quantity.find('input[type="number"]');
                
                if ($input.length && !$quantity.find('.qty-btn').length) {
                    const min = parseFloat($input.attr('min')) || 1;
                    const max = parseFloat($input.attr('max')) || 999;
                    
                    // Кнопка минус
                    const $minusBtn = $('<button>', {
                        type: 'button',
                        class: 'qty-btn qty-btn_minus',
                        html: '<i class="fas fa-minus"></i>',
                        css: {
                            width: '36px',
                            height: '36px',
                            border: 'none',
                            background: '#f1f5f9',
                            cursor: 'pointer',
                            transition: 'all 0.3s ease',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center'
                        }
                    });
                    
                    // Кнопка плюс
                    const $plusBtn = $('<button>', {
                        type: 'button',
                        class: 'qty-btn qty-btn_plus',
                        html: '<i class="fas fa-plus"></i>',
                        css: {
                            width: '36px',
                            height: '36px',
                            border: 'none',
                            background: '#f1f5f9',
                            cursor: 'pointer',
                            transition: 'all 0.3s ease',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center'
                        }
                    });
                    
                    // Обработчики
                    $minusBtn.on('click', function() {
                        const currentVal = parseFloat($input.val());
                        if (currentVal > min) {
                            $input.val(currentVal - 1).trigger('change');
                        }
                    });
                    
                    $plusBtn.on('click', function() {
                        const currentVal = parseFloat($input.val());
                        if (currentVal < max) {
                            $input.val(currentVal + 1).trigger('change');
                        }
                    });
                    
                    // Hover эффекты
                    $minusBtn.add($plusBtn).hover(
                        function() {
                            $(this).css('background', '#e2e8f0');
                        },
                        function() {
                            $(this).css('background', '#f1f5f9');
                        }
                    );
                    
                    // Вставляем кнопки
                    $quantity.prepend($minusBtn);
                    $quantity.append($plusBtn);
                }
            });
        }

        /**
         * Настройка формы применения купона
         */
        setupCouponForm() {
            const $couponForm = $('.cart-totals__coupon-form');
            const $couponInput = $('.cart-totals__coupon-input');
            const $couponBtn = $('.cart-totals__coupon-btn');

            $couponForm.on('submit', function(e) {
                // Валидация
                if (!$couponInput.val().trim()) {
                    e.preventDefault();
                    $couponInput.focus();
                    
                    // Анимация встряски
                    $couponInput.css({
                        animation: 'shake 0.5s'
                    });
                    
                    setTimeout(() => {
                        $couponInput.css('animation', '');
                    }, 500);
                    
                    return false;
                }

                // Loading состояние
                $couponBtn.prop('disabled', true);
                $couponBtn.html('<i class="fas fa-spinner fa-spin"></i> <span>Применяем...</span>');
                
                console.log('🎁 Applying coupon:', $couponInput.val());
            });

            // Удаление купона
            $(document).on('click', '.cart-totals__remove-coupon', function() {
                console.log('🗑️ Removing coupon');
            });
        }

        /**
         * Настройка формы оформления заказа
         */
        setupCheckoutForm() {
            const $checkoutForm = $('form.checkout');
            
            if (!$checkoutForm.length) return;

            // Валидация полей в реальном времени
            $checkoutForm.find('input[required], textarea[required]').on('blur', function() {
                const $field = $(this);
                const $formRow = $field.closest('.form-row');
                
                if (!$field.val().trim()) {
                    $formRow.addClass('woocommerce-invalid');
                    $formRow.removeClass('woocommerce-validated');
                } else {
                    $formRow.removeClass('woocommerce-invalid');
                    $formRow.addClass('woocommerce-validated');
                }
            });

            // Валидация email
            $checkoutForm.find('input[type="email"]').on('blur', function() {
                const $field = $(this);
                const $formRow = $field.closest('.form-row');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if ($field.val() && !emailPattern.test($field.val())) {
                    $formRow.addClass('woocommerce-invalid');
                    $formRow.removeClass('woocommerce-validated');
                } else if ($field.val()) {
                    $formRow.removeClass('woocommerce-invalid');
                    $formRow.addClass('woocommerce-validated');
                }
            });

            // Маска для телефона
            const $phoneFields = $checkoutForm.find('input[type="tel"]');
            $phoneFields.on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                
                if (value.length > 0) {
                    if (value.length <= 1) {
                        value = '+7 (' + value;
                    } else if (value.length <= 4) {
                        value = '+7 (' + value.substring(1);
                    } else if (value.length <= 7) {
                        value = '+7 (' + value.substring(1, 4) + ') ' + value.substring(4);
                    } else if (value.length <= 9) {
                        value = '+7 (' + value.substring(1, 4) + ') ' + value.substring(4, 7) + '-' + value.substring(7);
                    } else {
                        value = '+7 (' + value.substring(1, 4) + ') ' + value.substring(4, 7) + '-' + value.substring(7, 9) + '-' + value.substring(9, 11);
                    }
                }
                
                $(this).val(value);
            });

            // Обработка отправки формы
            $checkoutForm.on('submit', function() {
                const $placeOrderBtn = $('#place_order');
                
                // Loading состояние
                $placeOrderBtn.prop('disabled', true);
                $placeOrderBtn.html('<i class="fas fa-spinner fa-spin"></i> Оформляем заказ...');
                
                console.log('📦 Submitting order...');
            });

            // Обновление корзины при изменении способа доставки
            $(document).on('change', 'input[name^="shipping_method"]', function() {
                $('body').trigger('update_checkout');
                console.log('🚚 Shipping method changed');
            });
        }

        /**
         * Настройка плавной прокрутки
         */
        setupSmoothScrolling() {
            // Прокрутка к ошибкам валидации
            $(document).on('checkout_error', function() {
                const $errorElement = $('.woocommerce-error, .woocommerce-message');
                
                if ($errorElement.length) {
                    $('html, body').animate({
                        scrollTop: $errorElement.offset().top - 100
                    }, 500);
                }
            });

            // Прокрутка к форме при клике на шаги
            $('.checkout-steps__item').on('click', function() {
                const stepNumber = $(this).find('.checkout-steps__number').text();
                
                if (stepNumber === '1') {
                    $('html, body').animate({
                        scrollTop: $('.checkout-cart').offset().top - 100
                    }, 500);
                } else if (stepNumber === '2') {
                    $('html, body').animate({
                        scrollTop: $('.checkout-form').offset().top - 100
                    }, 500);
                }
            });
        }

        /**
         * Настройка loading состояний
         */
        setupLoadingStates() {
            // WooCommerce checkout обновление
            $(document).on('checkout_error', function() {
                $('.processing').removeClass('processing');
                $('#place_order').prop('disabled', false)
                               .html('Оформить заказ');
            });

            // AJAX обновление чекаута
            $(document).on('updated_checkout', function() {
                console.log('✅ Checkout updated');
            });

            // AJAX обновление корзины
            $(document).on('updated_wc_div', function() {
                console.log('✅ Cart updated');
                
                // Переинициализация контролов количества
                setTimeout(() => {
                    this.setupQuantityControls();
                }, 100);
            }.bind(this));
        }
    }

    /**
     * Инициализация при загрузке DOM
     */
    $(document).ready(function() {
        // Инициализируем только если мы на странице unified checkout
        if ($('.unified-checkout').length) {
            new UnifiedCheckout();
        }
    });

    /**
     * CSS для анимации встряски
     */
    const shakeAnimation = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    `;
    
    $('<style>').text(shakeAnimation).appendTo('head');

})(jQuery);

