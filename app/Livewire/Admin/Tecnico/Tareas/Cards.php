<?php

namespace App\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;

class Cards extends Component
{

    protected $listeners = [
        'updateIndex' => 'render',
        'update-unread' => 'render',
        'render-cancel' => 'render',
        'update-table-save-task' => 'render',
    ];

    public function render()
    {
        $totales = [

            'unread' => Tareas::estado('UNREAD')->get()->count(),
            'complete' => Tareas::estado('COMPLETE')->get()->count(),
            'pendient' => Tareas::estado('PENDIENT')->get()->count(),
            'canceled' => Tareas::estado('CANCELED')->get()->count(),

        ];
        return view('livewire.admin.tecnico.tareas.cards', compact('totales'));
    }

    public function openWithoutReading()
    {
        $this->dispatch('open-modal-unread');
    }
    public function openTaskComplete()
    {
        $this->dispatch('openModalComplete');
    }
    public function openTaskPending()
    {
        $this->dispatch('openModalPending');
    }
    public function openTaskCanceled()
    {
        $this->dispatch('openModalCanceled');
    }
}
