<?php

namespace App\Imports;

use App\Events\SimCardImportUpdated;
use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\ImportFailed;

class LineasImport implements ToCollection, WithChunkReading, WithEvents, ShouldQueue
{
    use Queueable, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {

        
            $linea = Lineas::create([
                'numero'    => $row[0],
                'operador'    => $row[2],
                'empresa_id'    => 1,
            ]);

            if ($linea) {

                SimCard::create([
                    'sim_card'    => $row[1],
                    'operador'    => $row[2],
                    'lineas_id' => $linea->id,
                    'empresa_id'    => 1 ,
                ]);
            }



        }
    }

    // public function model(array $row)
    // {
    //     //dd($row);
    //     return new SimCard([
    //         'sim_card'    => $row[0],
    //         'operador'    => $row[1],
    //         'empresa_id'    => 1 ,
    //     ]);
    // }

    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
        
        SimCardImportUpdated::dispatch();

    }

    public static function importFailed(ImportFailed $event){

        dd("fallo");
    }
}
