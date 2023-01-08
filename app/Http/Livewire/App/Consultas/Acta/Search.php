<?php

namespace App\Http\Livewire\App\Consultas\Acta;

use App\Models\Actas;
use Livewire\Component;

class Search extends Component
{

    public $codigo = null, $acta;

    protected $rules = [
        'codigo' => 'required|exists:certificados,codigo',

    ];
    protected $messages = [
        'codigo.required' => 'Ingresa el codigo del Acta',

    ];


    public function mount($codigo_acta)
    {
        $this->codigo = $codigo_acta;
    }

    public function render()
    {
        return view('livewire.app.consultas.acta.search');
    }

    public function SearchActa()
    {
        $this->validate();
        $this->emit('showResult', $this->codigo);
    }
}
