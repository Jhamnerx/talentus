# Refactorización del Módulo de Caja Chica - Talentus

## 📋 Análisis del Sistema FactuPRO

### Arquitectura de FactuPRO Cash System

#### 1. **Modelo Cash** (Caja Principal)

```php
class Cash extends ModelTenant
{
    protected $fillable = [
        'user_id',              // Usuario que apertura
        'date_opening',         // Fecha de apertura
        'time_opening',         // Hora de apertura
        'date_closed',          // Fecha de cierre
        'time_closed',          // Hora de cierre
        'beginning_balance',    // Saldo inicial
        'final_balance',        // Saldo final calculado
        'income',               // Ingresos totales
        'state',                // Estado (true=abierta, false=cerrada)
        'reference_number',     // Número de referencia
        'apply_restaurant'      // Aplica para restaurantes
    ];

    // Relaciones
    public function cash_documents() // Documentos asociados
    public function global_destination() // GlobalPayments (destino)
    public function cash_transaction() // Transacción inicial (saldo)
}
```

#### 2. **Modelo CashDocument** (Relación con Documentos)

```php
class CashDocument extends ModelTenant
{
    protected $fillable = [
        'cash_id',                  // ID de la caja
        'document_id',              // Factura/Boleta
        'sale_note_id',             // Nota de venta
        'technical_service_id',     // Servicio técnico
        'expense_payment_id',       // Pago de gasto
        'purchase_id',              // Compra
        'quotation_id',             // Cotización
    ];

    // Relaciones polimórficas con todos los tipos de documentos
}
```

#### 3. **Modelo CashDocumentPayment** (Pagos de Documentos)

```php
class CashDocumentPayment extends ModelTenant
{
    protected $fillable = [
        'cash_id',
        'document_payment_id',      // ID del pago de documento
        'sale_note_payment_id',     // ID del pago de nota de venta
        'cash_document_id',         // Relación con cash_document
    ];
}
```

#### 4. **Modelo CashDocumentCredit** (Créditos)

```php
class CashDocumentCredit extends ModelTenant
{
    protected $fillable = [
        'cash_id',
        'document_id',
        'sale_note_id',
    ];
}
```

### Flujo de Trabajo FactuPRO

#### A. **Apertura de Caja**

1. Usuario apertura caja con `beginning_balance`
2. Se crea registro en `cash` con `state=true`
3. Se crea `CashTransaction` con el saldo inicial
4. Se crea `GlobalPayment` vinculado al CashTransaction
5. Solo puede haber UNA caja abierta por usuario

```php
// Validación antes de apertura
$cash = Cash::where([
    ['user_id', $user_id],
    ['state', true]
])->first();

if($cash) {
    throw new Exception("Ya existe una caja abierta para este usuario");
}
```

#### B. **Registro de Documentos en Caja**

Cuando se emite un documento (Factura, Nota de Venta, etc.):

```php
$cash = Cash::where([
    ['user_id', auth()->id()],
    ['state', true]
])->first();

// Crear relación cash_document
$cash->cash_documents()->create([
    'document_id' => $document->id
]);

// Registrar CADA pago del documento
foreach($document->payments as $payment) {
    CashDocumentPayment::create([
        'cash_id' => $cash->id,
        'document_payment_id' => $payment->id,
        'cash_document_id' => $cashDocument->id
    ]);
}
```

**Documentos que se registran automáticamente:**

- ✅ Facturas (`document`)
- ✅ Notas de venta (`sale_note`)
- ✅ Servicios técnicos (`technical_service`)
- ✅ Pagos de gastos (`expense_payment`)
- ✅ Compras (`purchase`)
- ✅ Cotizaciones (`quotation`)

#### C. **Cierre de Caja**

Proceso complejo que calcula:

1. **Ingresos** (ventas en soles):
    - Facturas/Boletas aceptadas
    - Notas de venta aceptadas
    - Servicios técnicos
    - Cotizaciones (según configuración)

2. **Egresos** (gastos en soles):
    - Pagos de gastos aprobados
    - Compras pagadas totalmente

3. **Conversión de moneda**:

    ```php
    $total_pen = ($currency_type_id == 'PEN')
        ? $total
        : ($total * $exchange_rate_sale);
    ```

