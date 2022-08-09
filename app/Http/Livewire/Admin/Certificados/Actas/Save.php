<?php

namespace App\Http\Livewire\Admin\Certificados\Actas;


use App\Http\Requests\ActasRequest;
use App\Models\Actas;
use App\Models\Admin\Mensaje;
use App\Models\Ciudades;
use Illuminate\Support\Str;
use Livewire\Component;
use Vinkla\Hashids\Facades\Hashids;

class Save extends Component
{

    public $openModalSave = false;
    public $ciudades;

    public $numero, $vehiculos_id, $inicio_cobertura, $fin_cobertura, $ciudades_id = 1, $fondo = 1, $sello = 1;


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

        //  dd($values);

        $ciudad = Ciudades::find($values["ciudades_id"]);

        $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;

        $acta = Actas::create($values);

        $codigo = $ciudad->prefijo . "-" . date('y') . "-" . $acta->numero;
        $acta->year = today()->year;
        $acta->user_id = auth()->user()->id;

        $acta->unique_hash = Hashids::connection(Actas::class)->encode($acta->id);
        $acta->empresa_id = session('empresa');
        $acta->codigo = $codigo;
        $acta->fecha = $fecha;

        $acta->save();

        //$this->openModalSave = false;
        $this->dispatchBrowserEvent('acta-save', ['vehiculo' => $acta->vehiculos->placa]);
        $this->emit('updateTable');
        $this->reset();
        $this->resetErrorBag();
    }

    public function updated($label)
    {
        $actaRequest = new ActasRequest();
        $this->validateOnly($label, $actaRequest->rules(), $actaRequest->messages());
    }
}
