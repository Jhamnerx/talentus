<?php

namespace App\Livewire\Admin\Compras;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Compras;
use App\Models\Empresa;
use App\Models\Payments;
use App\Models\Productos;
use App\Models\PaymentMethodType;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\FactilizaService;
use App\Helpers\PaymentDestinationHelper;

class Edit extends Component
{
    public $tipo_comprobante_id = '01';
    public $proveedor_id, $serie, $correlativo,  $fecha_emision, $fecha_vencimiento, $divisa = 'PEN', $comentario = '', $observacion = '';
    public $tipo_cambio = 1.00;
    public $forma_pago = 'CONTADO';

    public $product_selected_id;
    public Collection $selected;
    public Collection $items;
    public Collection $pagos_detalle;

    // Propiedades para sistema de cuotas
    public $showCredit = false;
    public $numero_cuotas = 0;
    public $vence_cuotas = 30;
    public Collection $detalle_cuotas;
    public $total_cuotas = 0.00;

    public $sub_total = 0.00, $igv = 0.00, $total = 0.00;

    public Empresa $empresa;
    public $compra;

    /**
     * Obtener destinos de pago (Cajas y Bancos)
     */
    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    /**
     * Obtener métodos de pago desde catálogo
     */
    #[Computed]
    public function paymentMethods()
    {
        return PaymentMethodType::where('active', true)
            ->get()
            ->map(fn($method) => [
                'id' => $method->id,
                'descripcion' => $method->description,
            ]);
    }

