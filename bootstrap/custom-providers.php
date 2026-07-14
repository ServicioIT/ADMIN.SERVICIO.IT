<?php

/**
 * SERVICIO IT — Custom Service Providers
 * ======================================
 * Este archivo contiene los providers custom que NO forman parte
 * del core de Billmora. Al estar en un archivo separado, sobrevive
 * a merges del upstream sin conflictos.
 *
 * Los módulos de tipo "plugin" (en plugin/Modules/) son auto-descubiertos
 * por PluginServiceProvider desde la base de datos. Este archivo es para
 * providers que NO siguen el patrón de plugins (ej: overrides globales,
 * middlewares custom, bindings del contenedor).
 */

return [
    // Ejemplo: App\Providers\CustomMailProvider::class,
    // Ejemplo: App\Providers\CustomViewServiceProvider::class,
];
