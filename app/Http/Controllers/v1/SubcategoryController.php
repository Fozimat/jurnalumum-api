<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = Subcategory::with('category');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('category.name', 'like', "%$search%");
                });
        }

        $subcategories = $query->paginate($per_page);

        return ResponseHelper::success($subcategories, 'Sukses');
    }

    public function show($id)
    {
        $subcategory = Subcategory::with('category')->find($id);

        if (!$subcategory) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($subcategory, 'Sukses');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:64',
            'code' => 'required|string|max:64|unique:subcategories',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $subKategori = Subcategory::create([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return ResponseHelper::success($subKategori, 'Sub Kategori berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:64',
            'code' => 'required|string|max:64|unique:subcategories,code,' . $id,
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $subcategory->update([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return ResponseHelper::success($subcategory, 'Sub Kategori berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $subcategory->delete();

        return ResponseHelper::success([], 'Sub Kategori berhasil dihapus');
    }
}
