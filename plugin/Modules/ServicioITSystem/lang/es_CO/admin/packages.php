<?php

return [
    'create' => [
        'title' => 'Crear Paquete'
    ],
    'description' => 'Crear y gestionar paquetes de productos.',
    'edit' => [
        'title' => 'Editar Paquete'
    ],
    'fields' => [
        'description' => 'Agregar campos personalizados a los paquetes.',
        'title' => 'Campos del Paquete',
        'label' => 'Label',
        'label_helper' => 'Etiqueta del campo que se muestra al cliente.',
        'name' => 'Internal Nombre',
        'name_helper' => 'Nombre interno del campo.',
        'type' => 'Tipo',
        'type_helper' => 'Tipo de campo de entrada.',
        'helper' => 'Helper Text',
        'helper_helper' => 'Optional text displayed below the field to guide the user.',
        'default' => 'Por defecto Value',
        'default_helper' => 'Optional default value to pre-fill the field.',
        'required' => 'Required',
        'required_helper' => 'Hacer que este campo sea obligatorio.',
        'visible_on_order' => 'Show on Pedido Form',
        'visible_on_order_helper' => 'Show this field to customers during the checkout process.',
        'visible_on_invoice' => 'Show on Factura',
        'visible_on_invoice_helper' => 'Show this field and its value on the customer\'s invoice.',
        'options' => 'Options',
        'options_helper' => 'One option per line. Separate value and label with a pipe (|). If no pipe, the value is used as the label.',
        'condition_target' => 'Condition Target',
        'condition_target_helper' => 'Select whether the condition depends on a package field or an additional configuration.',
        'condition_field' => 'Target Field Nombre',
        'condition_field_helper' => 'Enter the exact name (key) of the target field.',
        'condition_operator' => 'Operator',
        'condition_operator_helper' => 'Select the comparison operator.',
        'condition_value' => 'Expected Value',
        'condition_value_helper' => 'The value to compare against. For "In List" or "Not In List", separate values with commas.'
    ],
    'hidden_helper' => 'Ocultar este paquete de la tienda.',
    'hidden_label' => 'Oculto',
    'index' => [
        'title' => 'Paquetes'
    ],
    'name_helper' => 'El nombre público de este paquete.',
    'name_label' => 'Nombre',
    'pricing' => [
        'description' => 'Configurar precios y ciclos de facturación.',
        'title' => 'Precios del Paquete',
        'name_label' => 'Nombre',
        'name_helper' => 'Enter the name for this pricing option.',
        'type_label' => 'Tipo',
        'type_helper' => 'Select the type of pricing for this package.',
        'time_interval_label' => 'Hora Interval',
        'time_interval_helper' => 'Choose the billing interval for this pricing option.',
        'billing_period_label' => 'Facturación Period',
        'billing_period_helper' => 'Select how often the customer will be billed for this package.',
        'currency_code_label' => 'Moneda Code',
        'currency_code_helper' => 'Displays the currency used for this price. This value cannot be changed here.',
        'price_label' => 'Precio',
        'price_helper' => 'El precio de este ciclo de facturación.',
        'setup_fee_label' => 'Tarifa de Configuración',
        'setup_fee_helper' => 'Tarifa única de configuración cobrada al activar.',
        'enabled_label' => 'Activard?',
        'enabled_helper' => 'Activar or disable this pricing option without deleting it.'
    ],
    'provisioning' => [
        'title' => 'Configuración de Aprovisionamiento',
        'instance_label' => 'Aprovisionamiento Instance',
        'instance_helper' => 'Select the provisioning instance to link with this package.',
        'unavailable_schema' => 'This provisioning instance has no schema options for packages.'
    ],
    'scaling' => [
        'title' => 'Configuración de Escalado',
        'target_packages_label' => 'Scalable To',
        'target_packages_helper' => 'Select the packages that this package can be scaled up or down to.'
    ],
    'tabs' => [
        'summary' => 'Resumen',
        'pricing' => 'Pricing',
        'provisioning' => 'Aprovisionamiento',
        'scaling' => 'Scaling',
        'fields' => 'Fields'
    ],
    'catalog_label' => 'Catálogo',
    'catalog_helper' => 'El catálogo al que pertenece este paquete.',
    'slug_label' => 'Slug',
    'slug_helper' => 'Enter a unique URL-friendly identifier for this package. It will be used in product URLs.',
    'description_label' => 'Descripción',
    'description_helper' => 'Provide a brief description of the package. HTML element supported.',
    'icon_label' => 'Icon',
    'icon_helper' => 'Choose an icon file to represent the package.',
    'stock_label' => 'Existencia',
    'stock_helper' => 'Cantidad de stock disponible. Déjalo vacío para ilimitado.',
    'per_user_limit_label' => 'Per Usuario Limit',
    'per_user_limit_helper' => 'Set the maximum number of this package a single user can purchase. Use -1 for no limit.',
    'allow_cancellation_label' => 'Todosow Cancelarlation',
    'allow_cancellation_helper' => 'Activar to let customers request service cancellation for this package.',
    'prorata_day_label' => 'Prorata Day',
    'prorata_day_helper' => 'Enter a day (1-28) to enable pro-rata billing, or leave empty to disable.',
    'prorata_next_month_day_label' => 'Charge Siguiente Month',
    'prorata_next_month_day_helper' => 'Charge for the next month if ordered on or after this day (1-28). Leave empty to disable.',
    'allow_quantity_label' => 'Todosow Cantidad',
    'allow_quantity_helper' => 'Activar to let customers purchase multiple or single quantities of this package.',
    'auto_provision_label' => 'Auto Aprovisionamiento',
    'auto_provision_helper' => 'Activar to automatically run provisioning and activate the service upon invoice payment.',
    'status_label' => 'Estado',
    'status_helper' => 'Set the status of the package to visible or hidden.',
    'status_options' => [
        'visible' => 'Visible',
        'hidden' => 'Hidden'
    ],
    'delete' => [
        'has_services' => 'Cannot delete package that has active services.'
    ]
];
