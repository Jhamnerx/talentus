<?php

namespace App\Livewire\Admin\Facturacion\Ventas;

use Carbon\Carbon;
use App\Models\Cobros;
use App\Models\Series;
use App\Models\Ventas;
use App\Models\Empresa;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\plantilla;
use App\Models\Productos;
use App\Models\MetodoPago;
use Livewire\Attributes\On;
use App\Models\DetalleCobros;
use App\Models\TipoComprobantes;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Collection;
use App\Models\CodigosDetracciones;
use App\Http\Requests\VentasRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\UtilesController;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class Emitir extends Component
{
    //PROPIEDADES DE VENTA
    public $tipo_comprobante_id, $serie, $correlativo, $serie_correlativo, $cliente_id,
        $direccion, $fecha_emision, $fecha_hora_emision, $fecha_vencimiento,
        $divisa = "PEN", $tipo_cambio, $metodo_pago_id = "009", $comentario,
        $igv_op = 0.00, $tipo_descuento = "cantidad", $descuento_factor,
        $adelanto = 0.00,  $numero_cuotas = 0,
        $vence_cuotas = 30, $forma_pago = "CONTADO";

    public $sub_total = 0.00, $op_gravadas = 0.00, $op_exoneradas = 0.00, $op_inafectas = 0.00,
        $op_gratuitas = 0.00, $descuento = 0.00, $igv = 0.00, $icbper = 0.00,  $total;


    public Collection $detalle_cuotas;

    //PROPIEDADES UTILES
    public $comprobante_slug;
    public $showCredit = false;
    public $product_selected_id;
    public $descuento_monto = 0.00;
    public $total_cuotas = 0.00;

    public Collection $items;
    public $cliente;
    public plantilla $plantilla;


    public $simbolo = "S/. ";

    public $metodo_type = "02";

    //PROPIEDAD PARA ASIGNAR EL MINIMO DEL CORRELATIVO
    public $min_correlativo;

    //DISMINUIR STOCK
    public $decrease_stock = true;


    public $tipo_operacion = '0101';
    public $detraccion = false;
    public $openModalDt = false;
    public Collection $datosDetraccion;


    //pago anticipado
    public $pago_anticipado = false;
    public $deduce_anticipos = false;
    public Collection $prepayments;
    public $total_anticipos = 0.00;
    public $igv_anticipos = 0.00;


    //PROPIEDAD PARA VERIFICAR EMPRESA
    public $empresa_id;

    //DETALLE DESDE COBRO
    public $detalle_ids;
    public $cobro_id;

    public function render()
    {
        return view('livewire.admin.facturacion.ventas.emitir');
    }

    public function openModalDetraccion()
    {
        $this->openModalDt = true;
    }

    public function updatedDatosDetraccionCodigoDetraccion($value)
    {
        if ($value) {
            $dt = CodigosDetracciones::where('codigo', $value)->first();
            $this->datosDetraccion['porcentaje'] = $dt->porcentaje;
            $this->calcularMontoDetraccion($this->total);
            $this->calcularCuotas($this->numero_cuotas);
        } else {
            $this->datosDetraccion['porcentaje'] = 0.00;
            $this->datosDetraccion['monto'] = 0.00;
        }
    }

    public function calcularMontoDetraccion($total)
    {
        $monto = $total * ($this->datosDetraccion['porcentaje'] / 100);

        if ($this->divisa == 'USD') {

            $this->datosDetraccion['monto'] = round($monto * $this->tipo_cambio);
        } else {

            $this->datosDetraccion['monto'] = round($monto);
        }
    }

    public function mount($detalle_ids = null, $cobro_id = null)
    {
        //DEFINIR EL TIPO DE COMPROBANTE
        $this->tipo_comprobante_id = TipoComprobantes::where('slug', $this->comprobante_slug)->first()->codigo;
        $this->setSerieMount();

        //ESTABLACER FECHAS DEFAULT
        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        //$this->fecha_hora_emision = Carbon::now();
        //$this->fecha_hora_emision = "2023-07-20 11:44:00";
        $this->fecha_vencimiento = Carbon::now()->format('Y-m-d');
        // $this->fecha_vencimiento = "2023-07-20 11:44:00";

        $this->items = collect();
        $this->detalle_cuotas = collect();

        //  CONSULTAR TIPO CAMBIO
        $util = new UtilesController;
        $this->tipo_cambio = $util->tipoCambio();

        //$comprobante;

        if ($this->tipo_comprobante_id == "03") {
            $this->cliente_id = 1;
            $this->cliente = Clientes::find(1);
        }

        if ($this->tipo_comprobante_id == '02') {

            $this->metodo_type = '03';
        }
        $this->plantilla = plantilla::first();


        //DETRACCION INICIALIZAR DATOS
        $this->datosDetraccion = collect([
            'codigo_detraccion' => '',
            'porcentaje' => 0.00,
            'monto' => 0.00,
            'metodo_pago_id' => '001',
            'cuenta_bancaria' => $this->plantilla->cuenta_detraccion,
        ]);

        $this->prepayments = collect();

        $this->empresa_id = plantilla::first()->empresa->id;

        // Asignar cliente_id
        $cobro = Cobros::find($cobro_id);

        if ($cobro) {
            $this->cliente = Clientes::find($cobro->clientes_id);
            $this->direccion = $this->cliente->direccion;
            $this->cliente_id = $cobro->clientes_id;
        }

        // Procesar items si no son nulos
        if ($detalle_ids) {
            $this->procesarItems($detalle_ids);
        }
    }

    public function procesarItems($items)
    {
        $detalles = DetalleCobros::whereIn('id', $items)->get();
        foreach ($detalles as $detalle) {
            $cantidad = $this->calcularCantidad($detalle->cobro->periodo);
            $igv = $this->calcularIgvProducto($detalle->plan, $cantidad, 10);
            $this->addProducto([
                'producto_id' => $detalle->cobro->producto_id,
                'codigo' => $detalle->cobro->producto->codigo,
                'cantidad' => $cantidad,
                'unit' => $detalle->cobro->producto->unit_code,
                'unit_name' => $detalle->cobro->producto->unit->descripcion,
                'descripcion' => $detalle->cobro->producto->descripcion . " DE LA PLACA: " . $detalle->vehiculo->placa . ' HASTA LA FECHA ' . $detalle->fecha->format('d-m-Y'),
                'valor_unitario' => round(floatval($detalle->plan)),
                'precio_unitario' => round(floatval($this->calcularPrecioUnitario($detalle->plan, 10)), 4),
                'igv' => $igv,
                'porcentaje_igv' => 18,
                'icbper' => 0.00,
                'total_icbper' => 0.00,
                'sub_total' => round(floatval($detalle->plan)) * $cantidad,
                'total' => round(floatval($detalle->plan) * $cantidad + $igv, 4),
                'codigo_afectacion' => 10,
                'afecto_icbper' => false,
                'tipo' => $detalle->cobro->producto->tipo,
            ]);
        }
    }


    public function calcularCantidad($periodo)
    {
        switch ($periodo) {
            case 'MENSUAL':
                return 1;
            case 'BIMENSUAL':
                return 2;
            case 'TRIMESTRAL':
                return 3;
            case 'SEMESTRAL':
                return 6;
            case 'ANUAL':
                return 12;
            default:
                return 1;
        }
    }

    public function calcularPrecioUnitario($valor_unitario, $tipo_afectacion)
    {
        if ($tipo_afectacion == "10") {
            return ($valor_unitario * $this->plantilla->igv) + $valor_unitario;
        } else {
            return $valor_unitario;
        }
    }

    public function calcularIgvProducto($valor_unitario, $cantidad, $tipo_afectacion)
    {
        $igv = 0.00;
        if ($tipo_afectacion == 10) {

            $sub_total = ($valor_unitario * floatval($cantidad));
            $igv = round($sub_total * $this->plantilla->igv, 4);
        } else {

            $sub_total = ($valor_unitario * floatval($cantidad));
            $igv = 0.00;
        }

        return $igv;
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
        $serie = Series::where('tipo_comprobante_id', $this->tipo_comprobante_id)->first();
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
            $this->simbolo = "$";
        } else {
            $this->simbolo = "S/. ";
        }

        $this->calcularMontoDetraccion($this->total);
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
        $this->detalle_cuotas = collect();
        $fecha = Carbon::now();
        //$this->total_cuotas = 0.00;
        for ($i = 0; $i < (int)$nCuotas; $i++) {

            $this->detalle_cuotas->push([
                'n_cuota' => $i + 1,
                'dias' => $this->vence_cuotas,
                'fecha' => $fecha->addDays($this->vence_cuotas)->format('Y-m-d'),
                'dia_semana' => ucfirst($fecha->dayName),
                'importe' => $this->total > 0 ? round(floatval(($this->detraccion ? ($this->total - ($this->datosDetraccion['monto'] / $this->tipo_cambio)) : $this->total) / $nCuotas), 2)  : 0.00,
            ]);
        }
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }



    public function updatedDetalleCuotas($attr, $valor)
    {

        $this->detalle_cuotas = $this->detalle_cuotas->map(function ($item, $key) use ($attr, $valor) {

            // $item['fecha'] = $valor['fecha'];
            $item['dia_semana'] = ucfirst(Carbon::parse($item['fecha'])->dayName);
            $item['dias'] = Carbon::parse($item['fecha'])->diffInDays(Carbon::now());
            return $item;
        });

        $this->validate(['detalle_cuotas.*.fecha' => 'required|date|after_or_equal:fecha_emision'], [
            'detalle_cuotas.*.fecha.after_or_equal' => 'La fecha de vencimiento de la cuota debe ser mayor o igual a la fecha de emisión',
        ]);
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }

    public function openModalCreateProduct()
    {
        $this->dispatch('openModalCreate');
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
                'descripcion' => $this->pago_anticipado ? $selected["descripcion"] . "***Pago Anticipado***" : $selected["descripcion"],
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
                'tipo' => $selected["tipo"],
            ]);

            //ENVIAR EVENTO PARA REINICIAR PRODUCTO SELECCIONADO EN MODAL
            $this->dispatch('reset-selected');

            //  CALCULAR TOTALES AL AÑADIR PRODUCTO
            $this->reCalTotal();


            // $this->calcularCuotas($this->numero_cuotas);
            // }
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR PRODUCTO',
                mensaje: $e->getMessage(),
            );
        }
    }

    #[On('add-prepayment')]
    public function addPrepayment($prepayments)
    {

        $this->prepayments->push($prepayments);
        $this->dispatch('reset-prepayments');
        $this->calcularAnticipos();
    }

    public function save()
    {


        if ($this->empresa_id != session('empresa')) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: 'No puedes registrar una venta de otra empresa',
            );
            return;
        }

        $request = new VentasRequest();
        $datos = $this->validate($request->rules($this->detraccion), $request->messages());
        try {

            $venta = Ventas::create($datos);

            //ACTUALIZAR DIRECCION
            if (is_null($this->cliente->direccion)) {

                $this->cliente->direccion = $datos["direccion"];
                $this->cliente->save();
            }

            //CREAR ITEMS DE LA VENTA
            Ventas::createItems($venta, $datos["items"], $this->decrease_stock);

            //SI DETRACCION ES TRUE CREAR DETRACCION
            if ($this->detraccion) {
                $venta->detraccion()->create([
                    'codigo_detraccion' => $this->datosDetraccion['codigo_detraccion'],
                    'porcentaje' => $this->datosDetraccion['porcentaje'],
                    'monto' => $this->datosDetraccion['monto'],
                    'metodo_pago_id' => $this->datosDetraccion['metodo_pago_id'],
                    'cuenta_bancaria' => $this->datosDetraccion['cuenta_bancaria'],
                    'tipo_cambio' => $this->tipo_cambio,
                ]);
            }

            //SI ES ANTICIPO REGISTRAR ANTICIPO
            if ($this->deduce_anticipos) {

                Ventas::createPrepayments($venta, $this->prepayments);
            }

            //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA
            $venta->getSerie->increment('correlativo');

            if ($this->metodo_type != '03') {
                $api = new ApiFacturacion();

                $mensaje = $api->emitirInvoice($venta, $this->metodo_type, $this->tipo_operacion);

                if ($mensaje['fe_codigo_error']) {

                    session()->flash('venta-registrada', $mensaje["fe_mensaje_error"] . ': Intenta enviar en un rato');
                    $this->redirectRoute('admin.ventas.index');
                } else {

                    session()->flash('venta-registrada', $mensaje['fe_mensaje_sunat']);
                    $this->redirectRoute('admin.ventas.index');
                }
            } else {

                session()->flash('venta-registrada', 'Nota de venta registrada');
                $this->redirectRoute('admin.ventas.index');
            }
        } catch (\Throwable $th) {

            $this->dispatch(
                'error',
                title: 'ERROR: ',
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

        $this->sub_total =   $this->calcularSubTotal();
        $this->descuento =  $this->calcularDescuento();
        $this->op_gravadas = $this->calcularOperacionesGravadas($this->descuento);
        $this->op_exoneradas = $this->calcularOperacionesExoneradas();
        $this->op_inafectas = $this->calcularOperacionesInafectas();

        $this->icbper = $this->calcularIcbper();

        $this->igv =  $this->calcularIgv();
        $this->total =  $this->calcularTotal();
        $this->calcularCuotas($this->numero_cuotas);

        //CALCULAR DETRACCION SI ES TRUE
        if ($this->detraccion) {
            $this->calcularMontoDetraccion($this->total);
        }


        //$this->op_gratuitas = $this->calcularOperacionesGratuitas();
    }

    public function calcularAnticipos()
    {
        //CALCULAR ANTICIPOS
        $this->total_anticipos = $this->calcularTotalAnticipos();
        $this->igv_anticipos = $this->calcularIvgAnticipos();

        $this->reCalTotal();
    }

    //CALCULAR EL SUB TOTAL DE LOS ITEMS
    public function calcularSubTotal()
    {
        $sub_total = $this->items->map(function ($item, $key) {

            $sub_total = 0;
            $sub_total =  $sub_total + $item["sub_total"];
            return round($sub_total, 4);
        });

        return $this->total_anticipos > 0 ? $sub_total->sum() - $this->total_anticipos : $sub_total->sum();
    }

    //CALCULAR IGV DESDE EL SUB TOTAL - FALTA POR TRAER EL PROCENTAJE DEL IUMPUESTO DE LA DB
    public function calcularIgv()
    {
        if ($this->igv_anticipos > 0) {

            $igv = (floatval($this->op_gravadas) *  $this->plantilla->igv);
            return round($igv, 4);
        } else {

            $igv = floatval($this->op_gravadas) *  $this->plantilla->igv;

            return round($igv, 4);
        }
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

        if ($descuento > 0) {

            return $op_gravadas - $descuento;
        } else {

            return round($op_gravadas - $this->total_anticipos, 4);
        }
    }

    // public function calcularOperacionesGratuitas()
    // {

    //     $op_gratuitas = $this->items->map(function ($item, $key) {

    //         if ($item['codigo_afectacion'] == '20') {
    //             $op_gratuitas = 0.00;
    //             $op_gratuitas = $op_gratuitas + $item['sub_total'];
    //             return round($op_gratuitas, 2);
    //         }
    //     })->sum();

    //     return round($op_gratuitas, 2);
    // }

    public function calcularOperacionesExoneradas()
    {
        $op_exoneradas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '20') {
                $op_exoneradas = 0.00;
                $op_exoneradas = $op_exoneradas + $item['sub_total'];
                return round($op_exoneradas, 4);
            }
        })->sum();

        return round($op_exoneradas, 4);
    }

    public function calcularOperacionesInafectas()
    {

        $op_inafectas = $this->items->map(function ($item, $key) {

            if ($item['codigo_afectacion'] == '30') {
                $op_inafectas = 0.00;
                $op_inafectas = $op_inafectas + $item['sub_total'];
                return round($op_inafectas, 4);
            }
        })->sum();

        return round($op_inafectas, 4);
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

        return round($icbper, 4);
    }

    //CALCUJLAR TOTAL DE ACUERDO AL TIPO DE DESCUENTO Y SI HAY
    public function calcularTotal()
    {
        if ($this->igv_anticipos > 0) {

            $total = (($this->op_gravadas + $this->op_exoneradas + $this->op_inafectas + $this->icbper) + $this->igv);

            return round($total, 4);
        } else {
            $total = ($this->op_gravadas + $this->op_exoneradas + $this->op_inafectas + $this->icbper) + $this->igv;

            return round($total, 4);
        }
    }

    public function calcularTotalAnticipos()
    {
        $total_anticipos = $this->prepayments->map(function ($item, $key) {

            $total_anticipos = 0.00;
            $total_anticipos = $total_anticipos + $item['valor_venta_ref'];
            return round($total_anticipos, 4);
        });

        return $total_anticipos->sum();
    }

    public function calcularIvgAnticipos()
    {
        $igv_anticipos = $this->prepayments->map(function ($item, $key) {

            $igv_anticipos = 0.00;
            $igv_anticipos = $igv_anticipos + $item['igv'];
            return round($igv_anticipos, 4);
        });

        return $igv_anticipos->sum();
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

            if ($this->sub_total && $this->descuento_monto > 0) {
                $descuento = $this->descuento_monto;
                $this->descuento_factor = round($this->descuento_monto / $this->sub_total, 5);
            }
        }
        // else {
        //     if ($this->total) {
        //         $rules = $this->validate([
        //             'descuento_monto' => [
        //                 'min:0',

        //             ],
        //         ]);
        //     }
        //     //calculcart el porncetaje del descuento del subtotal
        //     $descuento = ($this->op_gravadas * $this->descuento_monto) / 100;
        // }

        return round($descuento, 4);
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        if ($this->items->count() == 0) {
            $this->descuento_monto = 0.00;
            $this->descuento = 0.00;
        }
        $this->reCalTotal();
    }

    public function eliminarPrepayment($key)
    {
        unset($this->prepayments[$key]);
        $this->prepayments;
        $this->calcularAnticipos();
    }

    public function updated($propertyName)
    {
        $request = new VentasRequest();
        $this->validateOnly($propertyName, $request->rules(), $request->messages());
    }
    // ABRIR MODAL PARA REGISTRAR PRODUCTO Y AÑADIR AL COMPROBANTE
    public function openModalAddProducto()
    {
        $this->dispatch('openModalAddProducto');
    }

    public function OpenModalCliente($busqueda)
    {
        $this->dispatch('open-modal-save-cliente', busqueda: $busqueda);
    }

    public function updatedDetraccion()
    {
        if ($this->detraccion) {
            $this->tipo_operacion = '1001';
            $this->calcularMontoDetraccion($this->total);
        } else {
            $this->tipo_operacion = '0101';
        }
        $this->calcularCuotas($this->numero_cuotas);
    }

    public function updatedPagoAnticipado($value)
    {

        if ($value) {
            $this->items = $this->items->map(function ($item) {
                $item['descripcion'] .= '***Pago Anticipado***';
                return $item;
            });
        } else {
            $this->items = $this->items->map(function ($item) {
                $item['descripcion'] = str_replace('***Pago Anticipado***', '', $item['descripcion']);
                return $item;
            });
        }
    }
}
