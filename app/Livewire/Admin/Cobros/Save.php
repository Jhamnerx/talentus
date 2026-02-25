<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Cobros;
use Livewire\Component;
use App\Models\Vehiculos;
use App\Models\Productos;
use Illuminate\Support\Collection;
use App\Http\Requests\CobrosRequest;

class Save extends Component
{
    public $clientes_id, $comentario;
    public $nota;
    public $vehiculo_selected;
    public Collection $items;
    public $producto_id;
    public $divisa = 'PEN';
    public Collection $planes;

    // Valores por defecto para cada vehículo que se agregue
    public $default_periodo = 'MENSUAL';
    public $default_plan_id = null;
    public $default_fecha_inicio;
    public $default_fecha_vencimiento;

    public function mount()
    {
        $this->items = collect();
        $this->planes = collect();
        $this->default_fecha_inicio = Carbon::now()->format('Y-m-d');
        $this->default_fecha_vencimiento = Carbon::now()->addDays(30)->format('Y-m-d');
        $this->loadPlanes();

        // Obtener automáticamente el producto de servicio de cobro
        $productoServicio = Productos::getServicioCobro();

        if (!$productoServicio) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'PRODUCTO NO CONFIGURADO',
                mensaje: 'No se encontró un producto marcado como "Servicio de Cobro". Por favor, configura un producto en el módulo de Productos.'
            );
        }

        $this->producto_id = $productoServicio?->id;
    }

    public function loadPlanes()
    {
        $this->planes = Plan::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Seleccionar el primer plan por defecto si existe
        if ($this->planes->isNotEmpty() && !$this->default_plan_id) {
            $this->default_plan_id = $this->planes->first()->id;
        }
    }

    public function render()
    {
        return view('livewire.admin.cobros.save');
    }

    public function updated($label)
    {
        $requestCobros = new CobrosRequest();
        $this->validateOnly($label, $requestCobros->rules(), $requestCobros->messages());
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

            $cobro = Cobros::create([
                'clientes_id' => $datos["clientes_id"],
                'comentario' => $datos["comentario"],
                'divisa' => $datos["divisa"],
                'nota' => $datos["nota"],
                'producto_id' => $productoServicio->id,
            ]);

            Cobros::createItems($cobro, $datos["items"], 'create');

            session()->flash('cobro-registrado', 'Se registró con éxito el cobro');
            $this->redirectRoute('admin.cobros.index');
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL GUARDAR',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function agregarVehiculo()
    {
        if (empty($this->vehiculo_selected)) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR EL AÑADIR',
                mensaje: 'Debes seleccionar un vehiculo',
            );
            return;
        }

        $vehiculo = Vehiculos::find($this->vehiculo_selected);

        $this->addVehiculo($vehiculo);
        $this->vehiculo_selected = '';
    }

    public function addVehiculo(Vehiculos $vehiculo)
    {
        if (array_key_exists($vehiculo->placa, $this->items->all())) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL AÑADIR',
                mensaje: 'El vehículo ' . $vehiculo->placa . ' ya está agregado',
            );
        } else {
            // Validar que el vehículo no tenga ya un detalle de cobro activo
            $yaRegistrado = \App\Models\DetalleCobros::where('vehiculos_id', $vehiculo->id)
                ->where('estado', 1)
                ->whereHas('cobro', fn($q) => $q->whereNull('deleted_at'))
                ->exists();

            if ($yaRegistrado) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'VEHÍCULO YA REGISTRADO',
                    mensaje: 'El vehículo ' . $vehiculo->placa . ' ya tiene un cobro recurrente activo. No se permiten duplicados.',
                );
                return;
            }

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'VEHÍCULO AÑADIDO',
                mensaje: 'Añadiste ' . $vehiculo->placa,
            );

            $monto = Plan::find($this->default_plan_id)?->price ?? 0;

            $this->items[$vehiculo->placa] = [
                'vehiculo_id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'plan_id' => $this->default_plan_id,
                'monto' => $monto,
                'periodo' => $this->default_periodo,
                'fecha_inicio' => $this->default_fecha_inicio,
                'fecha_vencimiento' => $this->default_fecha_vencimiento,
                'estado' => 1,
            ];
        }
    }

    /**
     * Calcula la fecha de vencimiento según fecha de inicio y periodo
     */
    protected function calcularFechaVencimiento(string $fechaInicio, string $periodo): string
    {
        return match ($periodo) {
            'MENSUAL'    => Carbon::parse($fechaInicio)->addMonth()->format('Y-m-d'),
            'BIMENSUAL'  => Carbon::parse($fechaInicio)->addMonths(2)->format('Y-m-d'),
            'TRIMESTRAL' => Carbon::parse($fechaInicio)->addMonths(3)->format('Y-m-d'),
            'SEMESTRAL'  => Carbon::parse($fechaInicio)->addMonths(6)->format('Y-m-d'),
            'ANUAL'      => Carbon::parse($fechaInicio)->addYear()->format('Y-m-d'),
            default      => Carbon::parse($fechaInicio)->addMonth()->format('Y-m-d'),
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

            if (in_array($campo, ['plan_id', 'periodo']) && $this->items->has($placa)) {
                $item    = $this->items->get($placa);
                $planId  = $item['plan_id'] ?? null;
                $periodo = $item['periodo'] ?? 'MENSUAL';
                $plan    = $planId ? Plan::find($planId) : null;

                $multiplicador = match ($periodo) {
                    'BIMENSUAL'  => 2,
                    'TRIMESTRAL' => 3,
                    'SEMESTRAL'  => 6,
                    'ANUAL'      => 12,
                    default      => 1,
                };

                $updates = ['monto' => ($plan?->price ?? 0) * $multiplicador];

                // Al cambiar el periodo, recalcular también la fecha de vencimiento
                if ($campo === 'periodo') {
                    $fechaInicio = $item['fecha_inicio'] ?? Carbon::now()->format('Y-m-d');
                    $updates['fecha_vencimiento'] = $this->calcularFechaVencimiento($fechaInicio, $periodo);
                }

                $this->items->put($placa, array_merge($item, $updates));
            }
        }
    }
    public function eliminarVehiculo($key)
    {
        unset($this->items[$key]);
        $this->items;
    }
}
