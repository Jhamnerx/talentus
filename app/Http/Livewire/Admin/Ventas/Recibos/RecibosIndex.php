<?php

namespace App\Http\Livewire\Admin\Ventas\Recibos;

use App\Models\Recibos;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
class RecibosIndex extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $status = null;
    public $openModalReporte = false;
    public $modalOpenSend = false;
    
    public function render()
    {

        $desde = $this->from;
        $hasta = $this->to;

        $recibos = Recibos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('tipo_pago', 'like', '%' . $this->search . '%')
            ->orWhere('divisa', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);


        $pagadas = Recibos::where('pago_estado', 'PAID')->count();
        $vencidas = Recibos::where('pago_estado', 'UNPAID')->count();
    
        $total = Recibos::all()->count();

        $totales = [
            'pagadas' => $pagadas,
            'vencidas' => $vencidas,
            'total' => $total,
        ];

        $estado = $this->status;

        if($estado != null){

            $recibos = Recibos::Where('pago_estado', $estado)->paginate(10);
        }

        if (!empty($desde)) {


            $recibos = Recibos::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(divisa like ? OR numero like  ? OR fecha like ? OR total like ?)",
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


        return view('livewire.admin.ventas.recibos.recibos-index', compact('recibos', 'totales'));
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
    public function markPaid(Recibos $recibo){

        $recibo->update([
            'estado' => 'COMPLETADO',
            'pago_estado' => 'PAID',
            'fecha_pago' => Carbon::now(),
        ]);

        $this->render();
    }
    public function markUnPaid(Recibos $recibo){

        $recibo->update([
            'pago_estado' => 'UNPAID',
            'fecha_pago' => NULL,
        ]);
        $this->render();
    }

    public function OpenModalReporte(){

        $this->openModalReporte = true;
        $this->emit('openModalReporte');

    }

    public function modalOpenSend(Recibos $recibo){


        $this->emit('modalOpenSend', $recibo);

    }

}
