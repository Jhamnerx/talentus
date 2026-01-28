# Sistema de Pagos y Gastos - Talentus

## ✅ Implementación Completada

Se ha implementado exitosamente el sistema completo de pagos y gastos siguiendo la arquitectura de FactuPRO.

---

## 📊 Estructura de Tablas

### 1. `payment_method_types` (Catálogo SUNAT + Lógica de Negocio)

**Campos agregados:**

- `has_card` (boolean) - Si requiere tarjeta
- `number_days` (integer) - Días de crédito
- `charge` (decimal) - Comisión/recargo
- `is_credit` (boolean) - Si es a crédito
- `is_cash` (boolean) - Si es efectivo

**Uso:** Pagos de **INGRESOS** (Recibos, Ventas, Facturas)

**Ejemplo:**

```php
$paymentMethod = PaymentMethodType::find('005'); // Tarjeta de débito
echo $paymentMethod->hasCard(); // true
echo $paymentMethod->isCash(); // false
```

### 2. `expense_method_types` (Métodos para Gastos)

**Registros creados:**

- `1` - CAJA GENERAL
- `2` - Tarjeta de crédito (has_card=true)
- `3` - Tarjeta de débito (has_card=true)
- `4` - Transferencia bancaria
- `5` - Cheque

**Uso:** Pagos de **EGRESOS** (Compras, Gastos)

### 3. `expense_payments` (Pagos de Gastos)

**Campos:**

- `expense_id` (FK a compras)
- `date_of_payment` (fecha del pago)
- `expense_method_type_id` (FK a expense_method_types)
- `has_card` (si usa tarjeta)
- `card_brand_id` (marca de tarjeta, opcional)
- `reference` (número de operación)
- `payment` (monto)

---

## 🎯 Flujo de Trabajo

### Pago de Ingreso (Recibo/Venta)

```php
use App\Models\Payments;
use App\Models\Recibos;

// Crear recibo
$recibo = Recibos::create([...]);

// Crear pago (PaymentsObserver crea GlobalPayment automáticamente)
$payment = Payments::create([
    'paymentable_id' => $recibo->id,
    'paymentable_type' => Recibos::class,
    'payment_method_id' => '008', // Efectivo (payment_method_types)
    'monto' => 150.00,
    'fecha' => now(),
]);

// ✅ Automático:
// - GlobalPayment creado con type_movement='INGRESO'
// - Cash.saldo_actual incrementado (+150.00)
// - Destino determinado por payment_method_id
```

### Pago de Egreso (Compra/Gasto)

```php
use App\Models\ExpensePayment;
use App\Models\Compra;

// Crear compra
$compra = Compra::create([...]);

// Crear pago de gasto (ExpensePaymentObserver crea GlobalPayment automáticamente)
$expensePayment = ExpensePayment::create([
    'expense_id' => $compra->id,
    'date_of_payment' => now(),
    'expense_method_type_id' => 1, // CAJA GENERAL (expense_method_types)
    'has_card' => false,
    'payment' => 200.00,
]);

// ✅ Automático:
// - GlobalPayment creado con type_movement='EGRESO'
// - Cash.saldo_actual decrementado (-200.00)
// - Destino determinado por expense_method_type_id
```

---

## 🔄 Lógica de Destino Automático

### PaymentsObserver (Ingresos)

```
payment_method_id '008' o '009' (Efectivo)
→ Busca Cash del usuario → Cash abierta cualquiera → BankAccount

payment_method_id '001' o '003' (Depósito/Transferencia)
→ Busca BankAccount activa

payment_method_id '005', '006', '012', '013' (Tarjetas)
→ BankAccount activa

Otros → Cash abierta → BankAccount activa
```

### ExpensePaymentObserver (Egresos)

