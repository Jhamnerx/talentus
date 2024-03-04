<?php

namespace App\Livewire\Admin\Vehiculos\Flotas;

use App\Models\Flotas;
use Livewire\Component;
use App\Models\Eliminados;
use Livewire\Attributes\On;
use App\Models\ChangesModels;
use Illuminate\Database\Eloquent\Model;

class Delete extends Component
{

    public Flotas $flota;
    public $modalDelete = false;


    #[On('open-modal-delete')]
    public function openModal(Flotas $flota)
    {
        $this->flota = $flota;
        $this->modalDelete = true;
    }

    public function delete()
    {
        $this->flota->delete();

        // ChangesModels::create([
        //     'delete_id' => $this->flota->id,
        //     'delete_type' => Flotas::class,
        //     'user_id' => auth()->user()->id,
        // ]);

        $this->afterDelete();
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.flotas.delete');
    }
    public function closeModal()
    {

        $this->modalDelete = false;
    }

    public function afterDelete()
    {
        $this->closeModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'CATEGORIA ELIMINADA',
            mensaje: 'se elimino correctamente la categoria'
        );
        $this->dispatch('update-table');
    }
}
