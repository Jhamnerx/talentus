<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Imports\LineasImport;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component

{
    public $openModalImport = false;
    use WithFileUploads;
    public $file;
    public $errorInfo = null;


    protected $rules = [
        'file' => 'required|file|max:10024|mimes:xlsx,xls,csv',
    ];
    protected $messages = [
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
        return view('livewire.admin.lineas.import');
    }

    public function importExcel()
    {
        $this->validate();
        $this->errorInfo = null;
        try {
            $exit = Excel::import(new LineasImport, $this->file);
            session()->flash('import', 'Lineas importadas correctamente.');
            $this->emit('render');
            $this->openModalImport = false;
        } catch (Exception $e) {
            // dd($e);
            $this->errorInfo = $e->errorInfo["2"];
        }
    }
}
