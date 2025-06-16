<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Cobros;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Http\Requests\CobrosRequest;
use Symfony\Component\Mailer\Transport\Dsn;

class Edit extends Component
{
    public $clientes_id, $comentario, $periodo = 'MENSUAL', $monto_unidad = 30;
    public $fecha_inicio, $fecha_vencimiento, $cantidad_unidades, $tipo_pago = 'RECIBO', $observacion, $divisa = 'PEN';
    public $nota;

    public $vehiculo_selected;

    public Collection $items;

    public Cobros $cobro;
    public $producto_id;

    public function mount(Cobros $cobro)
    {
        $this->fecha_vencimiento = $this->cobro->fecha_vencimiento->format('Y-m-d');
        $this->fecha_inicio = $this->cobro->fecha_inicio ? $this->cobro->fecha_inicio->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $this->periodo = $this->cobro->periodo;
        $this->tipo_pago = $this->cobro->tipo_pago;
        $this->divisa = $this->cobro->divisa;
        $this->monto_unidad = $this->cobro->monto_unidad;
        $this->nota = $this->cobro->nota;
        $this->clientes_id = $this->cobro->clientes_id;
        $this->observacion = $this->cobro->observacion;
        $this->comentario = $this->cobro->comentario;
        $this->cobro = $cobro;
        $this->producto_id = $cobro->producto_id;

        // Inicializar la colección de items con verificación de vehículo
        $this->items = collect();
        foreach ($this->cobro->detalle as $detalle) {
            if ($detalle->vehiculo) {
                $this->items[$detalle->vehiculo->placa] = [
                    'vehiculo_id' => $detalle->vehiculo_id,
                    'placa' => $detalle->vehiculo->placa,
                    'plan' => $detalle->plan,
                    'fecha' => $detalle->fecha->format('Y-m-d'),
                    'estado' => $detalle->estado,
                ];
            }
        }
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
            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'VEHÍCULO AÑADIDO',
                mensaje: 'Añadiste ' . $vehiculo->placa,
            );

            // Asegurarse de que todos los campos necesarios estén presentes
            $this->items[$vehiculo->placa] = [
                'vehiculo_id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'plan' => $this->monto_unidad ?? 30,
                'fecha' => $this->fecha_vencimiento ?? Carbon::now()->addDay(30)->format('Y-m-d'),
                'estado' => 1,
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

    public function updatedPeriodo($periodo)
    {
        switch ($periodo) {
            case 'MENSUAL':
                $this->fecha_vencimiento = Carbon::now()->addDay(30)->format('Y-m-d');
                break;
            case 'BIMENSUAL':
                $this->fecha_vencimiento = Carbon::now()->addMonth(2)->format('Y-m-d');
                break;
            case 'TRIMESTRAL':
                $this->fecha_vencimiento = Carbon::now()->addMonth(3)->format('Y-m-d');
                break;
            case 'SEMESTRAL':
                $this->fecha_vencimiento = Carbon::now()->addMonth(6)->format('Y-m-d');
                break;
            case 'ANUAL':
                $this->fecha_vencimiento = Carbon::now()->addYear(1)->format('Y-m-d');
                break;
        }
    }

    public function save()
    {
        $requestCobros = new CobrosRequest();
        $datos = $this->validate($requestCobros->rules(), $requestCobros->messages());

        $this->cantidad_unidades = $this->items->count();

        try {
            $this->cobro->update([
                'clientes_id' => $datos["clientes_id"],
                'comentario' => $datos["comentario"],
                'periodo' => $datos["periodo"],
                'monto_unidad' => $datos["monto_unidad"],
                'divisa' => $datos["divisa"],
                'fecha_vencimiento' => $datos["fecha_vencimiento"],
                'tipo_pago' => $datos["tipo_pago"],
                'fecha_inicio' => $datos["fecha_inicio"],
                'nota' => $datos["nota"],
                'observacion' => $datos["observacion"],
                'producto_id' => $datos["producto_id"],
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
