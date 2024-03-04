<?php

namespace App\Livewire\Admin\Solicitudes;

use App\Models\Solicitudes;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;


    public function render()
    {
        $solicitudes = Solicitudes::where(function ($query) {
            $query->where('numero', 'like', '%' . $this->search . '%')
                ->orwhere('nombre', 'like', '%' . $this->search . '%')
                ->orwhere('tipo_solicitud', 'like', '%' . $this->search . '%')
                ->orwhere('placa', 'like', '%' . $this->search . '%')
                ->orwhere('telefono_envio', 'like', '%' . $this->search . '%')
                ->orwhere('email', 'like', '%' . $this->search . '%')
                ->orwhere('email_envio', 'like', '%' . $this->search . '%')
                ->orwhere('email', 'like', '%' . $this->search . '%');
        })->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.solicitudes.index', compact('solicitudes'));
    }

    public function markComplete(Solicitudes $solicitud)
    {

        $solicitud->estado = true;
        $solicitud->save();
        $this->dispatch('update-solicitud', ['titulo' => 'SOLICITUD COMPLETADA', 'message' => 'Se marco como completada la solicitud',  'numero' => $solicitud->numero, 'color' => '#34d399', 'progressBarColor' => 'rgb(255,255,255)']);
        $this->render();
    }
}