4. **Cálculo final**:

    ```php
    $final_balance = $beginning_balance + $income - $egress;
    $cash->final_balance = $final_balance;
    $cash->income = $income - $egress;
    $cash->state = false;
    ```

5. **Validaciones especiales**:
    - No cerrar si hay mesas abiertas (restaurantes)
    - Estados válidos: `['01','03','05','07','13']`

### Reportes en FactuPRO

#### 1. **Reporte Principal de Caja** (`report`)

**Endpoint**: `GET cash/report/{cash}`

**Contenido**:

- Datos de la caja (usuario, fechas, saldos)
- Todos los documentos (facturas, notas, gastos, compras)
- Totales por método de pago
- Balance final

**Formato**: PDF

#### 2. **Reporte de Productos** (`report_products`)

**Endpoint**: `GET cash/report/products/{cash}/{is_garage?}`

**Contenido**:

- Items vendidos en la caja
- Cantidad, precio unitario, subtotal
- Agrupa items de:
    - Facturas (`document_items`)
    - Notas de venta (`sale_note_items`)
    - Compras (`purchase_items`)

**Formato**: PDF

#### 3. **Reporte Excel de Productos** (`report_products_excel`)

**Endpoint**: `GET cash/report/products-excel/{cash}`

**Contenido**: Igual que report_products

**Formato**: XLSX usando `Maatwebsite\Excel`

#### 4. **Reporte Excel de Caja** (`report_cash_excel`)

**Endpoint**: `GET cash/report/cash-excel/{cash}`

**Contenido**:

- Detalle completo de transacciones
- Separado por tipo (ventas, compras, gastos)
- Totales por método de pago
- Créditos y contado separados

**Formato**: XLSX

#### 5. **Reporte General del Día** (`report_general`)

**Endpoint**: `GET cash/report`

**Contenido**:

- Todas las cajas abiertas en la fecha actual
- Consolidado de ventas del día
- Multi-usuario

**Formato**: PDF

### Integraciones con Otros Módulos

#### 1. **CashServiceProvider** (Observer Pattern)

```php
ExpensePayment::created(function ($expense_payment) {
    if($expense_payment->expense_method_type_id === 1) { // Efectivo
        $cash = Cash::where([
            ['user_id', auth()->user()->id],
            ['state', true]
        ])->first();

        if(!$cash) {
            throw new Exception("Debe aperturar caja chica");
        }

        $cash->cash_documents()->create([
            'expense_payment_id' => $expense_payment->id
        ]);
    }
});
```

#### 2. **GlobalPayment Integration**

```php
// Al aperturar caja, se crea GlobalPayment del saldo inicial
public function createCashTransaction($cash, $request) {
    $cash_transaction = $cash->cash_transaction()->create([
        'date' => now(),
        'description' => 'Saldo inicial',
        'payment' => $request->beginning_balance,
        'payment_destination_id' => 'cash',
    ]);

    $this->createGlobalPaymentTransaction($cash_transaction, $data);
}
```

#### 3. **Restaurant Module**

- Valida mesas cerradas antes de cerrar caja
- Bloquea cierre si hay mesas `notavailable`

#### 4. **POS Module**

- Integración directa con ventas rápidas
- Modal de pago usa caja abierta
- Registra productos/servicios automáticamente

---

## 🔄 Diferencias con Talentus Actual

| Aspecto                     | FactuPRO                                        | Talentus Actual      | Acción                      |
| --------------------------- | ----------------------------------------------- | -------------------- | --------------------------- |
| **Apertura**                | Saldo inicial + CashTransaction + GlobalPayment | Solo registro básico | ⚙️ Implementar integración  |
| **Documentos relacionados** | CashDocument polimórfico (7 tipos)              | Solo cash table      | ⚙️ Crear CashDocument model |
| **Pagos detallados**        | CashDocumentPayment por cada pago               | No existe            | ⚙️ Crear modelo             |
| **Cierre automático**       | Calcula desde documentos + conversión moneda    | No existe lógica     | ⚙️ Implementar cálculo      |
| **Reportes**                | 5 reportes diferentes (PDF/Excel)               | No existen           | ⚙️ Crear todos              |
| **Observers**               | ExpensePayment crea CashDocument                | No existe            | ⚙️ Implementar              |
| **Validaciones**            | No cerrar con mesas abiertas, una caja por user | Básicas              | ⚙️ Agregar reglas           |
| **Créditos**                | CashDocumentCredit separado                     | No existe            | ⚙️ Crear modelo             |

