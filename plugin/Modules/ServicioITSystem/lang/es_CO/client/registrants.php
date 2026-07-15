<?php

return [
    'domain_label' => 'Dominio',
    'status_label' => 'Estado',
    'registrant_number_label' => 'Registrante Number',
    'registration_date_label' => 'Registration Fecha',
    'expires_label' => 'Expires At',
    'auto_renew_label' => 'Auto Renew',
    'whois_privacy_label' => 'WHOIS Privacy',
    'nameservers_label' => 'Nombreservers',
    'epp_code_label' => 'EPP Code',
    'action' => [
        'overview' => 'Resumen',
        'nameservers' => 'Nombreservers',
        'epp_code' => 'EPP Code',
        'whois_privacy' => 'WHOIS Privacy',
        'failed' => 'Action failed: :message',
        'invalid_type' => 'Invalid action type configured for rendering.',
        'unavailable' => 'This action is not available for this domain.'
    ],
    'nameservers' => [
        'updated' => 'Nombreservers updated successfully.',
        'failed' => 'Fallido to update nameservers: :message'
    ],
    'epp' => [
        'retrieved' => 'EPP code retrieved successfully.',
        'failed' => 'Fallido to retrieve EPP code: :message'
    ],
    'privacy' => [
        'enabled' => 'WHOIS privacy enabled.',
        'disabled' => 'WHOIS privacy disabled.',
        'failed' => 'Fallido to update WHOIS privacy: :message'
    ],
    'auto_renew' => [
        'enabled' => 'Auto-renewal enabled.',
        'disabled' => 'Auto-renewal disabled.'
    ]
];
