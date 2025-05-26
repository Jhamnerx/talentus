<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use Carbon\Carbon;
use App\Models\Series;
use App\Models\Ventas;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\plantilla;
use App\Models\Productos;
use App\Models\MetodoPago;
use Livewire\Attributes\On;
use App\Models\Presupuestos;
use Illuminate\Validation\Rule;
use App\Models\TipoComprobantes;
use Illuminate\Support\Collection;
use App\Http\Requests\VentasRequest;
use App\Http\Requests\PresupuestosRequest;
use App\Http\Controllers\Admin\UtilesController;
use App\Http\Controllers\Admin\PresupuestoController;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;


class Create extends Component
{

    public $tipo_comprobante_id = '00';
    //PROPIEDADES DE VENTA
    public $serie, $correlativo, $serie_correlativo, $clientes_id,
        $direccion, $fecha, $fecha_caducidad,
        $divisa = "PEN", $tipo_cambio, $metodo_pago_id = "009", $comentario,
        $igv_op = 0.00, $tipo_descuento = "cantidad", $descuento_factor,
        $adelanto = 0.00,  $numero_cuotas = 0,
        $forma_pago = "CONTADO";
    public int $vence_cuotas = 30;
    public $sub_total = 0.00, $op_gravadas = 0.00, $op_exoneradas = 0.00, $op_inafectas = 0.00,
        $op_gratuitas = 0.00, $descuento = 0.00, $igv = 0.00, $icbper = 0.00,  $total = 0.00;


    //SOLES TOTALES
    public
        $sub_total_soles = 0.00, $op_gravadas_soles = 0.00, $op_exoneradas_soles = 0.00, $op_inafectas_soles = 0.00,
        $op_gratuitas_soles = 0.00, $descuento_soles = 0.00, $igv_soles = 0.00, $icbper_soles = 0.00,  $total_soles = 0.00;


    public $features = false;

    public $tipoCambio = 0;
    public $ConvertirSoles = false;

    //PROPIEDADES UTILES
    public $comprobante_slug;
    public $showCredit = false;
    public $product_selected_id;
    public $descuento_monto = 0.00;
    public $total_cuotas = 0.00;

    public Collection $items;
    public Collection $detalle_cuotas;

    public $cliente;
    public plantilla $plantilla;


    public $simbolo = "S/. ";

    public $metodo_type = "02";

    //PROPIEDAD PARA ASIGNAR EL MINIMO DEL CORRELATIVO
    public $min_correlativo;

    public Collection $terminos;


    public Collection $prepayments;

