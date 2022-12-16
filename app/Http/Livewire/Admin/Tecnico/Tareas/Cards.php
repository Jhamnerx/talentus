<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;

class Cards extends Component
{

    protected $listeners = [
        'updateIndex' => 'render',
        'update-unread' => 'render',
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
        $this->emit('openModalWReading');
    }
    public function openTaskComplete()
    {
        $this->emit('openModalComplete');
    }
    public function openTaskPending()
    {
        $this->emit('openModalPending');
    }
    public function openTaskCanceled()
    {
        $this->emit('openModalCanceled');
    }
}
