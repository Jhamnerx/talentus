<?php

namespace App\Livewire\Admin\Compras\Facturas;

use App\Models\ComprasFacturas;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $openModalDelete = false;
    protected $listeners = [
        'render'
    ];

    public function render()
    {
        $desde = $this->from;
        $hasta = $this->to;

        $facturas = ComprasFacturas::whereHas('proveedores', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->orderBy('numero', 'DESC')
            ->paginate(10);



        if (!empty($desde)) {


            $facturas = ComprasFacturas::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(numero like ? OR total like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('numero', 'DESC')
                ->paginate(10);
        }

        return view('livewire.admin.compras.facturas.index', compact('facturas'));
    }


    public function openModalDelete(ComprasFacturas $factura)
    {
        //dd($factura);
        $this->dispatch('openModalDelete', $factura);
        $this->openModalDelete = true;
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
