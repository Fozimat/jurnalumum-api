<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $akuns = Akun::with('subKategori.kategori')->get();

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Sukses',
            'data' => $akuns,
        ]);
    }

    public function show($id)
    {
        $akun = Akun::with('subKategori.kategori')->find($id);

        if (!$akun) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Akun tidak ditemukan',
            ]);
        }

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Sukses',
            'data' => $akun,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_kategori_id' => 'required|exists:sub_kategori,id',
            'nama_akun' => 'required|string|max:255',
            'kode_akun' => 'required|string|max:50|unique:akun',
        ]);

        $akun = Akun::create([
            'sub_kategori_id' => $request->input('sub_kategori_id'),
            'nama_akun' => $request->input('nama_akun'),
            'kode_akun' => $request->input('kode_akun'),
        ]);

        return response()->json([
            'code' => 201,
            'success' => true,
            'messages' => 'Akun berhasil ditambahkan',
            'data' => $akun,
        ]);
    }

    public function update(Request $request, $id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Akun tidak ditemukan',
            ]);
        }

        $request->validate([
            'sub_kategori_id' => 'required|exists:sub_kategori,id',
            'nama_akun' => 'required|string|max:255',
            'kode_akun' => 'required|string|max:50|unique:akun,kode_akun,' . $id,
        ]);

        $akun->update([
            'sub_kategori_id' => $request->input('sub_kategori_id'),
            'nama_akun' => $request->input('nama_akun'),
            'kode_akun' => $request->input('kode_akun'),
        ]);

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Akun berhasil diperbarui',
            'data' => $akun,
        ]);
    }

    public function destroy($id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'messages' => 'Akun tidak ditemukan',
            ]);
        }

        $akun->delete();

        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Akun berhasil dihapus',
        ]);
    }
}
