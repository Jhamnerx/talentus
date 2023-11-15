<?php

namespace App\Livewire\Admin\Certificados\Actas;

use App\Http\Controllers\Admin\ActasController;
use App\Http\Requests\ActasRequest;
use App\Models\Actas;
use App\Models\Ciudades;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class Save extends Component
{

    public $openModalSave = false;
    public $ciudades;

    public $numero, $vehiculos_id, $fecha_instalacion, $inicio_cobertura, $fin_cobertura, $ciudades_id, $fondo = 1, $sello = 1, $plataforma = "basica";


    protected $listeners = [
        'guardarActa' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.certificados.actas.save');
    }

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
        $this->reset();
        $this->resetErrorBag();
    }

    public function guardarActa()
    {
        $actaRequest = new ActasRequest();
        $values = $this->validate($actaRequest->rules(), $actaRequest->messages());


        $ciudad = Ciudades::find($values["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;
        $acta =  new Actas();

        $acta->vehiculos_id = $values["vehiculos_id"];
        $acta->numero = $values["numero"];
        $acta->fecha_instalacion = $values["fecha_instalacion"];
        $acta->inicio_cobertura = $values["inicio_cobertura"];
        $acta->fin_cobertura = $values["fin_cobertura"];
        $acta->ciudades_id = $values["ciudades_id"];
        $acta->fondo = $values["fondo"];
        $acta->sello = $values["sello"];
        $acta->plataforma = $values["plataforma"];
        $acta->codigo = $ciudad->prefijo . "-" . $values["numero"];
        $acta->year = today()->year;
        $acta->fecha = $fecha;
        $acta->save();

        $this->dispatch('acta-save', ['vehiculo' => $acta->vehiculo->placa]);
        $this->dispatch('updateTable');
        $this->reset();
        $this->resetErrorBag();
    }

    public function updated($label)
    {
        $actaRequest = new ActasRequest();
        $this->validateOnly($label, $actaRequest->rules(), $actaRequest->messages());
    }
}
