<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use App\Models\Sector;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public bool                  $openModal      = false;
    public ?PostventaPlantilla   $plantilla      = null;
    public ?int                  $sector_id      = null;
    public string                $cuerpo         = '';
    public bool                  $activo         = true;
    public                       $archivo        = null;
    public ?string               $archivoActual  = null;

    protected $listeners = ['openModalEditPlantilla' => 'open'];

    public function open(int $id): void
    {
        $plantilla             = PostventaPlantilla::findOrFail($id);
        $this->plantilla       = $plantilla;
        $this->sector_id       = $plantilla->sector_id;
        $this->cuerpo          = $plantilla->cuerpo;
        $this->activo          = $plantilla->activo;
        $this->archivoActual   = $plantilla->archivo_url;
        $this->archivo         = null;
        $this->openModal       = true;
        $this->resetErrorBag();
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
            'archivo'   => 'nullable|file|mimetypes:application/pdf,video/mp4,video/quicktime,video/x-msvideo|max:16384',
        ];
    }

    public function update(): void
    {
        $validated = $this->validate();

        $archivoUrl  = $this->plantilla->archivo_url;
        $archivoTipo = $this->plantilla->archivo_tipo;

        if ($this->archivo) {
            if ($archivoUrl) {
                Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $archivoUrl), '/'));
            }
            [$archivoUrl, $archivoTipo] = $this->almacenarArchivo();
        }

        $this->plantilla->update([
            'sector_id'    => $validated['sector_id'],
            'cuerpo'       => $validated['cuerpo'],
            'activo'       => $validated['activo'],
            'archivo_url'  => $archivoUrl,
            'archivo_tipo' => $archivoTipo,
        ]);

        $this->dispatch('notify-toast', icon: 'success', title: 'PLANTILLA ACTUALIZADA', mensaje: 'La plantilla fue actualizada.');
        $this->dispatch('update-table');
        $this->close();
    }

    /** @return array{string, string} */
    private function almacenarArchivo(): array
    {
        $path = $this->archivo->store('postventa', 'public');
        $tipo = strtolower($this->archivo->getClientOriginalExtension()) === 'pdf' ? 'pdf' : 'video';

        return ['/storage/' . $path, $tipo];
    }

    public function render()
    {
        $sectores = Sector::activos()->get();

        return view('livewire.admin.ajustes.postventa.plantillas.edit', compact('sectores'));
    }
}
