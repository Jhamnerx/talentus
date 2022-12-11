<?php

namespace App\Http\Livewire\Admin\Dispositivos;

use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ModelosDispositivo;
use App\Imports\DispositivosImport;
use Collator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class Import extends Component
{
    use WithFileUploads;
    public $file;
    public $modelo;
    public $modalOpen = false;
    public Collection $errorInfo;

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
        $modelos = ModelosDispositivo::all();

        return view('livewire.admin.dispositivos.import', compact('modelos'));
    }

    public function importExcel()
    {
        $this->validate();
        //$this->errorInfo = [];

        try {

            $excel = Excel::import(new DispositivosImport($this->modelo), $this->file);
            $this->modalOpen = false;
            $this->emit('render');
        } catch (ValidationException $e) {;
            $failures = $e->failures();
            foreach ($failures as $failure) {

                // $this->errorInfo->push(
                //     [
                //         'row' => $failure->row(),
                //         'attribute' => $failure->attribute(),
                //         'errors' => $failure->errors(),
                //         'values' => $failure->values(),
                //     ]
                // );
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

                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            ///dd($this->errorInfo);
        }
    }
}
