<?php

namespace App\Http\Controllers\v1;

use App\Exports\IncomeStatementExport;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\JournalDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class IncomeStatementReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        $startMonth = Carbon::parse($month)->startOfMonth();
        $endMonth = Carbon::parse($month)->endOfMonth();

        $incomeAccount = $this->getAccountByCategory('Pendapatan');
        $expenseAccount = $this->getAccountByCategory('Beban');

        $income = $this->getDebitCreditAccount($incomeAccount, $startMonth, $endMonth);
        $expense = $this->getDebitCreditAccount($expenseAccount, $startMonth, $endMonth);

        $response = [
            'income' => $income,
            'expense' => $expense
        ];

        return ResponseHelper::success($response);
    }

    public function getAccountByCategory($kategori)
    {
        return Account::whereHas('subcategory.category', function ($query) use ($kategori) {
            $query->where('categories.name', $kategori);
        })->get();
    }

    public function getDebitCreditAccount($akun, $startMonth, $endMonth)
    {
        $debitKredit = [];

        foreach ($akun as $item) {
            $total = JournalDetail::where('account_id', $item->id)
                ->select(DB::raw('sum(debit) as total_debit'), DB::raw('sum(credit) as total_credit'))
                ->whereHas('journal', function ($query) use ($startMonth, $endMonth) {
                    $query->whereBetween('date', [$startMonth, $endMonth]);
                })->first();

            if ($total->total_credit == 0 && $total->total_debit > 0) {
                $subtotal = $total->total_debit - $total->total_credit;
            } else {
                $subtotal = $total->total_credit - $total->total_debit;
            }

            $debitKredit[] = [
                'account_id' => $item->id,
                'account_code' => $item->code,
                'account_name' => $item->name,
                'total' => $subtotal,
            ];
        }

        return $debitKredit;
    }

    public function getDataToExport(Request $request)
    {
        $month = $request->input('month');
        $startMonth = Carbon::parse($month)->startOfMonth();
        $endMonth = Carbon::parse($month)->endOfMonth();

        $incomeAccount = $this->getAccountByCategory('Pendapatan');
        $expenseAccount = $this->getAccountByCategory('Beban');

        $income = $this->getDebitCreditAccount($incomeAccount, $startMonth, $endMonth);
        $expense = $this->getDebitCreditAccount($expenseAccount, $startMonth, $endMonth);

        $response = [
            'income' => $income,
            'expense' => $expense
        ];

        return $response;
    }

    public function export(Request $request)
    {
        $data = $this->getDataToExport($request);
        return Excel::download(new IncomeStatementExport($data), 'income-statement.xlsx');
    }
}
