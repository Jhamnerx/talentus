<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\CambiosLineas;
use App\Models\Lineas;
use Livewire\Attributes\On;
use Livewire\Component;

class VerCambios extends Component
{
    public $linea;
    public $modalOpen = false;
    public $cambios;

    public function render()
    {
        return view('livewire.admin.lineas.ver-cambios');
    }

    #[On('open-modal-ver-cambios-linea')]
    public function showModal($lineaId)
    {
        $this->modalOpen = true;
        $this->linea = Lineas::with('sim_card')->find($lineaId);

        if ($this->linea) {
            // Cargar todos los cambios donde esta línea está involucrada
            $this->cambios = CambiosLineas::where(function ($query) {
                $query->where('old_numero', $this->linea->id)
                    ->orWhere('new_numero', $this->linea->id);
            })
                ->with(['user', 'sim_card'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->cambios = collect();
        }
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->reset('cambios', 'linea');
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
            $data['descripcion'] = "Línea reactivada después de {$diasSuspendida} días suspendida";
        } elseif (str_contains(strtolower($tipo), 'suspensión')) {
            $data['icon'] = '⏸️';
            $data['color'] = 'amber';
            if (str_contains(strtolower($tipo), 'definitiva')) {
                $data['icon'] = '⛔';
                $data['color'] = 'red';
                $data['titulo'] = 'Suspensión - Baja definitiva';
                $data['descripcion'] = 'Línea suspendida permanentemente (no reactivable)';
            } else {
                $data['titulo'] = 'Suspensión temporal';
                $fechaLimite = $cambio->fecha_suspencion_fin
                    ? \Carbon\Carbon::parse($cambio->fecha_suspencion_fin)->format('d/m/Y')
                    : 'No definida';
                $data['descripcion'] = "Línea suspendida. Límite de reactivación: {$fechaLimite}";
            }
        } elseif (str_contains(strtolower($tipo), 'cambio de chip')) {
            $data['icon'] = '🔄';
            $data['color'] = 'indigo';
            if (str_contains(strtolower($tipo), 'liberado')) {
                $data['titulo'] = 'Chip anterior liberado';
                $chipAnterior = $cambio->sim_card ? $cambio->sim_card->sim_card : 'Chip desconocido';
                $data['descripcion'] = "Se liberó el chip {$chipAnterior}";
            } else {
                $data['titulo'] = 'Chip asignado';
                $chipNuevo = $cambio->sim_card ? $cambio->sim_card->sim_card : 'Chip desconocido';
                $data['descripcion'] = "Se asignó el chip {$chipNuevo}";
            }
        } elseif (str_contains(strtolower($tipo), 'nueva asignación')) {
            $data['icon'] = '✅';
            $data['color'] = 'green';
            $data['titulo'] = 'Primera asignación';
            $chip = $cambio->sim_card ? $cambio->sim_card->sim_card : 'Chip desconocido';
            $data['descripcion'] = "Línea asignada al chip {$chip}";
        } elseif (str_contains(strtolower($tipo), 'elimino') || str_contains(strtolower($tipo), 'liberado')) {
            $data['icon'] = '🗑️';
            $data['color'] = 'red';
            $data['titulo'] = 'Asignación eliminada';
            $chip = $cambio->sim_card ? $cambio->sim_card->sim_card : 'Chip desconocido';
            $data['descripcion'] = "Se eliminó la asignación del chip {$chip}";
        } elseif (str_contains(strtolower($tipo), 'asignada a vehículo')) {
            $data['icon'] = '🚗';
            $data['color'] = 'blue';
            $data['titulo'] = 'Asignada a vehículo';
            $placa = $cambio->vehiculo_placa ?? 'Vehículo desconocido';
            $data['descripcion'] = "Línea asignada al vehículo con placa: {$placa}";
        } elseif (str_contains(strtolower($tipo), 'removida de vehículo')) {
            $data['icon'] = '🚫';
            $data['color'] = 'rose';
            $data['titulo'] = 'Removida de vehículo';
            $placa = $cambio->old_vehiculo_placa ?? 'Vehículo desconocido';
            $data['descripcion'] = "Línea removida del vehículo con placa: {$placa}";
        }

        return $data;
    }
}
