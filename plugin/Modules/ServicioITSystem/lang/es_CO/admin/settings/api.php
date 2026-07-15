<?php

return [
    'create_token_button' => 'Crear Token',
    'create' => [
        'title' => 'Crear Token API'
    ],
    'description' => 'Gestionar tokens API para integraciones externas.',
    'index' => [
        'title' => 'API'
    ],
    'token_abilities_helper' => 'Selecciona los permisos que tendrá este token.',
    'token_abilities_label' => 'Habilidades',
    'token_last_used_label' => 'Último Uso',
    'token_name_helper' => 'Un nombre descriptivo para identificar este token.',
    'token_name_label' => 'Nombre',
    'title' => 'API',
    'rate_limit_label' => 'Rate Limit',
    'rate_limit_helper' => 'Máximo requests per minute for this token.',
    'expires_at_label' => 'Expires At',
    'expires_at_helper' => 'Leave empty for a token that never expires.',
    'whitelist_ips_label' => 'Whitelist IP Addresses',
    'whitelist_ips_helper' => 'Comma-separated IP addresses. Leave empty to allow all IPs.',
    'permissions_label' => 'Permisos',
    'permissions_helper' => 'Select which resources and actions this token can access. If none selected, all permissions are granted.',
    'last_used_label' => 'Last Used',
    'token_generated' => 'Your API token has been generated. Copiar it now — it won\'t be shown again.',
    'token_created_success' => 'API token created successfully.',
    'token_regenerated_success' => 'API token regenerated successfully. Copiar the new token above.',
    'all_permissions' => 'Todos',
    'all_ips' => 'Todos',
    'never' => 'Never',
    'regenerate' => 'Regenerate',
    'regenerate_title' => 'Regenerate Token',
    'regenerate_description' => 'This will revoke the current token for :name and create a new one with the same settings. Any applications using the old token will lose access.'
];
