<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Sukses',
            'data' => $kategori,
        ]);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Kategori tidak ditemukan',
            ]);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Sukses',
            'data' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:64',
            'kode_kategori' => 'required|string|max:64|unique:kategori',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'success' => false,
                'messages' => $validator->errors(),
            ]);
        }

        $kategori = Kategori::create([
            'nama_kategori' => $request->input('nama_kategori'),
            'kode_kategori' => $request->input('kode_kategori'),
        ]);

        return response()->json([
            'code' => 201,
            'success' => true,
            'messages' => 'Kategori berhasil ditambahkan',
            'data' => $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Kategori tidak ditemukan',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:50|unique:kategori,kode_kategori,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'success' => false,
                'messages' => $validator->errors(),
            ]);
        }

        $kategori->update([
            'nama_kategori' => $request->input('nama_kategori'),
            'kode_kategori' => $request->input('kode_kategori'),
        ]);

        return response()->json([
            'code' => 201,
            'success' => true,
            'messages' => 'Kategori berhasil diperbarui',
            'data' => $kategori
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Kategori tidak ditemukan',
            ]);
        }

        $kategori->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Kategori berhasil dihapus',
        ]);
    }
}
