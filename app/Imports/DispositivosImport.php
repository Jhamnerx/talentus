<?php

namespace App\Imports;

use App\Models\Dispositivos;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DispositivosImport implements ToModel, WithValidation, SkipsEmptyRows, WithHeadingRow
{
    use Importable;
    protected $id_model;

    function __construct($id)
    {
        $this->id_model = $id;
    }

    public function model(array $row)
    {
        return new Dispositivos([
            'imei'    => $row["imei"],
            'modelo_id'    => $this->id_model,
            'empresa_id'    => session('empresa'),
        ]);
    }

    public function rules(): array
    {
        $rules = [

            'imei' => 'required|unique:dispositivos,imei',
        ];

        return $rules;
    }
}
