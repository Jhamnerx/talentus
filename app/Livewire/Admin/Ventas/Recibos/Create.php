<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use Carbon\Carbon;
use App\Models\Cobros;
use App\Models\Series;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Payments;
use App\Models\plantilla;
use App\Models\Productos;
use App\Models\DetalleCobros;
use App\Models\PaymentMethodType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RecibosRequest;
use App\Helpers\PaymentDestinationHelper;

class Create extends Component
{


    public $clientes_id, $serie, $numero, $serie_numero, $fecha_emision, $fecha_pago, $divisa = 'PEN', $estado = "COMPLETADO";
    public $forma_pago = "009", $total = 0.0;
    public $tipo_venta = "CONTADO", $nota, $payment_destination_id;


    public $showCredit = false;
    public Collection $items;

    public Collection $selected;
    public $simbolo = "S/. ";
    public $cliente;
    public $product_selected_id;

    public Collection $detalle_cuotas;
    public Collection $payment_destinations;
    public ?Collection $payment_methods = null;
    public Collection $pagos_detalle;


    //DETALLE DESDE COBRO
    public $detalle_ids;
    public $cobro_id;
    public $empresa_id;

    public $tipo_cambio = 0.00;

    public function mount($detalle_ids = null, $cobro_id = null)
    {
        $this->setSerieMount();

        $this->fecha_emision = Carbon::now()->format('Y-m-d');
        $this->fecha_pago = Carbon::now()->format('Y-m-d');
        $this->items = collect();

        // Consultar tipo de cambio
        try {
            $factiliza = new \App\Services\FactilizaService();
            $resultado = $factiliza->consultarTipoCambio();
            $this->tipo_cambio = $resultado['venta'] ?? 3.80;
        } catch (\Exception $e) {
            $this->tipo_cambio = 3.80;
        }

        // Cargar destinos de pago (Caja + Cuentas Bancarias)
        $this->payment_destinations = PaymentDestinationHelper::getPaymentDestinations();

        // Cargar métodos de pago desde catálogo
        $this->payment_methods = PaymentMethodType::where('active', true)
            ->get()
            ->map(fn($method) => [
                'id' => $method->id,
                'name' => $method->description,
            ]);

        // Inicializar pagos_detalle con un pago por defecto
        $this->pagos_detalle = collect([[
            'metodo_pago_id' => '009',
            'payment_destination_id' => '',
            'referencia' => '',
            'monto' => 0.00,
        ]]);

        $this->selected = collect([
            'producto_id' => null,
            'producto' => "",
            'descripcion' => "",
            'cantidad' => "1",
            'precio' => 0.00
        ]);

        $this->empresa_id = plantilla::first()->empresa->id;


        // Asignar cliente_id
        $cobro = Cobros::find($cobro_id);

        if ($cobro) {
            $this->cliente = Clientes::find($cobro->clientes_id);
            $this->clientes_id = $cobro->clientes_id;
            $this->divisa = $cobro->divisa;
        }

        // Procesar items si no son nulos
        if ($detalle_ids) {
            $this->procesarItems($detalle_ids);
        }
    }

    public function render()
    {

        return view('livewire.admin.ventas.recibos.create');
    }

    public function setSerieMount()
    {
        $serie = Series::where('tipo_comprobante_id', '10')->first();
        $this->serie = $serie->serie;
        $this->numero = $serie->correlativo + 1;
        $this->serie_numero = $this->serie . "-" . $this->numero;
    }

    public function updatedSerie($value)
    {
        $this->changeSerieUpdate($value);
    }

    public function updatedNumero($value)
    {

        $this->serie_numero = $this->serie . "-" . $this->numero;
    }

