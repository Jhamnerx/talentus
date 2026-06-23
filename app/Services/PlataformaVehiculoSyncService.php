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
}
