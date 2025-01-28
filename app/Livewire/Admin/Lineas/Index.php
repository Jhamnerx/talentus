<?php

namespace App\Livewire\Admin\Lineas;

use App\Models\Lineas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    public $search;
    public $selected = [];


    protected $listeners = [

        'echo:sim,SimCardImportUpdated' => 'updateLineasToSimCard',
        'echo:lineas,LineasImportUpdated' => 'updateLineas'

    ];

    #[On('update-table', 'render')]
    public function updateTable()
    {
        $this->render();
    }

    #[On('suspend-save')]
    public function setSelectedNull()
    {
        $this->selected = [];
    }

    public function updateLineasToSimCard()
    {
        $this->render();
    }

    public function updateLineas()
    {
        $this->render();
        $this->dispatch('lineas-import');
    }

    public function render()
    {
        return view('livewire.admin.lineas.index');
    }


    public function openModalImport()
    {
        $this->dispatch('openModalImport');
    }

    public function consulta()
    {
        $lineas = Lineas::whereNotNull('old_sim_card')->get();
        foreach ($lineas as $linea) {

            $linea->old_sim_cards()->create([
                'old_sim_card' =>  $linea->old_sim_card,
                'user_id' => Auth::user()->id,
            ]);
        }
    }

    public function unSelect()
    {

        $this->selected = [];
    }

    public function openModalReporteLineas()
    {
        $this->dispatch('openModalReporteLineas');
    }

    public function openModalCreate()
    {
        $this->dispatch('open-modal-create');
    }
}
