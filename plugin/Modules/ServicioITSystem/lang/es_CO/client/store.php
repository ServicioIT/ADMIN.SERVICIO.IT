<?php

return [
    'view_package' => 'Ver Paquete',
    'view_store' => 'Ver Tienda',
    
    'order_now' => 'Ordenar Ahora',
    'order_unavailable' => 'Pedido No Disponible',
    'order_out_of_stock' => 'Agotado',

    'stock_unavailable' => ':item Agotado',
    'stock_available' => ':item Disponible',

    'package' => [
        'billing_cycle' => 'Ciclo de facturación',
        'configuration' => 'Configuración',
        'order_summary' => 'Resumen del Pedido',
        'subtotal' => 'Subtotal',
        'setup_fee' => 'Tarifa de Configuración',
        'due_today' => 'Total a Pagar Hoy',
        'next_billing' => 'Precio que se cobrará en el próximo ciclo de facturación',
        'add_to_cart' => 'Agregar al Carrito',
        'checkout' => 'Finalizar Compra',
    ],

    'order' => [
        'cycle_mismatch' => 'El ciclo de facturación seleccionado no pertenece al paquete elegido.',
        'cycle_currency_unavailable' => 'The selected billing cycle is not available for your selected currency.',
        'variant_mismatch' => 'One or more selected variants do not belong to this package.',
        'variant_price_missing' => 'One or more selected variants do not have prices for the selected billing cycle.',
        'option_invalid' => 'One or more selected options are invalid or do not belong to this package.',
        'option_missing' => 'One or more selected options were not found.',
        'option_unavailable' => 'The option ":attribute" is not available for the selected billing cycle and currency.',
    ],

    'unavailable_currency' => 'No disponible en esta moneda.',

    'domain_search_label' => 'Buscar Dominio',
    'domain_search_placeholder' => 'Registro de dominio por 1 año con todas las ventajas de Cloudflare: DNS ultrarrápido, CDN global, SSL, protección DDoS, proxy y WAF.',
    'domain_register_tab' => 'Registrar',
    'domain_transfer_tab' => 'Transferir',
    'domain_available' => '¡Disponible!',
    'domain_unavailable' => 'No Disponible',
    'domain_taken' => 'Ocupado',
    'domain_premium' => 'Premium',
    'domain_add_to_cart' => 'Agregar al Carrito',
    'domain_epp_code_label' => 'Código EPP / Autorización',
    'domain_epp_code_helper' => 'Requerido para transferencia de dominio. Solicítalo a tu registrador actual.',
    'domain_years_label' => 'Período de Registro',
    'domain_year' => 'Año',
    'domain_years' => 'Años',
    'domain_year_option' => ':count Año|:count Años',
    'domain_disabled' => 'El registro y transferencia de dominios no están disponibles actualmente.',
    'domain_configure_helper' => 'Configura tu dominio a continuación. Puedes especificar servidores de nombres personalizados o usar los predeterminados.',
    'domain_nameservers_label' => 'Servidores de Nombres',
    'domain_nameservers_helper' => 'If you want to use custom nameservers then enter them below. By default, new domains will use our nameservers for hosting on our network.',
    'domain_nameserver_label' => 'Servidor de Nombres :number',
    'domain_recommendations' => 'Recomendaciones',
];