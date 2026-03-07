<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Models\Dispositivos;
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
        // Revertir dispositivos GPS a STOCK
        $dispositivosIds = $this->recibo->detalles()
            ->whereNotNull('imeis')
            ->get()
            ->flatMap(fn($d) => $d->imeis ?? [])
            ->filter()->unique()->values();

        if ($dispositivosIds->isNotEmpty()) {
            Dispositivos::whereIn('id', $dispositivosIds)->update(['estado' => Dispositivos::STOCK]);
        }

        $this->recibo->delete();
        $this->dispatch('recibo-delete');
        $this->cerrarModal();
    }

    public function render()
    {
        return view('livewire.admin.ventas.recibos.eliminar-recibo');
    }
}
