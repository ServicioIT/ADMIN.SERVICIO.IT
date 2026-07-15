<?php

return [
    'title' => 'Facturas',
    'invoice_number_label' => 'Factura Number',
    'invoice_date_label' => 'Factura Fecha',
    'due_date_label' => 'Due Fecha',
    'total_label' => 'Total',
    'download_label' => 'Descargar as PDF',
    'invoice_label' => 'Factura #:number',
    'payment_label' => 'Pago Method',
    'payment_process_label' => 'Proceed to Pago',
    'bill_to_label' => 'Bill To',
    'issued_to_label' => 'Issued To',
    'invoice_items_label' => 'Factura Items',
    'description_label' => 'Descripción',
    'quantity_label' => 'Cantidad',
    'unit_price_label' => 'Unit Precio',
    'amount_label' => 'Monto',
    'subtotal_label' => 'Subtotal',
    'discount_label' => 'Descuento',
    'total_due_label' => 'Total Due',
    'currency_label' => 'Moneda',
    'prorated_item' => ':item - Prorated (:start – :end)',
    'status' => [
        'unpaid' => 'No Pagado',
        'paid' => 'Pagado',
        'cancelled' => 'Cancelarled',
        'refunded' => 'Reembolsado'
    ],
    'payment' => [
        'already_processed' => 'This invoice ha sido pagado or cancelled.',
        'method_required' => 'Please select a payment method first.',
        'invalid_method' => 'Pago method is invalid.'
    ],
    'credit' => [
        'available' => 'Available Crédito:',
        'submit_payment' => 'Settle with Crédito Saldo',
        'cannot_pay_deposit' => 'Crédito balance cannot be used to pay a Crédito Deposit invoice.',
        'insufficient_balance' => 'You do not have sufficient credit balance to complete this payment.',
        'fully_settled' => 'Your invoice has been fully settled using your credit balance.',
        'partially_applied' => 'Crédito balance applied. Please pay the remaining amount due.',
        'transaction_description' => 'Crédito Saldo Applied',
        'auto_credit_payment_description' => 'Auto Crédito Pago Applied'
    ]
];
