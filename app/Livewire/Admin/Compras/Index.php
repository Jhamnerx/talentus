<?php

namespace App\Livewire\Admin\Compras;

use App\Models\Compras;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ComprasFacturas;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    public function render()
    {
        $compras = Compras::whereHas('proveedor', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%')
                ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
        })->orWhereHas('tipoComprobante', function ($query) {
            $query->where('descripcion', 'like', '%' . $this->search . '%');
        })
            ->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('correlativo', 'like', '%' . $this->search . '%')
            ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->orderBy('correlativo', 'DESC')
            ->paginate(12);

        return view('livewire.admin.compras.index', compact('compras'));
    }

    #[On('update-table')]
    public function updateIndex()
    {
        $this->render();
    }

    public function openModalDelete(Compras $compra)
    {
        $this->dispatch('open-modal-delete', compra: $compra);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function anularCompra(Compras $compra)
    {
        if ($compra->estado === 'ANULADO') {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'COMPRA YA ANULADA',
                mensaje: 'Esta compra ya ha sido anulada anteriormente'
            );
            return;
        }

        foreach ($compra->detalle as $detalleItem) {
            if ($detalleItem->producto->stock < $detalleItem->cantidad) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'STOCK INSUFICIENTE',
                    mensaje: 'No hay suficiente stock para el producto: ' . $detalleItem->producto->nombre
                );
                return;
            }
        }

        foreach ($compra->detalle as $detalleItem) {
            $detalleItem->producto->decrement('stock', $detalleItem->cantidad);
        }

        $compra->update(['estado' => 'ANULADO']);

        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'COMPRA ANULADA',
            mensaje: 'Se anuló correctamente la compra'
        );
    }
}
