# Sistema de Pagos de Compras a Proveedores

## 📦 Modelo: Compras + ExpensePayment

El sistema de pagos de compras a proveedores en **Talentus** utiliza:

```
Compras (factura de proveedor)
   ↓ (hasMany)
ExpensePayment (pagos de la compra)
   ↓ (via ExpensePaymentObserver)
GlobalPayment (movimiento financiero EGRESO)
   ↓
Cash.saldo_actual (se decrementa automáticamente)
```

---

## ✅ Flujo Completo Implementado

### 1. Crear Compra (ya existe en tu sistema)

```php
use App\Models\Compras;
use App\Models\ExpensePayment;

// Crear compra a proveedor
$compra = Compras::create([
    'serie' => 'F001',
    'numero' => '00123',
    'proveedor_id' => $proveedorId,
    'tipo_comprobante_id' => '01', // Factura
    'fecha_emision' => now(),
    'sub_total' => 1000.00,
    'igv' => 180.00,
    'total' => 1180.00,
    'estado' => 'COMPLETADO',
    'metodo_pago_id' => '003', // Transferencia (solo referencia)
    'user_id' => auth()->id(),
]);

// Crear items de la compra
Compras::createItems($items, $compra);
```

### 2. Registrar Pago(s) de la Compra

```php
use App\Models\ExpensePayment;

// Pago completo
$payment = ExpensePayment::create([
    'expense_id' => $compra->id,
    'date_of_payment' => now(),
    'expense_method_type_id' => 4, // Transferencia bancaria
    'has_card' => false,
    'reference' => 'TRANSF-001-2026',
    'payment' => 1180.00, // Total completo
]);

// ✅ Automático:
// - GlobalPayment creado con type_movement='EGRESO'
// - Descripción: "EGRESO - F001-00123 - Proveedor SAC"
// - Cash.saldo_actual decrementado (-1180.00)
```

### 3. Pagos Parciales (Abonos)

```php
// Primer abono: 50% del total
$pago1 = ExpensePayment::create([
    'expense_id' => $compra->id,
    'date_of_payment' => now(),
    'expense_method_type_id' => 1, // Caja general
    'payment' => 590.00, // 50%
]);

// Segundo abono después de 15 días: 50% restante
$pago2 = ExpensePayment::create([
    'expense_id' => $compra->id,
    'date_of_payment' => now()->addDays(15),
    'expense_method_type_id' => 4, // Transferencia
    'reference' => 'TRANSF-002-2026',
    'payment' => 590.00, // 50%
]);

// Verificar estado de pago
if ($compra->isPaid()) {
    echo "Compra completamente pagada";
}

// Total pagado: S/ 1,180.00
// Saldo pendiente: S/ 0.00
```

### 4. Pago con Tarjeta de Crédito/Débito

```php
use App\Models\CardBrand;

// Obtener marca de tarjeta (Visa, Mastercard, etc.)
$visa = CardBrand::where('description', 'LIKE', '%Visa%')->first();

$payment = ExpensePayment::create([
    'expense_id' => $compra->id,
    'date_of_payment' => now(),
    'expense_method_type_id' => 2, // Tarjeta de crédito
    'has_card' => true,
    'card_brand_id' => $visa->id,
    'reference' => 'VISA-1234-5678',
    'payment' => 1180.00,
]);

// ✅ Automático:
// - GlobalPayment con destination_id → BankAccount del usuario
// - Si no hay BankAccount del usuario → Cualquier BankAccount abierta
// - Si no hay BankAccount → Cash del usuario
```

---

## 📊 Consultas y Reportes

### Obtener Pagos de una Compra

```php
// Todos los pagos
$pagos = $compra->expensePayments;

// Último pago
$ultimoPago = $compra->expensePayments()->latest()->first();

// Total pagado (usando atributo)
$totalPagado = $compra->total_pagado;

// Saldo pendiente (usando atributo)
$saldoPendiente = $compra->saldo_pendiente;

// Verificar si está pagada
if ($compra->isPaid()) {
    echo "Pagada completamente";
} else {
    echo "Pendiente: S/ {$compra->saldo_pendiente}";
}
```

### Movimientos Financieros Globales

