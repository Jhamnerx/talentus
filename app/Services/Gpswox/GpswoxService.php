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
     * Usa `v2/get_devices` (no `get_devices_latest`, que solo expone un
     * timestamp sin online/speed). La API agrupa la respuesta por
     * `group_id` con un array `items` anidado; se aplana aquí. El filtro
     * `id` requiere enviarse como array (no como string CSV), de lo
     * contrario la API solo devuelve el primer id de la lista.
     *
     * @param  array<int, int>  $gpswoxIds
     * @return array<string, mixed> indexado por device id (string)
     */
    public function getLatestStatusForDevices(int $clienteId, array $gpswoxIds): array
    {
        if (empty($gpswoxIds)) {
            return [];
        }

        return Cache::remember("gpswox.latest.{$clienteId}", 60, function () use ($clienteId, $gpswoxIds) {
            try {
                $response = $this->client->request('GET', 'v2/get_devices', [
                    'query' => [
                        'id' => $gpswoxIds,
                    ],
                ]);

                return collect($response)
                    ->flatMap(fn ($group) => $group['items'] ?? [])
                    ->keyBy(fn ($item) => (string) ($item['id'] ?? ''))
                    ->all();
            } catch (Throwable $e) {
                Log::warning('GpswoxService: error consultando v2/get_devices', [
                    'cliente_id' => $clienteId,
                    'error' => $e->getMessage(),
                ]);

                return [];
            }
        });
    }
}
