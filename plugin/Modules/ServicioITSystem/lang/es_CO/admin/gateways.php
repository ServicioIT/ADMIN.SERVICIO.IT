<?php

return [
    'create' => [
        'title' => 'Crear Pasarela de Pago'
    ],
    'description' => 'Configurar pasarelas de pago para procesar transacciones.',
    'edit' => [
        'title' => 'Editar Pasarela de Pago'
    ],
    'index' => [
        'title' => 'Pasarelas de Pago'
    ],
    'name_label' => 'Nombre',
    'name_helper' => 'Enter a unique name to identify this instance.',
    'provider_label' => 'Provider',
    'provider_helper' => 'Select the gateway provider to use for this instance.',
    'is_active_label' => 'Activa',
    'is_active_helper' => 'Activar o desactivar esta pasarela de pago.',
    'version_label' => 'Versión',
    'author_label' => 'Author',
    'webhook_url_title' => 'Webhook / Callback URL',
    'webhook_url_description' => 'If your payment gateway requires a webhook or callback URL to notify the system about payment statuses, please explicitly use the URL below.',
    'delete' => [
        'in_use' => 'This gateway cannot be deleted because it is associated with existing invoices or transactions.'
    ],
    'disable' => [
        'in_use' => 'This gateway cannot be disabled because it is currently in use.'
    ]
];
