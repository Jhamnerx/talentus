<?php

namespace App\Http\Livewire\Admin\SimCard;

use Exception;
use Livewire\Component;
use App\Imports\LineasImport;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class Import extends Component
{
    use WithFileUploads;

    public $file;
    public $errorInfo = null;
    public $modalOpenImport = false;

    protected $listeners = [

        'openModalImport' => 'openModal',
    ];


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
        return view('livewire.admin.sim-card.import');
    }

    public function importExcel()
    {
        $this->validate();

        $this->errorInfo = null;

        try {

            $import = Excel::Import(new LineasImport(auth()->user()), $this->file);

            $this->modalOpenImport = false;
        } catch (ValidationException $e) {;
        }
    }


    public function openModal()
    {


        $this->modalOpenImport = true;
    }

    public function closeModal()
    {

        $this->modalOpenImport = false;
        $this->reset();
    }
}
