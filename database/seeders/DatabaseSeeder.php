<?php

namespace Database\Seeders;

use App\Models\Actas;

use App\Models\Certificados;
use App\Models\CertificadosVelocimetros;
use App\Models\Clientes;

use App\Models\Contactos;

use App\Models\Dispositivos;
use App\Models\Empresa;
use App\Models\Flotas;
use App\Models\Lineas;
use App\Models\Presupuestos;
use App\Models\Proveedores;
use App\Models\Recibos;
use App\Models\Reportes;
use App\Models\SimCard;
use App\Models\Vehiculos;
use App\Models\VentasFacturas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Storage::deleteDirectory("productos");
        $this->call(EmpresasSeeder::class);
        $this->call(PlantillaSeeder::class);
        Storage::makeDirectory("productos");

        //Categoria::factory(100)->create();
        Lineas::factory(60)->create();
        SimCard::factory(500)->create();
        $this->call(ProductoSeeder::class);
        $this->call(ModelosDispositivoSeeder::class);
        Clientes::factory(500)->create();
        Proveedores::factory(100)->create();
        Dispositivos::factory(50)->create();
       // ComprasFacturas::factory(50)->create();
        //Presupuestos::factory(40)->create();
       // VentasFacturas::factory(50)->create();
        //Recibos::factory(60)->create();
        // Contratos::factory(70)->create();

        Flotas::factory(10)->create();
        Contactos::factory(30)->create();
        Vehiculos::factory(50)->create();
        Reportes::factory(60)->create();
        $this->call(CiudadesSeeder::class);
        Actas::factory(60)->create();
        Certificados::factory(50)->create();
        CertificadosVelocimetros::factory(60)->create();
        $this->call(ContratoSeeder::class);
        $this->call(PermisosSeeder::class);
        $this->call(UserSeeder::class);
    }
}
