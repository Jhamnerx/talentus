<?php

namespace App\Livewire\Admin\Gerencia\Recibos;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RecibosPagosVarios;
use Illuminate\Support\Collection;

class Index extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $status = null;

    protected $listeners = [
        'render'
    ];


    public function render()
    {

        $desde = $this->from;
        $hasta = $this->to;

        $recibos = RecibosPagosVarios::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('serie_numero', 'like', '%' . $this->search . '%')
            ->orWhere('divisa', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);


        $pagadas = RecibosPagosVarios::where('pago_estado', 'PAID')->count();
        $vencidas = RecibosPagosVarios::where('pago_estado', 'UNPAID')->count();

        $total = RecibosPagosVarios::all()->count();

        $totales = [
            'pagadas' => $pagadas,
            'vencidas' => $vencidas,
            'total' => $total,
        ];

        $estado = $this->status;

        if ($estado != null) {

            $recibos = RecibosPagosVarios::Where('pago_estado', $estado)->paginate(10);
        }

        if (!empty($desde)) {


            $recibos = RecibosPagosVarios::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(divisa like ? OR numero like  ? OR total like ? OR serie_numero like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('id', 'desc')
                ->paginate(10);
        }


        return view('livewire.admin.gerencia.recibos.index', compact('recibos', 'totales'));
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

    public function status($status = null)
    {
        $this->status = $status;
        // $this->render();

    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function markPaid(RecibosPagosVarios $recibo)
    {

        $recibo->update([
            'estado' => 'COMPLETADO',
            'pago_estado' => 'PAID',
            'fecha_pago' => Carbon::now(),
        ]);

        $this->render();
    }
    public function markUnPaid(RecibosPagosVarios $recibo)
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

    public function modalOpenSend(RecibosPagosVarios $recibo)
    {


        $this->dispatch('modalOpenSend', $recibo);
    }
    public function openModalDelete(RecibosPagosVarios $recibo)
    {

        $this->dispatch('openModalDelete', $recibo);
    }
}
