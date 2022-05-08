<?php

namespace App\Imports;

use App\Models\Clientes;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Clientes([
            'razon_social'    => $row[0],
            'numero_documento' => $row[1],
            'telefono' => $row[2],
            'email' => $row[3],
            'direccion' => $row[4],
            'empresa_id'    => session('empresa'),
        ]);
    }
}
