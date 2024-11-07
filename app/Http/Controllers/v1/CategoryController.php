<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = Category::orderBy('code');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%");
        }

        $categories = $query->paginate($per_page);

        return ResponseHelper::success($categories, 'Sukses');
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ResponseHelper::error('Category tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($category, 'Sukses');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:64',
            'code' => 'required|string|max:64|unique:categories',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category = Category::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return ResponseHelper::success($category, 'Category berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ResponseHelper::error('Category tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:categories,code,' . $id,
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return ResponseHelper::success($category, 'Category berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ResponseHelper::error('Category tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return ResponseHelper::success([], 'Category berhasil dihapus');
    }
}
