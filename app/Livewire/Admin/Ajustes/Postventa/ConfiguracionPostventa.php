<?php

namespace App\Livewire\Admin\Ajustes\Postventa;

use App\Models\Empresa;
use Livewire\Component;

class ConfiguracionPostventa extends Component
{
    public int $dias = 30;

    public function mount(): void
    {
        $this->dias = (int) (Empresa::find(session('empresa'))?->postventa_dias_cliente_nuevo ?? 30);
    }

    protected function rules(): array
    {
        return [
            'dias' => 'required|integer|min:1|max:3650',
        ];
    }

    public function guardar(): void
    {
        $this->validate();

        $empresa = Empresa::find(session('empresa'));
        if ($empresa) {
            $empresa->postventa_dias_cliente_nuevo = $this->dias;
            $empresa->save();
        }

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CONFIGURACIÓN GUARDADA',
            mensaje: 'Días para considerar cliente nuevo actualizado.',
        );
    }

    public function render()
    {
        return view('livewire.admin.ajustes.postventa.configuracion-postventa');
    }
}
