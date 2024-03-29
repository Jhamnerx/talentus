<?php

namespace App\Livewire\App\Consultas\Acta;

use App\Models\Actas;
use Livewire\Component;

class Search extends Component
{

    public $codigo = null, $acta;

    protected $rules = [
        'codigo' => 'required|exists:actas,codigo',

    ];
    protected $messages = [
        'codigo.required' => 'Ingresa el codigo del Acta',
        'codigo.exists' => 'No se encuentra el acta',

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
        $this->dispatch('showResult', $this->codigo);
    }
}
