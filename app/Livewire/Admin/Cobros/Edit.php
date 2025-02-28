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
    public $fecha_inicio, $fecha_vencimiento,  $cantidad_unidades, $tipo_pago = 'RECIBO', $observacion, $divisa = 'PEN';
    public $nota;

    public $vehiculo_selected;

    public Collection $items;

    public Cobros $cobro;

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

        $this->items = collect($this->cobro->detalle->mapWithKeys(function ($detalle) {
            return [
                $detalle->vehiculo->placa => [
                    'vehiculo_id' => $detalle->vehiculo_id,
                    'placa' => $detalle->vehiculo->placa,
                    'plan' => $detalle->plan,
                    'fecha' => $detalle->fecha->format('Y-m-d'),
                    'estado' => $detalle->estado,
                ],
            ];
        }));
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

    public function updateCobro()
    {
        $requestCobros = new CobrosRequest();

        $this->validate($requestCobros->rules(), $requestCobros->messages());

        $this->cobro->update([
            'periodo' => $this->periodo,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'nota' => $this->nota,
            'tipo_pago' => $this->tipo_pago,
            'divisa' => $this->divisa,
            'monto_unidad' => $this->monto_unidad,

        ]);

        return redirect()->route('admin.cobros.index')->with('update', 'Se actualizo con exito');
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
            ]);

            $this->cobro->detalle()->delete();

            Cobros::createItems($this->cobro, $datos["items"], 'update');

            session()->flash('cobro-actualizado', 'Se Actualizo con exito el cobro');
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
}
