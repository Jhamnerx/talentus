<?php

namespace App\Http\Livewire\Admin\Ventas\Recibos;

use App\Models\Recibos;
use Livewire\Component;

class RecibosIndex extends Component
{

    public $search;
    public $from = '';
    public $to = '';

    public function render()
    {

        $desde = $this->from;
        $hasta = $this->to;

        $recibos = Recibos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('tipo_pago', 'like', '%' . $this->search . '%')
            ->orWhere('divisa', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->paginate(10);

        $total = Recibos::all()->count();


        if (!empty($desde)) {


            $recibos = Recibos::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(divisa like ? OR numero like  ? OR fecha like ? OR total like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id')
                ->paginate(10);
        }


        return view('livewire.admin.ventas.recibos.recibos-index', compact('recibos', 'total'));
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
