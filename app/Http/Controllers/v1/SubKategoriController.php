<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class SubKategoriController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = SubKategori::with('kategori');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_sub_kategori', 'like', "%$search%")
                ->orWhere('kode_sub_kategori', 'like', "%$search%")
                ->orWhereHas('kategori', function ($q) use ($search) {
                    $q->where('nama_kategori', 'like', "%$search%");
                });
        }

        $subKategori = $query->paginate($per_page);

        return ResponseHelper::success($subKategori, 'Sukses');
    }

    public function show($id)
    {
        $subKategori = SubKategori::with('kategori')->find($id);

        if (!$subKategori) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($subKategori, 'Sukses');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori,id',
            'nama_sub_kategori' => 'required|string|max:64',
            'kode_sub_kategori' => 'required|string|max:64|unique:sub_kategori',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $subKategori = SubKategori::create([
            'kategori_id' => $request->input('kategori_id'),
            'nama_sub_kategori' => $request->input('nama_sub_kategori'),
            'kode_sub_kategori' => $request->input('kode_sub_kategori'),
        ]);

        return ResponseHelper::success($subKategori, 'Sub Kategori berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $subKategori = SubKategori::find($id);

        if (!$subKategori) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori,id',
            'nama_sub_kategori' => 'required|string|max:64',
            'kode_sub_kategori' => 'required|string|max:64|unique:sub_kategori,kode_sub_kategori,' . $id,
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $subKategori->update([
            'kategori_id' => $request->input('kategori_id'),
            'nama_sub_kategori' => $request->input('nama_sub_kategori'),
            'kode_sub_kategori' => $request->input('kode_sub_kategori'),
        ]);

        return ResponseHelper::success($subKategori, 'Sub Kategori berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $subKategori = SubKategori::find($id);

        if (!$subKategori) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $subKategori->delete();

        return ResponseHelper::success([], 'Sub Kategori berhasil dihapus');
    }
}
