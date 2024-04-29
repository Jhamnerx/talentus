<?php

namespace App\Livewire\Admin\Productos;

use Exception;
use Carbon\Carbon;
use App\Models\Ventas;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\plantilla;
use App\Models\Productos;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Collection;

class ModalAddProducto extends Component
{
    public plantilla $plantilla;
    public $showModal = false;

    #[Reactive]
    public $divisa;

    public $product_selected_id;
    public Collection $selected;

    public $tipo_afectacion = "10";

    //ANTICIPOS
    #[Reactive]
    public $deduce_anticipos;
    public $anticipo = false;
    public $comprobante_slug = '';
    #[Reactive]
    public $tipo_comprobante_id;
    public Collection $prepayments;


    public function mount()
    {

        $this->plantilla = plantilla::first();

        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "",
            'cantidad' => 1,
            'unit' => "NIU",
            'unit_name' => "UNIDAD",
            'producto' => "",
            'descripcion' => "",
            'valor_unitario' => 0.00,
            'precio_unitario' => 0.00,
            'igv' => 0.00,
            'icbper' => 0.00,
            'total_icbper' => 0.00,
            'total' => 0.00,
            'porcentaje_igv' => 18,
            'codigo_afectacion' => $this->tipo_afectacion,
            'afecto_icbper' => false,
            'tipo' => 'producto',
        ]);

        $this->prepayments = collect([
            'serie_ref' => "F001",
            'correlativo_ref' => "",
            'serie_correlativo_ref' => "",
            'tipo_comprobante_ref' => $this->tipo_comprobante_id == '01' ? '02' : '03',
            'descripcion' => "",
            'producto' => "",
            'codigo_anticipo' => "",
            'valor_venta_ref' => 0.00,
            'igv' => 0.00,
            'total_invoice_ref' => 0.00,
            'factor_anticipo' => 0.00,
            'fecha_emision_ref' => Carbon::now()->format('Y-m-d'),
        ]);
    }

    #[On('openModalAddProducto')]
    public function showModal()
    {

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function updatedProductos()
    {
    }

    public function render()
    {
        return view('livewire.admin.productos.modal-add-producto');
    }

    public function updated($name, $value)
    {
    }
    //BUSCAR PRODUCTO SELECCIONADO Y AÑADIRLO

    function updatedProductSelectedId($id)
    {
        $producto = Productos::find($id);

        $igv = $this->calcularIgvProducto($producto->valor_unitario);

        $this->selected->put('producto_id', $producto->id);
        $this->selected->put('codigo', $producto->codigo);
        $this->selected->put('unit', $producto->unit_code);
        $this->selected->put('unit_name', $producto->unit->descripcion);
        $this->selected->put('producto', $producto->descripcion);
        $this->selected->put('descripcion', $producto->descripcion);
        $this->selected->put('valor_unitario', round(floatval($producto->valor_unitario), 4));
        $this->selected->put('precio_unitario', round(floatval($this->calcularPrecioUnitario($producto->valor_unitario)), 4));
        //$this->selected->put('igv', round(floatval($igv_p), 4));
        $this->selected->put('icbper', ($producto->afecto_icbper) ? round(floatval($this->plantilla->icbper), 4) : 0.00);
        $this->selected->put('total_icbper', ($producto->afecto_icbper) ? round(floatval($this->plantilla->icbper) * floatval($this->selected["cantidad"]), 4) : 0.00);
        // $this->selected->put('total', round(floatval($producto->valor_unitario), 4) + round(floatval($igv_p), 4));
        $this->selected->put('codigo_afectacion', $this->tipo_afectacion);
        $this->selected->put('afecto_icbper', $producto->afecto_icbper);
        $this->selected->put('tipo', $producto->tipo);
        $this->calcularMontosProducto();
    }

    public function calcularPrecioUnitario($valor_unitario)
    {
        if ($this->tipo_afectacion == "10") {
            return ($valor_unitario * $this->plantilla->igv) + $valor_unitario;
        } else {
            return $valor_unitario;
        }
    }

    public function calcularIgvProducto($valor_unitario)
    {
        $igv = 0.00;
        if ($this->tipo_afectacion == 10) {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = round($sub_total * $this->plantilla->igv, 4);
        } else {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = 0.00;
        }

        return $igv;
    }

    public function updatedTipoAfectacion($value)
    {

        $this->calcularMontosProducto();
        $this->selected["codigo_afectacion"] = $this->tipo_afectacion;
    }

    //CALCULAR SUB TOTAL DEL ITEM SELECCIONADO
    public function updatedSelected($value, $name)
    {
        if ($name != 'total') {
            if ($name == "cantidad" && $value == "") {
                $this->selected['cantidad'] = 0;
            }

            $this->calcularMontosProducto();
        }
    }

    //CALCULAR SUB TOTAL DEL ITEM SELECCIONADO
    public function updatedSelectedTotal($value, $name)
    {
        if ($name == "cantidad" && $value == "") {
            $this->selected['cantidad'] = 0;
        }
        $this->calcularValorUnitario();
        $this->calcularIgv();
        $this->calcularMontosProducto();
    }

    public function calcularValorUnitario()
    {
        $this->selected['valor_unitario'] = round(floatval($this->selected['total']) / (1 + $this->plantilla->igv), 4);
    }

    public function calcularIgv()
    {
        if ($this->tipo_afectacion == 10) {
            $this->selected['igv'] = round(floatval($this->selected['total']) - floatval($this->selected['valor_unitario']), 4);
        } else {
            $this->selected['igv'] = 0.00;
        }
    }

    public function calcularMontosProducto()
    {
        $igv = 0.00;
        $sub_total = 0.00;
        $total_icbper = 0.00;
        $total = 0.00;

        if ($this->tipo_afectacion == 10) {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = round($sub_total * $this->plantilla->igv, 4);
            $total_icbper = ($this->selected['afecto_icbper']) ? floatval($this->selected["cantidad"] * floatval($this->plantilla->icbper)) : 0.00;
            $total = $sub_total + $igv;
        } else {

            $sub_total = ($this->selected["valor_unitario"] * floatval($this->selected["cantidad"]));
            $igv = 0.00;
            $total_icbper = ($this->selected['afecto_icbper']) ? floatval($this->selected["cantidad"] * floatval($this->plantilla->icbper)) : 0.00;
            $total = $sub_total + $igv;
        }

        $this->selected["igv"] = round($igv, 4);
        $this->selected["porcentaje_igv"] = ($this->tipo_afectacion == 10) ? $this->plantilla->igvbnormal : 0.00;
        $this->selected["total"] = ($this->selected["afecto_icbper"]) ? round($total + $total_icbper, 4) : round($total, 4);
        $this->selected["precio_unitario"] = ($this->selected["afecto_icbper"]) ? round(floatval($this->calcularPrecioUnitario($this->selected["valor_unitario"])), 4) : round(floatval($this->calcularPrecioUnitario($this->selected["valor_unitario"])), 4);
        $this->selected["total_icbper"] = $total_icbper;
    }

    #[On('reset-selected')]
    public function resetSelected()
    {
        $this->selected = collect([
            'producto_id' => "",
            'codigo' => "",
            'cantidad' => 1,
            'unit' => "NIU",
            'unit_name' => "UNIDAD",
            'producto' => "",
            'descripcion' => "",
            'valor_unitario' => 0.00,
            'igv' => 0.00,
            'porcentaje_igv' => 0.00,
            'icbper' => 0.00,
            'total_icbper' => 0.00,
            'total' => 0.00,
            'codigo_afectacion' => $this->tipo_afectacion,
            'afecto_icbper' => false
        ]);

        $this->reset('product_selected_id', 'anticipo');
    }

    public function addProducto()
    {
        if ($this->anticipo) {

            $this->dispatch('add-prepayment', prepayments: $this->prepayments);
            $this->closeModal();
        } else {
            try {
                $this->validate([
                    //'selected.producto_id' => 'required',
                    'selected.codigo' => 'required',
                    'selected.cantidad' => 'required|integer|min:1',
                    'selected.unit' => 'required|exists:units,codigo',
                    //'selected.producto' => 'required',
                    'selected.descripcion' => 'required',
                    'selected.valor_unitario' => 'required|',
                    'selected.igv' => 'required',
                    'selected.icbper' => 'required',
                    'selected.total' => 'required',

                ], [
                    'selected.producto_id.required' => 'Seleccion una producto',
                    'selected.codigo.required' => 'Seleccion una producto',
                    'selected.cantidad.required' => 'Por favor ingresa una cantidad',
                    'selected.cantidad.integer' => 'Debe ser un numero entero',
                    'selected.cantidad.min' => 'La cantidad debe ser mayor a 1',
                    'selected.unit.required' => 'Seleccion una producto',
                    'selected.unit.exists' => 'Error no existe la unidad',
                    'selected.descripcion.required' => 'Seleccion una producto',
                    'selected.valor_unitario.required' => 'Valor unitario requerido',
                    'selected.total.required' => 'Sub Total requerido',
                ]);

                $this->dispatch('add-producto-selected', selected: $this->selected);
                $this->closeModal();
            } catch (\Throwable $th) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'ERROR',
                    mensaje: 'Error: ' . $th->getMessage(),
                );
            }
        }
    }

    public function addProductoModal($producto)
    {
        $this->dispatch('add-producto-modal', producto: $producto);
    }

    //BUSCAR FACTURA DE REFERENCIA
    public function updatedPrePaymentsCorrelativoRef($value)
    {
        $this->searchInvoice();
    }
    public function updatedSerieRef($value)
    {
        $this->searchInvoice();
    }

    public function updatedAnticipo($value)
    {
        //$this->resetAnticipo();
    }

    #[On('reset-prepayments')]
    public function resetAnticipo()
    {
        $this->prepayments = collect([
            'serie_ref' => "F001",
            'correlativo_ref' => "",
            'serie_correlativo_ref' => "",
            'tipo_comprobante_ref' => $this->tipo_comprobante_id == '01' ? '02' : '03',
            'descripcion' => "",
            'producto' => "",
            'codigo_anticipo' => "",
            'valor_venta_ref' => 0.00,
            'igv' => 0.00,
            'total_invoice_ref' => 0.00,
            'factor_anticipo' => 0.00,
            'fecha_emision_ref' => Carbon::now()->format('Y-m-d'),
        ]);
        $this->resetSelected();
    }

    public function searchInvoice()
    {

        // $this->validate(
        //     [
        //         'serie_ref' => 'required|min:4|max:4|exists:series,serie',
        //         'correlativo_ref' => 'required',
        //     ],
        //     [
        //         'serie_ref.required' => 'Serie requerida',
        //         'serie_ref.min' => 'La Serie debe tener 4 caracteres',
        //         'serie_ref.max' => 'Serie debe tener 4 caracteres',
        //         'serie_ref.exists' => 'La Serie no existe',
        //         'correlativo_ref.required' => 'Correlativo requerido',
        //     ]
        // );

        try {

            $venta = Ventas::where('serie', $this->prepayments['serie_ref'])->where('correlativo', $this->prepayments['correlativo_ref'])->first();

            if ($venta) {

                if ($venta->divisa != $this->divisa) {
                    throw new Exception('La factura de referencia no es de la misma divisa');
                } else {
                    $this->prepayments['fecha_emision_ref'] = $venta->fecha_emision;
                    $this->prepayments['valor_venta_ref'] = $venta->sub_total;
                    $this->prepayments['igv'] = $venta->igv;
                    $this->prepayments['total_invoice_ref'] = $venta->total;
                    $this->prepayments['serie_correlativo_ref'] = $venta->serie_correlativo;
                    $this->prepayments['descripcion'] = 'ANTICIPO: ' . Str::upper($this->comprobante_slug) . ' DE VENTA NRO° ' . $venta->serie_correlativo;
                    $this->prepayments['producto'] = 'ANTICIPO: ' . Str::upper($this->comprobante_slug) . ' DE VENTA NRO° ' . $venta->serie_correlativo;
                    $this->selected['igv'] = $venta->igv;
                    $this->selected['total'] = $venta->total;

                    $this->selected['codigo'] = 'ANTICIPO';
                    $this->selected['cantidad'] = 1;
                    $this->selected['valor_unitario'] = $venta->sub_total;
                    $this->selected['precio_unitario'] = $venta->total;
                    $this->selected['tipo'] = 'servicio';
                }
            } else {

                throw new Exception('No se encontro la factura de referencia');
            }
        } catch (\Exception $e) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Error: ' . $e->getMessage(),
                timer: 6000
            );
        }
    }

    public function negative($num)
    {
        return -$num;
    }
}
