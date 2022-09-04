<?php

namespace App\Http\Livewire\Admin\Vehiculos;

use App\Imports\VehiculosImport;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component
{
    use WithFileUploads;

    public $file;
    public $modalOpenImport = false;

    protected $listeners = [
        
        'openModalImport' => 'openModal',
    ];

    protected $rules = [
        'file' => 'required|file|max:10024|mimes:xlsx,csv,csv,xls',
    ];
    protected $messages = [
        'file.required' => 'Debes seleccionar un archivo',
        'file.file' => 'Debes seleccionar un archivo',
        'file.max' => 'El tamaño maximo es de 10MB',
        'file.mimes' => 'Debe ser un archivo de Excel',
    ];

    public function updated($label)
    {
        $this->validateOnly($label);
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.import');
    }

    
    public function importExcel()
    {
        $this->validate();

        try {

            $import = Excel::queueImport(new VehiculosImport, $this->file);
            $this->reset();


        } catch (Exception $e) {
            //dd($e);
            $e->getMessage();

        }finally{

           $this->modalOpenImport = false;

        }
    }

    public function openModal(){

        $this->modalOpenImport = true;

    }

    public function closeModal(){

        $this->modalOpenImport = false;
        $this->reset();
    }


}
