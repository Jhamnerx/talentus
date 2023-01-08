<?php

namespace App\Http\Livewire\App\Consultas\Certificados;

use App\Models\Certificados;
use Livewire\Component;

class ResultGpsSearch extends Component
{
    public $search = '';
    public $is_search = false;
    protected $listeners = [
        'showResult' => 'showResult',
    ];

    public function render()
    {
        $certificado = null;
        $certificado = Certificados::where('codigo', $this->search)->first();
        return view('livewire.app.consultas.certificados.result-gps-search', compact('certificado'));
    }
    public function showResult($codigo)
    {

        $this->search = $codigo;
        $this->is_search = true;
        // dd($unique_hash);
    }
}
