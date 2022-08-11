<?php

namespace App\Http\Livewire\Admin\Certificados\Actas;

use App\Http\Requests\ActasRequest;
use App\Models\Actas;
use App\Models\Ciudades;
use Livewire\Component;
use Illuminate\Support\Str;

class Edit extends Component
{

    public $openModalEdit = false;

    public $acta;
    public $numero, $vehiculos_id, $inicio_cobertura, $fin_cobertura, $ciudades_id, $fondo, $sello;


    protected $listeners = [
        'actualizarActa' => 'openModal'
    ];

    public function render()
    {
        return view('livewire.admin.certificados.actas.edit');
    }


    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->reset();
        $this->resetErrorBag();
    }


    public function openModal(Actas $acta)
    {
        $this->openModalEdit = true;

        $this->acta = $acta;

        $this->numero = $acta->numero;
        $this->vehiculos_id = $acta->vehiculos_id;
        $this->ciudades_id = $acta->ciudades_id;
        $this->dispatchBrowserEvent('set-vehiculo', ['vehiculo' => $acta->vehiculos, 'ciudad' => $acta->ciudades]);
        $this->inicio_cobertura = $acta->inicio_cobertura;
        $this->fin_cobertura = $acta->fin_cobertura;
    }


    public function actualizarActa()
    {
        $actaRequest = new ActasRequest();
        $values = $this->validate($actaRequest->rules($this->acta), $actaRequest->messages());

        $ciudad = Ciudades::find($values["ciudades_id"]);
        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;
        $update = Actas::find($this->acta->id);
        $update->numero = $values["numero"];
        $codigo = $ciudad->prefijo . "-" . date('y') . "-" . $update->numero;
        $update->codigo = $codigo;
        $update->vehiculos_id = $values["vehiculos_id"];
        $update->fecha = $fecha;
        $update->inicio_cobertura = $values["inicio_cobertura"];
        $update->fin_cobertura = $values["fin_cobertura"];
        $update->ciudades_id = $values["ciudades_id"];
        $update->save();

        $this->openModalEdit = false;
        $this->dispatchBrowserEvent('acta-edit', ['acta' => $values["numero"]]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $actaRequest = new ActasRequest();
        $this->validateOnly($label, $actaRequest->rules($this->acta), $actaRequest->messages());
    }
}
