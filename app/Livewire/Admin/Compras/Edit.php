<?php

namespace App\Livewire\Admin\Compras;

use Livewire\Component;
use App\Models\Compras;
use App\Models\Empresa;
use App\Models\Productos;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\UtilesController;

class Edit extends Component
{
    public $tipo_comprobante_id = '01';
    public $proveedor_id, $serie, $correlativo,  $fecha_emision, $divisa = 'PEN', $comentario = '';
    public $tipo_cambio = 1.00;

    public $product_selected_id;
    public Collection $selected;
    public Collection $items;

    public $sub_total = 0.00, $igv = 0.00, $total = 0.00;

    public Empresa $empresa;
    public $compra;

    public function mount(Compras $compra)
    {

        $this->compra = $compra;
        $this->tipo_comprobante_id = $compra->tipo_comprobante_id;
        $this->proveedor_id = $compra->proveedor_id;
        $this->serie = $compra->serie;
        $this->correlativo = $compra->correlativo;
        // $this->fecha_emision = $compra->fecha_emision;
        $this->fecha_emision = $compra->fecha_emision->format('Y-m-d');
        $this->divisa = $compra->divisa;
        $this->comentario = $compra->comentario;

        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "PROD-0000",
            'descripcion' => "",
            'cantidad' => 1,
            'codigo_lote' => "",
            'fecha_vencimiento' => "",
            'precio' => 0.00,
            'importe_total' => 0.00,
        ]);

        $this->items = collect($compra->detalle->toArray());
        $this->empresa = Empresa::first();

        //  CONSULTAR TIPO CAMBIO
        $util = new UtilesController;
        $this->tipo_cambio = $util->tipoCambio();
        $this->reCalTotal();
    }


    public function render()
    {
        return view('livewire.admin.compras.edit');
    }

    public function updatedSerie($value)
    {
        $this->serie = strtoupper($this->serie);
    }

    public function updatedProductSelectedId($value)
    {
        if ($value != "") {
            $producto = Productos::findOrFail($value);
            $this->selected = collect([
                'producto_id' => $producto->id,
                'codigo' => $producto->codigo,
                'descripcion' => $producto->descripcion,
                'cantidad' => 1,
                'precio' => 0.00,
                'importe_total' => 0.00,
            ]);
        }
    }

    public function agregarItem()
    {
        $this->validate([
            'selected.producto_id' => 'required',
            'selected.cantidad' => 'required|numeric|min:1',
            'selected.precio' => 'required|numeric|min:0.01',
            'selected.precio' => 'required|numeric|min:0.01',
        ], [
            'selected.producto_id.required' => 'Seleccione un producto',
            'selected.cantidad.required' => 'Ingrese la cantidad',
            'selected.cantidad.numeric' => 'La cantidad debe ser un número',
            'selected.cantidad.min' => 'La cantidad debe ser mayor a 0',
            'selected.precio.required' => 'Ingrese el precio',
            'selected.precio.numeric' => 'El precio debe ser un número',
            'selected.precio.min' => 'El precio debe ser mayor a 0',
            //'selected.fecha_vencimiento.date_format' => 'Ingrese una fecha válida dia-mes-año',
        ]);
        try {

            $this->items->push($this->selected);
            $this->selected = collect([
                'producto_id' => "",
                'codigo' => "PROD-0000",
                'descripcion' => "",
                'cantidad' => 1,
                'precio' => 0.00,
                'importe_total' => 0.00,
            ]);
            $this->reCalTotal();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function updatedSelected($value, $name)
    {

        if ($name  == "cantidad" && $value == "") {
            $this->selected['cantidad'] = 1;
        }

        $this->selected['importe_total'] = floatval($this->selected['cantidad']) * floatval($this->selected['precio']);
    }

    public function updatedItems($value)
    {
        $this->calcularMontosLinea();
        $this->reCalTotal();
    }
    public function calcularMontosLinea()
    {

        $this->items = $this->items->map(function ($item, $key) {

            $item['importe_total'] = $item['cantidad'] * $item['precio'];
            return $item;
        });
    }

    //METODO GLOBAL PARA HACER CALCULOS
    public function reCalTotal()
    {
        $this->total =  $this->calcularTotal();
        $this->sub_total =   $this->calcularSubTotal();
        $this->igv =  $this->calcularIgv();
    }


    //CALCULAR IGV DESDE EL SUB TOTAL - FALTA POR TRAER EL PROCENTAJE DEL IUMPUESTO DE LA DB
    public function calcularIgv()
    {

        $igv = $this->total - $this->sub_total;
        return round($igv, 4);
    }

    //CALCUJLAR TOTAL DE ACUERDO AL TIPO DE DESCUENTO Y SI HAY
    public function calcularTotal()
    {
        $total = $this->items->map(function ($item, $key) {

            $total = 0;
            $total =  $total + $item["importe_total"];
            return round($total, 4);
        });

        return $total->sum();
    }

    //CALCULAR EL SUB TOTAL DE LOS ITEMS
    public function calcularSubTotal()
    {
        return round($this->total / (1 + $this->empresa->plantilla->igv), 4);
    }

    public function eliminarItem($index)
    {
        $this->items->forget($index);
        $this->reCalTotal();
    }


    public function save()
    {
        $this->validate([
            'proveedor_id' => 'required',
            'tipo_comprobante_id' => 'required',
            'serie' => 'required',
            'correlativo' => 'required',
            'fecha_emision' => 'required',
            'divisa' => 'required',
            'items' => 'required',
        ], [
            'proveedor_id.required' => 'Seleccione un proveedor',
            'serie.required' => 'Ingrese la serie',
            'correlativo.required' => 'Ingrese el correlativo',
            'fecha_emision.required' => 'Ingrese la fecha de emisión',
            'divisa.required' => 'Seleccione la divisa',
            'items.required' => 'Ingrese al menos un item',
        ]);

        try {
            DB::beginTransaction();

            $this->compra->update([
                'proveedor_id' => $this->proveedor_id,
                'tipo_comprobante_id' => $this->tipo_comprobante_id,
                'serie' => $this->serie,
                'correlativo' => $this->correlativo,
                'serie_correlativo' => $this->serie . '-' . $this->correlativo,
                'fecha_emision' => $this->fecha_emision,
                'divisa' => $this->divisa,
                'comentario' => $this->comentario,
                'sub_total' => $this->sub_total,
                'igv' => $this->igv,
                'total' => $this->total,
            ]);

            $this->compra->detalle()->delete();
            foreach ($this->items as $item) {
                $this->compra->detalle()->create([
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'importe_total' => $item['importe_total'],
                ]);
            }
            DB::commit();
            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'EXITO:',
                mensaje: 'Compra actualizada correctamente',
            );
            return redirect()->route('admin.compras.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }
}
