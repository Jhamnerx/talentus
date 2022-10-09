<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Http\Requests\CobrosRequest;
use App\Models\Clientes;
use App\Models\Cobros;
use Livewire\Component;
use Carbon\Carbon;

class Save extends Component
{


    public $cliente, $vehiculos_id, $comentario, $periodo = 'MENSUAL', $monto_unidad = 30;
    public $fecha_vencimiento,  $cantidad_unidades, $tipo_pago = 'RECIBO', $observacion;
    public $dataVehiculos = [];
    public $nota;

    public function mount()
    {

        $this->fecha_vencimiento = Carbon::now()->addDays(30)->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.cobros.save');
    }


    public function updatedCliente($id)
    {

        $cliente = Clientes::where('id', $id)->first();


        $data = [];
        foreach ($cliente->flotas as $flota) {
            foreach ($flota->vehiculos as $vehiculo) {

                if ($vehiculo->is_active) {
                    $data[] = [
                        'id' => $vehiculo->id,
                        'text' => $vehiculo->placa,
                    ];
                }
            }
        }

        $this->dispatchBrowserEvent('dataVehiculos', ['data' => $data]);
        $this->dataVehiculos = $data;
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

    public function GuardarCobro()
    {
        // dd($this->imei);
        $requestCobros = new CobrosRequest();

        $values = $this->validate($requestCobros->rules(), $requestCobros->messages());

        Cobros::create([
            'clientes_id' => $values["cliente"],
            'vehiculos_id' => $values["vehiculos_id"],
            'comentario' => $values["comentario"],
            'periodo' => $values["periodo"],
            'monto_unidad' => $values["monto_unidad"],
            'fecha_vencimiento' => $values["fecha_vencimiento"],
            'tipo_pago' => $values["tipo_pago"],
            'nota' => $values["nota"],
            'observacion' => $values["observacion"],
        ]);

        return redirect()->route('admin.cobros.index')->with('store', 'Se guardo con exito');
    }
}
