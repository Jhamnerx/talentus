<?php

namespace App\Http\Livewire\Admin\Vehiculos\Reportes;

use App\Models\Reportes;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class Delete extends Component
{

    public Model $model;

    public $openModalDelete = false;
    public $field = "eliminado";

    public $eliminado;
    protected $listeners = [
        'EliminarReporte' => 'openModal'
    ];


    public function delete()
    {
        $this->model->setAttribute($this->field, '1')->save();
        // return redirect()->route('admin.vehiculos.index');
        $this->dispatchBrowserEvent('reporte-delete', ['vehiculo' => $this->model->vehiculos->placa]);

        $this->emit('updateTable');
    }
    public function render()
    {
        return view('livewire.admin.vehiculos.reportes.delete');
    }

    public function openModal(Reportes $reportes)
    {
        $this->openModalDelete = true;
        $this->model = $reportes;
    }
}
