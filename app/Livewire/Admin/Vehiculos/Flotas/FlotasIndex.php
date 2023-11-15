<?php

namespace App\Livewire\Admin\Vehiculos\Flotas;

use App\Models\Flotas;
use Livewire\Component;
use Livewire\WithPagination;
class FlotasIndex extends Component
{
    use WithPagination;
    public $search;
    public $sort = "id";
    public $direction = "desc";

    protected $listeners = ['render' => 'render'];

    public function render()
    {

        $flotas = Flotas::whereHas('clientes', function ($query) {
            $query->where('razon_social', 'like', '%' . $this->search . '%');
        })->orWhere('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        // ->get();
        return view('livewire.admin.vehiculos.flotas.flotas-index', compact('flotas'));
    }
}
