<?php

namespace App\Http\Livewire\App\Consultas\Certificados;

use Livewire\Component;
use App\Models\CertificadosVelocimetros;

class ResultVelocimetroSearch extends Component
{

    public $search = '';
    public $is_search = false;
    protected $listeners = [
        'showResult' => 'showResult',
    ];

    public function render()
    {
        $certificado = null;
        $certificado = CertificadosVelocimetros::where('codigo', $this->search)->withoutGlobalScopes()->first();

        return view('livewire.app.consultas.certificados.result-velocimetro-search', compact('certificado'));
    }
    public function showResult($codigo)
    {
        $this->search = $codigo;
        $this->is_search = true;
        // dd($unique_hash);
    }
}