    public function mount()
    {
        $this->setSerieMount();

        //ESTABLACER FECHAS DEFAULT
        $this->fecha = Carbon::now()->format('Y-m-d');
        $this->fecha_caducidad = Carbon::now()->addDays(15)->format('Y-m-d');

        $this->items = collect();
        $this->detalle_cuotas = collect();

        //  CONSULTAR TIPO CAMBIO
        $util = new UtilesController;
        $this->tipo_cambio = $util->tipoCambio();

        $this->plantilla = plantilla::first();

        $this->terminos = collect($this->plantilla->terminos);


        $this->prepayments = collect();
    }


    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.create');
    }



    public function updatedClienteId($value)
    {

        if ($value) {
            //dd(Clientes::findOrFail($value)->direccion);
            $this->direccion = Clientes::findOrFail($value)->direccion;
            $this->cliente = Clientes::findOrFail($value);
        }
    }

    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', '00')->first();
        $this->serie = $serie->serie;
        $this->correlativo = $serie->correlativo + 1;
        $this->min_correlativo = $serie->correlativo + 1;
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

    public function updatedDivisa($value)
    {

        if ($value == "USD") {
            $this->ConvertirSoles = true;
            $this->simbolo = "$";
            $this->calcularTotalSoles();
        } else {
            $this->ConvertirSoles = false;
            $this->simbolo = "S/. ";
        }
    }


    public function updatedFormaPago()
    {
        $this->toggleShowCredit();
    }


    public function toggleShowCredit()
    {

        if ($this->forma_pago == "CREDITO") {

            $this->showCredit = true;
            $this->resetCrediFields();
        } else {
            $this->showCredit = false;
        }
    }


    public function resetCrediFields()
    {
        $this->numero_cuotas = 0;
        $this->adelanto = 0.00;
        $this->detalle_cuotas = collect();
    }

    public function updatedNumeroCuotas($value)
    {

        $this->calcularCuotas($value);
    }

    public function updatedVenceCuotas($value)
    {
        $this->calcularCuotas($this->numero_cuotas);
    }

    public function calcularCuotas($nCuotas)
    {
        dd($this->vence_cuotas);
        $this->detalle_cuotas = collect();
        $fecha = Carbon::now();
        //$this->total_cuotas = 0.00;
        for ($i = 0; $i < (int)$nCuotas; $i++) {

            $this->detalle_cuotas->push([
                'n_cuota' => $i + 1,
                'dias' => $this->vence_cuotas,
                'fecha' => $fecha->addDays($this->vence_cuotas)->format('Y-m-d'),
                'dia_semana' => ucfirst($fecha->dayName),
                'importe' => $this->total > 0 ? round(floatval(($this->total) / $nCuotas), 2)  : 0.00,
            ]);
        }
        $this->total_cuotas = $this->detalle_cuotas->sum('importe');
    }

    public function updatedDetalleCuotas($attr, $valor)
    {

        $this->total_cuotas = $this->detalle_cuotas->sum('importe');
    }

    public function openModalCreateProduct()
    {
        $this->dispatch('openModalCreate');
    }

    public function calcularIgvProducto(Productos $producto): float
    {


        switch ($producto->tipoAfectacion->codigo_afectacion) {
            case "1000":

                $igv = round(floatval($producto->valor_unitario), 2) *  $this->plantilla->igv;

                return floatval($igv);
            default:
                $igv = 0;

                return floatval($igv);
        }
    }




    //AÑADIR ITEM SELECCIONADO A LA LISTA DE ITEMS
    #[On('add-producto-selected')]
    function addProducto($selected)
    {
        try {
            // if ($this->items->contains('producto_id', $selected["producto_id"])) {
            //     $this->dispatch(
            //         'notify-toast',
            //         icon: 'error',
            //         title: 'YA ESTA AÑADIDO',
            //         mensaje: 'El producto o servicio ya esta en el carrito'
            //     );
            // } else {

            $this->items->push([
                'producto_id' => $selected["producto_id"],
                'codigo' => $selected["codigo"],
                'cantidad' => $selected["cantidad"],
                'unit' => $selected["unit"],
                'unit_name' => $selected["unit_name"],
                'producto' => $selected["producto"],
                'descripcion' => $selected["descripcion"],
                'valor_unitario' => $selected["valor_unitario"],
                'precio_unitario' => $selected["precio_unitario"],
                'igv' => $selected["igv"],
                'porcentaje_igv' => $selected["porcentaje_igv"],
                'icbper' => $selected["icbper"],
                'total_icbper' => $selected["total_icbper"],
                'sub_total' => round($selected["valor_unitario"] * $selected["cantidad"], 4),
                'total' => $selected["total"],
                'codigo_afectacion' => $selected["codigo_afectacion"],
                'afecto_icbper' => $selected["afecto_icbper"],
            ]);

            //ENVIAR EVENTO PARA REINICIAR PRODUCTO SELECCIONADO EN MODAL
            $this->dispatch('reset-selected');

            //  CALCULAR TOTALES AL AÑADIR PRODUCTO
            $this->reCalTotal();

            //$this->dispatchBrowserEvent('add-producto');
            $this->calcularCuotas($this->numero_cuotas);
            // }
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR PRODUCTO',
                mensaje: $e->getMessage()
            );
        }
    }

    public function save()
    {

        $request = new PresupuestosRequest();
        $datos = $this->validate($request->rules(), $request->messages());

        try {


            $presupuesto = Presupuestos::create($datos);

            //CREAR ITEMS DE LA VENTA
            $items = Presupuestos::createItems($presupuesto, $datos["items"]);

            //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA
            $presupuesto->getSerie->increment('correlativo');

            session()->flash('cotizacion-registrada', 'Cotizacion registrada');
            $this->redirectRoute('admin.ventas.presupuestos.index');
        } catch (\Throwable $th) {

            $this->dispatch(
                'error',
                title: 'ERROR EN FUNCION: ',
                mensaje: $th->getMessage(),
            );
        }
    }



    public function afterSave($mensaje)
    {
        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'VENTA REGISTRADA',
            mensaje: $mensaje,
        );
    }

    //CALCULAR IGV Y SUN TOTAL AL MODIFICAR CANTIDAD DEL ITEM #
    public function updatedItems($name, $value)
    {
        $this->items = $this->items->map(function ($item, $key) {

            $item["igv"] =  $item["codigo_afectacion"] == '10' ? round(floatval($item["valor_unitario"] * $item["cantidad"]) * $this->plantilla->igv, 4) : 0.00;
            $item["sub_total"] =  round(floatval($item["cantidad"]) *  floatval($item["valor_unitario"]), 4);
            $item["total"] =  $item["afecto_icbper"] ? round(floatval($item["cantidad"]) *  floatval($item["valor_unitario"]) + $item["igv"] + $item["total_icbper"], 4)  : round(floatval($item["cantidad"]) *  floatval($item["valor_unitario"]) + $item["igv"], 4);
            //   $item["afecto_icbper"] ? $item["icbper"] = 0.50 * round(floatval($item["cantidad"])) : 0;
            $item["precio_unitario"] = ($item["valor_unitario"] * $this->plantilla->igv) + $item["valor_unitario"];

            return $item;
        });

        $this->reCalTotal();
    }


    //METODO GLOBAL PARA HACER CALCULOS
    public function reCalTotal()
    {
        $this->descuento =  $this->calcularDescuento();
        $this->sub_total =   $this->calcularSubTotal();
        $this->op_gravadas = $this->calcularOperacionesGravadas($this->descuento);
        // $this->op_gratuitas = $this->calcularOperacionesGratuitas();
        $this->op_exoneradas = $this->calcularOperacionesExoneradas();
        $this->op_inafectas = $this->calcularOperacionesInafectas();
        $this->icbper = $this->calcularIcbper();

        $this->igv =  $this->calcularIgv();
        $this->total =  $this->calcularTotal();
        $this->calcularCuotas($this->numero_cuotas);
        $this->calcularTotalSoles();
    }

    public function calcularTotalSoles()
    {

        if ($this->divisa == "USD") {

            $this->descuento_soles = $this->descuento * $this->tipo_cambio;
            $this->sub_total_soles = $this->sub_total * $this->tipo_cambio;
            $this->op_gravadas_soles = $this->op_gravadas * $this->tipo_cambio;
            $this->op_exoneradas_soles = $this->op_exoneradas * $this->tipo_cambio;
            $this->op_inafectas_soles = $this->op_inafectas * $this->tipo_cambio;
            $this->igv_soles =  $this->igv * $this->tipo_cambio;
            $this->total_soles =  $this->total * $this->tipo_cambio;
        }
    }


    //CALCULAR EL SUB TOTAL DE LOS ITEMS
    public function calcularSubTotal()
    {
        $sub_total = $this->items->map(function ($item, $key) {

            $sub_total = 0;
            $sub_total =  $sub_total + $item["sub_total"];
            return round($sub_total, 4);
        });

        return $sub_total->sum();
    }


    //CALCULAR IGV DESDE EL SUB TOTAL - FALTA POR TRAER EL PROCENTAJE DEL IUMPUESTO DE LA DB
    public function calcularIgv()
    {

        $igv = floatval($this->op_gravadas) *  $this->plantilla->igv;

        return round($igv, 4);
    }

    //CALCULAR TOTALES DE LOS TIPOS DE AFECTACIONES

    public function calcularOperacionesGravadas($descuento)
    {


        $op_gravadas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '10') {
                $op_gravadas = 0.00;
                $op_gravadas = $op_gravadas + $item['sub_total'];
                return round($op_gravadas, 4);
            }
        })->sum();


        return $descuento > 0 ? $op_gravadas - $descuento : $op_gravadas;
    }

    public function calcularOperacionesExoneradas()
    {
        $op_exoneradas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '20') {
                $op_exoneradas = 0.00;
                $op_exoneradas = $op_exoneradas + $item['sub_total'];
                return round($op_exoneradas, 2);
            }
        })->sum();

        return round($op_exoneradas, 2);
    }

    public function calcularOperacionesInafectas()
    {

        $op_inafectas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '30') {
                $op_inafectas = 0.00;
                $op_inafectas = $op_inafectas + $item['sub_total'];
                return round($op_inafectas, 2);
            }
        })->sum();

        return round($op_inafectas, 2);
    }
    public function calcularIcbper()
    {

        $icbper = $this->items->map(function ($item, $key) {

            if ($item['afecto_icbper']) {
                $icbper = 0.00;
                $icbper = $item["icbper"];
                return round($icbper * $item["cantidad"], 4);
            }
        })->sum();

        return round($icbper, 2);
    }

    //CALCUJLAR TOTAL DE ACUERDO AL TIPO DE DESCUENTO Y SI HAY
    public function calcularTotal()
    {
        $total = ($this->op_gravadas + $this->op_exoneradas + $this->op_inafectas + $this->icbper) + $this->igv;

        return round($total, 4);
    }

    public function updatedDescuentoMonto()
    {

        $this->validate([
            'descuento_monto' => [
                'lt:op_gravadas',
                'exclude_if:op_gravadas,0'
            ],
        ]);
        $this->reCalTotal();
    }
    public function updatedTipoDescuento()
    {
        $this->reCalTotal();
    }



    public function calcularDescuento()
    {
        // cantidad - porcentaje

        $descuento = 0.00;
        if ($this->tipo_descuento == "cantidad") {

            if ($this->total) {
                $rules = $this->validate([
                    'descuento_monto' => [
                        'min:0',
                    ],
                ]);
            }

            $descuento = $this->descuento_monto;
            if ($this->sub_total) {

                $this->descuento_factor = round($this->descuento_monto / $this->sub_total, 4);
            }
        } else {
            if ($this->total) {
                $rules = $this->validate([
                    'descuento_monto' => [
                        'min:0',

                    ],
                ]);
            }
            //calculcart el porncetaje del descuento del subtotal
            $descuento = ($this->op_gravadas * $this->descuento_monto) / 100;
        }

        return round($descuento, 2);
    }


    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }

    // public function updated($propertyName)
    // {
    //     $request = new VentasRequest();
    //     $this->validateOnly($propertyName, $request->rules(), $request->messages());
    // }


    public function OpenModalCliente($busqueda)
    {
        $this->dispatch('open-modal-save-cliente', busqueda: $busqueda);
    }

    // ABRIR MODAL PARA REGISTRAR PRODUCTO Y AÑADIR AL COMPROBANTE
    public function openModalAddProducto()
    {
        $this->dispatch('openModalAddProducto');
    }

    #[On('terminos-save')]
    public function setTerminos($terminos)
    {
        $this->terminos = collect($terminos);
    }

    public function openModalTerminos()
    {
        $this->dispatch('open-modal-terminos', terminos: $this->terminos);
    }
}
