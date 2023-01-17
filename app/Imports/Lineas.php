<?php

namespace App\Imports;

use App\Events\LineasImportUpdated;
use App\Models\Lineas as ModelsLineas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;

class Lineas implements ToModel, WithChunkReading, WithEvents, ShouldQueue
{

    use Queueable, RegistersEventListeners;


    public function model(array $row)
    {
        // dd($row);
        return new ModelsLineas([
            'numero'    => $row[0],
            'operador'    => $row[1],
            'empresa_id'    => session('empresa'),
        ]);
    }


    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {

        LineasImportUpdated::dispatch();
    }

    public static function importFailed(ImportFailed $event)
    {

        dd("fallo");
    }
}
