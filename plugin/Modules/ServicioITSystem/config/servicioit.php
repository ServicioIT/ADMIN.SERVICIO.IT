<?php

/**
 * SERVICIO IT — Configuraciones corporativas
 * ============================================
 * Estas configuraciones complementan las que se almacenan en la base de datos
 * (tabla `settings`). Se aplican en el boot del módulo ServicioITSystem.
 *
 * Las configuraciones de base de datos (company_name, moneda, formatos, portal)
 * se aplican vía el seeder SettingsSeeder.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Identidad corporativa
    |--------------------------------------------------------------------------
    */
    'app.name'            => 'SERVICIO IT',
    'app.url'             => 'https://admin.servicio.it',
    'app.timezone'        => 'America/Bogota',
    'app.locale'          => 'es',
    'app.fallback_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    */
    'mail.from.address' => 'soporte@servicio.it',
    'mail.from.name'    => 'SERVICIO IT',

    /*
    |--------------------------------------------------------------------------
    | Formatos regionales
    |--------------------------------------------------------------------------
    */
    'servicioit.date_format'      => 'd/m/Y',
    'servicioit.default_country'  => 'CO',
    'servicioit.default_currency' => 'COP',

    /*
    |--------------------------------------------------------------------------
    | URLs externas
    |--------------------------------------------------------------------------
    */
    'servicioit.support_url' => 'https://estado.servicio.it',
    'servicioit.website_url' => 'https://servicio.it',
    'servicioit.billing_url' => 'https://cobros.servicio.it',

];
