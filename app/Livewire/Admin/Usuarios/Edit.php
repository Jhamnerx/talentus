<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use App\Models\Locales;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    public $showModal = false;
    public $usuario;
    public $name, $email, $password, $password_confirmation, $roles_id = [], $local_id;

    public $locales = [];

    protected function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->usuario->id,
            'password' => 'confirmed',
            'roles_id' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'email.required' => 'El campo email es requerido',
            'email.email' => 'El campo email debe ser un correo válido',
            'email.unique' => 'El campo email ya está en uso',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'roles_id.required' => 'Selecciona los roles del usuario',
        ];
    }

    public function mount() {}

    public function render()
    {
        $roles = Role::all()->select('name', 'id');

        return view('livewire.admin.usuarios.edit', compact('roles'));
    }

    #[On('open-modal-edit')]
    public function openModal(User $usuario)
    {
        //$this->locales = Locales::all()->select('nombre', 'id');
        $this->showModal = true;
        $this->usuario = $usuario;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->roles_id = $usuario->roles->pluck('id');
    }

    public function save()
    {
        $this->validate();

        $this->usuario->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password ? Hash::make($this->password) : $this->usuario->password,
        ]);

        try {
            $this->usuario->syncRoles($this->roles_id);
            $this->dispatch('update-table');
            $this->dispatch(
                'notify',
                icon: 'success',
                title: 'USUARIO ACTUALIZADO',
                mensaje: 'El usuario se ha actualizado correctamente'
            );
            $this->logoutUser($this->usuario->id);
            $this->closeModal();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Ha ocurrido un error al actualizar el usuario'
            );
        }
    }

    public function logoutUser($userId)
    {
        // Encuentra todas las sesiones del usuario
        $sessions = DB::table('sessions')->where('user_id', $userId)->get();

        // Elimina cada sesión
        foreach ($sessions as $session) {
            DB::table('sessions')->where('id', $session->id)->delete();
        }

        // Cierra la sesión del usuario actual si es necesario
        if (Auth::id() == $userId) {
            Auth::logout();
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetProps();
        $this->resetErrorBag();
    }

    public function resetProps()
    {
        $this->reset();
    }
}
