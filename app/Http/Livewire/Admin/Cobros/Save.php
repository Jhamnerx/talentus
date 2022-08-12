<?php

namespace App\Http\Livewire\Admin\Cobros;

use App\Models\Clientes;
use Livewire\Component;

class Save extends Component
{

    public $cliente, $vehiculos_id, $comentario, $periodo, $monto_unidad, $cantidad_unidades, $tipo_pago, $observacion, $fecha_vencimiento;
    public $dataVehiculos = [];
    public function render()
    {
        return view('livewire.admin.cobros.save');
    }


    public function updatedCliente($id){

        $cliente = Clientes::where('id',$id)->first();
        

        $data = [];

        if($cliente->flota){

            foreach ($cliente->flota->vehiculos as $vehiculo) {

                $data[] = [
                    'id' => $vehiculo->id,
                    'text' => $vehiculo->placa,
                ];
            }
            $this->dispatchBrowserEvent('dataVehiculos', ['data' => $data]);
            $this->dataVehiculos = $data;
        }



       
    }
}
