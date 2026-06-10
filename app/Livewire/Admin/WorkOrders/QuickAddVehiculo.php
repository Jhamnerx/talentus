<?php

declare(strict_types=1);

namespace App\Livewire\Admin\WorkOrders;

use App\Models\Vehiculos;
use App\Services\FactilizaService;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class QuickAddVehiculo extends Component
{
    use WireUiActions;

    public bool    $modalOpen = false;

    public string  $placa       = '';
    public ?int    $clientes_id = null;
    public string  $marca       = '';
    public string  $modelo      = '';
    public string  $tipo        = '';
    public string  $year        = '';
    public string  $color       = '';
    public string  $motor       = '';
    public string  $serie       = '';
    public string  $descripcion = '';

    public ?string $errorConsultaPlaca = null;

    protected function rules(): array
    {
        return [
            'placa'       => ['required', 'regex:/^\S+$/', 'unique:vehiculos,placa', 'max:20'],
            'clientes_id' => ['required', 'exists:clientes,id'],
            'marca'       => ['nullable', 'string', 'max:100'],
            'modelo'      => ['nullable', 'string', 'max:100'],
            'tipo'        => ['nullable', 'string', 'max:100'],
            'year'        => ['nullable', 'string', 'max:4'],
            'color'       => ['nullable', 'string', 'max:50'],
            'motor'       => ['nullable', 'string', 'max:100'],
            'serie'       => ['nullable', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected function messages(): array
    {
        return [
            'placa.required'       => 'La placa es requerida.',
            'placa.regex'          => 'La placa no debe contener espacios en blanco.',
            'placa.unique'         => 'Esta placa ya está registrada en el sistema.',
            'placa.max'            => 'La placa no puede superar 20 caracteres.',
            'clientes_id.required' => 'Debe seleccionar un cliente.',
        ];
    }

    public function render()
    {
        return view('livewire.admin.work-orders.quick-add-vehiculo');
    }

    #[On('open-vehiculo-rapido')]
    public function openModal(string $placa = ''): void
    {
        $this->reset(['placa', 'clientes_id', 'marca', 'modelo', 'tipo', 'year', 'color', 'motor', 'serie', 'descripcion', 'errorConsultaPlaca']);
        $this->resetValidation();

        // Pre-rellenar con la placa buscada (sin espacios ni guiones)
        $this->placa = strtoupper(str_replace([' ', '-'], '', $placa));

        $this->modalOpen = true;
    }

    public function closeModal(): void
    {
        $this->reset(['placa', 'clientes_id', 'marca', 'modelo', 'tipo', 'year', 'color', 'motor', 'serie', 'descripcion', 'errorConsultaPlaca']);
        $this->resetValidation();
        $this->modalOpen = false;
    }

    public function updatedPlaca(): void
    {
        // Eliminar espacios en tiempo real y convertir a mayúsculas
        $this->placa = strtoupper(str_replace(' ', '', $this->placa));
        $this->errorConsultaPlaca = null;
    }

    public function buscarPlaca(): void
    {
        $this->errorConsultaPlaca = null;

        $placaLimpia = strtoupper(str_replace([' ', '-'], '', $this->placa));

        if (empty($placaLimpia)) {
            $this->errorConsultaPlaca = 'Ingrese una placa para consultar.';
            return;
        }

        try {
            $resultado = app(FactilizaService::class)->consultarPlaca($placaLimpia);

            if (($resultado['status'] ?? 0) == 200 && ($resultado['success'] ?? false)) {
                $this->marca  = $resultado['marca']  ?? $this->marca;
                $this->modelo = $resultado['modelo'] ?? $this->modelo;
                $this->color  = $resultado['color']  ?? $this->color;
                $this->motor  = $resultado['motor']  ?? $this->motor;
                $this->serie  = $resultado['serie']  ?? $this->serie;

                $this->notification()->success(
                    title: 'Datos encontrados',
                    description: 'Información del vehículo cargada desde el registro vehicular.'
                );
            } else {
                $this->errorConsultaPlaca = $resultado['message'] ?? 'No se encontraron datos para esta placa.';
            }
        } catch (\Throwable $th) {
            $this->errorConsultaPlaca = 'Error al consultar la placa: ' . $th->getMessage();
        }
    }

    public function save(): void
    {
        $this->validate();

        $vehiculo = Vehiculos::create([
            'placa'       => $this->placa,
            'clientes_id' => $this->clientes_id,
            'marca'       => $this->marca       ?: null,
            'modelo'      => $this->modelo      ?: null,
            'tipo'        => $this->tipo        ?: null,
            'year'        => $this->year        ?: null,
            'color'       => $this->color       ?: null,
            'motor'       => $this->motor       ?: null,
            'serie'       => $this->serie       ?: null,
            'descripcion' => $this->descripcion ?: null,
        ]);

        // Notificar al CreateModal para que seleccione automáticamente el vehículo
        $this->dispatch('vehiculo-quick-added', id: $vehiculo->id, placa: $vehiculo->placa);

        $this->closeModal();

        $this->notification()->success(
            title: 'Vehículo registrado',
            description: "Placa {$vehiculo->placa} registrada. Seleccionada automáticamente en la orden."
        );
    }
}
