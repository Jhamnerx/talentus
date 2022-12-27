<?php

namespace App\Http\Livewire\App\Consultas\Certificados;

use Livewire\Component;
use Illuminate\Support\Str;

class GpsSearch extends Component
{


    public $codigo = null, $acta;

    protected $rules = [
        'codigo' => 'required|exists:certificados,codigo',

    ];
    protected $messages = [
        'codigo.required' => 'Ingresa el codigo del Certificado',
        'codigo.exists' => 'El Codigo de este certificado no existe',

    ];


    public function mount($codigo_acta)
    {
        $this->codigo = $codigo_acta;
    }

    public function render()
    {
        return view('livewire.app.consultas.certificados.gps-search');
    }

    public function updatedCodigo($value)
    {

        $this->codigo = Str::upper($value);
    }


    public function SearchCertificado()
    {
        $this->validate();
        $this->emit('showResult', $this->codigo);
    }
}
