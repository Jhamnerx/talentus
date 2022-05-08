<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'razon_social'  => $this->faker->name(),
            'numero_documento' => $this->faker->ean8(),
            'telefono' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->companyEmail(),
            'web_site' => $this->faker->safeEmailDomain(),
            'direccion' => $this->faker->address(),
            'empresa_id' => Empresa::all()->random()->id,

        ];
    }
}
