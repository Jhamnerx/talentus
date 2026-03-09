<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\Cash;
use App\Models\Empresa;
use App\Models\plantilla;
use App\Exports\CashExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CajaChicaPdfController extends Controller
{

    /**
     * Prepara los datos comunes del encabezado para todos los reportes
     * Basado en FactuPRO: getHeaderCommonDataToReport()
     * Usa datos reales de la tabla plantilla
     */
    private function getHeaderCommonDataToReport(Cash $cash)
    {
        $user = $cash->user;

        // ✅ Obtener empresa desde la sesión
        $empresaId = session('empresa');
        $empresa = Empresa::find($empresaId);

        // ✅ Obtener plantilla relacionada con la empresa
        $plantilla = $empresa ? $empresa->plantilla : null;

        return [
            'cash' => $cash,
            'cash_user_name' => $user->name,
            'cash_date_opening' => $cash->fecha_apertura,
            'cash_time_opening' => $cash->hora_apertura,
            'cash_state' => $cash->estado,
            'cash_date_closed' => $cash->fecha_cierre,
            'cash_time_closed' => $cash->hora_cierre,
            'company_name' => $plantilla->razon_social ?? config('app.name'),
            'company_number' => $plantilla->ruc ?? '-',
            'establishment_address' => is_array($plantilla->direccion) ? ($plantilla->direccion['direccion'] ?? '-') : ($plantilla->direccion ?? '-'),
            'establishment_department_description' => '-',
            'establishment_district_description' => '-',
            'company' => $plantilla,
        ];
    }

    /**
     * Prepara todos los datos para los reportes de caja
     * Basado en FactuPRO: setDataToReport()
     * Adaptado para la estructura de Talentus (globalDestination + Payment polymorphic)
     */
    private function setDataToReport($cash_id, $summary = 0)
    {
        set_time_limit(0);

        /** @var Cash $cash */
        $cash = Cash::with(['user'])->findOrFail($cash_id);

        $data = $this->getHeaderCommonDataToReport($cash);
        $data['summary'] = ($summary) ? 1 : 0;

        // Inicializar contadores
        $cash_income = 0;
        $cash_egress = 0;
        $final_balance = 0;

        // Obtener TODOS los pagos usando globalDestination()
        $payments = $cash->globalDestination()
            ->with(['paymentable', 'paymentMethod'])
            ->get();

        $all_documents = [];

        foreach ($payments as $payment) {
            $paymentable = $payment->paymentable;

            if (!$paymentable) continue;

            $temp = [];
            $order_number = 1;

            // Determinar tipo de documento y datos
            $modelClass = get_class($paymentable);

            switch ($modelClass) {
                case 'App\Models\Recibos':
                    // Recibos - Ingresos
                    $cliente = $paymentable->clientes;
                    $cash_income += $payment->monto;
                    $final_balance += $payment->monto;

                    $temp = [
                        'type_transaction' => 'Venta',
                        'document_type_description' => 'RECIBO',
                        'number' => $paymentable->numero_documento ?: 'R-' . $paymentable->id,
                        'date_of_issue' => $payment->created_at->format('Y-m-d'),
                        'date_sort' => $payment->created_at,
                        'customer_name' => $cliente->razon_social ?? '-',
                        'customer_number' => $cliente->numero_documento ?? '-',
                        'total' => $payment->monto,
                        'currency_type_id' => $payment->divisa,
                        'tipo' => 'recibo',
                        'total_payments' => $payment->monto,
                        'type_transaction_prefix' => 'income',
                        'order_number_key' => '2_' . $payment->created_at->format('YmdHis'),
                    ];
                    $order_number = 2;
                    break;

                case 'App\Models\Ventas':
                    // Ventas - Ingresos
                    $cliente = $paymentable->cliente;
                    $cash_income += $payment->monto;
                    $final_balance += $payment->monto;

                    $temp = [
                        'type_transaction' => 'Venta',
                        'document_type_description' => 'VENTA',
                        'number' => 'V-' . $paymentable->id,
                        'date_of_issue' => $payment->created_at->format('Y-m-d'),
                        'date_sort' => $payment->created_at,
                        'customer_name' => $cliente->razon_social ?? '-',
                        'customer_number' => $cliente->numero_documento ?? '-',
                        'total' => $payment->monto,
                        'currency_type_id' => $payment->divisa,
                        'tipo' => 'venta',
                        'total_payments' => $payment->monto,
                        'type_transaction_prefix' => 'income',
                        'order_number_key' => '1_' . $payment->created_at->format('YmdHis'),
                    ];
                    $order_number = 1;
                    break;

                case 'App\Models\ExpensePayment':
                    // Gastos - Egresos
                    $expense = $paymentable->expense;
                    $supplier = $expense->supplier ?? null;
                    $cash_egress += $payment->monto;
                    $final_balance -= $payment->monto;

                    $temp = [
                        'type_transaction' => 'Gasto',
                        'document_type_description' => $expense->expenseType->nombre ?? 'GASTO',
                        'number' => $expense->numero ?? 'G-' . $expense->id,
                        'date_of_issue' => $payment->created_at->format('Y-m-d'),
                        'date_sort' => $payment->created_at,
                        'customer_name' => $supplier->nombre ?? '-',
                        'customer_number' => $supplier->numero_documento ?? '-',
                        'total' => -$payment->monto,
                        'currency_type_id' => $payment->divisa,
                        'tipo' => 'expense',
                        'total_payments' => -$payment->monto,
                        'type_transaction_prefix' => 'egress',
                        'order_number_key' => '9_' . $payment->created_at->format('YmdHis'),
                    ];
                    $order_number = 9;
                    break;

                case 'App\Models\Compras':
                    // Compras - Egresos
                    $proveedor = $paymentable->proveedor;
                    $cash_egress += $payment->monto;
                    $final_balance -= $payment->monto;

                    $temp = [
                        'type_transaction' => 'Compra',
                        'document_type_description' => 'COMPRA',
                        'number' => $paymentable->numero_documento ?: 'C-' . $paymentable->id,
                        'date_of_issue' => $payment->created_at->format('Y-m-d'),
                        'date_sort' => $payment->created_at,
                        'customer_name' => $proveedor->razon_social ?? '-',
                        'customer_number' => $proveedor->numero_documento ?? '-',
                        'total' => -$payment->monto,
                        'currency_type_id' => $payment->divisa,
                        'tipo' => 'compra',
                        'total_payments' => -$payment->monto,
                        'type_transaction_prefix' => 'egress',
                        'order_number_key' => '8_' . $payment->created_at->format('YmdHis'),
                    ];
                    $order_number = 8;
                    break;

                case 'App\Models\Cotizaciones':
                    // Cotizaciones - Ingresos (Pagos a cuenta)
                    $cliente = $paymentable->cliente;
                    $cash_income += $payment->monto;
                    $final_balance += $payment->monto;

                    $temp = [
                        'type_transaction' => 'Venta (Pago a cuenta)',
                        'document_type_description' => 'COTIZACIÓN',
                        'number' => $paymentable->numero ?: 'COT-' . $paymentable->id,
                        'date_of_issue' => $payment->created_at->format('Y-m-d'),
                        'date_sort' => $payment->created_at,
                        'customer_name' => $cliente->razon_social ?? '-',
                        'customer_number' => $cliente->numero_documento ?? '-',
                        'total' => $payment->monto,
                        'currency_type_id' => $payment->divisa,
                        'tipo' => 'cotizacion',
                        'total_payments' => $payment->monto,
                        'type_transaction_prefix' => 'income',
                        'order_number_key' => '5_' . $payment->created_at->format('YmdHis'),
                    ];
                    $order_number = 5;
                    break;

                case 'App\Models\WorkOrder':
                    // Órdenes de Trabajo - Ingresos
                    $vehiculo = $paymentable->vehiculo;
                    $cliente = $vehiculo->cliente ?? null;
                    $cash_income += $payment->monto;
                    $final_balance += $payment->monto;

                    $temp = [
                        'type_transaction' => 'Venta',
                        'document_type_description' => 'ORDEN DE TRABAJO',
                        'number' => $paymentable->codigo ?: 'OT-' . $paymentable->id,
                        'date_of_issue' => $payment->created_at->format('Y-m-d'),
                        'date_sort' => $payment->created_at,
                        'customer_name' => $cliente->razon_social ?? '-',
                        'customer_number' => $cliente->numero_documento ?? '-',
                        'total' => $payment->monto,
                        'currency_type_id' => $payment->divisa,
                        'tipo' => 'orden_trabajo',
                        'total_payments' => $payment->monto,
                        'type_transaction_prefix' => 'income',
                        'order_number_key' => '4_' . $payment->created_at->format('YmdHis'),
                    ];
                    $order_number = 4;
                    break;
            }

            if (!empty($temp)) {
                $temp['total_string'] = number_format($temp['total'], 2, '.', '');
                $temp['total_payments'] = number_format($temp['total_payments'], 2, '.', '');
                $all_documents[] = $temp;
            }
        }

        // Calcular totales finales
        $cash_final_balance = $final_balance + $cash->saldo_inicial;

        $data['all_documents'] = $all_documents;
        $data['cash_documents_total'] = count($all_documents);
        $data['cash_income'] = number_format($cash_income, 2, '.', '');
        $data['cash_egress'] = number_format($cash_egress, 2, '.', '');
        $data['cash_beginning_balance'] = number_format($cash->saldo_inicial, 2, '.', '');
        $data['cash_final_balance'] = number_format($cash_final_balance, 2, '.', '');
        $data['total_cash_payment_method_type_01'] = $data['cash_final_balance'];
        $data['total_cash_income_pmt_01'] = $data['cash_income'];
        $data['total_cash_egress_pmt_01'] = $data['cash_egress'];

        return $data;
    }

    /**
     * PDF A4 - Reporte principal con todos los documentos
     */
    public function reportA4(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $data = $this->setDataToReport($caja->id, 0);

        $pdf = Pdf::loadView('pdf.caja-chica.report-a4', [
            'data' => $data,
        ]);

        return $pdf->stream("Reporte_Caja_General_{$caja->fecha_apertura}.pdf");
    }

    /**
     * Excel - Detalle completo de caja para análisis
     */
    public function reportExcel(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        return Excel::download(
            new CashExport($caja),
            "Reporte_Caja_General_{$caja->fecha_apertura}.xlsx"
        );
    }
}
