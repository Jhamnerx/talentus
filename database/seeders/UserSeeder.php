<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jhamner Rolando',
            'apellido' => 'Sifuentes Vasquez',
            'email' => 'jhamnerx1x@gmail.com',
            'tipo_documento' => 'DNI',
            'numero_documento' => '75103149',
            'direccion' => 'Trujillo',
            'telefonos' => '961482121',
            'birthday' => '17/03/1999',
            'is_client' => 'no',
            'password' => bcrypt('12345678'),
        ]);
        User::factory(9)->create();
    }
}
