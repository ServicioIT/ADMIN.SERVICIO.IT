<?php

return [
    'amount_label' => 'Monto',
    'cancelled_label' => 'Cancelada',
    'create' => [
        'title' => 'Crear Factura'
    ],
    'credit_label' => 'Crédito',
    'date_label' => 'Fecha',
    'description' => 'Gestionar facturas y transacciones.',
    'due_date_label' => 'Fecha de Vencimiento',
    'edit' => [
        'title' => 'Editar Factura'
    ],
    'index' => [
        'title' => 'Facturas'
    ],
    'invoice_number_label' => 'Número de Factura',
    'items_label' => 'Conceptos',
    'note_label' => 'Nota',
    'overdue_label' => 'Vencida',
    'paid_label' => 'Pagada',
    'partially_paid_label' => 'Parcialmente Pagada',
    'refunded_label' => 'Reembolsada',
    'refund_amount_label' => 'Monto del Reembolso',
    'status_label' => 'Estado',
    'total_label' => 'Total',
    'unpaid_label' => 'No Pagada',
    'user_email_label' => 'Correo del Usuario',
    'user_label' => 'Usuario',
    'view_invoice' => 'Ver Factura',
    'send_invoice' => 'Enviar Factura',
    'mark_as_paid' => 'Marcar como Pagada',
    'mark_as_unpaid' => 'Marcar como No Pagada',
    'refund_invoice' => 'Reembolsar Factura',
    'cancel_invoice' => 'Cancelar Factura',
    'tabs' => [
        'summary' => 'Resumen',
        'transaction' => 'Transaction',
        'refund' => 'Refund'
    ],
    'number_label' => 'Factura Number',
    'user_helper' => 'Select the user this invoice is assigned to.',
    'status_helper' => 'Select the current status of the invoice',
    'date_helper' => 'Set the date when this invoice is issued.',
    'due_date_helper' => 'Set the payment due date for this invoice.',
    'currency_label' => 'Moneda',
    'currency_helper' => 'Select the currency used for this invoice.',
    'email_label' => 'Send Factura Correo Electrónico',
    'email_helper' => 'Activar to notify the user by email when this invoice is created.',
    'invoice_items' => [
        'items_label' => 'Items',
        'items_helper' => 'Add invoice items with description, quantity, and price.',
        'description_label' => 'Descripción',
        'description_helper' => 'Enter a description of the invoice item or service.',
        'quantity_label' => 'Cantidad',
        'quantity_helper' => 'Enter the quantity for this invoice item.',
        'unit_price_label' => 'Unit Precio',
        'unit_price_helper' => 'Enter the price per unit. Use a negative value to apply a discount.'
    ],
    'download_label' => 'Descargar as PDF',
    'add_new_items_label' => 'Add new items',
    'refund' => [
        'type_label' => 'Refund Tipo',
        'type_helper' => 'Select the refund method. Pasarela de Pago processes the refund through the payment gateway, Manual records it manually.',
        'amount_label' => 'Refund Monto',
        'amount_helper' => 'Enter the amount to be refunded from this transaction.',
        'reference_label' => 'Reference Number',
        'reference_helper' => 'Enter the reference number or ID for this refund. Only applicable for manual refunds.',
        'already_fully_refunded' => 'This invoice has already been fully refunded.',
        'no_gateway_associated' => 'No payment gateway is associated with this invoice.',
        'gateway_not_support_refund' => 'The selected gateway does not support automated refunds.',
        'gateway_rejected' => 'The gateway rejected the refund request. Please try again or process it manually.',
        'success' => 'Refund processed successfully.',
        'transaction_description' => 'Refund Processed (:type)',
        'type_gateway' => 'Automatic via Pasarela de Pago',
        'type_manual' => 'Manual Process (External)'
    ]
];
