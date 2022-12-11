<?php

namespace App\Http\Livewire\Admin\GuiasRemision;

use App\Models\GuiaRemision;
use App\Models\Guias;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    public $detallePanelOpen = false;

    public function render()
    {
        $guias = GuiaRemision::whereHas('motivo', function ($query) {
            $query->where('descripcion', 'like', '%' . $this->search . '%');
        })->orWhere('serie_numero', 'like', '%' . $this->search . '%')
            ->orWhere('razon_social', 'like', '%' . $this->search . '%')
            ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('numero_documento', 'like', '%' . $this->search . '%')
            ->orWhere('code_puerto', 'like', '%' . $this->search . '%')
            ->orWhere('numero_contenedor', 'like', '%' . $this->search . '%')
            ->orWhere('ubigeo_partida', 'like', '%' . $this->search . '%')
            ->orWhere('ubigeo_llegada', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);


        return view('livewire.admin.guias-remision.index', compact('guias'));
    }


    public function openDetallePanel(GuiaRemision $guia)
    {

        $this->emit('DetallePanel', $guia);

        $this->setDetalleOpen();
    }

    public function setDetalleOpen()
    {
        $this->detallePanelOpen = true;
    }

    public function setDetalleClose()
    {
        $this->detallePanelOpen = false;
        sleep(5);
    }
}
