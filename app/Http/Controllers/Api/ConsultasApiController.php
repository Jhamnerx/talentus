<?php

namespace App\Http\Controllers\Api;

use App\Models\Actas;
use App\Models\Certificados;
use App\Models\CertificadosVelocimetros;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Scopes\EmpresaScope;

class ConsultasApiController extends Controller
{
    /**
     * Buscar acta por código
     * 
     * @param string $codigo Código del acta
     * @return JsonResponse
     */
    public function buscarActa(string $codigo): JsonResponse
    {
        $acta = Actas::withoutGlobalScope(EmpresaScope::class)
            ->where('codigo', $codigo)
            ->with([
                'vehiculo:id,placa,marca,modelo,year,color,clientes_id',
                'vehiculo.cliente:id,razon_social',
                'ciudades:id,nombre'
            ])
            ->first();

        if (!$acta) {
            return response()->json([
                'success' => false,
                'message' => 'Acta no encontrada'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'acta' => [
                    'id' => $acta->id,
                    'codigo' => $acta->codigo,
                    'unique_hash' => $acta->unique_hash,
                    'fecha_instalacion' => $acta->fecha_instalacion?->format('Y-m-d'),
                    'inicio_cobertura' => $acta->inicio_cobertura?->format('Y-m-d'),
                    'fin_cobertura' => $acta->fin_cobertura?->format('Y-m-d'),
                    'estado' => $acta->estado,
                    'ciudad' => $acta->ciudades?->nombre,
                ],
                'vehiculo' => $acta->vehiculo ? [
                    'id' => $acta->vehiculo->id,
                    'placa' => $acta->vehiculo->placa,
                    'marca' => $acta->vehiculo->marca,
                    'modelo' => $acta->vehiculo->modelo,
                    'year' => $acta->vehiculo->year,
                    'color' => $acta->vehiculo->color,
                ] : null,
                'cliente' => $acta->vehiculo?->cliente ? [
                    'razon_social' => $acta->vehiculo->cliente->razon_social,
                ] : null,
            ]
        ]);
    }

