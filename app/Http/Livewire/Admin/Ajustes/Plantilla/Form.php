<?php

namespace App\Http\Livewire\Admin\Ajustes\Plantilla;

use App\Models\Empresa;
use App\Models\plantilla;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{

    use WithFileUploads;

    public plantilla $plantilla;
    public $sunat;
    public $direccion;
    public $series;
    public $ruc, $razon_social, $telefono;

    public function mount()
    {
        $this->sunat = $this->plantilla->sunat;
        $this->ruc = $this->plantilla->ruc;
        $this->razon_social = $this->plantilla->razon_social;
        $this->telefono = $this->plantilla->telefono;
        $this->direccion = $this->plantilla->direccion;
        $this->series = $this->plantilla->series;
    }

    public function render()
    {
        return view('livewire.admin.ajustes.plantilla.form');
    }

    public function save()
    {
        $this->plantilla->ruc = $this->ruc;
        $this->plantilla->razon_social = $this->razon_social;
        $this->plantilla->direccion = $this->direccion;
        $this->plantilla->telefono = $this->telefono;
        $this->plantilla->save();
    }
    public function saveSeries()
    {

        $this->plantilla->series = $this->series;
        $this->plantilla->save();
    }
}