---

## 🏗️ Plan de Implementación para Talentus

### Fase 1: Migraciones y Modelos

#### 1.1 Crear Migración `cash_documents`

```php
Schema::create('cash_documents', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('cash_id');

    // Documentos (nullables porque solo uno se usa a la vez)
    $table->unsignedBigInteger('factura_id')->nullable();
    $table->unsignedBigInteger('recibo_id')->nullable();
    $table->unsignedBigInteger('venta_id')->nullable();
    $table->unsignedBigInteger('expense_payment_id')->nullable();
    $table->unsignedBigInteger('compra_id')->nullable();
    $table->unsignedBigInteger('cotizacion_id')->nullable();

    $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
    $table->index('cash_id');
});
```

#### 1.2 Crear Migración `cash_document_payments`

```php
Schema::create('cash_document_payments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('cash_id');
    $table->unsignedBigInteger('payment_id'); // Payments table
    $table->unsignedBigInteger('cash_document_id')->nullable();

    $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
    $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
});
```

#### 1.3 Crear Migración `cash_document_credits`

```php
Schema::create('cash_document_credits', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('cash_id');
    $table->unsignedBigInteger('factura_id')->nullable();
    $table->unsignedBigInteger('recibo_id')->nullable();
    $table->timestamps();

    $table->foreign('cash_id')->references('id')->on('cash')->onDelete('cascade');
});
```

### Fase 2: Modelos Eloquent

#### 2.1 Actualizar Modelo `Cash`

```php
class Cash extends Model
{
    use HasFactory, LogsActivity, EmpresaScope;

    protected $table = 'cash';

    protected $fillable = [
        'user_id',
        'empresa_id',
        'fecha_apertura',
        'hora_apertura',
        'fecha_cierre',
        'hora_cierre',
        'saldo_inicial',
        'saldo_final',
        'ingresos',
        'estado',           // 1=abierta, 0=cerrada
        'nombre',
        'descripcion',
    ];

    protected $casts = [
        'fecha_apertura' => 'date',
        'fecha_cierre' => 'date',
        'saldo_inicial' => 'decimal:2',
        'saldo_final' => 'decimal:2',
        'ingresos' => 'decimal:2',
        'estado' => 'boolean',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cash_documents(): HasMany
    {
        return $this->hasMany(CashDocument::class);
    }

    public function cash_document_payments(): HasMany
    {
        return $this->hasMany(CashDocumentPayment::class);
    }

    public function global_destination(): MorphMany
    {
        return $this->morphMany(GlobalPayment::class, 'destination');
    }

    // Scopes
    public function scopeAbiertas($query)
    {
        return $query->where('estado', 1);
    }

    public function scopeCerradas($query)
    {
        return $query->where('estado', 0);
    }

    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Métodos
    public function aperturar(float $saldoInicial)
    {
        $this->fecha_apertura = now()->toDateString();
        $this->hora_apertura = now()->toTimeString();
        $this->saldo_inicial = $saldoInicial;
        $this->estado = 1;
        $this->save();

        // Crear GlobalPayment del saldo inicial
        $this->crearGlobalPaymentInicial();
    }

    public function cerrar()
    {
        // Calcular totales
        $totales = $this->calcularTotales();

        $this->fecha_cierre = now()->toDateString();
        $this->hora_cierre = now()->toTimeString();
        $this->ingresos = $totales['ingresos'] - $totales['egresos'];
        $this->saldo_final = $this->saldo_inicial + $this->ingresos;
        $this->estado = 0;
        $this->save();
    }

    private function calcularTotales(): array
    {
        $ingresos = 0;
        $egresos = 0;

        foreach ($this->cash_documents as $doc) {
            if ($doc->factura) {
                $ingresos += $doc->factura->total_a_pagar;
            }
            // ... otros tipos
        }

        return compact('ingresos', 'egresos');
    }
}
```

