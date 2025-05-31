<?php

namespace App\Livewire\Admin\Certificados\Antifatiga;

use App\Http\Requests\ActasRequest;
use App\Models\Ciudades;
use App\Models\Vehiculos;
use App\Models\Clientes;
use App\Models\CertificadosAntifatiga;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public $openModalEdit = false;
    public $certificado_id, $numero, $vehiculos_id, $cliente_id, $fecha_instalacion, $fecha_emision, $inicio_cobertura, $fin_cobertura, $ciudades_id;
    public $fondo = 1, $sello = 1, $plataforma = "basica";

    public $vehiculo_cliente_id; // Para almacenar el ID del cliente del vehículo
    public $cambiar_cliente = false; // Flag para permitir cambiar el cliente

    public $dispositivo_id; // ID del dispositivo asociado al vehículo
    public $imei_personalizado; // IMEI personalizado para el certificado
    public $cambiar_imei = false; // Flag para permitir cambiar el IMEI
    public $dispositivo_imei; // IMEI seleccionado desde el selector de dispositivos

    public $dispositivos = []; // Lista de dispositivos asociados al vehículo

    protected function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'vehiculos_id' => 'required|exists:vehiculos,id',
            'fecha_emision' => 'required|date',
            'fecha_instalacion' => 'required|date',
            'dispositivo_id' => 'nullable|exists:dispositivos,id',
            'inicio_cobertura' => 'required|date',
            'fin_cobertura' => 'required|date|after_or_equal:inicio_cobertura',
            'ciudades_id' => 'required|exists:ciudades,id',
            'fondo' => 'boolean',
            'sello' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            'vehiculos_id.required' => 'Debe seleccionar un vehículo.',
            'vehiculos_id.exists' => 'El vehículo seleccionado no existe.',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria.',
            'fecha_instalacion.required' => 'La fecha de instalación es obligatoria.',
            'inicio_cobertura.required' => 'La fecha de inicio de cobertura es obligatoria.',
            'fin_cobertura.required' => 'La fecha de fin de cobertura es obligatoria.',
            'ciudades_id.required' => 'Debe seleccionar una ciudad.',
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'imei_personalizado.required' => 'El IMEI personalizado es obligatorio cuando se activa la opción de cambiar IMEI.',
        ];
    }


    public function render()
    {
        return view('livewire.admin.certificados.antifatiga.edit');
    }

    #[On('actualizarCertificado')]
    public function openModal(CertificadosAntifatiga $certificado)
    {
        $this->openModalEdit = true;
        $this->certificado_id = $certificado->id;
        $this->vehiculos_id = $certificado->vehiculo_id;
        $this->cliente_id = $certificado->cliente_id;
        $this->fecha_emision = $certificado->fecha_emision;
        $this->fecha_instalacion = $certificado->fecha_instalacion;
        $this->inicio_cobertura = $certificado->inicio_cobertura;
        $this->fin_cobertura = $certificado->fin_cobertura;
        $this->ciudades_id = $certificado->ciudades_id;
        $this->fondo = $certificado->fondo;
        $this->sello = $certificado->sello;
        $this->plataforma = $certificado->plataforma ?? 'basica';

        // Obtener el cliente asociado al vehículo
        $vehiculo = Vehiculos::find($certificado->vehiculo_id);
        if ($vehiculo && $vehiculo->cliente) {
            $this->vehiculo_cliente_id = $vehiculo->cliente->id;
        }

        // Comprobar si se cambió el cliente
        $this->cambiar_cliente = $certificado->cliente_id != $this->vehiculo_cliente_id;

        // Obtener el dispositivo y el IMEI
        $this->dispositivo_id = $certificado->dispositivo_id;
        $this->imei_personalizado = $certificado->imei_personalizado;
        $this->cambiar_imei = $certificado->cambiar_imei;

        $this->getDispositivosDelVehiculo(); // Cargar los dispositivos del vehículo
        // Asignar el dispositivo_id correspondiente si existe
        if ($this->dispositivos && count($this->dispositivos) > 0) {
            // Buscar el dispositivo que coincida con el ID actual del certificado o el principal
            $dispositivo = collect($this->dispositivos)->firstWhere('id', $this->dispositivo_id);
            if ($dispositivo) {
                $this->dispositivo_id = $dispositivo['id'];
            } else {
                // Si no coincide, asignar el primero de la lista
                $this->dispositivo_id = $this->dispositivos[0]['id'];
            }
        } else {
            $this->dispositivo_id = null;
        }
    }

    public function closeModal()
    {
        $this->openModalEdit = false;
        $this->resetProperties();
    }

    public function save()
    {
        $values = $this->validate();


        try {
            $certificado = CertificadosAntifatiga::find($this->certificado_id);

            if (!$certificado) {
                throw new \Exception('Certificado no encontrado.');
            }

            // Validar que el vehículo tenga un dispositivo asignado o se haya ingresado un IMEI personalizado
            $vehiculo = Vehiculos::find($values["vehiculos_id"]);
            $tieneDispositivo = $vehiculo && $vehiculo->dispositivoPrincipal && $vehiculo->dispositivoPrincipal->dispositivo;

            if (!$tieneDispositivo && !$this->cambiar_imei) {
                throw new \Exception('El vehículo seleccionado no tiene un dispositivo GPS asociado. Por favor, asigne un dispositivo al vehículo o active la opción "Personalizar IMEI" e ingrese un IMEI manualmente.');
            }

            // Obtener el cliente seleccionado
            $clienteId = $this->cliente_id;
            $cliente = Clientes::find($clienteId);

            if (!$cliente) {
                throw new \Exception('Debe seleccionar un cliente válido.');
            }

            // Actualizar el certificado
            $certificado->update([
                'vehiculo_id' => $values["vehiculos_id"],
                'cliente_id' => $clienteId,
                'fecha_emision' => $this->fecha_emision,
                'fecha_instalacion' => $values["fecha_instalacion"],
                'inicio_cobertura' => $values["inicio_cobertura"],
                'fin_cobertura' => $values["fin_cobertura"],
                'ciudades_id' => $values["ciudades_id"],
                'fondo' => $values["fondo"],
                'sello' => $values["sello"],
                // Actualizar datos del cliente en JSON para tener un histórico
                'cliente' => [
                    'razon_social' => $cliente->razon_social,
                    'numero_documento' => $cliente->numero_documento,
                    'direccion' => $cliente->direccion
                ],
                // Actualizar información del dispositivo
                'dispositivo_id' => $this->cambiar_imei ? null : $this->dispositivo_id,
                'imei_personalizado' => $this->cambiar_imei ? $this->imei_personalizado : null,
                'cambiar_imei' => $this->cambiar_imei
            ]);

            $this->actualizarVehiculo(Vehiculos::find($values["vehiculos_id"]), $values["fecha_instalacion"]);

            $this->afterSave();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR AL ACTUALIZAR',
                mensaje: 'Ocurrió el siguiente error: ' . $th->getMessage(),
            );
        }
    }

    public function actualizarVehiculo(Vehiculos $vehiculo, $fecha_instalacion)
    {
        $vehiculo->update(['fecha_instalacion' => $fecha_instalacion]);
    }

    public function updatedVehiculosId($vehiculoId)
    {
        if (!$vehiculoId) return;

        $vehiculo = Vehiculos::find($vehiculoId);
        if (!$vehiculo) return;

        // Actualizar fecha de instalación
        $this->fecha_instalacion = $vehiculo->fecha_instalacion
            ? Carbon::parse($vehiculo->fecha_instalacion)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');

        // Obtener el cliente asociado al vehículo
        if ($vehiculo->cliente) {
            $this->vehiculo_cliente_id = $vehiculo->cliente->id;
            $this->cliente_id = $vehiculo->cliente->id;
        } else {
            $this->vehiculo_cliente_id = null;
            $this->cliente_id = null;
        }

        // Obtener el dispositivo asociado al vehículo
        if ($vehiculo->dispositivoPrincipal) {
            $this->dispositivo_id = $vehiculo->dispositivoPrincipal->dispositivo_id;
            if ($vehiculo->dispositivoPrincipal->dispositivo) {
                $this->imei_personalizado = $vehiculo->dispositivoPrincipal->dispositivo->imei;
                $this->dispositivo_imei = $vehiculo->dispositivoPrincipal->dispositivo->imei;
            }
        } else {
            $this->dispositivo_id = null;
            $this->imei_personalizado = null;
            $this->dispositivo_imei = null;

            // Notificar al usuario que el vehículo no tiene dispositivo
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'ADVERTENCIA',
                mensaje: 'El vehículo seleccionado no tiene un dispositivo GPS asociado. Por favor, asigne un dispositivo al vehículo o personalice el IMEI manualmente.',
            );
        }

        // Resetear las opciones
        $this->cambiar_cliente = false;
        $this->cambiar_imei = false;
    }

    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CERTIFICADO ACTUALIZADO',
            mensaje: 'Se actualizó correctamente el certificado antifatiga',
        );
        $this->closeModal();
        $this->dispatch('update-table');
    }

    public function updated($label)
    {

        $this->validateOnly($label);
    }

    public function resetProperties()
    {
        $this->certificado_id = null;
        $this->numero = null;
        $this->vehiculos_id = null;
        $this->cliente_id = null;
        $this->vehiculo_cliente_id = null;
        $this->cambiar_cliente = false;
        $this->fecha_emision = null;
        $this->fecha_instalacion = null;
        $this->inicio_cobertura = null;
        $this->fin_cobertura = null;
        $this->ciudades_id = null;
        $this->fondo = 1;
        $this->sello = 1;
        $this->plataforma = "basica";
        $this->dispositivo_id = null;
        $this->dispositivo_imei = null;
        $this->imei_personalizado = null;
        $this->cambiar_imei = false;
    }

    /**
     * Método para alternar la opción de cambiar cliente
     */
    public function toggleCambiarCliente()
    {
        // Invertir el estado actual
        $this->cambiar_cliente = !$this->cambiar_cliente;

        // Si desmarcamos la opción de cambiar cliente, volver al cliente original del vehículo
        if (!$this->cambiar_cliente) {
            $this->cliente_id = $this->vehiculo_cliente_id;
        }
    }

    /**
     * Método para alternar la opción de cambiar IMEI
     */
    public function toggleCambiarImei()
    {
        // Invertir el estado actual
        $this->cambiar_imei = !$this->cambiar_imei;

        if ($this->vehiculos_id) {
            $vehiculo = Vehiculos::find($this->vehiculos_id);

            // Si desmarcamos la opción de cambiar IMEI, volver al IMEI original del dispositivo
            if (!$this->cambiar_imei) {
                if ($vehiculo && $vehiculo->dispositivoPrincipal && $vehiculo->dispositivoPrincipal->dispositivo) {
                    $this->dispositivo_id = $vehiculo->dispositivoPrincipal->dispositivo_id;
                    $this->dispositivo_imei = $vehiculo->dispositivoPrincipal->dispositivo->imei;
                    $this->imei_personalizado = null; // Limpiar el IMEI personalizado
                }
            } else {
                // Si activamos la opción de cambiar IMEI, inicializar el campo con el IMEI actual
                if ($vehiculo && $vehiculo->dispositivoPrincipal && $vehiculo->dispositivoPrincipal->dispositivo) {
                    $this->imei_personalizado = $vehiculo->dispositivoPrincipal->dispositivo->imei;
                }
            }
        }
    }

    /**
     * Método para registrar un nuevo IMEI
     */
    public function registarImei($imei)
    {
        // Validar el formato del IMEI
        if (!preg_match('/^\d{15}$/', $imei)) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'FORMATO INCORRECTO',
                mensaje: 'El IMEI debe tener 15 dígitos numéricos.',
            );
            return;
        }

        // Establecer el IMEI manualmente
        $this->imei_personalizado = $imei;
        $this->dispositivo_imei = $imei;
        $this->cambiar_imei = true; // Activar el modo de IMEI personalizado

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'IMEI REGISTRADO',
            mensaje: 'Se ha registrado el IMEI: ' . $imei,
        );
    }

    /**
     * Método que se ejecuta cuando se actualiza el IMEI seleccionado en el dropdown
     */
    public function updatedDispositivoImei($value)
    {
        if (!$value || !$this->vehiculos_id) {
            return;
        }

        // Buscar el dispositivo correspondiente al IMEI seleccionado
        $vehiculo = Vehiculos::find($this->vehiculos_id);
        if (!$vehiculo) {
            return;
        }

        $dispositivoVehiculo = $vehiculo->dispositivos()
            ->whereNull('fecha_desinstalacion')
            ->whereHas('dispositivo', function ($query) use ($value) {
                $query->where('imei', $value);
            })
            ->with('dispositivo')
            ->first();

        if ($dispositivoVehiculo && $dispositivoVehiculo->dispositivo) {
            $this->dispositivo_id = $dispositivoVehiculo->dispositivo->id;
        }
    }

    /**
     * Método para obtener los dispositivos asociados al vehículo seleccionado
     * Este método será utilizado para filtrar los dispositivos en el selector
     */
    public function getDispositivosDelVehiculo()
    {
        if (!$this->vehiculos_id) {
            return [];
        }

        $vehiculo = Vehiculos::find($this->vehiculos_id);
        if (!$vehiculo) {
            return [];
        }

        // Obtener todos los dispositivos activos (sin fecha de desinstalación) del vehículo
        $dispositivos = $vehiculo->dispositivos()
            ->whereNull('fecha_desinstalacion')
            ->with('dispositivo')
            ->get()
            ->pluck('dispositivo')
            ->filter(); // Filtrar los nulos

        // Si no hay dispositivos, verificar si hay un dispositivo principal
        if ($dispositivos->isEmpty() && $vehiculo->dispositivoPrincipal && $vehiculo->dispositivoPrincipal->dispositivo) {
            $dispositivoPrincipal = $vehiculo->dispositivoPrincipal->dispositivo;
            return [
                [
                    'id' => $dispositivoPrincipal->id,
                    'imei' => $dispositivoPrincipal->imei,
                    'option_description' => 'Modelo: ' . optional($dispositivoPrincipal->modelo)->modelo . ' (Principal)'
                ]
            ];
        }

        // Formateamos la respuesta para ser compatible con el selector
        $this->dispositivos =  $dispositivos->map(function ($dispositivo) {
            return [
                'id' => $dispositivo->id,
                'imei' => $dispositivo->imei,
                'option_description' => 'Modelo: ' . optional($dispositivo->modelo)->modelo
            ];
        })->toArray();
        return $this->dispositivos;
    }

    /**
     * Método para registrar un nuevo vehículo
     */
    public function addVehiculo()
    {
        $this->dispatch('open-modal-add-vehiculo');
    }
}
