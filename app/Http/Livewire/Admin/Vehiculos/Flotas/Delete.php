<?php

namespace App\Http\Livewire\Admin\Vehiculos\Flotas;

use App\Models\Eliminados;
use App\Models\Flotas;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{


    public Model $model;


    public $field = "eliminado";

    public $eliminado;

    public function delete()
    {
        $this->model->setAttribute($this->field, '1')->save();

        Eliminados::create([
            'delete_id' => $this->model->id,
            'delete_type' => Flotas::class,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('admin.vehiculos.flotas.index');
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.flotas.delete');
    }
}