#### 2.2 Crear Modelo `CashDocument`

```php
class CashDocument extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'cash_id',
        'factura_id',
        'recibo_id',
        'venta_id',
        'expense_payment_id',
        'compra_id',
        'cotizacion_id',
    ];

    public function cash(): BelongsTo
    {
        return $this->belongsTo(Cash::class);
    }

    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class);
    }

    public function recibo(): BelongsTo
    {
        return $this->belongsTo(Recibos::class);
    }

    // ... otras relaciones

    // Método helper para obtener el documento
    public function getDocumento()
    {
        return $this->factura
            ?? $this->recibo
            ?? $this->venta
            ?? $this->expense_payment
            ?? $this->compra
            ?? $this->cotizacion;
    }
}
```

### Fase 3: Observers

#### 3.1 Crear `CashObserver`

```php
class CashObserver
{
    use FinanceTrait;

    public function created(Cash $cash)
    {
        // Crear GlobalPayment del saldo inicial si tiene
        if ($cash->saldo_inicial > 0) {
            $this->createGlobalPayment(
                payment: null, // No hay payment real, es saldo inicial
                destination_type: Cash::class,
                destination_id: $cash->id
            );
        }
    }

    public function deleting(Cash $cash)
    {
        // Eliminar documentos relacionados
        $cash->cash_documents()->delete();
        $cash->cash_document_payments()->delete();

        // Eliminar GlobalPayments
        $cash->global_destination()->delete();
    }
}
```

#### 3.2 Crear `PaymentObserver` (ya existe, actualizar)

```php
public function created(Payment $payment)
{
    // Si el pago tiene destino Caja, registrar en cash_documents
    if ($payment->destination_type === Cash::class) {
        $cash = Cash::find($payment->destination_id);

        if ($cash && $cash->estado == 1) {
            // Determinar tipo de documento
            $docType = $this->getDocumentType($payment->paymentable_type);

            $cashDoc = $cash->cash_documents()->create([
                $docType => $payment->paymentable_id
            ]);

            // Registrar el pago
            CashDocumentPayment::create([
                'cash_id' => $cash->id,
                'payment_id' => $payment->id,
                'cash_document_id' => $cashDoc->id,
            ]);
        }
    }
}

private function getDocumentType($paymentableType): string
{
    $map = [
        'App\Models\Factura' => 'factura_id',
        'App\Models\Recibos' => 'recibo_id',
        'App\Models\Ventas' => 'venta_id',
        // ... otros
    ];

    return $map[$paymentableType] ?? 'factura_id';
}
```

### Fase 4: Componentes Livewire

#### 4.1 Actualizar `Admin/Finanzas/CajaChica/Index`

```php
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $estado_filter = '';
    public $user_filter = '';

    public function render()
    {
        $query = Cash::with(['user', 'cash_documents'])
            ->where(function($q) {
                $q->where('nombre', 'like', '%'.$this->search.'%')
                  ->orWhere('descripcion', 'like', '%'.$this->search.'%');
            })
            ->when($this->estado_filter !== '', fn($q) => $q->where('estado', $this->estado_filter))
            ->when($this->user_filter, fn($q) => $q->where('user_id', $this->user_filter))
            ->when($this->from && $this->to, fn($q) =>
                $q->whereBetween('fecha_apertura', [$this->from, $this->to])
            )
            ->latest('fecha_apertura')
            ->paginate(20);

        $usuarios = User::all();

        return view('livewire.admin.finanzas.caja-chica.index', [
            'cajas' => $query,
            'usuarios' => $usuarios
        ]);
    }

    public function aperturar()
    {
        $this->dispatch('aperturar-caja');
    }

    public function cerrar($id)
    {
        $cash = Cash::find($id);

        if (!$cash) {
            $this->notification()->error('Caja no encontrada');
            return;
        }

        try {
            $cash->cerrar();
            $this->notification()->success('Caja cerrada exitosamente');
            $this->dispatch('render');
        } catch (\Exception $e) {
            $this->notification()->error($e->getMessage());
        }
    }

    public function verReporte($id, $tipo)
    {
        return redirect()->route('admin.finanzas.caja.reporte', [
            'cash' => $id,
            'tipo' => $tipo
        ]);
    }
}
```

