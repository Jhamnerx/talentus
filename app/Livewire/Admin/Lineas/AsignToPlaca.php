<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\CambiosLineas;
use App\Models\Lineas;
use App\Models\Vehiculos;
use App\Services\GpsWoxService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class AsignToPlaca extends Component
{
    use WireUiActions;
    public $openModal = false;

    public $asignado = false, $confirm = false;

    public Lineas $linea;
    public $vehiculo_id;


    public function render()
    {
        return view('livewire.admin.lineas.asign-to-placa');
    }

    #[On('asign-to-placa')]
    public function asignToPlaca(Lineas $linea)
    {

        $this->asignado = $linea->sim_card->vehiculos ? true : false;
        $this->vehiculo_id = $linea->sim_card->vehiculos ? $linea->sim_card->vehiculos->placa : null;

        $this->linea = $linea;

        $this->openModal();
    }

    public function removeLinea()
    {

        $this->confirm = true;
    }

    public function confirmation()
    {
        $vehiculo = $this->linea->sim_card->vehiculos;

        // Preservar datos anteriores antes de limpiar
        $vehiculo->old_sim_card = $this->linea->sim_card->sim_card;
        $vehiculo->old_numero   = $this->linea->numero;
        $vehiculo->numero       = null;
        $vehiculo->sim_card_id  = null;

        if ($vehiculo->save()) {
            // Registrar en historial de cambios
            CambiosLineas::create([
                'tipo_cambio'        => 'Línea removida de vehículo',
                'sim_card_id'        => $this->linea->sim_card->id,
                'old_numero'         => $this->linea->id,
                'new_numero'         => $this->linea->id,
                'old_vehiculo_placa' => $vehiculo->placa,
                'user_id'            => Auth::user()->id,
            ]);

            // Limpiar número SIM en la plataforma de tracking
            app(GpsWoxService::class)->limpiarSimVehiculo($vehiculo);

            $this->asignado = false;
            $this->dispatch('index-update');

            $this->notification()->warning(
                'Línea removida',
                "Línea {$this->linea->numero} desvinculada de placa {$vehiculo->placa}"
            );
        }
        $this->reset('confirm');
    }

    public function openModal()
    {

        $this->openModal = true;
    }
    public function closeModal()
    {
        $this->openModal = false;
        $this->asignado = false;
        $this->vehiculo_id = null;
    }

    public function asign()
    {
        $vehiculo = Vehiculos::findOrFail($this->vehiculo_id);

        // Limpiar SIM anterior si tenía otro asignado
        $simAnterior = $vehiculo->sim_card_id;
        if ($simAnterior && $simAnterior !== $this->linea->sim_card->id) {
            $vehiculo->old_sim_card = $vehiculo->sim_card?->sim_card;
            $vehiculo->old_numero   = $vehiculo->numero;
        }

        $vehiculo->sim_card_id = $this->linea->sim_card->id;
        $vehiculo->numero      = $this->linea->numero;  // sincronizar número de línea
        $vehiculo->save();

        // Registrar en historial de cambios
        CambiosLineas::create([
            'tipo_cambio'    => 'Línea asignada a vehículo',
            'sim_card_id'    => $this->linea->sim_card->id,
            'old_numero'     => $this->linea->id,
            'new_numero'     => $this->linea->id,
            'vehiculo_placa' => $vehiculo->placa,
            'user_id'        => Auth::user()->id,
        ]);

        // Sincronizar número SIM con la plataforma de tracking
        app(GpsWoxService::class)->sincronizarSimVehiculo($vehiculo);

        $this->afterSave($vehiculo);
    }

    public function afterSave($vehiculo)
    {
        $this->notification()->success(
            'Línea asignada a vehículo',
            "Se asignó la línea {$this->linea->numero} a la placa {$vehiculo->placa}"
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
}
