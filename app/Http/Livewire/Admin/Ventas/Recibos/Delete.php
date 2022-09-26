<?php

namespace App\Http\Livewire\Admin\Ventas\Recibos;

use App\Models\Recibos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{
    public Model $recibo;
    public $openModalDelete;

    protected $listeners = [
        'openModalDelete'
    ];

    public function delete()
    {
        $this->recibo->delete();
        $this->dispatchBrowserEvent('recibo-delete');
        $this->emit('render');
        //$flight->forceDelete();
    }
    public function openModalDelete(Recibos $recibo)
    {
        $this->openModalDelete = true;
        $this->recibo = $recibo;
    }

    public function render()
    {
        return view('livewire.admin.ventas.recibos.delete');
    }
}
