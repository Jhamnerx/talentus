<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Vehiculos;
use App\Services\GpsWoxService;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class SincronizarFlota extends Component
{
    use WireUiActions;

    public bool $modalOpen          = false;
    public int  $total              = 0;
    public int  $procesados         = 0;
    public bool $corriendo          = false;
    public bool $terminado          = false;
    public int  $lastId             = 0;
    public int  $noEncontradosCount = 0;

    public function render()
    {
        return view('livewire.admin.vehiculos.sincronizar-flota');
    }

    #[On('abrir-sincronizar-flota')]
    public function abrir(): void
    {
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount']);
        $this->total     = Vehiculos::count();
        $this->modalOpen = true;
        $this->dispatch('reset-sync-errors');
    }

    public function iniciar(): void
    {
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount']);
        $this->total     = Vehiculos::count();
        $this->corriendo = true;
        $this->dispatch('reset-sync-errors');
    }

    public function procesarSiguiente(): array
    {
        $vehiculo = Vehiculos::where('id', '>', $this->lastId)
            ->orderBy('id')
            ->first();

        if (! $vehiculo) {
            $this->terminado = true;
            $this->corriendo = false;
            return ['terminado' => true];
        }

        $this->lastId = $vehiculo->id;
        $this->procesados++;

        $resultado = app(GpsWoxService::class)->sincronizarVehiculoDesdePlataforma($vehiculo);

        $error = null;
        if ($resultado['status'] !== 1) {
            $this->noEncontradosCount++;
            $error = [
                'placa'   => $vehiculo->placa,
                'message' => $resultado['message'] ?? 'No encontrado en plataforma',
            ];
        }

        $terminado = $this->procesados >= $this->total;

        if ($terminado) {
            $this->terminado = true;
            $this->corriendo = false;
        }

        return ['terminado' => $terminado, 'error' => $error];
    }

    public function cancelar(): void
    {
        $this->corriendo = false;
        $this->terminado = true;
    }

    public function cerrar(): void
    {
        $this->modalOpen = false;
        $this->reset(['procesados', 'corriendo', 'terminado', 'lastId', 'noEncontradosCount', 'total']);
    }
}
