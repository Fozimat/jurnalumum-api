<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\JournalRequest;
use App\Http\Resources\JournalDetailResource;
use App\Http\Resources\JournalResource;
use App\Models\Account;
use App\Models\JournalDetail;
use App\Models\Journal;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = Journal::join('journal_details', 'journals.id', '=', 'journal_details.journal_id')
            ->select('journals.id', 'journals.date', 'journals.description', DB::raw('SUM(journal_details.debit) as total'), 'journals.transaction_code')
            ->groupBy('journals.id');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('journals.description', 'like', "%$search%")
                ->orWhere('journals.transaction_code', 'like', "%$search%");
        }

        $journals = $query->paginate($per_page);
        return $this->sendResponse($this->ResourceCollection(JournalResource::collection($journals)));
    }

    public function show($id)
    {
        $journal = Journal::with('journal_details.account')->where('id', $id)->first();

        if (!$journal) {
            return $this->sendError('Jurnal tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse(new JournalDetailResource($journal));
    }

    public function store(JournalRequest $request)
    {
        DB::beginTransaction();
        try {
            $total_debit = collect($request['detail'])->sum('debit');
            $total_credit = collect($request['detail'])->sum('credit');

            if ($total_debit != $total_credit) {
                DB::rollBack();
                return $this->sendError('Total debit dan credit harus sama', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $journal = Journal::create([
                'transaction_code' => $request['transaction_code'],
                'date' => $request['date'],
                'description' => $request['description'],
            ]);

            foreach ($request['detail'] as $entry) {
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

                $debitBalance = in_array($subcategory->category_id, [1, 5]);

                if ($debitBalance) {
                    if ($entry['credit'] > $account->balance) {
                        DB::rollBack();
                        return $this->sendError('Saldo tidak mencukupi', Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    if ($entry['debit'] > 0) {
                        $account->balance += $entry['debit'];
                    } else {
                        $account->balance -= $entry['credit'];
                    }
                } else {
                    if ($entry['debit'] > $account->balance) {
                        DB::rollBack();
                        return $this->sendError('Kelebihan pembayaran', Response::HTTP_UNPROCESSABLE_ENTITY);
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
            return $this->sendResponse('', 'Jurnal berhasil ditambahkan', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError($exception->getLine() . ' ' . $exception->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        }
    }
}
