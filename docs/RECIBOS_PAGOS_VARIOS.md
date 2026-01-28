# RecibosPagosVarios - Sistema de Salidas/Egresos

## 📋 ¿Qué es RecibosPagosVarios?

`RecibosPagosVarios` es un modelo de **Talentus** que representa **RECIBOS DE EGRESO** (salidas de efectivo), diferente a:

- **Recibos** (de ingreso) - Cobros a clientes
- **Compras** (facturas de proveedores) - Gastos con factura

### Ejemplos de uso:

- ✅ Vales de caja chica
- ✅ Adelantos a empleados
- ✅ Reembolsos
- ✅ Pagos varios sin factura
- ✅ Gastos menores
- ✅ Viáticos

---

## 🔄 Comparación: FactuPRO vs Talentus

### FactuPRO: Sistema de Gastos

```
Expense (gasto con factura)
   ↓ (hasMany)
ExpensePayment (pagos del gasto)
   ↓ (morphOne, via Observer)
GlobalPayment (movimiento financiero EGRESO)
```

**Características:**

- Un gasto puede tener MÚLTIPLES pagos (abonos)
- Cada pago crea un GlobalPayment
- Soporta pagos a crédito con historial

### Talentus: Sistema de Recibos de Egreso

```
RecibosPagosVarios (recibo de salida)
   ↓ (morphMany)
Payments (registro del pago)
   ↓ (via PaymentsObserver)
GlobalPayment (movimiento financiero EGRESO)
```

**Características:**

- Un recibo = un documento de salida
- Puede tener múltiples pagos (similar a FactuPRO)
- Automáticamente crea GlobalPayment como EGRESO
- Actualiza saldo de caja automáticamente

---

## 🛠️ Uso en Talentus

### 1. Crear Recibo de Egreso con Pago

```php
use App\Models\RecibosPagosVarios;
use App\Models\Payments;

// Crear el recibo de egreso
$recibo = RecibosPagosVarios::create([
    'serie' => 'RE',
    'numero' => '001',
    'clientes_id' => 123,
    'fecha_emision' => now(),
    'fecha_pago' => now(),
    'total' => 150.00,
    'moneda' => 'PEN',
    'estado' => 'COMPLETADO',
    'pago_estado' => 'PAID',
    'concepto' => 'Adelanto de sueldo',
]);

// Crear el pago (PaymentsObserver crea GlobalPayment automáticamente)
$payment = Payments::create([
    'paymentable_id' => $recibo->id,
    'paymentable_type' => RecibosPagosVarios::class,
    'payment_method_id' => '009', // Efectivo
    'monto' => 150.00,
    'fecha' => now(),
]);

// ✅ Automático:
// - GlobalPayment creado con type_movement='EGRESO'
// - Cash.saldo_actual decrementado (-150.00)
// - Descripción: "EGRESO - 001 - Juan Pérez"
```

### 2. Recibo de Egreso con Pagos Parciales

```php
$recibo = RecibosPagosVarios::create([
    'total' => 500.00,
    'pago_estado' => 'UNPAID',
    // ... otros campos
]);

// Pago 1: 200 en efectivo
Payments::create([
    'paymentable_id' => $recibo->id,
    'paymentable_type' => RecibosPagosVarios::class,
    'payment_method_id' => '009',
    'monto' => 200.00,
    'fecha' => now(),
]);

// Pago 2: 300 por transferencia
Payments::create([
    'paymentable_id' => $recibo->id,
    'paymentable_type' => RecibosPagosVarios::class,
    'payment_method_id' => '003',
    'monto' => 300.00,
    'fecha' => now()->addDays(1),
]);

// Actualizar estado
$totalPagado = $recibo->payments()->sum('monto');
if ($totalPagado >= $recibo->total) {
    $recibo->update(['pago_estado' => 'PAID']);
}
```

### 3. Consultar Movimientos

```php
// Obtener todos los pagos del recibo
$pagos = $recibo->payments;

// Obtener movimientos financieros globales
$globalPayments = $recibo->globalPayments;

// Total pagado
$totalPagado = $recibo->payments()->sum('monto');

// Saldo pendiente
$saldoPendiente = $recibo->total - $totalPagado;
```

---

## 🎯 Flujo Automático

