<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $akun = Akun::with('subKategori.kategori')->paginate($per_page);
        return ResponseHelper::success($akun, 'Sukses');
    }

    public function show($id)
    {
        $akun = Akun::with('subKategori.kategori')->find($id);

        if (!$akun) {
            return ResponseHelper::error('Akun tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($akun, 'Sukses');
    }

    public function showSubKategori($id)
    {
        $subKategori = SubKategori::where('kategori_id', $id)->get();

        if (!$subKategori) {
            return ResponseHelper::error('Sub Kategori tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($subKategori, 'Sukses');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_kategori_id' => 'required|exists:sub_kategori,id',
            'nama_akun' => 'required|string|max:255',
            'kode_akun' => 'required|string|max:50|unique:akun',
            'saldo_awal' => 'required|numeric',
            'tanggal_saldo_awal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $akun = Akun::create([
            'sub_kategori_id' => $request->input('sub_kategori_id'),
            'nama_akun' => $request->input('nama_akun'),
            'kode_akun' => $request->input('kode_akun'),
            'saldo_awal' => $request->input('saldo_awal'),
            'tanggal_saldo_awal' => $request->input('tanggal_saldo_awal'),
            'saldo' => $request->input('saldo_awal'),
        ]);

        return ResponseHelper::success($akun, 'Akun berhasil ditambahkan', Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return ResponseHelper::error('Akun tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'sub_kategori_id' => 'required|exists:sub_kategori,id',
            'nama_akun' => 'required|string|max:255',
            'kode_akun' => 'required|string|max:50|unique:akun,kode_akun,' . $id,
            'saldo_awal' => 'required|numeric',
            'tanggal_saldo_awal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $akun->update([
            'sub_kategori_id' => $request->input('sub_kategori_id'),
            'nama_akun' => $request->input('nama_akun'),
            'kode_akun' => $request->input('kode_akun'),
            'saldo_awal' => $request->input('saldo_awal'),
            'tanggal_saldo_awal' => $request->input('tanggal_saldo_awal'),
            'saldo' => $request->input('saldo_awal'),
        ]);

        return ResponseHelper::success($akun, 'Akun berhasil diperbarui', Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $akun = Akun::find($id);

        if (!$akun) {
            return ResponseHelper::error('Akun tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        $akun->delete();
        return ResponseHelper::success([], 'Akun berhasil dihapus');
    }
}