```php
// Todos los movimientos de la compra
$movimientos = $compra->globalPayments;

// Movimientos con detalles
$movimientos = $compra->globalPayments()
    ->with(['payment.expenseMethodType'])
    ->get();

foreach ($movimientos as $movimiento) {
    echo "Fecha: {$movimiento->created_at}\n";
    echo "Monto: S/ {$movimiento->payment->payment}\n";
    echo "Método: {$movimiento->payment->method_name}\n";
    echo "Destino: {$movimiento->destination_description}\n";
}
```

### Compras Pendientes de Pago

```php
// Compras con saldo pendiente
$comprasPendientes = Compras::all()->filter(function($compra) {
    return !$compra->isPaid();
});

// O usando query builder (más eficiente)
$comprasPendientes = Compras::whereDoesntHave('expensePayments', function($q) {
    $q->havingRaw('SUM(payment) >= compras.total');
})->get();
```

### Reporte de Pagos del Mes

```php
use App\Models\GlobalPayment;
use App\Models\ExpensePayment;

// Total pagado a proveedores este mes
$totalPagadoMes = GlobalPayment::where('type_movement', 'EGRESO')
    ->where('payment_type', ExpensePayment::class)
    ->whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year)
    ->sum('payment.payment'); // Relación polimórfica

// Pagos agrupados por método
$pagosPorMetodo = ExpensePayment::whereHas('expense', function($q) {
    $q->whereMonth('fecha_emision', now()->month);
})
->with('expenseMethodType')
->get()
->groupBy('expense_method_type_id')
->map(function($grupo) {
    return [
        'metodo' => $grupo->first()->method_name,
        'total' => $grupo->sum('payment'),
        'cantidad' => $grupo->count(),
    ];
});
```

### Compras por Proveedor

```php
// Total comprado y total pagado a un proveedor
$comprasProveedor = Compras::where('proveedor_id', $proveedorId)
    ->with('expensePayments')
    ->get();

$totalComprado = $comprasProveedor->sum('total');
$totalPagado = $comprasProveedor->sum('total_pagado');
$saldoPendiente = $totalComprado - $totalPagado;

echo "Total comprado: S/ {$totalComprado}\n";
echo "Total pagado: S/ {$totalPagado}\n";
echo "Saldo pendiente: S/ {$saldoPendiente}\n";
```

---

## 🎯 Métodos de Pago Disponibles

### ExpenseMethodType (expense_method_types)

| ID  | Descripción            | has_card | Uso               |
| --- | ---------------------- | -------- | ----------------- |
| 1   | CAJA GENERAL           | No       | Pagos en efectivo |
| 2   | Tarjeta de crédito     | Sí       | Pagos con TC      |
| 3   | Tarjeta de débito      | Sí       | Pagos con TD      |
| 4   | Transferencia bancaria | No       | Transferencias    |
| 5   | Cheque                 | No       | Pagos con cheque  |

### PaymentMethodType (payment_method_types - SUNAT)

23 métodos de pago SUNAT (solo para referencia en el comprobante):

- `001` - Depósito en cuenta
- `003` - Transferencia de fondos
- `005` - Tarjetas de débito
- `006` - Tarjetas de crédito
- `008` - Efectivo
- `009` - Efectivo (alternativo)
- etc.

**Importante**:

- `metodo_pago_id` en `compras` tabla → Solo referencia para SUNAT
- `expense_method_type_id` en `expense_payments` → Método real de pago que crea movimientos

### CardBrand (card_brands)

Marcas de tarjetas disponibles para pagos con TC/TD:

| ID  | Descripción                | Uso                 |
| --- | -------------------------- | ------------------- |
| 01  | Visa                       | Tarjeta Visa        |
| 02  | Mastercard                 | Tarjeta Mastercard  |
| 03  | American Express           | Tarjeta Amex        |
| 04  | Diners Club                | Tarjeta Diners      |
| 05  | Discover                   | Tarjeta Discover    |
| 06  | UnionPay                   | Tarjeta UnionPay    |
| 07  | JCB                        | Tarjeta JCB         |
| 08  | Oh! (Banco de Crédito BCP) | Tarjeta Oh! del BCP |
| 09  | Ripley                     | Tarjeta Ripley      |
| 10  | Cencosud                   | Tarjeta Cencosud    |
| 99  | Otros                      | Otras marcas        |

**Uso**: Requerido solo cuando `expense_method_type_id` es **2** (TC) o **3** (TD)

