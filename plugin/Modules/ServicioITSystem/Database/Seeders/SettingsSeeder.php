<?php

namespace Plugins\Modules\ServicioITSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Configuraciones iniciales de SERVICIO IT.
     *
     * Usa updateOrInsert para ser idempotente — se puede ejecutar
     * múltiples veces sin duplicar ni sobrescribir cambios manuales.
     */
    public function run(): void
    {
        $this->applyCompanySettings();
        $this->applyCurrencySettings();

        $this->command?->info('✅ SERVICIO IT settings applied.');
    }

    /**
     * Identidad de la empresa (category: general).
     */
    protected function applyCompanySettings(): void
    {
        $settings = [
            'company_name'       => 'SERVICIO IT',
            'company_language'   => 'es_419',
            'company_timezone'   => 'America/Bogota',
            'company_date_format'=> 'd/m/Y',
            'company_portal'     => '1',
            'company_maintenance'=> '0',
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                [
                    'category'   => 'general',
                    'value'      => $value,
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Monedas: COP (default), USD, EUR.
     * Schema: code, prefix, suffix, format, base_rate, is_default
     */
    protected function applyCurrencySettings(): void
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
