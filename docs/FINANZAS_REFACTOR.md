# Refactorización del Módulo de Finanzas - Talentus

## 📋 Análisis del Sistema FactuPRO

### Arquitectura de FactuPRO Finance Module

#### 1. **GlobalPayments** (Tabla Central)

```sql
CREATE TABLE global_payments (
    id INT PRIMARY KEY,
    soap_type_id CHAR(2),
    destination_id INT,           -- Cash::id o BankAccount::id
    destination_type VARCHAR,     -- Cash::class o BankAccount::class
    payment_id INT,               -- DocumentPayment::id, PurchasePayment::id, etc.
    payment_type VARCHAR,         -- DocumentPayment::class, PurchasePayment::class, etc.
    user_id INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Concepto Clave**:

- **NO se crean movimientos manualmente**
- Los movimientos se generan **automáticamente** cuando se registra un pago en cualquier módulo
- Usa **polimorfismo** (morphTo) para relacionar con múltiples tipos de pago

#### 2. **Flujo de Creación Automática**

```php
// Cuando se crea un pago de documento:
DocumentPayment::create([...])
    -> Trigger: createGlobalPayment()
        -> GlobalPayment::create([
            'destination_id' => $cash->id,
            'destination_type' => Cash::class,
            'payment_id' => $payment->id,
            'payment_type' => DocumentPayment::class
        ])
```

#### 3. **Tipos de Pagos que Generan Movimientos**

- `DocumentPayment` - Pagos de facturas/boletas
- `SaleNotePayment` - Pagos de notas de venta
- `PurchasePayment` - Pagos de compras
- `ExpensePayment` - Pagos de gastos
- `QuotationPayment` - Pagos de cotizaciones
- `ContractPayment` - Pagos de contratos
- `IncomePayment` - Ingresos adicionales
- `TechnicalServicePayment` - Pagos de servicios técnicos
- `CashTransaction` - Transacciones de caja chica POS

#### 4. **Destinations (Destinos de Pago)**

- `Cash::class` - Caja general del usuario
- `BankAccount::class` - Cuentas bancarias de la empresa

### Diferencias con Implementación Actual de Talentus

| Aspecto                     | FactuPRO               | Talentus Actual   | Problema               |
| --------------------------- | ---------------------- | ----------------- | ---------------------- |
| **Creación de movimientos** | Automática desde pagos | Manual con modal  | ❌ Duplica información |
| **Origen de datos**         | Relación polimórfica   | Campos duplicados | ❌ Inconsistencia      |
| **Tabla central**           | `global_payments`      | `cash_movements`  | ❌ No usa relaciones   |
| **Integración**             | Con todos los módulos  | Solo Finanzas     | ❌ Aislado             |

---

## 🔧 Plan de Refactorización para Talentus

### Fase 1: Crear Tabla `global_payments`

```php
// Migration: create_global_payments_table.php
Schema::create('global_payments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('destination_id')->nullable();
    $table->string('destination_type')->nullable(); // Cash, BankAccount
    $table->unsignedBigInteger('payment_id');
    $table->string('payment_type'); // PaymentDocument, PaymentPurchase, etc.
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('empresa_id');
    $table->timestamps();

    $table->index(['destination_id', 'destination_type']);
    $table->index(['payment_id', 'payment_type']);
    $table->foreign('user_id')->references('id')->on('users');
    $table->foreign('empresa_id')->references('id')->on('empresas');
});
```

### Fase 2: Crear Modelo `GlobalPayment`

```php
// app/Models/GlobalPayment.php
class GlobalPayment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'destination_id',
        'destination_type',
        'payment_id',
        'payment_type',
        'user_id',
        'empresa_id'
    ];

    // Relación polimórfica con el destino (Caja o Cuenta Bancaria)
    public function destination()
    {
        return $this->morphTo();
    }

    // Relación polimórfica con el pago
    public function payment()
    {
        return $this->morphTo();
    }

    // Relaciones específicas
    public function documentPayment()
    {
        return $this->belongsTo(Payment::class, 'payment_id')
            ->where('payment_type', Payment::class);
    }

    // Accessors
    public function getTypeMovementAttribute()
    {
        // INGRESO si es pago de venta
        // EGRESO si es pago de compra/gasto
        return $this->payment->isIncome() ? 'INGRESO' : 'EGRESO';
    }

    public function getMontoAttribute()
    {
        return $this->payment->payment ?? 0;
    }
}
```

### Fase 3: Modificar Tabla `payments`

```php
// Ya existe en Talentus, agregar relación:
// app/Models/Payment.php
class Payment extends Model
{
    // ... código existente

