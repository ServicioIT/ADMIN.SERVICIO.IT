<?php

return [
    'create' => [
        'title' => 'Crear Transacción'
    ],
    'description' => 'Gestionar transacciones financieras.',
    'index' => [
        'title' => 'Transacciones'
    ],
    'user_label' => 'Usuario',
    'user_helper' => 'Select the user associated with this transaction.',
    'invoice_label' => 'Factura',
    'invoice_helper' => 'Select the invoice for this transaction. Its currency will be used for amount and fee.',
    'gateway_label' => 'Pasarela',
    'gateway_helper' => 'Select the payment gateway used to process this transaction.',
    'reference_label' => 'Reference Code',
    'reference_helper' => 'Enter the reference code or transaction ID provided by the payment gateway.',
    'amount_label' => 'Monto',
    'amount_helper' => 'Enter the total amount charged for this transaction.',
    'fee_label' => 'Fee',
    'fee_helper' => 'Enter the processing fee applied to this transaction.',
    'description_label' => 'Descripción',
    'description_helper' => 'Provide notes or details about this transaction.'
];
