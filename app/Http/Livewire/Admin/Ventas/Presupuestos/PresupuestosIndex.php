<?php

namespace App\Http\Livewire\Admin\Ventas\Presupuestos;


use App\Models\Presupuestos;
use App\Models\VentasFacturas;
use Carbon\Carbon;
use Livewire\Component;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Date;

class PresupuestosIndex extends Component
{

    public $search;
    public $from = '';
    public $to = '';
    public $status = null;

    public function render()
    {

        $desde = $this->from;
        $hasta = $this->to;

        $presupuestos = Presupuestos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('estado', 'like', '%' . $this->search . '%')
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->Where('estado', $this->status)
            ->orderBy('numero', 'desc')
            ->paginate(10);

        


        $pendientes = Presupuestos::where('estado', '0')->count();
        $aceptadas = Presupuestos::where('estado', '1')->count();
        $rechazadas = Presupuestos::where('estado', '2')->count();
        $total = Presupuestos::all()->count();

        $totales = [
            'pendientes' => $pendientes,
            'aceptadas' => $aceptadas,
            'rechazadas' => $rechazadas,
            'total' => $total,
        ];

        $estado = $this->status;

        if($estado != null){

            $presupuestos = Presupuestos::Where('estado', $estado)->paginate(10);
        }


        if (!empty($desde)) {


            $presupuestos = Presupuestos::whereRaw(
                "(created_at >= ? AND created_at <= ?)",
                [
                    $desde . " 00:00:00",
                    $hasta . " 23:59:59"
                ]
            )->whereRaw(
                "(numero like  ? OR fecha like ?)",
                [
                    '%' . $this->search . '%',
                    '%' . $this->search . '%',
                ]
            )
                ->orderBy('numero', 'desc')
                ->paginate(10);
        }

        return view('livewire.admin.ventas.presupuestos.presupuestos-index', compact('presupuestos', 'total', 'totales'));
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

    public function markAccept(Presupuestos $presupuesto){

        $presupuesto->update([
            'estado' => '1',
        ]);
        $this->render();
    }
    public function markReject(Presupuestos $presupuesto){

        $presupuesto->update([
            'estado' => '2',
        ]);
        $this->render();
    }



    public function convertInvoice(Presupuestos $presupuesto)
    {
        if(!$presupuesto->factura)
        {

            $venta = $presupuesto->factura()->create([
                'clientes_id' => $presupuesto->clientes_id,
                'numero' => IdGenerator::generate(['table' => 'facturas','field'=>'numero', 'length' => 9, 'prefix' => 'FACT-']),
                'fecha' => $date = Carbon::now(),
                'fecha_vencimiento' => $date = Carbon::now()->addDay(15),
                'sub_total' => $presupuesto->subtotal,
                'impuesto' => $presupuesto->impuesto,
                'total' => $presupuesto->total,
                'divisa' => $presupuesto->divisa,
                'tipo_pago' => '',
                'estado' => 'COMPLETADO',
                'pago_estado' => 'UNPAID',
                'empresa_id' => session('empresa'),
                'enviado' => false,
                'user_id' => auth()->user()->id,
                'nota' => $presupuesto->nota,
            ]);

            $this->dispatchBrowserEvent('save-invoice', ['numero' => $venta->numero]);
            $this->render();

        }else{

            $this->dispatchBrowserEvent('save-error', ['mensaje' => 'La Factura de este presupuesto ya fue creada']);
        }


        
    }

    public function convertRecibo(Presupuestos $presupuesto)
    {
        if(!$presupuesto->recibo)
        {

            $recibo = $presupuesto->recibo()->create([
                'clientes_id' => $presupuesto->clientes_id,
                'numero' => IdGenerator::generate(['table' => 'recibos','field'=>'numero', 'length' => 9, 'prefix' => 'REC-']),
                'tipo_pago' => '',
                'fecha' => $date = Carbon::now(),
                'divisa' => $presupuesto->divisa,
                'total' => $presupuesto->subtotal,
                'fecha_pago' => $date = Carbon::now(),
                'estado' => '1',
                'empresa_id' => session('empresa'),
                'nota' => $presupuesto->nota,
                'user_id' => auth()->user()->id,
                
            ]);

            $this->dispatchBrowserEvent('save-recibo', ['numero' => $recibo->numero]);
            $this->render();

        }else{

            $this->dispatchBrowserEvent('save-error', ['mensaje' => 'La Factura de este presupuesto ya fue creada']);
        }
    }
}