    /**
     * Buscar certificado GPS por código
     * 
     * @param string $codigo Código del certificado
     * @return JsonResponse
     */
    public function buscarCertificadoGps(string $codigo): JsonResponse
    {
        $certificado = Certificados::withoutGlobalScope(EmpresaScope::class)
            ->where('codigo', $codigo)
            ->with([
                'vehiculo:id,placa,marca,modelo,year,color,clientes_id',
                'vehiculo.cliente:id,razon_social',
                'ciudades:id,nombre'
            ])
            ->first();

        if (!$certificado) {
            return response()->json([
                'success' => false,
                'message' => 'Certificado GPS no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'certificado' => [
                    'id' => $certificado->id,
                    'codigo' => $certificado->codigo,
                    'unique_hash' => $certificado->unique_hash,
                    'fecha_instalacion' => $certificado->fecha_instalacion?->format('Y-m-d'),
                    'fin_cobertura' => $certificado->fin_cobertura?->format('Y-m-d'),
                    'estado' => $certificado->estado,
                    'ciudad' => $certificado->ciudades?->nombre,
                    'imei' => $certificado->imei,
                    'year' => $certificado->year,
                ],
                'vehiculo' => $certificado->vehiculo ? [
                    'id' => $certificado->vehiculo->id,
                    'placa' => $certificado->vehiculo->placa,
                    'marca' => $certificado->vehiculo->marca,
                    'modelo' => $certificado->vehiculo->modelo,
                    'year' => $certificado->vehiculo->year,
                    'color' => $certificado->vehiculo->color,
                ] : null,
                'cliente' => $certificado->vehiculo?->cliente ? [
                    'razon_social' => $certificado->vehiculo->cliente->razon_social,
                ] : null,
            ]
        ]);
    }

    /**
     * Buscar certificado de velocímetro por código
     * 
     * @param string $codigo Código del certificado
     * @return JsonResponse
     */
    public function buscarCertificadoVelocimetro(string $codigo): JsonResponse
    {
        $certificado = CertificadosVelocimetros::withoutGlobalScope(EmpresaScope::class)
            ->where('codigo', $codigo)
            ->with([
                'vehiculo:id,placa,marca,modelo,year,color,clientes_id',
                'vehiculo.cliente:id,razon_social',
                'ciudades:id,nombre'
            ])
            ->first();

        if (!$certificado) {
            return response()->json([
                'success' => false,
                'message' => 'Certificado de velocímetro no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'certificado' => [
                    'id' => $certificado->id,
                    'codigo' => $certificado->codigo,
                    'unique_hash' => $certificado->unique_hash,
                    'numero' => $certificado->numero,
                    'fecha' => $certificado->fecha,
                    'velocimetro_modelo' => $certificado->velocimetro_modelo,
                    'year' => $certificado->year,
                    'estado' => $certificado->estado,
                    'ciudad' => $certificado->ciudades?->nombre,
                ],
                'vehiculo' => $certificado->vehiculo ? [
                    'id' => $certificado->vehiculo->id,
                    'placa' => $certificado->vehiculo->placa,
                    'marca' => $certificado->vehiculo->marca,
                    'modelo' => $certificado->vehiculo->modelo,
                    'year' => $certificado->vehiculo->year,
                    'color' => $certificado->vehiculo->color,
                ] : null,
                'cliente' => $certificado->vehiculo?->cliente ? [
                    'razon_social' => $certificado->vehiculo->cliente->razon_social,
                ] : null,
            ]
        ]);
    }

    /**
     * Consultar transmisión de vehículo por placa
     * 
     * @param string $placa Placa del vehículo
     * @return JsonResponse
     */
    public function consultarTransmision(string $placa): JsonResponse
    {
        try {
            // Buscar el vehículo
            $vehiculo = \App\Models\Vehiculos::withoutGlobalScope(EmpresaScope::class)
                ->where('placa', strtoupper($placa))
                ->with([
                    'cliente:id,razon_social',
                    'actas' => function ($query) {
                        $query->latest()->limit(1);
                    },
                    'contratos' => function ($query) {
                        $query->latest();
                    }
                ])
                ->first();

            if (!$vehiculo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vehículo no encontrado'
                ], 404);
            }

            // Consultar dispositivo en GPS
            $apiController = new \App\Http\Controllers\GpsWox\Api\GpsWoxApiController();
            $request = new \Illuminate\Http\Request([
                'plate_number' => $placa,
                'limit' => 1
            ]);

            $devices = $apiController->getDevices($request);

            if (empty($devices)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró dispositivo GPS para esta placa'
                ], 404);
            }

            // Procesar respuesta - Mismo formato que el componente Livewire
            $deviceData = null;
            $transmitiendo = false;

            foreach ($devices as $group) {
                if (isset($group['items'][0]['device_data'])) {
                    $deviceData = $group['items'][0]['device_data'];
                    // Si hay datos del dispositivo, está transmitiendo
                    $transmitiendo = !empty($deviceData);
                    break;
                }
            }

            // Convertir fecha UTC a America/Lima
            $ultimaActualizacion = null;
            if (isset($deviceData['time'])) {
                $ultimaActualizacion = \Carbon\Carbon::parse($deviceData['time'], 'UTC')
                    ->setTimezone('America/Lima')
                    ->format('Y-m-d H:i:s');
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'vehiculo' => [
                        'id' => $vehiculo->id,
                        'placa' => $vehiculo->placa,
                        'marca' => $vehiculo->marca,
                        'modelo' => $vehiculo->modelo,
                        'year' => $vehiculo->year,
                        'color' => $vehiculo->color,
                    ],
                    'cliente' => [
                        'razon_social' => $vehiculo->cliente?->razon_social,
                    ],
                    'dispositivo' => [
                        'imei' => $deviceData['imei'] ?? null,
                        'nombre' => $deviceData['name'] ?? null,
                        'transmitiendo' => $transmitiendo,
                        'ultima_actualizacion' => $ultimaActualizacion,
                    ],
                    'ultima_acta' => $vehiculo->actas->first() ? [
                        'codigo' => $vehiculo->actas->first()->codigo,
                        'unique_hash' => $vehiculo->actas->first()->unique_hash,
                        'fecha_instalacion' => $vehiculo->actas->first()->fecha_instalacion?->format('Y-m-d'),
                        'fin_cobertura' => $vehiculo->actas->first()->fin_cobertura?->format('Y-m-d'),
                        'pdf_url' => route('api.consultas.acta.pdf', ['codigo' => $vehiculo->actas->first()->codigo]),
                    ] : null,
                    'contratos' => $vehiculo->contratos->map(function ($contrato) {
                        return [
                            'id' => $contrato->id,
                            'unique_hash' => $contrato->unique_hash,
                            'numero' => $contrato->numero,
                            'fecha_inicio' => $contrato->fecha?->format('Y-m-d'),
                            'estado' => $contrato->estado,
                            'pdf_url' => route('api.consultas.contrato.pdf', ['hash' => $contrato->unique_hash]),
                        ];
                    })->toArray(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al consultar transmisión: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener PDF de acta en base64
     * 
     * @param string $codigo Código del acta
     * @return JsonResponse
     */
    public function obtenerPdfActa(string $codigo): JsonResponse
    {
        try {
            $acta = Actas::withoutGlobalScope(EmpresaScope::class)
                ->where('codigo', $codigo)
                ->first();

            if (!$acta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acta no encontrada'
                ], 404);
            }

            // Generar PDF
            $pdf = $acta->getPDFData();
            $pdfContent = $pdf->output();
            $pdfBase64 = base64_encode($pdfContent);

            return response()->json([
                'success' => true,
                'data' => [
                    'codigo' => $acta->codigo,
                    'filename' => "acta_{$acta->codigo}.pdf",
                    'pdf_base64' => $pdfBase64,
                    'content_type' => 'application/pdf',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener PDF de contrato en base64
     * 
     * @param string $hash Unique hash del contrato
     * @return JsonResponse
     */
    public function obtenerPdfContrato(string $hash): JsonResponse
    {
        try {
            $contrato = \App\Models\Contratos::withoutGlobalScope(EmpresaScope::class)
                ->where('unique_hash', $hash)
                ->first();

            if (!$contrato) {
                return response()->json([
                    'success' => false,
                    'message' => 'Contrato no encontrado'
                ], 404);
            }

            // Generar PDF (asumiendo que el modelo tiene un método similar)
            if (method_exists($contrato, 'getPDFData')) {
                $pdf = $contrato->getPDFData();
                $pdfContent = $pdf->output();
                $pdfBase64 = base64_encode($pdfContent);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'unique_hash' => $contrato->unique_hash,
                        'numero' => $contrato->numero,
                        'filename' => "contrato_{$contrato->numero}.pdf",
                        'pdf_base64' => $pdfBase64,
                        'content_type' => 'application/pdf',
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede generar PDF para este contrato'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage()
            ], 500);
        }
    }
}
