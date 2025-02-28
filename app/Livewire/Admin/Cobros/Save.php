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

class Save extends Component
{


    public $clientes_id, $comentario, $periodo = 'MENSUAL', $monto_unidad = 30;
    public $fecha_inicio, $fecha_vencimiento,  $cantidad_unidades, $tipo_pago = 'RECIBO', $observacion, $divisa = 'PEN';

    public $nota;

    public $vehiculo_selected;


    public Collection $items;

    public function mount()
    {
        $this->items = collect();
        $this->fecha_inicio = Carbon::now()->format('Y-m-d');
        $this->fecha_vencimiento = Carbon::now()->addDays(30)->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.cobros.save');
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

    public function updated($label)
    {
        $requestCobros = new CobrosRequest();
        $this->validateOnly($label, $requestCobros->rules(), $requestCobros->messages());
    }

    public function save()
    {
        $requestCobros = new CobrosRequest();

        $datos = $this->validate($requestCobros->rules(), $requestCobros->messages());

        $this->cantidad_unidades = $this->items->count();


        try {
            $cobro = Cobros::create([
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
            ]);

            Cobros::createItems($cobro, $datos["items"], 'create');

            // $this->dispatch(
            //     'notify-toast',
            //     icon: 'success',
            //     title: 'COBRO REGISTRADO',
            //     mensaje: 'Se registro con existo el cobro',
            // );
            session()->flash('cobro-registrado', 'Se registro con exito el cobro');
            $this->redirectRoute('admin.cobros.index');
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ACTUALIZAR',
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
                title: 'ERROR EL AÑADIR',
                mensaje: 'El vehiculo ' . $vehiculo->placa . ' ya esta agregado',
            );
        } else {

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'VEHICULO AÑADIDO',
                mensaje: 'Añadiste ' . $vehiculo->placa,
            );

            $this->items[$vehiculo->placa] = [
                'vehiculo_id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'plan' => 30,
                'fecha' => $this->fecha_vencimiento,
                'estado' => 1,
            ];
        }
    }
    public function eliminarVehiculo($key)
    {
        unset($this->items[$key]);
        $this->items;
    }
}
