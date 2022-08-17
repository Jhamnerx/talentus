<?php

namespace App\Http\Livewire\Admin\Usuarios;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
class Index extends Component
{
    use WithPagination;
    public $search;
    public $from = '';
    public $to = '';
    protected $listeners = [
        'render' => 'render',
    ];
    public function render()
    {
        $usuarios = User::Where('name', 'like', '%' . $this->search . '%')
            ->where('email', '<>', 'jhamnerx1x@gmail.com')
            ->orderBy('id', 'desc')
            ->paginate(10);
            
        $total = User::all()->count()-1;
        return view('livewire.admin.usuarios.index', compact('usuarios', 'total'));
    }
}
