<?php

namespace App\Imports;


use App\Models\SimCard;
use Maatwebsite\Excel\Concerns\ToModel;

class LineasImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        return new SimCard([
            'sim_card'    => $row[0],
            'operador'    => $row[1],
            'empresa_id'    => session('empresa'),
        ]);
    }
}
