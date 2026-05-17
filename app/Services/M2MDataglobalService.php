<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use App\Models\SimCard;
use App\Models\Operador;
use App\Scopes\EmpresaScope;

/**
 * Servicio para interactuar con la API REST de M2M Dataglobal
 *
 * Base URL: https://m2mcenter.app/apiclient/v1/
 * Autenticación: header X-API-KEY con el valor de M2M_TOKEN (.env)
 *
 * Métodos disponibles:
 * - simList()                        → Listado de todas las SIM cards
 * - simDetails($tipo, $valor)        → Detalle en tiempo real por icc / msisdn / imei
 * - testGsm($tipo, $valor)           → Test de conexión GSM
 * - testGprs($tipo, $valor)          → Test de conexión GPRS
 * - reset($tipo, $valor)             → Reset de SIM card
 * - sendSms($tipo, $valor, $mensaje) → Envío de SMS
 * - updateCustomFields($tipo, $valor, $fields) → Actualizar campos personalizados
 */
class M2MDataglobalService
{
    protected string $baseUrl;
    protected string $apiKey;

    // Tipos de identificador aceptados por la API
    const TIPO_ICC    = 'icc';
    const TIPO_MSISDN = 'msisdn';
    const TIPO_IMEI   = 'imei';

    public function __construct()
    {
        $this->baseUrl = config('services.m2m.base_url', 'https://m2mcenter.app/apiclient/v1');
        $this->apiKey  = config('services.m2m.token', '');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // LISTADO
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Obtiene el listado completo de SIM cards del cliente.
     *
     * @return array{status: bool, total: string|null, data: array|null, error: string|null}
     *
     * Ejemplo de un ítem en data:
     * [
     *   'icc'                   => '88888888888888888888',
     *   'msisdn'                => '5555555555',
     *   'planCode'              => 'GPS_CL_LBX_6M_2020_0',
     *   'planName'              => 'Movistar Smart Sin Fronteras Chile 6 MB',
     *   'imei'                  => '999999999999999',
     *   'consumptionMonthlyData'=> '4510720',
     *   'simCycleState'         => 'ACTIVATED',
     * ]
     */
    public function simList(): array
    {
        return $this->get('sims/simList');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // SINCRONIZACIÓN
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Slug que identifica este servicio en la tabla operadores (campo api_slug).
     */
    const API_SLUG = 'm2m_dataglobal';

    /**
     * Sincroniza las SIM cards de la API hacia la tabla local sim_card.
     *
     * - Inserta las ICC nuevas (nunca vistas).
     * - Actualiza el operador_id de las existentes si cambió.
     * - No toca lineas_id, estado ni deleted_at.
     *
     * @param  Operador $operador  El operador local al que se asignarán las SIMs.
     * @param  int      $empresaId ID de la empresa (tenant).
     * @return array{insertados: int, actualizados: int, error: string|null}
     */
    public function sincronizar(Operador $operador, int $empresaId): array
    {
        $resultado = $this->simList();

        if (! $resultado['status'] || empty($resultado['data'])) {
            return [
                'insertados'  => 0,
                'actualizados' => 0,
                'error'       => $resultado['error'] ?? 'La API no devolvió datos.',
            ];
        }

        $insertados  = 0;
        $actualizados = 0;

        foreach ($resultado['data'] as $item) {
            $icc = trim($item['icc'] ?? '');
            if ($icc === '') {
                continue;
            }

            $existente = SimCard::withoutGlobalScope(EmpresaScope::class)
                ->where('sim_card', $icc)
                ->where('empresa_id', $empresaId)
                ->first();

            if ($existente) {
                // Solo actualiza el operador si cambió
                if ($existente->operador_id !== $operador->id) {
                    $existente->operador_id = $operador->id;
                    $existente->saveQuietly(); // sin disparar eventos de auditoría
                    $actualizados++;
                }
            } else {
                SimCard::withoutGlobalScope(EmpresaScope::class)->create([
                    'sim_card'    => $icc,
                    'operador_id' => $operador->id,
                    'empresa_id'  => $empresaId,
                    'estado'      => 1,
                ]);
                $insertados++;
            }
        }

        Log::info("[M2MDataglobal] Sincronización empresa {$empresaId}: +{$insertados} nuevas, {$actualizados} actualizadas.");

        return [
            'insertados'  => $insertados,
            'actualizados' => $actualizados,
            'error'       => null,
        ];
    }

    // ──────────────────────────────────────────────────────────────────────────
    // DETALLE
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Obtiene el detalle en tiempo real de una SIM card.
     *
     * @param string $tipo  Uno de: 'icc' | 'msisdn' | 'imei'
     * @param string $valor El identificador de la SIM
     *
     * @return array{status: bool, data: array|null, message: string|null, error: string|null}
     *
     * Campos disponibles en data:
     *   icc, msisdn, planCode, planName, imsi, apn, imei, ip,
     *   simType, simCycleState, gprsStatus, lastConnStart, lastConnStop,
     *   operator, latitude, longitude, customField1, customField2,
     *   commModuleManufacturer, commModuleModel,
     *   consumptionMonthlyData, consumptionDailyData
     */
    public function simDetails(string $tipo, string $valor): array
    {
        $this->validarTipo($tipo);
        return $this->get("sims/simDetails/{$tipo}/{$valor}");
    }

    /**
     * Atajo: detalle por ICC
     */
    public function simDetailsByIcc(string $icc): array
    {
        return $this->simDetails(self::TIPO_ICC, $icc);
    }

    /**
     * Atajo: detalle por MSISDN
     */
    public function simDetailsByMsisdn(string $msisdn): array
    {
        return $this->simDetails(self::TIPO_MSISDN, $msisdn);
    }

    /**
     * Atajo: detalle por IMEI
     */
    public function simDetailsByImei(string $imei): array
    {
        return $this->simDetails(self::TIPO_IMEI, $imei);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // TESTS DE CONEXIÓN
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Ejecuta un test de conexión GSM sobre la SIM.
     *
     * @param string $tipo  Uno de: 'icc' | 'msisdn' | 'imei'
     * @param string $valor El identificador de la SIM
     *
     * @return array{status: bool, data: array{result: string}|null, message: string|null, error: string|null}
     *   Posibles values en data.result: 'GSM_UP', 'GSM_DOWN', etc.
     */
    public function testGsm(string $tipo, string $valor): array
    {
        $this->validarTipo($tipo);
        return $this->get("sims/testGsm/{$tipo}/{$valor}");
    }

    /**
     * Ejecuta un test de conexión GPRS sobre la SIM.
     *
     * @param string $tipo  Uno de: 'icc' | 'msisdn' | 'imei'
     * @param string $valor El identificador de la SIM
     *
     * @return array{status: bool, data: array{result: string}|null, message: string|null, error: string|null}
     *   Posibles values en data.result: 'GPRS_UP', 'GPRS_DOWN', etc.
     */
    public function testGprs(string $tipo, string $valor): array
    {
        $this->validarTipo($tipo);
        return $this->get("sims/testGprs/{$tipo}/{$valor}");
    }

    // ──────────────────────────────────────────────────────────────────────────
    // RESET
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Realiza un reset de la SIM card.
     *
     * @param string $tipo  Uno de: 'icc' | 'msisdn' | 'imei'
     * @param string $valor El identificador de la SIM
     *
     * @return array{status: bool, message: string|null, error: string|null}
     */
    public function reset(string $tipo, string $valor): array
    {
        $this->validarTipo($tipo);
        return $this->get("sims/reset/{$tipo}/{$valor}");
    }

    // ──────────────────────────────────────────────────────────────────────────
    // SMS
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Envía un SMS a la SIM card.
     *
     * @param string $tipo    Uno de: 'icc' | 'msisdn' | 'imei'
     * @param string $valor   El identificador de la SIM
     * @param string $mensaje El texto a enviar (máx. 160 caracteres recomendado)
     *
     * @return array{status: bool, message: string|null, error: string|null}
     */
    public function sendSms(string $tipo, string $valor, string $mensaje): array
    {
        $this->validarTipo($tipo);
        return $this->post("sims/sms/{$tipo}/{$valor}", ['message' => $mensaje]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CAMPOS PERSONALIZADOS
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Actualiza los campos personalizados de una SIM card.
     *
     * @param string $tipo   Uno de: 'icc' | 'msisdn' | 'imei'
     * @param string $valor  El identificador de la SIM
     * @param array  $fields Campos a actualizar. Puede incluir:
     *                       ['customField1' => 'valor1', 'customField2' => 'valor2']
     *                       Se puede enviar uno o ambos en la misma llamada.
     *
     * @return array{status: bool, message: string|null, error: string|null}
     */
    public function updateCustomFields(string $tipo, string $valor, array $fields): array
    {
        $this->validarTipo($tipo);

        $payload = array_filter([
            'customField1' => $fields['customField1'] ?? null,
            'customField2' => $fields['customField2'] ?? null,
        ], fn($v) => $v !== null);

        return $this->post("customfields/sms/{$tipo}/{$valor}", $payload);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // HTTP HELPERS PRIVADOS
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Realiza una petición GET a la API.
     */
    private function get(string $endpoint): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->timeout(30)
                ->get("{$this->baseUrl}/{$endpoint}");

            return $this->parseResponse($response, $endpoint);
        } catch (\Exception $e) {
            Log::error("[M2MDataglobal] GET {$endpoint} falló: " . $e->getMessage());
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Realiza una petición POST a la API.
     */
    private function post(string $endpoint, array $body): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->timeout(30)
                ->post("{$this->baseUrl}/{$endpoint}", $body);

            return $this->parseResponse($response, $endpoint);
        } catch (\Exception $e) {
            Log::error("[M2MDataglobal] POST {$endpoint} falló: " . $e->getMessage());
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Cabeceras requeridas por la API.
     */
    private function headers(): array
    {
        return [
            'X-API-KEY'    => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
            'User-Agent'   => config('app.name', 'Talentus') . '/1.0',
        ];
    }

    /**
     * Parsea la respuesta HTTP y la normaliza.
     */
    private function parseResponse(Response $response, string $endpoint): array
    {
        if ($response->failed()) {
            Log::warning("[M2MDataglobal] {$endpoint} → HTTP {$response->status()}");
            return $this->errorResponse("Error HTTP {$response->status()}");
        }

        $json = $response->json();

        if (! is_array($json)) {
            Log::warning("[M2MDataglobal] {$endpoint} → respuesta no es JSON válido");
            return $this->errorResponse('Respuesta inválida de la API');
        }

        return $json;
    }

    /**
     * Estructura de respuesta de error uniforme.
     */
    private function errorResponse(string $message): array
    {
        return [
            'status' => false,
            'error'  => $message,
            'data'   => null,
        ];
    }

    /**
     * Valida que el tipo de identificador sea uno de los permitidos.
     *
     * @throws \InvalidArgumentException
     */
    private function validarTipo(string $tipo): void
    {
        $permitidos = [self::TIPO_ICC, self::TIPO_MSISDN, self::TIPO_IMEI];

        if (! in_array($tipo, $permitidos, true)) {
            throw new \InvalidArgumentException(
                "Tipo de identificador inválido: '{$tipo}'. Use: " . implode(', ', $permitidos)
            );
        }
    }
}
