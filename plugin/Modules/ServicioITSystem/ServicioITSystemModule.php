<?php

namespace Plugins\Modules\ServicioITSystem;

use App\Contracts\ModuleInterface;
use App\Support\AbstractPlugin;

class ServicioITSystemModule extends AbstractPlugin implements ModuleInterface
{
    /**
     * Configuration schema for the admin plugin settings form.
     */
    public function getConfigSchema(): array
    {
        return [
            'company_name' => [
                'type'    => 'text',
                'label'   => 'Nombre de la empresa',
                'helper'  => 'Nombre visible en el panel, emails y facturas.',
                'rules'   => 'required|string|max:255',
                'default' => 'SERVICIO IT',
            ],
            'company_country' => [
                'type'    => 'select',
                'label'   => 'País por defecto',
                'options' => ['CO' => 'Colombia', 'US' => 'Estados Unidos', 'ES' => 'España', 'IT' => 'Italia'],
                'rules'   => 'required|in:CO,US,ES,IT',
                'default' => 'CO',
            ],
            'default_currency' => [
                'type'    => 'select',
                'label'   => 'Moneda por defecto',
                'options' => ['COP' => 'COP — Peso Colombiano', 'USD' => 'USD — Dólar', 'EUR' => 'EUR — Euro'],
                'rules'   => 'required|in:COP,USD,EUR',
                'default' => 'COP',
            ],
            'date_format' => [
                'type'    => 'select',
                'label'   => 'Formato de fecha',
                'options' => [
                    'd/m/Y' => 'd/m/Y (31/12/2026)',
                    'm/d/Y' => 'm/d/Y (12/31/2026)',
                    'Y-m-d' => 'Y-m-d (2026-12-31)',
                ],
                'rules'   => 'required|in:d/m/Y,m/d/Y,Y-m-d',
                'default' => 'd/m/Y',
            ],
        ];
    }

    /**
     * Custom permissions for this module.
     */
    public function getPermissions(): array
    {
        return [
            'modules.servicioit.view',
            'modules.servicioit.manage',
        ];
    }

    /**
     * Admin navigation items (visible en sidebar del admin).
     */
    public function getNavigationAdmin(): array
    {
        return [
            'servicioit' => [
                'label'      => 'SERVICIO IT',
                'icon'       => 'lucide-building-2',
                'route'      => route('admin.modules.servicioitsystem.index'),
                'permission' => 'modules.servicioit.manage',
            ],
        ];
    }

    /**
     * Apply SERVICIO IT config overrides on boot.
     */
    protected function setup(): void
    {
        $this->mergeConfigOverrides();
    }

    /**
     * Merge our custom config values at runtime.
     */
    protected function mergeConfigOverrides(): void
    {
        $customConfig = require __DIR__ . '/config/servicioit.php';

        foreach ($customConfig as $key => $value) {
            config()->set($key, $value);
        }
    }

    /**
     * Register module config for publication.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/servicioit.php', 'servicioit'
        );
    }
}
