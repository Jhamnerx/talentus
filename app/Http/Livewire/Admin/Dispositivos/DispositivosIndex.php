<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Models\Dispositivos;
use App\Models\ModelosDispositivo;
use Livewire\Component;
use Livewire\WithPagination;

class DispositivosIndex extends Component
{
    use WithPagination;
    public $search;
    public $estado = 0;

    protected $listeners = ['render' => 'render'];

    public function render()
    {

        $dispositivos = Dispositivos::whereHas('modelo', function ($query) {
            $query->where('marca', 'like', '%' . $this->search . '%')
                ->orWhere('modelo', 'like', '%' . $this->search . '%');
        })->orwhereHas('vehiculos', function ($query) {
            $query->where('placa', 'like', '%' . $this->search . '%');
        })->orWhere('imei', 'like', '%' . $this->search . '%')
            ->orWhere('estado', 'like', $this->search === "Equipo Disponible" ? '%STOCK%' : '%' . $this->search . '%')
            ->with('vehiculos', 'modelo')
            ->orderBy('id', 'desc')
            ->paginate(10);


        if ($this->estado == "VENDIDO") {

            $dispositivos = Dispositivos::whereHas('modelo', function ($query) {
                $query->where('marca', 'like', '%' . $this->search . '%')
                    ->orWhere('modelo', 'like', '%' . $this->search . '%');
            })->orwhereHas('vehiculos', function ($query) {
                $query->where('placa', 'like', '%' . $this->search . '%');
            })->orWhere('imei', 'like', '%' . $this->search . '%')
                ->vendido()
                ->with('vehiculos', 'modelo')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        if ($this->estado == "STOCK") {

            $dispositivos = Dispositivos::whereHas('modelo', function ($query) {
                $query->where('marca', 'like', '%' . $this->search . '%')
                    ->orWhere('modelo', 'like', '%' . $this->search . '%');
            })->orwhereHas('vehiculos', function ($query) {
                $query->where('placa', 'like', '%' . $this->search . '%');
            })->orWhere('imei', 'like', '%' . $this->search . '%')
                ->stock()
                ->with('vehiculos', 'modelo')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        return view('livewire.admin.dispositivos.dispositivos-index', compact('dispositivos'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function updated($name, $value)
    {
        dd($name, $value);
    }


    public function filter($estado)
    {
        $this->estado = $estado;
        $this->resetPage();
    }
}
