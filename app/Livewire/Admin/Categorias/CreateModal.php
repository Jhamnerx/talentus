<?php

namespace App\Livewire\Admin\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;
use App\Http\Requests\CategoriaRequest;
use WireUi\Traits\WireUiActions;

class CreateModal extends Component
{
    use WireUiActions;

    public $modalCreate = false;
    public $nombre, $descripcion;
    public bool $es_equipo_gps = false;
    public bool $es_servicio_monitoreo = false;

    public function render()
    {
        $empresaId = session('empresa');
        $equipoGpsOcupado   = Categoria::where('es_equipo_gps', true)->where('empresa_id', $empresaId)->first();
        $monitoreoOcupado   = Categoria::where('es_servicio_monitoreo', true)->where('empresa_id', $empresaId)->first();

        return view('livewire.admin.categorias.create-modal', compact('equipoGpsOcupado', 'monitoreoOcupado'));
    }

    #[On('open-modal-create')]
    public function openModal()
    {

        $this->resetValidation();
        $this->resetProp();
        $this->modalCreate = true;
    }

    public function closeModal()
    {
        $this->modalCreate = false;
        $this->resetProp();
    }

    public function save()
    {
        $request = new CategoriaRequest();
        $datos = $this->validate($request->rules(), $request->messages());

        // Validar exclusividad de flags
        if ($this->es_equipo_gps && Categoria::where('es_equipo_gps', true)->exists()) {
            $this->addError('es_equipo_gps', 'Ya existe una categoría configurada como Equipo GPS.');
            return;
        }
        if ($this->es_servicio_monitoreo && Categoria::where('es_servicio_monitoreo', true)->exists()) {
            $this->addError('es_servicio_monitoreo', 'Ya existe una categoría configurada como Servicio de Monitoreo.');
            return;
        }

        try {
            $categoria = Categoria::create($datos);
            $this->closeModal();
            $this->notification()->success(
                title: 'CATEGORIA REGISTRADA',
                description: 'La Categoria ' . $categoria->nombre . ' fue guardada correctamente'
            );
            $this->dispatch('categoria-saved');
            $this->resetProp();
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'ERROR',
                description: $th->getMessage()
            );
        }
    }

    public function resetProp()
    {
        $this->reset(['nombre', 'descripcion', 'es_equipo_gps', 'es_servicio_monitoreo']);
    }
}
