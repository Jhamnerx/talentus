<?php

namespace App\Http\Livewire\Admin\Certificados;

use App\Models\Certificados;
use Livewire\Component;

class CertificadosGpsIndex extends Component
{
    public $search;
    public $from = '';
    public $to = '';

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;


        $certificados = Certificados::whereHas('ciudades', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orwhere('prefijo', 'like', '%' . $this->search . '%');
        })->orwhereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('fin_cobertura', 'like', '%' . $this->search . '%')
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->paginate(10);

        $total = Certificados::all()->count();
        if (!empty($desde)) {


            $certificados = Certificados::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(fecha like ? OR fin_cobertura like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id')
                ->paginate(10);
        }
        return view('livewire.admin.certificados.certificados-gps-index', compact('certificados', 'total'));
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
