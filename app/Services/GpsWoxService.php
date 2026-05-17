<?php

namespace App\Services;

use App\Models\Vehiculos;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Servicio para interactuar con la API de GPS Wox
 * 
 * Endpoints documentados:
 * - /api/get_devices_by_plate: Búsqueda de dispositivo por placa exacta
 * - /api/get_devices_transmission_status: Estado de transmisión de dispositivos activos
 * 
 */
class GpsWoxService
{
    protected Client $client;
    protected string $baseUri;
    protected string $apiHash;

    public function __construct()
    {
        $this->baseUri = config('services.gpswox.base_uri');
        $this->apiHash = config('services.gpswox.api_hash');

        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'timeout' => 30,
            'http_errors' => false, // Manejamos errores manualmente
        ]);
    }

    /**
     * Busca un dispositivo específico por número de placa exacto
     * 
     * @param string $plateNumber Número de placa exacto del dispositivo
     * @return array Respuesta de la API con estructura:
     *               - status: 1 (éxito) o 0 (error)
     *               - device: Información del dispositivo (id, imei, sim_number, name, plate_number)
     *               - message: Mensaje de error si status = 0
     * @throws \Exception Si ocurre un error de comunicación con la API
     * 
     * @example
     * $response = $service->getDeviceByPlate('ADF-730');
     * if ($response['status'] === 1) {
     *     $device = $response['device'];
     *     echo "Dispositivo: {$device['name']}, IMEI: {$device['imei']}";
     * }
     */

    /** 
     * {
     * "status": 1,
     *"device": {
     * "id": 502,
     *"imei": "865413055961162",
     *"sim_number": "982086064",
     *"name": "ADF-730 SHADAY",
     *"plate_number": "ADF-730"
     *}
     *}
     */
    public function getDeviceByPlate(string $plateNumber): array
    {
        try {
            $response = $this->client->request('GET', 'get_devices_by_plate', [
                'query' => [
                    'user_api_hash' => $this->apiHash,
                    'plate_number' => $plateNumber,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            // Manejo de respuestas HTTP específicas
            if ($statusCode === 404) {
                return [
                    'status' => 0,
                    'message' => $body['message'] ?? "Device not found with plate number: {$plateNumber}",
                ];
            }

            if ($statusCode === 400) {
                return [
                    'status' => 0,
                    'message' => $body['message'] ?? 'plate_number parameter is required',
                ];
            }

            if ($statusCode === 403) {
                return [
                    'status' => 0,
                    'message' => $body['message'] ?? 'No tiene permiso para realizar esta acción',
                ];
            }

            if ($statusCode !== 200) {
                Log::error("GPS Wox API Error - getDeviceByPlate", [
                    'status_code' => $statusCode,
                    'plate_number' => $plateNumber,
                    'response' => $body,
                ]);

                return [
                    'status' => 0,
                    'message' => 'Error al consultar la API de GPS',
                ];
            }

            return $body;
        } catch (GuzzleException $e) {
            Log::error("GPS Wox API Exception - getDeviceByPlate", [
                'plate_number' => $plateNumber,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception("Error de comunicación con la API de GPS: {$e->getMessage()}");
        }
    }

    /**
     * Obtiene el estado de transmisión de todos los dispositivos activos
     * 
     * Categoriza dispositivos por tiempo sin conexión:
     * - ok: < 1 hora (transmitiendo normalmente)
     * - warning: 1-24 horas (sin transmisión reciente)
     * - critical: 1-7 días (requiere atención inmediata)
     * - emergency: > 7 días (requiere revisión urgente)
     * - never_connected: Sin conexión (nunca se ha conectado)
     * 
     * @param bool $showEmpty Si es true, muestra todas las categorías aunque estén vacías
     * @return array Respuesta de la API con estructura:
     *               - status: 1 (éxito) o 0 (error)
     *               - total_active_devices: Total de dispositivos activos
     *               - summary: Conteo por categoría
     *               - categories: Array de categorías con dispositivos
     * @throws \Exception Si ocurre un error de comunicación con la API
     * 
     * @example
     * $response = $service->getDevicesTransmissionStatus();
     * if ($response['status'] === 1) {
     *     echo "Total dispositivos: {$response['total_active_devices']}";
     *     echo "OK: {$response['summary']['ok']}";
     *     echo "Críticos: {$response['summary']['critical']}";
     * }
     */
    public function getDevicesTransmissionStatus(bool $showEmpty = false): array
    {
        try {
            $queryParams = [
                'user_api_hash' => $this->apiHash,
            ];

            if ($showEmpty) {
                $queryParams['show_empty'] = 'true';
            }

            $response = $this->client->request('GET', 'get_devices_transmission_status', [
                'query' => $queryParams,
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            if ($statusCode === 403) {
                return [
                    'status' => 0,
                    'message' => $body['message'] ?? 'No tiene permiso para realizar esta acción',
                ];
            }

            if ($statusCode !== 200) {
                Log::error("GPS Wox API Error - getDevicesTransmissionStatus", [
                    'status_code' => $statusCode,
                    'show_empty' => $showEmpty,
                    'response' => $body,
                ]);

                return [
                    'status' => 0,
                    'message' => 'Error al consultar la API de GPS',
                ];
            }

            return $body;
        } catch (GuzzleException $e) {
            Log::error("GPS Wox API Exception - getDevicesTransmissionStatus", [
                'show_empty' => $showEmpty,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception("Error de comunicación con la API de GPS: {$e->getMessage()}");
        }
    }

    /**
     * Filtra dispositivos por categoría específica del estado de transmisión
     * 
     * @param string $category Categoría: 'ok', 'warning', 'critical', 'emergency', 'never_connected'
     * @return array Lista de dispositivos en la categoría especificada
     */
    public function getDevicesByTransmissionCategory(string $category): array
    {
        $response = $this->getDevicesTransmissionStatus();

        if ($response['status'] !== 1) {
            return [];
        }

        foreach ($response['categories'] as $cat) {
            if ($cat['key'] === $category) {
                return $cat['items'] ?? [];
            }
        }

        return [];
    }

    /**
     * Obtiene resumen ejecutivo del estado de la flota
     * 
     * @return array Resumen con contadores por categoría
     */
    public function getFleetSummary(): array
    {
        $response = $this->getDevicesTransmissionStatus();

        if ($response['status'] !== 1) {
            return [
                'status' => 0,
                'message' => $response['message'] ?? 'Error al obtener resumen',
            ];
        }

        return [
            'status' => 1,
            'total_active_devices' => $response['total_active_devices'],
            'summary' => $response['summary'],
        ];
    }

    /**
     * Importa el sim_number desde la plataforma GPS y actualiza vehiculos.numero en Talentus.
     * Dirección: Tracking Platform → Talentus.
     * Búsqueda por placa del vehículo → devuelve sim_number registrado en la plataforma.
     */
    public function sincronizarSimVehiculo(Vehiculos $vehiculo): bool
    {
        if (blank($vehiculo->placa)) {
            return false;
        }

        try {
            $response = $this->getDeviceByPlate($vehiculo->placa);

            if (($response['status'] ?? 0) !== 1) {
                Log::channel('daily')->warning('[GpsWox] Vehículo no encontrado en la plataforma', [
                    'placa' => $vehiculo->placa,
                    'response' => $response,
                ]);
                return false;
            }

            $simNumber = $response['device']['sim_number'] ?? null;

            if (blank($simNumber)) {
                return false;
            }

            if ($vehiculo->numero !== $simNumber) {
                $vehiculo->numero = $simNumber;
                $vehiculo->save();

                Log::channel('daily')->info('[GpsWox] SIM importado desde plataforma', [
                    'placa'      => $vehiculo->placa,
                    'sim_number' => $simNumber,
                ]);
            }

            return true;
        } catch (\Throwable $e) {
            Log::channel('daily')->error('[GpsWox] Error al importar SIM desde plataforma', [
                'placa' => $vehiculo->placa,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Limpia vehiculos.numero en Talentus cuando se desvincula la línea.
     */
    public function limpiarSimVehiculo(Vehiculos $vehiculo): bool
    {
        if (blank($vehiculo->numero)) {
            return true;
        }

        $vehiculo->numero = null;
        $vehiculo->save();

        Log::channel('daily')->info('[GpsWox] SIM limpiado en Talentus', [
            'placa' => $vehiculo->placa,
        ]);

        return true;
    }
}
