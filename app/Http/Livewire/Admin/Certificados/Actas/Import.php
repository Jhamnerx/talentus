<?php

namespace App\Http\Livewire\Admin\Certificados\Actas;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Certificados\ActasImport;
use Maatwebsite\Excel\Validators\ValidationException;

class Import extends Component
{

    use WithFileUploads;
    public $file;

    public $modalOpenImport = false;
    public Collection $errorInfo;
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

    public function mount()
    {
        $this->errorInfo = collect();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function render()
    {
        return view('livewire.admin.certificados.actas.import');
    }


    public function importExcel()
    {
        $this->validate();

        try {

            $import = Excel::queueImport(new ActasImport(Auth::user()), $this->file);

            $this->modalOpenImport = false;
            $this->reset('file');
        } catch (ValidationException $e) {

            $failures = $e->failures();
            foreach ($failures as $failure) {

                $errores = $failure->errors();
                $values = $failure->values();
                foreach ($errores as $key => $error) {
                    foreach ($values as $value) {
                        $this->errorInfo->push([
                            'errores' => $error,
                            'values' => $value,
                        ]);
                    }
                }

                $failure->row();
                $failure->attribute();
                $failure->errors();
                $failure->values();
            }
        }
    }

    public function openModal()
    {

        $this->modalOpenImport = true;
    }

    public function closeModal()
    {

        $this->modalOpenImport = false;
        $this->reset('file');
    }
}
