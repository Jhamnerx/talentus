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
            'archivo'   => 'nullable|file|mimetypes:application/pdf,video/mp4,video/quicktime,video/x-msvideo|max:16384',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        [$archivoUrl, $archivoTipo] = $this->archivo
            ? $this->almacenarArchivo()
            : [null, null];

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

        return view('livewire.admin.ajustes.postventa.plantillas.save', compact('sectores'));
    }
}