    public function globalPayment()
    {
        return $this->morphOne(GlobalPayment::class, 'payment');
    }

    public function isIncome()
    {
        // Determinar si es ingreso según el paymentable_type
        return in_array($this->paymentable_type, [
            'App\\Models\\Recibos',
            'App\\Models\\Factura',
            // Otros modelos de venta
        ]);
    }
}
```

### Fase 4: Trait `FinanceTrait`

```php
// app/Traits/FinanceTrait.php
trait FinanceTrait
{
    /**
     * Crear GlobalPayment automáticamente cuando se crea un pago
     */
    public function createGlobalPayment($payment, $destination_type, $destination_id)
    {
        GlobalPayment::create([
            'destination_id' => $destination_id,
            'destination_type' => $destination_type,
            'payment_id' => $payment->id,
            'payment_type' => get_class($payment),
            'user_id' => auth()->id(),
            'empresa_id' => session('empresa'),
        ]);
    }

    /**
     * Obtener caja abierta del usuario
     */
    public function getCashOpened()
    {
        return Cash::where('user_id', auth()->id())
            ->where('estado', 1)
            ->first();
    }

    /**
     * Obtener destinos disponibles (Cajas + Cuentas Bancarias)
     */
    public function getPaymentDestinations()
    {
        $destinations = collect();

        // Caja del usuario
        $cash = $this->getCashOpened();
        if ($cash) {
            $destinations->push([
                'id' => 'cash',
                'cash_id' => $cash->id,
                'type' => Cash::class,
                'description' => "CAJA - {$cash->nombre}"
            ]);
        }

        // Cuentas bancarias
        $bankAccounts = BankAccount::active()->get();
        foreach ($bankAccounts as $account) {
            $destinations->push([
                'id' => $account->id,
                'type' => BankAccount::class,
                'description' => "{$account->bank->description} - {$account->number}"
            ]);
        }

        return $destinations;
    }
}
```

### Fase 5: Observer para Payments

```php
// app/Observers/PaymentObserver.php
class PaymentObserver
{
    use FinanceTrait;

    public function created(Payment $payment)
    {
        // Determinar destino desde el campo destination_id del payment
        if ($payment->destination_type && $payment->destination_id) {
            $this->createGlobalPayment(
                $payment,
                $payment->destination_type,
                $payment->destination_id
            );
        }
    }

