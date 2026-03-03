<?php

namespace App\Livewire\Admin\Cobros;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Cobros;
use App\Models\Ventas;
use App\Models\Recibos;
use Livewire\Component;
use App\Models\Clientes;
use App\Models\Payments;
use App\Models\BankAccount;
use App\Models\DetalleCobros;
use App\Models\NotificacionCobro;
use App\Models\PaymentMethodType;
use App\Helpers\PaymentDestinationHelper;
use App\Http\Controllers\Admin\PaymentsController;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

/**
 * Gestiona las Notificaciones de Cobro.
 *
 * El modal de pago sigue el mismo patron que Payment.php:
 *   - numero secuencial (PaymentsController::setNextSequenceNumber)
 *   - tipo pago (FACTURA / RECIBO)
 *   - selector de documento (factura/boleta o recibo UNPAID del cliente)
 *   - metodo de pago
 *   - destino (caja abierta o cuenta bancaria via PaymentDestinationHelper)
 *   - divisa, monto, n operacion, nota
 *   - modo "crear nuevo" o "asociar pago existente"
 * Al confirmar: crea el Payment + llama marcarComoPagado() en la notificacion.
 */
class Notificaciones extends Component
{
    use WithPagination, WireUiActions;

    // Filtros de tabla
    public string $search = '';
    public string $estado = 'PENDIENTE';
    public $filtroVencimiento = null;
    public $clienteId = null;
    public int $perPage = 15;

    // Estado del modal de pago
    public bool $modalPago = false;
    public ?int $pagoNotificacionId = null;

    // Campos del formulario de pago (misma nomenclatura que Payment.php)
    public $pago_numero             = null;
    public $pago_fecha              = null;
    public string $pago_tipo_pago   = 'FACTURA';
    public string $pago_titulo_doc  = 'Factura / Boleta';
    public $pago_paymentable_type   = null;
    public $pago_paymentable_id     = null;
    public array $pago_documentos   = [];
    public int $pago_payment_method_id = 1;
    public $pago_payment_destination_id = null;
    public bool $pago_showBankAccountSelector = false;
    public $pago_bank_account_id    = null;
    public string $pago_divisa      = 'PEN';
    public $pago_monto              = null;
    public $pago_numero_operacion   = null;
    public string $pago_nota        = '';

    // Modo crear / asociar
    public string $pago_mode     = 'create';
    public $pago_existing_id      = null;
    public array $pago_existing_list = [];

    // Catalogos cargados en mount()
    public array $paymentsMethods = [];
    public $bankAccounts = [];

    protected $queryString = [
        'search'            => ['except' => ''],
        'estado'            => ['except' => 'PENDIENTE'],
        'filtroVencimiento' => ['except' => ''],
        'clienteId'         => ['except' => ''],
        'perPage'           => ['except' => 15],
    ];

    protected $listeners = ['render'];

    public function mount(): void
    {
        $this->paymentsMethods = PaymentMethodType::whereActive(true)->get()->toArray();
        $this->bankAccounts    = BankAccount::where('status', true)->get();
    }

    // Computed: clientes con notificaciones (para filtro)
    #[Computed]
    public function clientes()
    {
        return Clientes::whereIn('id', NotificacionCobro::distinct()->pluck('cliente_id')->filter())
            ->orderBy('razon_social')
            ->get(['id', 'razon_social', 'numero_documento']);
    }

    // Computed: destinos de pago
    #[Computed]
    public function paymentDestinations()
    {
        return PaymentDestinationHelper::getPaymentDestinations();
    }

