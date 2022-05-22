<?php

namespace App\Http\Livewire\App\Consultas\Acta;

use App\Models\Actas;
use Livewire\Component;

class Search extends Component
{

    public $codigo = null, $unique_hash = null, $acta;

    protected $rules = [
        'codigo' => 'required',
        'unique_hash' => 'required',
    ];
    protected $messages = [
        'codigo.required' => 'Ingresa el codigo',
        'unique_hash.required' => 'Ingresa el hash',
    ];


    public function mount($acta_hash)
    {
        $this->unique_hash = $acta_hash;
    }

    public function render()
    {
        return view('livewire.app.consultas.acta.search');
    }

    public function SearchActa()
    {
        $this->validate();
        $this->emit('showResult', $this->unique_hash, $this->codigo);
    }
}
