<?php

namespace App\Imports\Certificados;

use App\Models\User;
use App\Models\Actas;
use App\Models\Ciudades;
use App\Models\Vehiculos;
use App\Scopes\EmpresaScope;
use Illuminate\Bus\Queueable;
use Vinkla\Hashids\Facades\Hashids;
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

class ActasImport implements ToModel, ShouldQueue, SkipsOnFailure, WithEvents, WithChunkReading, WithValidation, WithHeadingRow, WithGroupedHeadingRow, SkipsEmptyRows
{

    use RegistersEventListeners, Importable, Queueable;

    protected $importedBy;

    public function __construct(User $importedBy)
    {
        $this->importedBy = $importedBy;
    }



    public function model(array $fila)
    {

        $vehiculos_id = Vehiculos::withoutGlobalScope(EmpresaScope::class)->where('placa', '=', $fila['placa'])->first()->id;
        //dd($vehiculos_id, $fila['placa']);
        $ciudades_id = Ciudades::where('prefijo', '=', $fila['prefijo_ciudad'])->first()->id;

        return new Actas([
            'vehiculos_id' => $vehiculos_id,
            'numero' => $fila['numero'],
            'inicio_cobertura' => $fila['inicio_cobertura'],
            'fin_cobertura' => $fila['fin_cobertura'],
            'fecha' => $fila['fecha'],
            'year' => $fila['year'],
            'sello' => $fila['sello'],
            'fondo' => $fila['fondo'],
            'codigo' => $fila['codigo'],
            'ciudades_id' => $ciudades_id,
            'unique_hash' => Hashids::connection(Actas::class)->encode($this->generateUniqueCode()),
            'empresa_id' => 1,
        ]);
    }
    public function generateUniqueCode()
    {
        do {
            $code = random_int(1, 500);
        } while (Actas::where("id", "=", $code)->first());

        return $code;
    }
    public function rules(): array
    {
        $rules = [
            'placa' => 'required',
            'prefijo_ciudad' => 'required|exists:ciudades,prefijo',
            'inicio_cobertura' => 'required|date',
            'fin_cobertura' => 'required|date',
        ];

        return $rules;
    }

    public function onFailure(Failure ...$failures)
    {
        $errores = [];

        foreach ($failures as $failure) {

            // dd($failure->row(), $failure->attribute(), $failure->values()[$failure->attribute()], $failure->errors()[0]);

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
        return 500;
    }

    public static function afterImport(AfterImport $event)
    {
    }
}
