<?php

namespace App\Exports;

use App\Models\GlobalPayment;
use App\Models\BankAccount;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class MovimientosExport implements FromView, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected $records;
    protected $company;
    protected $dateStart;
    protected $dateEnd;
    protected $filters;

    public function __construct(
        $from = null,
        $to = null,
        $tipo = null,
        $destinationType = null,
        $cashId = null,
        $bankAccountId = null,
        $search = ''
    ) {
        $this->dateStart = $from;
        $this->dateEnd = $to;
        $this->filters = [
            'tipo' => $tipo,
            'destination_type' => $destinationType,
            'cash_id' => $cashId,
            'bank_account_id' => $bankAccountId,
            'search' => $search,
        ];

        $this->buildRecords();
    }

    protected function buildRecords()
    {
        $query = GlobalPayment::query()
            ->withRelationsForReport()
            ->latestPayments();

        // Aplicar filtros (igual que TransaccionesExport)
        if (!empty($this->filters['search'])) {
            $query->where(function ($q) {
                $q->whereHas('payment.paymentable', function ($subQ) {
                    $subQ->where('numero', 'like', '%' . $this->filters['search'] . '%')
                        ->orWhere('numero_comprobante', 'like', '%' . $this->filters['search'] . '%')
                        ->orWhereHas('cliente', function ($clienteQ) {
                            $clienteQ->where('razon_social', 'like', '%' . $this->filters['search'] . '%');
                        })
                        ->orWhereHas('proveedor', function ($provQ) {
                            $provQ->where('nombre', 'like', '%' . $this->filters['search'] . '%');
                        });
                });
            });
        }

        if ($this->filters['tipo'] === 'ingreso') {
            $query->ingresos();
        } elseif ($this->filters['tipo'] === 'egreso') {
            $query->egresos();
        }

        if ($this->filters['destination_type'] === 'cash') {
            $query->whereCashDestination();
        } elseif ($this->filters['destination_type'] === 'bank') {
            $query->whereBankDestination();
        }

        if ($this->filters['cash_id']) {
            $query->byCash($this->filters['cash_id']);
        }

        if ($this->filters['bank_account_id']) {
            $query->byDestinationType(BankAccount::class)
                ->where('destination_id', $this->filters['bank_account_id']);
        }

        if (!empty($this->dateStart) && !empty($this->dateEnd)) {
            $query->whereDateBetween($this->dateStart, $this->dateEnd);
        }

        $this->records = $query->get();
    }

    public function title(): string
    {
        return substr('Movimientos de Caja', 0, 30);
    }

    public function view(): View
    {
        // Obtener empresa actual
        $this->company = \App\Models\Empresa::find(session('empresa'));

        return view('exports.movimientos', [
            'records' => $this->records,
            'company' => $this->company,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd,
            'filters' => $this->filters,
        ]);
    }
}
