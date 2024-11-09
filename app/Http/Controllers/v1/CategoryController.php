<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
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
        return $this->sendResponse($this->ResourceCollection(CategoryResource::collection($categories)));
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError('Category tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return $this->sendResponse(new CategoryResource($category));
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return $this->sendResponse('', 'Category berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError('Category tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $category->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return $this->sendResponse('', 'Category berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError('Category tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return $this->sendResponse('', 'Category berhasil dihapus');
    }
}
