<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Tipos;

use App\Models\User;
use Livewire\Component;
use App\Models\tipoTareas;

class Edit extends Component
{

    public $modalEdit = false;
    public $nombre, $costo = 0, $descripcion = "";
    public $user_id = null;
    public $afecta_mantenimiento = false;

    public tipoTareas $tipo_tarea;
    protected $listeners = [
        'openModalEditTipoTask' => 'openModal',
    ];

    protected function rules()
    {
        $rules = [
            'nombre' => 'required',
            'costo' => 'required',
            'descripcion' => 'required',
            'afecta_mantenimiento' => 'boolean',
            'user_id' => 'required',
        ];

        if (auth()->user()->hasRole('tecnico')) {
            $rules['user_id'] = 'nullable';
        }

        return $rules;
    }
    protected function messages()
    {
        return [
            'nombre.required' => 'Escribe una descripcion',
            'costo.required' => 'Ingresa un costo',
            'user_id.required' => 'Selecciona un tecnico',

        ];
    }

    public function render()
    {
        $tecnicos = User::role('tecnico')->get();
        return view('livewire.admin.tecnico.tareas.tipos.edit', compact('tecnicos'));
    }


    public function openModal(tipoTareas $tipo_tarea)
    {

        $this->nombre = $tipo_tarea->nombre;
        $this->costo = $tipo_tarea->costo;
        $this->tipo_tarea = $tipo_tarea;
        $this->descripcion = $tipo_tarea->descripcion;
        $this->afecta_mantenimiento = $tipo_tarea->afecta_mantenimiento;
        $this->user_id = $tipo_tarea->user_id;
        $this->modalEdit = true;
    }
    public function closeModal()
    {

        $this->modalEdit = false;
    }

    public function updated($name, $value)
    {
        $this->validateOnly($name, $this->rules(), $this->messages());
    }

    public function save()
    {
        $data = $this->validate();

        if (auth()->user()->hasRole('tecnico')) {
            $data['user_id'] = auth()->user()->id;
        }

        try {
            $this->tipo_tarea->update($data);
            $this->afterSave();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Mensaje: ' . $th->getMessage() . "."
            );
        }
    }
    public function afterSave()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'TIPO TAREA ACTUALIZADA',
            mensaje: 'Se actualizo correctamente el tipo de tarea ',
        );

        $this->closeModal();
        $this->resetProp();
        $this->dispatch('updateIndex');
    }

    public function resetProp()
    {
        $this->reset([
            'nombre',
            'costo',
            'descripcion',
            'user_id',
            'afecta_mantenimiento',
        ]);
    }
}
