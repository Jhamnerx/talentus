<?php

namespace App\Http\Livewire\Admin\Ventas\Facturas;

use App\Models\ComprasFacturas;
use Livewire\Component;

class FacturasIndex extends Component
{
    public $search;
    public $from = '';
    public $to = '';

    public function render()
    {

        $desde = $this->from;
        $hasta = $this->to;

        $facturas = ComprasFacturas::whereHas('proveedores', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->orderBy('id')
            ->paginate(10);

        $total = ComprasFacturas::all()->count();


        if (!empty($desde)) {


            $facturas = ComprasFacturas::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(serie like ? OR numero like  ? OR fecha like ? OR total like ?)",
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

        return view('livewire.admin.ventas.facturas.facturas-index', compact('facturas', 'total'));
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
