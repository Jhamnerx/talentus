<?php

namespace App\Livewire\Admin\Ventas\Recibos;

use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Payments;
use App\Models\Productos;
use App\Models\Dispositivos;
use App\Models\PaymentMethodType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RecibosRequest;
use App\Helpers\PaymentDestinationHelper;
use Livewire\Attributes\Computed;

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
    public Collection $pagos_detalle;

    // Modal selección de IMEI para equipos GPS
    public bool $showImeiModal = false;
    public array $pendingGpsItem = [];
    public array $selectedImeis = [];  // [{id, imei}] acumulando selecciones durante el modal
    public ?int $editingImeiIndex = null;  // índice del item editado, null = modo añadir
    public string $imeiSearch = '';

    #[Computed]
    public function paymentMethods()
    {
        return PaymentMethodType::where('active', true)
            ->get()
            ->map(fn($method) => [
                'id' => $method->id,
                'name' => $method->description,
            ]);
    }

    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    public function mount()
    {
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
            'producto_id' => null,
            'producto' => "",
            'descripcion' => "",
            'descripcion_pdf' => null,
            'imeis' => null,
            'cantidad' => "1",
            'precio' => 0.00,
            'es_dispositivo' => false,
            'modelo_id' => null,
            'categoria_es_gps' => false,
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
                    'payment_destination_id' => ($payment->destination_type && $payment->destination_id)
                        ? $payment->destination_type . '|' . $payment->destination_id
                        : '',
                    'referencia' => $payment->numero_operacion,
                    'monto' => $payment->monto,
                ];
            });
        } else {
            // Sin pagos previos — opcional, se puede registrar después
            $this->pagos_detalle = collect([]);
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

        // Si el producto es equipo GPS, solicitar IMEI primero
        if ($this->selected->get('es_dispositivo') && $this->selected->get('categoria_es_gps') && $this->selected->get('modelo_id')) {
            $this->pendingGpsItem = $this->selected->toArray();
            $this->imeiSearch = '';
            $this->showImeiModal = true;
            return;
        }

        try {

            $total = round((floatval($this->selected["cantidad"]) * floatval($this->selected["precio"])), 2);
            $this->items->push([
                'producto_id' => $this->selected["producto_id"],
                'producto' => $this->selected->get('producto'),
                'descripcion' => $this->selected["descripcion"],
                'descripcion_pdf' => null,
                'imeis' => null,
                'cantidad' => $this->selected["cantidad"],
                'precio' => $this->selected["precio"],
                'total' => $total,
            ]);

            $this->selected = collect();
            $this->reset('product_selected_id');

            //calcular los totales al añadir un producto
            $this->reCalTotal();

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
            'descripcion_pdf' => null,
            'imeis' => null,
            'cantidad' => "1",
            'precio' => $producto->valor_unitario,
            'es_dispositivo' => (bool) $producto->es_dispositivo,
            'modelo_id' => $producto->modelo_id,
            'categoria_es_gps' => (bool) ($producto->categoria?->es_equipo_gps ?? false),
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

    /** Dispositivos en STOCK del modelo pendiente, filtrados por búsqueda de IMEI */
    #[Computed]
    public function dispositivosImei()
    {
        if (empty($this->pendingGpsItem['modelo_id'])) {
            return collect();
        }
        $excludeIds = collect($this->selectedImeis)->pluck('id')->toArray();
        return Dispositivos::where('modelo_id', $this->pendingGpsItem['modelo_id'])
            ->where('estado', Dispositivos::STOCK)
            ->whereNotIn('id', $excludeIds)
            ->when($this->imeiSearch, fn($q) => $q->where('imei', 'like', '%' . $this->imeiSearch . '%'))
            ->limit(50)
            ->get();
    }

    /** Cada clic agrega un IMEI; cuando count == cantidad, cierra el modal */
    public function confirmarImei(int $dispositivoId): void
    {
        $needed = (int) ($this->pendingGpsItem['cantidad'] ?? 1);
        if (count($this->selectedImeis) >= $needed) {
            return;
        }

        $dispositivo = Dispositivos::findOrFail($dispositivoId);
        $this->selectedImeis[] = ['id' => $dispositivo->id, 'imei' => $dispositivo->imei];
        $this->imeiSearch = '';

        if (count($this->selectedImeis) < $needed) {
            return;
        }

        $item       = $this->pendingGpsItem;
        $imeiList   = collect($this->selectedImeis)->pluck('imei')->join(', ');
        $imeiIds    = collect($this->selectedImeis)->pluck('id')->toArray();
        $total      = round((floatval($item['cantidad']) * floatval($item['precio'])), 2);
        $wasEditing = $this->editingImeiIndex !== null;

        $newItemData = [
            'producto_id'     => $item['producto_id'],
            'producto'        => $item['producto'],
            'descripcion'     => $item['descripcion'] . ' IMEI: ' . $imeiList,
            'descripcion_pdf' => null,
            'imeis'           => $imeiIds,
            'modelo_id'       => $item['modelo_id'] ?? null,
            'cantidad'        => $item['cantidad'],
            'precio'          => $item['precio'],
            'total'           => $total,
        ];

        if ($wasEditing) {
            $itemsArr = $this->items->toArray();
            $itemsArr[$this->editingImeiIndex] = $newItemData;
            $this->items = collect($itemsArr);
        } else {
            $this->items->push($newItemData);
        }

        $this->reCalTotal();
        $this->showImeiModal = false;
        $this->pendingGpsItem = [];
        $this->selectedImeis = [];
        $this->editingImeiIndex = null;
        $this->imeiSearch = '';
        if (!$wasEditing) {
            $this->selected = collect();
            $this->reset('product_selected_id');
        }
    }

    /** Eliminar un IMEI de la selección actual (dentro del modal) */
    public function quitarImeiSeleccionado(int $index): void
    {
        unset($this->selectedImeis[$index]);
        $this->selectedImeis = array_values($this->selectedImeis);
    }

    /** Abrir modal para editar los IMEIs de un item ya añadido */
    public function editarImeis(int $index): void
    {
        $item = $this->items[$index];
        $this->editingImeiIndex = $index;

        $this->pendingGpsItem = [
            'producto_id' => $item['producto_id'],
            'producto'    => $item['producto'],
            'descripcion' => explode(' IMEI: ', $item['descripcion'])[0],  // base sin IMEIs
            'cantidad'    => $item['cantidad'],
            'precio'      => $item['precio'],
            'modelo_id'   => $item['modelo_id'] ?? null,
        ];

        if (!empty($item['imeis']) && is_array($item['imeis'])) {
            $dispositivos = Dispositivos::whereIn('id', $item['imeis'])->get(['id', 'imei'])->keyBy('id');
            $this->selectedImeis = collect($item['imeis'])->map(function ($id) use ($dispositivos) {
                return ['id' => $id, 'imei' => $dispositivos->get($id)?->imei ?? "ID:{$id}"];
            })->toArray();
        } else {
            $this->selectedImeis = [];
        }

        $this->imeiSearch = '';
        $this->showImeiModal = true;
    }

    /** Cancelar selección de IMEI */
    public function cancelarImei(): void
    {
        $this->showImeiModal = false;
        $this->pendingGpsItem = [];
        $this->selectedImeis = [];
        $this->editingImeiIndex = null;
        $this->imeiSearch = '';
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

            // Capturar IMEIs anteriores antes de borrar detalles
            $oldImeiIds = $this->recibo->detalles()
                ->whereNotNull('imeis')
                ->get()
                ->flatMap(fn($d) => $d->imeis ?? [])
                ->filter()->unique()->values();

            $this->recibo->update($data);

            $this->recibo->detalles()->delete();

            Recibos::createItems($this->recibo, $data["items"]);

            // Nuevos IMEIs del formulario
            $newImeiIds = collect($this->items)
                ->flatMap(fn($item) => (!empty($item['imeis']) && is_array($item['imeis'])) ? $item['imeis'] : [])
                ->filter()->unique()->values();

            // Revertir a STOCK los que se eliminaron
            $toStock = $oldImeiIds->diff($newImeiIds)->values();
            if ($toStock->isNotEmpty()) {
                Dispositivos::whereIn('id', $toStock)->update(['estado' => Dispositivos::STOCK]);
            }

            // Marcar como VENDIDO los que se añadieron
            $toVendido = $newImeiIds->diff($oldImeiIds)->values();
            if ($toVendido->isNotEmpty()) {
                Dispositivos::whereIn('id', $toVendido)->update(['estado' => Dispositivos::VENDIDO]);
            }

            //ACTUALIZAR REGISTROS DE PAYMENT DESDE PAGOS_DETALLE
            if ($this->forma_pago === '009') { // CONTADO
                // Eliminar pagos anteriores
                $this->recibo->payments()->delete();

                // Validar que cada pago con monto tenga destino seleccionado
                foreach ($this->pagos_detalle as $i => $pago) {
                    if (!empty($pago['monto']) && floatval($pago['monto']) > 0) {
                        $destino = PaymentDestinationHelper::parseDestination($pago['payment_destination_id'] ?? null);
                        if (!$destino || !$destino['destination_id']) {
                            throw new \Exception('El pago #' . ($i + 1) . ' no tiene un destino de pago seleccionado.');
                        }
                    }
                }

                $total_pagos = 0;

                foreach ($this->pagos_detalle as $pago) {
                    // Omitir pagos sin monto
                    if (empty($pago['monto']) || floatval($pago['monto']) <= 0) {
                        continue;
                    }

                    // Parsear destination_type y destination_id desde formato "tipo|id"
                    $destinationRecord = PaymentDestinationHelper::parseDestination($pago['payment_destination_id'] ?? null);

                    Payments::create([
                        'paymentable_type' => Recibos::class,
                        'paymentable_id' => $this->recibo->id,
                        'payment_method_id' => $pago['metodo_pago_id'],
                        'destination_type' => $destinationRecord['destination_type'],
                        'destination_id' => $destinationRecord['destination_id'],
                        'numero_operacion' => $pago['referencia'] ?? null,
                        'monto' => $pago['monto'],
                        'fecha' => $this->fecha_emision,
                        'divisa' => $this->divisa,
                        'user_id' => Auth::user()->id,
                        'empresa_id' => session('empresa'),
                    ]);

                    $total_pagos += floatval($pago['monto']);
                }

                // Solo marcar PAID si los pagos cubren el total completo
                if (round($total_pagos, 2) >= round($this->total, 2)) {
                    $this->recibo->pago_estado = 'PAID';
                    $this->recibo->save();
                }
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
