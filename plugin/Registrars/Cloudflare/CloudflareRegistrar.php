<?php

namespace Plugins\Registrars\Cloudflare;

use App\Contracts\RegistrarInterface;
use App\Models\Registrant;
use App\Support\AbstractPlugin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareRegistrar extends AbstractPlugin implements RegistrarInterface
{
    /**
     * Cloudflare API base URL.
     */
    protected string $apiBase = 'https://api.cloudflare.com/client/v4';

    /**
     * Get global configuration schema for admin panel.
     */
    public function getConfigSchema(): array
    {
        return [
            'api_token' => [
                'type'    => 'text',
                'label'   => 'Cloudflare API Token',
                'required' => true,
                'default' => '',
                'helper'  => 'Token con permisos: Account:Read + Registrar:Read/Write + Zone:Read + DNS:Edit.',
            ],
            'account_id' => [
                'type'    => 'text',
                'label'   => 'Cloudflare Account ID',
                'required' => true,
                'default' => '',
                'helper'  => 'ID de tu cuenta Cloudflare. Lo encuentras en la URL del dashboard o en la API.',
            ],
            'default_nameservers' => [
                'type'    => 'textarea',
                'label'   => 'Nameservers por defecto',
                'required' => false,
                'default'  => "ns1.cloudflare.com\nns2.cloudflare.com\nns3.cloudflare.com",
                'helper'  => 'Nameservers asignados a nuevos dominios (uno por línea).',
            ],
            'auto_proxy' => [
                'type'    => 'toggle',
                'label'   => 'Proxy automático (CDN naranja)',
                'default' => true,
                'helper'  => 'Activar Cloudflare proxy por defecto en registros A/AAAA/CNAME.',
            ],
        ];
    }

    /**
     * Test connection to Cloudflare API.
     */
    public function testConnection(array $config): bool
    {
        $response = $this->apiRequest('GET', '/user/tokens/verify');

        return $response && ($response['success'] ?? false);
    }

    /**
     * Check domain availability via Cloudflare Registrar search.
     */
    public function checkAvailability(string $domain): array
    {
        $domain = strtolower(trim($domain));
        $accountId = $this->getInstanceConfig('account_id');

        // Try to get existing domain in registrar
        $response = $this->apiRequest('GET', "/accounts/{$accountId}/registrar/domains/{$domain}");

        if ($response && ($response['success'] ?? false)) {
            // Domain already registered in this account
            return [
                'available' => false,
                'premium'   => $response['result']['premium'] ?? false,
                'price'     => null,
            ];
        }

        // If 404, domain is available (not registered in this account)
        // If other error, we can't determine — assume available with caution
        return [
            'available' => true,
            'premium'   => false,
            'price'     => null,
        ];
    }

    /**
     * Register a new domain via Cloudflare Registrar API.
     */
    public function create(Registrant $registrant): void
    {
        $domain = strtolower(trim($registrant->domain));
        $accountId = $this->getInstanceConfig('account_id');
        $years = $registrant->years ?? 1;

        $payload = [
            'name'    => $domain,
            'years'   => $years,
            'auto_renew' => true,
            'zone_activate' => true,
            'registrant_contact' => [
                'first_name' => $registrant->user?->first_name ?? 'Customer',
                'last_name'  => $registrant->user?->last_name ?? '',
                'email'      => $registrant->user?->email ?? '',
                'phone'      => $registrant->user?->billing?->phone ?? '',
                'organization' => $registrant->user?->billing?->company ?? '',
                'address'    => $registrant->user?->billing?->street_address ?? '',
                'city'       => $registrant->user?->billing?->city ?? '',
                'state'      => $registrant->user?->billing?->state ?? '',
                'zip'        => $registrant->user?->billing?->postcode ?? '',
                'country'    => $registrant->user?->billing?->country ?? 'CO',
            ],
        ];

        $response = $this->apiRequest(
            'POST',
            "/accounts/{$accountId}/registrar/domains/{$domain}/registrations",
            $payload
        );

        if (empty($response['result']['id'])) {
            Log::error("Cloudflare Registrar: Failed to register {$domain}", $response);
            throw new \RuntimeException('Failed to register domain: ' . ($response['errors'][0]['message'] ?? 'Unknown error'));
        }

        // Store registration info
        $configuration = $registrant->configuration ?? [];
        $configuration['cloudflare_registration_id'] = $response['result']['id'];
        $configuration['cloudflare_zone_id'] = $response['result']['zone_id'] ?? null;
        $configuration['nameservers'] = $response['result']['name_servers'] ?? $this->getDefaultNameservers();

        $registrant->update([
            'configuration' => $configuration,
            'registered_at' => now(),
            'expires_at'    => now()->addYears($years),
        ]);

        Log::info("Cloudflare Registrar: Domain {$domain} registered — ID: {$response['result']['id']}");
    }

    /**
     * Transfer domain into Cloudflare Registrar.
     */
    public function transfer(Registrant $registrant, string $eppCode): void
    {
        $domain = strtolower(trim($registrant->domain));
        $accountId = $this->getInstanceConfig('account_id');

        $payload = [
            'name'    => $domain,
            'years'   => $registrant->years ?? 1,
            'auto_renew' => true,
            'auth_code' => $eppCode,
        ];

        $response = $this->apiRequest(
            'POST',
            "/accounts/{$accountId}/registrar/domains/{$domain}/transfer",
            $payload
        );

        if (empty($response['result']['id'])) {
            Log::error("Cloudflare Registrar: Failed to transfer {$domain}", $response);
            throw new \RuntimeException('Failed to transfer domain: ' . ($response['errors'][0]['message'] ?? 'Unknown error'));
        }

        $configuration = $registrant->configuration ?? [];
        $configuration['cloudflare_registration_id'] = $response['result']['id'];
        $configuration['epp_code'] = $eppCode;

        $registrant->update(['configuration' => $configuration]);

        Log::info("Cloudflare Registrar: Transfer initiated for {$domain}");
    }

    /**
     * Renew domain registration.
     */
    public function renew(Registrant $registrant, int $years = 1): void
    {
        $domain = strtolower(trim($registrant->domain));
        $accountId = $this->getInstanceConfig('account_id');

        // Get current registration
        $current = $this->apiRequest('GET', "/accounts/{$accountId}/registrar/domains/{$domain}");

        if (!$current || !($current['success'] ?? false)) {
            Log::warning("Cloudflare Registrar: Cannot find {$domain} for renewal");
            return;
        }

        $currentExpires = $current['result']['expires_at'] ?? null;
        $currentYears = $current['result']['years'] ?? 1;
        $newYears = $currentYears + $years;

        $response = $this->apiRequest(
            'PUT',
            "/accounts/{$accountId}/registrar/domains/{$domain}",
            ['years' => $newYears, 'auto_renew' => true]
        );

        if ($response && ($response['success'] ?? false)) {
            if ($currentExpires) {
                $registrant->update(['expires_at' => \Carbon\Carbon::parse($currentExpires)->addYears($years)]);
            }
            Log::info("Cloudflare Registrar: {$domain} renewed for {$years} year(s) — now {$newYears} years total");
        }
    }

    /**
     * Get nameservers from Cloudflare Registrar.
     */
    public function getNameservers(Registrant $registrant): array
    {
        $domain = strtolower(trim($registrant->domain));
        $accountId = $this->getInstanceConfig('account_id');

        $response = $this->apiRequest('GET', "/accounts/{$accountId}/registrar/domains/{$domain}");

        if ($response && ($response['success'] ?? false)) {
            return $response['result']['name_servers'] ?? $this->getDefaultNameservers();
        }

        return $registrant->configuration['nameservers'] ?? $this->getDefaultNameservers();
    }

    /**
     * Set nameservers — Cloudflare Registrar manages NS internally.
     */
    public function setNameservers(Registrant $registrant, array $nameservers): void
    {
        Log::info("Cloudflare Registrar: Nameservers for {$registrant->domain} managed by Cloudflare.");
    }

    /**
     * Sync domain status from Cloudflare.
     */
    public function syncStatus(Registrant $registrant): array
    {
        $domain = strtolower(trim($registrant->domain));
        $accountId = $this->getInstanceConfig('account_id');

        $response = $this->apiRequest('GET', "/accounts/{$accountId}/registrar/domains/{$domain}");

        if (!$response || !($response['success'] ?? false)) {
            return [
                'status'     => $registrant->status,
                'expires_at' => $registrant->expires_at?->toDateTimeString(),
            ];
        }

        $data = $response['result'];

        return [
            'status'          => $data['status'] ?? $registrant->status,
            'expires_at'      => $data['expires_at'] ?? null,
            'registration_id' => $data['id'] ?? null,
            'premium'         => $data['premium'] ?? false,
            'auto_renew'      => $data['auto_renew'] ?? true,
            'locked'          => $data['locked'] ?? true,
        ];
    }

    /**
     * Get default nameservers from config.
     */
    protected function getDefaultNameservers(): array
    {
        $ns = $this->getInstanceConfig('default_nameservers', "ns1.cloudflare.com\nns2.cloudflare.com");
        return array_filter(array_map('trim', explode("\n", $ns)));
    }

    /**
     * Make an API request to Cloudflare.
     */
    protected function apiRequest(string $method, string $endpoint, array $data = []): ?array
    {
        $token = $this->getInstanceConfig('api_token');

        if (empty($token)) {
            Log::error('Cloudflare Registrar: API token not configured.');
            return null;
        }

        try {
            $http = Http::withToken($token)
                ->timeout(30)
                ->withHeaders(['Content-Type' => 'application/json']);

            $url = $this->apiBase . $endpoint;

            $response = match (strtoupper($method)) {
                'GET'    => $http->get($url, $data),
                'POST'   => $http->post($url, $data),
                'PUT'    => $http->put($url, $data),
                'PATCH'  => $http->patch($url, $data),
                'DELETE' => $http->delete($url, $data),
                default  => null,
            };

            if (!$response) {
                return null;
            }

            $json = $response->json();

            if (!$json || ($json['success'] === false)) {
                Log::error("Cloudflare Registrar: API {$method} {$endpoint} failed", [
                    'errors' => $json['errors'] ?? [],
                ]);
            }

            return $json;
        } catch (\Throwable $e) {
            Log::error("Cloudflare Registrar: {$method} {$endpoint} exception: " . $e->getMessage());
            return null;
        }
    }
}
