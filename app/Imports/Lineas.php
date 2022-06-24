<?php

namespace App\Imports;

use App\Models\Lineas as ModelsLineas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class Lineas implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // dd($row);
        return new ModelsLineas([
            'numero'    => $row[0],
            'operador'    => $row[1],
            'empresa_id'    => session('empresa'),
        ]);
    }
}
