<?php

namespace Plugins\Modules\ServicioITSystem;

use App\Contracts\ModuleInterface;
use App\Support\AbstractPlugin;
use Illuminate\Support\Facades\Event;

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
                'helper'  => 'País principal de operación.',
                'options' => ['CO' => 'Colombia', 'US' => 'Estados Unidos', 'ES' => 'España', 'IT' => 'Italia'],
                'rules'   => 'required|in:CO,US,ES,IT',
                'default' => 'CO',
            ],
            'default_currency' => [
                'type'    => 'select',
                'label'   => 'Moneda por defecto',
                'helper'  => 'Moneda principal para facturación.',
                'options' => ['COP' => 'COP — Peso Colombiano', 'USD' => 'USD — Dólar', 'EUR' => 'EUR — Euro'],
                'rules'   => 'required|in:COP,USD,EUR',
                'default' => 'COP',
            ],
            'date_format' => [
                'type'    => 'select',
                'label'   => 'Formato de fecha',
                'helper'  => 'Formato usado en todo el sistema.',
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
     * Admin navigation items.
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
     * Events subscribed by this module.
     * Hook into Billmora's lifecycle to apply our customizations.
     */
    public function getSubscribedEvents(): array
    {
        return [
            // Hook into system boot to apply settings
            \Illuminate\Foundation\Events\VendorTagPublished::class => 'onSystemBoot',
        ];
    }

    /**
     * Apply SERVICIO IT customizations on boot.
     */
    public function onSystemBoot($event): void
    {
        // Placeholder for event-driven customizations
    }

    /**
     * Additional setup: apply config overrides, register custom views, etc.
     */
    protected function setup(): void
    {
        // Override default config values from our module
        $this->mergeConfigOverrides();

        // Register custom admin views that extend core Billmora views
        $this->registerCustomViews();
    }

    /**
     * Merge SERVICIO IT configuration overrides at runtime.
     * These complement (not replace) the database settings.
     */
    protected function mergeConfigOverrides(): void
    {
        $customConfig = require __DIR__ . '/config/servicioit.php';

        foreach ($customConfig as $key => $value) {
            config()->set($key, $value);
        }
    }

    /**
     * Register additional view paths so our custom views take priority
     * over the core Billmora views when they share the same name.
     */
    protected function registerCustomViews(): void
    {
        // Our views are already registered via AbstractPlugin as "module.servicioitsystem"
        // Additional overrides for core views can be done via View::composer or View::prependLocation
        $customViewsPath = $this->pluginPath . '/resources/views';

        if (is_dir($customViewsPath)) {
            // Prepend our views so they're checked first
            app('view')->getFinder()->prependLocation($customViewsPath);
        }
    }

    /**
     * Register module services.
     */
    public function register()
    {
        // Merge our config file
        $this->mergeConfigFrom(
            __DIR__ . '/config/servicioit.php', 'servicioit'
        );
    }
}
