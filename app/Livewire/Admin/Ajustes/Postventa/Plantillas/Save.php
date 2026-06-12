<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use App\Models\Sector;
use Livewire\Component;
use Livewire\WithFileUploads;

class Save extends Component
{
    use WithFileUploads;

    public bool    $openModal   = false;
    public ?int    $sector_id   = null;
    public string  $cuerpo      = '';
    public bool    $activo      = true;
    public         $archivo     = null;

    protected $listeners = ['openModalSavePlantilla' => 'open'];

    public function open(): void
    {
        $this->reset();
        $this->activo    = true;
        $this->openModal = true;
    }

    public function close(): void
    {
        $this->openModal = false;
        $this->reset();
        $this->resetErrorBag();
    }

    protected function rules(): array
    {
        return [
            'sector_id' => 'nullable|exists:sectores,id',
            'cuerpo'    => 'required|string|max:2000',
            'activo'    => 'boolean',
            'archivo'   => 'nullable|file|mimes:pdf,mp4,mov,avi|max:16384',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        $archivoUrl  = null;
        $archivoTipo = null;

        if ($this->archivo) {
            $path       = $this->archivo->store('postventa', 'public');
            $archivoUrl = '/storage/' . $path;
            $extension  = strtolower($this->archivo->getClientOriginalExtension());
            $archivoTipo = $extension === 'pdf' ? 'pdf' : 'video';
        }

        PostventaPlantilla::create([
            'sector_id'    => $validated['sector_id'],
            'cuerpo'       => $validated['cuerpo'],
            'activo'       => $validated['activo'],
            'archivo_url'  => $archivoUrl,
            'archivo_tipo' => $archivoTipo,
        ]);

        $this->dispatch('notify-toast', icon: 'success', title: 'PLANTILLA CREADA', mensaje: 'La plantilla post-venta fue creada.');
        $this->dispatch('update-table');
        $this->close();
    }

    public function render()
    {
        $sectores = Sector::activos()->get();

        return view('livewire.admin.ajustes.postventa.plantillas.save', compact('sectores'));
    }
}
