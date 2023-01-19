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
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Notifications\Imports\ImportHasFailedNotification;

class LineasImport implements ToCollection, WithChunkReading, ShouldQueue, SkipsOnFailure, WithEvents, WithValidation, WithHeadingRow, WithGroupedHeadingRow, SkipsEmptyRows
{
    use Queueable, RegistersEventListeners, Importable;

    protected $importedBy;

    public function __construct(User $importedBy)
    {
        $this->importedBy = $importedBy;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            $linea = Lineas::create([
                'numero'    => $row['numero'],
                'operador'    => $row['operador'],
                'empresa_id'    => 1,
            ]);

            if ($linea) {

                SimCard::create([
                    'sim_card'    => $row['sim_card'],
                    'operador'    => $row['operador'],
                    'lineas_id' => $linea->id,
                    'empresa_id'    => 1,
                ]);
            }
        }
    }

    public function rules(): array
    {
        $rules = [

            'numero' => 'required|unique:lineas,numero',
            'operador' => 'required',
            'sim_card' => 'unique:sim_card,sim_card',
        ];

        return $rules;
    }
    // public function model(array $row)
    // {
    //     //dd($row);
    //     return new SimCard([
    //         'sim_card'    => $row[0],
    //         'operador'    => $row[1],
    //         'empresa_id'    => 1 ,
    //     ]);
    // }

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
}
