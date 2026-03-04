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
use App\Models\PaymentMethodType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RecibosRequest;
use App\Helpers\PaymentDestinationHelper;
use App\Models\NotificacionCobro;

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
    public $cobro_id;
    public $empresa_id;
    public $notificacion_ids_array = [];
    public $cobro_redirect_back = null;

    public $tipo_cambio = 0.00;

    public function mount($notificacion_ids = null)
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


        // Asignar cliente y contexto
        if ($notificacion_ids) {
            $ids       = is_array($notificacion_ids) ? $notificacion_ids : $notificacion_ids;
            $firstNotif = NotificacionCobro::with(['cobro', 'cliente'])->find(
                is_array($ids) ? $ids[0] : $ids
            );

            if ($firstNotif) {
                $cobro = $firstNotif->cobro;
                $this->cliente   = $firstNotif->cliente;
                $this->clientes_id = $firstNotif->cliente_id;
                $this->divisa    = $firstNotif->moneda ?? $cobro->divisa ?? 'PEN';
                $this->cobro_id  = $firstNotif->cobro_id;
                $this->cobro_redirect_back = session('cobro_redirect_back');

                $sessionFormaPago = session('cobro_forma_pago');
                if ($sessionFormaPago) {
                    $this->tipo_venta = $sessionFormaPago;
                    $this->showCredit = $sessionFormaPago === 'CREDITO';
                    session()->forget('cobro_forma_pago');
                }
            }

            $this->notificacion_ids_array = is_array($ids) ? $ids : [$ids];

            $this->procesarItemsDesdeNotificaciones($this->notificacion_ids_array);
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
    /**
     * Procesa items desde NotificacionCobro (nuevo flujo preferido).
     * Para recibos: el monto ya no lleva IGV, valor_unitario = monto total.
     */
    public function procesarItemsDesdeNotificaciones(array $notificacionIds): void
    {
        $notificaciones = NotificacionCobro::with([
            'detalleCobro.planModel',
            'cobro.producto',
            'vehiculo',
        ])->whereIn('id', $notificacionIds)->get();

        $servicioCobro = Productos::getServicioCobro();
        $servicioDescripcion = $servicioCobro?->descripcion ?? '';

        foreach ($notificaciones as $notificacion) {
            $detalle  = $notificacion->detalleCobro;
            $cobro    = $notificacion->cobro;
            $vehiculo = $notificacion->vehiculo;
            $producto = $cobro->producto;

            $montoTotal = (float) $notificacion->monto;

            $periodo = $detalle?->periodo ?? $cobro->periodo ?? 'MENSUAL';
            $periodoTexto = match (strtoupper((string) $periodo)) {
                'BIMENSUAL'  => '2 meses',
                'TRIMESTRAL' => '3 meses',
                'SEMESTRAL'  => '6 meses',
                'ANUAL'      => '12 meses',
                default      => '1 mes',
            };

            $planNombre  = $detalle?->planModel?->name ?? $producto?->descripcion ?? 'Servicio GPS';
            $placa       = $vehiculo?->placa ?? 'S/P';
            $fechaInicio = $detalle?->fecha_inicio?->format('d/m/Y') ?? '';
            $fechaVence  = $notificacion->fecha_vencimiento?->format('d/m/Y') ?? '';
            $descripcion = trim("{$servicioDescripcion} {$planNombre} - periodo {$periodoTexto} placa {$placa} inicio {$fechaInicio} - fin {$fechaVence}");

            $this->items->push([
                'producto_id' => $producto->id,
                'producto'    => $producto->descripcion,
                'descripcion' => $descripcion,
                'cantidad'    => 1,
                'precio'      => $montoTotal,
                'total'       => $montoTotal,
            ]);
        }

        $this->reCalTotal();
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
                // Parsear destination_type y destination_id desde formato "tipo|id"
                $destinationRecord = PaymentDestinationHelper::parseDestination($pago['payment_destination_id']);

                if (!$destinationRecord || !$destinationRecord['destination_id']) {
                    throw new \Exception("Destino de pago inválido para monto {$pago['monto']}");
                }

                Payments::create([
                    'paymentable_type' => Recibos::class,
                    'paymentable_id' => $recibo->id,
                    'payment_method_id' => $pago['metodo_pago_id'],
                    'destination_type' => $destinationRecord['destination_type'],
                    'destination_id' => $destinationRecord['destination_id'],
                    'numero_operacion' => $pago['referencia'] ?? null,
                    'monto' => $pago['monto'],
                    'fecha' => $this->fecha_emision,
                    'divisa' => $this->divisa,
                    'cobros_id' => $this->cobro_id,
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

        // AUTO-UPDATE desde flujo de notificaciones
        if (!empty($this->notificacion_ids_array)) {
            $notificaciones = NotificacionCobro::with(['detalleCobro', 'cobro'])
                ->whereIn('id', $this->notificacion_ids_array)->get();

            // Renovar período de cada detalle individualmente (si auto_renovar)
            // El DetalleCobroObserver sincronizará la suscripción automáticamente
            foreach ($notificaciones as $notif) {
                $det   = $notif->detalleCobro;
                $cobro = $notif->cobro;

                if ($det && $cobro) {
                    $nuevoInicio = $notif->fecha_vencimiento->copy();
                    $nuevoFin    = match (strtoupper($cobro->periodo ?? 'MENSUAL')) {
                        'BIMENSUAL'  => $nuevoInicio->copy()->addMonths(2),
                        'TRIMESTRAL' => $nuevoInicio->copy()->addMonths(3),
                        'SEMESTRAL'  => $nuevoInicio->copy()->addMonths(6),
                        'ANUAL'      => $nuevoInicio->copy()->addYear(),
                        default      => $nuevoInicio->copy()->addMonth(),
                    };
                    // Actualiza fecha_inicio y fecha_vencimiento;
                    // el observer sincroniza la suscripción del vehículo
                    $det->update([
                        'fecha_inicio'      => $nuevoInicio,
                        'fecha_vencimiento' => $nuevoFin,
                    ]);
                }
            }

            // Actualizar estado de NotificacionCobro
            $estadoNotif = $this->tipo_venta === 'CONTADO' ? 'PAGADO' : 'FACTURADO';
            $notifData = [
                'estado'            => $estadoNotif,
                'recibo_id'         => $recibo->id,
                'fecha_facturacion' => now(),
            ];
            if ($this->tipo_venta === 'CONTADO') {
                $notifData['fecha_pago'] = now();
            }
            NotificacionCobro::whereIn('id', $this->notificacion_ids_array)->update($notifData);
        }

        session()->flash('recibo-registrado', 'El Recibo se registró con éxito');

        // Redirect back al cobro si viene del módulo de cobros
        $redirectBack = $this->cobro_redirect_back ?: null;
        session()->forget('cobro_redirect_back');

        if ($redirectBack) {
            return redirect($redirectBack);
        }

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