    public function changeSerieUpdate($serie)
    {

        if ($serie) {

            $serie = Series::where('serie', $serie)->first();
            $this->serie = $serie->serie;
            $this->numero = $serie->correlativo + 1;
            $this->serie_numero = $this->serie . "-" . $this->numero;
        } else {

            $this->reset('numero');
        }
    }
    public function procesarItems($items)
    {
        $this->detalle_ids = $items;
        $detalles = DetalleCobros::whereIn('id', $items)->get();

        $detalles->each(function ($item) {
            $cantidad = $this->calcularCantidad($item->cobro->periodo);
            $valor_unitario = $item->plan;

            $this->items->push([
                'producto_id' => $item->cobro->producto->id,
                'producto' => $item->cobro->producto->descripcion,
                'descripcion' => $item->cobro->descripcion . " DE LA PLACA: " . $item->vehiculo->placa . ' HASTA LA FECHA ' . $item->fecha->format('d-m-Y'),
                'cantidad' => $cantidad,
                'precio' => $valor_unitario,
                'total' => round((floatval($cantidad) * floatval($valor_unitario)), 2),
            ]);
        });

        $this->reCalTotal();
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

    function addProducto()
    {

        $this->validate([
            'selected.producto_id' => 'required',
            'selected.producto' => 'required',
            'selected.descripcion' => 'nullable',
            'selected.cantidad' => 'required',
            'selected.precio' => 'required',

        ], [
            'selected.producto_id.required' => 'Seleccion una producto',
            'selected.producto.required' => 'Por favor ingresa un producto',
            'selected.cantidad.required' => 'Por favor ingresa una cantidad',
            'selected.precio.required' => 'Por favor ingresa un precio',
        ]);

        try {

            // $igv = round(round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2) * 18 / 100, 2);
            $total = round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2);
            $this->items->push([
                'producto_id' => $this->selected["producto_id"],
                'producto' => $this->selected->get('producto'),
                'descripcion' => $this->selected["descripcion"],
                'cantidad' => $this->selected["cantidad"],
                'precio' => $this->selected["precio"],
                'total' => $total,
            ]);

            $this->selected = collect();
            $this->reset('product_selected_id');

            //calcular los totales al añadir un producto
            $this->total = $this->calcularTotal();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'PRODUCTO AÑADIDO',
                mensaje: 'añadiste el producto ' . $this->selected->get('producto'),
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR EL AÑADIR',
                mensaje: $e->getMessage(),
            );
        }
    }
    function updatedProductSelectedId(Productos $producto)
    {

        $this->selected = collect([
            'producto_id' => $producto->id,
            'producto' => $producto->descripcion,
            'descripcion' => $producto->descripcion,
            'cantidad' => "1",
            'precio' => $producto->valor_unitario
        ]);
    }
    public function updatedItems($name, $value)
    {
        $this->items = $this->items->map(function ($item, $key) {

            $item["total"] =  round(floatval($item["cantidad"]) *  floatval($item["precio"]), 2);
            return $item;
        });

        $this->reCalTotal();
    }


    public function reCalTotal()
    {
        $this->total =  $this->calcularTotal();

        // Recalcular montos de pagos cuando cambia el total
        if ($this->tipo_venta === 'CONTADO' && $this->pagos_detalle->count() > 0) {
            $this->recalcularMontosPagos();
        }
    }



    public function calcularTotal()
    {
        $sub_total = $this->items->map(function ($item, $key) {

            $sub_total = 0;
            $sub_total =  $sub_total + $item["total"];

            return number_format($sub_total, 2, '.', '');
        });

        return $sub_total->sum();
    }


    public function updatedDivisa($value)
    {
        if ($value == "USD") {
            $this->simbolo = "$";
        } else {
            $this->simbolo = "S/. ";
        }
    }
    public function updatedClientesId($value)
    {
        $this->cliente = Clientes::find($this->clientes_id);
    }
    public function unselectCliente()
    {
        $this->cliente = null;
        $this->clientes_id = null;
        $this->dispatch('unselect-cliente');
    }

    public function updated($name, $value)
    {
        $request = new RecibosRequest();
        $error = $this->validateOnly($name, $request->rules(), $request->messages());
    }

    public function save()
    {

        $request = new RecibosRequest();
        $data = $this->validate($request->rules(), $request->messages());

        $recibo = Recibos::create($data);

        Recibos::createItems($recibo, $data["items"]);

        //CREAR REGISTROS DE PAYMENT DESDE PAGOS_DETALLE
        if ($this->forma_pago === '009') { // CONTADO
            // Validar que la suma de pagos coincida con el total
            $total_pagos = $this->pagos_detalle->sum('monto');
            if (round($total_pagos, 2) != round($this->total, 2)) {
                throw new \Exception("La suma de pagos (" . round($total_pagos, 2) . ") no coincide con el total (" . round($this->total, 2) . ")");
            }

            foreach ($this->pagos_detalle as $pago) {
                Payments::create([
                    'paymentable_type' => Recibos::class,
                    'paymentable_id' => $recibo->id,
                    'payment_method_id' => $pago['metodo_pago_id'],
                    'payment_destination_id' => $pago['payment_destination_id'],
                    'numero_operacion' => $pago['referencia'] ?? null,
                    'monto' => $pago['monto'],
                    'fecha' => $this->fecha_emision,
                    'divisa' => $this->divisa,
                    'user_id' => Auth::user()->id,
                    'empresa_id' => session('empresa'),
                ]);
            }

            // Actualizar pago_estado del recibo a PAID
            $recibo->pago_estado = 'PAID';
            $recibo->save();
        }

        //ACTUALIZAR CORRELATIVO DE SERIE UTILIZADA
        $recibo->getSerie->increment('correlativo');

        session()->flash('recibo-registrado', 'El Recibo se registro con exito');
        $this->redirectRoute('admin.ventas.recibos.index');
    }

    public function eliminarProducto($key)
    {
        unset($this->items[$key]);
        $this->items;
        $this->reCalTotal();
    }
    public function addProductoModal($producto)
    {
        $this->dispatch('add-producto-modal', producto: $producto);
    }

    public function agregarPago()
    {
        $this->pagos_detalle->push([
            'metodo_pago_id' => '009',
            'payment_destination_id' => '',
            'referencia' => '',
            'monto' => 0.00,
        ]);
        $this->recalcularMontosPagos();
    }

    public function eliminarPago($index)
    {
        if ($this->pagos_detalle->count() > 1) {
            $this->pagos_detalle->forget($index);
            $this->pagos_detalle = $this->pagos_detalle->values();
            $this->recalcularMontosPagos();
        } else {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'MÍNIMO UN PAGO',
                mensaje: 'Debe existir al menos un método de pago',
            );
        }
    }

    public function recalcularMontosPagos()
    {
        $cantidad_pagos = $this->pagos_detalle->count();

        if ($cantidad_pagos === 0) {
            return;
        }

        if ($cantidad_pagos === 1) {
            // Si hay un solo pago, asignar el total completo
            $this->pagos_detalle = $this->pagos_detalle->map(function ($pago) {
                $pago['monto'] = $this->total;
                return $pago;
            });
        } else {
            // Si hay múltiples pagos, dividir el total entre la cantidad
            $monto_por_pago = round($this->total / $cantidad_pagos, 2);
            $diferencia = round($this->total - ($monto_por_pago * $cantidad_pagos), 2);

            $this->pagos_detalle = $this->pagos_detalle->map(function ($pago, $index) use ($monto_por_pago, $diferencia, $cantidad_pagos) {
                // Asignar el monto dividido
                $pago['monto'] = $monto_por_pago;

                // Agregar la diferencia al último pago para cuadrar exactamente
                if ($index === $cantidad_pagos - 1 && $diferencia != 0) {
                    $pago['monto'] = round($pago['monto'] + $diferencia, 2);
                }

                return $pago;
            });
        }
    }
}
