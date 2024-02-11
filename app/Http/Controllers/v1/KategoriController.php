<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = Kategori::orderBy('kode_kategori');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_kategori', 'like', "%$search%")
                ->orWhere('kode_kategori', 'like', "%$search%");
        }

        $kategori = $query->paginate($per_page);

        return ResponseHelper::success($kategori, 'Sukses');
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return ResponseHelper::error('Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($kategori, 'Sukses');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:64',
            'kode_kategori' => 'required|string|max:64|unique:kategori',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $kategori = Kategori::create([
            'nama_kategori' => $request->input('nama_kategori'),
            'kode_kategori' => $request->input('kode_kategori'),
        ]);

        return ResponseHelper::success($kategori, 'Kategori berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return ResponseHelper::error('Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:50|unique:kategori,kode_kategori,' . $id,
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $kategori->update([
            'nama_kategori' => $request->input('nama_kategori'),
            'kode_kategori' => $request->input('kode_kategori'),
        ]);

        return ResponseHelper::success($kategori, 'Kategori berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return ResponseHelper::error('Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $kategori->delete();

        return ResponseHelper::success([], 'Kategori berhasil dihapus');
    }
}
