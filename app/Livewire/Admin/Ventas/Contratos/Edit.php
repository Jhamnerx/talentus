<?php

namespace App\Livewire\Admin\Ventas\Contratos;


use Livewire\Component;
use App\Models\Contratos;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Http\Requests\ContratosRequest;

class Edit extends Component
{
    public Contratos $contrato;

    public $clientes_id, $ciudades_id = '01', $fondo = false, $sello = false, $fecha;

    public $panelVehiculosOpen = false;

    public Collection $items;


    public function mount(Contratos $contrato)
    {
        $this->items = collect();
        $this->contrato = $contrato;
        $this->clientes_id = $contrato->clientes_id;
        $this->ciudades_id = $contrato->ciudades_id;
        $this->fondo = $contrato->fondo;
        $this->sello = $contrato->sello;
        $this->fecha = $contrato->fecha;

        foreach ($this->contrato->detalle as $detalle) {
            $this->items[$detalle->vehiculos->placa] = [
                'vehiculos_id' => $detalle->vehiculos->id,
                'placa' => $detalle->vehiculos->placa,
                'plan' => $detalle->plan
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.edit');
    }

    public function openPanelVehiculos()
    {
        $this->panelVehiculosOpen = true;
    }

    public function updatedContratoClientesId($cliente)
    {

        $this->dispatch('openPanelVehiculos', ['cliente' => $cliente, 'vehiculos' => $cliente->vehiculos]);
    }

    public function eliminarVehiculo($key)
    {
        unset($this->items[$key]);
        $this->items;
    }

    #[On('add-vehiculo')]
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
                tittle: 'VEHICULO AÑADIDO',
                mensaje: 'Añadiste ' . $vehiculo->placa,
            );

            $this->items[$vehiculo->placa] = [
                'vehiculos_id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'plan' => 30
            ];
        }
    }


    public function updated($field)
    {
        $request = new ContratosRequest();

        $validate = $this->validateOnly($field, $request->rules(), $request->messages());
    }

    public function save()
    {

        $request = new ContratosRequest();

        $datos = $this->validate($request->rules(), $request->messages());

        $this->contrato->update($datos);

        $this->contrato->detalle()->delete();

        Contratos::createItems($this->contrato, $this->items);

        session()->flash('update', 'El contrato se actualizo con exito');
        $this->redirectRoute('admin.ventas.contratos.index');
    }

    public function OpenModalCliente($busqueda)
    {
        $this->dispatch('open-modal-save-cliente', busqueda: $busqueda);
    }
}
