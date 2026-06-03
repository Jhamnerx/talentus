<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\FactilizaService;

class SaveQuick extends Component
{

    public $modalOpen = false;
    public $flotas;
    public $flotas_selected = [];
    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $clientes_id, $descripcion;
    public $errorConsultaPlaca = null;


    protected function rules()
    {
        return [
            'placa' => 'required|unique:vehiculos',
            "marca" => 'nullable',
            "modelo" => 'nullable',
            "tipo" => 'nullable',
            "year" => 'nullable',
            "color" => 'nullable',
            "motor" => 'nullable',
            "serie" => 'nullable',
            "clientes_id"  => "required",
            'descripcion' => 'nullable|string|max:500',
        ];
    }
    protected function messages()
    {
        return [
            'placa.required' => 'Ingresa una placa',
            'placa.unique' => 'La placa ingresada ya esta registrada',
            'clientes_id.required' => 'Por favor seleccione un cliente',
        ];
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.save-quick');
    }

    #[On('open-modal-add-vehiculo')]
    public function openModal()
    {
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function updatedClientesId($value)
    {

        $this->flotas = Clientes::find($value)->flotas()->get();
    }

    public function updated($attr)
    {
        $this->validateOnly($attr);
    }

    public function updatedPlaca()
    {
        $this->placa = strtoupper($this->placa);
    }
    public function save()
    {
        $this->validate();

        $vehiculo = Vehiculos::create([
            'placa'       => $this->placa,
            'marca'       => $this->marca,
            'modelo'      => $this->modelo,
            'tipo'        => $this->tipo,
            'year'        => $this->year,
            'color'       => $this->color,
            'motor'       => $this->motor,
            'serie'       => $this->serie,
            'clientes_id' => $this->clientes_id,
            'descripcion' => $this->descripcion,
        ]);


        if ($this->flotas_selected) {
            $vehiculo->flotas()->attach($this->flotas_selected);
        }

        $this->afterSave($vehiculo->placa);
    }

    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHICULO REGISTRADO',
            mensaje: 'Se registro correctamente el vehiculo ' . $placa,
        );

        $this->closeModal();
        $this->dispatch('update-table');
        $this->reset();
    }

    public function buscarPlaca()
    {
        $this->errorConsultaPlaca = null;

        if (empty($this->placa)) {
            $this->errorConsultaPlaca = 'Ingrese una placa para buscar';
            return;
        }

        try {
            // Limpiar la placa: quitar espacios, guiones y convertir a mayúsculas
            $placaLimpia = strtoupper(str_replace([' ', '-'], '', $this->placa));

            $factilizaService = app(FactilizaService::class);
            $resultado = $factilizaService->consultarPlaca($placaLimpia);

            if (($resultado['status'] ?? 0) == 200 && ($resultado['success'] ?? false)) {
                // Rellenar los campos con los datos obtenidos directamente
                //$this->placa = $resultado['placa'] ?? $this->placa;
                $this->marca = $resultado['marca'] ?? $this->marca;
                $this->modelo = $resultado['modelo'] ?? $this->modelo;
                $this->serie = $resultado['serie'] ?? $this->serie;
                $this->color = $resultado['color'] ?? $this->color;
                $this->motor = $resultado['motor'] ?? $this->motor;

                $this->dispatch(
                    'notify-toast',
                    icon: 'success',
                    title: 'PLACA ENCONTRADA',
                    mensaje: 'Datos del vehículo cargados correctamente'
                );
            } else {
                $this->errorConsultaPlaca = $resultado['message'] ?? 'No se encontraron datos para esta placa';
            }
        } catch (\Throwable $th) {
            $this->errorConsultaPlaca = 'Error al consultar la placa: ' . $th->getMessage();
        }
    }
}
