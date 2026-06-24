<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Cliente de la API de Teltonika Fota Web.
 * Extraído de FotaWebApiController (que se usaba como servicio).
 */
class FotaWebService
{
    private const BASE_URI = 'https://api.teltonika.lt';

    private function client(): Client
    {
        return new Client(['base_uri' => self::BASE_URI, 'verify' => false]);
    }

    /**
     * @return object|false
     */
    public function getDevice(?string $imei)
    {
        $token = config('app.token_fota_web');

        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Referer' => self::BASE_URI . '/devices/' . $imei,
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $this->client()->request('GET', self::BASE_URI . '/devices/' . $imei, $parameters);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents());
        }

        return false;
    }

    /**
     * @param array $options imei, model, company_id, group_id, query, query_field, page, per_page, sort, order, activity_status
     * @return object|false
     */
    public function getDevices(array $options = [])
    {
        $token = config('app.token_fota_web');

        $queryParams = [];

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
        if (!empty($options['query'])) {
            $queryParams['query'] = $options['query'];
        }
        if (!empty($options['query_field'])) {
            $queryParams['query_field'] = $options['query_field'];
        }

        $queryParams['page'] = $options['page'] ?? 1;
        $queryParams['per_page'] = min($options['per_page'] ?? 25, 100);

        if (!empty($options['sort'])) {
            $queryParams['sort'] = $options['sort'];
        }
        $queryParams['order'] = $options['order'] ?? 'asc';

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
                'Referer' => self::BASE_URI . '/devices',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
        ];

        $res = $this->client()->request('GET', self::BASE_URI . '/devices', $parameters);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents());
        }

        return false;
    }

    /**
     * @param array $imeis
     * @return array{total:int,found:int,not_found:int,devices:array}
     */
    public function syncDevices(array $imeis): array
    {
        $result = [
            'total' => count($imeis),
            'found' => 0,
            'not_found' => 0,
            'devices' => [],
        ];

        $chunks = array_chunk($imeis, 50);

        foreach ($chunks as $chunk) {
            $response = $this->getDevices([
                'imei' => $chunk,
                'per_page' => 50,
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
     * @return array|false
     */
    public function getStats()
    {
        $response = $this->getDevices(['page' => 1, 'per_page' => 1]);

        if ($response) {
            return [
                'total' => $response->total ?? 0,
                'current_page' => $response->current_page ?? 0,
                'last_page' => $response->last_page ?? 0,
                'per_page' => $response->per_page ?? 0,
            ];
        }

        return false;
    }
}
