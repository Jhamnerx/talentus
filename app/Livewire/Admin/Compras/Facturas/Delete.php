<?php

namespace App\Livewire\Admin\Compras\Facturas;

use App\Models\ComprasFacturas;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{

    public Model $factura;
    public $openModalDelete;

    protected $listeners = [
        'openModalDelete'
    ];

    public function delete()
    {
        $this->factura->delete();
        $this->dispatch('factura-delete');
        $this->dispatch('render');
        //$flight->forceDelete();
    }
    public function openModalDelete(ComprasFacturas $factura)
    {
        $this->openModalDelete = true;
        $this->factura = $factura;
    }
    public function render()
    {
        return view('livewire.admin.compras.facturas.delete');
    }
}