    public function mount(Compras $compra)
    {

        $this->compra = $compra;
        $this->tipo_comprobante_id = $compra->tipo_comprobante_id;
        $this->proveedor_id = $compra->proveedor_id;
        $this->serie = $compra->serie;
        $this->correlativo = $compra->correlativo;
        $this->fecha_emision = $compra->fecha_emision->format('Y-m-d');
        $this->fecha_vencimiento = $compra->fecha_vencimiento ? $compra->fecha_vencimiento->format('Y-m-d') : now()->format('Y-m-d');
        $this->divisa = $compra->divisa;
        $this->comentario = $compra->comentario;
        $this->observacion = $compra->observacion;
        $this->forma_pago = $compra->forma_pago;

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

        // Cargar payments existentes
        $this->pagos_detalle = collect(
            $compra->payments->map(fn($payment) => [
                'metodo_pago_id' => $payment->payment_method_id,
                'payment_destination_id' => $payment->destination_type . '|' . $payment->destination_id,
                'referencia' => $payment->numero_operacion,
                'monto' => $payment->monto,
            ])->toArray()
        );

        // Cargar cuotas existentes si es crédito
        if ($compra->forma_pago == 'CREDITO' && $compra->cuotas) {
            $this->showCredit = true;
            $this->numero_cuotas = $compra->numero_cuotas;
            $this->detalle_cuotas = collect($compra->cuotas);
            $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
        } else {
            $this->detalle_cuotas = collect([]);
        }

        $this->empresa = Empresa::first();

        //  CONSULTAR TIPO CAMBIO
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarTipoCambio();
        $this->tipo_cambio = $resultado['venta'] ?? 0;
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

        // Recalcular montos de pagos cuando cambia el total
        if ($this->pagos_detalle->count() > 0) {
            $this->recalcularMontosPagos();
        }
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

    /**
     * Manejo de forma de pago (contado/crédito)
     */
    public function updatedFormaPago()
    {
        $this->toggleShowCredit();
    }

    public function toggleShowCredit()
    {
        if ($this->forma_pago == "CREDITO") {
            $this->showCredit = true;
            $this->resetCreditFields();
        } else {
            $this->showCredit = false;
        }
    }

    public function resetCreditFields()
    {
        $this->numero_cuotas = 0;
        $this->detalle_cuotas = collect([]);
    }

    /**
     * Calcular cuotas cuando cambia el número
     */
    public function updatedNumeroCuotas($value)
    {
        $this->calcularCuotas($value);
    }

    /**
     * Recalcular cuotas cuando cambia el vencimiento
     */
    public function updatedVenceCuotas($value)
    {
        $this->calcularCuotas($this->numero_cuotas);
    }

    /**
     * Calcular cuotas dividiendo el total
     */
    public function calcularCuotas($nCuotas)
    {
        $this->detalle_cuotas = collect([]);
        $fecha = Carbon::parse($this->fecha_emision);

        for ($i = 0; $i < (int)$nCuotas; $i++) {
            $importe = round(floatval($this->total / $nCuotas), 2);

            $this->detalle_cuotas->push([
                'n_cuota' => $i + 1,
                'dias' => $this->vence_cuotas,
                'fecha' => $fecha->addDays((int)$this->vence_cuotas)->format('Y-m-d'),
                'dia_semana' => ucfirst($fecha->dayName),
                'importe' => $this->total > 0 ? $importe : 0.00,
            ]);
        }
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }

    /**
     * Validar y actualizar cuotas manualmente editadas
     */
    public function updatedDetalleCuotas($attr, $valor)
    {
        $this->detalle_cuotas = $this->detalle_cuotas->map(function ($item, $key) use ($attr, $valor) {
            if ($attr == "$key.fecha" && \Carbon\Carbon::parse($item['fecha'])->lt($this->fecha_emision)) {
                $item['fecha'] = $this->fecha_emision;
            }
            return $item;
        });

        $this->validate(['detalle_cuotas.*.fecha' => 'required|date|after_or_equal:fecha_emision'], [
            'detalle_cuotas.*.fecha.after_or_equal' => 'La fecha de vencimiento de la cuota debe ser mayor o igual a la fecha de emisión',
        ]);
        $this->total_cuotas = round($this->detalle_cuotas->sum('importe'), 4);
    }

    public function save()
    {
        $this->validate([
            'proveedor_id' => 'required',
            'tipo_comprobante_id' => 'required',
            'serie' => 'required',
            'correlativo' => 'required',
            'fecha_emision' => 'required',
            'fecha_vencimiento' => 'required',
            'forma_pago' => 'required',
            'divisa' => 'required',
            'items' => 'required',
        ], [
            'proveedor_id.required' => 'Seleccione un proveedor',
            'serie.required' => 'Ingrese la serie',
            'correlativo.required' => 'Ingrese el correlativo',
            'fecha_emision.required' => 'Ingrese la fecha de emisión',
            'fecha_vencimiento.required' => 'Ingrese la fecha de vencimiento',
            'forma_pago.required' => 'Seleccione la forma de pago',
            'divisa.required' => 'Seleccione la divisa',
            'items.required' => 'Ingrese al menos un item',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'proveedor_id' => $this->proveedor_id,
                'tipo_comprobante_id' => $this->tipo_comprobante_id,
                'serie' => $this->serie,
                'correlativo' => $this->correlativo,
                'serie_correlativo' => $this->serie . '-' . $this->correlativo,
                'fecha_emision' => $this->fecha_emision,
                'fecha_vencimiento' => $this->fecha_vencimiento,
                'forma_pago' => $this->forma_pago,
                'divisa' => $this->divisa,
                'comentario' => $this->comentario,
                'observacion' => $this->observacion,
                'sub_total' => $this->sub_total,
                'igv' => $this->igv,
                'total' => $this->total,
            ];

            // Agregar datos de cuotas si es crédito
            if ($this->forma_pago == 'CREDITO') {
                $updateData['numero_cuotas'] = $this->numero_cuotas;
                $updateData['cuotas'] = $this->detalle_cuotas->toArray();
            } else {
                $updateData['numero_cuotas'] = 0;
                $updateData['cuotas'] = null;
            }

            $this->compra->update($updateData);

            $this->compra->detalle()->delete();
            foreach ($this->items as $item) {
                $this->compra->detalle()->create([
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'importe_total' => $item['importe_total'],
                ]);
            }

            // Actualizar payments
            $this->compra->payments()->delete();
            $this->registrarPayments($this->compra);

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

    /**
     * Registrar payments de tipo egreso para la compra
     */
    protected function registrarPayments($compra)
    {
        foreach ($this->pagos_detalle as $pago) {
            if (empty($pago['metodo_pago_id']) || empty($pago['payment_destination_id']) || ($pago['monto'] ?? 0) <= 0) {
                continue;
            }

            // Parsear destination_type y destination_id desde formato "tipo|id"
            $destinationRecord = PaymentDestinationHelper::parseDestination($pago['payment_destination_id']);

            if (!$destinationRecord || !$destinationRecord['destination_id']) {
                throw new \Exception("Destino de pago inválido para monto {$pago['monto']}");
            }

            Payments::create([
                'paymentable_type' => Compras::class,
                'paymentable_id' => $compra->id,
                'payment_method_id' => $pago['metodo_pago_id'],
                'destination_type' => $destinationRecord['destination_type'],
                'destination_id' => $destinationRecord['destination_id'],
                'numero_operacion' => $pago['referencia'] ?? null,
                'monto' => $pago['monto'],
                'fecha' => $this->fecha_emision,
                'divisa' => $this->divisa,
                'tipo_cambio' => $this->tipo_cambio,
                // user_id, empresa_id y type_movement se asignan automáticamente en PaymentsObserver
            ]);
        }
    }

    /**
     * Agregar método de pago al detalle
     */
    public function addPayment()
    {
        $this->pagos_detalle->push([
            'metodo_pago_id' => '009',
            'payment_destination_id' => '',
            'referencia' => '',
            'monto' => 0.00,
        ]);
        $this->recalcularMontosPagos();
    }

    /**
     * Eliminar método de pago del detalle
     */
    public function removePayment($index)
    {
        if ($this->pagos_detalle->count() > 1) {
            $this->pagos_detalle->forget($index);
            $this->pagos_detalle = $this->pagos_detalle->values(); // Reindexar
            $this->recalcularMontosPagos();
        } else {
            $this->pagos_detalle->forget($index);
        }
    }

    /**
     * Recalcular montos de pagos automáticamente
     */
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
