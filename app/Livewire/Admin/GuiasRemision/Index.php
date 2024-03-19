<?php

namespace App\Livewire\Admin\GuiasRemision;

use App\Models\GuiaRemision;
use App\Models\Guias;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $openModalDelete = false;
    public $detallePanelOpen = false;

    protected $listeners = [
        'updateTable' => 'render',
    ];

    public function render()
    {
        $guias = GuiaRemision::whereHas('motivoTraslado', function ($query) {
            $query->where('descripcion', 'like', '%' . $this->search . '%');
        })
            ->orWhereHas('cliente', function ($cliente) {
                $cliente->where('razon_social', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
            })
            ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
            ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%')
            ->orWhere('serie', 'like', '%' . $this->search . '%')
            ->orWhere('correlativo', 'like', '%' . $this->search . '%')
            ->orWhere('ubigeo_partida', 'like', '%' . $this->search . '%')
            ->orWhere('ubigeo_llegada', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);


        return view('livewire.admin.guias-remision.index', compact('guias'));
    }


    public function openDetallePanel(GuiaRemision $guia)
    {

        $guia->sim_cards;
        $this->dispatch('DetallePanel', $guia);

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

    public function openModalDelete(GuiaRemision $guia)
    {
        $this->dispatch('EliminarGuia', $guia);
        $this->openModalDelete = true;
    }
}
