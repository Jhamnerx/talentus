<?php

namespace App\Http\Livewire\Admin\Clientes;

use App\Imports\ClientesImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component
{
    use WithFileUploads;
    public $file;

    public $modalOpen = false;

    protected $rules = [
        'file' => 'required|file|max:10024|mimes:xlsx,csv,csv,xls',
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


        return view('livewire.admin.clientes.import');
    }

    public function importExcel()
    {
        $this->validate();

        Excel::import(new ClientesImport, $this->file);

        $this->emit('render');
    }
}
