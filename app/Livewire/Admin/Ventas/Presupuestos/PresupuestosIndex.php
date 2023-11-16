<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use App\Http\Controllers\Admin\RecibosController;
use App\Http\Controllers\Admin\VentasFacturasController;

use App\Models\plantilla;
use App\Models\Presupuestos;

use Carbon\Carbon;
use Livewire\Component;

use Livewire\WithPagination;

class PresupuestosIndex extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    public $estado = '';
    public $openModalDelete = false;
    public $modalOpenSend = false;

    protected $queryString = [
        'estado' => ['except' => ''],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];
    protected $listeners = [
        'render'
    ];

    public function render()
    {

        $desde = $this->from;
        $hasta = $this->to;

        $presupuestos = Presupuestos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orderBy('numero', 'DESC')
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

        $estado = $this->estado;

        if ($estado != null) {


            $presupuestos = Presupuestos::whereHas('clientes', function ($query) {
                $query->where('razon_social', 'like', '%' . $this->search . '%');
            })
                ->orWhere('numero', 'like', '%' . $this->search . '%')
                ->orWhere('fecha', 'like', '%' . $this->search . '%')
                ->estado($this->estado)
                ->orderBy('numero', 'DESC')
                ->paginate(10);
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
                ->orderBy('numero', 'DESC')
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

        $this->estado = $status;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function markAccept(Presupuestos $presupuesto)
    {

        $presupuesto->update([
            'estado' => '1',
        ]);
        $this->render();
    }
    public function markReject(Presupuestos $presupuesto)
    {
        $presupuesto->update([
            'estado' => '2',
        ]);
        $this->render();
    }


    public function convertInvoice(Presupuestos $presupuesto)
    {
        $facturasController = new VentasFacturasController();
        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

        if (!$presupuesto->factura) {
            $venta = $presupuesto->factura()->create([
                'clientes_id' => $presupuesto->clientes_id,
                'numero' => $facturasController->setNextSequenceNumber(),
                'serie' => $plantilla->series["factura"],
                'fecha_emision' => $date = Carbon::now(),
                'fecha_vencimiento' => $date = Carbon::now(),
                'divisa' => $presupuesto->divisa,
                'tipo_pago' => '',
                'estado' => 'BORRADOR',
                'pago_estado' => 'UNPAID',
                'fecha_pago' => NULL,


                'sub_total' => $presupuesto->sub_total,
                'impuesto' => $presupuesto->impuesto,
                'total' => $presupuesto->total,


                'sent' => false,
                'user_id' => auth()->user()->id,
                'nota' => $presupuesto->nota,
            ]);

            foreach ($presupuesto->detalles->toArray() as $item) {



                $item['facturas_id'] = $venta->id;
                $item['impuesto'] = "";
                $venta->detalles()->create($item);
            }

            $this->dispatch('save-invoice', ['numero' => $venta->numero]);
            $this->render();
        } else {

            $this->dispatch('save-error', ['mensaje' => 'La Factura de este presupuesto ya fue creada']);
        }
    }

    public function convertRecibo(Presupuestos $presupuesto)
    {
        if (!$presupuesto->recibo) {
            $recibosController = new RecibosController();
            $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

            $recibo = $presupuesto->recibo()->create([
                'clientes_id' => $presupuesto->clientes_id,
                'numero' => $recibosController->setNextSequenceNumber(),
                'serie' => $plantilla->series["recibo"],
                'fecha_emision' => $date = Carbon::now(),
                'fecha_pago' => $date = Carbon::now(),
                'tipo_pago' => '',
                'fecha' => $date = Carbon::now(),
                'divisa' => $presupuesto->divisa,
                'total' => $presupuesto->sub_total,
                'estado' => 'COMPLETADO',
                'pago_estado' => 'UNPAID',
                'nota' => $presupuesto->nota,
                'user_id' => auth()->user()->id,

            ]);

            foreach ($presupuesto->detalles->toArray() as $item) {

                $item['recibos_id'] = $recibo->id;
                $recibo->detalles()->create($item);
            }

            $this->dispatch('save-recibo', ['numero' => $recibo->numero]);
            $this->render();
        } else {

            $this->dispatch('save-error', ['mensaje' => 'El recibo de este presupuesto ya fue creado']);
        }
    }

    public function openModalDelete(Presupuestos $presupuesto)
    {
        //dd($presupuesto);
        $this->dispatch('openModalDelete', $presupuesto);
        $this->openModalDelete = true;
    }


    public function modalOpenSend(Presupuestos $presupuesto)
    {


        $this->dispatch('modalOpenSend', $presupuesto);
    }
}