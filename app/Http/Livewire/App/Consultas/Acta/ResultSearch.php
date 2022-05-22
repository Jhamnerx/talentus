<?php

namespace App\Http\Livewire\App\Consultas\Acta;

use App\Models\Actas;
use Livewire\Component;

class ResultSearch extends Component
{
    public $unique_hash_search = '';
    public $codigo_search = '';
    public $is_search = false;
    protected $listeners = [
        'showResult' => 'showResult',
    ];

    public function render()
    {
        $acta = Actas::where('unique_hash', $this->unique_hash_search)->where('codigo', $this->codigo_search)->first();

        return view('livewire.app.consultas.acta.result-search', compact('acta'));
    }
    public function showResult($unique_hash, $codigo)
    {
        $this->unique_hash_search = $unique_hash;
        $this->codigo_search = $codigo;
        $this->is_search = true;
        // dd($unique_hash);
    }
}
