<?php

namespace Database\Seeders;

use App\Models\PaymentMethods;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethods::create(
            [
                'name' => 'DEPOSITO EN CTA',
                'empresas_id' => 1,
            ],
            [
                'name' => 'DEPOSITO EN CTA CORRIENTE',
                'empresas_id' => 1,
            ],
            [
                'name' => 'DEPOSITO EN AGENTE',
                'empresas_id' => 1,
            ],

        );
    }
}
