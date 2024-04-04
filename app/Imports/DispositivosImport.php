<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dispositivos;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Notifications\Imports\ImportHasFailedNotification;

class DispositivosImport implements ToModel, WithValidation, SkipsEmptyRows, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;
    protected $id_model;
    protected $importedBy;

    function __construct(User $importedBy, $id)
    {
        $this->id_model = $id;
        $this->importedBy = $importedBy;
    }

    public function model(array $row)
    {
        return new Dispositivos([
            'imei'    => $row["imei"],
            'modelo_id'    => $this->id_model,
            'empresa_id'    => session('empresa'),
        ]);
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

    public function rules(): array
    {
        $rules = [

            'imei' => 'required|unique:dispositivos,imei',
        ];

        return $rules;
    }
}
