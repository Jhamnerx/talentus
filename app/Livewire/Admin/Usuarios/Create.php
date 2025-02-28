<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{

    public $name, $email, $password, $password_confirmation;
    public $roles_id = [], $local_id;
    public $showModal = false;


    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|string|max:255',
            'password' => 'required|confirmed',
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
            'password.required' => 'El campo contraseña es requerido',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'roles_id.required' => 'Selecciona los roles del usuario',
        ];
    }

    public function render()
    {
        $roles = Role::all()->select('name', 'id');

        return view('livewire.admin.usuarios.create', compact('roles'));
    }

    public function save()
    {
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // ASIGNAR ROLES
            $user->assignRole($this->roles_id);
            $user->save();
            $this->dispatch(
                'notify',
                icon: 'success',
                title: 'USUARIO CREADO',
                mensaje: 'El usuario se ha creado correctamente'
            );
            $this->closeModal();
            $this->dispatch('update-table');
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Ha ocurrido un error al intentar guardar el usuario'
            );
        }
    }

    #[On('open-modal-create')]
    public function openModal()
    {
        $this->showModal = true;
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
