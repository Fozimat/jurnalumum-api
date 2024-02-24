<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\DetailJurnal;
use App\Models\JurnalUmum;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $query = JurnalUmum::join('detail_jurnal', 'jurnal_umum.id', '=', 'detail_jurnal.jurnal_id')
            ->select('jurnal_umum.id', 'jurnal_umum.tanggal', 'jurnal_umum.keterangan', DB::raw('SUM(detail_jurnal.debit) as total'), DB::raw('MAX(jurnal_umum.kode_transaksi) as kode_transaksi'))
            ->groupBy('jurnal_umum.id', 'jurnal_umum.tanggal', 'jurnal_umum.keterangan');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('jurnal_umum.keterangan', 'like', "%$search%")
                ->orWhere('jurnal_umum.kode_transaksi', 'like', "%$search%");
        }

        $jurnal = $query->paginate($per_page);
        return ResponseHelper::success($jurnal);
    }

    public function show($id)
    {
        $jurnal = JurnalUmum::with('detailJurnal.akun')->where('id', $id)->get();

        if (!$jurnal) {
            return ResponseHelper::error('Jurnal tidak ditemukan', Response::HTTP_NOT_FOUND);
        }

        return ResponseHelper::success($jurnal);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'kode_transaksi' => ['required', 'string', Rule::unique(JurnalUmum::class, 'kode_transaksi')],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['required', 'string'],
            'detail' => ['required', 'array'],
            'detail.*.akun_id' => ['required', Rule::exists(Akun::class, 'id')],
            'detail.*.debit' => ['required', 'numeric'],
            'detail.*.kredit' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();
        try {
            $totalDebit = collect($input['detail'])->sum('debit');
            $totalCredit = collect($input['detail'])->sum('kredit');

            if ($totalDebit != $totalCredit) {
                DB::rollBack();
                return ResponseHelper::error('Total debit dan kredit harus sama', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $jurnalUmum = JurnalUmum::create([
                'kode_transaksi' => $input['kode_transaksi'],
                'tanggal' => $input['tanggal'],
                'keterangan' => $input['keterangan'],
            ]);

            foreach ($input['detail'] as $entry) {
                DetailJurnal::create([
                    'jurnal_id' => $jurnalUmum->id,
                    'akun_id' => $entry['akun_id'],
                    'debit' => $entry['debit'],
                    'kredit' => $entry['kredit'],
                ]);

                $akun = Akun::find($entry['akun_id']);
                $subCategory = SubKategori::find($akun->sub_kategori_id);

                /**
                 * Saldo Normal Aktiva (id: 1) dan Beban (id: 5) ada di Debit
                 * Saldo Normal Hutang, Modal, dan Pendapatan ada di Kredit
                 */

                $saldoDebit = in_array($subCategory->kategori_id, [1, 5]);

                if ($saldoDebit) {
                    if ($entry['kredit'] > $akun->saldo) {
                        DB::rollBack();
                        return ResponseHelper::error('Saldo tidak mencukupi', Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    if ($entry['debit'] > 0) {
                        $akun->saldo += $entry['debit'];
                    } else {
                        $akun->saldo -= $entry['kredit'];
                    }
                } else {
                    if ($entry['debit'] > $akun->saldo) {
                        DB::rollBack();
                        return ResponseHelper::error('Kelebihan pembayaran', Response::HTTP_UNPROCESSABLE_ENTITY);
                    }
                    if ($entry['kredit'] > 0) {
                        $akun->saldo += $entry['kredit'];
                    } else {
                        $akun->saldo -= $entry['debit'];
                    }
                }

                $akun->save();
            }

            DB::commit();
            return ResponseHelper::success([], 'Jurnal berhasil ditambahkan', Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            DB::rollBack();
            return ResponseHelper::error($exception->getLine() . ' ' . $exception->getMessage(), Response::HTTP_PRECONDITION_FAILED);
        }
    }
}
