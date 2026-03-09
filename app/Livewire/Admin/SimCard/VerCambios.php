<?php

namespace App\Livewire\Admin\SimCard;

use App\Models\CambiosLineas;
use App\Models\SimCard;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class VerCambios extends Component
{
    public $sim_card;
    public $modalOpen = false;
    public $cambios;

    public function render()
    {
        return view('livewire.admin.sim-card.ver-cambios');
    }

    #[On('open-modal-cambios')]
    public function showModal(SimCard $sim_card)
    {
        $this->modalOpen = true;
        $this->sim_card = $sim_card;

        // Cargar cambios con relaciones
        $this->cambios = $sim_card->cambios()
            ->with(['user', 'linea_old', 'linea_new'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->reset('cambios', 'sim_card');
    }

    /**
     * Obtener datos del cambio formateados
     */
    public function getCambioData($cambio)
    {
        $tipo = $cambio->tipo_cambio;
        $data = [
            'icon' => '📝',
            'color' => 'blue',
            'titulo' => 'Cambio registrado',
            'descripcion' => $tipo,
        ];

        if (str_contains(strtolower($tipo), 'reactivación')) {
            $data['icon'] = '✅';
            $data['color'] = 'green';
            $data['titulo'] = 'Línea reactivada';
            $diasSuspendida = $cambio->fecha_suspencion && $cambio->fecha_suspencion_fin
                ? \Carbon\Carbon::parse($cambio->fecha_suspencion)->diffInDays($cambio->fecha_suspencion_fin)
                : 0;
            $numeroLinea = $cambio->linea_new ? $cambio->linea_new->numero : ($cambio->linea_old ? $cambio->linea_old->numero : 'Línea desconocida');
            $data['descripcion'] = "Línea {$numeroLinea} reactivada después de {$diasSuspendida} días";
        } elseif (str_contains(strtolower($tipo), 'suspensión')) {
            $data['icon'] = '⏸️';
            $data['color'] = 'amber';
            $numeroLinea = $cambio->linea_new ? $cambio->linea_new->numero : ($cambio->linea_old ? $cambio->linea_old->numero : 'Línea desconocida');
            if (str_contains(strtolower($tipo), 'definitiva')) {
                $data['icon'] = '⛔';
                $data['color'] = 'red';
                $data['titulo'] = 'Suspensión - Baja definitiva';
                $data['descripcion'] = "Línea {$numeroLinea} suspendida permanentemente";
            } else {
                $data['titulo'] = 'Suspensión temporal';
                $fechaLimite = $cambio->fecha_suspencion_fin
                    ? \Carbon\Carbon::parse($cambio->fecha_suspencion_fin)->format('d/m/Y')
                    : 'No definida';
                $data['descripcion'] = "Línea {$numeroLinea} suspendida hasta {$fechaLimite}";
            }
        } elseif (str_contains(strtolower($tipo), 'cambio de número')) {
            $data['icon'] = '🔄';
            $data['color'] = 'indigo';
            $data['titulo'] = 'Cambio de número';
            $numeroAnterior = $cambio->linea_old ? $cambio->linea_old->numero : 'Sin número';
            $numeroNuevo = $cambio->linea_new ? $cambio->linea_new->numero : 'Sin número';
            $data['descripcion'] = "{$numeroAnterior} → {$numeroNuevo}";
        } elseif (str_contains(strtolower($tipo), 'elimino') || str_contains(strtolower($tipo), 'liberado')) {
            $data['icon'] = '🗑️';
            $data['color'] = 'red';
            $data['titulo'] = 'Número eliminado';
            $numeroAnterior = $cambio->linea_old ? $cambio->linea_old->numero : 'Número desconocido';
            $data['descripcion'] = "Se liberó el número {$numeroAnterior}";
        } elseif (str_contains(strtolower($tipo), 'nueva asignación') || str_contains(strtolower($tipo), 'asignado')) {
            $data['icon'] = '✅';
            $data['color'] = 'green';
            $data['titulo'] = 'Número asignado';
            $numeroNuevo = $cambio->linea_new ? $cambio->linea_new->numero : 'Número desconocido';
            $data['descripcion'] = "Se asignó el número {$numeroNuevo}";
        }

        return $data;
    }
}
