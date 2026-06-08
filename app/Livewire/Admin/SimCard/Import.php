<?php

namespace App\Livewire\Admin\SimCard;

use Exception;
use Livewire\Component;
use App\Imports\LineasImport;
use App\Models\Operador;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class Import extends Component
{
    use WithFileUploads;

    public $file;
    public $operadorId;
    public $sobrescribir = false;
    public $errorInfo = null;
    public $modalOpenImport = false;

    protected $listeners = [

        'openModalImport' => 'openModal',
    ];


    protected $rules = [
        'operadorId' => 'required|exists:operadores,id',
        'file' => 'required|file|max:10024|mimes:xlsx,xls,csv',
    ];



    protected $messages = [
        'operadorId.required' => 'Selecciona el operador de las líneas y sim cards a importar',
        'operadorId.exists' => 'Selecciona un operador válido',
        'file.required' => 'Debes seleccionar un archivo',
        'file.file' => 'Debes seleccionar un archivo',
        'file.max' => 'El tamaño maximo es de 10MB',
        'file.mimes' => 'Debe ser un archivo de Excel',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        $operadores = Operador::orderBy('name')->get();

        return view('livewire.admin.sim-card.import', compact('operadores'));
    }

    public function importExcel()
    {
        $this->validate();

        $this->errorInfo = null;

        try {

            $import = new LineasImport(auth()->user(), (int) $this->operadorId, (bool) $this->sobrescribir);

            Excel::import($import, $this->file);

            $resumen = $import->resumen();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'IMPORTACIÓN COMPLETADA',
                mensaje: "Creados: {$resumen['creados']} · Asignados: {$resumen['asignados']} · Omitidos: {$resumen['omitidos']}",
            );

            $this->modalOpenImport = false;
            $this->reset('file', 'sobrescribir', 'errorInfo');
        } catch (ValidationException $e) {;
        }
    }

    #[On('open-modal-import')]
    public function openModal()
    {

        $this->modalOpenImport = true;
    }

    public function closeModal()
    {

        $this->modalOpenImport = false;
        $this->reset('file', 'errorInfo');
        $this->reset();
    }
}
