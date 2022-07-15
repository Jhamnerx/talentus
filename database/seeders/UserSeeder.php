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
        $admin = User::create([
            'name' => 'Jhamner Sifuentes Vasquez',
            'email' => 'jhamnerx1x@gmail.com',
            'tipo_documento' => 'DNI',
            'numero_documento' => '75103149',
            'direccion' => 'Trujillo',
            'telefonos' => '961482121',
            'birthday' => '17/03/1999',
            'is_client' => 'no',
            'password' => bcrypt('12345678'),
        ]);



        User::create([
            'name' => 'Sandra Centurion',
            'email' => 'administracion@talentustechnology.com',
            'tipo_documento' => 'DNI',
            'numero_documento' => '000000',
            'direccion' => 'Cajamarca',
            'telefonos' => '944299794',
            'birthday' => '',
            'is_client' => 'no',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@talentus.com',
            'tipo_documento' => 'DNI',
            'numero_documento' => '000000',
            'direccion' => 'Cajamarca',
            'telefonos' => '987654654321',
            'birthday' => '',
            'is_client' => 'no',
            'password' => bcrypt('12345678'),
        ]);
        User::factory(8)->create();
    }
}