```php
// Ejemplo: Pago con tarjeta Visa
ExpensePayment::create([
    'expense_id' => $compra->id,
    'expense_method_type_id' => 2, // Tarjeta de crédito
    'has_card' => true,
    'card_brand_id' => '01', // Visa
    'payment' => 1180.00,
]);
```

---

## 🔄 Diferencias con Otros Documentos

| Documento              | Tipo              | Sistema de Pago  | Movimiento |
| ---------------------- | ----------------- | ---------------- | ---------- |
| **Compras**            | Factura proveedor | `ExpensePayment` | EGRESO     |
| **RecibosPagosVarios** | Vale de salida    | `Payments`       | EGRESO     |
| **Recibos**            | Cobro cliente     | `Payments`       | INGRESO    |
| **Ventas**             | Factura cliente   | `Payments`       | INGRESO    |

---

## 🛠️ Ejemplo: Componente Livewire

```php
// app/Livewire/Admin/Compras/RegistrarPago.php

use Livewire\Component;
use App\Models\Compras;
use App\Models\ExpensePayment;
use App\Models\ExpenseMethodType;
use App\Models\CardBrand;
use WireUi\Traits\WireUiActions;

class RegistrarPago extends Component
{
    use WireUiActions;

    public $compra;
    public $payment = 0;
    public $expense_method_type_id = 1;
    public $date_of_payment;
    public $reference = '';
    public $has_card = false;
    public $card_brand_id = null;

    public function mount(Compras $compra)
    {
        $this->compra = $compra;
        $this->payment = $compra->saldo_pendiente;
        $this->date_of_payment = now()->format('Y-m-d');
    }

    public function updatedExpenseMethodTypeId($value)
    {
        $metodo = ExpenseMethodType::find($value);
        $this->has_card = $metodo->requiresCard();

        if (!$this->has_card) {
            $this->card_brand_id = null;
        }
    }

    public function registrarPago()
    {
        $this->validate([
            'payment' => 'required|numeric|min:0.01|max:' . $this->compra->saldo_pendiente,
            'expense_method_type_id' => 'required|exists:expense_method_types,id',
            'date_of_payment' => 'required|date',
            'card_brand_id' => 'required_if:has_card,true|exists:card_brands,id',
        ], [
            'payment.max' => 'El monto no puede ser mayor al saldo pendiente',
        ]);

        DB::transaction(function () {
            ExpensePayment::create([
                'expense_id' => $this->compra->id,
                'date_of_payment' => $this->date_of_payment,
                'expense_method_type_id' => $this->expense_method_type_id,
                'has_card' => $this->has_card,
                'card_brand_id' => $this->card_brand_id,
                'reference' => $this->reference,
                'payment' => $this->payment,
            ]);

            $this->notification()->success('Pago registrado correctamente');
            $this->emit('pagoRegistrado');
            $this->reset(['payment', 'reference', 'card_brand_id']);
        });
    }

    public function render()
    {
        return view('livewire.admin.compras.registrar-pago', [
            'metodosPago' => ExpenseMethodType::all(),
            'cardBrands' => CardBrand::all(),
            'saldoPendiente' => $this->compra->saldo_pendiente,
            'totalPagado' => $this->compra->total_pagado,
        ]);
    }
}
```

### Vista Blade

