<?php

namespace App\Livewire\Admin\Facturacion\Nota\Credito;

use Carbon\Carbon;
use App\Models\Series;
use App\Models\Ventas;
use Livewire\Component;
use App\Models\plantilla;
use App\Models\TipoComprobantes;
use Illuminate\Support\Collection;
use App\Http\Controllers\Admin\UtilesController;

class Emitir extends Component
{
    //PROPIEDADES DE NOTA
    public $tipo_comprobante_id, $serie, $correlativo, $serie_correlativo,
        $fecha_emision, $fecha_hora_emision;

    //PROPIEDADES UTILES
    public $comprobante_slug;
    public $invoice_type = '01';

    public plantilla $plantilla;


    //PROPIEDAD PARA ASIGNAR EL MINIMO DEL CORRELATIVO
    public $min_correlativo;


    //PROPIEDADES PARA INVOICE SELECCIONADO
    public $invoice_id;
    public Ventas $invoice;

    public $serie_correlativo_ref, $invoice_divisa = "USD", $invoice_fecha_emision, $invoice_fecha_vencimiento, $invoice_metodo_pago_id = "009", $invoice_comentario;
    public $tipo_descuento = "cantidad", $descuento_factor, $forma_pago = "CONTADO";
    public $invoice_cliente_id, $invoice_cliente_razon_social, $invoice_cliente_direccion;
    public $sub_total = 0.00, $op_gravadas = 0.00, $op_exoneradas = 0.00, $op_inafectas = 0.00,
        $op_gratuitas = 0.00, $descuento = 0.00, $igv = 0.00, $icbper = 0.00,  $total;

    public $simbolo = "S/. ";
    public $cliente;

    public Collection $items;


    public function mount()
    {
        $this->tipo_comprobante_id = TipoComprobantes::where('slug', $this->comprobante_slug)->first()->codigo;
        $this->setSerieMount();
        //ESTABLACER FECHAS DEFAULT
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->invoice_fecha_emision = Carbon::now()->format('Y-m-d');
        $this->invoice_fecha_vencimiento = Carbon::now()->format('Y-m-d');
        $this->items = collect();

        //$this->detalle_cuotas = collect();
        //  CONSULTAR TIPO CAMBIO
        $util = new UtilesController;
        // $this->tipo_cambio = $util->tipoCambio();
        $this->plantilla = plantilla::first();


        //
    }
    public function render()
    {

        return view('livewire.admin.facturacion.nota.credito.emitir');
    }
    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', $this->tipo_comprobante_id)->first();
        $this->serie = $serie->serie;
        $this->correlativo = $serie->correlativo + 1;
        $this->min_correlativo = $serie->correlativo + 1;
        $this->serie_correlativo = $this->serie . "-" . $this->correlativo;
    }

    public function verIframe()
    {
        $this->dispatch('ver-iframe-pdf', serie_correlativo: $this->serie_correlativo_ref);
    }

    public function updatedInvoiceId($value)
    {
        $this->resetItems();
    }

    public function selectInvoice()
    {
        $this->invoice = Ventas::find($this->invoice_id);
        $this->serie_correlativo_ref = $this->invoice->serie_correlativo;

        $this->setDataInvoice();
        $this->setDataItemsInvoice();
    }

    public function setDataInvoice()
    {

        $this->invoice_divisa = $this->invoice->divisa;
        $this->invoice_fecha_emision = $this->invoice->fecha_emision;
        $this->invoice_fecha_vencimiento = $this->invoice->fecha_vencimiento;
    }

    public function setDataItemsInvoice()
    {

        foreach ($this->invoice->ventaDetalles  as $selected) {

            $this->items->push([
                'producto_id' => $selected->producto_id,
                'codigo' => $selected->codigo,
                'cantidad' => $selected->cantidad,
                'unit' => $selected->unit,
                'unit_name' => $selected->unit_name,
                'descripcion' => $selected->descripcion,
                'valor_unitario' => $selected->valor_unitario,
                'precio_unitario' => $selected->precio_unitario,
                'igv' => $selected->igv,
                'porcentaje_igv' => $selected->porcentaje_igv,
                'icbper' => $selected->icbper,
                'total_icbper' => $selected->total_icbper,
                'sub_total' => $selected->valor_unitario * $selected->cantidad,
                'total' => $selected->total,
                'codigo_afectacion' => $selected->codigo_afectacion,
                'afecto_icbper' => $selected->afecto_icbper,
            ]);
        }
    }
    public function resetItems()
    {

        $this->items = collect();
    }
}
