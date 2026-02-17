<?php

namespace App\Traits;

use App\Models\Lineas;
use Illuminate\Support\Facades\Auth;

/**
 * Trait para centralizar la lógica de guardar el historial de SIM cards anteriores
 * 
 * Usado por: CambiarNumero, CambiarChip
 * 
 * Este trait evita duplicación de código al manejar el registro histórico
 * de chips anteriores asociados a una línea telefónica.
 */
trait GuardaHistorialSimCard
{
    /**
     * Guarda el SIM card anterior en el historial de la línea
     * 
     * @param Lineas $linea La línea a la que se le guardará el historial
     * @param string $sim_card_numero El número/código del SIM card anterior
     * @return void
     */
    protected function guardarSimCardAnterior(Lineas $linea, string $sim_card_numero): void
    {
        // Actualizar campo old_sim_card en la línea
        $linea->old_sim_card = $sim_card_numero;
        $linea->save();

        // Crear registro en la tabla de historial (relación old_sim_cards)
        $linea->old_sim_cards()->create([
            'old_sim_card' => $sim_card_numero,
            'user_id' => Auth::id(),
        ]);
    }
}
