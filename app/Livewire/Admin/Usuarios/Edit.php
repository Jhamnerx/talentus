<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use App\Models\Ciudades;
use App\Models\Locales;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use WireUi\Traits\WireUiActions;

class Edit extends Component
{
    use WireUiActions;
    public $showModal = false;
    public $usuario;
    public $name, $email, $password, $password_confirmation, $roles_id = [], $local_id;
    public $telefonos  = '';
    public $document_id;
    public $series;
    public $series_id;
    public ?int $ciudad_id = null;

    public $locales = [];

    protected function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->usuario->id,
            'password' => 'nullable|min:8|confirmed',
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
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'roles_id.required' => 'Selecciona los roles del usuario',
            'series_id.required' => 'Selecciona una serie para el usuario',
        ];
    }

    public function mount()
    {
        $this->series = collect();
    }

    public function render()
    {
        $roles = Role::all()->select('name', 'id');
        $ciudades = Ciudades::where('is_active', true)->orderBy('nombre')->get();
        $tecnicoRoleId = Role::findByName('tecnico', 'web')?->id;
        $esTecnico = $tecnicoRoleId && in_array($tecnicoRoleId, (array) $this->roles_id);

        return view('livewire.admin.usuarios.edit', compact('roles', 'ciudades', 'esTecnico'));
    }

    #[On('open-modal-edit')]
    public function openModal(User $usuario)
    {
        $this->showModal = true;
        $this->usuario = $usuario;
        $this->name     = $usuario->name;
        $this->email    = $usuario->email;
        $this->telefonos = $usuario->telefonos ?? '';
        $this->roles_id = $usuario->roles->pluck('id')->toArray();
        $this->series_id = $usuario->series_id;
        $this->ciudad_id = $usuario->ciudad_id;
        if ($usuario->series_id) {
            $serie = $usuario->series;
            $this->document_id = $serie ? $serie->tipo_comprobante_id : null;
            $this->series = \App\Models\Series::where('tipo_comprobante_id', $this->document_id)->get();
        } else {
            $this->document_id = null;
            $this->series = collect();
        }
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

    public function save()
    {
        $this->validate();

        try {
            $this->usuario->update([
                'name'      => $this->name,
                'email'     => $this->email,
                'password'  => $this->password ? Hash::make($this->password) : $this->usuario->password,
                'series_id' => $this->series_id,
                'ciudad_id' => $this->ciudad_id,
                'telefonos' => $this->telefonos ?: null,
            ]);
            $this->usuario->syncRoles($this->roles_id);
            $this->dispatch('update-table');
            $this->notification()->success(
                title: 'USUARIO ACTUALIZADO',
                description: 'El usuario se ha actualizado correctamente.',
            );
            $this->logoutUser($this->usuario->id);
            $this->closeModal();
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: 'Ha ocurrido un error al actualizar el usuario: ' . $th->getMessage(),
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
