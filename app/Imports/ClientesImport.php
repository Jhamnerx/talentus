<?php

namespace App\Imports;

use App\Events\ClientesImportUpdated;
use App\Http\Livewire\Admin\Clientes\ClientesIndex;
use App\Http\Livewire\Admin\Clientes\Import;
use App\Models\Clientes;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Jobs\AfterImportJob;

class ClientesImport implements ToModel, WithChunkReading, WithEvents, ShouldQueue, WithGroupedHeadingRow, WithHeadingRow
{

    use Queueable, RegistersEventListeners;

    public function model(array $row)
    {

        dd($row);
        //no añadir la primera linea
        // if (!isset($row[0])) {
        //     return null;
        // }

        // return new Clientes([
        //     'razon_social'    => $row['razon_social'],
        //     'numero_documento' => $row['numero_documento'],
        //     'direccion' => $row['direccion'],
        //     'telefono' => $row['telefono'],
        //     'email' => $row['email'],
        
        //     'empresa_id' => 1,
        // ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }


    public static function beforeImport(BeforeImport $event)
    {

    }
	
    public static function afterImport(AfterImport $event)
    {
        
        ClientesImportUpdated::dispatch();
        //ClientesImportUpdated::dispatch();
        // $tabla = new ClientesIndex();
        // $tabla->render();

    }

    public static function beforeSheet(BeforeSheet $event)
    {
       // dd($event);
    }

    public static function afterSheet(AfterSheet $event)
    {
       //dd($event);
    }
}
