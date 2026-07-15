<?php

namespace Plugins\Modules\ServicioITSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Configuraciones de SERVICIO IT.
     * Idempotente — updateOrInsert permite re-ejecución segura.
     */
    public function run(): void
    {
        $this->applyCompanyIdentity();
        $this->applyPortalTexts();
        $this->applyCurrencies();

        $this->command?->info('✅ SERVICIO IT — identidad, portal y monedas aplicados.');
    }

    /**
     * Identidad corporativa (category: general).
     */
    protected function applyCompanyIdentity(): void
    {
        $settings = [
            'company_name'        => 'SERVICIO IT',
            'company_description' => 'Plataforma de facturación, administración y control total para tu negocio.',
            'company_language'    => 'es',              // 'es_419' rompe el flag del header
            'company_timezone'    => 'America/Bogota',
            'company_date_format' => 'd/m/Y',
            'company_portal'      => '1',
            'company_maintenance' => '0',
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['category' => 'general', 'value' => $value, 'updated_at' => now()]
            );
        }
    }

    /**
     * Portal público — textos en español.
     */
    protected function applyPortalTexts(): void
    {
        $portal = [
            'hero_title'          => 'Haz crecer tu negocio con SERVICIO IT',
            'hero_description'    => 'Plataforma gratuita de facturación y gestión para tu negocio.',
            'catalog_title'       => 'Nuestros Catálogos',
            'catalog_description' => '¿Qué quieres comprar?',
            'cta_title'           => '¿Listo para empezar?',
            'cta_description'     => 'Únete a cientos de empresas que confían en SERVICIO IT.',
        ];

        foreach ($portal as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['category' => 'general', 'value' => $value, 'updated_at' => now()]
            );
        }
    }

    /**
     * Monedas: COP (default), USD, EUR.
     */
    protected function applyCurrencies(): void
    {
        $currencies = [
            [
                'code'       => 'COP',
                'prefix'     => '$ ',
                'suffix'     => ' COP',
                'format'     => '1.234,56',
                'base_rate'  => 3342.36,
                'is_default' => true,
            ],
            [
                'code'       => 'USD',
                'prefix'     => '$ ',
                'suffix'     => ' USD',
                'format'     => '1,234.56',
                'base_rate'  => 1.00,
                'is_default' => false,
            ],
            [
                'code'       => 'EUR',
                'prefix'     => '',
                'suffix'     => ' €',
                'format'     => '1.234,56',
                'base_rate'  => 0.876,
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
}
