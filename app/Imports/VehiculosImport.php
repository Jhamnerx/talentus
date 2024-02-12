<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Clientes;
use App\Models\Vehiculos;

use App\Scopes\EmpresaScope;
use Illuminate\Bus\Queueable;
use App\Events\VehiculosImportUpdated;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Notifications\Imports\ImportHasFailedNotification;

class VehiculosImport implements ToModel, ShouldQueue, SkipsOnFailure, WithEvents, WithChunkReading, WithValidation, WithHeadingRow, WithGroupedHeadingRow, SkipsEmptyRows
{

    use RegistersEventListeners, Importable, Queueable;

    protected $importedBy;

    public function __construct(User $importedBy)
    {
        $this->importedBy = $importedBy;
    }

    public function model(array $fila)
    {

        $clientes_id = Clientes::withoutGlobalScope(EmpresaScope::class)->where('numero_documento', '=', $fila['numero_documento'])->first()->id;

        return new Vehiculos([
            'placa' => $fila['placa'],
            'marca' => $fila['marca'],
            'modelo' => $fila['modelo'],
            'tipo' => $fila['tipo'],
            'year' => $fila['year'],
            'color' => $fila['color'],
            'motor' => $fila['motor'],
            'serie' => $fila['serie'],
            'clientes_id' => $clientes_id,
            'empresa_id' => 1,
        ]);
    }

    public function rules(): array
    {
        $rules = [

            'placa' => 'required|unique:vehiculos,placa',
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

    public static function afterImport(AfterImport $event)
    {

        VehiculosImportUpdated::dispatch();
    }
}
