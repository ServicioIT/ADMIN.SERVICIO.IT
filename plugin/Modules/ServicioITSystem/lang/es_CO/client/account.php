<?php

return [
    'update_email_label' => 'Actualizar Correo Electrónico',
    'new_email_label' => 'New Correo Electrónico',
    'update_password_label' => 'Actualizar Contraseña',
    'current_password_label' => 'Current Contraseña',
    'new_password_label' => 'New Contraseña',
    'confirm_new_password_label' => 'Confirmar New Contraseña',
    'credits' => [
        'currency_label' => 'Moneda',
        'amount_label' => 'Monto',
        'payment_method_label' => 'Pago Method',
        'no_credits' => 'You have no credits.',
        'deposit_submit' => 'Deposit',
        'deposit_success' => 'Factura for deposit credits has been generated. Please complete your payment.',
        'insufficient_balance' => 'Insufficient credit balance in :currency wallet.',
        'deposit_exceeds_max_balance' => 'This deposit exceeds your maximum allowed wallet balance of :max_balance.'
    ],
    'auto_credit_payment' => [
        'title' => 'Pago Preferences',
        'label' => 'Auto Crédito Pago',
        'helper' => 'Automatically pay new invoices using your available credit balance. When enabled, invoices will be settled from your credit wallet upon generation.'
    ],
    'sessions' => [
        'title' => 'Activo Sessions',
        'description' => 'Manage and revoke your active sessions across devices. If necessary, you may revoke all of your other sessions.',
        'current' => 'This device',
        'revoke' => 'Revoke',
        'revoke_others' => 'Revoke Otro Sessions',
        'revoke_success' => 'Session has been revoked.',
        'revoke_others_success' => 'Todos other sessions have been revoked.',
        'revoke_failed' => 'Session not found or already revoked.',
        'cannot_revoke_current' => 'You cannot revoke your current session.',
        'last_active' => 'Last active :time'
    ]
];
