<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use Livewire\Component;

class Cards extends Component
{
    public function render()
    {
        return view('livewire.admin.tecnico.tareas.cards');
    }

    public function openWithoutReading()
    {
        $this->emit('openModal');
    }
    public function openTaskComplete()
    {
        $this->emit('openModal');
    }
    public function openTaskPending()
    {
        $this->emit('openModal');
    }
    public function openTaskCanceled()
    {
        $this->emit('openModal');
    }
}
