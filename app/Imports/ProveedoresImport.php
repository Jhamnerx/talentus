<?php

namespace App\Imports;

use App\Models\Proveedores;
use Maatwebsite\Excel\Concerns\ToModel;

class ProveedoresImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Proveedores([
            'razon_social'    => $row[0],
            'numero_documento' => $row[1],
            'telefono' => $row[2],
            'email' => $row[3],
            'web_site' => $row[4],
            'direccion' => $row[5],
            'empresa_id'    => session('empresa'),
        ]);
    }
}
