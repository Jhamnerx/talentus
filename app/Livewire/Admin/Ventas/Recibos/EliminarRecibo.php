<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Models\Recibos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class EliminarRecibo extends Component
{
    public Model $recibo;
    public $mostrarModal = false;

    protected $listeners = [
        'openModalDelete' => 'abrirModal'
    ];

    public function abrirModal(Recibos $recibo)
    {
        $this->mostrarModal = true;
        $this->recibo = $recibo;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        $this->recibo->delete();
        $this->dispatch('recibo-delete');
        $this->dispatch('render');
    }

    public function render()
    {
        return view('livewire.admin.ventas.recibos.eliminar-recibo');
    }
}
