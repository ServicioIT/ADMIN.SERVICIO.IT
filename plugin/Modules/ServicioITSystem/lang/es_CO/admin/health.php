<?php

return [
    'description' => 'Monitorear la salud del sistema y las dependencias.',
    'title' => 'Salud del Sistema',
    'database' => 'Database',
    'cache' => 'Cache',
    'environment' => 'Environment',
    'debug_mode' => 'Debug Mode',
    'version' => 'Versión',
    'current_version' => 'Current Versión',
    'latest_version' => 'Latest Versión',
    'php_version' => 'PHP Versión',
    'laravel_version' => 'Framework Versión',
    'status' => [
        'ok' => 'Operational',
        'issue' => 'Issue Detected',
        'enabled' => 'Activard',
        'disabled' => 'Desactivard',
        'up_to_date' => 'Up to Fecha',
        'update_available' => 'Actualizar Available',
        'unknown' => 'Desconocido'
    ],
    'cards' => [
        'database_desc' => 'Database connection status and availability.',
        'cache_desc' => 'Cache driver performance and connectivity.',
        'env_desc' => 'Application running environment.',
        'debug_desc' => 'Diagnostic mode for debugging and logging.',
        'version_desc' => 'Real-time version comparison with official repository.',
        'php_desc' => 'Runtime engine version for PHP.',
        'laravel_desc' => 'Current version of the Laravel framework.'
    ],
    'view_update' => 'View Actualizar'
];
