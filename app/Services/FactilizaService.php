<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

/**
 * Servicio para consumir la API de Factiliza
 * 
 * @see https://api.factiliza.com/docs
 */
class FactilizaService
{
    /**
     * Base URL de la API de Factiliza
     */
    protected string $baseUrl = 'https://api.factiliza.com/v1/';

    /**
     * Token de autenticación
     */
    protected string $token;

    /**
     * Cliente Guzzle
     */
    protected Client $client;

    /**
     * Constructor del servicio
     */
    public function __construct()
    {
        $this->token = config('services.factiliza.token', '');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30.0,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Realiza una petición GET a la API de Factiliza
     * 
     * @param string $endpoint
     * @return array
     */
    protected function get(string $endpoint): array
    {
        try {
            $response = $this->client->get($endpoint);
            $body = $response->getBody()->getContents();
            $result = json_decode($body, true) ?? [];

            // Aplanar la respuesta: mover data al nivel principal
            if (isset($result['data'])) {
                $data = $result['data'];
                unset($result['data']);
                return array_merge($result, $data);
            }

            return $result;
        } catch (RequestException $e) {
            // Obtener el cuerpo de la respuesta de error si existe
            $errorBody = null;
            $userMessage = 'No se encontró información';
            $statusCode = $e->getCode();

            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                $errorData = json_decode($errorBody, true);
                $statusCode = $e->getResponse()->getStatusCode();

                // Determinar mensaje amigable según el código de error
                if ($statusCode === 404) {
                    $userMessage = 'No se encontró información para el número consultado';
                } elseif ($statusCode === 400) {
                    $userMessage = 'El número consultado no es válido';
                } elseif ($statusCode === 401 || $statusCode === 403) {
                    $userMessage = 'Error de autenticación con el servicio';
                } elseif ($statusCode === 405) {
                    // Extraer mensaje específico del body si existe
                    if (isset($errorData['message'])) {
                        $userMessage = $errorData['message'];
                    } else {
                        $userMessage = 'El servicio de consulta no está disponible';
                    }
                } elseif ($statusCode >= 500) {
                    $userMessage = 'El servicio no está disponible temporalmente';
                }
            }

            // Log detallado para desarrolladores
            Log::error('Error en Factiliza API GET', [
                'endpoint' => $endpoint,
                'status_code' => $statusCode,
                'error_message' => $e->getMessage(),
                'error_body' => $errorBody,
            ]);

            return [
                'status' => $statusCode ?: 500,
                'success' => false,
                'message' => $userMessage,
            ];
        } catch (GuzzleException $e) {
            // Log de errores de conexión u otros errores de Guzzle
            Log::error('Error de conexión en Factiliza API GET', [
                'endpoint' => $endpoint,
                'exception' => $e->getMessage(),
            ]);

            return [
                'status' => 500,
                'success' => false,
                'message' => 'Error de conexión con el servicio',
            ];
        } catch (\Exception $e) {
            // Log de errores inesperados
            Log::error('Error inesperado en Factiliza API GET', [
                'endpoint' => $endpoint,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al procesar la solicitud',
            ];
        }
    }

    /**
     * Realiza una petición POST a la API de Factiliza
     * 
     * @param string $endpoint
     * @param array $data
     * @return array
     */
    protected function post(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->client->post($endpoint, [
                'json' => $data
            ]);

            $body = $response->getBody()->getContents();
            $result = json_decode($body, true) ?? [];

            // Aplanar la respuesta: mover data al nivel principal
            if (isset($result['data'])) {
                $dataContent = $result['data'];
                unset($result['data']);
                return array_merge($result, $dataContent);
            }

            return $result;
        } catch (RequestException $e) {
            // Obtener el cuerpo de la respuesta de error si existe
            $errorBody = null;
            $userMessage = 'No se pudo completar la operación';
            $statusCode = $e->getCode();

            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                $errorData = json_decode($errorBody, true);
                $statusCode = $e->getResponse()->getStatusCode();

                // Determinar mensaje amigable según el código de error
                if ($statusCode === 404) {
                    $userMessage = 'No se encontró el recurso solicitado';
                } elseif ($statusCode === 400) {
                    $userMessage = 'Los datos enviados no son válidos';
                } elseif ($statusCode === 401 || $statusCode === 403) {
                    $userMessage = 'Error de autenticación con el servicio';
                } elseif ($statusCode === 405) {
                    // Extraer mensaje específico del body si existe
                    if (isset($errorData['message'])) {
                        $userMessage = $errorData['message'];
                    } else {
                        $userMessage = 'El servicio de consulta no está disponible';
                    }
                } elseif ($statusCode >= 500) {
                    $userMessage = 'El servicio no está disponible temporalmente';
                }
            }

            // Log detallado para desarrolladores
            Log::error('Error en Factiliza API POST', [
                'endpoint' => $endpoint,
                'status_code' => $statusCode,
                'error_message' => $e->getMessage(),
                'error_body' => $errorBody,
                'request_data' => $data,
            ]);

            return [
                'status' => $statusCode ?: 500,
                'success' => false,
                'message' => $userMessage,
            ];
        } catch (GuzzleException $e) {
            // Log de errores de conexión u otros errores de Guzzle
            Log::error('Error de conexión en Factiliza API POST', [
                'endpoint' => $endpoint,
                'exception' => $e->getMessage(),
                'request_data' => $data,
            ]);

            return [
                'status' => 500,
                'success' => false,
                'message' => 'Error de conexión con el servicio',
            ];
        } catch (\Exception $e) {
            // Log de errores inesperados
            Log::error('Error inesperado en Factiliza API POST', [
                'endpoint' => $endpoint,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $data,
            ]);

            return [
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al procesar la solicitud',
            ];
        }
    }

    /**
     * Consulta información de un DNI
     * 
     * @param string $dni Número de DNI a consultar (8 dígitos)
     * @return array Retorna datos personales según el DNI
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarDni('27427864');
     * // Retorna: nombres, apellido_paterno, apellido_materno, departamento, provincia, distrito, direccion, ubigeo, etc.
     */
    public function consultarDni(string $dni): array
    {
        return $this->get("dni/info/{$dni}");
    }

    /**
     * Consulta información de un RUC
     * 
     * @param string $ruc Número de RUC a consultar (11 dígitos)
     * @return array Retorna datos de la empresa según el RUC
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarRuc('20552103816');
     * // Retorna: nombre_o_razon_social, tipo_contribuyente, estado, condicion, direccion, ubigeo, etc.
     */
    public function consultarRuc(string $ruc): array
    {
        return $this->get("ruc/info/{$ruc}");
    }

    /**
     * Consulta los establecimientos (anexos) de un RUC
     * 
     * @param string $ruc Número de RUC a consultar (11 dígitos)
     * @return array Retorna lista de establecimientos registrados
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarRucEstablecimientos('20552103816');
     * // Retorna array de establecimientos: codigo, tipo_establecimiento, direccion, ubigeo, etc.
     */
    public function consultarRucEstablecimientos(string $ruc): array
    {
        return $this->get("ruc/anexo/{$ruc}");
    }

    /**
     * Consulta los representantes legales de un RUC
     * 
     * @param string $ruc Número de RUC a consultar (11 dígitos)
     * @return array Retorna lista de representantes legales
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarRucRepresentantes('20552103816');
     * // Retorna array de representantes: tipo_de_documento, numero_de_documento, nombre, cargo, fecha_desde
     */
    public function consultarRucRepresentantes(string $ruc): array
    {
        return $this->get("ruc/representante/{$ruc}");
    }

    /**
     * Consulta información de un Carnet de Extranjería
     * 
     * @param string $cee Número de Carnet de Extranjería a consultar
     * @return array Retorna datos personales del extranjero
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarCarnetExtranjeria('001077238');
     * // Retorna: numero, nombres, apellido_paterno, apellido_materno
     */
    public function consultarCarnetExtranjeria(string $cee): array
    {
        return $this->get("cee/info/{$cee}");
    }

    /**
     * Consulta el tipo de cambio del día o de una fecha específica
     * Primero busca en la base de datos, si no existe consulta la API y guarda el resultado
     * 
     * @param string|null $fecha Fecha en formato Y-m-d (opcional, por defecto hoy)
     * @param bool $forzarApi Forzar consulta a la API ignorando caché (default: false)
     * @return array Retorna tipo de cambio de compra y venta
     * 
     * @example
     * $data = (new FactilizaService())->consultarTipoCambio('2024-01-01');
     * // Retorna: fecha, compra, venta, desde_cache
     */
    public function consultarTipoCambio(?string $fecha = null, bool $forzarApi = false): array
    {
        $fecha = $fecha ?? \Carbon\Carbon::today()->format('Y-m-d');

        // Buscar en la base de datos primero
        if (!$forzarApi) {
            $tipoCambio = \App\Models\TipoCambio::porFecha($fecha);

            if ($tipoCambio) {
                return [
                    'status' => 200,
                    'success' => true,
                    'message' => 'Tipo de cambio obtenido desde base de datos',
                    'desde_cache' => true,
                    'fecha' => $tipoCambio->fecha->format('Y-m-d'),
                    'compra' => (float) $tipoCambio->compra,
                    'venta' => (float) $tipoCambio->venta,
                ];
            }
        }

        // Si no existe en DB o se fuerza, consultar la API
        $endpoint = "tipocambio/info/dia?fecha={$fecha}";
        $resultado = $this->get($endpoint);

        // Si la consulta fue exitosa, guardar en la base de datos
        if ($resultado['success'] ?? false && isset($resultado['fecha'])) {
            try {
                \App\Models\TipoCambio::guardar([
                    'fecha' => $resultado['fecha'],
                    'compra' => $resultado['compra'],
                    'venta' => $resultado['venta'],
                    'fuente' => 'factiliza',
                ]);

                $resultado['desde_cache'] = false;
                $resultado['message'] = 'Tipo de cambio obtenido desde API y guardado en cache';
            } catch (\Exception $e) {
                Log::error('Error al guardar tipo de cambio en DB: ' . $e->getMessage());
            }
        }

        return $resultado;
    }

    /**
     * Consulta información de una placa vehicular
     * 
     * @param string $placa Número de placa a consultar
     * @return array Retorna datos del vehículo
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarPlaca('F3H792');
     * // Retorna: placa, marca, modelo, serie, color, motor, vin
     */
    public function consultarPlaca(string $placa): array
    {
        return $this->get("placa/info/{$placa}");
    }

    /**
     * Consulta información del SOAT de un vehículo
     * 
     * @param string $placa Número de placa a consultar
     * @return array Retorna datos del SOAT vigente
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarSoat('F3H792');
     * // Retorna: información del SOAT vigente
     */
    public function consultarSoat(string $placa): array
    {
        return $this->get("soat/info/{$placa}");
    }

    /**
     * Consulta información de una licencia de conducir
     * 
     * @param string $licencia Número de licencia a consultar
     * @return array Retorna datos de la licencia
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarLicenciaConducir('L12345678');
     * // Retorna: información de la licencia de conducir
     */
    public function consultarLicenciaConducir(string $licencia): array
    {
        return $this->get("licencia-conducir/info/{$licencia}");
    }

    /**
     * Consulta un Comprobante de Pago Electrónico (CPE) en SUNAT
     * 
     * @param array $data Datos del comprobante
     *   - numRuc: RUC del emisor
     *   - tipoDocumento: Tipo de comprobante (01=factura, 03=boleta, etc.)
     *   - numSerieComprobante: Serie del comprobante
     *   - numDocumentoComprobante: Número del comprobante
     * @return array Retorna estado del CPE en SUNAT
     * 
     * @example
     * $data = app(FactilizaService::class)->consultarCPE([
     *     'numRuc' => '20123456789',
     *     'tipoDocumento' => '01',
     *     'numSerieComprobante' => 'F001',
     *     'numDocumentoComprobante' => '00000123'
     * ]);
     */
    public function consultarCPE(array $data): array
    {
        return $this->post("sunat/cpe", $data);
    }

    /**
     * Descarga el XML de un comprobante desde SUNAT
     * 
     * @param string $numRuc RUC del emisor (11 dígitos)
     * @param string $tipoDocumento Tipo de comprobante (01, 03, 07, 08, etc.)
     * @param string $numSerieComprobante Serie del comprobante
     * @param string $numDocumentoComprobante Número del comprobante
     * @return array Retorna el XML del comprobante
     * 
     * @example
     * $xml = app(FactilizaService::class)->descargarXML('20123456789', '01', 'F001', '00000123');
     */
    public function descargarXML(string $numRuc, string $tipoDocumento, string $numSerieComprobante, string $numDocumentoComprobante): array
    {
        $documento = "{$numRuc}-{$tipoDocumento}-{$numSerieComprobante}-{$numDocumentoComprobante}";
        return $this->get("sunat/xml/{$documento}");
    }

    /**
     * Descarga el PDF de un comprobante desde SUNAT
     * 
     * @param string $numRuc RUC del emisor (11 dígitos)
     * @param string $tipoDocumento Tipo de comprobante (01, 03, 07, 08, etc.)
     * @param string $numSerieComprobante Serie del comprobante
     * @param string $numDocumentoComprobante Número del comprobante
     * @return array Retorna el PDF del comprobante en base64
     * 
     * @example
     * $pdf = app(FactilizaService::class)->descargarPDF('20123456789', '01', 'F001', '00000123');
     */
    public function descargarPDF(string $numRuc, string $tipoDocumento, string $numSerieComprobante, string $numDocumentoComprobante): array
    {
        $documento = "{$numRuc}-{$tipoDocumento}-{$numSerieComprobante}-{$numDocumentoComprobante}";
        return $this->get("sunat/pdf/{$documento}");
    }

    /**
     * Descarga el CDR (Constancia de Recepción) de un comprobante desde SUNAT
     * 
     * @param string $numRuc RUC del emisor (11 dígitos)
     * @param string $tipoDocumento Tipo de comprobante (01, 03, 07, 08, etc.)
     * @param string $numSerieComprobante Serie del comprobante
     * @param string $numDocumentoComprobante Número del comprobante
     * @return array Retorna el CDR en formato ZIP
     * 
     * @example
     * $cdr = app(FactilizaService::class)->descargarCDR('20123456789', '01', 'F001', '00000123');
     */
    public function descargarCDR(string $numRuc, string $tipoDocumento, string $numSerieComprobante, string $numDocumentoComprobante): array
    {
        $documento = "{$numRuc}-{$tipoDocumento}-{$numSerieComprobante}-{$numDocumentoComprobante}";
        return $this->get("sunat/cdr/{$documento}");
    }

    /**
     * Descarga el JSON de una Guía de Remisión desde SUNAT
     * 
     * @param string $numRuc RUC del emisor (11 dígitos)
     * @param string $tipoDocumento Tipo de guía (09=Guía de Remisión Remitente)
     * @param string $numSerieComprobante Serie de la guía
     * @param string $numDocumentoComprobante Número de la guía
     * @return array Retorna el JSON de la guía
     * 
     * @example
     * $guia = app(FactilizaService::class)->descargarGuiaJSON('20123456789', '09', 'T001', '00000123');
     */
    public function descargarGuiaJSON(string $numRuc, string $tipoDocumento, string $numSerieComprobante, string $numDocumentoComprobante): array
    {
        $documento = "{$numRuc}-{$tipoDocumento}-{$numSerieComprobante}-{$numDocumentoComprobante}";
        return $this->get("sunat/guia/{$documento}");
    }

    /**
     * Descarga el XML de una Guía de Remisión desde SUNAT
     * 
     * @param string $numRuc RUC del emisor (11 dígitos)
     * @param string $tipoDocumento Tipo de guía (09=Guía de Remisión Remitente)
     * @param string $numSerieComprobante Serie de la guía
     * @param string $numDocumentoComprobante Número de la guía
     * @return array Retorna el XML de la guía
     * 
     * @example
     * $guia = app(FactilizaService::class)->descargarGuiaXML('20123456789', '09', 'T001', '00000123');
     */
    public function descargarGuiaXML(string $numRuc, string $tipoDocumento, string $numSerieComprobante, string $numDocumentoComprobante): array
    {
        $documento = "{$numRuc}-{$tipoDocumento}-{$numSerieComprobante}-{$numDocumentoComprobante}";
        return $this->get("sunat/guia-xml/{$documento}");
    }
}
