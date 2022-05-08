<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use App\Imports\DispositivosImport;
use App\Models\ModelosDispositivo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component
{
    use WithFileUploads;
    public $file;
    public $modelo;
    public $modalOpen = false;

    protected $rules = [
        'file' => 'required|file|max:10024|mimes:xlsx,csv,csv',
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

        Excel::import(new DispositivosImport($this->modelo), $this->file);
        $this->modalOpen = false;
        $this->emit('render');
    }
}
