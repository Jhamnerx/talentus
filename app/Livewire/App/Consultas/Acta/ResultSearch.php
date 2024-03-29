<?php

namespace App\Livewire\App\Consultas\Acta;

use App\Models\Actas;
use Livewire\Component;

class ResultSearch extends Component
{
    public $search = '';
    public $is_search = false;
    protected $listeners = [
        'showResult' => 'showResult',
    ];

    public function render()
    {
        $acta = null;
        $acta = Actas::where('codigo', $this->search)->withoutGlobalScopes()->first();

        return view('livewire.app.consultas.acta.result-search', compact('acta'));
    }
    public function showResult($codigo)
    {

        $this->search = $codigo;
        $this->is_search = true;
        // dd($unique_hash);
    }
}