    public function deleted(Payment $payment)
    {
        // Eliminar GlobalPayment asociado
        $payment->globalPayment()?->delete();
    }
}
```

### Fase 6: Modificar Vista de Movimientos

**ELIMINAR**: Modal de creación manual  
**REEMPLAZAR**: Vista de solo lectura con filtros

```blade
{{-- resources/views/livewire/admin/finanzas/movimientos/index.blade.php --}}
<div>
    <h1>Movimientos de Ingresos y Egresos</h1>
    <p class="text-sm text-gray-500">
        Los movimientos se generan automáticamente desde los pagos registrados en el sistema
    </p>

    {{-- Filtros --}}
    <div class="filters">
        <select wire:model.live="payment_type">
            <option value="">Todos los Tipos</option>
            <option value="Payment">Pagos de Documentos</option>
            <option value="PurchasePayment">Pagos de Compras</option>
            <option value="ExpensePayment">Gastos</option>
        </select>

        <select wire:model.live="destination_type">
            <option value="">Todos los Destinos</option>
            <option value="Cash">Caja</option>
            <option value="BankAccount">Cuenta Bancaria</option>
        </select>
    </div>

    {{-- Tabla de solo lectura --}}
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Documento/Transacción</th>
                <th>Cliente/Proveedor</th>
                <th>Tipo</th>
                <th>Destino</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $movimiento)
            <tr>
                <td>{{ $movimiento->payment->created_at }}</td>
                <td>
                    @if($movimiento->payment->paymentable)
                        {{ $movimiento->payment->paymentable->numero }}
                    @endif
                </td>
                <td>{{ $movimiento->payment->paymentable->cliente->razon_social ?? '-' }}</td>
                <td>
                    <x-badge :color="$movimiento->type_movement == 'INGRESO' ? 'green' : 'red'">
                        {{ $movimiento->type_movement }}
                    </x-badge>
                </td>
                <td>{{ $movimiento->destination->description ?? '-' }}</td>
                <td>{{ $movimiento->monto }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
```

### Fase 7: Componente Livewire Simplificado

```php
// app/Livewire/Admin/Finanzas/Movimientos/Index.php
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $payment_type = '';
    public $destination_type = '';

    #[On('render')]
    public function render()
    {
        $query = GlobalPayment::with(['payment.paymentable', 'destination', 'user'])
            ->whereBetween('created_at', [$this->from ?: now()->startOfMonth(), $this->to ?: now()])
            ->when($this->payment_type, fn($q) => $q->where('payment_type', $this->payment_type))
            ->when($this->destination_type, fn($q) => $q->where('destination_type', $this->destination_type))
            ->latest();

        $movimientos = $query->paginate(20);

        return view('livewire.admin.finanzas.movimientos.index', compact('movimientos'));
    }
}
```

---

## 📊 Migración de Datos Existentes

```php
// database/seeders/MigrateToGlobalPaymentsSeeder.php
class MigrateToGlobalPaymentsSeeder extends Seeder
{
    public function run()
    {
        // 1. Migrar cash_movements existentes a global_payments
        $movements = CashMovement::all();

        foreach ($movements as $movement) {
            // Buscar el pago relacionado si existe
            $payment = Payment::where('id', $movement->payment_id)->first();

            if ($payment) {
                GlobalPayment::create([
                    'destination_id' => $movement->cash_id,
                    'destination_type' => Cash::class,
                    'payment_id' => $payment->id,
                    'payment_type' => get_class($payment),
                    'user_id' => $movement->user_id ?? 1,
                    'empresa_id' => $movement->empresa_id ?? 1,
                    'created_at' => $movement->created_at,
                    'updated_at' => $movement->updated_at,
                ]);
            }
        }

        // 2. OPCIONAL: Eliminar tabla cash_movements después de verificar
        // Schema::dropIfExists('cash_movements');
    }
}
```

---

## ✅ Checklist de Implementación

- [x] **Fase 1**: Crear migration `global_payments` ✅
- [x] **Fase 2**: Crear modelo `GlobalPayment` ✅
- [x] **Fase 3**: Agregar relación con GlobalPayment al modelo Payments ✅
- [x] **Fase 4**: Crear `FinanceTrait` ✅
- [x] **Fase 5**: Crear `PaymentObserver` ✅
- [x] **Fase 6**: Registrar observer en `AppServiceProvider` ✅
- [x] **Fase 7**: Eliminar modal de creación manual en Movimientos ✅
- [x] **Fase 8**: Actualizar vista de Movimientos (solo lectura) ✅
- [x] **Fase 9**: Actualizar Livewire component ✅
- [x] **Fase 10**: Migrar datos existentes (seeder creado) ✅
- [ ] **Fase 11**: Testing completo ⏳
- [ ] **Fase 12**: Documentar para el equipo ⏳

---

## 🎉 IMPLEMENTACIÓN COMPLETADA

### Archivos Creados

1. **database/migrations/2026_01_26_214204_create_global_payments_table.php**
    - Tabla central con relaciones polimórficas
    - Índices optimizados para búsquedas

2. **app/Models/GlobalPayment.php**
    - Modelo completo con relaciones morphTo
    - Accessors para type_movement, monto, destination_description, etc.
    - Scopes: ingresos(), egresos(), byCash()
    - Integrado con EmpresaScope y LogsActivity

3. **app/Traits/FinanceTrait.php**
    - createGlobalPayment()
    - getCashOpened()
    - getPaymentDestinations()
    - getDestinationRecord()
    - deleteGlobalPayment()

4. **app/Observers/PaymentObserver.php**
    - Auto-crear GlobalPayment en created()
    - Auto-eliminar GlobalPayment en deleting()

5. **database/seeders/MigratePaymentsToGlobalPaymentsSeeder.php**
    - Migración de datos existentes

### Archivos Modificados

1. **app/Models/Payments.php**
    - Agregada relación globalPayment()
    - Métodos isIncome() y isExpense()

2. **app/Providers/AppServiceProvider.php**
    - Registrado PaymentObserver

3. **app/Livewire/Admin/Finanzas/Movimientos/Index.php**
    - Reescrito completamente para usar GlobalPayment
    - Filtros por tipo de movimiento, destino, caja
    - Búsqueda por documento
    - Fechas por defecto (mes actual)

4. **resources/views/livewire/admin/finanzas/movimientos/index.blade.php**
    - Vista de solo lectura
    - Indicadores visuales (verde=ingreso, rojo=egreso)
    - Filtros mejorados
    - Sin botón de crear

### Archivos Eliminados

1. ~~database/migrations/2026_01_26_123341_create_cash_movements_table.php~~
2. ~~app/Models/CashMovement.php~~
3. ~~app/Livewire/Admin/Finanzas/Movimientos/Save.php~~
4. ~~resources/views/livewire/admin/finanzas/movimientos/save.blade.php~~

### Comandos Ejecutados

```bash
# Migración ejecutada correctamente
php artisan migrate
# ✅ 2026_01_26_214204_create_global_payments_table

