<?php

namespace App\Http\Livewire\Admin\Certificados\Velocimetros;

use App\Models\CertificadosVelocimetros;
use Livewire\Component;

class VelocimetrosIndex extends Component
{
    public $search;
    public $from = '';
    public $to = '';
    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $certificados = CertificadosVelocimetros::whereHas('vehiculos', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%')
                ->orwhere('motor', 'like', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->paginate(10);

        $total = CertificadosVelocimetros::all()->count();
        if (!empty($desde)) {


            $certificados = CertificadosVelocimetros::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(fecha like ? OR numero like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id')
                ->paginate(10);
        }
        return view('livewire.admin.certificados.velocimetros.velocimetros-index', compact('certificados', 'total'));
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 7 days"));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 month"));
                $this->to = date('Y-m-d');
                break;
            case '12':
                $this->from = date('Y-m-d', strtotime(date('Y-m-d') . "- 1 year"));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }
}
