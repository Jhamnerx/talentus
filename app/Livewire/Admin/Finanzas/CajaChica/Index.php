<?php

namespace App\Livewire\Admin\Finanzas\CajaChica;

use App\Models\Cash;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $estado_filter = '';

    #[On('render')]
    public function render()
    {
        $query = Cash::with(['user', 'cashDocuments'])
            ->withCount('cashDocuments')
            ->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });

        if ($this->estado_filter !== '') {
            $query->where('estado', $this->estado_filter);
        }

        if (!empty($this->from) && !empty($this->to)) {
            $query->whereBetween('fecha_apertura', [$this->from, $this->to]);
        }

        $cajas = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.admin.finanzas.caja-chica.index', compact('cajas'));
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime('-7 days'));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime('-1 month'));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function create()
    {
        $this->dispatch('create-cash');
    }

    public function edit($id)
    {
        $this->dispatch('edit-cash', id: $id);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('delete-cash', id: $id);
    }

    public function closeCash($id)
    {
        $this->dispatch('close-cash', id: $id);
    }

    public function verReporte($id)
    {
        // Generar reporte PDF de caja
        return redirect()->route('finanzas.caja-chica.reporte', $id);
    }

    public function verReporteIngreso($id)
    {
        // Generar reporte PDF de ingresos y egresos
        return redirect()->route('finanzas.caja-chica.ingresos-egresos', $id);
    }
}
