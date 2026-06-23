<?php

namespace App\Services;

use App\Models\Dispositivos;
use App\Models\Lineas;
use App\Models\Vehiculos;
use App\Models\VehiculoDispositivos;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Log;

/**
 * Asigna número/SIM e IMEI a un vehículo respetando la plataforma GPSWox como
 * fuente de verdad: libera el dato del vehículo que lo tenía antes y lo asigna
 * al destino. Los métodos son transaction-agnostic: el llamador debe envolver
 * liberar+asignar+save en un único DB::transaction.
 */
class PlataformaVehiculoSyncService
{
    /**
     * Asigna el número/SIM al vehículo destino, liberándolo de cualquier otro
     * vehículo que lo tuviera (archivando en old_numero/old_sim_card).
     * No guarda el destino: el llamador persiste numero/sim_card_id.
     */
    public function aplicarNumero(Vehiculos $destino, string $simNumber): void
    {
        $simNumber = trim($simNumber);

        if (blank($simNumber) || $destino->numero === $simNumber) {
            return;
        }

        $anterior = Vehiculos::withoutGlobalScope(EmpresaScope::class)
            ->where('numero', $simNumber)
            ->where('id', '!=', $destino->id)
            ->first();

        if ($anterior) {
            $anterior->old_numero   = $anterior->numero;
            $anterior->old_sim_card = $anterior->sim_card?->sim_card;
            $anterior->numero       = null;
            $anterior->sim_card_id  = null;
            $anterior->save();
        }

        $destino->numero = $simNumber;

        $linea = Lineas::withoutGlobalScope(EmpresaScope::class)
            ->where('numero', $simNumber)
            ->first();

        if ($linea && $linea->sim_card) {
            $destino->sim_card_id = $linea->sim_card->id;
        }
    }

    /**
     * Asigna el dispositivo (por IMEI) como principal del vehículo destino,
     * desinstalándolo de cualquier otro vehículo que lo tuviera activo.
     * Persiste pivots y el shortcut dispositivos_id. Retorna true si quedó asignado.
     */
    public function aplicarImei(Vehiculos $destino, string $imei): bool
    {
        $imei = trim($imei);

        if (blank($imei)) {
            return false;
        }

        $dispositivo = Dispositivos::withoutGlobalScope(EmpresaScope::class)
            ->where('imei', $imei)
            ->first();

        if (! $dispositivo) {
            Log::channel('daily')->info('[PlataformaSync] IMEI no registrado en Talentus', ['imei' => $imei]);
            return false;
        }

        $pivotDestino = VehiculoDispositivos::where('vehiculo_id', $destino->id)
            ->where('imei', $imei)
            ->whereNull('fecha_desinstalacion')
            ->first();

        if ($pivotDestino) {
            VehiculoDispositivos::where('vehiculo_id', $destino->id)
                ->whereNull('fecha_desinstalacion')
                ->where('id', '!=', $pivotDestino->id)
                ->update(['is_principal' => false]);

            $pivotDestino->update(['is_principal' => true]);
            $destino->dispositivos_id = $dispositivo->id;
            $destino->save();

            return true;
        }

        $pivotOtro = VehiculoDispositivos::where('dispositivo_id', $dispositivo->id)
            ->where('vehiculo_id', '!=', $destino->id)
            ->whereNull('fecha_desinstalacion')
            ->first();

        if ($pivotOtro) {
            $pivotOtro->update(['fecha_desinstalacion' => now(), 'is_principal' => false]);

            $anterior = Vehiculos::withoutGlobalScope(EmpresaScope::class)->find($pivotOtro->vehiculo_id);
            if ($anterior && (int) $anterior->dispositivos_id === (int) $dispositivo->id) {
                $anterior->dispositivos_id = null;
                $anterior->save();
            }
        } else {
            app(StockService::class)->marcarVendidoPorInstalacion($dispositivo);
        }

        VehiculoDispositivos::where('vehiculo_id', $destino->id)
            ->whereNull('fecha_desinstalacion')
            ->update(['is_principal' => false]);

        VehiculoDispositivos::create([
            'vehiculo_id'       => $destino->id,
            'dispositivo_id'    => $dispositivo->id,
            'imei'              => $imei,
            'is_principal'      => true,
            'fecha_instalacion' => now(),
        ]);

        $destino->dispositivos_id = $dispositivo->id;
        $destino->save();

        return true;
    }
}
