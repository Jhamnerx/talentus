<?php

namespace App\Livewire\Admin\Clientes;

use App\Models\Clientes;
use App\Models\ClienteUser;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class AccesoPortal extends Component
{
    use WireUiActions;

    public bool $modal = false;

    public ?Clientes $cliente = null;

    public ?int $clienteUserId = null;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?string $estadoActual = null;

    public function render()
    {
        return view('livewire.admin.clientes.acceso-portal');
    }

    #[On('abrir-modal-acceso-portal')]
    public function abrir(int $clienteId): void
    {
        $this->authorize('gestionar-accesos-portal');

        $this->resetValidation();
        $this->reset(['clienteUserId', 'name', 'email', 'password', 'password_confirmation', 'estadoActual']);

        $this->cliente = Clientes::findOrFail($clienteId);

        $titular = $this->cliente->clienteUsers()->where('rol', 'titular')->first()
            ?? $this->cliente->clienteUsers()->first();

        if ($titular) {
            $this->clienteUserId = $titular->id;
            $this->name = $titular->name;
            $this->email = $titular->email;
            $this->estadoActual = $titular->estado;
        } else {
            $this->name = '';
            $this->email = (string) ($this->cliente->email ?? '');
        }

        $this->modal = true;
    }

    public function save(): void
    {
        $this->authorize('gestionar-accesos-portal');

        if (! $this->cliente) {
            return;
        }

        $data = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('cliente_users', 'email')->ignore($this->clienteUserId)],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [], [
            'name' => 'nombre',
            'email' => 'correo',
            'password' => 'contraseña',
        ]);

        $clienteUser = $this->clienteUserId
            ? ClienteUser::findOrFail($this->clienteUserId)
            : new ClienteUser([
                'cliente_id' => $this->cliente->id,
                'rol' => $this->cliente->clienteUsers()->exists() ? 'colaborador' : 'titular',
            ]);

        $clienteUser->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // el cast 'hashed' lo encripta
            'estado' => 'aprobado',
        ]);

        if ($clienteUser->email_verified_at === null) {
            $clienteUser->email_verified_at = now();
        }

        $clienteUser->save();

        $this->modal = false;

        $this->dispatch(
            'notify',
            icon: 'success',
            title: 'ACCESO AL PORTAL',
            mensaje: 'Se estableció la contraseña y se activó el acceso de ' . $clienteUser->name . '.',
        );
        $this->dispatch('update-table');

        $this->reset(['clienteUserId', 'name', 'email', 'password', 'password_confirmation', 'estadoActual']);
    }

    public function closeModal(): void
    {
        $this->modal = false;
    }
}