```
expense_method_type_id 1 (CAJA GENERAL)
→ Cash abierta

expense_method_type_id 2, 3 (Tarjetas)
→ BankAccount activa

expense_method_type_id 4 (Transferencia)
→ BankAccount activa

expense_method_type_id 5 (Cheque)
→ BankAccount activa

Otros → Cash abierta → BankAccount activa
```

---

## 📝 Modelos Actualizados

### PaymentMethodType

**Nuevos métodos:**

```php
$method->isCredit();      // Verifica si es crédito
$method->isCash();        // Verifica si es efectivo
$method->hasCard();       // Verifica si requiere tarjeta
$method->getCreditDays(); // Obtiene días de crédito
$method->getCharge();     // Obtiene comisión
$method->hasCharge();     // Si tiene comisión
```

### ExpenseMethodType

**Métodos:**

```php
$method->requiresCard();  // Si requiere tarjeta
$method->isCash();        // Si es caja (ID 1)
$method->isTransfer();    // Si es transferencia (ID 4)
```

### ExpensePayment

**Atributos virtuales:**

```php
$expensePayment->method_name;        // Nombre del método
$expensePayment->full_description;   // Descripción completa
```

**Métodos:**

```php
$expensePayment->usesCard();  // Si usa tarjeta
```

---

## 🗂️ Relaciones

### CashDocument

Ahora soporta `expense_payment_id`:

```php
$cashDoc = CashDocument::create([
    'cash_id' => 1,
    'expense_payment_id' => $expensePayment->id,
]);

// Relación
$expensePayment = $cashDoc->expensePayment;
```

### GlobalPayment

Soporta ambos tipos de pago:

```php
// Pago de ingreso
$globalPayment = GlobalPayment::where('payment_type', Payments::class)->first();

// Pago de egreso
$globalPayment = GlobalPayment::where('payment_type', ExpensePayment::class)->first();

// Acceder al pago original
$payment = $globalPayment->payment; // Polimórfico
```

---

## 🔍 Consultas Útiles

### Pagos de ingresos por método

```php
use App\Models\Payments;

$pagosTarjeta = Payments::whereHas('paymentMethod', function($q) {
    $q->where('has_card', true);
})->get();

$pagosEfectivo = Payments::whereHas('paymentMethod', function($q) {
    $q->where('is_cash', true);
})->get();
```

### Gastos por método

```php
use App\Models\ExpensePayment;

$gastosConTarjeta = ExpensePayment::whereHas('expenseMethodType', function($q) {
    $q->where('has_card', true);
})->get();

$gastosCaja = ExpensePayment::where('expense_method_type_id', 1)->get();
```

### Movimientos globales del día

```php
use App\Models\GlobalPayment;

$ingresos = GlobalPayment::where('type_movement', 'INGRESO')
    ->whereDate('created_at', today())
    ->sum('payment.payment'); // Polimórfico

$egresos = GlobalPayment::where('type_movement', 'EGRESO')
    ->whereDate('created_at', today())
    ->sum('payment.payment');
```

---

## ⚙️ Configuración Adicional

### Si necesitas crear un CardBrand

```php
// Migración
Schema::create('card_brands', function (Blueprint $table) {
    $table->id();
    $table->string('description'); // Visa, Mastercard, Amex, etc.
    $table->boolean('active')->default(true);
    $table->timestamps();
});

// Seeder
DB::table('card_brands')->insert([
    ['description' => 'Visa'],
    ['description' => 'Mastercard'],
    ['description' => 'American Express'],
    ['description' => 'Diners Club'],
]);
```

---

## 🎨 Componente Livewire para Pagos de Gastos

