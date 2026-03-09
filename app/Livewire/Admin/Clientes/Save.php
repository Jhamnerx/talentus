<?php

namespace App\Livewire\Admin\Clientes;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Contactos;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use WireUi\Traits\WireUiActions;
use App\Services\FactilizaService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ClientesRequest;

class Save extends Component
{
    use WireUiActions;

    public $modalSave = false;

    public $tipo_documento_id = 1, $numero_documento, $razon_social, $telefono, $email, $web_site, $direccion;

    public $errorConsulta;


    public function render()
    {
        return view('livewire.admin.clientes.save');
    }

    public function buscarDocumento()
    {
        $this->reset('errorConsulta');
        $numero = trim($this->numero_documento);

        // Validar que solo contenga números
        if (!ctype_digit($numero)) {
            $this->errorConsulta = 'El número de documento solo debe contener dígitos';
            return;
        }

        // Validar formato según tipo de documento
        if ($this->tipo_documento_id == 1) {
            if (strlen($numero) != 8) {
                $this->errorConsulta = 'El DNI debe tener exactamente 8 dígitos';
                return;
            }
            $this->consultarDni($numero);
        } elseif ($this->tipo_documento_id == 6) {
            if (strlen($numero) != 11) {
                $this->errorConsulta = 'El RUC debe tener exactamente 11 dígitos';
                return;
            }
            $this->consultarRuc($numero);
        } else {
            $this->errorConsulta = 'Tipo de documento no válido para búsqueda automática';
        }
    }

    protected function consultarDni($numero)
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarDni($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombres'] ?? false) {
                $this->razon_social = $resultado['nombre_completo'];
                $this->direccion = $resultado['direccion_completa'] ?? '';
                $this->notification()->success('DNI encontrado', 'Datos cargados correctamente');
            } else {
                $this->errorConsulta = 'No se encontró información para este DNI';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el DNI';
        }
    }

    protected function consultarRuc($numero)
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarRuc($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombre_o_razon_social'] ?? false) {
                $this->razon_social = $resultado['nombre_o_razon_social'];
                $this->direccion = $resultado['direccion_completa'] ?? '';
                $this->notification()->success('RUC encontrado', 'Datos cargados correctamente');
            } else {
                $this->errorConsulta = 'No se encontró información para este RUC';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el RUC';
        }
    }

    public function save()
    {
        $request = new ClientesRequest();
        $data = $this->validate($request->rules(), $request->messages());

        try {
            $cliente = Clientes::create($data);
            $this->afterSave($cliente);
        } catch (\Throwable $th) {

            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterSave($cliente)
    {
        // Crear contacto automáticamente según tipo de documento
        $this->crearContactoAutomatico($cliente);

        $this->closeModal();
        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'CLIENTE GUARDADO',
            mensaje: 'El cliente ' . $cliente->razon_social . ' fue registrado correctamente'
        );

        $this->dispatch('update-table');
        $this->resetProp();
    }

    /**
     * Crea un contacto automáticamente después de guardar el cliente
     * - Si es RUC: Consulta representante legal y lo guarda como GERENTE
     * - Si es DNI: Guarda el mismo cliente como contacto
     */
    protected function crearContactoAutomatico($cliente)
    {
        try {
            if ($cliente->tipo_documento_id == 6) {
                // Es RUC: Consultar representante legal
                $this->crearContactoDesdeRepresentante($cliente);
            } elseif ($cliente->tipo_documento_id == 1) {
                // Es DNI: Guardar el mismo cliente como contacto
                $this->crearContactoDesdeDNI($cliente);
            }
        } catch (\Throwable $th) {
            // Log del error pero no detener el flujo principal
            Log::warning('Error al crear contacto automático: ' . $th->getMessage(), [
                'cliente_id' => $cliente->id,
                'tipo_documento_id' => $cliente->tipo_documento_id,
            ]);
        }
    }

    /**
     * Crea contacto desde el representante legal consultando a Factiliza
     */
    protected function crearContactoDesdeRepresentante($cliente)
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarRucRepresentantes($cliente->numero_documento);

        if (($resultado['success'] ?? false) && !empty($resultado['representantes'])) {
            // Buscar el gerente general en los representantes
            $gerente = collect($resultado['representantes'])->first(function ($rep) {
                return stripos($rep['cargo'] ?? '', 'GERENTE') !== false;
            });

            // Si no hay gerente, tomar el primer representante
            $gerente = $gerente ?? $resultado['representantes'][0];

            // Extraer número de documento (puede estar enmascarado con *****)
            $numeroDocumento = $gerente['numero_de_documento'];

            // Verificar si ya existe un contacto con este documento
            $existeContacto = Contactos::where('clientes_id', $cliente->id)
                ->where('numero_documento', $numeroDocumento)
                ->exists();

            if (!$existeContacto) {
                Contactos::create([
                    'clientes_id' => $cliente->id,
                    'nombre' => $gerente['nombre'],
                    'numero_documento' => $numeroDocumento,
                    'cargo' => $gerente['cargo'] ?? 'GERENTE GENERAL',
                    'is_gerente' => true,
                    'telefono' => $cliente->telefono ?? '',
                    'email' => $cliente->email ?? '',
                    'birthday' => Carbon::now(),
                    'descripcion' => 'Contacto creado automáticamente desde representante legal',
                    'empresa_id' => $cliente->empresa_id,
                ]);
            }
        }
    }

    /**
     * Crea contacto desde el mismo cliente cuando es DNI
     */
    protected function crearContactoDesdeDNI($cliente)
    {
        // Verificar si ya existe un contacto con este DNI
        $existeContacto = Contactos::where('clientes_id', $cliente->id)
            ->where('numero_documento', $cliente->numero_documento)
            ->exists();

        if (!$existeContacto) {
            Contactos::create([
                'clientes_id' => $cliente->id,
                'nombre' => $cliente->razon_social,
                'numero_documento' => $cliente->numero_documento,
                'cargo' => 'GERENTE',
                'is_gerente' => true,
                'telefono' => $cliente->telefono ?? '',
                'email' => $cliente->email ?? '',
                'birthday' => Carbon::now(),
                'descripcion' => 'Contacto creado automáticamente desde cliente DNI',
                'empresa_id' => $cliente->empresa_id,
            ]);
        }
    }

    public function resetProp()
    {

        $this->reset('tipo_documento_id', 'numero_documento', 'razon_social', 'telefono', 'email', 'web_site', 'direccion');
    }

    public function updated($value)
    {
        $request = new ClientesRequest();
        $this->validateOnly($value, $request->rules(), $request->messages());
    }

    public function closeModal()
    {
        $this->modalSave = false;
    }

    #[On(['open-modal-save-cliente'])]
    public function openModalSaveCliente($busqueda = null)
    {
        $this->razon_social = $busqueda;
        $this->modalSave = true;
    }
}
