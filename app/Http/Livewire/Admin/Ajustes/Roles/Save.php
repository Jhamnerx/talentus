<?php

namespace App\Http\Livewire\Admin\Ajustes\Roles;

use Livewire\Component;

class Save extends Component
{
    public $openModalSave = false;

    protected $listeners = [
        'openModalSave' => 'openModal'
    ];
    
    public function render()
    {
        return view('livewire.admin.ajustes.roles.save');
    }
    public function openModal()
    {
        $this->openModalSave = true;
    }
}