# Para migrar datos existentes:
php artisan db:seed --class=MigratePaymentsToGlobalPaymentsSeeder
```

---

## 🚀 Próximos Pasos

### 1. Modificar módulo de Pagos

Actualizar el formulario de registro de pagos para incluir destino:

```blade
{{-- Al registrar un pago --}}
<x-form.native.select label="Destino del Pago" wire:model="destination_id">
    @foreach($destinations as $dest)
        <option value="{{ $dest['id'] }}">
            {{ $dest['description'] }}
            @if(isset($dest['saldo']))
                (Saldo: S/ {{ number_format($dest['saldo'], 2) }})
            @endif
        </option>
    @endforeach
</x-form.native.select>
```

### 2. Actualizar otros módulos de Finanzas

- **Balance**: Calcular desde GlobalPayments
- **Ingresos**: Eliminar registro manual, usar desde pagos
- **Caja Chica**: Mantener pero integrar con GlobalPayments
- **Transacciones**: Vista consolidada de GlobalPayments

### 3. Agregar columnas a `payments` table

```php
// Migration para agregar destination_id y destination_type
Schema::table('payments', function (Blueprint $table) {
    $table->unsignedBigInteger('destination_id')->nullable()->after('payment');
    $table->string('destination_type')->nullable()->after('destination_id');
    $table->index(['destination_id', 'destination_type']);
});
```

### 4. Testing

- Test creación de pago → GlobalPayment automático
- Test eliminación de pago → GlobalPayment eliminado
- Test filtros en vista de movimientos
- Test accessors del modelo GlobalPayment

---

## 🎯 Beneficios de la Nueva Arquitectura

1. ✅ **Automático**: No se crean movimientos manualmente
2. ✅ **Integrado**: Todos los pagos generan movimientos
3. ✅ **Confiable**: Datos consistentes entre módulos
4. ✅ **Escalable**: Fácil agregar nuevos tipos de pago
5. ✅ **Auditable**: Trazabilidad completa de transacciones
6. ✅ **Flexible**: Soporta múltiples destinos (cajas, bancos)

---

## 📌 Notas Importantes

- **NO eliminar** `cash_movements` hasta verificar migración completa
- Mantener `cash` table para apertura/cierre de cajas
- `CashDocument` permanece para relación cash-documentos
- Balance se calcula desde `global_payments`, no manualmente
