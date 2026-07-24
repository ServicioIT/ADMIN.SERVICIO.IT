<?php

namespace Plugins\Gateways\Stripe;

use App\Contracts\GatewayInterface;
use App\Support\AbstractPlugin;
use App\Support\GatewayCallbackResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StripeGateway extends AbstractPlugin implements GatewayInterface
{
    /*
    |--------------------------------------------------------------------------
    | Plugin Contract
    |--------------------------------------------------------------------------
    */

    public function getConfigSchema(): array
    {
        return [
            'publishable_key' => [
                'label' => 'Publishable Key (pk_...)',
                'type'  => 'text',
                'rules' => 'required|string',
            ],
            'secret_key' => [
                'label' => 'Secret Key (sk_...)',
                'type'  => 'password',
                'rules' => 'required|string',
            ],
            'webhook_secret' => [
                'label' => 'Webhook Signing Secret (whsec_...)',
                'type'  => 'password',
                'rules' => 'nullable|string',
                'helper' => 'Opcional pero recomendado para validar webhooks.',
            ],
            'mode' => [
                'label'   => 'Environment',
                'type'    => 'select',
                'options' => [
                    'test' => 'Test (sandbox)',
                    'live' => 'Live (producción)',
                ],
                'rules'   => 'required|in:test,live',
                'default' => 'test',
            ],
        ];
    }

    public function getPermissions(): array
    {
        return ['gateways.stripe'];
    }

    /*
    |--------------------------------------------------------------------------
    | Gateway Contract
    |--------------------------------------------------------------------------
    */

    public function isApplicable(float $amount, string $currency): bool
    {
        // Stripe soporta 135+ monedas incluyendo COP, USD, EUR
        return $amount > 0;
    }

    public function pay(string $invoiceNumber, float $amount, string $currency, array $options = []): mixed
    {
        try {
            $callbackUrl = route('client.gateways.return', [
                'plugin' => $this->getPluginModel()->id,
            ]);

            $successUrl = $callbackUrl . '?invoice=' . urlencode($invoiceNumber) . '&status=success';
            $cancelUrl  = $callbackUrl . '?invoice=' . urlencode($invoiceNumber) . '&status=cancel';

            // Crear Checkout Session
            $payload = [
                'mode'        => 'payment',
                'success_url' => $successUrl,
                'cancel_url'  => $cancelUrl,
                'client_reference_id' => $invoiceNumber,
                'line_items'  => [
                    [
                        'quantity'   => 1,
                        'price_data' => [
                            'currency'     => strtolower($currency),
                            'unit_amount'  => $this->formatAmount($amount, $currency),
                            'product_data' => [
                                'name' => $options['description'] ?? "Factura {$invoiceNumber}",
                            ],
                        ],
                    ],
                ],
                'metadata' => [
                    'invoice_number' => $invoiceNumber,
                ],
            ];

            // Apple Pay / Google Pay requieren dominios registrados
            $payload['payment_method_types'] = ['card'];

            $response = $this->request('POST', '/v1/checkout/sessions', $payload);

            if (! isset($response['url'])) {
                return [
                    'success' => false,
                    'message' => 'Stripe no devolvió URL de checkout.',
                ];
            }

            return [
                'success' => true,
                'type'    => 'redirect',
                'data'    => $response['url'],
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function webhook(Request $request): GatewayCallbackResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = $this->getInstanceConfig('webhook_secret');

        // Verificar firma si hay webhook secret configurado
        if ($webhookSecret && $sigHeader) {
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sigHeader, $webhookSecret
                );
            } catch (\Exception $e) {
                return new GatewayCallbackResponse(
                    isValid: false,
                    isSuccess: false,
                    orderNumber: ''
                );
            }
        } else {
            $event = json_decode($payload, true);
        }

        if (($event['type'] ?? '') !== 'checkout.session.completed') {
            return new GatewayCallbackResponse(
                isValid: true,
                isSuccess: false,
                orderNumber: ''
            );
        }

        $session = $event['data']['object'] ?? [];
        $invoiceNumber = $session['client_reference_id'] ?? '';

        return new GatewayCallbackResponse(
            isValid: true,
            isSuccess: $session['payment_status'] === 'paid',
            orderNumber: (string) $invoiceNumber,
            gatewayReference: $session['payment_intent'] ?? '',
            amount: (float) ($session['amount_total'] ?? 0) / 100,
            fee: 0,
        );
    }

    public function return(Request $request): GatewayCallbackResponse
    {
        $invoiceNumber = $request->query('invoice');
        $status = $request->query('status');

        if (! $invoiceNumber) {
            return new GatewayCallbackResponse(
                isValid: false,
                isSuccess: false,
                orderNumber: '',
                redirectUrl: url('/')
            );
        }

        $redirectUrl = route('client.invoices.show', $invoiceNumber);

        // Si viene con status=success, verificar la sesión de Stripe
        if ($status === 'success') {
            return new GatewayCallbackResponse(
                isValid: true,
                isSuccess: true,
                orderNumber: (string) $invoiceNumber,
                redirectUrl: $redirectUrl
            );
        }

        // Cancelado
        return new GatewayCallbackResponse(
            isValid: true,
            isSuccess: false,
            orderNumber: (string) $invoiceNumber,
            redirectUrl: $redirectUrl
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Internals
    |--------------------------------------------------------------------------
    */

    /**
     * Stripe usa centavos para la mayoría de monedas,
     * pero COP, JPY, KRW etc. son "zero-decimal" (sin centavos).
     */
    private function formatAmount(float $amount, string $currency): int
    {
        $zeroDecimal = ['COP', 'JPY', 'KRW', 'CLP', 'PYG', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'BIF', 'DJF', 'GNF', 'RWF', 'XPF'];

        if (in_array(strtoupper($currency), $zeroDecimal)) {
            return (int) round($amount);
        }

        return (int) round($amount * 100);
    }

    private function request(string $method, string $endpoint, array $params): array
    {
        $response = Http::withBasicAuth($this->getInstanceConfig('secret_key'), '')
            ->asForm()
            ->{strtolower($method)}($this->baseUrl() . $endpoint, $params);

        if (! $response->successful()) {
            $error = $response->json('error.message') ?? $response->body();
            throw new \Exception("Stripe API error ({$response->status()}): {$error}");
        }

        return $response->json() ?? [];
    }

    private function baseUrl(): string
    {
        return 'https://api.stripe.com';
    }
}
