<?php

return [
    'description' => 'Actualizar Billmora a la última versión.',
    'index' => [
        'title' => 'Actualización del Sistema'
    ],
    'progress' => [
        'title' => 'Progreso de Actualización',
        'running' => 'En Progreso',
        'completed' => 'Completado',
        'failed' => 'Fallido',
        'log_title' => 'Actualizar Log',
        'log_description' => 'Real-time update process output.',
        'waiting' => 'Waiting for update process to start...',
        'success_title' => 'Actualizar Éxitoful',
        'success_message' => 'The system has been successfully updated to v:version.',
        'failed_title' => 'Actualizar Fallido',
        'failed_message' => 'The update process encountered an error. Mantenimiento mode has been disabled automatically. Please check the logs above for details.',
        'stale_title' => 'Actualizar Process Unresponsive',
        'stale_message' => 'The update process has been running for more than 15 minutes without responding. It may have crashed. Please check storage/logs/laravel.log for details, verify the server state, and try again if necessary.'
    ],
    'title' => 'Sistema Actualizar',
    'check_complete' => 'Versión check completed.',
    'no_update' => 'Your system is already up to date.',
    'requirements_not_met' => 'Sistema requirements are not met. Please resolve the issues before updating.',
    'version' => [
        'current' => 'Current Versión',
        'latest' => 'Latest Versión',
        'up_to_date' => 'Up to Fecha',
        'update_available' => 'Actualizar Available',
        'unknown' => 'Unable to Check'
    ],
    'release' => [
        'title' => 'What\'s New in :version',
        'published' => 'Published on :date',
        'view_github' => 'View on GitHub',
        'no_notes' => 'No release notes available.'
    ],
    'requirements' => [
        'title' => 'Sistema Requirements',
        'description' => 'Todos requirements must be satisfied before updating.',
        'label' => 'Requirement',
        'required' => 'Required',
        'current' => 'Current',
        'status' => 'Estado',
        'passed' => 'Passed',
        'failed' => 'Fallido',
        'items' => [
            'php_version' => 'PHP Versión',
            'phar_extension' => 'Phar Extension',
            'composer' => 'Composer',
            'disk_space' => 'Available Disk Space',
            'writable' => 'Application Directory'
        ],
        'values' => [
            'enabled' => 'Activard',
            'disabled' => 'Desactivard',
            'available' => 'Disponible',
            'not_found' => 'Not Found',
            'writable' => 'Writable',
            'read_only' => 'Read Only'
        ]
    ],
    'actions' => [
        'check' => 'Check for Actualizars',
        'update' => 'Actualizar to :version',
        'confirm_title' => 'Confirmar Actualizar',
        'confirm_message' => 'Está seguro you want to update to :version? Please ensure you have backed up your database before proceeding. The system will enter maintenance mode during the update.',
        'confirm_button' => 'Sí, Actualizar Now',
        'cancel_button' => 'Cancelar'
    ],
    'warning' => [
        'title' => 'Before You Actualizar',
        'backup' => 'Please make sure to backup your database and application files before proceeding with the update.'
    ],
    'maintenance_message' => 'Sistema is being updated. Please check back shortly.',
    'steps' => [
        'no_update' => 'No update available.',
        'maintenance_enabling' => 'Activando modo mantenimiento...',
        'maintenance_enabled' => 'Mantenimiento mode enabled.',
        'downloading' => 'Descargaring release v:version...',
        'download_complete' => 'Descargar complete.',
        'extracting' => 'Extrayendo archivos...',
        'extracted' => 'Files extracted and applied.',
        'composer_installing' => 'Instalaring dependencies (composer install)...',
        'composer_installed' => 'Dependencies installed.',
        'migrations_running' => 'Running database migrations...',
        'migrations_complete' => 'Migrations complete.',
        'cache_clearing' => 'Limpiaring application cache...',
        'cache_cleared' => 'Cache cleared.',
        'optimizing' => 'Optimizing application...',
        'optimized' => 'Optimization complete.',
        'queue_restarting' => 'Reiniciando trabajadores de cola...',
        'queue_restarted' => 'Queue workers restarted.',
        'maintenance_disabling' => 'Disabling maintenance mode...',
        'maintenance_disabled' => 'Mantenimiento mode disabled.',
        'cleanup' => 'Cleaning up temporary files...',
        'cleanup_complete' => 'Cleanup complete.',
        'completed' => 'Actualizar to v:version completed successfully!',
        'error' => 'Error: :message',
        'maintenance_disabled_after_error' => 'Mantenimiento mode disabled after error.'
    ],
    'updating_title' => 'Updating Billmora',
    'updating_subtitle' => 'Applying update :version — please do not close this page.',
    'update_success' => 'Éxitofully updated to v:version!',
    'update_failed' => 'La actualización falló.',
    'update_already_running' => 'An update is already in progress.',
    'back_to_update' => 'Volver to Actualizar Page'
];
