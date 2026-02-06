<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cash;
use App\Models\Bank;
use App\Models\User;
use App\Models\BankAccount;
use App\Helpers\PaymentDestinationHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentDestinationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que getPaymentDestinations retorna solo cuentas bancarias cuando no hay caja abierta
     */
    public function test_payment_destinations_returns_only_bank_accounts_when_no_cash_open(): void
    {
        // Crear banco y cuenta bancaria
        $bank = Bank::factory()->create(['descripcion' => 'BANCO DE LA NACIÓN']);
        $bankAccount = BankAccount::factory()->create([
            'bank_id' => $bank->id,
            'numero_cuenta' => '123456789',
            'moneda' => 'PEN',
            'descripcion' => 'CUENTA CORRIENTE',
            'status' => true
        ]);

        $destinations = PaymentDestinationHelper::getPaymentDestinations();

        // Debe retornar 1 cuenta bancaria
        $this->assertCount(1, $destinations);

        $firstDestination = $destinations->first();
        $this->assertEquals($bankAccount->id, $firstDestination['id']);
        $this->assertEquals('bank', $firstDestination['type']);
        $this->assertEquals("BANCO DE LA NACIÓN - PEN - CUENTA CORRIENTE", $firstDestination['description']);
    }

    /**
     * Test que getPaymentDestinations retorna caja + cuentas bancarias cuando hay caja abierta
     */
    public function test_payment_destinations_returns_cash_and_banks_when_cash_is_open(): void
    {
        // Crear usuario y autenticar
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear caja abierta para el usuario
        $cash = Cash::factory()->create([
            'user_id' => $user->id,
            'estado' => true,
            'fecha_apertura' => now(),
            'saldo_inicial' => 100.00,
            'saldo_actual' => 100.00
        ]);

        // Crear cuenta bancaria
        $bank = Bank::factory()->create(['descripcion' => 'BBVA']);
        $bankAccount = BankAccount::factory()->create([
            'bank_id' => $bank->id,
            'moneda' => 'USD',
            'descripcion' => 'AHORROS',
        ]);

        $destinations = PaymentDestinationHelper::getPaymentDestinations();

        // Debe retornar 2 destinos: 1 cuenta bancaria + 1 caja
        $this->assertCount(2, $destinations);

        // Verificar que incluye la cuenta bancaria
        $bankDestination = $destinations->first();
        $this->assertEquals('bank', $bankDestination['type']);

        // Verificar que incluye la caja
        $cashDestination = $destinations->last();
        $this->assertEquals('cash', $cashDestination['id']);
        $this->assertEquals($cash->id, $cashDestination['cash_id']);
        $this->assertEquals('CAJA GENERAL', $cashDestination['description']);
    }

    /**
     * Test que getDestinationRecord retorna correctamente el destino tipo Cash
     */
    public function test_get_destination_record_returns_cash(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $cash = Cash::factory()->create([
            'user_id' => $user->id,
            'estado' => true,
        ]);

        $result = PaymentDestinationHelper::getDestinationRecord('cash');

        $this->assertEquals($cash->id, $result['destination_id']);
        $this->assertEquals(Cash::class, $result['destination_type']);
    }

    /**
     * Test que getDestinationRecord retorna correctamente el destino tipo BankAccount
     */
    public function test_get_destination_record_returns_bank_account(): void
    {
        $bank = Bank::factory()->create();
        $bankAccount = BankAccount::factory()->create(['bank_id' => $bank->id]);

        $result = PaymentDestinationHelper::getDestinationRecord($bankAccount->id);

        $this->assertEquals($bankAccount->id, $result['destination_id']);
        $this->assertEquals(BankAccount::class, $result['destination_type']);
    }
}
