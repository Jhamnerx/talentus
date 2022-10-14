<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Http\Requests\CobrosRequest;
use App\Models\Clientes;
use Carbon\Carbon;
use Livewire\Component;
use Symfony\Component\Mailer\Transport\Dsn;

class Edit extends Component
{
    public $cliente, $vehiculos_id, $comentario, $periodo, $monto_unidad;
    public $fecha_vencimiento,  $cantidad_unidades, $tipo_pago, $observacion;
    public $dataVehiculos = [];
    public $nota;
    public $cobro;

    public function mount()
    {
        $this->fecha_vencimiento = $this->cobro->fecha_vencimiento->format('Y-m-d');
        $this->periodo = $this->cobro->periodo;
        $this->tipo_pago = $this->cobro->tipo_pago;
        $this->monto_unidad = $this->cobro->monto_unidad;
        $this->nota = $this->cobro->nota;
        $this->cliente = $this->cobro->clientes_id;
        $this->vehiculos_id = $this->cobro->vehiculos_id;
        $this->dataVehiculos = $this->LoadDataVehiculos($this->cobro->clientes_id);
    }

    public function render()
    {
        return view('livewire.admin.cobros.edit');
    }



    public function LoadDataVehiculos($id)
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

        return $data;
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

        $values = $this->validate($requestCobros->rules(), $requestCobros->messages());


        $this->cobro->update([
            'periodo' => $this->periodo,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'nota' => $this->nota,
            'tipo_pago' => $this->tipo_pago,
            'monto_unidad' => $this->monto_unidad,

        ]);

        return redirect()->route('admin.cobros.index')->with('update', 'Se actualizo con exito');
    }
}
