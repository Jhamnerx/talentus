<?php

namespace App\Livewire\Admin\Finanzas\Transacciones;

use App\Models\Cash;
use App\Models\Payments;
use App\Models\BankAccount;
use App\Http\Resources\MovementCollection;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaccionesExport;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $from = '';
    public $to = '';
    public $tipo_filter = ''; // all, ingreso, egreso
    public $destination_type = ''; // all, cash, bank
    public $cash_id = '';
    public $bank_account_id = '';

    #[On('render')]
    public function render()
    {
        $query = Payments::query()
            ->with(['paymentable', 'destination', 'user', 'bankAccount'])
            ->latest('created_at');

        // Búsqueda por texto
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('numero_operacion', 'like', '%' . $this->search . '%')
                    ->orWhereHas('paymentable', function ($subQ) {
                        $subQ->where('numero', 'like', '%' . $this->search . '%')
                            ->orWhere('numero_comprobante', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filtro por tipo de movimiento
        if ($this->tipo_filter === 'ingreso') {
            $query->ingresos();
        } elseif ($this->tipo_filter === 'egreso') {
            $query->egresos();
        }

        // Filtro por tipo de destino
        if ($this->destination_type === 'cash') {
            $query->byDestinationType('App\\Models\\Cash');
        } elseif ($this->destination_type === 'bank') {
            $query->byDestinationType('App\\Models\\BankAccount');
        }

        // Filtro por caja específica
        if ($this->cash_id) {
            $query->byCash($this->cash_id);
        }

        // Filtro por cuenta bancaria específica
        if ($this->bank_account_id) {
            $query->byBankAccount($this->bank_account_id);
        }

        // Filtro por rango de fechas
        if (!empty($this->from) && !empty($this->to)) {
            $query->whereDateBetween($this->from, $this->to);
        }

        // Usar paginación y transformar con MovementCollection
        $paginator = $query->paginate(15);

        // Pasar filtros a la request
        request()->merge([
            'search' => $this->search,
            'tipo_filter' => $this->tipo_filter,
            'destination_type' => $this->destination_type,
            'cash_id' => $this->cash_id,
            'bank_account_id' => $this->bank_account_id,
            'from' => $this->from,
            'to' => $this->to,
            'per_page' => 15,
        ]);

        // Transformar cada item del paginator con MovementCollection
        $transformedItems = $paginator->getCollection()->map(function ($payment, $index) {
            return $this->transformPaymentToMovement($payment, $index);
        });

        // Reemplazar los items originales con los transformados
        $paginator->setCollection($transformedItems);

        $movimientos = $paginator;

        // Calcular totales
        $totales = $this->calcularTotales($query);

        $cajas = Cash::all();
        $cuentasBancarias = BankAccount::where('status', true)->get();

        return view('livewire.admin.finanzas.transacciones.index', compact(
            'movimientos',
            'totales',
            'cajas',
            'cuentasBancarias'
        ));
    }

    private function calcularTotales($query)
    {
        // Clonar query para no afectar paginación
        $allRecords = (clone $query)->get();

        $ingresos = 0;
        $egresos = 0;

        foreach ($allRecords as $record) {
            // Convertir USD a PEN usando tipo de cambio del registro
            $monto = $record->divisa === 'USD'
                ? $record->monto * ($record->tipo_cambio ?: 3.75)
                : $record->monto;

            if ($record->type_movement === 'INGRESO') {
                $ingresos += $monto;
            } elseif ($record->type_movement === 'EGRESO') {
                $egresos += $monto;
            }
        }

        return [
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'saldo' => $ingresos - $egresos,
        ];
    }

    public function filter($dias)
    {
        switch ($dias) {
            case '1':
                $this->from = date('Y-m-d');
                $this->to = date('Y-m-d');
                break;
            case '7':
                $this->from = date('Y-m-d', strtotime('-7 days'));
                $this->to = date('Y-m-d');
                break;
            case '30':
                $this->from = date('Y-m-d', strtotime('-1 month'));
                $this->to = date('Y-m-d');
                break;
            case '0':
                $this->from = '';
                $this->to = '';
                break;
        }
    }

    public function export()
    {
        return Excel::download(
            new TransaccionesExport(
                $this->from,
                $this->to,
                $this->tipo_filter,
                $this->destination_type,
                $this->cash_id,
                $this->bank_account_id,
                $this->search
            ),
            'transacciones_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Transformar Payment a formato de movimiento compatible con la vista
     */
    private function transformPaymentToMovement($payment, $index)
    {
        // Obtener monto (convertir USD a PEN si es necesario)
        $amount = $payment->divisa === 'USD'
            ? $payment->monto * ($payment->tipo_cambio ?: 3.75)
            : $payment->monto;

        // Determinar input/output según tipo de movimiento
        $input = $payment->type_movement === 'INGRESO'
            ? number_format($payment->monto, 2, '.', '')
            : '-';

        $output = $payment->type_movement === 'EGRESO'
            ? number_format($payment->monto, 2, '.', '')
            : '-';

        // Símbolo de moneda
        $currencySymbol = $payment->divisa === 'USD' ? '$' : 'S/';

        return [
            'id' => $payment->id,
            'index' => $index + 1,

            // Fecha
            'date_of_payment' => $payment->fecha ? \Carbon\Carbon::parse($payment->fecha)->format('Y-m-d H:i:s') : null,
            'created_at' => $payment->created_at->format('d/m/Y H:i'),

            // Tipo
            'type_movement' => $payment->type_movement,
            'instance_type' => $payment->payment_type_description,

            // Documento
            'document_number' => $payment->document_number,

            // Persona
            'person_name' => $payment->person_name,

            // Destino
            'destination_description' => $payment->destination_description,
            'destination_name' => $payment->destination_description,

            // Montos
            'currency_type_id' => $currencySymbol,
            'original_amount' => number_format($payment->monto, 2, '.', ''),
            'amount_pen' => number_format($amount, 2, '.', ''),
            'input' => $input,
            'output' => $output,

            // Raw payment para acceso directo
            'payment' => $payment,
        ];
    }
}
