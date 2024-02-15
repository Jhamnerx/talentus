<?php

namespace App\Livewire\Admin\Certificados\Actas;

use App\Http\Controllers\Admin\ActasController;
use App\Http\Requests\ActasRequest;
use App\Models\Actas;
use App\Models\Ciudades;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class Save extends Component
{

    public $openModalSave = false;

    public $numero, $vehiculos_id, $fecha_instalacion, $inicio_cobertura, $fin_cobertura, $ciudades_id, $fondo = 1, $sello = 1, $plataforma = "basica";


    public function render()
    {
        return view('livewire.admin.certificados.actas.save');
    }

    #[On('guardarActa')]
    public function openModal()
    {

        $this->openModalSave = true;
        $newActa = new ActasController();
        $this->numero = $newActa->setNextSequenceNumber();
        $this->fecha_instalacion = Carbon::now()->format('Y-m-d');
        $this->inicio_cobertura = Carbon::now()->format('Y-m-d');
        $this->fin_cobertura = Carbon::now()->addDays(30)->format('Y-m-d');
    }

    public function closeModal()
    {
        $this->openModalSave = false;
        $this->resetProperties(); // Llamada al método para restablecer las propiedades
    }

    public function save()
    {
        $actaRequest = new ActasRequest();
        $values = $this->validate($actaRequest->rules(), $actaRequest->messages());

        try {

            $ciudad = Ciudades::find($values["ciudades_id"]);
            $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

            $acta = Actas::create([
                'vehiculos_id' => $values["vehiculos_id"],
                'numero' => $values["numero"],
                'fecha_instalacion' => $values["fecha_instalacion"],
                'inicio_cobertura' => $values["inicio_cobertura"],
                'fin_cobertura' => $values["fin_cobertura"],
                'ciudades_id' => $values["ciudades_id"],
                'fondo' => $values["fondo"],
                'sello' => $values["sello"],
                'plataforma' => $values["plataforma"],
                'codigo' => $ciudad->prefijo . "-" . $values["numero"],
                'year' => today()->year,
                'fecha' => $fecha,
            ]);

            $this->afterSave($acta->codigo);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                tittle: 'ERROR AL GUARDAR',
                mensaje: 'Ocurrio el sgte error: ' . $th->getMessage(),
            );
        }
    }


    public function afterSave($numero)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            tittle: 'ACTA REGISTRADA',
            mensaje: 'Se registro correctamente el acta #' . $numero,
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }

    public function updated($label)
    {
        $actaRequest = new ActasRequest();
        $this->validateOnly($label, $actaRequest->rules(), $actaRequest->messages());
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
