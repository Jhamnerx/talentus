<?php

namespace App\Services;

use App\Models\Dispositivos;
use App\Models\Lineas;
use App\Models\Vehiculos;
use App\Models\VehiculoDispositivos;
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

    // =========================================================================
    // CRUD DE DISPOSITIVOS EN LA PLATAFORMA GPSWox
    // =========================================================================

    /**
     * Wrapper genérico de petición HTTP a la API de GPSWox.
     * Centraliza autenticación, logging y manejo de errores.
     *
     * @param string $method  GET|POST
     * @param string $uri     Ruta sin slash inicial (ej. 'add_device')
     * @param array  $query   Query string (se agrega user_api_hash automáticamente)
     * @param array  $body    Cuerpo (form_params para POST)
     * @return array          ['status' => 1|0, 'data' => array, 'http_code' => int, 'message' => ?string]
     */
    protected function request(string $method, string $uri, array $query = [], array $body = []): array
    {
        $options = [
            'query'   => array_merge(['user_api_hash' => $this->apiHash], $query),
            'headers' => ['Accept' => 'application/json'],
        ];

        if (!empty($body)) {
            $options['form_params'] = $body;
        }

        try {
            $response = $this->client->request($method, $uri, $options);
            $statusCode = $response->getStatusCode();
            $payload    = json_decode($response->getBody()->getContents(), true) ?? [];

            if ($statusCode >= 400) {
                Log::channel('daily')->error("[GpsWox] HTTP {$statusCode} en {$method} {$uri}", [
                    'query'   => $query,
                    'body'    => $body,
                    'payload' => $payload,
                ]);
                return [
                    'status'    => 0,
                    'http_code' => $statusCode,
                    'message'   => $payload['message'] ?? "Error HTTP {$statusCode}",
                    'data'      => $payload,
                ];
            }

            return [
                'status'    => $payload['status'] ?? 1,
                'http_code' => $statusCode,
                'data'      => $payload,
            ];
        } catch (GuzzleException $e) {
            Log::channel('daily')->error("[GpsWox] Exception {$method} {$uri}", [
                'error' => $e->getMessage(),
            ]);
            return [
                'status'    => 0,
                'http_code' => 0,
                'message'   => 'Error de comunicación con la API de GPS: ' . $e->getMessage(),
                'data'      => [],
            ];
        }
    }

    /**
     * Obtiene los catálogos necesarios para crear un dispositivo
     * (grupos, iconos, usuarios, timezones, etc.).
     *
     * @return array Respuesta cruda de la API: device_groups, device_icons, users,
     *               device_fuel_measurements, timezones, expiration_date_select, status
     */
    public function addDeviceData(): array
    {
        return $this->request('GET', 'add_device_data')['data'];
    }

    /**
     * Obtiene los datos completos del dispositivo para editarlo
     * (extiende add_device_data con `item`, `sensors`, `services`, etc.).
     *
     * @param int $deviceId ID del dispositivo en la plataforma
     */
    public function editDeviceData(int $deviceId): array
    {
        return $this->request('GET', 'edit_device_data', ['device_id' => $deviceId])['data'];
    }

    /**
     * Crea un dispositivo en la plataforma GPSWox.
     *
     * @param array $payload Campos requeridos: name, imei, icon_id, fuel_measurement_id,
     *                       tail_length, min_moving_speed, min_fuel_fillings, min_fuel_thefts.
     *                       Opcionales: group_id, sim_number, plate_number, device_model,
     *                       user_id[], icon_moving, icon_stopped, etc.
     * @return array ['status' => 1|0, 'id' => int|null, 'message' => string|null]
     */
    public function addDevice(array $payload): array
    {
        $result = $this->request('POST', 'add_device', [], $payload);

        return [
            'status'  => $result['status'] ?? 0,
            'id'      => $result['data']['id'] ?? null,
            'message' => $result['data']['message'] ?? ($result['message'] ?? null),
            'raw'     => $result['data'] ?? [],
        ];
    }

    /**
     * Actualiza un dispositivo existente en la plataforma GPSWox.
     *
     * @param int   $deviceId
     * @param array $payload  Mismos campos que addDevice()
     */
    public function editDevice(int $deviceId, array $payload): array
    {
        $result = $this->request('POST', 'edit_device', ['device_id' => $deviceId], $payload);

        return [
            'status'  => $result['status'] ?? 0,
            'message' => $result['data']['message'] ?? ($result['message'] ?? null),
            'raw'     => $result['data'] ?? [],
        ];
    }

    /**
     * Elimina un dispositivo de la plataforma GPSWox.
     */
    public function destroyDevice(int $deviceId): array
    {
        $result = $this->request('GET', 'destroy_device', ['device_id' => $deviceId]);

        return [
            'status'  => $result['status'] ?? 0,
            'message' => $result['data']['message'] ?? ($result['message'] ?? null),
        ];
    }

    /**
     * Cambia el estado activo/inactivo de uno o varios dispositivos.
     *
     * @param int|array $id      ID o arreglo de IDs
     * @param bool      $active
     */
    public function changeActiveDevice(int|array $id, bool $active): array
    {
        $result = $this->request('POST', 'change_active_device', [], [
            'id'     => $id,
            'active' => $active ? 1 : 0,
        ]);

        return [
            'status'  => $result['status'] ?? 0,
            'message' => $result['data']['message'] ?? ($result['message'] ?? null),
        ];
    }

    /**
     * Sincroniza un vehículo local con la plataforma:
     * - Busca el dispositivo por placa
     * - Si lo encuentra, guarda gpswox_id (y opcionalmente importa SIM)
     *
     * Útil para vehículos preexistentes que aún no tienen gpswox_id.
     *
     * @return array ['status' => 1|0, 'message' => string, 'gpswox_id' => ?int]
     */
    public function sincronizarVehiculoDesdePlataforma(Vehiculos $vehiculo): array
    {
        if (blank($vehiculo->placa)) {
            return ['status' => 0, 'message' => 'El vehículo no tiene placa', 'gpswox_id' => null];
        }

        try {
            $response = $this->getDeviceByPlate($vehiculo->placa);

            if (($response['status'] ?? 0) !== 1) {
                return [
                    'status'    => 0,
                    'message'   => $response['message'] ?? 'Dispositivo no encontrado en la plataforma',
                    'gpswox_id' => null,
                ];
            }

            $device    = $response['device'] ?? [];
            $gpswoxId  = isset($device['id']) ? (int) $device['id'] : null;
            $imei      = $device['imei'] ?? null;
            $simNumber = $device['sim_number'] ?? null;
            $active    = isset($device['active']) ? (bool) $device['active'] : null;

            if (!$gpswoxId) {
                return ['status' => 0, 'message' => 'La plataforma no devolvió un id válido', 'gpswox_id' => null];
            }

            $acciones = [];

            // ── 1. gpswox_id ───────────────────────────────────────────────────
            $vehiculo->gpswox_id              = $gpswoxId;
            $vehiculo->gpswox_sincronizado_at = now();
            if ($active !== null) {
                $vehiculo->gpswox_active = $active;
            }

            // ── 2. Dispositivo por IMEI en pivot vehiculos_dispositivos ──────────
            // La fuente de verdad es el IMEI almacenado en el pivot, no en dispositivos.
            if (!blank($imei)) {
                $pivotConEseImei = VehiculoDispositivos::where('vehiculo_id', $vehiculo->id)
                    ->where('imei', $imei)
                    ->whereNull('fecha_desinstalacion')
                    ->first();

                if ($pivotConEseImei) {
                    // Desmarcar cualquier otro principal activo del mismo vehículo
                    VehiculoDispositivos::where('vehiculo_id', $vehiculo->id)
                        ->whereNull('fecha_desinstalacion')
                        ->where('id', '!=', $pivotConEseImei->id)
                        ->where('is_principal', true)
                        ->update(['is_principal' => false]);

                    // Marcar este como principal
                    $pivotConEseImei->update(['is_principal' => true]);

                    // Actualizar el shortcut dispositivos_id en el vehículo
                    $vehiculo->dispositivos_id = $pivotConEseImei->dispositivo_id;
                    $acciones[] = "IMEI {$imei} marcado como dispositivo principal";
                } else {
                    // El IMEI no está en el historial del vehículo — buscar en catálogo
                    $dispositivo = Dispositivos::where('imei', $imei)->first();
                    if ($dispositivo) {
                        // Desmarcar principal previo
                        VehiculoDispositivos::where('vehiculo_id', $vehiculo->id)
                            ->whereNull('fecha_desinstalacion')
                            ->where('is_principal', true)
                            ->update(['is_principal' => false]);

                        VehiculoDispositivos::create([
                            'vehiculo_id'      => $vehiculo->id,
                            'dispositivo_id'   => $dispositivo->id,
                            'imei'             => $imei,
                            'is_principal'     => true,
                            'fecha_instalacion' => now(),
                        ]);

                        $vehiculo->dispositivos_id = $dispositivo->id;
                        $acciones[] = "IMEI {$imei} instalado como nuevo dispositivo principal";
                    } else {
                        $acciones[] = "IMEI {$imei} no encontrado en el sistema — regístralo primero";
                    }
                }
            }

            // ── 3. SIM / Línea ─────────────────────────────────────────────────
            if (!blank($simNumber)) {
                $vehiculo->numero = $simNumber;

                $linea = Lineas::where('numero', $simNumber)->first();
                if ($linea) {
                    $simCard = $linea->sim_card;
                    if ($simCard) {
                        $vehiculo->sim_card_id = $simCard->id;
                        $acciones[] = "SIM {$simNumber} vinculada";
                    } else {
                        $acciones[] = "línea {$simNumber} encontrada pero sin SIM card asignada";
                    }
                } else {
                    $acciones[] = "número {$simNumber} actualizado (línea no registrada en sistema)";
                }
            }

            $vehiculo->save();

            $resumen = implode('; ', $acciones) ?: 'sin cambios adicionales';

            Log::channel('daily')->info('[GpsWox] Vehículo sincronizado desde plataforma', [
                'placa'     => $vehiculo->placa,
                'gpswox_id' => $gpswoxId,
                'imei'      => $imei,
                'sim'       => $simNumber,
                'acciones'  => $acciones,
            ]);

            return [
                'status'    => 1,
                'message'   => "Vinculado con plataforma #{$gpswoxId}: {$resumen}",
                'gpswox_id' => $gpswoxId,
            ];
        } catch (\Throwable $e) {
            Log::channel('daily')->error('[GpsWox] Error al sincronizar vehículo desde plataforma', [
                'placa' => $vehiculo->placa,
                'error' => $e->getMessage(),
            ]);
            return ['status' => 0, 'message' => $e->getMessage(), 'gpswox_id' => null];
        }
    }
}
