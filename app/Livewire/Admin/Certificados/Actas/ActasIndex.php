<?php

namespace App\Livewire\Admin\Certificados\Actas;

use App\Http\Controllers\Admin\UtilesController;
use App\Models\Actas;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

class ActasIndex extends Component
{
    use WithPagination;

    public $search;

    protected $listeners = [
        'update-table' => 'render',
    ];

    public function render()
    {

        $query = Actas::query();

        $query->whereHas('ciudades', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('prefijo', 'like', '%' . $this->search . '%');
        })->orWhereHas('vehiculo', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orWhere('inicio_cobertura', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_instalacion', 'like', '%' . $this->search . '%')
            ->orWhere('fin_cobertura', 'like', '%' . $this->search . '%')
            ->orWhere('numero', 'like', '%' . $this->search . '%')
            ->orWhere('fecha', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%');


        $actas = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.admin.certificados.actas.actas-index', compact('actas'));
    }


    public function openModalSave()
    {
        $this->dispatch('guardarActa');
    }

    //Enviar datos para editar acta
    public function openModalEdit(Actas $acta)
    {
        $this->dispatch('actualizarActa', acta: $acta);
    }


    public function openModalDelete(Actas $acta)
    {
        $this->dispatch('EliminarActa', $acta);
    }

    public function openModalShow(Actas $acta)
    {
        $this->dispatch('verDetalleActa', $acta);
        //$this->openModalDetalle = true;
    }

    public function cambiarEstado(Actas $acta, $field, $value)
    {
        $acta->setAttribute($field, $value)->save();
    }
    public function modalOpenSend(Actas $acta)
    {

        $this->dispatch('modalOpenSend', $acta);
    }

    public function openModalImport()
    {

        $this->dispatch('openModalImport');
    }

    public function toggleStatus(Actas $acta)
    {
        $acta->estado = !$acta->estado; // Cambia el estado del toggle
        $acta->save(); // Guarda el cambio en el modelo
    }
    public function toggleSello(Actas $acta)
    {
        $acta->sello = !$acta->sello; // Cambia el estado del toggle
        $acta->save(); // Guarda el cambio en el modelo
    }

    public function toggleFondo(Actas $acta)
    {
        $acta->fondo = !$acta->fondo; // Cambia el estado del toggle
        $acta->save(); // Guarda el cambio en el modelo
    }
}
