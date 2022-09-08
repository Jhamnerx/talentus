<?php

namespace App\Http\Livewire\Admin\Inicio;

use App\Models\User;
use Livewire\Component;

class Avatars extends Component
{

    public function render()
    {
        $usuarios = User::latest()
                    ->take(4)
                    ->get();

        return view('livewire.admin.inicio.avatars', compact('usuarios'));
    }


    public function AddNewUser(){

        dd('añadir nuevo usuario modal');
    }
}
