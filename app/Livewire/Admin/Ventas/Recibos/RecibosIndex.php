<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Models\Recibos;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class RecibosIndex extends Component
{
    use WithPagination;
    public $search;

    public $status = null;

    protected $listeners = [
        'render'
    ];

    public function render()
    {


        $recibos = Recibos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('serie_numero', 'like', '%' . $this->search . '%')
            ->orWhere('tipo_venta', 'like', '%' . $this->search . '%')
            ->orWhere('divisa', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->with('clientes')
            ->orderBy('id', 'desc')
            ->paginate(15);


        $pagadas = Recibos::where('pago_estado', 'PAID')->count();
        $vencidas = Recibos::where('pago_estado', 'UNPAID')->count();

        $total = Recibos::all()->count();

        $totales = [
            'pagadas' => $pagadas,
            'vencidas' => $vencidas,
            'total' => $total,
        ];

        $estado = $this->status;

        if ($estado != null) {

            $recibos = Recibos::whereHas('clientes', function ($query) {
                $query->where('razon_social', 'like', '%' . $this->search . '%');
            })->orWhere('numero', 'like', '%' . $this->search . '%')
                ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
                ->orWhere('serie', 'like', '%' . $this->search . '%')
                ->orWhere('serie_numero', 'like', '%' . $this->search . '%')
                ->orWhere('tipo_venta', 'like', '%' . $this->search . '%')
                ->orWhere('divisa', 'like', '%' . $this->search . '%')
                ->orWhere('total', 'like', '%' . $this->search . '%')
                ->estado($this->status)
                ->with('clientes')
                ->orderBy('id', 'desc')
                ->paginate(15);;
        }



        return view('livewire.admin.ventas.recibos.recibos-index', compact('recibos', 'totales'));
    }


    public function statusSearch($status = null)
    {

        $this->status = $status;
        $this->resetPage();
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function markPaid(Recibos $recibo)
    {

        $recibo->update([
            'estado' => 'COMPLETADO',
            'pago_estado' => 'PAID',
            'fecha_pago' => Carbon::now(),
        ]);

        $this->render();
    }
    public function markUnPaid(Recibos $recibo)
    {

        $recibo->update([
            'pago_estado' => 'UNPAID',
            'fecha_pago' => NULL,
        ]);
        $this->render();
    }

    public function OpenModalReporte()
    {
        $this->dispatch('openModalReporte');
    }

    public function modalOpenSend(Recibos $recibo)
    {
        $this->dispatch('modalOpenSend', $recibo);
    }

    public function openModalDelete(Recibos $recibo)
    {
        $this->dispatch('openModalDelete', $recibo);
    }
}
