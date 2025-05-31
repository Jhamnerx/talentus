<?php

namespace App\Livewire\Admin\Vehiculos;

use App\Models\Flotas;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Vehiculos;
use Livewire\Attributes\On;
use App\Models\Dispositivos;
use App\Http\Requests\VehiculosRequest;
use App\Models\Lineas;

class SaveVehiculo extends Component
{
    public $modalSaveV = false;

    public $flotas;

    public $placa, $marca, $modelo, $tipo, $year, $color, $motor, $serie, $dispositivo_imei = '', $modelo_gps,
        $sim_card_id, $numero, $sim_card, $operador, $clientes_id, $dispositivos_id, $descripcion;

    // Nuevas propiedades para múltiples dispositivos
    public $dispositivos = [];
    public $dispositivo_principal = null;

    public $flotas_selected = [];

    public function render()
    {
        return view('livewire.admin.vehiculos.save-vehiculo');
    }


    #[On('open-modal-save')]
    public function openModalSave($placa = null)
    {

        $this->modalSaveV = true;
        $this->placa = $placa;
    }


    public function closeModal()
    {
        $this->modalSaveV = false;
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function save()
    {
        $requestVehiculo = new VehiculosRequest();

        $data = $this->validate($requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());

        try {
            // Crear el vehículo con los datos básicos
            $vehiculo = Vehiculos::create($data);
            $this->registerFlotas($vehiculo);

            // Registrar los dispositivos seleccionados
            $this->registerDispositivos($vehiculo);

            $this->dispatch('update-table');

            $this->afterSave($data["placa"]);
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR: ',
                mensaje: $th->getMessage(),
            );
        }
    }

    // Función para registrar los dispositivos al crear un vehículo nuevo
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
        [$disponible, $vehiculo_asignado, $mensaje] = $dispositivo->verificarDisponibilidad();

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

    public function afterSave($placa)
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'VEHICULO REGISTRADO',
            mensaje: 'Se registro correctamente el vehiculo ' . $placa,
        );
        $this->closeModal();
        $this->reset();
    }
    public function setDispositivoVendido($imei)
    {
        // Esta función ya no se usa directamente, su lógica está en registerDispositivos
    }

    public function registerFlotas(Vehiculos $vehiculo)
    {
        $vehiculo->flotas()->sync($this->flotas_selected);
    }

    public function updated($label)
    {
        $requestVehiculo = new VehiculosRequest();
        $this->validateOnly($label, $requestVehiculo->rules($this->dispositivos_id, $this->numero), $requestVehiculo->messages());
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
            $this->operador = $linea->operador;
            $this->sim_card_id = $linea->sim_card ? $linea->sim_card->id : null;
            $this->sim_card = $linea->sim_card ? $linea->sim_card->sim_card : null;
        }
    }

    public function updatedPlaca()
    {
        $this->placa = strtoupper($this->placa);
    }

    public function updatedDispositivoImei($imei = '')
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