    // Render
    public function render()
    {
        $notificaciones = NotificacionCobro::query()
            ->with(['detalleCobro.vehiculo', 'cobro.clientes', 'venta', 'recibo'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('cobro.clientes', fn($c) => $c->where('razon_social', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('detalleCobro.vehiculo', fn($v) => $v->where('placa', 'like', '%' . $this->search . '%'))
                        ->orWhere('descripcion', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->estado, fn($q) => $q->where('estado', $this->estado))
            ->when($this->clienteId, fn($q) => $q->where('cliente_id', $this->clienteId))
            ->when($this->filtroVencimiento === 'vencidos', fn($q) => $q->vencidos())
            ->when($this->filtroVencimiento === 'hoy',     fn($q) => $q->whereDate('fecha_vencimiento', now()))
            ->when($this->filtroVencimiento === '7dias',   fn($q) => $q->porVencer(7))
            ->when($this->filtroVencimiento === '15dias',  fn($q) => $q->porVencer(15))
            ->orderBy('fecha_vencimiento', 'asc')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        $stats = [
            'pendientes'      => NotificacionCobro::pendientes()->count(),
            'vencidos'        => NotificacionCobro::vencidos()->count(),
            'hoy'             => NotificacionCobro::pendientes()->whereDate('fecha_vencimiento', now())->count(),
            'monto_pendiente' => NotificacionCobro::pendientes()->sum('monto'),
        ];

        return view('livewire.admin.cobros.notificaciones', compact('notificaciones', 'stats'));
    }

    // Modal de pago - apertura
    public function abrirModalPago(int $notificacionId): void
    {
        $this->resetPago();

        $notificacion = NotificacionCobro::with(['cobro.clientes', 'detalleCobro'])->findOrFail($notificacionId);
        $this->pagoNotificacionId = $notificacionId;

        $this->pago_numero = (new PaymentsController())->setNextSequenceNumber();
        $this->pago_fecha  = Carbon::now()->format('Y-m-d');

        $cobro = $notificacion->cobro;
        $this->pago_divisa = $cobro->divisa ?? 'PEN';
        $this->pago_monto  = $notificacion->monto;

        $this->pago_tipo_pago = $cobro->tipo_pago === 'RECIBO' ? 'RECIBO' : 'FACTURA';
        $this->cargarDocumentos($cobro);

        $this->checkAvailableDestinations();
        $this->loadExistingPayments($cobro->clientes);

        $this->modalPago = true;
    }

    public function cerrarModalPago(): void
    {
        $this->modalPago = false;
        $this->resetPago();
    }

    // Reactivos del formulario de pago
    public function updatedPagoPaymentMethodId(int $id): void
    {
        $method = PaymentMethodType::find($id);

        if ($method && $method->is_credit == 1) {
            $this->pago_showBankAccountSelector = true;
            $this->bankAccounts = BankAccount::active()->get();
        } else {
            $this->pago_showBankAccountSelector = false;
            $this->pago_bank_account_id          = null;
        }
    }

    public function updatedPagoTipoPago(string $tipo): void
    {
        $this->reset('pago_paymentable_id');
        $notificacion = NotificacionCobro::with('cobro.clientes')->find($this->pagoNotificacionId);
        if ($notificacion) {
            $this->cargarDocumentos($notificacion->cobro);
        }
    }

    public function updatedPagoPaymentableId($id): void
    {
        if (!$id) {
            return;
        }

        if ($this->pago_paymentable_type === Ventas::class) {
            $doc = Ventas::find($id);
            if (!$doc) {
                return;
            }
            $this->pago_divisa = $doc->divisa;

            if ($doc->forma_pago === 'CONTADO') {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'VENTA AL CONTADO',
                    mensaje: 'Esta venta ya tiene pago al contado.'
                );
                $this->pago_paymentable_id = null;
                return;
            }
            if ($doc->pago_estado === Ventas::PAID) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'VENTA YA PAGADA',
                    mensaje: 'Esta venta ya fue pagada completamente.'
                );
                $this->pago_paymentable_id = null;
                return;
            }
        }

        if ($this->pago_paymentable_type === Recibos::class) {
            $doc = Recibos::find($id);
            if (!$doc) {
                return;
            }
            $this->pago_divisa = $doc->divisa;

            if ($doc->tipo_venta === 'CONTADO') {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'RECIBO AL CONTADO',
                    mensaje: 'Este recibo ya tiene pago al contado.'
                );
                $this->pago_paymentable_id = null;
                return;
            }
            if ($doc->pago_estado === Recibos::PAID) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'RECIBO YA PAGADO',
                    mensaje: 'Este recibo ya fue pagado completamente.'
                );
                $this->pago_paymentable_id = null;
                return;
            }
        }
    }

    // Guardar pago
    public function confirmarPago(): void
    {
        try {
            $notificacion = NotificacionCobro::with(['cobro', 'detalleCobro'])->findOrFail($this->pagoNotificacionId);

            if ($notificacion->estado !== 'PENDIENTE') {
                $this->notification()->error('Esta notificacion ya no esta pendiente');
                return;
            }

            // Modo ASOCIAR
            if ($this->pago_mode === 'associate') {
                if (empty($this->pago_existing_id)) {
                    $this->dispatch(
                        'notify-toast',
                        icon: 'error',
                        title: 'PAGO REQUERIDO',
                        mensaje: 'Selecciona un pago existente para asociar'
                    );
                    return;
                }

                $payment = Payments::findOrFail($this->pago_existing_id);
                $payment->update(['cobros_id' => $notificacion->cobro_id]);
                $notificacion->marcarComoPagado();

                $this->notification()->success(
                    title: 'Pago Asociado',
                    description: "Pago #{$payment->numero} asociado y periodo avanzado"
                );
                $this->cerrarModalPago();
                $this->dispatch('render');
                return;
            }

            // Modo CREAR
            $this->validate([
                'pago_payment_method_id' => 'required|integer',
                'pago_monto'             => 'required|numeric|min:0.01',
                'pago_fecha'             => 'required|date',
            ], [
                'pago_payment_method_id.required' => 'Selecciona un metodo de pago',
                'pago_monto.required'             => 'El monto es requerido',
                'pago_monto.min'                  => 'El monto debe ser mayor a cero',
                'pago_fecha.required'             => 'La fecha es requerida',
            ]);

            $this->pago_numero = (new PaymentsController())->setNextSequenceNumber();

            $destination = PaymentDestinationHelper::parseDestination($this->pago_payment_destination_id);

            $payment = Payments::create([
                'numero'            => $this->pago_numero,
                'fecha'             => $this->pago_fecha,
                'monto'             => $this->pago_monto,
                'divisa'            => $this->pago_divisa ?: 'PEN',
                'nota'              => $this->pago_nota ?: null,
                'numero_operacion'  => $this->pago_numero_operacion ?: null,
                'payment_method_id' => $this->pago_payment_method_id,
                'cobros_id'         => $notificacion->cobro_id,
                'paymentable_type'  => $this->pago_paymentable_id ? $this->pago_paymentable_type : null,
                'paymentable_id'    => $this->pago_paymentable_id ?: null,
                'documento'         => $this->pago_tipo_pago,
                'destination_type'  => $destination['destination_type'],
                'destination_id'    => $destination['destination_id'],
                'bank_account_id'   => $this->pago_bank_account_id ?: null,
            ]);

            // Marcar documento como PAID si corresponde
            if ($payment->paymentable) {
                $totalPagos = Payments::where('paymentable_type', $this->pago_paymentable_type)
                    ->where('paymentable_id', $this->pago_paymentable_id)
                    ->sum('monto');

                if ($totalPagos >= $payment->paymentable->total) {
                    $payment->paymentable->pago_estado = 'PAID';
                    $payment->paymentable->estado      = 'COMPLETADO';
                    $payment->paymentable->save();
                }
            }

            $notificacion->marcarComoPagado();

            $this->notification()->success(
                title: 'Pago Registrado',
                description: "Pago {$payment->numero} guardado y periodo avanzado"
            );

            $this->cerrarModalPago();
            $this->dispatch('render');
        } catch (\Throwable $th) {
            $this->notification()->error(
                title: 'Error al registrar el pago',
                description: $th->getMessage()
            );
        }
    }

    // Helpers privados del pago
    private function resetPago(): void
    {
        $this->reset([
            'pagoNotificacionId',
            'pago_numero',
            'pago_fecha',
            'pago_tipo_pago',
            'pago_titulo_doc',
            'pago_paymentable_type',
            'pago_paymentable_id',
            'pago_documentos',
            'pago_payment_method_id',
            'pago_payment_destination_id',
            'pago_showBankAccountSelector',
            'pago_bank_account_id',
            'pago_divisa',
            'pago_monto',
            'pago_numero_operacion',
            'pago_nota',
            'pago_mode',
            'pago_existing_id',
            'pago_existing_list',
        ]);
        $this->pago_payment_method_id = $this->paymentsMethods[0]['id'] ?? 1;
        $this->pago_divisa            = 'PEN';
        $this->pago_mode              = 'create';
    }

    private function cargarDocumentos(Cobros $cobro): void
    {
        $cliente = $cobro->clientes;

        if ($this->pago_tipo_pago === 'RECIBO' || $cobro->tipo_pago === 'RECIBO') {
            $this->pago_titulo_doc       = 'Numero de Recibo';
            $this->pago_paymentable_type = Recibos::class;
            $this->pago_documentos       = $this->loadRecibos($cliente);
        } else {
            $this->pago_titulo_doc       = 'Factura / Boleta';
            $this->pago_paymentable_type = Ventas::class;
            $this->pago_documentos       = $this->loadFacturas($cliente);
        }
    }

    private function loadFacturas($cliente): array
    {
        if (!$cliente) {
            return [];
        }

        return $cliente->ventas()
            ->where('pago_estado', 'UNPAID')
            ->get()
            ->map(fn($v) => [
                'id'    => $v->id,
                'text'  => $v->serie_correlativo,
                'monto' => $v->total,
                'divisa' => $v->divisa,
            ])
            ->toArray();
    }

    private function loadRecibos($cliente): array
    {
        if (!$cliente) {
            return [];
        }

        return $cliente->recibos()
            ->unpaid()
            ->get()
            ->map(fn($r) => [
                'id'    => $r->id,
                'text'  => $r->serie_numero,
                'monto' => $r->total,
                'divisa' => $r->divisa,
            ])
            ->toArray();
    }

    private function loadExistingPayments($cliente): void
    {
        if (!$cliente) {
            return;
        }

        $this->pago_existing_list = Payments::query()
            ->where(function ($q) use ($cliente) {
                $q->where('paymentable_type', 'App\\Models\\Ventas')
                    ->whereIn('paymentable_id', Ventas::where('cliente_id', $cliente->id)->pluck('id'));
            })
            ->orWhere(function ($q) use ($cliente) {
                $q->where('paymentable_type', 'App\\Models\\Recibos')
                    ->whereIn('paymentable_id', Recibos::where('clientes_id', $cliente->id)->pluck('id'));
            })
            ->whereNull('cobros_id')
            ->with('paymentable')
            ->latest()
            ->get()
            ->map(function ($p) {
                $doc = '';
                if ($p->paymentable_type === 'App\\Models\\Ventas') {
                    $doc = $p->paymentable?->serie_correlativo ?? 'FAC';
                } elseif ($p->paymentable_type === 'App\\Models\\Recibos') {
                    $doc = $p->paymentable?->serie_numero ?? 'REC';
                }
                return [
                    'id'    => $p->id,
                    'label' => "Pago #{$p->numero} - {$doc} - {$p->divisa} " . number_format($p->monto, 2) . " ({$p->fecha->format('d/m/Y')})",
                ];
            })
            ->toArray();
    }

    private function checkAvailableDestinations(): void
    {
        $hasCash        = Cash::where('estado', true)->exists();
        $hasBankAccount = BankAccount::where('status', true)->exists();

        if (!$hasCash && !$hasBankAccount) {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'Sin Destinos Disponibles',
                mensaje: 'No hay cajas abiertas ni cuentas bancarias activas.'
            );
        } elseif (!$hasCash) {
            $this->dispatch(
                'notify-toast',
                icon: 'info',
                title: 'Sin Caja Abierta',
                mensaje: 'No hay cajas abiertas. El pago en efectivo quedara sin destino.'
            );
        }
    }

    // Facturar (Emitir documento)
    public function redirectToFacturar(int $notificacionId): mixed
    {
        $notificacion = NotificacionCobro::with(['detalleCobro', 'cobro.clientes'])->find($notificacionId);

        if (!$notificacion) {
            $this->notification()->error('Notificacion no encontrada');
            return null;
        }

        $detalle = $notificacion->detalleCobro;
        $cobro   = $notificacion->cobro;
        $cliente = $cobro->clientes;

        session([
            'cobro_forma_pago'      => 'CONTADO',
            'cobro_redirect_back'   => route('admin.cobros.notificaciones'),
            'notificacion_cobro_id' => $notificacionId,
        ]);

        $detalleIds = json_encode([$detalle->id]);

        if ($cobro->tipo_pago === 'RECIBO') {
            return redirect()->route('admin.ventas.recibos.create', [
                'detalle_ids' => $detalleIds,
                'cobro_id'    => $cobro->id,
            ]);
        }

        if (($cliente->tipo_documento_id ?? null) == 6) {
            return redirect()->route('admin.factura.create', [
                'detalle_ids' => $detalleIds,
                'cobro_id'    => $cobro->id,
            ]);
        }

        return redirect()->route('admin.boleta.create', [
            'detalle_ids' => $detalleIds,
            'cobro_id'    => $cobro->id,
        ]);
    }

    // Cancelar
    public function cancelar(int $notificacionId): void
    {
        $this->dialog()->confirm([
            'title'       => 'Cancelar notificacion?',
            'description' => 'Esta accion no se puede deshacer',
            'icon'        => 'warning',
            'accept'      => [
                'label'  => 'Si, cancelar',
                'method' => 'confirmarCancelacion',
                'params' => $notificacionId,
            ],
            'reject' => ['label' => 'No, volver'],
        ]);
    }

    public function confirmarCancelacion(int $notificacionId): void
    {
        try {
            NotificacionCobro::findOrFail($notificacionId)
                ->cancelar('Cancelado desde el panel de notificaciones');

            $this->notification()->success('Notificacion cancelada correctamente');
            $this->dispatch('render');
        } catch (\Exception $e) {
            $this->notification()->error('Error al cancelar: ' . $e->getMessage());
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'estado', 'filtroVencimiento', 'clienteId']);
        $this->resetPage();
    }

    /**
     * Avanzar la fecha del detalle cobro al siguiente período
     */
    public function refreshFecha(int $notificacionId): void
    {
        $notificacion = NotificacionCobro::with('detalleCobro.cobro')->findOrFail($notificacionId);
        $detalle      = $notificacion->detalleCobro;

        if (!$detalle) {
            $this->notification()->error('Esta notificación no tiene un detalle de cobro asociado.');
            return;
        }

        $periodo = $detalle->cobro->periodo;

        $nuevaFecha = match ($periodo) {
            'MENSUAL'    => $detalle->fecha->copy()->addMonth(),
            'BIMENSUAL'  => $detalle->fecha->copy()->addMonths(2),
            'TRIMESTRAL' => $detalle->fecha->copy()->addMonths(3),
            'SEMESTRAL'  => $detalle->fecha->copy()->addMonths(6),
            'ANUAL'      => $detalle->fecha->copy()->addYear(),
            default      => $detalle->fecha,
        };

        $detalle->update(['fecha' => $nuevaFecha]);

        $this->notification()->success(
            title: 'Fecha Actualizada',
            description: 'La fecha del vehículo fue avanzada al siguiente período.'
        );
        $this->dispatch('render');
    }
}
