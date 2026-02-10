<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Traits\FinanceTrait; // Incluir el trait
use App\Models\Cash;
use App\Models\Payments;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * EJEMPLO: Controlador de reportes de caja
 * 
 * USO DEL FinanceTrait:
 * - calculateTotalCurrencyType() - Convertir totales a PEN o USD
 * - getBalanceByCash() - Calcular balance de caja en PEN o USD
 * - getPaymentDestinations() - Obtener lista de cajas y bancos
 */
class CashReportController extends Controller
{
    use FinanceTrait; // ✅ Se usa en CONTROLADORES, NO en modelos

    /**
     * Reporte de caja con totales en PEN y USD
     * 
     * EJEMPLO: Muestra cómo usar calculateTotalCurrencyType()
     */
    public function index(Request $request)
    {
        $cashId = $request->input('cash_id');
        $dateFrom = $request->input('date_from', now()->startOfMonth());
        $dateTo = $request->input('date_to', now()->endOfMonth());

        $payments = Payments::where('destination_type', Cash::class)
            ->where('destination_id', $cashId)
            ->whereBetween('fecha', [$dateFrom, $dateTo])
            ->with('paymentable')
            ->get();

        // Calcular totales en AMBAS monedas usando FinanceTrait
        $totalPEN = $this->calculateTotalCurrencyType($payments, 'PEN');
        $totalUSD = $this->calculateTotalCurrencyType($payments, 'USD');

        // Calcular balance actual de la caja en PEN y USD
        $balancePEN = $this->getBalanceByCash($cashId, 'PEN');
        $balanceUSD = $this->getBalanceByCash($cashId, 'USD');

        return view('admin.reports.cash', [
            'payments' => $payments,
            'totalPEN' => $totalPEN,
            'totalUSD' => $totalUSD,
            'balancePEN' => $balancePEN,
            'balanceUSD' => $balanceUSD,
        ]);
    }

    /**
     * EJEMPLO: Reporte de ingresos/egresos separados
     * 
     * Muestra cómo filtrar por type_movement y convertir a moneda específica
     */
    public function incomeExpense(Request $request)
    {
        $cashId = $request->input('cash_id');
        $currencyType = $request->input('currency_type', 'PEN'); // PEN o USD

        // Obtener ingresos
        $incomePayments = Payments::where('destination_type', Cash::class)
            ->where('destination_id', $cashId)
            ->where('type_movement', 'INGRESO')
            ->with('payment.paymentable')
            ->get()
            ->pluck('payment')
            ->filter();

        // Obtener egresos
        $expensePayments = Payments::where('destination_type', Cash::class)
            ->where('destination_id', $cashId)
            ->where('type_movement', 'EGRESO')
            ->with('payment.paymentable')
            ->get()
            ->pluck('payment')
            ->filter();

        // Calcular totales con conversión automática
        $totalIncome = $this->calculateTotalCurrencyType($incomePayments, $currencyType);
        $totalExpense = $this->calculateTotalCurrencyType($expensePayments, $currencyType);
        $netBalance = $totalIncome - $totalExpense;

        return view('admin.reports.income-expense', [
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netBalance' => $netBalance,
            'currencyType' => $currencyType,
        ]);
    }

    /**
     * EJEMPLO: API endpoint para obtener balance actual
     * 
     * Útil para dashboards que muestran balance en tiempo real
     */
    public function balance(Request $request)
    {
        $cashId = $request->input('cash_id');

        $balancePEN = $this->getBalanceByCash($cashId, 'PEN');
        $balanceUSD = $this->getBalanceByCash($cashId, 'USD');

        return response()->json([
            'success' => true,
            'balance' => [
                'PEN' => number_format($balancePEN, 2),
                'USD' => number_format($balanceUSD, 2),
            ],
        ]);
    }

    /**
     * EJEMPLO: Comparar ingresos entre varias cajas
     */
    public function compareMultipleCashes(Request $request)
    {
        $cashIds = $request->input('cash_ids', []); // [1, 2, 3]
        $currencyType = $request->input('currency_type', 'PEN');

        $comparison = [];

        foreach ($cashIds as $cashId) {
            $cash = Cash::find($cashId);

            if (!$cash) {
                continue;
            }

            $balance = $this->getBalanceByCash($cashId, $currencyType);

            $comparison[] = [
                'cash_name' => $cash->nombre,
                'balance' => $balance,
            ];
        }

        return view('admin.reports.compare-cashes', [
            'comparison' => $comparison,
            'currencyType' => $currencyType,
        ]);
    }
}
