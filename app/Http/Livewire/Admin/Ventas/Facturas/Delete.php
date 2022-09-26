<?php

namespace App\Http\Livewire\Admin\Ventas\Facturas;

use App\Models\Facturas;
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
        $this->dispatchBrowserEvent('factura-delete');
        $this->emit('render');
        //$flight->forceDelete();
    }
    public function openModalDelete(Facturas $factura)
    {
        $this->openModalDelete = true;
        $this->factura = $factura;
    }
    public function render()
    {
        return view('livewire.admin.ventas.facturas.delete');
    }
}
