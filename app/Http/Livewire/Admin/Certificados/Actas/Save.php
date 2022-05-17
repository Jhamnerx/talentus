<?php

namespace App\Http\Livewire\Admin\Certificados\Actas;

use App\Http\Requests\ActasRequest;
use App\Models\Actas;
use App\Models\Ciudades;
use Illuminate\Support\Str;
use Livewire\Component;

class Save extends Component
{

    public $openModalSave = false;
    public $ciudades;

    public $numero, $vehiculos_id, $fecha_inicio, $fecha_fin, $ciudades_id, $fondo, $sello;


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
    }

    public function guardarActa()
    {
        $actaRequest = new ActasRequest();
        $values = $this->validate($actaRequest->rules(), $actaRequest->messages());


        $acta = new Actas;


        $ciudad = Ciudades::find($values["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;


        $acta->numero = $values["numero"];
        $acta->vehiculos_id = $values["vehiculos_id"];
        $acta->inicio_cobertura = $values["fecha_inicio"];
        $acta->fin_cobertura = $values["fecha_fin"];
        $acta->ciudades_id = $values["ciudades_id"];
        $acta->fecha = $fecha;
        $acta->year = today()->year;
        $acta->user_id = auth()->user()->id;
        $acta->empresa_id = session('empresa');
        $acta->save();


        //$this->openModalSave = false;
        $this->dispatchBrowserEvent('acta-save', ['vehiculo' => $acta->vehiculos->placa]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $actaRequest = new ActasRequest();
        $this->validateOnly($label, $actaRequest->rules(), $actaRequest->messages());
    }
}