#### 4.2 Crear `Admin/Finanzas/CajaChica/Aperturar`

```php
class Aperturar extends Component
{
    public $showModal = false;
    public $saldo_inicial = 0;
    public $nombre = '';
    public $descripcion = '';

    protected $listeners = ['aperturar-caja' => 'show'];

    protected $rules = [
        'saldo_inicial' => 'required|numeric|min:0',
        'nombre' => 'required|string|max:255',
    ];

    public function show()
    {
        // Verificar que no haya caja abierta
        $cajaAbierta = Cash::where('user_id', auth()->id())
            ->where('estado', 1)
            ->exists();

        if ($cajaAbierta) {
            $this->notification()->error('Ya tiene una caja abierta');
            return;
        }

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $cash = Cash::create([
            'user_id' => auth()->id(),
            'empresa_id' => session('empresa'),
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'saldo_inicial' => $this->saldo_inicial,
            'fecha_apertura' => now()->toDateString(),
            'hora_apertura' => now()->toTimeString(),
            'estado' => 1,
        ]);

        // Crear GlobalPayment del saldo inicial
        if ($this->saldo_inicial > 0) {
            GlobalPayment::create([
                'destination_type' => Cash::class,
                'destination_id' => $cash->id,
                'payment_type' => null, // Saldo inicial
                'payment_id' => null,
                'user_id' => auth()->id(),
                'empresa_id' => session('empresa'),
            ]);
        }

        $this->notification()->success('Caja aperturada exitosamente');
        $this->reset(['showModal', 'saldo_inicial', 'nombre', 'descripcion']);
        $this->dispatch('render');
    }

    public function render()
    {
        return view('livewire.admin.finanzas.caja-chica.aperturar');
    }
}
```

### Fase 5: Vistas Blade

#### 5.1 Vista Principal `caja-chica/index.blade.php`

```blade
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-384 mx-auto">
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold">Caja Chica</h1>
            <p class="text-sm text-gray-500 mt-1">
                Apertura y cierre de cajas para control de efectivo
            </p>
        </div>

        <button wire:click="aperturar" class="btn bg-violet-500 text-white">
            <svg class="w-4 h-4 mr-2">...</svg>
            Aperturar Caja
        </button>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <x-form.input wire:model.live="search" placeholder="Buscar..." />

        <x-form.select wire:model.live="estado_filter" label="Estado">
            <option value="">Todos</option>
            <option value="1">Abiertas</option>
            <option value="0">Cerradas</option>
        </x-form.select>

        <x-form.select wire:model.live="user_filter" label="Usuario">
            <option value="">Todos</option>
            @foreach($usuarios as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </x-form.select>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Fecha Apertura</th>
                    <th>Saldo Inicial</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cajas as $caja)
                <tr>
                    <td>{{ $caja->user->name }}</td>
                    <td>{{ $caja->nombre }}</td>
                    <td>{{ $caja->fecha_apertura->format('d/m/Y') }}</td>
                    <td>S/ {{ number_format($caja->saldo_inicial, 2) }}</td>
                    <td>
                        <x-badge :color="$caja->estado ? 'green' : 'gray'">
                            {{ $caja->estado ? 'Abierta' : 'Cerrada' }}
                        </x-badge>
                    </td>
                    <td>
                        @if($caja->estado)
                            <button wire:click="cerrar({{ $caja->id }})"
                                class="text-red-500">
                                Cerrar
                            </button>
                        @else
                            <button wire:click="verReporte({{ $caja->id }}, 'pdf')"
                                class="text-blue-500">
                                Ver Reporte
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $cajas->links() }}
        </div>
    </div>

    <livewire:admin.finanzas.caja-chica.aperturar />
</div>
```

### Fase 6: Controladores de Reportes

#### 6.1 Crear `CashReportController`

