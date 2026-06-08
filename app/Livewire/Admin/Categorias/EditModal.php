<?php

namespace App\Livewire\Admin\Categorias;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\Attributes\On;
use App\Http\Requests\CategoriaRequest;
use WireUi\Traits\WireUiActions;

class EditModal extends Component
{
    use WireUiActions;

    public bool $modalEdit = false;
    public ?string $nombre = null;
    public ?string $descripcion = null;
    public bool $es_equipo_gps = false;
    public bool $es_servicio_monitoreo = false;
    public bool $es_accesorios = false;
    public bool $tieneProductos = false;
    public ?Categoria $categoria = null;

    public function render()
    {
        $empresaId = session('empresa');
        $equipoGpsOcupado  = Categoria::where('es_equipo_gps', true)
            ->where('empresa_id', $empresaId)
            ->when($this->categoria, fn($q) => $q->where('id', '!=', $this->categoria->id))
            ->first();
        $monitoreoOcupado  = Categoria::where('es_servicio_monitoreo', true)
            ->where('empresa_id', $empresaId)
            ->when($this->categoria, fn($q) => $q->where('id', '!=', $this->categoria->id))
            ->first();
        $accesoriosOcupado = Categoria::where('es_accesorios', true)
            ->where('empresa_id', $empresaId)
            ->when($this->categoria, fn($q) => $q->where('id', '!=', $this->categoria->id))
            ->first();

        return view('livewire.admin.categorias.edit-modal', compact('equipoGpsOcupado', 'monitoreoOcupado', 'accesoriosOcupado'));
    }

    #[On('open-modal-edit')]
    public function openModal(Categoria $categoria)
    {
        $this->resetValidation();
        $this->categoria             = $categoria;
        $this->nombre                = $categoria->nombre;
        $this->descripcion           = $categoria->descripcion;
        $this->es_equipo_gps         = (bool) $categoria->es_equipo_gps;
        $this->es_servicio_monitoreo = (bool) $categoria->es_servicio_monitoreo;
        $this->es_accesorios         = (bool) $categoria->es_accesorios;
        $this->tieneProductos        = $categoria->productos()->exists();
        $this->modalEdit             = true;
    }

    public function closeModal()
    {
        $this->modalEdit = false;
        $this->resetProp();
    }

    public function update()
    {
        $request = new CategoriaRequest();
        $datos = $this->validate($request->rules($this->categoria), $request->messages());

        // Si ya tiene productos, preservar los flags originales (no permitir modificarlos)
        // GPS y Monitoreo bloqueados si ya hay productos (afectan facturación)
        if ($this->tieneProductos) {
            unset($datos['es_equipo_gps'], $datos['es_servicio_monitoreo']);
        } else {
            if ($this->es_equipo_gps && Categoria::where('es_equipo_gps', true)->where('id', '!=', $this->categoria->id)->exists()) {
                $this->addError('es_equipo_gps', 'Ya existe una categoría configurada como Equipo GPS.');
                return;
            }
            if ($this->es_servicio_monitoreo && Categoria::where('es_servicio_monitoreo', true)->where('id', '!=', $this->categoria->id)->exists()) {
                $this->addError('es_servicio_monitoreo', 'Ya existe una categoría configurada como Servicio de Monitoreo.');
                return;
            }
        }

        // es_accesorios siempre editable (solo clasifica en almacén, no afecta facturación)
        if ($this->es_accesorios && Categoria::where('es_accesorios', true)->where('id', '!=', $this->categoria->id)->exists()) {
            $this->addError('es_accesorios', 'Ya existe una categoría configurada como Accesorios WorkOrder.');
            return;
        }

        try {
            $this->categoria->update($datos);

            $this->notification()->success(
                title: 'CATEGORIA ACTUALIZADA',
                description: 'La Categoria ' . $this->categoria->nombre . ' fue actualizada correctamente'
            );
            $this->closeModal();
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
        $this->reset(['nombre', 'descripcion', 'categoria', 'es_equipo_gps', 'es_servicio_monitoreo', 'es_accesorios', 'tieneProductos']);
    }
}