```php
// app/Livewire/Admin/Compras/RegistrarPago.php

use Livewire\Component;
use App\Models\ExpensePayment;
use App\Models\ExpenseMethodType;
use App\Models\Compra;

class RegistrarPago extends Component
{
    public $compra_id;
    public $expense_method_type_id;
    public $date_of_payment;
    public $payment;
    public $reference;
    public $has_card = false;
    public $card_brand_id;

    public function mount($compraId)
    {
        $this->compra_id = $compraId;
        $this->date_of_payment = now()->format('Y-m-d');
    }

    public function updatedExpenseMethodTypeId($value)
    {
        $method = ExpenseMethodType::find($value);
        $this->has_card = $method?->has_card ?? false;
    }

    public function registrarPago()
    {
        $this->validate([
            'expense_method_type_id' => 'required|exists:expense_method_types,id',
            'date_of_payment' => 'required|date',
            'payment' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:255',
            'card_brand_id' => 'required_if:has_card,true',
        ]);

        ExpensePayment::create([
            'expense_id' => $this->compra_id,
            'date_of_payment' => $this->date_of_payment,
            'expense_method_type_id' => $this->expense_method_type_id,
            'has_card' => $this->has_card,
            'card_brand_id' => $this->has_card ? $this->card_brand_id : null,
            'reference' => $this->reference,
            'payment' => $this->payment,
        ]);

        $this->notification()->success('Pago registrado correctamente');
        $this->reset(['payment', 'reference', 'card_brand_id']);
    }

    public function render()
    {
        return view('livewire.admin.compras.registrar-pago', [
            'metodosPago' => ExpenseMethodType::all(),
        ]);
    }
}
```

---

## 📦 Archivos Creados

### Migraciones

- `2026_01_27_000001_add_business_fields_to_payment_method_types.php`
- `2026_01_27_000002_create_expense_method_types_table.php`
- `2026_01_27_000003_create_expense_payments_table.php`

### Modelos

- `app/Models/ExpenseMethodType.php`
- `app/Models/ExpensePayment.php`

### Observers

- `app/Observers/ExpensePaymentObserver.php`

### Actualizados

- `app/Models/PaymentMethodType.php` - Casts y métodos helper
- `app/Models/CashDocument.php` - Relación con ExpensePayment

---

## ✅ Testing

```php
// tests/Feature/ExpensePaymentTest.php

use App\Models\ExpensePayment;
use App\Models\Compra;
use App\Models\GlobalPayment;
use App\Models\Cash;

test('crear pago de gasto crea global payment automáticamente', function () {
    $compra = Compra::factory()->create();

    $expensePayment = ExpensePayment::create([
        'expense_id' => $compra->id,
        'date_of_payment' => now(),
        'expense_method_type_id' => 1, // CAJA GENERAL
        'payment' => 100.00,
    ]);

    expect($expensePayment->globalPayment)->not->toBeNull();
    expect($expensePayment->globalPayment->type_movement)->toBe('EGRESO');
});

test('pago con caja decrementa saldo', function () {
    $cash = Cash::factory()->create(['saldo_actual' => 500.00, 'estado' => true]);
    $compra = Compra::factory()->create();

    ExpensePayment::create([
        'expense_id' => $compra->id,
        'date_of_payment' => now(),
        'expense_method_type_id' => 1,
        'payment' => 100.00,
    ]);

    expect($cash->fresh()->saldo_actual)->toBe(400.00);
});
```

---

## 🚀 Próximos Pasos

1. ✅ Crear componentes Livewire para registrar pagos de gastos
2. ✅ Implementar vista de historial de pagos por compra
3. ✅ Agregar validación de saldo en caja antes de crear pago
4. ✅ Crear reportes de flujo de caja (ingresos vs egresos)
5. ✅ Implementar conciliación bancaria

---

## 📚 Documentación de Referencia

- PaymentMethodType: Catálogo SUNAT con 23 métodos (001-999)
- ExpenseMethodType: 5 métodos internos personalizables
- Observers automáticos: PaymentsObserver + ExpensePaymentObserver
- GlobalPayment: Tabla central de movimientos financieros

---

**Fecha de implementación:** 27 de enero de 2026
**Versión:** 1.0.0
**Sistema:** Talentus - Laravel 12
