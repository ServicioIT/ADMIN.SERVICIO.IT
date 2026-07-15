<?php

return [
    'description' => 'Configurar protección CAPTCHA para formularios.',
    'placement' => [
        'title' => 'Ubicación'
    ],
    'provider' => [
        'title' => 'Proveedor'
    ],
    'title' => 'CAPTCHA',
    'tabs' => [
        'provider' => 'Provider',
        'placement' => 'Placement'
    ],
    'provider_type_label' => 'Captcha Provider',
    'provider_type_helper' => 'Select the captcha service provider to use for form verification.',
    'provider_site_key_label' => 'Site Clave',
    'provider_site_key_helper' => 'Enter the site key provided by your captcha service.',
    'provider_secret_key_label' => 'Secreto Clave',
    'provider_secret_key_helper' => 'Enter the secret key provided by your captcha service.',
    'placements_enabled_forms_label' => 'Activard Forms',
    'placements_enabled_forms_helper' => 'Select the forms where captcha verification should be enabled.'
];
