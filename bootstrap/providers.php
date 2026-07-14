<?php

$providers = [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuditServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\BillmoraServiceProvider::class,
    App\Providers\CurrencyServiceProvider::class,
    App\Providers\PluginServiceProvider::class,
    App\Providers\SocialiteServiceProvider::class,
    App\Providers\ThemeServiceProvider::class,
];

// Merge SERVICIO IT custom providers (archivo separado para evitar
// conflictos al hacer merge de upstream)
$customProviders = require __DIR__ . '/custom-providers.php';

return array_merge($providers, $customProviders);
