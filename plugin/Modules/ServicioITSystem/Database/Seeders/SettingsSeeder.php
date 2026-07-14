<?php

namespace Plugins\Modules\ServicioITSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Configuraciones iniciales de SERVICIO IT para la tabla `settings`.
     *
     * Usa updateOrInsert para ser idempotente — se puede ejecutar
     * múltiples veces sin duplicar ni sobrescribir cambios manuales
     * (solo inserta si no existe).
     */
    public function run(): void
    {
        $this->applyCompanySettings();
        $this->applyCurrencySettings();
        $this->applyFormatSettings();
        $this->applyPortalSettings();

        $this->command?->info('✅ SERVICIO IT settings applied.');
    }

    /**
     * Identidad de la empresa.
     */
    protected function applyCompanySettings(): void
    {
        $settings = [
            'company_name'     => 'SERVICIO IT',
            'company_language' => 'es_419',
            'company_timezone' => 'America/Bogota',
            'company_portal'   => '1',
            'company_maintenance' => '0',
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }
    }

    /**
     * Monedas: COP (default), USD, EUR.
     */
    protected function applyCurrencySettings(): void
    {
        $currencies = [
            [
                'code'      => 'COP',
                'symbol'    => '$',
                'format'    => '1.234,56',
                'base_rate' => '3342.36',
                'is_default' => true,
            ],
            [
                'code'      => 'USD',
                'symbol'    => '$',
                'format'    => '1,234.56',
                'base_rate' => '1.00',
                'is_default' => false,
            ],
            [
                'code'      => 'EUR',
                'symbol'    => '€',
                'format'    => '1.234,56',
                'base_rate' => '0.876',
                'is_default' => false,
            ],
        ];

        foreach ($currencies as $currency) {
            DB::table('currencies')->updateOrInsert(
                ['code' => $currency['code']],
                array_merge($currency, ['updated_at' => now()])
            );
        }
    }

    /**
     * Formatos regionales (fecha, hora, decimales).
     */
    protected function applyFormatSettings(): void
    {
        $settings = [
            'company_date_format'     => 'd/m/Y',
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }
    }

    /**
     * Portal público — textos en español.
     */
    protected function applyPortalSettings(): void
    {
        $settings = [
            'hero_title'       => 'Haz crecer tu negocio con SERVICIO IT',
            'hero_description' => 'Plataforma gratuita de facturación y gestión para tu negocio.',
            'catalog_title'    => 'Nuestros Catálogos',
            'catalog_description' => '¿Qué quieres comprar?',
            'cta_title'        => '¿Listo para empezar?',
            'cta_description'  => 'Únete a cientos de empresas que confían en SERVICIO IT.',
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }
    }
}
