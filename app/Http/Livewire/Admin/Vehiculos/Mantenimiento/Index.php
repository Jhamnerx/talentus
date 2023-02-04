<?php

namespace App\Http\Livewire\Admin\Vehiculos\Mantenimiento;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mantenimiento;

class Index extends Component
{

    use WithPagination;

    public $search;

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

    function validateDate($date, $format = 'd-m-Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function openModalSave()
    {
        $this->emit('openModalSaveMantenimiento', ['from' => 'index']);
    }
}
