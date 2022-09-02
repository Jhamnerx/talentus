<?php

namespace App\Imports;

use App\Events\VehiculosImportUpdated;
use App\Models\Vehiculos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;

class VehiculosImport implements ToModel, WithChunkReading, WithEvents, ShouldQueue
{

    use Queueable, RegistersEventListeners;

    public function model(array $fila)
    {
        
        return new Vehiculos([
            'placa' => $fila[0],
            'marca' => $fila[1],
            'modelo' => $fila[2],
            'tipo' => $fila[3],
            'year' => $fila[4],
            'color' => $fila[5],
            'motor' => $fila[6],
            'serie' => $fila[7],
            'empresa_id' => 1,
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
        
        VehiculosImportUpdated::dispatch();

    }
}
