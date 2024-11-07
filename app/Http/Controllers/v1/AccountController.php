<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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

        return ResponseHelper::success($accounts, 'Sukses');
    }

    public function show($id)
    {
        $account = Account::with('subcategory.category')->find($id);

        if (!$account) {
            return ResponseHelper::error('Account tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($account, 'Sukses');
    }

    public function showSubcategory($id)
    {
        $subcategory = Subcategory::where('category_id', $id)->get();

        if (!$subcategory) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($subcategory, 'Sukses');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:accounts',
            'initial_balance' => 'required|numeric',
            'initial_balance_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $account = Account::create([
            'subcategory_id' => $request->input('subcategory_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'initial_balance' => $request->input('initial_balance'),
            'initial_balance_date' => $request->input('initial_balance_date'),
            'balance' => $request->input('balance'),
        ]);

        return ResponseHelper::success($account, 'Account berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $account = Account::find($id);

        if (!$account) {
            return ResponseHelper::error('Account tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:accounts,code,' . $id,
            'initial_balance' => 'required|numeric',
            'initial_balance_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $account->update([
            'subcategory_id' => $request->input('subcategory_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'initial_balance' => $request->input('initial_balance'),
            'initial_balance_date' => $request->input('initial_balance_date'),
            'balance' => $request->input('balance'),
        ]);

        return ResponseHelper::success($account, 'Account berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return ResponseHelper::error('Account tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $account->delete();
        return ResponseHelper::success([], 'Account berhasil dihapus');
    }
}
