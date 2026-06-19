<?php

namespace App\Services\Gpswox;

use Gpswox\Wox;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class GpswoxService
{
    private Wox $client;

    public function __construct()
    {
        $this->client = new Wox(
            config('services.gpswox.base_uri'),
            config('services.gpswox.api_hash')
        );
    }

    /**
     * Devuelve el estado más reciente (online/offline, velocidad, última
     * señal) de los dispositivos indicados, cacheado 60s por cliente.
     * En caso de error de la API externa, retorna un array vacío en vez
     * de propagar la excepción — el llamador debe tratar la ausencia de
     * datos como "estado no disponible", no como un fallo de la página.
     *
     * @param  array<int, int>  $gpswoxIds
     * @return array<string, mixed> indexado por device id (string)
     */
    public function getLatestStatusForDevices(int $clienteId, array $gpswoxIds): array
    {
        if (empty($gpswoxIds)) {
            return [];
        }

        return Cache::remember("gpswox.latest.{$clienteId}", 60, function () use ($gpswoxIds) {
            try {
                $response = $this->client->request('GET', 'api/get_devices_latest', [
                    'query' => [
                        'filters' => [
                            'id' => implode(',', $gpswoxIds),
                        ],
                    ],
                ]);

                $items = $response['items'] ?? [];

                return collect($items)->keyBy(fn ($item) => (string) ($item['id'] ?? ''))->all();
            } catch (Throwable $e) {
                Log::warning('GpswoxService: error consultando get_devices_latest', [
                    'cliente_id' => $clienteId,
                    'error' => $e->getMessage(),
                ]);

                return [];
            }
        });
    }
}
