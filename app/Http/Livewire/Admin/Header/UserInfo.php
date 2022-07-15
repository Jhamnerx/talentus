<?php

namespace App\Http\Livewire\Admin\Header;

use Livewire\Component;

class UserInfo extends Component
{

    protected $listeners = [
        'render' => 'render'
    ];


    public function render()
    {
        return view('livewire.admin.header.user-info');
    }
}
