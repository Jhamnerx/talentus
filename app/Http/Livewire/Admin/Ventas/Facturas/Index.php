<?php

namespace App\Http\Livewire\Admin\Ventas\Facturas;

use App\Models\Facturas;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
class Index extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $status = null;
    public $openModalDelete = false;
    public $modalOpenSend = false;
    protected $listeners = [
        'render'
    ];

    public function render()
    {

        $desde = $this->from;
        $hasta = $this->to;

        $facturas = Facturas::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->Where('estado', $this->status)
            ->orderBy('numero', 'DESC')
            ->paginate(10);


        $pagadas = Facturas::where('pago_estado', 'PAID')->count();
        $vencidas = Facturas::where('pago_estado', 'UNPAID')->count();
    
        $total = Facturas::all()->count();

        $totales = [
            'pagadas' => $pagadas,
            'vencidas' => $vencidas,
            'total' => $total,
        ];

        $estado = $this->status;

        if($estado != null){

            $facturas = Facturas::Where('pago_estado', $estado)->paginate(10);
        }

        if (!empty($desde)) {


            $facturas = Facturas::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(serie like ? OR numero like  ? OR fecha_emision like ? OR total like ?)",
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

        return view('livewire.admin.ventas.facturas.index', compact('facturas', 'totales'));
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
        //$this->render();
        
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }    

    public function markPaid(Facturas $factura){

        $factura->update([
            'pago_estado' => 'PAID',
            'fecha_pago' => $date = Carbon::now(),
            'estado' => 'COMPLETADO',
        ]);
        $this->render();
    }
    public function markUnPaid(Facturas $factura){

        $factura->update([
            'pago_estado' => 'UNPAID',
            'fecha_pago' => NULL,
        ]);
        $this->render();
    }    
    public function openModalDelete(Facturas $factura){
        //dd($factura);
        $this->emit('openModalDelete', $factura);
        $this->openModalDelete = true;

    }

    public function modalOpenSend(Facturas $factura){

        $this->emit('modalOpenSend', $factura);

    }

}
