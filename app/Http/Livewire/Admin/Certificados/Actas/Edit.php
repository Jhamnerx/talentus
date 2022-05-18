<?php

namespace App\Http\Livewire\Admin\Certificados\Actas;

use App\Http\Requests\ActasRequest;
use App\Models\Actas;
use Livewire\Component;

class Edit extends Component
{

    public $openModalEdit = false;

    public $acta;
    public $numero, $vehiculos_id, $fecha_inicio, $fecha_fin, $ciudades_id, $fondo, $sello;


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
        $this->dispatchBrowserEvent('set-vehiculo', ['vehiculo' => $this->acta->vehiculos, 'ciudad' => $this->acta->ciudades]);
        $this->fecha_inicio = $acta->inicio_cobertura;
        $this->fecha_fin = $acta->fin_cobertura;
    }


    public function actualizarActa()
    {
        $actaRequest = new ActasRequest();
        $values = $this->validate($actaRequest->rules($this->acta), $actaRequest->messages());

        $update = Actas::find($this->acta->id);
        $update->inicio_cobertura = $values["hora_t"];
        $update->fecha_t = $values["fecha_t"];
        $update->detalle = $values["detalle"];

        $update->save();
        $this->openModalEdit = false;
        $this->dispatchBrowserEvent('reporte-edit', ['vehiculo' => $this->reporte->vehiculos->placa]);
        $this->emit('updateTable');
        $this->reset();
    }

    public function updated($label)
    {
        $actaRequest = new ActasRequest();
        $this->validateOnly($label, $actaRequest->rules(), $actaRequest->messages());
    }
}