```blade
{{-- resources/views/livewire/admin/compras/registrar-pago.blade.php --}}

<x-form.modal.card title="Registrar Pago de Compra" wire:model="showModal" max-width="2xl">
    {{-- Información de la compra --}}
    <div class="mb-4 p-4 bg-gray-50 rounded-lg dark:bg-gray-800">
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div>
                <span class="font-semibold">Comprobante:</span>
                {{ $compra->serie }}-{{ $compra->numero }}
            </div>
            <div>
                <span class="font-semibold">Proveedor:</span>
                {{ $compra->proveedor->nombre }}
            </div>
            <div>
                <span class="font-semibold">Total:</span>
                S/ {{ number_format($compra->total, 2) }}
            </div>
            <div>
                <span class="font-semibold text-green-600">Total Pagado:</span>
                S/ {{ number_format($totalPagado, 2) }}
            </div>
            <div class="col-span-2">
                <span class="font-semibold text-red-600">Saldo Pendiente:</span>
                S/ {{ number_format($saldoPendiente, 2) }}
            </div>
        </div>
    </div>

    {{-- Formulario de pago --}}
    <div class="grid grid-cols-2 gap-4">
        {{-- Monto del pago --}}
        <x-form.currency
            label="Monto a Pagar"
            wire:model="payment"
            prefix="S/"
            thousands="."
            decimal=","
        />

        {{-- Fecha del pago --}}
        <x-form.datetime.picker
            label="Fecha de Pago"
            wire:model="date_of_payment"
            without-time
        />

        {{-- Método de pago --}}
        <div class="col-span-2">
            <x-form.select
                label="Método de Pago"
                wire:model.live="expense_method_type_id"
                :options="$metodosPago"
                option-label="description"
                option-value="id"
            />
        </div>

        {{-- Marca de tarjeta (condicional) --}}
        @if ($has_card)
            <x-form.select
                label="Marca de Tarjeta"
                wire:model="card_brand_id"
                :options="$cardBrands"
                option-label="description"
                option-value="id"
                placeholder="Seleccione marca"
            />
        @endif

        {{-- Referencia --}}
        <x-form.input
            label="Referencia / N° Operación"
            wire:model="reference"
            placeholder="Opcional"
            :class="$has_card ? '' : 'col-span-2'"
        />
    </div>

    {{-- Historial de pagos --}}
    @if ($compra->expensePayments->count() > 0)
        <div class="mt-4">
            <h4 class="font-semibold mb-2">Historial de Pagos:</h4>
            <div class="space-y-2">
                @foreach ($compra->expensePayments as $pago)
                    <div class="flex justify-between text-sm p-2 bg-gray-50 rounded dark:bg-gray-800">
                        <div>
                            <span class="font-medium">{{ $pago->date_of_payment->format('d/m/Y') }}</span>
                            - {{ $pago->method_name }}
                            @if ($pago->reference)
                                <span class="text-gray-500">({{ $pago->reference }})</span>
                            @endif
                        </div>
                        <span class="font-semibold">S/ {{ number_format($pago->payment, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <x-slot name="footer">
        <x-form.button flat label="Cancelar" wire:click="$emit('closeModal')" />
        <x-form.button primary label="Registrar Pago" wire:click="registrarPago" />
    </x-slot>
</x-form.modal.card>
```

---

## 🔍 Verificación en Tinker

```php
// Buscar una compra
$compra = Compras::with('proveedor')->first();

// Ver información
echo "Comprobante: {$compra->serie}-{$compra->numero}\n";
echo "Proveedor: {$compra->proveedor->nombre}\n";
echo "Total: S/ {$compra->total}\n";

// Registrar pago
$pago = ExpensePayment::create([
    'expense_id' => $compra->id,
    'date_of_payment' => now(),
    'expense_method_type_id' => 1,
    'payment' => 500.00,
]);

// Verificar
echo "Total pagado: S/ {$compra->fresh()->total_pagado}\n";
echo "Saldo pendiente: S/ {$compra->fresh()->saldo_pendiente}\n";
echo "Está pagado? " . ($compra->fresh()->isPaid() ? 'Sí' : 'No') . "\n";

// Ver movimiento global creado
$globalPayment = $pago->globalPayment;
echo "Movimiento: {$globalPayment->type_movement}\n";
echo "Destino: {$globalPayment->destination_description}\n";
echo "Descripción: {$globalPayment->description}\n";
```

---

## ✅ Resumen

### Flujo Completo:

1. **Crear Compra** → Tabla `compras`
2. **Registrar Pago(s)** → Tabla `expense_payments`
3. **Observer automático** → Crea `GlobalPayment` con type_movement='EGRESO'
4. **Actualización automática** → Decrementa `Cash.saldo_actual`

### Relaciones del Modelo Compras:

```php
$compra->expensePayments;     // HasMany - Todos los pagos
$compra->globalPayments;      // HasManyThrough - Movimientos
$compra->total_pagado;        // Attribute - Suma de pagos
$compra->saldo_pendiente;     // Attribute - Saldo por pagar
$compra->isPaid();            // Method - ¿Está pagado?
```

### Métodos de Pago:

- **Efectivo** → ID 1 (CAJA GENERAL) → Destino: Cash
- **Tarjetas** → ID 2/3 (TC/TD) + card_brand_id → Destino: BankAccount
- **Transferencia** → ID 4 → Destino: BankAccount
- **Cheque** → ID 5 → Destino: BankAccount o Cash

---

**Sistema:** Talentus - Laravel 12  
**Fecha:** 27 de enero de 2026  
**Versión:** 1.0.0
