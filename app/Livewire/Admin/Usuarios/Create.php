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

    public $document_id;
    public $series;
    public $series_id;

    public $editMode = false;
    public $userId;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|string|max:255',
            'password' => 'required|confirmed',
            'roles_id' => 'required',
        ];

        if (!is_null($this->document_id)) {
            $rules['series_id'] = 'required';
        }

        return $rules;
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
            'series_id.required' => 'Selecciona una serie para el usuario',
        ];
    }

    public function render()
    {
        $roles = Role::all()->select('name', 'id');

        return view('livewire.admin.usuarios.create', compact('roles'));
    }

    public function mount($userId = null)
    {
        if ($userId) {
            $this->editMode = true;
            $this->userId = $userId;
            $user = User::findOrFail($userId);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->roles_id = $user->roles->pluck('id')->toArray();
            $this->series_id = $user->series_id;

            if ($user->series_id) {
                $serie = $user->series;
                $this->document_id = $serie ? $serie->tipo_comprobante_id : null;
                $this->series = \App\Models\Series::where('tipo_comprobante_id', $this->document_id)->get();
            } else {
                $this->document_id = null;
                $this->series = collect();
            }
        } else {
            $this->series = collect();
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $user = User::findOrFail($this->userId);
                $user->name = $this->name;
                $user->email = $this->email;
                if ($this->password) {
                    $user->password = Hash::make($this->password);
                }
                $user->series_id = $this->series_id;
                $user->save();
                $user->syncRoles($this->roles_id);
            } else {
                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'series_id' => $this->series_id,
                ]);
                $user->assignRole($this->roles_id);
                $user->save();
            }
            $this->dispatch(
                'notify',
                icon: 'success',
                title: $this->editMode ? 'USUARIO ACTUALIZADO' : 'USUARIO CREADO',
                mensaje: $this->editMode ? 'El usuario se ha actualizado correctamente' : 'El usuario se ha creado correctamente'
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

    public function updatedDocumentId($value)
    {
        if ($value) {
            $this->series = \App\Models\Series::where('tipo_comprobante_id', $value)->get();
        } else {
            $this->series = collect();
        }
        $this->series_id = null;
    }
}
