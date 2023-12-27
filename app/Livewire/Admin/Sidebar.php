<?php

namespace App\Livewire\Admin;

use App\Models\Empresa;
use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        $empresa = Empresa::where('id', session('empresa'))->first();

        return view('livewire.admin.sidebar', compact('empresa'));
    }
}
