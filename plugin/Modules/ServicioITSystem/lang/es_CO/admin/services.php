<?php

return [
    'cancellations' => [
        'description' => 'Gestionar solicitudes de cancelación de servicios.',
        'title' => 'Cancelaciones de Servicio'
    ],
    'description' => 'Gestionar servicios de clientes.',
    'edit' => [
        'title' => 'Editar Servicio'
    ],
    'index' => [
        'title' => 'Servicios'
    ],
    'tabs' => [
        'services' => 'Servicios',
        'cancellations' => 'Cancelarlations'
    ],
    'user_label' => 'Usuario',
    'user_helper' => 'Cliente associated with this service.',
    'name_label' => 'Nombre',
    'name_helper' => 'Nombre of this service.',
    'number_label' => 'Servicio Number',
    'number_helper' => 'Number of this service.',
    'subscription_label' => 'Subscription ID',
    'subscription_helper' => 'Subscription ID of this service.',
    'currency_label' => 'Moneda',
    'currency_helper' => 'Select currency to determine available packages and pricing.',
    'status_label' => 'Estado',
    'status_helper' => 'Set the current status of this service.',
    'recalculate_label' => 'Recalculate on Guardar?',
    'recalculate_helper' => ' Automatically recalculate price and setup fee based on package selection.',
    'expires_label' => 'Expira',
    'expires_helper' => 'Set when this service will expire or next due date.',
    'price_label' => 'Precio',
    'price_helper' => ' Override price manually, not affected when recalculate is enabled.',
    'setup_fee_label' => 'Setup Fee',
    'setup_fee_helper' => ' Override setup fee manually, not affected when recalculate is enabled.',
    'package_configuration_label' => 'Paquete Configuration',
    'package_configuration_helper' => 'Define the base package and billing period for this service.',
    'package_label' => 'Paquete',
    'package_helper' => 'Choose a currency first to view available packages.',
    'billing_cycle_label' => 'Facturación Cycle',
    'billing_cycle_helper' => 'Select a package first to view available billing cycles.',
    'variant_option_label' => 'Variant Options',
    'variant_option_helper' => 'Select additional variants that are available for the chosen package.',
    'additional_configuration_label' => 'Additional Configuration',
    'additional_configuration_helper' => 'Provide any additional configuration required for provisioning this service.',
    'admin_notes_label' => 'Administrador Notas',
    'admin_notes_helper' => 'Internal notes for staff. Visible only to administrators.',
    'cancellation_service_label' => 'Servicio',
    'cancellation_reviewed_by_label' => 'Reviewed By',
    'cancellation_reviewed_at_label' => 'Reviewed At',
    'cancellation_cancelled_at_label' => 'Cancelarled At',
    'cancellation_type_label' => 'Tipo',
    'cancellation_reason_label' => 'Reason',
    'cancellation_rejection_label' => 'Rejection Nota',
    'cancellation' => [
        'approve' => 'Approve',
        'reject' => 'Reject',
        'approved' => 'Cancelarlation request has been approved.',
        'rejected' => 'Cancelarlation request has been rejected.'
    ],
    'catalog_label' => 'Catálogo',
    'go_to_service' => 'Go to Servicio',
    'go_to_user' => 'Go to Usuario',
    'provisioning_actions_label' => 'Aprovisionamiento Actions',
    'provisioning_create_label' => 'Crear',
    'provisioning_suspend_label' => 'Suspend',
    'provisioning_unsuspend_label' => 'Unsuspend',
    'provisioning_terminate_label' => 'Terminate',
    'provisioning_renew_label' => 'Force Renew',
    'provisioning_scale_label' => 'Scale',
    'provisioning' => [
        'create' => [
            'invalid_status' => 'Servicio must be pending or terminated to be created.',
            'success' => 'Servicio created and activated successfully.',
            'failed' => 'Crear failed: :message'
        ],
        'suspend' => [
            'invalid_status' => 'Only active services can be suspended.',
            'success' => 'Servicio suspended successfully.',
            'failed' => 'Suspend failed: :message'
        ],
        'unsuspend' => [
            'invalid_status' => 'Only suspended services can be unsuspended.',
            'success' => 'Servicio unsuspended successfully.',
            'failed' => 'Unsuspend failed: :message'
        ],
        'terminate' => [
            'already_terminated' => 'Servicio is already terminated.',
            'success' => 'Servicio terminated successfully.',
            'failed' => 'Termination failed: :message'
        ],
        'renew' => [
            'invalid_status' => 'Only active or suspended services can be renewed.',
            'success' => 'Servicio renewed on provider successfully.',
            'failed' => 'Renew failed: :message'
        ],
        'scale' => [
            'invalid_status' => 'Only active services can be scaled.',
            'success' => 'Servicio scaled successfully.',
            'failed' => 'Scaling failed: :message'
        ]
    ],
    'delete' => [
        'active_services' => 'Cannot delete an active service. Please terminate or cancel it first to ensure remote resources are cleaned up.'
    ]
];
