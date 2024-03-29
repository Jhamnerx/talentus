<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use Carbon\Carbon;
use Livewire\Component;

use App\Models\plantilla;
use App\Models\Presupuestos;

use Livewire\Attributes\Url;
use Livewire\WithPagination;

use App\Http\Controllers\Admin\RecibosController;
use App\Http\Controllers\Admin\VentasFacturasController;
use App\Models\Series;

class PresupuestosIndex extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: 'null')]
    public $estado = 'null';

    protected $listeners = [
        'render'
    ];

    public function render()
    {

        $presupuestos = Presupuestos::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

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

        if ($estado != "null") {

            $presupuestos = Presupuestos::whereHas('clientes', function ($query) {
                $query->where('razon_social', 'like', '%' . $this->search . '%');
            })
                ->orWhere('numero', 'like', '%' . $this->search . '%')
                ->orWhere('fecha', 'like', '%' . $this->search . '%')
                ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%')
                ->estado($this->estado)
                ->orderBy('created_at', 'DESC')
                ->paginate(15);
        }

        return view('livewire.admin.ventas.presupuestos.presupuestos-index', compact('presupuestos', 'total', 'totales'));
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

    public function convertToInvoice(Presupuestos $presupuesto)
    {

        if (!$presupuesto->invoice) {


            $this->dispatch('convert-to-invoice', presupuesto: $presupuesto);
        } else {

            $this->dispatch(
                'error',
                title: 'ERROR: ',
                mensaje: 'El comprobante de este presupuesto ya fue creada',
            );
        }
    }


    public function convertRecibo(Presupuestos $presupuesto)
    {
        if (!$presupuesto->recibo) {

            try {


                $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

                $serie = Series::where('tipo_comprobante_id', 10)->first();
                $numero = $serie->correlativo + 1;

                $recibo = $presupuesto->recibo()->create([
                    'clientes_id' => $presupuesto->clientes_id,
                    'numero' => $numero,
                    'serie' => $serie->serie,
                    'serie_numero' => $serie->serie . "-" . $numero,
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
                    $recibo->detalles()->create(
                        [
                            'producto' => $item['descripcion'],
                            'descripcion' => $item['descripcion'],
                            'cantidad' => $item['cantidad'],
                            'precio' => $item['valor_unitario'],
                            'total' => $item['sub_total'],
                            'recibos_id' => $item['recibos_id'],
                            'producto_id' => $item['producto_id'],
                        ]
                    );
                }
                //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA
                $recibo->getSerie->increment('correlativo');

                $this->dispatch(
                    'notify-toast',
                    icon: 'success',
                    title: 'RECIBO CREADO',
                    mensaje: 'Se registro el siguiente: ' . $recibo->serie_numero . "."
                );

                $this->render();
            } catch (\Throwable $th) {

                $this->dispatch(
                    'error',
                    title: 'ERROR: ',
                    mensaje: $th->getMessage(),
                );
            }
        } else {

            $this->dispatch(
                'error',
                title: 'ERROR: ',
                mensaje: 'El recibo de este presupuesto ya fue creado',
            );
        }
    }

    public function openModalDelete(Presupuestos $presupuesto)
    {
        $this->dispatch('open-modal-delete', presupuesto: $presupuesto);
    }


    public function modalOpenSend(Presupuestos $presupuesto)
    {

        $this->dispatch('open-modal-send', presupuesto: $presupuesto);
    }
}
