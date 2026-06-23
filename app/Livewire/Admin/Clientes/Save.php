<?php

namespace App\Livewire\Admin\Clientes;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Contactos;
use App\Models\RubroCliente;
use App\Models\Sector;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;
use App\Services\FactilizaService;
use App\Http\Requests\ClientesRequest;

class Save extends Component
{
    use WireUiActions;

    public $modalSave = false;

    // Datos del cliente
    public $tipo_documento_id = 1, $numero_documento, $razon_social, $telefono, $email, $web_site, $direccion, $ubigeo;
    public ?int $rubro_id = null;
    public ?int $sector_id = null;

    // Datos del contacto principal (para RUC: se llena manualmente; para DNI: se sincroniza automáticamente)
    public $contacto_nombre;
    public $contacto_numero_documento;
    public $contacto_cargo = 'GERENTE GENERAL';
    public $contacto_telefono;
    public $contacto_email;

    public $errorConsulta;
    public $errorContacto;

    public function render()
    {
        $rubros = RubroCliente::activos()->get(['id', 'nombre']);
        $sectores = Sector::activos()->get(['id', 'nombre']);
        return view('livewire.admin.clientes.save', compact('rubros', 'sectores'));
    }

    // ─── Sincronización para DNI ────────────────────────────────────────────────

    public function updatedRazonSocial($value): void
    {
        if ($this->tipo_documento_id == 1) {
            $this->contacto_nombre = $value;
        }
    }

    public function updatedNumeroDocumento($value): void
    {
        if ($this->tipo_documento_id == 1) {
            $this->contacto_numero_documento = $value;
        }
    }

    public function updatedTelefono($value): void
    {
        if ($this->tipo_documento_id == 1) {
            $this->contacto_telefono = $value;
        }
    }

    public function updatedEmail($value): void
    {
        if ($this->tipo_documento_id == 1) {
            $this->contacto_email = $value;
        }
    }

    public function updatedTipoDocumentoId($value): void
    {
        if ($value == 1) {
            // DNI: el contacto es el mismo cliente
            $this->contacto_nombre           = $this->razon_social;
            $this->contacto_numero_documento = $this->numero_documento;
            $this->contacto_cargo            = 'GERENTE';
            $this->contacto_telefono         = $this->telefono;
            $this->contacto_email            = $this->email;
        } else {
            // RUC: limpiar para que el usuario llene manualmente
            $this->contacto_nombre           = null;
            $this->contacto_numero_documento = null;
            $this->contacto_cargo            = 'GERENTE GENERAL';
            $this->contacto_telefono         = null;
            $this->contacto_email            = null;
        }
        $this->reset('errorConsulta');
    }

    // ─── Búsqueda de documento ───────────────────────────────────────────────────

    public function buscarContacto(): void
    {
        $this->reset('errorContacto');
        $numero = trim($this->contacto_numero_documento);

        if (!ctype_digit($numero) || strlen($numero) != 8) {
            $this->errorContacto = 'El DNI debe tener exactamente 8 dígitos';
            return;
        }

        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarDni($numero);

        if (($resultado['success'] ?? false) && ($resultado['nombres'] ?? false)) {
            $this->contacto_nombre = $resultado['nombre_completo'];
            $this->notification()->success('DNI encontrado', 'Datos del contacto cargados');
        } else {
            $this->errorContacto = $resultado['message'] ?? 'No se encontró información para este DNI';
        }
    }

    public function buscarDocumento(): void
    {
        $this->reset('errorConsulta');
        $numero = trim($this->numero_documento);

        if (!ctype_digit($numero)) {
            $this->errorConsulta = 'El número de documento solo debe contener dígitos';
            return;
        }

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

    protected function consultarDni(string $numero): void
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarDni($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombres'] ?? false) {
                $this->razon_social              = $resultado['nombre_completo'];
                $this->direccion                 = $resultado['direccion_completa'] ?? '';
                $this->ubigeo                    = $resultado['ubigeo_sunat'] ?? '';
                // Sincronizar contacto
                $this->contacto_nombre           = $this->razon_social;
                $this->contacto_numero_documento = $numero;
                $this->notification()->success('DNI encontrado', 'Datos cargados correctamente');
            } else {
                $this->errorConsulta = 'No se encontró información para este DNI';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el DNI';
        }
    }

    protected function consultarRuc(string $numero): void
    {
        $factiliza = new FactilizaService();
        $resultado = $factiliza->consultarRuc($numero);

        if ($resultado['success'] ?? false) {
            if ($resultado['nombre_o_razon_social'] ?? false) {
                $this->razon_social = $resultado['nombre_o_razon_social'];
                $this->direccion    = $resultado['direccion_completa'] ?? '';
                $this->ubigeo       = $resultado['ubigeo_sunat'] ?? '';
                $this->notification()->success('RUC encontrado', 'Datos cargados correctamente');

                // Intentar pre-llenar contacto desde representante legal
                $this->preLlenarContactoDesdeRuc($numero);
            } else {
                $this->errorConsulta = 'No se encontró información para este RUC';
            }
        } else {
            $this->errorConsulta = $resultado['message'] ?? 'Error al consultar el RUC';
        }
    }

