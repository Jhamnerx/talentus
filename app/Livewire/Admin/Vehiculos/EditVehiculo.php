<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Lineas;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use App\Models\Dispositivos;
use App\Http\Requests\VehiculosRequest;
use App\Models\Sector;
use App\Services\FactilizaService;
use App\Services\GpsWoxService;

class EditVehiculo extends Component
{
    public $flotas;

    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $dispositivo_imei, $modelo_gps,
        $sim_card_id, $numero, $sim_card, $operador, $clientes_id, $dispositivos_id, $descripcion;

    public $errorConsultaPlaca = null;

    // Nuevas propiedades para múltiples dispositivos
    public $dispositivos = [];
    public $dispositivo_principal = null;

    public $modalEdit = false;

    public $flotas_selected = [];
    public array $sectores_selected = [];

    public Vehiculos $vehiculo;

    public function render()
    {
        $sectores = Sector::activos()->get(['id', 'nombre']);
        return view('livewire.admin.vehiculos.edit-vehiculo', compact('sectores'));
    }


    #[On('open-modal-edit')]
    public function openModalEdit(Vehiculos $vehiculo)
    {
        $this->modalEdit = true;
        $this->vehiculo = $vehiculo;
        $this->placa = $vehiculo->placa;
        $this->marca = $vehiculo->marca;
        $this->modelo = $vehiculo->modelo;
        $this->tipo = $vehiculo->tipo;
        $this->year = $vehiculo->year;
        $this->color = $vehiculo->color;
        $this->motor = $vehiculo->motor;
        $this->serie = $vehiculo->serie;
        $this->dispositivo_imei = ''; // campo de entrada temporal, no viene de BD
        $this->modelo_gps = $vehiculo->dispositivoPrincipal ? $vehiculo->dispositivoPrincipal->dispositivo->modelo->modelo : null;
        $this->sim_card_id = $vehiculo->sim_card_id;
        $this->numero = $vehiculo->numero;
        $this->sim_card = $vehiculo->sim_card ? $vehiculo->sim_card->sim_card : null;
        $this->operador = $vehiculo->sim_card ? $vehiculo->sim_card->operador?->name : null;
        $this->clientes_id = $vehiculo->clientes_id;
        $this->dispositivos_id = $vehiculo->dispositivos_id;
        $this->descripcion = $vehiculo->descripcion;
        $this->sectores_selected = $vehiculo->sectores->pluck('id')->map(fn($id) => (string) $id)->toArray();

        // Cargar los dispositivos asociados al vehículo
        $this->cargarDispositivos();
    }

