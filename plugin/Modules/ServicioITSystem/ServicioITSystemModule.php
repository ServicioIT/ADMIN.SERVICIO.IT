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
     * Admin navigation — deshabilitado temporalmente (ruta no definida).
     */
    public function getNavigationAdmin(): array
    {
        return [];
    }

    /**
     * Apply SERVICIO IT config overrides on boot.
     */
    protected function setup(): void
    {
        $this->mergeConfigOverrides();
        $this->publishTranslations();
        $this->checkAndRestore();
    }

    /**
     * Auto-detecte y restaura assets del tema tras one-click update.
     * Si el CSS no existe, copia de Moraine + aplica rosa.
     */
    protected function checkAndRestore(): void
    {
        $needsRestore = false;
        foreach (['admin', 'client', 'portal'] as $type) {
            $css = base_path("public/themes/{$type}/servicioit/css/style.css");
            if (!file_exists($css) || filesize($css) < 50000) {
                $needsRestore = true;
                break;
            }
        }

        if ($needsRestore && file_exists(base_path('scripts/restore-after-update.sh'))) {
            exec('bash ' . base_path('scripts/restore-after-update.sh') . ' 2>&1', $output, $code);
            if ($code === 0) {
                \Illuminate\Support\Facades\Log::info('ServicioIT: Assets restaurados automáticamente.');
            }
        }
    }

    /**
     * Sync Spanish translations from plugin to lang directory
     * so root-namespace __() calls find them.
     */
    protected function publishTranslations(): void
    {
        $source = $this->pluginPath . '/lang/es_CO';
        $target = base_path('lang/es_CO');

        if (is_dir($source) && is_dir($target)) {
            $files = glob($source . '/*.php');
            foreach ($files as $file) {
                $name = basename($file);
                if (!file_exists($target . '/' . $name) 
                    || md5_file($file) !== md5_file($target . '/' . $name)) {
                    copy($file, $target . '/' . $name);
                }
            }
            // Also sync subdirectories
            $dirs = glob($source . '/*', GLOB_ONLYDIR);
            foreach ($dirs as $dir) {
                $sub = basename($dir);
                $this->syncDir($dir, $target . '/' . $sub);
            }
        }
    }

    protected function syncDir(string $source, string $target): void
    {
        if (!is_dir($target)) {
            mkdir($target, 0755, true);
        }
        $files = glob($source . '/*.php');
        foreach ($files as $file) {
            $name = basename($file);
            if (!file_exists($target . '/' . $name)
                || md5_file($file) !== md5_file($target . '/' . $name)) {
                copy($file, $target . '/' . $name);
            }
        }
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