```php
class CashReportController extends Controller
{
    public function reportePrincipal(Cash $cash)
    {
        $cash->load(['cash_documents.factura', 'cash_documents.recibo', 'user']);
        $empresa = Empresa::find(session('empresa'));

        $pdf = PDF::loadView('admin.pdf.cash-report', compact('cash', 'empresa'));

        return $pdf->stream("caja_{$cash->id}.pdf");
    }

    public function reporteProductos(Cash $cash)
    {
        $productos = $this->getProductosVendidos($cash);
        $empresa = Empresa::find(session('empresa'));

        $pdf = PDF::loadView('admin.pdf.cash-productos', compact('cash', 'productos', 'empresa'));

        return $pdf->stream("caja_productos_{$cash->id}.pdf");
    }

    public function reporteExcel(Cash $cash)
    {
        return Excel::download(
            new CashExport($cash),
            "caja_{$cash->id}.xlsx"
        );
    }

    private function getProductosVendidos(Cash $cash): Collection
    {
        $items = collect();

        // Facturas
        foreach ($cash->cash_documents()->whereNotNull('factura_id')->get() as $doc) {
            foreach ($doc->factura->detalles as $detalle) {
                $items->push([
                    'tipo' => 'Factura',
                    'numero' => $doc->factura->numero_comprobante,
                    'producto' => $detalle->producto->nombre,
                    'cantidad' => $detalle->cantidad,
                    'precio' => $detalle->precio_unitario,
                    'total' => $detalle->importe,
                ]);
            }
        }

        // Recibos
        // ... similar

        return $items;
    }
}
```

### Fase 7: Rutas

```php
// routes/admin.php
Route::prefix('finanzas')->name('admin.finanzas.')->group(function () {

    Route::get('caja-chica', Index::class)->name('caja-chica.index');

    Route::prefix('caja')->name('caja.')->group(function () {
        Route::get('{cash}/reporte', [CashReportController::class, 'reportePrincipal'])
            ->name('reporte');
        Route::get('{cash}/reporte-productos', [CashReportController::class, 'reporteProductos'])
            ->name('reporte-productos');
        Route::get('{cash}/reporte-excel', [CashReportController::class, 'reporteExcel'])
            ->name('reporte-excel');
    });
});
```

---

## ✅ Checklist de Implementación

- [ ] **Fase 1**: Crear migraciones (cash_documents, cash_document_payments, cash_document_credits)
- [ ] **Fase 2**: Actualizar modelo Cash y crear CashDocument, CashDocumentPayment
- [ ] **Fase 3**: Crear CashObserver y actualizar PaymentObserver
- [ ] **Fase 4**: Actualizar componentes Livewire (Index, Aperturar, Cerrar)
- [ ] **Fase 5**: Crear vistas Blade completas
- [ ] **Fase 6**: Crear CashReportController con 3 tipos de reportes
- [ ] **Fase 7**: Actualizar rutas
- [ ] **Fase 8**: Crear PDFs templates para reportes
- [ ] **Fase 9**: Crear Exports para Excel
- [ ] **Fase 10**: Testing completo

---

## 🎯 Beneficios de la Nueva Arquitectura

1. ✅ **Trazabilidad completa**: Todos los documentos quedan vinculados a la caja
2. ✅ **Cálculo automático**: El cierre calcula desde los documentos reales
3. ✅ **Reportes detallados**: PDF y Excel con todos los datos
4. ✅ **Integración GlobalPayment**: Flujo de efectivo consolidado
5. ✅ **Multi-documento**: Soporta facturas, recibos, gastos, compras, etc.
6. ✅ **Validación robusta**: No puede haber 2 cajas abiertas por usuario
7. ✅ **Auditable**: LogsActivity registra todos los cambios

---

## 📌 Notas Importantes

- **Conversión de moneda**: Implementar para soportar USD y PEN
- **Estados válidos**: Usar los mismos que FactuPRO `['01','03','05','07','13']`
- **CashTransaction**: Crear modelo para saldo inicial si no existe
- **Restaurant module**: Si se implementa, agregar validación de mesas
- **Créditos**: CashDocumentCredit solo se crea si `payment_condition_id === '02'`
- **Expense integration**: Usar observer para registrar gastos automáticamente

---

## 🚀 Próximos Pasos

1. ¿Deseas que implemente las migraciones primero?
2. ¿Prefieres empezar por los modelos y relaciones?
3. ¿O comenzamos con los componentes Livewire?

**Recomendación**: Empezar por migraciones → modelos → observers → livewire → reportes