    private function cargarDispositivos()
    {
        $this->dispositivos = [];
        $this->dispositivo_principal = null;

        // Obtener los dispositivos asociados al vehículo
        $dispositivos_vehiculo = \App\Models\VehiculoDispositivos::where('vehiculo_id', $this->vehiculo->id)
            ->whereNull('fecha_desinstalacion')
            ->get();

        foreach ($dispositivos_vehiculo as $index => $disp) {
            $dispositivo = Dispositivos::find($disp->dispositivo_id);
            if (!$dispositivo) continue;

            $this->dispositivos[] = [
                'imei' => $disp->imei ?: $dispositivo->imei,
                'modelo' => $dispositivo->modelo->modelo ?? 'Sin modelo',
                'id' => $dispositivo->id
            ];

            // Marcar el principal
            if ($disp->is_principal) {
                $this->dispositivo_principal = count($this->dispositivos) - 1;
            }
        }

        if ($this->dispositivo_principal !== null && isset($this->dispositivos[$this->dispositivo_principal])) {
            $this->dispositivos_id = $this->dispositivos[$this->dispositivo_principal]['id'];
        }
    }
    public function save()
    {
        $this->dispositivos_id = isset($this->dispositivos[$this->dispositivo_principal]['id'])
            ? $this->dispositivos[$this->dispositivo_principal]['id']
            : null;

        $requestVehiculo = new VehiculosRequest();
        $data = $this->validate($requestVehiculo->rules($this->dispositivos_id, $this->numero, $this->vehiculo), $requestVehiculo->messages());

        try {
            $this->vehiculo->update($data);
            $changes = $this->vehiculo->getChanges();
            $this->registerFlotas($this->vehiculo);
            $this->registerSectores($this->vehiculo);

            // Actualizar los dispositivos
            $this->registerDispositivos($this->vehiculo);

            $this->dispatch('update-table');

            if (array_key_exists('numero', $changes)) {
                $this->closeModal();
                $this->dispatch('updated-numero', placa: $data["placa"]);
                $this->reset();
            } else {
                $this->afterSave($data["placa"]);
            }
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }    // Función para registrar los dispositivos utilizando el método sincronizarDispositivos del modelo Vehiculos
    private function registerDispositivos(Vehiculos $vehiculo)
    {
        // Utilizar el nuevo método del modelo Vehiculos para sincronizar dispositivos
        [$success, $mensaje] = $vehiculo->sincronizarDispositivos($this->dispositivos, $this->dispositivo_principal);

        if (!$success) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL SINCRONIZAR DISPOSITIVOS',
                mensaje: $mensaje
            );
        }
    }

    // Método para agregar un dispositivo a la lista
    public function agregarDispositivo($imei)
    {
        $dispositivo = Dispositivos::where('imei', $imei)->first();

        if (!$dispositivo) {
            // No existe el dispositivo, podemos mostrar un error o pedir crear uno
            $this->dispatch('add-imei-modal', imei: $imei);
            return;
        }

        // Verificar si el dispositivo ya está en la lista
        foreach ($this->dispositivos as $disp) {
            if ($disp['imei'] == $imei) {
                // Ya existe, no hacer nada o mostrar mensaje
                return;
            }
        }

        // Verificar si el dispositivo está disponible para asignación
        [$disponible, $vehiculo_asignado, $mensaje] = $dispositivo->verificarDisponibilidad($this->vehiculo->id);

        if (!$disponible) {
            // El dispositivo no está disponible (ya asignado u otro estado)
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'DISPOSITIVO NO DISPONIBLE',
                mensaje: $vehiculo_asignado
                    ? 'El dispositivo ya está asignado al vehículo con placa ' . $vehiculo_asignado->placa
                    : $mensaje
            );
            return;
        }

        // Agregar a la lista
        $this->dispositivos[] = [
            'imei' => $imei,
            'modelo' => $dispositivo->modelo->modelo ?? 'Sin modelo',
            'id' => $dispositivo->id
        ];

        // Si es el primer dispositivo agregado, marcarlo como principal
        if (count($this->dispositivos) == 1) {
            $this->dispositivo_principal = 0;
        }
    }

    // Método para quitar un dispositivo de la lista
    public function quitarDispositivo($index)
    {
        // Si el que eliminamos es el principal, actualizar
        if ($this->dispositivo_principal == $index) {
            $this->dispositivo_principal = null;
        }
        // Si el principal tenía un índice mayor, ajustarlo
        elseif ($this->dispositivo_principal > $index) {
            $this->dispositivo_principal--;
        }

        // Eliminar el dispositivo
        array_splice($this->dispositivos, $index, 1);
    }

    // Método para marcar un dispositivo como principal
    public function marcarComoPrincipal($index)
    {
        $this->dispositivo_principal = $index;
    }

    public function setDispositivoVendido($imei)
    {
        // Esta función ya no se usa directamente, su lógica está en registerDispositivos
    }

    public function registerFlotas(Vehiculos $vehiculo): void
    {
        $vehiculo->flotas()->sync($this->flotas_selected);
    }

    public function registerSectores(Vehiculos $vehiculo): void
    {
        $vehiculo->sectores()->sync($this->sectores_selected);
    }


    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHICULO ACTUALIZADO',
            mensaje: 'Se registro correctamente el vehiculo ' . $placa,
        );
        $this->closeModal();
        $this->reset();
    }

    /**
     * Sincronización manual: busca el vehículo en la plataforma por placa y
     * actualiza gpswox_id, gpswox_active, numero (SIM) y gpswox_sincronizado_at.
     */
    public function sincronizarDesdePlataforma(): void
    {
        try {
            $result = app(GpsWoxService::class)->sincronizarVehiculoDesdePlataforma($this->vehiculo);
            if (($result['status'] ?? 0) === 1) {
                $this->vehiculo->refresh()->load(['sim_card.operador']);
                $this->numero      = $this->vehiculo->numero ?? $this->numero;
                $this->sim_card_id = $this->vehiculo->sim_card_id;
                $this->sim_card    = $this->vehiculo->sim_card?->sim_card;
                $this->operador    = $this->vehiculo->sim_card?->operador?->name;
                $this->cargarDispositivos();
                $this->dispatch('update-table');
                $this->dispatch('notify-toast', icon: 'success', title: 'PLATAFORMA GPS', mensaje: $result['message']);
            } else {
                $this->dispatch('notify-toast', icon: 'warning', title: 'PLATAFORMA GPS', mensaje: $result['message'] ?? 'No encontrado en la plataforma');
            }
        } catch (\Throwable $e) {
            $this->dispatch('notify-toast', icon: 'error', title: 'PLATAFORMA GPS', mensaje: $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->modalEdit = false;
        $this->errorConsultaPlaca = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function buscarPlaca()
    {
        $this->errorConsultaPlaca = null;

        if (empty($this->placa)) {
            $this->errorConsultaPlaca = 'Ingrese una placa para buscar';
            return;
        }

        try {
            $placaLimpia = strtoupper(str_replace([' ', '-'], '', $this->placa));

            $factilizaService = app(FactilizaService::class);
            $resultado = $factilizaService->consultarPlaca($placaLimpia);

            if (($resultado['status'] ?? 0) == 200 && ($resultado['success'] ?? false)) {
                $this->marca  = $resultado['marca']  ?? $this->marca;
                $this->modelo = $resultado['modelo'] ?? $this->modelo;
                $this->serie  = $resultado['serie']  ?? $this->serie;
                $this->color  = $resultado['color']  ?? $this->color;
                $this->motor  = $resultado['motor']  ?? $this->motor;

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



    public function updated($label)
    {
        $requestVehiculo = new VehiculosRequest();
        $this->validateOnly($label, $requestVehiculo->rules($this->dispositivos_id, $this->numero, $this->vehiculo), $requestVehiculo->messages());
    }


    public function updatedPlaca()
    {
        $this->placa = strtoupper($this->placa);
    }

    public function updatedClientesId($value)
    {

        if ($value) {

            $this->flotas = Clientes::find($value)->flotas()->get();
        } else {
            $this->reset('flotas');
        }
    }
    public function updatedNumero($numero)
    {
        if ($numero) {
            $linea = Lineas::where('numero', $numero)->first();
            if (!$linea) return;
            $this->operador = $linea->operador?->name;
            $this->sim_card_id = $linea->sim_card ? $linea->sim_card->id : null;
            $this->sim_card = $linea->sim_card ? $linea->sim_card->sim_card : null;
        }
    }
    public function updatedDispositivoImei($imei)
    {
        if ($imei) {
            $dispositivo = Dispositivos::where('imei', $imei)->first();
            if ($dispositivo) {
                $this->agregarDispositivo($imei);
                $this->dispositivo_imei = ''; // Limpiar el campo después de agregar
            }
        }
    }
    public function close()
    {
        $this->closeModal();
        $this->reset();
    }

    public function addLinea($numero)
    {
        $this->dispatch('add-linea-modal', numero: $numero);
    }

    public function registarImei($imei)
    {
        $this->dispatch('add-imei-modal', imei: $imei);
    }

    public function OpenModalCliente($busqueda)
    {
        $this->dispatch('open-modal-save-cliente', busqueda: $busqueda);
    }
}
