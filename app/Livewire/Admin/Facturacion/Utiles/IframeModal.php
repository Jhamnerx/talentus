<?php

namespace App\Livewire\Admin\Facturacion\Utiles;

use Livewire\Attributes\On;
use Livewire\Component;

class IframeModal extends Component
{

    public $modalFrame = false;
    public $serie_correlativo = 'F001-132';
    public function render()
    {
        return view('livewire.admin.facturacion.utiles.iframe-modal');
    }

    #[On('ver-iframe-pdf')]
    public function openModal($serie_correlativo)
    {
        $this->serie_correlativo = $serie_correlativo;

        $this->modalFrame = true;
    }

    public function close()
    {
        $this->modalFrame = false;
    }
}