    protected function preLlenarContactoDesdeRuc(string $ruc): void
    {
        try {
            $factiliza = new FactilizaService();
            $resultado = $factiliza->consultarRucRepresentantes($ruc);

            if (($resultado['success'] ?? false) && !empty($resultado['representantes'])) {
                $gerente = collect($resultado['representantes'])->first(
                    fn($rep) => stripos($rep['cargo'] ?? '', 'GERENTE') !== false
                ) ?? $resultado['representantes'][0];

                $this->contacto_nombre           = $gerente['nombre'] ?? null;
                $this->contacto_numero_documento = $gerente['numero_de_documento'] ?? null;
                $this->contacto_cargo            = $gerente['cargo'] ?? 'GERENTE GENERAL';
            }
        } catch (\Throwable) {
            // No bloquear si falla la consulta de representantes
        }
    }

    // ─── Guardar ─────────────────────────────────────────────────────────────────

    public function save(): void
    {
        $request      = new ClientesRequest();
        $clienteRules = $request->rules();

        // DNI: teléfono y email obligatorios en el cliente
        if ($this->tipo_documento_id == 1) {
            $clienteRules['telefono'] = 'required|digits_between:6,15|numeric';
            $clienteRules['email']    = 'required|email';
        }

        // Reglas del contacto
        if ($this->tipo_documento_id == 6) {
            $contactoRules = [
                'contacto_nombre'           => 'required|min:3',
                'contacto_numero_documento' => 'required|digits:8|numeric',
                'contacto_cargo'            => 'nullable|string|max:100',
                'contacto_telefono'         => 'required|digits_between:6,15|numeric',
                'contacto_email'            => 'nullable|email',
            ];
        } else {
            $contactoRules = [
                'contacto_telefono' => 'required|digits_between:6,15|numeric',
                'contacto_email'    => 'required|email',
            ];
        }

        $messages = array_merge($request->messages(), [
            'contacto_nombre.required'           => 'El nombre del contacto es obligatorio',
            'contacto_nombre.min'                => 'El nombre debe tener al menos 3 caracteres',
            'contacto_numero_documento.required' => 'El DNI del contacto es obligatorio',
            'contacto_numero_documento.digits'   => 'El DNI debe tener exactamente 8 dígitos',
            'contacto_numero_documento.numeric'  => 'El DNI solo debe contener números',
            'contacto_telefono.required'         => 'El teléfono del contacto es obligatorio',
            'contacto_email.required'            => 'El correo del contacto es obligatorio',
            'contacto_email.email'               => 'El correo del contacto no tiene un formato válido',
            'telefono.required'                  => 'El teléfono es obligatorio',
            'email.required'                     => 'El correo es obligatorio',
        ]);

        $data = $this->validate(array_merge($clienteRules, $contactoRules), $messages);

        try {
            $cliente = Clientes::create($data);
            $this->crearContacto($cliente);
            $this->afterSave($cliente);
        } catch (\Throwable $th) {
            $this->dispatch('notify-toast', icon: 'error', title: 'ERROR:', mensaje: $th->getMessage());
        }
    }

    protected function crearContacto(Clientes $cliente): void
    {
        if ($this->tipo_documento_id == 1) {
            // DNI: el mismo cliente es el contacto
            Contactos::create([
                'clientes_id'      => $cliente->id,
                'nombre'           => $this->razon_social,
                'numero_documento' => $this->numero_documento,
                'cargo'            => 'GERENTE',
                'is_gerente'       => true,
                'telefono'         => $this->telefono,
                'email'            => $this->email,
                'birthday'         => Carbon::now(),
                'descripcion'      => 'Contacto creado automáticamente',
                'empresa_id'       => $cliente->empresa_id,
            ]);
        } else {
            // RUC: contacto ingresado en el formulario
            Contactos::create([
                'clientes_id'      => $cliente->id,
                'nombre'           => $this->contacto_nombre,
                'numero_documento' => $this->contacto_numero_documento,
                'cargo'            => $this->contacto_cargo ?: 'GERENTE GENERAL',
                'is_gerente'       => true,
                'telefono'         => $this->contacto_telefono,
                'email'            => $this->contacto_email,
                'birthday'         => Carbon::now(),
                'descripcion'      => 'Contacto registrado al crear cliente',
                'empresa_id'       => $cliente->empresa_id,
            ]);
        }
    }

    public function afterSave(Clientes $cliente): void
    {
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

    public function resetProp(): void
    {
        $this->reset(
            'tipo_documento_id',
            'numero_documento',
            'razon_social',
            'telefono',
            'email',
            'web_site',
            'direccion',
            'ubigeo',
            'contacto_nombre',
            'contacto_numero_documento',
            'contacto_cargo',
            'contacto_telefono',
            'contacto_email',
            'rubro_id',
            'sector_id',
            'errorConsulta',
            'errorContacto'
        );
        $this->tipo_documento_id = 1;
        $this->contacto_cargo    = 'GERENTE GENERAL';
    }

    public function updated($value): void
    {
        $request = new ClientesRequest();
        $this->validateOnly($value, $request->rules(), $request->messages());
    }

    public function closeModal(): void
    {
        $this->modalSave = false;
    }

    #[On(['open-modal-save-cliente'])]
    public function openModalSaveCliente($busqueda = null): void
    {
        $this->resetProp();
        $this->razon_social    = $busqueda;
        $this->contacto_nombre = $busqueda;
        $this->modalSave       = true;
    }
}
