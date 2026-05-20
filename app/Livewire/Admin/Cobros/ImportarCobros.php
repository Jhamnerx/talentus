<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Cobros;

use App\Imports\CobrosImport;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use WireUi\Traits\WireUiActions;

class ImportarCobros extends Component
{
    use WithFileUploads, WireUiActions;

    public bool $modalOpen = false;

    public $archivo = null;

    public ?int  $importados = null;
    public ?int  $omitidos   = null;
    public array $errores    = [];

    protected $rules = [
        'archivo' => 'required|file|max:10240',
    ];

    protected $messages = [
        'archivo.required' => 'Selecciona un archivo Excel.',
        'archivo.max'      => 'El archivo no debe superar 10 MB.',
    ];

    protected $listeners = ['abrirImportarCobros' => 'abrir'];

    public function abrir(): void
    {
        $this->reset(['archivo', 'importados', 'omitidos', 'errores']);
        $this->modalOpen = true;
    }

    public function cerrar(): void
    {
        $this->modalOpen = false;
        $this->reset(['archivo', 'importados', 'omitidos', 'errores']);
    }

    public function importar(): void
    {
        $this->validate();

        if (! $this->archivo) {
            $this->notification()->error(title: 'Error', description: 'No se recibió el archivo.');
            return;
        }

        try {
            $empresaId = (int) session('empresa');

            if (! $empresaId) {
                $this->notification()->error(title: 'Error', description: 'Sesión de empresa no encontrada.');
                return;
            }

            $import = new CobrosImport($empresaId);

            Excel::import($import, $this->archivo->getRealPath());

            $this->importados = $import->importados;
            $this->omitidos   = $import->omitidos;
            $this->errores    = $import->errores;

            $this->archivo = null;

            // if ($this->importados > 0) {
            //     $this->dispatch('cobrosImportados');
            // }
        } catch (\Throwable $e) {
            Log::error('CobrosImport error: ' . $e->getMessage());
            $this->notification()->error(
                title: 'Error al importar',
                description: $e->getMessage(),
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.cobros.importar-cobros');
    }
}