### Cuando creas un Payment con RecibosPagosVarios:

1. **PaymentsObserver.created()** se ejecuta
2. **getTypeMovement()** identifica `RecibosPagosVarios` → retorna `'EGRESO'`
3. **getDestination()** determina destino:
    - Si payment_method_id es '008' o '009' → Cash del usuario
    - Si no encuentra Cash del usuario → Cualquier Cash abierta
    - Si no hay Cash → BankAccount activa
4. **createGlobalPayment()** crea el movimiento:
    - `type_movement` = 'EGRESO'
    - `description` = "EGRESO - {numero} - {cliente}"
    - Relaciona con el Payment (polimórfico)
5. **Actualiza Cash.saldo_actual**:
    - Si destino es Cash → `decrement('saldo_actual', monto)`

---

## 📊 Diferencias con Recibos de Ingreso

| Aspecto              | Recibos (Ingreso)               | RecibosPagosVarios (Egreso)            |
| -------------------- | ------------------------------- | -------------------------------------- |
| **Tipo movimiento**  | INGRESO                         | EGRESO                                 |
| **Saldo Cash**       | Incrementa (+)                  | Decrementa (-)                         |
| **Concepto**         | Cobros a clientes               | Salidas de efectivo                    |
| **Relación cliente** | `clientes()` - Cliente que paga | `clientes()` - Beneficiario que recibe |
| **Tabla**            | `recibos`                       | `recibos_pagos`                        |
| **Modelo**           | `Recibos`                       | `RecibosPagosVarios`                   |

---

## 🔍 Queries Útiles

### Recibos de egreso del día

```php
$egresosHoy = RecibosPagosVarios::whereDate('fecha_emision', today())
    ->with('payments.globalPayment')
    ->get();

$totalEgresosHoy = $egresosHoy->sum('total');
```

### Recibos pendientes de pago

```php
$pendientes = RecibosPagosVarios::where('pago_estado', 'UNPAID')
    ->where('estado', 'COMPLETADO')
    ->get();
```

### Movimientos de egreso del mes

```php
$egresosGlobales = GlobalPayment::where('type_movement', 'EGRESO')
    ->where('payment_type', Payments::class)
    ->whereHasMorph('payment', [Payments::class], function($q) {
        $q->where('paymentable_type', RecibosPagosVarios::class);
    })
    ->whereMonth('created_at', now()->month)
    ->sum('payment.monto'); // Polimórfico
```

---

## ⚙️ Configuración del Modelo

### Constantes

```php
const COMPLETADO = 'COMPLETADO';
const BORRADOR = 'BORRADOR';
const PAID = 'PAID';
const UNPAID = 'UNPAID';
const PEN = 'PEN';
const USD = 'USD';
```

### Scopes

```php
// Estados de pago
RecibosPagosVarios::paid()->get();      // Solo pagados
RecibosPagosVarios::unpaid()->get();    // Pendientes de pago

// Estados del documento
RecibosPagosVarios::completado()->get(); // Completados
RecibosPagosVarios::borrador()->get();   // Borradores

// Estado específico
RecibosPagosVarios::status('PAID')->get();
```

### Relaciones

```php
// Detalles del recibo
$recibo->detalles; // HasMany DetalleRecibosPagos

// Cliente/beneficiario
$recibo->clientes; // BelongsTo Clientes

// Pagos realizados
$recibo->payments; // MorphMany Payments

// Movimientos financieros globales
$recibo->globalPayments; // HasManyThrough
```

---

## 🚀 Ejemplo Completo: Componente Livewire

