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
                'helper'  => 'Crear en Cloudflare → My Profile → API Tokens. Permisos: Zone:Read, DNS:Edit.',
            ],
            'default_nameservers' => [
                'type'    => 'textarea',
                'label'   => 'Nameservers por defecto',
                'required' => false,
                'default'  => "ns1.cloudflare.com\nns2.cloudflare.com",
                'helper'  => 'Nameservers asignados a nuevos dominios (uno por línea).',
            ],
            'default_ttl' => [
                'type'    => 'number',
                'label'   => 'TTL por defecto (segundos)',
                'required' => false,
                'default' => '3600',
                'helper'  => 'TTL para registros DNS. 1 = Automatic.',
            ],
            'proxy_default' => [
                'type'    => 'toggle',
                'label'   => 'Proxied por defecto',
                'default' => true,
                'helper'  => 'Activar Cloudflare proxy (naranja) por defecto en registros A/AAAA/CNAME.',
            ],
        ];
    }

    /**
     * Test connection to Cloudflare API.
     */
    public function testConnection(array $config): bool
    {
        $response = $this->apiRequest('GET', '/user/tokens/verify');

        if ($response && ($response['success'] ?? false)) {
            return true;
        }

        Log::error('Cloudflare Registrar: Connection test failed', [
            'response' => $response,
        ]);

        return false;
    }

    /**
     * Check domain availability via Cloudflare.
     * Creates zone with pause=true to verify ownership without activating.
     */
    public function checkAvailability(string $domain): array
    {
        // Cloudflare doesn't have a direct "check availability" endpoint.
        // We try to create a zone - if it fails with "already exists", the domain is taken.
        // This is a lightweight check - we don't actually create the zone here,
        // just check if one already exists under this account.

        $domain = strtolower(trim($domain));

        // Check if we already have this zone
        $zones = $this->apiRequest('GET', '/zones', [
            'name' => $domain,
        ]);

        $exists = !empty($zones['result']) && count($zones['result']) > 0;

        // If zone exists in our account, it's already registered
        if ($exists) {
            $zone = $zones['result'][0];
            return [
                'available' => false,
                'premium'   => false,
                'price'     => null,
                'status'    => $zone['status'] ?? 'active',
            ];
        }

        // Domain not in our Cloudflare account — could be available or could be
        // registered with another provider/account. We report it as "check manually".
        return [
            'available' => true,
            'premium'   => false,
            'price'     => null,
            'note'      => 'Verify manually at cloudflare.com',
        ];
    }

    /**
     * Create registrant — add domain to Cloudflare (DNS-only, no registration).
     * Actual domain registration must be done at cloudflare.com/registrar.
     */
    public function create(Registrant $registrant): void
    {
        $domain = strtolower(trim($registrant->domain));

        // Create zone in Cloudflare (DNS setup)
        $response = $this->apiRequest('POST', '/zones', [
            'name' => $domain,
            'type' => 'full',
        ]);

        if (empty($response['result']['id'])) {
            Log::error("Cloudflare Registrar: Failed to create zone for {$domain}", $response);
            return;
        }

        $zoneId = $response['result']['id'];
        $nameservers = $response['result']['name_servers'] ?? [];

        // Store zone info
        $configuration = $registrant->configuration ?? [];
        $configuration['cloudflare_zone_id'] = $zoneId;
        $configuration['nameservers'] = $nameservers;

        $registrant->update([
            'configuration' => $configuration,
        ]);

        Log::info("Cloudflare Registrar: Zone created for {$domain} — Zone ID: {$zoneId}");
    }

    /**
     * Transfer registrant — adds existing domain as zone to Cloudflare.
     */
    public function transfer(Registrant $registrant, string $eppCode): void
    {
        $domain = strtolower(trim($registrant->domain));

        // Add zone to Cloudflare (the domain should already be pointing to Cloudflare NS)
        $response = $this->apiRequest('POST', '/zones', [
            'name' => $domain,
            'type' => 'full',
        ]);

        if (empty($response['result']['id'])) {
            Log::error("Cloudflare Registrar: Failed to add zone for transfer {$domain}", $response);
            return;
        }

        $zoneId = $response['result']['id'];
        $nameservers = $response['result']['name_servers'] ?? [];

        $configuration = $registrant->configuration ?? [];
        $configuration['cloudflare_zone_id'] = $zoneId;
        $configuration['nameservers'] = $nameservers;
        $configuration['epp_code'] = $eppCode;

        $registrant->update([
            'configuration' => $configuration,
        ]);

        Log::info("Cloudflare Registrar: Zone added for transfer {$domain} — Zone ID: {$zoneId}");
    }

    /**
     * Renew registrant — Cloudflare domains auto-renew. Admin must handle billing externally.
     */
    public function renew(Registrant $registrant, int $years = 1): void
    {
        Log::info("Cloudflare Registrar: Renewal notice for {$registrant->domain} — {$years} year(s). Handle manually at cloudflare.com.");
    }

    /**
     * Get nameservers from Cloudflare zone.
     */
    public function getNameservers(Registrant $registrant): array
    {
        $zoneId = $registrant->configuration['cloudflare_zone_id'] ?? null;

        if (!$zoneId) {
            // Fallback to stored nameservers
            return $registrant->configuration['nameservers'] 
                ?? explode("\n", $this->getInstanceConfig('default_nameservers', "ns1.cloudflare.com\nns2.cloudflare.com"));
        }

        $response = $this->apiRequest('GET', "/zones/{$zoneId}");

        return $response['result']['name_servers'] 
            ?? $registrant->configuration['nameservers'] 
            ?? [];
    }

    /**
     * Set nameservers — not applicable for Cloudflare (uses Cloudflare NS).
     * Instead, list DNS records of the zone as reference.
     */
    public function setNameservers(Registrant $registrant, array $nameservers): void
    {
        Log::info("Cloudflare Registrar: Nameservers for {$registrant->domain} managed by Cloudflare.");
    }

    /**
     * Get DNS records for the zone.
     */
    public function getDnsRecords(Registrant $registrant): array
    {
        $zoneId = $registrant->configuration['cloudflare_zone_id'] ?? null;

        if (!$zoneId) {
            return [];
        }

        $response = $this->apiRequest('GET', "/zones/{$zoneId}/dns_records", [
            'per_page' => 100,
        ]);

        return $response['result'] ?? [];
    }

    /**
     * Get EPP Code.
     */
    public function getEPPCode(Registrant $registrant): string
    {
        // EPP codes are obtained from the Cloudflare dashboard
        return $registrant->configuration['epp_code'] ?? '';
    }

    /**
     * Get Whois Info.
     */
    public function getWhoisInfo(Registrant $registrant): array
    {
        return [
            'registrar'      => 'Cloudflare',
            'creation_date'  => $registrant->registered_at ? $registrant->registered_at->toDateString() : now()->toDateString(),
            'expiration_date' => $registrant->expires_at ? $registrant->expires_at->toDateString() : now()->addYear()->toDateString(),
        ];
    }

    /**
     * Set Whois Privacy — Cloudflare enables this by default for all registered domains.
     */
    public function setWhoisPrivacy(Registrant $registrant, bool $enabled): void
    {
        Log::info("Cloudflare Registrar: WHOIS Privacy for {$registrant->domain} set to " . ($enabled ? 'enabled' : 'disabled'));
        $registrant->update(['whois_privacy' => $enabled]);
    }

    /**
     * Sync Status from Cloudflare zone.
     */
    public function syncStatus(Registrant $registrant): array
    {
        $zoneId = $registrant->configuration['cloudflare_zone_id'] ?? null;

        if (!$zoneId) {
            return [
                'status'     => $registrant->status,
                'expires_at' => $registrant->expires_at ? $registrant->expires_at->toDateTimeString() : null,
            ];
        }

        $response = $this->apiRequest('GET', "/zones/{$zoneId}");

        $zoneStatus = $response['result']['status'] ?? 'unknown';
        $paused = $response['result']['paused'] ?? false;

        $status = match ($zoneStatus) {
            'active'  => $paused ? 'suspended' : 'active',
            'pending' => 'pending',
            'moved'   => 'expired',
            default   => $registrant->status,
        };

        return [
            'status'     => $status,
            'expires_at' => $registrant->expires_at ? $registrant->expires_at->toDateTimeString() : null,
            'zone_status' => $zoneStatus,
            'paused'     => $paused,
            'plan'       => $response['result']['plan']['name'] ?? 'Free',
        ];
    }

    // =====================================================
    // Helper Methods
    // =====================================================

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
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ]);

            $url = $this->apiBase . $endpoint;

            $response = match (strtoupper($method)) {
                'GET'    => $http->get($url, $data),
                'POST'   => $http->post($url, $data),
                'PUT'    => $http->put($url, $data),
                'PATCH'  => $http->patch($url, $data),
                'DELETE' => $http->delete($url, $data),
                default  => null,
            };

            if (!$response || $response->failed()) {
                Log::error("Cloudflare Registrar: API {$method} {$endpoint} failed", [
                    'status' => $response?->status(),
                    'body'   => $response?->body(),
                ]);
                return null;
            }

            return $response->json();
        } catch (\Throwable $e) {
            Log::error("Cloudflare Registrar: API {$method} {$endpoint} exception: " . $e->getMessage());
            return null;
        }
    }
}
