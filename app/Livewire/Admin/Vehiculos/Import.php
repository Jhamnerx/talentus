<?php

namespace App\Livewire\Admin\Vehiculos;

use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\VehiculosImport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class Import extends Component
{
    use WithFileUploads;

    public $file;
    public $modalOpenImport = false;

    public Collection $errorInfo;

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

    public function updated($label)
    {
        $this->validateOnly($label);
    }

    public function render()
    {
        return view('livewire.admin.vehiculos.import');
    }
    public function afterImport()
    {
        $this->dispatch(
            'notify',
            icon: 'success',
            tittle: 'IMPORTANDO VEHICULOS',
            mensaje: 'los vehiculos empezaron a importarse'
        );

        $this->modalOpenImport = false;
        $this->reset('file');
    }

    public function importExcel()
    {
        $this->validate();

        try {

            Excel::import(new VehiculosImport(Auth::user()), $this->file);

            $this->afterImport();
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

    #[On('open-modal.import')]
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