```php
// app/Livewire/Admin/RecibosPagos/Create.php

use Livewire\Component;
use App\Models\RecibosPagosVarios;
use App\Models\Payments;
use App\Models\Clientes;
use WireUi\Traits\WireUiActions;

class Create extends Component
{
    use WireUiActions;

    public $cliente_id;
    public $concepto;
    public $total = 0;
    public $payment_method_id = '009'; // Efectivo por defecto
    public $fecha_emision;

    public function mount()
    {
        $this->fecha_emision = now()->format('Y-m-d');
    }

    public function crearRecibo()
    {
        $this->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'concepto' => 'required|string|max:255',
            'total' => 'required|numeric|min:0.01',
            'payment_method_id' => 'required',
        ]);

        DB::transaction(function () {
            // 1. Crear recibo de egreso
            $recibo = RecibosPagosVarios::create([
                'serie' => 'RE',
                'numero' => $this->getNextNumber(),
                'clientes_id' => $this->cliente_id,
                'fecha_emision' => $this->fecha_emision,
                'fecha_pago' => now(),
                'total' => $this->total,
                'moneda' => 'PEN',
                'estado' => 'COMPLETADO',
                'pago_estado' => 'PAID',
                'concepto' => $this->concepto,
            ]);

            // 2. Crear pago (automáticamente crea GlobalPayment)
            Payments::create([
                'paymentable_id' => $recibo->id,
                'paymentable_type' => RecibosPagosVarios::class,
                'payment_method_id' => $this->payment_method_id,
                'monto' => $this->total,
                'fecha' => now(),
            ]);

            $this->notification()->success('Recibo de egreso registrado correctamente');
            $this->reset();
            $this->emit('reciboCreado');
        });
    }

    private function getNextNumber()
    {
        $last = RecibosPagosVarios::where('serie', 'RE')
            ->orderBy('numero', 'desc')
            ->first();

        return $last ? str_pad((int)$last->numero + 1, 3, '0', STR_PAD_LEFT) : '001';
    }

    public function render()
    {
        return view('livewire.admin.recibos-pagos.create', [
            'clientes' => Clientes::active()->get(),
            'metodosPago' => PaymentMethodType::where('active', true)->get(),
        ]);
    }
}
```

---

## 📝 Vista Blade

```blade
{{-- resources/views/livewire/admin/recibos-pagos/create.blade.php --}}

<x-form.modal.card title="Nuevo Recibo de Egreso" wire:model="showModal" max-width="3xl">
    <div class="grid grid-cols-2 gap-4">
        {{-- Cliente --}}
        <x-form.select
            label="Beneficiario"
            wire:model="cliente_id"
            placeholder="Seleccione cliente/empleado"
            :options="$clientes"
            option-label="nombre"
            option-value="id"
        />

        {{-- Fecha --}}
        <x-form.datetime.picker
            label="Fecha de Emisión"
            wire:model="fecha_emision"
            without-time
        />

        {{-- Concepto --}}
        <div class="col-span-2">
            <x-form.textarea
                label="Concepto"
                wire:model="concepto"
                placeholder="Adelanto de sueldo, vale de caja chica, etc."
                rows="2"
            />
        </div>

        {{-- Monto --}}
        <x-form.currency
            label="Monto Total"
            wire:model="total"
            prefix="S/"
            thousands="."
            decimal=","
        />

        {{-- Método de pago --}}
        <x-form.select
            label="Método de Pago"
            wire:model="payment_method_id"
            :options="$metodosPago"
            option-label="description"
            option-value="id"
        />
    </div>

    <x-slot name="footer">
        <x-form.button flat label="Cancelar" wire:click="$emit('closeModal')" />
        <x-form.button primary label="Registrar Salida" wire:click="crearRecibo" />
    </x-slot>
</x-form.modal.card>
```

---

## 🎯 Resumen

### ¿Cuándo usar RecibosPagosVarios?

✅ **Usar para:**

- Salidas de efectivo sin factura
- Adelantos a empleados
- Gastos menores de caja chica
- Reembolsos
- Viáticos
- Cualquier egreso que NO sea una compra con factura

❌ **NO usar para:**

- Compras con factura → Usar `Compra` + `ExpensePayment`
- Pagos a proveedores con documento → Usar `Compra` + `ExpensePayment`

### Flujo Automático

1. Crear `RecibosPagosVarios`
2. Crear `Payments` relacionado
3. `PaymentsObserver` detecta tipo EGRESO
4. Crea `GlobalPayment` automáticamente
5. Decrementa `Cash.saldo_actual`

### Reportes

- **Flujo de caja**: Ingresos vs Egresos (incluye RecibosPagosVarios)
- **Caja del día**: Saldo inicial + ingresos - egresos
- **Control de gastos**: Compras + RecibosPagosVarios

---

**Fecha de actualización:** 27 de enero de 2026  
**Versión:** 1.0.0  
**Sistema:** Talentus - Laravel 12
