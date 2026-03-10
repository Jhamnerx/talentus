<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Cobros;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Vehiculos;
use App\Models\Productos;
use Illuminate\Support\Collection;
use App\Http\Requests\CobrosRequest;

class Edit extends Component
{
    public $clientes_id, $comentario;
    public $nota;
    public $vehiculo_selected;
    public Collection $items;
    public Cobros $cobro;
    public $producto_id;
    public $divisa = 'PEN';
    public $tipo_pago = 'FACTURA';
    public ?float $descuento_global = 0;
    public Collection $planes;

    // Valores por defecto para nuevos vehículos
    public $default_periodo = 'MENSUAL';
    public $default_plan_id = null;
    public $default_fecha_inicio;
    public $default_fecha_vencimiento;

    public function mount(Cobros $cobro)
    {
        $this->cobro = $cobro;
        $this->clientes_id = $cobro->clientes_id;
        $this->comentario = $cobro->comentario;
        $this->divisa = $cobro->divisa;
        $this->tipo_pago = $cobro->tipo_pago ?? 'FACTURA';
        $this->nota = $cobro->nota;
        $this->producto_id = $cobro->producto_id;
        $this->descuento_global = (float) ($cobro->descuento_global ?? 0);

        // Valores por defecto para nuevos vehículos
        $this->default_fecha_inicio = Carbon::now()->format('Y-m-d');
        $this->default_fecha_vencimiento = Carbon::now()->addMonth()->format('Y-m-d');

        $this->planes = collect();
        $this->loadPlanes();

        // Obtener automáticamente el producto de servicio de cobro
        $productoServicio = Productos::getServicioCobro();

        if (!$productoServicio && !$this->producto_id) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'PRODUCTO NO CONFIGURADO',
                mensaje: 'No se encontró un producto marcado como "Servicio de Cobro". Por favor, configura un producto en el módulo de Productos.'
            );
        }

        $this->producto_id = $productoServicio?->id ?? $this->producto_id;

        // Inicializar la colección de items con verificación de vehículo
        $this->items = collect();
        foreach ($this->cobro->detalle as $detalle) {
            if (!$detalle->vehiculo) {
                continue;
            }

            $periodo = $detalle->periodo ?? 'MENSUAL';

            // Para registros legacy: fecha_vencimiento=NULL, fecha=la fecha de vencimiento real.
            // Detectar si el vehículo tiene suscripción activa.
            $tieneSub = $detalle->vehiculo->planSubscription('gps-tracking') !== null;

            if ($detalle->fecha_vencimiento) {
                // Ya tiene fecha_vencimiento (fue sincronizado previamente)
                $fechaVenc  = $detalle->fecha_vencimiento->format('Y-m-d');
                $fechaInicio = $detalle->fecha_inicio
                    ? $detalle->fecha_inicio->format('Y-m-d')
                    : $this->calcularFechaInicio($fechaVenc, $periodo);
            } elseif (!$tieneSub && $detalle->fecha) {
                // Legacy sin suscripción: usar campo fecha como vencimiento y calcular inicio
                $fechaVenc   = Carbon::parse($detalle->fecha)->format('Y-m-d');
                $fechaInicio = $detalle->fecha_inicio
                    ? $detalle->fecha_inicio->format('Y-m-d')
                    : $this->calcularFechaInicio($fechaVenc, $periodo);
            } else {
                // Fallback: fechas desde hoy
                $fechaInicio = Carbon::now()->format('Y-m-d');
                $fechaVenc   = $this->calcularFechaVencimiento($fechaInicio, $periodo);
            }

            $plan = $detalle->plan_id ? Plan::find($detalle->plan_id) : null;
            $montoBase = $plan
                ? $this->calcularMontoItem($plan, $periodo)
                : (float) ($detalle->monto_unidad ?? $detalle->monto_efectivo ?? 0);

            $this->items[$detalle->vehiculo->placa] = [
                'vehiculo_id'       => $detalle->vehiculo_id,
                'placa'             => $detalle->vehiculo->placa,
                'plan_id'           => $detalle->plan_id,
                'monto_base'        => $montoBase,
                'monto'             => $detalle->monto_efectivo,
                'descuento'         => (float) ($detalle->descuento ?? 0),
                'periodo'           => $periodo,
                'fecha_inicio'      => $fechaInicio,
                'fecha_vencimiento' => $fechaVenc,
                'estado'            => $detalle->estado,
            ];
        }
    }

    public function loadPlanes()
    {
        $this->planes = Plan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Priorizar el plan marcado como default, si no existe tomar el primero
        if ($this->planes->isNotEmpty() && !$this->default_plan_id) {
            $planDefault = $this->planes->firstWhere('default', true) ?? $this->planes->first();
            $this->default_plan_id = $planDefault->id;
        }
    }

    /**
     * Convierte un precio desde la moneda del plan hacia la divisa seleccionada.
     * tipo_cambio() retorna cuántos PEN equivalen a 1 USD (ej: 3.5).
     */
    protected function convertirMontoDivisa(float $precio, string $planCurrency = 'PEN'): float
    {
        if ($planCurrency === $this->divisa) {
            return $precio;
        }

        // Buscar tipo de cambio: hoy → ayer → anteayer (cubre fines de semana/feriados)
        $tc = tipo_cambio()
            ?? tipo_cambio(now()->subDay()->format('Y-m-d'))
            ?? tipo_cambio(now()->subDays(2)->format('Y-m-d'));

        if (!$tc) {
            return $precio; // no se pudo obtener, devolver sin convertir
        }

        if ($planCurrency === 'PEN' && $this->divisa === 'USD') {
            return round($precio / $tc, 2);
        }

        if ($planCurrency === 'USD' && $this->divisa === 'PEN') {
            return round($precio * $tc, 2);
        }

        return $precio;
    }

    /**
     * Aplica IGV 18% si el tipo de comprobante es FACTURA/BOLETA.
     * Los precios en planes son la base SIN IGV.
     * Ejemplo: S/. 30.00 (base) → S/. 35.40 (con IGV 18%) para Factura
     *          S/. 30.00 (base) → S/. 30.00 para Recibo
     */
    protected function calcularMontoEfectivo(float $montoBase): float
    {
        if ($this->tipo_pago !== 'RECIBO' && $montoBase > 0) {
            return round($montoBase * 1.18, 2);
        }
        return $montoBase;
    }

    /**
     * Pipeline completo: precio del plan → conversión de divisa → multiplicador de período → IGV.
     */
    protected function calcularMontoItem(?Plan $plan, string $periodo): float
    {
        if (!$plan) {
            return 0;
        }

        $multiplicador = match ($periodo) {
            'BIMENSUAL'  => 2,
            'TRIMESTRAL' => 3,
            'SEMESTRAL'  => 6,
            'ANUAL'      => 12,
            default      => 1,
        };

        $precio = $this->convertirMontoDivisa((float) $plan->price, $plan->currency ?? 'PEN');

        return $this->calcularMontoEfectivo($precio * $multiplicador);
    }

    /**
     * Aplica descuentos (por ítem y global) al monto base.
     */
    protected function calcularMontoFinal(float $montoBase, float $descuentoItem = 0): float
    {
        return max(0, round($montoBase - $descuentoItem - (float) ($this->descuento_global ?? 0), 2));
    }

    /**
     * Recalcular todos los montos al cambiar divisa o tipo de comprobante.
     */
    protected function recalcularMontos(): void
    {
        foreach ($this->items as $placa => $item) {
            $plan = isset($item['plan_id']) ? Plan::find($item['plan_id']) : null;
            $montoBase     = $this->calcularMontoItem($plan, $item['periodo'] ?? 'MENSUAL');
            $descuentoItem = (float) ($item['descuento'] ?? 0);
            $this->items->put($placa, array_merge($item, [
                'monto_base' => $montoBase,
                'monto'      => $this->calcularMontoFinal($montoBase, $descuentoItem),
            ]));
        }
    }

    public function updatedDivisa(): void
    {
        $this->recalcularMontos();
    }

    public function updatedTipoPago(): void
    {
        $this->recalcularMontos();
    }

    public function updatedDescuentoGlobal(): void
    {
        $this->recalcularMontos();
    }

    /**
     * Recalcular fecha de vencimiento default cuando cambia la fecha de inicio.
     */
    public function updatedDefaultFechaInicio(): void
    {
        $this->default_fecha_vencimiento = $this->calcularFechaVencimiento(
            $this->default_fecha_inicio,
            $this->default_periodo
        );
    }

    /**
     * Recalcular fecha de vencimiento default cuando cambia el periodo.
     */
    public function updatedDefaultPeriodo(): void
    {
        $this->default_fecha_vencimiento = $this->calcularFechaVencimiento(
            $this->default_fecha_inicio,
            $this->default_periodo
        );
    }

    public function render()
    {
        return view('livewire.admin.cobros.edit');
    }

    public function updatedCliente($id)
    {
        $cliente = Clientes::where('id', $id)->first();
        $data = [];

        foreach ($cliente->vehiculos as $vehiculo) {
            if ($vehiculo->is_active) {
                $data[] = [
                    'id' => $vehiculo->id,
                    'text' => $vehiculo->placa,
                ];
            }
        }
    }

    public function agregarVehiculo()
    {
        if (empty($this->vehiculo_selected)) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR',
                mensaje: 'Debes seleccionar un vehículo',
            );
            return;
        }

        $vehiculo = Vehiculos::find($this->vehiculo_selected);

        $this->addVehiculo($vehiculo);
        $this->vehiculo_selected = '';
    }

    /**
     * Calcula la fecha de inicio a partir de la fecha de vencimiento y el periodo (inverso de calcularFechaVencimiento).
     */
    protected function calcularFechaInicio(string $fechaVencimiento, string $periodo): string
    {
        return match ($periodo) {
            'BIMENSUAL'  => Carbon::parse($fechaVencimiento)->subMonthsNoOverflow(2)->format('Y-m-d'),
            'TRIMESTRAL' => Carbon::parse($fechaVencimiento)->subMonthsNoOverflow(3)->format('Y-m-d'),
            'SEMESTRAL'  => Carbon::parse($fechaVencimiento)->subMonthsNoOverflow(6)->format('Y-m-d'),
            'ANUAL'      => Carbon::parse($fechaVencimiento)->subYearNoOverflow()->format('Y-m-d'),
            default      => Carbon::parse($fechaVencimiento)->subMonthNoOverflow()->format('Y-m-d'),
        };
    }

    /**
     * Calcula la fecha de vencimiento según fecha de inicio y periodo
     */
    protected function calcularFechaVencimiento(string $fechaInicio, string $periodo): string
    {
        return match ($periodo) {
            'MENSUAL'    => Carbon::parse($fechaInicio)->addMonthNoOverflow()->format('Y-m-d'),
            'BIMENSUAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(2)->format('Y-m-d'),
            'TRIMESTRAL' => Carbon::parse($fechaInicio)->addMonthsNoOverflow(3)->format('Y-m-d'),
            'SEMESTRAL'  => Carbon::parse($fechaInicio)->addMonthsNoOverflow(6)->format('Y-m-d'),
            'ANUAL'      => Carbon::parse($fechaInicio)->addYearNoOverflow()->format('Y-m-d'),
            default      => Carbon::parse($fechaInicio)->addMonthNoOverflow()->format('Y-m-d'),
        };
    }

    /**
     * Recalcular precio y fecha de vencimiento cuando cambia el plan o periodo
     */
    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) === 2) {
            $placa = $parts[0];
            $campo = $parts[1];

            if (in_array($campo, ['plan_id', 'periodo', 'descuento']) && $this->items->has($placa)) {
                $item          = $this->items->get($placa);
                $planId        = $item['plan_id'] ?? null;
                $periodo       = $item['periodo'] ?? 'MENSUAL';
                $plan          = $planId ? Plan::find($planId) : null;
                $descuentoItem = (float) ($item['descuento'] ?? 0);

                // Reusar monto_base si solo cambió el descuento (evita recalcular el plan)
                if ($campo === 'descuento' && isset($item['monto_base'])) {
                    $montoBase = (float) $item['monto_base'];
                } else {
                    $montoBase = $this->calcularMontoItem($plan, $periodo);
                }

                $updates = [
                    'monto_base' => $montoBase,
                    'monto'      => $this->calcularMontoFinal($montoBase, $descuentoItem),
                ];

                // Al cambiar el periodo, recalcular también la fecha de vencimiento
                if ($campo === 'periodo') {
                    $fechaInicio = $item['fecha_inicio'] ?? Carbon::now()->format('Y-m-d');
                    $updates['fecha_vencimiento'] = $this->calcularFechaVencimiento($fechaInicio, $periodo);
                }

                $this->items->put($placa, array_merge($item, $updates));
            }
        }
    }

    public function addVehiculo(Vehiculos $vehiculo)
    {
        if (!$vehiculo || !$vehiculo->placa) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR',
                mensaje: 'Vehículo no válido o sin placa',
            );
            return;
        }

        if (array_key_exists($vehiculo->placa, $this->items->all())) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR',
                mensaje: 'El vehículo ' . $vehiculo->placa . ' ya está agregado',
            );
        } else {
            // Validar que el vehículo no tenga un detalle de cobro activo en OTRO cobro distinto
            $yaRegistrado = \App\Models\DetalleCobros::where('vehiculo_id', $vehiculo->id)
                ->where('estado', 1)
                ->whereHas('cobro', fn($q) => $q->whereNull('deleted_at')->where('id', '!=', $this->cobro->id))
                ->exists();

            if ($yaRegistrado) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'VEHÍCULO YA REGISTRADO',
                    mensaje: 'El vehículo ' . $vehiculo->placa . ' ya tiene un cobro recurrente activo en otro contrato. No se permiten duplicados.',
                );
                return;
            }

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'VEHÍCULO AÑADIDO',
                mensaje: 'Añadiste ' . $vehiculo->placa,
            );

            $plan      = Plan::find($this->default_plan_id);
            $montoBase = $this->calcularMontoItem($plan, $this->default_periodo);
            $monto     = $this->calcularMontoFinal($montoBase);

            $this->items[$vehiculo->placa] = [
                'vehiculo_id'       => $vehiculo->id,
                'placa'             => $vehiculo->placa,
                'plan_id'           => $this->default_plan_id,
                'monto_base'        => $montoBase,
                'monto'             => $monto,
                'descuento'         => 0,
                'periodo'           => $this->default_periodo,
                'fecha_inicio'      => $this->default_fecha_inicio,
                'fecha_vencimiento' => $this->calcularFechaVencimiento($this->default_fecha_inicio, $this->default_periodo),
                'estado'            => 1,
            ];

            // Forzar la actualización de la colección
            $this->items = $this->items->collect();
        }
    }

    public function eliminarVehiculo($key)
    {
        // Verificar que la clave existe antes de intentar eliminarla
        if ($this->items->has($key)) {
            // Olvidar el elemento de la colección
            $this->items->forget($key);

            // Forzar la actualización de la colección
            $this->items = $this->items->collect();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'VEHÍCULO ELIMINADO',
                mensaje: 'Se eliminó el vehículo con placa ' . $key,
            );
        } else {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ELIMINAR',
                mensaje: 'No se encontró el vehículo con placa ' . $key,
            );
        }
    }

    public function save()
    {
        $requestCobros = new CobrosRequest();
        $datos = $this->validate($requestCobros->rules(), $requestCobros->messages());

        try {
            // Asegurar que tenemos el producto de servicio
            $productoServicio = Productos::getServicioCobro();
            if (!$productoServicio) {
                throw new \Exception('No se encontró un producto marcado como servicio de cobro');
            }

            $this->cobro->update([
                'clientes_id'      => $datos["clientes_id"],
                'comentario'       => $datos["comentario"],
                'divisa'           => $datos["divisa"],
                'nota'             => $datos["nota"],
                'tipo_pago'        => $datos["tipo_pago"],
                'producto_id'      => $productoServicio->id,
                'descuento_global' => $datos["descuento_global"] ?? 0,
            ]);

            $this->cobro->detalle()->delete();

            Cobros::createItems($this->cobro, $datos["items"], 'update');

            session()->flash('cobro-actualizado', 'Se actualizó con éxito el cobro');
            return redirect()->route('admin.cobros.index')->with('update', 'Se actualizó con éxito');
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ACTUALIZAR',
                mensaje: $th->getMessage(),
            );
        }
    }
}
