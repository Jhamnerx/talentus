<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Contactos;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactosFlotasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contactos::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre'  => $this->faker->unique()->name(),
            'clientes_id' => Clientes::all()->random()->id,
            'cargo' => 'Supervisor',
            'telefono' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->companyEmail(),
        ];
    }
}
