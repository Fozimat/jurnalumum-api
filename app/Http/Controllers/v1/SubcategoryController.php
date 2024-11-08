<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubcategoryRequest;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use Illuminate\Http\Request;
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

        return $this->sendResponse($this->ResourceCollection(SubcategoryResource::collection($subcategories)), 'Sukses');
    }

    public function show($id)
    {
        $subcategory = Subcategory::with('category')->find($id);

        if (!$subcategory) {
            return $this->sendError('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse(new SubcategoryResource($subcategory), 'Sukses');
    }

    public function store(SubcategoryRequest $request)
    {
        Subcategory::create([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return $this->sendResponse('', 'Sub Kategori berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(SubcategoryRequest $request, $id)
    {
        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return $this->sendError('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $subcategory->update([
            'category_id' => $request->input('category_id'),
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return $this->sendResponse('', 'Sub Kategori berhasil diperbarui', Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);

        if (!$subcategory) {
            return $this->sendError('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $subcategory->delete();

        return $this->sendResponse('', 'Sub Kategori berhasil dihapus');
    }
}
