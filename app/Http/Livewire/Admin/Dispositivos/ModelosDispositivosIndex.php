<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Models\ModelosDispositivo;
use Livewire\Component;

class ModelosDispositivosIndex extends Component
{
    public $search;
    public function render()
    {
        $modelos = ModelosDispositivo::where('modelo', 'like', '%' . $this->search . '%')
            ->orwhere('marca', 'like', '%' . $this->search . '%')
            ->orwhere(
                function ($query) {
                    return $query
                        ->where('certificado', 'like', '%' . $this->search . '%');
                }
            )
            ->paginate(10);

        return view('livewire.admin.dispositivos.modelos-dispositivos-index', compact('modelos'));
    }
}
