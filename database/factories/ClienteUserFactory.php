<?php

namespace Database\Factories;

use App\Models\Clientes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClienteUser>
 */
class ClienteUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Clientes::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'rol' => 'titular',
            'estado' => 'aprobado',
            'telefono' => $this->faker->e164PhoneNumber(),
        ];
    }

    /**
     * Cuenta verificada por correo pero pendiente de aprobación del admin.
     */
    public function pendiente(): static
    {
        return $this->state(fn (array $attributes): array => [
            'estado' => 'pendiente',
        ]);
    }

    /**
     * Cuenta recién registrada, sin verificar el correo.
     */
    public function sinVerificar(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
            'estado' => 'pendiente',
        ]);
    }

    public function rechazado(): static
    {
        return $this->state(fn (array $attributes): array => [
            'estado' => 'rechazado',
        ]);
    }

    public function suspendido(): static
    {
        return $this->state(fn (array $attributes): array => [
            'estado' => 'suspendido',
        ]);
    }
}
