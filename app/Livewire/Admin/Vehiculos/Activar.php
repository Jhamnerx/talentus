<?php

namespace App\Livewire\Admin\Vehiculos;

use Livewire\Component;
use App\Models\Vehiculos;
use App\Models\DetalleCobros;
use App\Models\Lineas;
use App\Models\Dispositivos;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;

class Activar extends Component
{
    use WireUiActions;

    public ?Vehiculos $vehiculo = null;
    public bool $modalActivar = false;
    public bool $tieneDetalleCobro = false;

    // Línea / SIM
    public ?string $numero = null;
    public ?string $sim_card = null;
    public ?string $operador = null;
    public ?int $sim_card_id = null;
    public ?string $numeroOcupadoPorPlaca = null; // placa del vehículo que ya tiene ese número

    // Dispositivos
    public string $dispositivo_imei = '';
    public array $dispositivos = [];
    public ?int $dispositivo_principal = null;

    #[On('open-modal-activar-vehiculo')]
    public function openModal(Vehiculos $vehiculo): void
    {
        $this->vehiculo = $vehiculo;
        $this->tieneDetalleCobro = DetalleCobros::where('vehiculo_id', $vehiculo->id)->exists();

        // Pre-cargar última línea conocida
        $this->numero = $vehiculo->old_numero;
        $this->sim_card = $vehiculo->old_sim_card;
        $this->sim_card_id = null;
        $this->operador = null;
        $this->numeroOcupadoPorPlaca = null;

        if ($this->numero) {
            $linea = Lineas::where('numero', $this->numero)->first();
            if ($linea) {
                $this->operador = $linea->operador;
                $this->sim_card_id = $linea->sim_card?->id;
                $this->sim_card = $linea->sim_card?->sim_card ?? $this->sim_card;
            }
        }

        // Pre-cargar dispositivos actualmente instalados en el vehículo
        $this->dispositivo_imei = '';
        $this->dispositivo_principal = null;
        $dispositivosInstalados = $vehiculo->dispositivos()
            ->whereNull('fecha_desinstalacion')
            ->with('dispositivo.modelo')
            ->get();

        $this->dispositivos = [];
        foreach ($dispositivosInstalados as $vd) {
            if (!$vd->dispositivo) continue;
            $this->dispositivos[] = [
                'imei'   => $vd->imei,
                'modelo' => $vd->dispositivo->modelo->modelo ?? 'Sin modelo',
                'id'     => $vd->dispositivo->id,
            ];
            if ($vd->is_principal) {
                $this->dispositivo_principal = array_key_last($this->dispositivos);
            }
        }

        if ($this->dispositivo_principal === null && count($this->dispositivos) > 0) {
            $this->dispositivo_principal = 0;
        }

        $this->modalActivar = true;
    }

    public function updatedNumero(?string $numero): void
    {
        $this->numeroOcupadoPorPlaca = null;

        if ($numero) {
            // Verificar que el número no esté asignado a otro vehículo activo
            $vehiculoOcupado = Vehiculos::where('numero', $numero)
                ->where('id', '!=', $this->vehiculo?->id)
                ->first();

            if ($vehiculoOcupado) {
                $this->numeroOcupadoPorPlaca = $vehiculoOcupado->placa;
                $this->operador   = null;
                $this->sim_card_id = null;
                $this->sim_card   = null;
                return;
            }

            $linea = Lineas::where('numero', $numero)->first();
            if (!$linea) return;
            $this->operador   = $linea->operador;
            $this->sim_card_id = $linea->sim_card?->id;
            $this->sim_card   = $linea->sim_card?->sim_card;
        } else {
            $this->operador   = null;
            $this->sim_card_id = null;
            $this->sim_card   = null;
        }
    }

    public function updatedDispositivoImei(?string $imei): void
    {
        if ($imei) {
            $this->agregarDispositivo($imei);
            $this->dispositivo_imei = '';
        }
    }

    public function agregarDispositivo(string $imei): void
    {
        $dispositivo = Dispositivos::where('imei', $imei)->first();

        if (!$dispositivo) {
            $this->notification()->send(['icon' => 'error', 'title' => 'ERROR', 'description' => 'Dispositivo con IMEI ' . $imei . ' no encontrado.']);
            return;
        }

        foreach ($this->dispositivos as $d) {
            if ($d['imei'] === $imei) return; // ya existe
        }

        [$disponible, $vehiculoAsignado] = Dispositivos::find($dispositivo->id)
            ? \App\Models\VehiculoDispositivos::dispositivoDisponible($dispositivo->id, $this->vehiculo->id)
            : [true, null];

        if (!$disponible) {
            $this->notification()->send(['icon' => 'error', 'title' => 'DISPOSITIVO NO DISPONIBLE', 'description' => 'El dispositivo ya está asignado al vehículo ' . ($vehiculoAsignado?->placa ?? '')]);
            return;
        }

        $this->dispositivos[] = [
            'imei'   => $imei,
            'modelo' => $dispositivo->modelo->modelo ?? 'Sin modelo',
            'id'     => $dispositivo->id,
        ];

        if (count($this->dispositivos) === 1) {
            $this->dispositivo_principal = 0;
        }
    }

    public function quitarDispositivo(int $index): void
    {
        if ($this->dispositivo_principal === $index) {
            $this->dispositivo_principal = null;
        } elseif ($this->dispositivo_principal > $index) {
            $this->dispositivo_principal--;
        }
        array_splice($this->dispositivos, $index, 1);
    }

    public function marcarComoPrincipal(int $index): void
    {
        $this->dispositivo_principal = $index;
    }

    public function activar(): void
    {
        // Validar que el número no esté ocupado por otro vehículo
        if ($this->numero) {
            $vehiculoOcupado = Vehiculos::where('numero', $this->numero)
                ->where('id', '!=', $this->vehiculo->id)
                ->first();

            if ($vehiculoOcupado) {
                $this->numeroOcupadoPorPlaca = $vehiculoOcupado->placa;
                $this->notification()->send(['icon' => 'error', 'title' => 'LÍNEA NO DISPONIBLE', 'description' => 'El número ya está asignado a ' . $vehiculoOcupado->placa . '. Suspéndelo primero.']);
                return;
            }
        }

        $this->vehiculo->setAttribute('numero', $this->numero);
        $this->vehiculo->setAttribute('sim_card_id', $this->sim_card_id);
        $this->vehiculo->setAttribute('estado', 1);
        $this->vehiculo->save();

        // Sincronizar dispositivos
        if (count($this->dispositivos) > 0) {
            $this->vehiculo->sincronizarDispositivos($this->dispositivos, $this->dispositivo_principal);
        }

        // Reactivar DetalleCobros inactivos
        DetalleCobros::where('vehiculo_id', $this->vehiculo->id)
            ->where('estado', false)
            ->update(['estado' => true]);

        // Reactivar suscripción cancelada
        $subscription = $this->vehiculo->planSubscription('gps-tracking');
        if ($subscription && $subscription->canceled_at) {
            $subscription->forceFill(['canceled_at' => null])->save();
        }

        $this->modalActivar = false;

        $this->notification()->send(['icon' => 'success', 'title' => 'VEHÍCULO ACTIVADO', 'description' => 'Se reactivó el vehículo: ' . $this->vehiculo->placa]);

        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.activar');
    }
}
