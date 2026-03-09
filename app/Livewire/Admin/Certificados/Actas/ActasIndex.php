<?php

namespace App\Livewire\Admin\Certificados\Actas;

use App\Models\Actas;
use Livewire\Component;
use Livewire\WithPagination;
use Vinkla\Hashids\Facades\Hashids;

class ActasIndex extends Component
{
    use WithPagination;

    public $search;
    public $vehiculoId;
    public $estadoFiltro = '';
    public $vigenciaFiltro = '';

    protected $listeners = [
        'update-table' => 'render',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingVehiculoId()
    {
        $this->resetPage();
    }
    public function updatingEstadoFiltro()
    {
        $this->resetPage();
    }
    public function updatingVigenciaFiltro()
    {
        $this->resetPage();
    }

    public function render()
    {

        $query = Actas::query();

        $query->where(function ($q) {
            $q->whereHas('ciudades', function ($q2) {
                $q2->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('prefijo', 'like', '%' . $this->search . '%');
            })->orWhereHas('vehiculo', function ($q2) {
                $q2->where('placa', 'like', '%' . $this->search . '%');
            })->orWhere('inicio_cobertura', 'like', '%' . $this->search . '%')
                ->orWhere('fecha_instalacion', 'like', '%' . $this->search . '%')
                ->orWhere('fin_cobertura', 'like', '%' . $this->search . '%')
                ->orWhere('numero', 'like', '%' . $this->search . '%')
                ->orWhere('fecha', 'like', '%' . $this->search . '%')
                ->orWhere('codigo', 'like', '%' . $this->search . '%');
        });

        if ($this->vehiculoId) {
            $query->where('vehiculos_id', $this->vehiculoId);
        }

        if ($this->estadoFiltro !== '' && $this->estadoFiltro !== null) {
            $query->where('estado', (int) $this->estadoFiltro);
        }

        if ($this->vigenciaFiltro !== '' && $this->vigenciaFiltro !== null) {
            $today = \Carbon\Carbon::today();
            if ($this->vigenciaFiltro === 'vigente') {
                $query->where('estado', 1)->where('fin_cobertura', '>=', $today);
            } elseif ($this->vigenciaFiltro === 'vencida') {
                $query->where('estado', 1)->where('fin_cobertura', '<', $today);
            }
        }


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
        $this->dispatch('EliminarActa', acta: $acta);
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
