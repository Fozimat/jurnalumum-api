<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubKategoriController extends Controller
{
    public function index()
    {
        $subKategori = SubKategori::with('kategori')->get();
        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Sukses',
            'data' => $subKategori,
        ]);
    }

    public function show($id)
    {
        $subKategori = SubKategori::with('kategori')->find($id);

        if (!$subKategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Sub Kategori tidak ditemukan',
            ]);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Sukses',
            'data' => $subKategori
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori,id',
            'nama_sub_kategori' => 'required|string|max:64',
            'kode_sub_kategori' => 'required|string|max:64|unique:sub_kategori',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $subKategori = SubKategori::create([
            'kategori_id' => $request->input('kategori_id'),
            'nama_sub_kategori' => $request->input('nama_sub_kategori'),
            'kode_sub_kategori' => $request->input('kode_sub_kategori'),
        ]);

        return response()->json([
            'code' => 201,
            'success' => true,
            'messages' => 'Sub Kategori berhasil ditambahkan',
            'data' => $subKategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $subKategori = SubKategori::find($id);

        if (!$subKategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Sub Kategori tidak ditemukan',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori,id',
            'nama_sub_kategori' => 'required|string|max:64',
            'kode_sub_kategori' => 'required|string|max:64|unique:sub_kategori,kode_sub_kategori,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $subKategori->update([
            'kategori_id' => $request->input('kategori_id'),
            'nama_sub_kategori' => $request->input('nama_sub_kategori'),
            'kode_sub_kategori' => $request->input('kode_sub_kategori'),
        ]);

        return response()->json([
            'code' => 201,
            'success' => true,
            'messages' => 'Sub Kategori berhasil diperbarui',
            'data' => $subKategori
        ]);
    }

    public function destroy($id)
    {
        $subKategori = SubKategori::find($id);

        if (!$subKategori) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Sub Kategori tidak ditemukan',
            ]);
        }

        $subKategori->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Sub Kategori berhasil dihapus',
        ]);
    }
}
