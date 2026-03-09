<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;


class FotaWebApiController extends Controller
{


    public function getDevice($imei)
    {

        $token = config('app.token_fota_web');
        $client = new Client(['base_uri' => 'https://api.teltonika.lt', 'verify' => false]);

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://api.teltonika.lt/devices/' . $imei,
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $client->request('GET', 'https://api.teltonika.lt/devices/' . $imei, $parameters);

        if ($res->getStatusCode() == 200) {

            return $response = json_decode($res->getBody()->getContents());
        } else {

            return false;
        }
    }

    /**
     * Obtener dispositivos de Fota Web con paginación y filtros
     * 
     * @param array $options Opciones de consulta:
     *   - imei: array de IMEIs para filtrar
     *   - model: array de modelos para filtrar
     *   - query: búsqueda en imei, serial, description
     *   - query_field: campo específico de búsqueda (imei, serial, description, iccid)
     *   - page: número de página (default: 1)
     *   - per_page: elementos por página (1-100, default: 25)
     *   - sort: campo de ordenamiento (imei, model, seen_at, etc)
     *   - order: orden asc/desc (default: asc)
     *   - activity_status: filtrar por estado de actividad
     * @return object|false
     */
    public function getDevices(array $options = [])
    {
        $token = config('app.token_fota_web');
        $client = new Client(['base_uri' => 'https://api.teltonika.lt', 'verify' => false]);

        // Construir query parameters
        $queryParams = [];

        // Filtros de array
        if (!empty($options['imei'])) {
            $queryParams['imei'] = is_array($options['imei']) ? $options['imei'] : [$options['imei']];
        }

        if (!empty($options['model'])) {
            $queryParams['model'] = is_array($options['model']) ? $options['model'] : [$options['model']];
        }

        if (!empty($options['company_id'])) {
            $queryParams['company_id'] = is_array($options['company_id']) ? $options['company_id'] : [$options['company_id']];
        }

        if (!empty($options['group_id'])) {
            $queryParams['group_id'] = is_array($options['group_id']) ? $options['group_id'] : [$options['group_id']];
        }

        // Búsqueda
        if (!empty($options['query'])) {
            $queryParams['query'] = $options['query'];
        }

        if (!empty($options['query_field'])) {
            $queryParams['query_field'] = $options['query_field'];
        }

        // Paginación
        $queryParams['page'] = $options['page'] ?? 1;
        $queryParams['per_page'] = min($options['per_page'] ?? 25, 100); // Máximo 100

        // Ordenamiento
        if (!empty($options['sort'])) {
            $queryParams['sort'] = $options['sort'];
        }

        $queryParams['order'] = $options['order'] ?? 'asc';

        // Estado de actividad
        if (isset($options['activity_status'])) {
            $queryParams['activity_status'] = is_array($options['activity_status'])
                ? $options['activity_status']
                : [$options['activity_status']];
        }

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 10,
            'timeout' => 30,
            'query' => $queryParams,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => 'https://api.teltonika.lt/devices',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $client->request('GET', 'https://api.teltonika.lt/devices', $parameters);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents());
        } else {
            return false;
        }
    }

    /**
     * Sincronizar dispositivos locales con Fota Web
     * 
     * @param array $imeis Array de IMEIs a consultar
     * @return array Resultado de la sincronización
     */
    public function syncDevices(array $imeis)
    {
        $result = [
            'total' => count($imeis),
            'found' => 0,
            'not_found' => 0,
            'devices' => []
        ];

        // Consultar en lotes de 50 IMEIs (para no saturar la API)
        $chunks = array_chunk($imeis, 50);

        foreach ($chunks as $chunk) {
            $response = $this->getDevices([
                'imei' => $chunk,
                'per_page' => 50
            ]);

            if ($response && isset($response->data)) {
                foreach ($response->data as $device) {
                    $result['devices'][] = $device;
                    $result['found']++;
                }
            }
        }

        $result['not_found'] = $result['total'] - $result['found'];

        return $result;
    }

    /**
     * Obtener estadísticas de dispositivos en Fota Web
     * 
     * @return array|false
     */
    public function getStats()
    {
        $response = $this->getDevices([
            'page' => 1,
            'per_page' => 1
        ]);

        if ($response) {
            return [
                'total' => $response->total ?? 0,
                'current_page' => $response->current_page ?? 0,
                'last_page' => $response->last_page ?? 0,
                'per_page' => $response->per_page ?? 0
            ];
        }

        return false;
    }
}
