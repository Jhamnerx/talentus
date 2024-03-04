<?php

namespace App\Livewire\Admin\Certificados\Actas;

use Carbon\Carbon;
use App\Models\Actas;
use Livewire\Component;
use App\Models\Ciudades;
use Illuminate\Support\Str;
use App\Http\Requests\ActasRequest;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $openModalEdit = false;

    public $numero, $vehiculos_id, $fecha_instalacion, $inicio_cobertura, $fin_cobertura, $ciudades_id, $fondo = 1, $sello = 1, $plataforma = "basica";

    public Actas $acta;

    public function render()
    {
        return view('livewire.admin.certificados.actas.edit');
    }

    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->resetProperties(); // Llamada al método para restablecer las propiedades
    }

    #[On('actualizarActa')]
    public function openModal(Actas $acta)
    {
        $this->openModalEdit = true;

        $this->acta = $acta;
        $this->numero = $acta->numero;
        $this->fondo = $acta->fondo;
        $this->sello = $acta->sello;
        $this->vehiculos_id = $acta->vehiculos_id;
        $this->ciudades_id = $acta->ciudades_id;
        $this->plataforma = $acta->plataforma;
        $this->fecha_instalacion = $acta->fecha_instalacion ? $acta->fecha_instalacion->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->inicio_cobertura = $acta->inicio_cobertura->format('Y-m-d');
        $this->fin_cobertura = $acta->fin_cobertura->format('Y-m-d');
    }


    public function save()
    {
        $actaRequest = new ActasRequest();
        $values = $this->validate($actaRequest->rules($this->acta), $actaRequest->messages());

        $ciudad = Ciudades::find($values["ciudades_id"]);
        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        try {
            $this->acta->update([
                'vehiculos_id' => $values["vehiculos_id"],
                'fecha_instalacion' => $values["fecha_instalacion"],
                'inicio_cobertura' => $values["inicio_cobertura"],
                'fin_cobertura' => $values["fin_cobertura"],
                'ciudades_id' => $values["ciudades_id"],
                'fondo' => $values["fondo"],
                'sello' => $values["sello"],
                'plataforma' => $values["plataforma"],
                'year' => today()->year,
                'fecha' => $fecha,
            ]);

            $this->afterSave($this->acta->codigo);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ACTUALIZAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }

    public function updated($label)
    {
        $actaRequest = new ActasRequest();
        $this->validateOnly($label, $actaRequest->rules($this->acta), $actaRequest->messages());
    }

    public function afterSave($numero)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'ACTA ACTUALIZADA',
            mensaje: 'Se actualizo correctamente el acta #' . $numero,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }
    public function resetProperties()
    {
        $this->numero = null;
        $this->vehiculos_id = null;
        $this->fecha_instalacion = null;
        $this->inicio_cobertura = null;
        $this->fin_cobertura = null;
        $this->ciudades_id = null;
        $this->fondo = 1;
        $this->sello = 1;
        $this->plataforma = "basica";
    }
}
