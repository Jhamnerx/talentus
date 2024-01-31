<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use Carbon\Carbon;
use App\Models\Series;
use App\Models\Ventas;
use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Presupuestos;
use function PHPSTORM_META\map;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class ConvertTo extends Component
{
    public $modalConvert = false;

    public Presupuestos $presupuesto;
    public $tipo_comprobante_id = '01', $serie, $correlativo, $min_correlativo, $serie_correlativo;

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.convert-to');
    }

    public function mount()
    {
        $this->setSerieMount();
    }

    #[On('convert-to-invoice')]
    public function openModal(Presupuestos $presupuesto)
    {
        $this->presupuesto = $presupuesto;
        $this->modalConvert = true;
    }

    public function updatedTipoComprobanteId($value)
    {

        $this->setSerieMount();
    }


    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', $this->tipo_comprobante_id)->first();
        $this->serie = $serie->serie;
        $this->correlativo = $serie->correlativo + 1;
        $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
    }

    public function updatedSerie($value)
    {
        $this->changeSerieUpdate($value);
    }


    public function changeSerieUpdate($serie)
    {

        if ($serie) {

            $serie = Series::where('serie', $serie)->first();
            $this->serie = $serie->serie;
            $this->correlativo = $serie->correlativo + 1;
            $this->min_correlativo = $serie->correlativo + 1;
            $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
        } else {

            $this->reset('correlativo');
        }
    }

    public function updatedCorrelativo($value)

    {
        $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
    }

    public function save()
    {

        $datos = $this->validate(
            [
                'serie' => 'required',
                'correlativo' => 'required',
                'serie_correlativo' => [
                    'required',
                    Rule::unique('ventas', 'serie_correlativo')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
                ]
            ],
            [
                'serie.required' => 'Selecciona una serie',
                'correlativo.required' => 'El correlativo es obligatorio',
                'serie_correlativo.required' => 'serie y correlativo deben ser seleccionados',
                'serie_correlativo.unique' => 'Esta serie y correlativo ya existen',
            ]
        );

        try {

            $invoice = $this->presupuesto->invoice()->create(
                [
                    'tipo_comprobante_id' => $this->tipo_comprobante_id,
                    'serie' => $this->serie,
                    'correlativo' => $this->correlativo,
                    'serie_correlativo' => $this->serie_correlativo,
                    'cliente_id' => $this->presupuesto->clientes_id,
                    'fecha_emision' => Carbon::now()->format('Y-m-d'),
                    'fecha_vencimiento' => Carbon::now()->addDays(1)->format('Y-m-d'),
                    'divisa' => $this->presupuesto->divisa,
                    'tipo_cambio' => $this->presupuesto->tipo_cambio,
                    'metodo_pago_id' => $this->presupuesto->metodo_pago_id,
                    'comentario' => $this->presupuesto->comentario,
                    'op_gravadas' => $this->presupuesto->op_gravadas,
                    'op_exoneradas' => $this->presupuesto->op_exoneradas,
                    'op_inafectas' => $this->presupuesto->op_inafectas,
                    'op_gratuitas' => $this->presupuesto->op_gratuitas,
                    'descuento' => $this->presupuesto->descuento,
                    'tipo_descuento' => $this->presupuesto->tipo_descuento,
                    'descuento_factor' => $this->presupuesto->descuento_factor,
                    'icbper' => $this->presupuesto->icbper,
                    'sub_total' => $this->presupuesto->sub_total,
                    'igv' => $this->presupuesto->igv,
                    'total' => $this->presupuesto->total,
                    'numero_cuotas' => $this->presupuesto->numero_cuotas,
                    'vence_cuotas' => $this->presupuesto->vence_cuotas,
                    'detalle_cuotas' => $this->presupuesto->detalle_cuotas,
                    //'user_id' => $this->presupuesto->user_id,
                    'estado' => 'BORRADOR',
                    'pago_estado' => $this->presupuesto->pago_estado,
                    'forma_pago' => $this->presupuesto->forma_pago,
                    'fe_estado' => 0,
                ]
            );

            //CREAR ITEMS DE LA VENTA
            $items = Ventas::createItems($invoice, $this->presupuesto->detalles->toArray());

            //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA

            $invoice->getSerie->increment('correlativo');

            //CREAR XML DE INVOICE CREADO
            $api = new ApiFacturacion();

            $mensaje = $api->emitirInvoice($invoice, '01');


            if ($mensaje['fe_codigo_error']) {

                $this->dispatch(
                    'notify-toast',
                    icon: 'success',
                    tittle: 'COMPROBANTE REGISTRADO',
                    mensaje: $mensaje["fe_mensaje_error"] . ': Intenta enviar en un rato',
                );
            } else {
                $this->dispatch(
                    'notify-toast',
                    icon: 'success',
                    tittle: 'COMPROBANTE REGISTRADO',
                    mensaje: $mensaje["fe_mensaje_sunat"],
                );
            }
            $this->afterSave();
        } catch (\Throwable $th) {

            $this->dispatch(
                'error',
                tittle: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterSave()
    {

        $this->modalConvert = false;
        $this->reset('serie', 'correlativo', 'serie_correlativo');
    }

    public function updated($attr)
    {
        $datos = $this->validateOnly(
            $attr,
            [
                'serie' => 'required',
                'correlativo' => 'required',
                'serie_correlativo' => [
                    'required',
                    Rule::unique('ventas', 'serie_correlativo')->where(fn ($query) => $query->where('empresa_id', session('empresa'))),
                ]
            ],
            [
                'serie.required' => 'Selecciona una serie',
                'correlativo.required' => 'El correlativo es obligatorio',
                'serie_correlativo.required' => 'serie y correlativo deben ser seleccionados',
                'serie_correlativo.unique' => 'Esta serie y correlativo ya existen',
            ]
        );
    }
}
