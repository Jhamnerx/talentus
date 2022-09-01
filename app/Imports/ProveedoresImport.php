<?php

namespace App\Imports;

use App\Events\ProveedoresImportUpdated;
use App\Models\Proveedores;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;

class ProveedoresImport implements ToModel, WithChunkReading, WithEvents, ShouldQueue
{
    use Queueable, RegistersEventListeners;

    
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
            'direccion' => $row[2],
            'telefono' => $row[3],
            'email' => $row[4],
            'empresa_id' => 1,
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }


    public static function afterImport(AfterImport $event)
    {
        
        ProveedoresImportUpdated::dispatch();
        //ClientesImportUpdated::dispatch();
        // $tabla = new ClientesIndex();
        // $tabla->render();

    }


}
