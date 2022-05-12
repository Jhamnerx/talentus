<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Imports\DispositivosImport;
use App\Models\ModelosDispositivo;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component
{
    use WithFileUploads;
    public $file;
    public $modelo;
    public $modalOpen = false;
    public $errorInfo = null;

    protected $rules = [
        'file' => 'required|file|max:10024|mimes:xlsx,xls,csv',
        'modelo' => 'required',
    ];
    protected $messages = [
        'file.required' => 'Debes seleccionar un archivo',
        'file.file' => 'Debes seleccionar un archivo',
        'file.max' => 'El tamaño maximo es de 10MB',
        'file.mimes' => 'Debe ser un archivo de Excel',
        'modelo.required' => 'Debe Seleccionar un modelo'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function render()
    {
        $modelos = ModelosDispositivo::all();

        return view('livewire.admin.dispositivos.import', compact('modelos'));
    }

    public function importExcel()
    {
        $this->validate();
        $this->errorInfo = null;


        try {
            Excel::import(new DispositivosImport($this->modelo), $this->file);
            $this->modalOpen = false;
            $this->emit('render');
        } catch (Exception $e) {

            $this->errorInfo = $e->errorInfo["2"];
        }
    }
}
