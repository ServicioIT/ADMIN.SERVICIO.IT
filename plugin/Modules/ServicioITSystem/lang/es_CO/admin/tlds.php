<?php

return [
    'create' => [
        'title' => 'Crear TLD'
    ],
    'description' => 'Gestionar precios y disponibilidad de dominios de nivel superior.',
    'edit' => [
        'title' => 'Editar TLD'
    ],
    'index' => [
        'title' => 'TLDs'
    ],
    'tld_label' => 'TLD',
    'tld_helper' => 'Top-level domain extension (e.g. com, net).',
    'register_price_label' => 'Precio de Registro',
    'register_price_helper' => 'Precio de registro.',
    'transfer_price_label' => 'Precio de Transferencia',
    'transfer_price_helper' => 'Precio de transferencia.',
    'renew_price_label' => 'Precio de Renovación',
    'renew_price_helper' => 'Precio de renovación.',
    'min_years_label' => 'Años Mínimos',
    'min_years_helper' => 'Mínimo de años de registro.',
    'max_years_label' => 'Años Máximos',
    'max_years_helper' => 'Máximo de años de registro.',
    'grace_period_label' => 'Grace Period (Days)',
    'grace_period_helper' => 'Number of days after expiration before the domain enters redemption.',
    'redemption_period_label' => 'Redemption Period (Days)',
    'redemption_period_helper' => 'Number of days after grace period before the domain is terminated.',
    'registrar_label' => 'Por defecto Registrador',
    'registrar_helper' => 'Select the default registrar for this TLD.',
    'status_label' => 'Estado',
    'status_helper' => 'Set whether this TLD is visible in the store.',
    'pricing_label' => 'Pricing by Moneda',
    'pricing_helper' => 'Define register, transfer, and renew pricing for each currency.',
    'currency_code_label' => 'Moneda',
    'currency_code_helper' => 'The currency for these prices.',
    'enabled_label' => 'Activard',
    'enabled_helper' => 'Toggle to enable pricing for this currency.',
    'delete' => [
        'has_registrants' => 'Cannot delete TLD that has active registrants.'
    ]
];
