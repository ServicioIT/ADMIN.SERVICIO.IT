<?php

return [
    'coupon_label' => 'Cupón',
    'notes_label' => 'Notas',
    'payment_label' => 'Pago Method',
    'agree_terms' => 'I agree with the :attribute',
    'order_summary' => 'Pedido Resumen',
    'subtotal' => 'Subtotal',
    'setup_fee' => 'Setup Fee',
    'discount' => 'Descuento',
    'total_due' => 'Total Due',
    'next_billing' => 'Precio that will be charged on the next billing cycle',
    'complete_order' => 'Complete Pedido',
    'cart' => [
        'review_order' => 'Review Your Pedido',
        'contiue_shopping' => 'Continue Shopping',
        'empty' => 'Tu carrito está vacío.',
        'empty_message' => 'Looks like you haven\'t added any services to your cart yet.',
        'item_not_found' => 'Item not found in cart.',
        'item_added' => 'Item added to cart successfully.',
        'item_removed' => 'Item removed from cart successfully.',
        'items_removed_currency_mismatch' => 'One or more items in your cart are not supported by the selected currency and have been removed.'
    ],
    'coupon' => [
        'invalid' => 'Invalid or expired coupon code.',
        'cart_mismatch' => 'This coupon is not applicable to any items in your cart.',
        'limit_reached' => 'This coupon has reached its usage limit.',
        'user_limit_reached' => 'You have reached the usage limit for this coupon.',
        'new_client_only' => 'This coupon is only valid for new clients with no previous orders.',
        'existing_client_only' => 'This coupon is only valid for existing clients with previous orders.',
        'applied' => 'Cupón applied successfully!',
        'removed' => 'Cupón removed successfully.'
    ],
    'complete' => [
        'heading' => 'Thank you for your order!',
        'message' => 'Tu pedido ha sido completado exitosamente.',
        'information' => 'Your order number is #:order_number.',
        'unpaid_note' => 'Your order is currently unpaid. Please complete the payment to activate your services.',
        'view_invoice' => 'Ver Factura',
        'back_to_client' => 'Volver to Cliente Area'
    ],
    'session' => [
        'expired' => 'Your checkout session has expired. Please add items to your cart and try again.',
        'missing_data' => 'No checkout data found. Please select a package first.',
        'currency_mismatch' => 'The selected configuration is not available for the current currency. Please select again.'
    ],
    'validation_unavailable' => 'Validation service is currently unavailable. Please try again.'
];
