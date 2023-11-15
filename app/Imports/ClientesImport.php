<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Clientes;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Events\ClientesImportUpdated;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Jobs\AfterImportJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Livewire\Admin\Clientes\Import;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Livewire\Admin\Clientes\ClientesIndex;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Notifications\Imports\ImportHasFailedNotification;

class ClientesImport implements ToModel, WithChunkReading, SkipsOnFailure, WithEvents, ShouldQueue, WithGroupedHeadingRow, WithHeadingRow, WithValidation, SkipsEmptyRows
{

    use Queueable, RegistersEventListeners, Importable;

    protected $importedBy;

    public function __construct(User $importedBy)
    {
        $this->importedBy = $importedBy;
    }

    public function model(array $row)
    {
        return new Clientes([
            'razon_social'    => $row['razon_social'],
            'numero_documento' => $row['numero_documento'],
            'direccion' => $row['direccion'],
            'telefono' => $row['telefono'],
            'email' => $row['email'],
            'empresa_id' => 1,
        ]);
    }

    public function rules(): array
    {
        $rules = [

            'razon_social' => 'required',
            'numero_documento' => 'required|unique:clientes,numero_documento',
        ];

        return $rules;
    }

    public function onFailure(Failure ...$failures)
    {
        $errores = [];

        foreach ($failures as $failure) {
            $errores = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'value' => $failure->values()[$failure->attribute()],
                'error' => $failure->errors()[0],
            ];
        }

        $this->importedBy->notify(new ImportHasFailedNotification($errores));
    }

    public function chunkSize(): int
    {
        return 1000;
    }


    public static function beforeImport(BeforeImport $event)
    {
    }

    public static function afterImport(AfterImport $event)
    {

        ClientesImportUpdated::dispatch();
        //ClientesImportUpdated::dispatch();
        // $tabla = new ClientesIndex();
        // $tabla->render();

    }

    public static function beforeSheet(BeforeSheet $event)
    {
        // dd($event);
    }

    public static function afterSheet(AfterSheet $event)
    {
        //dd($event);
    }
}
