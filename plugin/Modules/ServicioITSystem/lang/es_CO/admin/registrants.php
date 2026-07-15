<?php

return [
    'description' => 'Gestionar registros de dominios y registrantes.',
    'edit' => [
        'title' => 'Editar Registrante'
    ],
    'index' => [
        'title' => 'Registrantes'
    ],
    'domain_label' => 'Dominio',
    'domain_helper' => 'Enter the domain name without http/https (e.g. example.com).',
    'status_label' => 'Estado',
    'status_helper' => 'Set the current status of this registration.',
    'user_label' => 'Usuario',
    'user_helper' => 'Select the client that owns this domain.',
    'tld_label' => 'TLD',
    'tld_helper' => 'Select the TLD extension for this domain.',
    'registrar_label' => 'Registrador',
    'registrar_helper' => 'Select the registrar plugin managing this domain.',
    'registration_type_label' => 'Registration Tipo',
    'registration_type_helper' => 'Choose whether this is a new registration or a transfer.',
    'years_label' => 'Years',
    'years_helper' => 'Number of years for this registration.',
    'registered_label' => 'Registered At',
    'registered_helper' => 'The date when this domain was registered.',
    'expires_label' => 'Expira',
    'expires_helper' => 'Set when this domain registration expires.',
    'auto_renew_label' => 'Auto-Renovar',
    'auto_renew_helper' => 'Automatically renew this domain before expiration.',
    'nameservers_label' => 'Servidores de Nombres',
    'nameservers_helper' => 'Personalizado nameservers for this domain.',
    'number_label' => 'Registrante Number',
    'number_helper' => 'Sistema generated unique identifier.',
    'price_label' => 'Precio',
    'price_helper' => 'The recurring price or initial cost of this domain.',
    'go_to_user' => 'Go to Usuario',
    'registrar_actions_label' => 'Registrador Actions',
    'registrar_create_label' => 'Crear',
    'registrar_transfer_label' => 'Transfer',
    'registrar_renew_label' => 'Force Renew',
    'registrar_suspend_label' => 'Suspend',
    'registrar_unsuspend_label' => 'Unsuspend',
    'registrar_sync_label' => 'Sync Estado',
    'registrar' => [
        'create' => [
            'success' => 'Dominio registered successfully.',
            'failed' => 'Registration failed: :message',
            'invalid_status' => 'Dominio must be pending to be registered.'
        ],
        'transfer' => [
            'success' => 'Dominio transfer initiated successfully.',
            'failed' => 'Transfer failed: :message',
            'invalid_status' => 'Dominio must be pending transfer.'
        ],
        'renew' => [
            'success' => 'Dominio renewed successfully.',
            'failed' => 'Renewal failed: :message',
            'invalid_status' => 'Only active or expired domains can be renewed.'
        ],
        'suspend' => [
            'success' => 'Dominio suspended successfully.',
            'failed' => 'Suspension failed: :message',
            'invalid_status' => 'Dominio must be active to be suspended.'
        ],
        'unsuspend' => [
            'success' => 'Dominio unsuspended successfully.',
            'failed' => 'Unsuspension failed: :message',
            'invalid_status' => 'Dominio must be suspended to be unsuspended.'
        ],
        'sync' => [
            'success' => 'Dominio status synced from registrar.',
            'failed' => 'Sync failed: :message'
        ]
    ],
    'delete' => [
        'active_registrant' => 'Cannot delete an active domain. Please terminate it first.'
    ]
];
