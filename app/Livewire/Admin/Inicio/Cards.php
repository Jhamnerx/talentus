<?php

namespace App\Livewire\Admin\Inicio;

use App\Models\Clientes;
use App\Models\Dispositivos;
use App\Models\Flotas;
use App\Models\Vehiculos;
use Carbon\Carbon;
use Livewire\Component;

class Cards extends Component
{




    public function render()
    {

        $clientes = Clientes::all();
        $clientes_hoy = Clientes::whereDate('created_at', Carbon::now())->get();
        $vehiculos = Vehiculos::all();
        $vehiculos_hoy = Vehiculos::whereDate('created_at', Carbon::now())->get();
        $flotas = Flotas::all();
        $flotas_hoy = Flotas::whereDate('created_at', Carbon::now())->get();





        $totales = [
            'clientes-total' => $clientes->count(),
            'clientes-hoy' => $clientes_hoy->count(),
            'vehiculos-total' => $vehiculos->count(),
            'vehiculos-hoy' => $vehiculos_hoy->count(),
            'flotas-total' => $flotas->count(),
            'flotas-hoy' => $flotas_hoy->count()
        ];


        return view('livewire.admin.inicio.cards', compact('totales'));
    }


    public function toClientes()
    {

        return redirect()->route('admin.clientes.index');
    }
    public function toVehiculos()
    {

        return redirect()->route('admin.vehiculos.index');
    }
    public function toFlotas()
    {

        return redirect()->route('admin.vehiculos.flotas.index');
    }
}
