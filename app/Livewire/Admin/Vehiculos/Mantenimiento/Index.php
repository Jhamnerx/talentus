<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mantenimiento;
use Illuminate\Database\Capsule\Manager;
use Livewire\Attributes\On;

class Index extends Component
{

    use WithPagination;

    public $search;

    protected $listeners = [
        'update-mantenimiento' => 'render'
    ];

    public function render()
    {

        $mantenimientos = Mantenimiento::wherehas('vehiculo', function ($vehiculo) {

            $vehiculo->where('placa', 'LIKE', '%' . $this->search . '%')
                ->orwhereHas('cliente', function ($query) {
                    $query->where('razon_social', 'LIKE', '%' . $this->search . '%');
                });
        })->orwhere('numero', 'LIKE', '%' . $this->search . '%')
            ->orwhere('detalle_trabajo', 'LIKE', '%' . $this->search . '%')
            ->orwhereDate('fecha_hora_mantenimiento', $this->validateDate($this->search) ? Carbon::createFromFormat('d-m-Y', $this->search)->format('Y-m-d') : '')
            ->orderby('id', 'desc')
            ->with('vehiculo')
            ->paginate(10);;


        return view('livewire.admin.vehiculos.mantenimiento.index', compact('mantenimientos'));
    }

    #[On('update-table')]
    public function updateTable()
    {
        $this->render();
    }


    function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function openModalSave()
    {
        $this->dispatch('open-modal-save-mantenimiento', 'index');
    }

    public function createTask(Mantenimiento $mantenimiento)
    {

        $this->dispatch('openModalCreateTask', $mantenimiento);
    }

    public function openModalEdit(Mantenimiento $mantenimiento)
    {

        $this->dispatch('openModalEditMantenimiento', $mantenimiento);
    }

    public function markAs(Mantenimiento $mantenimiento, $value)
    {

        if ($mantenimiento->estado->name !== $value) {
            $mantenimiento->estado = $value;
            $mantenimiento->save();
            $this->dispatch('mark-as', ['estado' => $value]);
        }

        if ($value = "COMPLETADA") {

            if ($mantenimiento->tarea) {
                $mantenimiento->tarea->estado = 'COMPLETE';
                $mantenimiento->tarea->fecha_termino = Carbon::now();
                $mantenimiento->tarea->save();
            }
        }
    }

    public function openModalDelete(Mantenimiento $mantenimiento)
    {
        $this->dispatch('EliminarMantenimiento', $mantenimiento);
    }

    public function openModalExport()
    {
        $this->dispatch('openModalExport');
    }
}
