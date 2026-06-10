<?php

namespace App\Http\Controllers\Api;

use App\Models\Dispositivos;
use App\Models\Lineas;
use App\Models\VehiculoDispositivos;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

/**
 * Webhook recibido desde la plataforma de rastreo GPSWox.
 *
 * La plataforma envía este POST cada vez que se guarda o actualiza un dispositivo.
 * Solo se permite desde TRACKING_ALLOWED_IP (middleware AllowedTrackingIp).
 *
 * Payload esperado (todos opcionales excepto plate_number):
 *   plate_number  string   Placa del vehículo — clave de búsqueda
 *   id            int      ID del dispositivo en la plataforma (gpswox_id)
 *   imei          string   IMEI del dispositivo principal
 *   sim_number    string   Número de SIM
 *   active        bool     Estado activo/inactivo en plataforma
 *   name          string   Nombre del dispositivo en plataforma (ignorado)
 */
class TrackingWebhookController extends Controller
{
    public function deviceSync(Request $request): JsonResponse
    {
        $plateNumber = strtoupper(trim($request->input('plate_number', '')));
        $gpswoxId    = $request->input('id');
        $imei        = trim($request->input('imei', ''));
        $simNumber   = trim($request->input('sim_number', ''));
        $activeInput = $request->input('active');
        $active      = ($request->has('active') && $activeInput !== null)
            ? filter_var($activeInput, FILTER_VALIDATE_BOOLEAN)
            : null;

        if (blank($plateNumber)) {
            return response()->json(['status' => 0, 'message' => 'plate_number es requerido'], 422);
        }

        // Buscar vehículo por placa ignorando el scope de empresa (contexto API)
        $vehiculo = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('placa', $plateNumber)
            ->first();

        if (!$vehiculo) {
            Log::channel('daily')->info('[TrackingWebhook] Placa no encontrada', [
                'plate_number' => $plateNumber,
            ]);
            return response()->json(['status' => 0, 'message' => "Vehículo con placa {$plateNumber} no encontrado"], 404);
        }

        $cambios = [];

        // --- gpswox_id ---
        if (!blank($gpswoxId)) {
            $vehiculo->gpswox_id = (int) $gpswoxId;
            $cambios[] = 'gpswox_id';
        }

        // --- gpswox_active ---
        if ($active !== null) {
            // Preservar old_sim_card / old_numero antes de desactivar para facilitar reactivación
            if ($active === false && $vehiculo->gpswox_active !== false) {
                if ($vehiculo->sim_card_id && blank($vehiculo->old_sim_card)) {
                    $vehiculo->old_sim_card = $vehiculo->sim_card?->sim_card;
                    $cambios[] = 'old_sim_card';
                }
                if ($vehiculo->numero && blank($vehiculo->old_numero)) {
                    $vehiculo->old_numero = $vehiculo->numero;
                    $cambios[] = 'old_numero';
                }
            }
            $vehiculo->gpswox_active = $active;
            $cambios[] = 'gpswox_active';
        }

        // --- numero (SIM) + sim_card_id ---
        if (!blank($simNumber) && $vehiculo->numero !== $simNumber) {
            $vehiculo->numero = $simNumber;
            $cambios[] = 'numero';
        }

        if (!blank($simNumber)) {
            $linea = Lineas::withoutGlobalScope(EmpresaScope::class)
                ->where('numero', $simNumber)
                ->first();

            $simCard = $linea?->sim_card;

            if ($simCard && $vehiculo->sim_card_id !== $simCard->id) {
                $vehiculo->sim_card_id = $simCard->id;
                $cambios[] = 'sim_card_id';
            }
        }

        // --- Timestamp de sincronización ---
        $vehiculo->gpswox_sincronizado_at = now();

        $vehiculo->save();

        // --- Dispositivo principal por IMEI ---
        // Se manipula el pivot directamente para NO desinstalar otros dispositivos del vehículo.
        $imeiSincronizado = false;
        if (!blank($imei)) {
            $dispositivo = Dispositivos::where('imei', $imei)->first();

            if ($dispositivo) {
                $pivotActivo = VehiculoDispositivos::where('vehiculo_id', $vehiculo->id)
                    ->where('imei', $imei)
                    ->whereNull('fecha_desinstalacion')
                    ->first();

                if ($pivotActivo) {
                    // Ya está instalado — solo asegurar que sea el principal
                    VehiculoDispositivos::where('vehiculo_id', $vehiculo->id)
                        ->whereNull('fecha_desinstalacion')
                        ->where('id', '!=', $pivotActivo->id)
                        ->update(['is_principal' => false]);

                    $pivotActivo->update(['is_principal' => true]);
                    $vehiculo->dispositivos_id = $dispositivo->id;
                    $vehiculo->save();
                    $imeiSincronizado = true;
                } else {
                    // IMEI nuevo para este vehículo — verificar que no esté asignado a otro
                    $asignadoAOtro = VehiculoDispositivos::where('dispositivo_id', $dispositivo->id)
                        ->where('vehiculo_id', '!=', $vehiculo->id)
                        ->whereNull('fecha_desinstalacion')
                        ->exists();

                    if (!$asignadoAOtro) {
                        VehiculoDispositivos::where('vehiculo_id', $vehiculo->id)
                            ->whereNull('fecha_desinstalacion')
                            ->update(['is_principal' => false]);

                        VehiculoDispositivos::create([
                            'vehiculo_id'       => $vehiculo->id,
                            'dispositivo_id'    => $dispositivo->id,
                            'imei'              => $imei,
                            'is_principal'      => true,
                            'fecha_instalacion' => now(),
                        ]);

                        $vehiculo->dispositivos_id = $dispositivo->id;
                        $vehiculo->save();
                        $imeiSincronizado = true;
                    } else {
                        Log::channel('daily')->warning('[TrackingWebhook] IMEI ya asignado a otro vehículo', [
                            'placa' => $plateNumber,
                            'imei'  => $imei,
                        ]);
                    }
                }
            } else {
                Log::channel('daily')->info('[TrackingWebhook] IMEI no registrado en Talentus', [
                    'placa' => $plateNumber,
                    'imei'  => $imei,
                ]);
            }
        }

        Log::channel('daily')->info('[TrackingWebhook] Vehículo sincronizado', [
            'placa'            => $plateNumber,
            'gpswox_id'        => $vehiculo->gpswox_id,
            'cambios'          => $cambios,
            'imei_sincronizado' => $imeiSincronizado,
        ]);

        return response()->json([
            'status'            => 1,
            'message'           => 'Vehículo actualizado correctamente',
            'placa'             => $vehiculo->placa,
            'gpswox_id'         => $vehiculo->gpswox_id,
            'imei_sincronizado' => $imeiSincronizado,
            'cambios'           => $cambios,
        ]);
    }
}
