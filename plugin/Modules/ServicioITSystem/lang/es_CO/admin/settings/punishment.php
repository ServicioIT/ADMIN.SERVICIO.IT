<?php

return [
    'create' => [
        'title' => 'Crear Sanción'
    ],
    'description' => 'Gestionar sanciones y suspensiones de usuarios.',
    'index' => [
        'title' => 'Sanciones'
    ],
    'title' => 'Sanciones',
    'punishment_user_label' => 'Target Usuario',
    'punishment_user_helper' => 'Select the user account to apply the punishment to.',
    'punishment_status_label' => 'Punishment Estado',
    'punishment_status_helper' => 'Choose the type of punishment to apply.',
    'punishment_reason_label' => 'Reason',
    'punishment_reason_helper' => 'Provide a reason for the punishment. This will be visible to the user if you choose to notify them.',
    'punishment_expires_at_label' => 'Expires At',
    'punishment_expires_at_helper' => 'Optional. Set a date and time when the punishment will automatically expire. Leave empty for permanent.',
    'punishment_terminate_services_label' => 'Terminate Todos Servicios',
    'punishment_terminate_services_helper' => 'Immediately terminate all active services owned by this user.',
    'punishment_notify_label' => 'Notify Usuario',
    'punishment_notify_helper' => 'Send an email notification to the user detailing the reason for the punishment.'
];
