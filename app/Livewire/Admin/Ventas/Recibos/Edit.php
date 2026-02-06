<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Payments;
use App\Models\Productos;
use App\Models\PaymentMethods;
use App\Models\PaymentMethodType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RecibosRequest;
use App\Helpers\PaymentDestinationHelper;

class Edit extends Component
{
    public $clientes_id, $serie, $numero, $serie_numero, $fecha_emision, $fecha_pago, $divisa, $estado;
    public $forma_pago, $total = 0.0;
    public $tipo_venta, $nota, $payment_destination_id;
    public $tipo_cambio = 0.00;


    public $showCredit = false;

    public Recibos $recibo;

    public Collection $items;

    public Collection $selected;
    public $simbolo = "S/. ";
    public $cliente;
    public $product_selected_id;
    public Collection $payment_destinations;
    public ?Collection $payment_methods = null;
    public Collection $pagos_detalle;

    public function mount()
    {
        // Cargar destinos de pago (Caja + Cuentas Bancarias)
        $this->payment_destinations = PaymentDestinationHelper::getPaymentDestinations();

        // Cargar métodos de pago desde catálogo
        $this->payment_methods = PaymentMethodType::where('active', true)
            ->get()
            ->map(fn($method) => [
                'id' => $method->id,
                'name' => $method->description,
            ]);

        $this->clientes_id = $this->recibo->clientes_id;
        $this->serie = $this->recibo->serie;
        $this->numero = $this->recibo->numero;
        $this->serie_numero = $this->serie . "-" . $this->numero;
        $this->fecha_emision = $this->recibo->fecha_emision->format('Y-m-d');
        $this->fecha_pago = $this->recibo->fecha_pago->format('Y-m-d');
        $this->divisa = $this->recibo->divisa;
        $this->estado = $this->recibo->estado;
        $this->forma_pago = $this->recibo->forma_pago;
        $this->total = $this->recibo->total;
        $this->tipo_venta = $this->recibo->tipo_venta;
        $this->tipo_cambio = $this->recibo->tipo_cambio ?? 3.80;

        $this->nota = $this->recibo->nota;

        $this->items = collect($this->recibo->detalles->toArray());

        $this->selected = collect([
            'producto_id' => "",
            'producto' => "",
            'descripcion' => "",
            'cantidad' => 1,
            'total' => "",
            'precio' => 0.00
        ]);

        if ($this->recibo->tipo_venta == "CREDITO") {
            $this->showCredit = true;
        }

        $this->cliente = Clientes::find($this->clientes_id);

        // Cargar pagos existentes o inicializar con default
        $existingPayments = $this->recibo->payments;
        if ($existingPayments->isNotEmpty()) {
            $this->pagos_detalle = $existingPayments->map(function ($payment) {
                return [
                    'metodo_pago_id' => $payment->payment_method_id,
                    'payment_destination_id' => $payment->payment_destination_id,
                    'referencia' => $payment->numero_operacion,
                    'monto' => $payment->monto,
                ];
            });
        } else {
            $this->pagos_detalle = collect([[
                'metodo_pago_id' => '009',
                'payment_destination_id' => '',
                'referencia' => '',
                'monto' => 0.00,
            ]]);
        }
    }

    public function render()
    {

        return view('livewire.admin.ventas.recibos.edit');
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

        try {
            $request = new RecibosRequest();

            $data = $this->validate($request->rules($this->recibo), $request->messages());

            $this->recibo->update($data);

            $this->recibo->detalles()->delete();

            Recibos::createItems($this->recibo, $data["items"]);

            //ACTUALIZAR REGISTROS DE PAYMENT DESDE PAGOS_DETALLE
            if ($this->forma_pago === '009') { // CONTADO
                // Eliminar pagos anteriores
                $this->recibo->payments()->delete();

                // Validar que la suma de pagos coincida con el total
                $total_pagos = $this->pagos_detalle->sum('monto');
                if (round($total_pagos, 2) != round($this->total, 2)) {
                    throw new \Exception("La suma de pagos (" . round($total_pagos, 2) . ") no coincide con el total (" . round($this->total, 2) . ")");
                }

                foreach ($this->pagos_detalle as $pago) {
                    Payments::create([
                        'paymentable_type' => Recibos::class,
                        'paymentable_id' => $this->recibo->id,
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
                $this->recibo->pago_estado = 'PAID';
                $this->recibo->save();
            }

            session()->flash('recibo-actualizo', 'El Recibo se actualizo con exito');
            $this->redirectRoute('admin.ventas.recibos.index');
        } catch (\Throwable $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ACTUALIZAR',
                mensaje: $e->getMessage(),
            );
        }
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
