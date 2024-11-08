<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\SubcategoryResource;
use App\Models\Account;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = Account::with('subcategory.category');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('accounts.name', 'like', "%$search%")
                ->orWhere('accounts.code', 'like', "%$search%")
                ->orWhere('balance', 'like', "%$search%")
                ->orWhereHas('subcategory', function ($q) use ($search) {
                    $q->where('subcategories.name', 'like', "%$search%");
                })->orWhereHas('subcategory.category', function ($q) use ($search) {
                    $q->where('categories.name', 'like', "%$search%");
                });
        }

        if ($request->has('paginate') && $request->input('paginate') == 'false') {
            $accounts = $query->get();
        } else {
            $accounts = $query->paginate($per_page);
        }

        return $this->sendResponse($this->ResourceCollection(AccountResource::collection($accounts)), 'Sukses');
    }

    public function show($id)
    {
        $account = Account::with('subcategory.category')->find($id);

        if (!$account) {
            return $this->sendError('Account tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse(new AccountResource($account), 'Sukses');
    }

    public function showSubcategory($id)
    {
        $subcategory = Subcategory::where('category_id', $id)->get();

        if (!$subcategory) {
            return $this->sendError('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse($this->ResourceCollection(SubcategoryResource::collection($subcategory)), 'Sukses');
    }

    public function store(AccountRequest $request)
    {
        Account::create([
            'subcategory_id' => $request->input('subcategory_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'initial_balance' => $request->input('initial_balance'),
            'initial_balance_date' => $request->input('initial_balance_date'),
            'balance' => $request->input('balance'),
        ]);

        return $this->sendResponse('', 'Account berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(AccountRequest $request, $id)
    {
        $account = Account::find($id);

        if (!$account) {
            return $this->sendError('Account tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $account->update([
            'subcategory_id' => $request->input('subcategory_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'initial_balance' => $request->input('initial_balance'),
            'initial_balance_date' => $request->input('initial_balance_date'),
            'balance' => $request->input('balance'),
        ]);

        return $this->sendResponse('', 'Account berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return $this->sendError('Account tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $account->delete();
        return $this->sendResponse('', 'Account berhasil dihapus');
    }
}
