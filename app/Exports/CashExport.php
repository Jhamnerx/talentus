<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $cash;

    public function __construct(Cash $cash)
    {
        $this->cash = $cash;
        $this->cash->load(['user']);
    }

    public function collection()
    {
        $data = collect();

        // Header info
        $data->push(['REPORTE DE CAJA CHICA']);
        $data->push(['Nombre:', $this->cash->nombre ?? 'Caja General']);
        $data->push(['Usuario:', $this->cash->user->name]);
        $data->push(['Fecha Apertura:', $this->cash->fecha_apertura->format('d/m/Y H:i:s')]);
        if ($this->cash->fecha_cierre) {
            $data->push(['Fecha Cierre:', $this->cash->fecha_cierre->format('d/m/Y H:i:s')]);
        }
        $data->push(['Estado:', $this->cash->estado ? 'Abierta' : 'Cerrada']);
        $data->push(['']);

        // Saldos iniciales
        $data->push(['SALDOS INICIALES']);
        $data->push(['PEN:', 'S/ ' . number_format($this->cash->saldo_inicial, 2)]);
        $data->push(['USD:', '$ ' . number_format($this->cash->saldo_inicial_usd ?? 0, 2)]);
        $data->push(['']);

        // Obtener todos los movimientos
        $payments = $this->cash->globalDestination()
            ->with(['paymentable', 'paymentMethod'])
            ->get();

        $cash_income = 0;
        $cash_egress = 0;
        $cash_income_usd = 0;
        $cash_egress_usd = 0;

        if ($payments->isNotEmpty()) {
            $data->push(['MOVIMIENTOS REGISTRADOS']);
            $data->push(['Tipo Doc.', 'Documento', 'Fecha', 'Cliente/Proveedor', 'Método Pago', 'Moneda', 'Monto', 'Tipo Mov.']);

            foreach ($payments as $payment) {
                $paymentable = $payment->paymentable;

                if (!$paymentable) continue;

                $modelClass = get_class($paymentable);
                $tipoDoc = '';
                $documento = '';
                $fecha = '';
                $clienteProveedor = '';
                $tipoMovimiento = '';
                $moneda = $payment->moneda ?? 'PEN';
                $monto = $payment->monto;

                // Sumar ingresos/egresos según moneda
                switch ($modelClass) {
                    case 'App\Models\Recibos':
                        $tipoDoc = 'Recibo';
                        $documento = $paymentable->serie . '-' . $paymentable->numero;
                        $fecha = $paymentable->fecha_emision ?? '-';
                        $clienteProveedor = $paymentable->clientes->razon_social ?? '';
                        $tipoMovimiento = 'INGRESO';

                        if ($moneda === 'USD') {
                            $cash_income_usd += $monto;
                        } else {
                            $cash_income += $monto;
                        }
                        break;

                    case 'App\Models\Ventas':
                        $cliente = $paymentable->cliente;
                        $tipoDoc = $paymentable->tipo_comprobante_id ?? 'Venta';
                        $documento = ($paymentable->serie ?? '') . '-' . ($paymentable->numero ?? '');
                        $fecha = $paymentable->fecha_emision ?? '-';
                        $clienteProveedor = $cliente->nombre_completo ?? $cliente->razon_social ?? '';
                        $tipoMovimiento = 'INGRESO';

                        if ($moneda === 'USD') {
                            $cash_income_usd += $monto;
                        } else {
                            $cash_income += $monto;
                        }
                        break;

                    case 'App\Models\ExpensePayment':
                        $expense = $paymentable->expense;
                        $supplier = $expense->supplier ?? null;
                        $tipoDoc = 'Gasto';
                        $documento = $expense->expense_reason->name ?? 'Gasto general';
                        $fecha = $expense->expense_date ?? '-';
                        $clienteProveedor = $supplier->name ?? 'Proveedor interno';
                        $tipoMovimiento = 'EGRESO';

                        if ($moneda === 'USD') {
                            $cash_egress_usd += $monto;
                        } else {
                            $cash_egress += $monto;
                        }
                        break;

                    case 'App\Models\Compras':
                        $proveedor = $paymentable->proveedor;
                        $tipoDoc = $paymentable->tipo_comprobante ?? 'Compra';
                        $documento = ($paymentable->serie ?? '') . '-' . ($paymentable->correlativo ?? '');
                        $fecha = $paymentable->fecha_emision ?? '-';
                        $clienteProveedor = $proveedor->razon_social ?? $proveedor->nombre ?? '';
                        $tipoMovimiento = 'EGRESO';

                        if ($moneda === 'USD') {
                            $cash_egress_usd += $monto;
                        } else {
                            $cash_egress += $monto;
                        }
                        break;

                    case 'App\Models\Cotizaciones':
                        $cliente = $paymentable->cliente;
                        $tipoDoc = 'Cotización';
                        $documento = $paymentable->codigo ?? '-';
                        $fecha = $paymentable->fecha_emision ?? '-';
                        $clienteProveedor = $cliente->razon_social ?? $cliente->nombre_completo ?? '';
                        $tipoMovimiento = 'INGRESO';

                        if ($moneda === 'USD') {
                            $cash_income_usd += $monto;
                        } else {
                            $cash_income += $monto;
                        }
                        break;

                    case 'App\Models\WorkOrder':
                        $vehiculo = $paymentable->vehiculo;
                        $tipoDoc = 'Orden Trabajo';
                        $documento = $paymentable->codigo ?? '-';
                        $fecha = $paymentable->created_at->format('Y-m-d') ?? '-';
                        $clienteProveedor = $vehiculo->placa ?? 'Vehículo';
                        $tipoMovimiento = 'INGRESO';

                        if ($moneda === 'USD') {
                            $cash_income_usd += $monto;
                        } else {
                            $cash_income += $monto;
                        }
                        break;

                    default:
                        continue 2;
                }

                $metodoPago = $payment->paymentMethod->descripcion ?? 'Efectivo';
                $simboloMoneda = $moneda === 'USD' ? '$' : 'S/';

                $data->push([
                    $tipoDoc,
                    $documento,
                    $fecha,
                    $clienteProveedor,
                    $metodoPago,
                    $moneda,
                    $simboloMoneda . ' ' . number_format($monto, 2),
                    $tipoMovimiento,
                ]);
            }
        }

        // Totales finales
        $data->push(['']);
        $data->push(['TOTALES PEN (SOLES)']);
        $data->push(['Saldo Inicial:', 'S/ ' . number_format($this->cash->saldo_inicial, 2)]);
        $data->push(['Total Ingresos:', 'S/ ' . number_format($cash_income, 2)]);
        $data->push(['Total Egresos:', 'S/ ' . number_format($cash_egress, 2)]);
        $data->push(['Saldo Final:', 'S/ ' . number_format($this->cash->saldo_inicial + $cash_income - $cash_egress, 2)]);

        $data->push(['']);
        $data->push(['TOTALES USD (DÓLARES)']);
        $data->push(['Saldo Inicial:', '$ ' . number_format($this->cash->saldo_inicial_usd ?? 0, 2)]);
        $data->push(['Total Ingresos:', '$ ' . number_format($cash_income_usd, 2)]);
        $data->push(['Total Egresos:', '$ ' . number_format($cash_egress_usd, 2)]);
        $data->push(['Saldo Final:', '$ ' . number_format(($this->cash->saldo_inicial_usd ?? 0) + $cash_income_usd - $cash_egress_usd, 2)]);

        return $data;
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Caja ' . $this->cash->fecha_apertura->format('d-m-Y');
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            9 => ['font' => ['bold' => true, 'size' => 12]],
            13 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
