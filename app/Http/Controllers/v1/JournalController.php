<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\JournalDetail;
use App\Models\Journal;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = Journal::join('journal_details', 'journals.id', '=', 'journal_details.journal_id')
            ->select('journals.id', 'journals.date', 'journals.description', DB::raw('SUM(journal_details.debit) as total'), DB::raw('MAX(journals.transaction_code) as transaction_transaction_code'))
            ->groupBy('journals.id', 'journals.date', 'journals.description');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('journals.description', 'like', "%$search%")
                ->orWhere('journals.transaction_code', 'like', "%$search%");
        }

        $journals = $query->paginate($per_page);
        return ResponseHelper::success($journals);
    }

    public function show($id)
    {
        $journal = Journal::with('journal_details.account')->where('id', $id)->get();

        if (!$journal) {
            return ResponseHelper::error('Jurnal tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($journal);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'transaction_code' => ['required', 'string', Rule::unique(Journal::class, 'transaction_code')],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
            'detail' => ['required', 'array'],
            'detail.*.account_id' => ['required', Rule::exists(Account::class, 'id')],
            'detail.*.debit' => ['required', 'numeric'],
            'detail.*.credit' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();
        try {
            $total_debit = collect($input['detail'])->sum('debit');
            $total_credit = collect($input['detail'])->sum('credit');

            if ($total_debit != $total_credit) {
                DB::rollBack();
                return ResponseHelper::error('Total debit dan credit harus sama', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $journal = Journal::create([
                'transaction_code' => $input['transaction_code'],
                'date' => $input['date'],
                'description' => $input['description'],
            ]);

            foreach ($input['detail'] as $entry) {
                JournalDetail::create([
                    'journal_id' => $journal->id,
                    'account_id' => $entry['account_id'],
                    'debit' => $entry['debit'],
                    'credit' => $entry['credit'],
                ]);

                $account = Account::find($entry['account_id']);
                $subcategory = Subcategory::find($account->subcategory_id);

                /**
                 * Saldo Normal Aktiva (id: 1) dan Beban (id: 5) ada di Debit
                 * Saldo Normal Hutang, Modal, dan Pendapatan ada di Kredit
                 */

                $saldoDebit = in_array($subcategory->category_id, [1, 5]);

                if ($saldoDebit) {
                    if ($entry['credit'] > $account->balance) {
                        DB::rollBack();
                        return ResponseHelper::error('Saldo tidak mencukupi', Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    if ($entry['debit'] > 0) {
                        $account->balance += $entry['debit'];
                    } else {
                        $account->balance -= $entry['credit'];
                    }
                } else {
                    if ($entry['debit'] > $account->balance) {
                        DB::rollBack();
                        return ResponseHelper::error('Kelebihan pembayaran', Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    if ($entry['credit'] > 0) {
                        $account->balance += $entry['credit'];
                    } else {
                        $account->balance -= $entry['debit'];
                    }
                }

                $account->save();
            }

            DB::commit();
            return ResponseHelper::success([], 'Jurnal berhasil ditambahkan', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            return ResponseHelper::error($exception->getLine() . ' ' . $exception->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        }
    }
}
