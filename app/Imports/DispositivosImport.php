<?php

namespace App\Imports;

use App\Models\Dispositivos;
use Maatwebsite\Excel\Concerns\ToModel;

class DispositivosImport implements ToModel
{
    protected $id_model;

    function __construct($id)
    {
        $this->id_model = $id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Dispositivos([
            'imei'    => $row[0],
            'modelo_id'    => $this->id_model,
            'empresa_id'    => session('empresa'),
        ]);
    }
}
