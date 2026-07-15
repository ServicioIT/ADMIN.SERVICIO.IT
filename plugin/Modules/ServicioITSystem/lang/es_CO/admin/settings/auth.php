<?php

return [
    'description' => 'Configurar autenticación, registro y seguridad de usuarios.',
    'social' => [
        'description' => 'Configurar proveedores OAuth para inicio de sesión social.',
        'title' => 'Social',
        'google' => 'Google',
        'discord' => 'Discord',
        'github' => 'GitHub',
        'enabled_label' => 'Activado',
        'enabled_helper' => 'Activar este proveedor de inicio de sesión social.',
        'client_id_label' => 'Cliente ID',
        'client_secret_label' => 'Cliente Secreto'
    ],
    'title' => 'Autenticación',
    'user' => [
        'description' => 'Configurar opciones de registro y verificación de usuarios.',
        'title' => 'Usuario'
    ],
    'tabs' => [
        'user' => 'Usuario',
        'social' => 'Social Iniciar Sesión'
    ],
    'user_registration_label' => 'Usuario Registration',
    'user_registration_helper' => 'Todosow new users to register for an account in the client area.',
    'user_require_verified_label' => 'Usuario Require Verificado',
    'user_require_verified_helper' => 'Require users to verify their email address before accessing the client portal.',
    'user_require_two_factor_label' => 'Require Dos Factores Authentication',
    'user_require_two_factor_helper' => 'Force all users to enable Dos Factores Authentication (2FA) for increased account security.',
    'user_registration_disabled_inputs_label' => 'Desactivard Registration Inputs',
    'user_registration_disabled_inputs_helper' => 'Select the fields to hide from the registration form. Usuarios will not see or fill in these fields.',
    'user_billing_required_inputs_label' => 'Required Facturación Informaciónrmation Inputs',
    'user_billing_required_inputs_helper' => 'Select the fields that users must fill in as required. Unselected fields remain optional.'
];
