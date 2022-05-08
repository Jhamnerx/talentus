<?php

namespace App\Http\Livewire\Admin\Lineas;

use App\Imports\LineasImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component

{
    use WithFileUploads;
    public $file;


    protected $rules = [
        'file' => 'required|file|max:10024|mimes:xlsx,csv',
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

        Excel::import(new LineasImport, $this->file);

        $this->emit('render');
    }
}
