<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use App\Events\SimCardImportUpdated;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Notifications\Imports\ImportHasFailedNotification;

class LineasImport implements ToModel, WithChunkReading, SkipsOnError, ShouldQueue, SkipsOnFailure, WithEvents, WithValidation, WithHeadingRow, WithGroupedHeadingRow, SkipsEmptyRows
{
    use RegistersEventListeners, Importable;

    protected $importedBy;

    public function __construct(User $importedBy)
    {
        $this->importedBy = $importedBy;
    }


    public function model(array $fila)
    {

        if ($fila['numero'] != "no") {

            $linea = Lineas::create([
                'numero'    => $fila['numero'],
                'operador'    => $fila['operador'],
                'empresa_id'    => 1,
            ]);

            if ($linea) {

                SimCard::create([
                    'sim_card'    => $fila['sim_card'],
                    'operador'    => $fila['operador'],
                    'lineas_id' => $linea->id,
                    'empresa_id'    => 1,
                ]);
            }
        } else {

            SimCard::create([
                'sim_card'    => $fila['sim_card'],
                'operador'    => $fila['operador'],
                'empresa_id'    => 1,
            ]);
        }
    }
    public function rules(): array
    {
        $rules = [
            'numero' => 'required',
            'operador' => 'required',
            'sim_card' => 'required|unique:sim_card,sim_card',
            // 'empresa_id' => 'required',
        ];

        return $rules;
    }

    public function chunkSize(): int
    {
        return 100;
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
    public static function afterImport(AfterImport $event)
    {

        SimCardImportUpdated::dispatch();
    }

    public static function importFailed(ImportFailed $event)
    {
    }
    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }
}
