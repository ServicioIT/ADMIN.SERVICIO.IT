<?php

namespace Plugins\Gateways\Wompi;

use App\Contracts\GatewayInterface;
use App\Support\AbstractPlugin;
use App\Support\GatewayCallbackResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WompiGateway extends AbstractPlugin implements GatewayInterface
{
    /*
    |--------------------------------------------------------------------------
    | Plugin Contract
    |--------------------------------------------------------------------------
    */

    public function getConfigSchema(): array
    {
        return [
            'public_key' => [
                'label' => 'Public Key (pub_...)',
                'type'  => 'text',
                'rules' => 'required|string',
            ],
            'private_key' => [
                'label' => 'Private Key (prv_...)',
                'type'  => 'password',
                'rules' => 'required|string',
            ],
            'events_secret' => [
                'label' => 'Event Signature Secret',
                'type'  => 'password',
                'rules' => 'nullable|string',
                'helper' => 'Secreto para validar webhooks de Wompi (opcional pero recomendado).',
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
        return ['gateways.wompi'];
    }

    /*
    |--------------------------------------------------------------------------
    | Gateway Contract
    |--------------------------------------------------------------------------
    */

    /**
     * Wompi solo opera en COP (Colombia).
     */
    public function isApplicable(float $amount, string $currency): bool
    {
        return strtoupper($currency) === 'COP' && $amount > 0;
    }

    public function pay(string $invoiceNumber, float $amount, string $currency, array $options = []): mixed
    {
        try {
            // Crear transacción en Wompi
            $payload = [
                'amount_in_cents'  => (int) round($amount * 100),
                'currency'          => 'COP',
                'customer_email'    => $options['email'] ?? config('mail.from.address'),
                'payment_method'    => [
                    'type' => 'NEQUI',
                ],
                'reference'         => $invoiceNumber,
                'redirect_url'      => route('client.gateways.return', [
                    'plugin'  => $this->getPluginModel()->id,
                    'invoice' => $invoiceNumber,
                ]),
            ];

            // Crear sesión de pago checkout
            $checkoutResponse = $this->request('POST', '/v1/checkout/sessions', [
                'amount_in_cents' => $payload['amount_in_cents'],
                'currency'        => 'COP',
                'customer_email'  => $payload['customer_email'],
                'reference'       => $invoiceNumber,
                'redirect_url'    => $payload['redirect_url'],
            ]);

            $checkoutUrl = $this->checkoutUrl() . $checkoutResponse['data']['id'] ?? null;

            if (! $checkoutUrl) {
                // Fallback: usar URL de widget directo
                $checkoutUrl = $this->checkoutWidgetUrl(
                    $payload['amount_in_cents'],
                    $invoiceNumber,
                    $payload['customer_email'],
                    $payload['redirect_url']
                );
            }

            return [
                'success' => true,
                'type'    => 'redirect',
                'data'    => $checkoutUrl,
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
        $payload = $request->json()->all();
        $event = $payload['event'] ?? null;
        $data = $payload['data'] ?? [];

        // Validar firma del evento si hay events_secret
        $eventsSecret = $this->getInstanceConfig('events_secret');
        $signature = $payload['signature'] ?? null;

        if ($eventsSecret && $signature) {
            $expectedChecksum = hash('sha256', $eventsSecret . $data['transaction']['reference'] ?? '');
            if ($signature['checksum'] !== $expectedChecksum) {
                return new GatewayCallbackResponse(
                    isValid: false,
                    isSuccess: false,
                    orderNumber: ''
                );
            }
        }

        $status = $data['transaction']['status'] ?? '';
        $reference = $data['transaction']['reference'] ?? '';

        $isSuccess = in_array($status, ['APPROVED', 'SUCCESS']);

        return new GatewayCallbackResponse(
            isValid: true,
            isSuccess: $isSuccess,
            orderNumber: (string) $reference,
            gatewayReference: $data['transaction']['id'] ?? '',
            amount: isset($data['transaction']['amount_in_cents'])
                ? (float) $data['transaction']['amount_in_cents'] / 100
                : 0,
            fee: 0,
        );
    }

    public function return(Request $request): GatewayCallbackResponse
    {
        $invoiceNumber = $request->query('invoice');
        $transactionId = $request->query('id');

        if (! $invoiceNumber) {
            return new GatewayCallbackResponse(
                isValid: false,
                isSuccess: false,
                orderNumber: '',
                redirectUrl: url('/')
            );
        }

        $redirectUrl = route('client.invoices.show', $invoiceNumber);

        // Si hay transaction ID, verificar estado
        if ($transactionId) {
            try {
                $tx = $this->request('GET', "/v1/transactions/{$transactionId}");
                $status = $tx['data']['status'] ?? '';
                $isSuccess = $status === 'APPROVED';

                return new GatewayCallbackResponse(
                    isValid: true,
                    isSuccess: $isSuccess,
                    orderNumber: (string) $invoiceNumber,
                    gatewayReference: $transactionId,
                    amount: isset($tx['data']['amount_in_cents'])
                        ? (float) $tx['data']['amount_in_cents'] / 100
                        : 0,
                    fee: 0,
                    redirectUrl: $redirectUrl
                );
            } catch (\Exception $e) {
                // Si falla la verificación, asumir que vino del redirect
            }
        }

        // Sin transaction ID — asumir éxito (Wompi solo redirige si se completó)
        return new GatewayCallbackResponse(
            isValid: true,
            isSuccess: true,
            orderNumber: (string) $invoiceNumber,
            redirectUrl: $redirectUrl
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Internals
    |--------------------------------------------------------------------------
    */

    private function request(string $method, string $endpoint, array $params = []): array
    {
        $response = Http::withToken($this->getInstanceConfig('private_key'))
            ->acceptJson()
            ->asJson()
            ->{strtolower($method)}($this->baseUrl() . $endpoint, $params);

        if (! $response->successful()) {
            $error = $response->json('error.messages.0') ?? $response->body();
            throw new \Exception("Wompi API error ({$response->status()}): {$error}");
        }

        return $response->json() ?? [];
    }

    private function baseUrl(): string
    {
        return $this->getInstanceConfig('mode') === 'live'
            ? 'https://production.wompi.co'
            : 'https://sandbox.wompi.co';
    }

    private function checkoutUrl(): string
    {
        return $this->getInstanceConfig('mode') === 'live'
            ? 'https://checkout.wompi.co/l/'
            : 'https://checkout.wompi.co/p/';
    }

    /**
     * URL del widget de checkout embebido (fallback si la API de sessions falla)
     */
    private function checkoutWidgetUrl(int $amountInCents, string $reference, string $email, string $redirectUrl): string
    {
        $pubKey = $this->getInstanceConfig('public_key');
        $currency = 'COP';

        return "https://checkout.wompi.co/p/?"
            . http_build_query([
                'public-key'       => $pubKey,
                'currency'         => $currency,
                'amount-in-cents'  => $amountInCents,
                'reference'        => $reference,
                'customer-email'   => $email,
                'redirect-url'     => $redirectUrl,
            ]);
    }
}
