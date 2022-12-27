<?php

namespace App\Http\Livewire\App\Consultas\Certificados;

use Livewire\Component;
use Illuminate\Support\Str;

class VelocimetroSearch extends Component
{

    public $codigo = null, $certificado;

    protected $rules = [
        'codigo' => 'required|exists:certificados_velocimetros,codigo',

    ];
    protected $messages = [
        'codigo.required' => 'Ingresa el codigo del Certificado',

    ];


    public function mount($codigo_certificado)
    {
        $this->codigo = $codigo_certificado;
    }

    public function render()
    {
        return view('livewire.app.consultas.certificados.velocimetro-search');
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
