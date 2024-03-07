<?php

namespace App\Http\Controllers\v1;

use App\Exports\LabaRugiExport;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\DetailJurnal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanLabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        $startMonth = Carbon::parse($month)->startOfMonth();
        $endMonth = Carbon::parse($month)->endOfMonth();

        $akunPendapatan = $this->getAkunByKategori('Pendapatan');
        $akunBeban = $this->getAkunByKategori('Beban');

        $pendapatan = $this->getDebitKreditAkun($akunPendapatan, $startMonth, $endMonth);
        $beban = $this->getDebitKreditAkun($akunBeban, $startMonth, $endMonth);

        $response = [
            'pendapatan' => $pendapatan,
            'beban' => $beban
        ];

        return ResponseHelper::success($response);
    }

    public function getAkunByKategori($kategori)
    {
        return Akun::whereHas('subKategori.kategori', function ($query) use ($kategori) {
            $query->where('nama_kategori', $kategori);
        })->get();
    }

    public function getDebitKreditAkun($akun, $startMonth, $endMonth)
    {
        $debitKredit = [];

        foreach ($akun as $item) {
            $total = DetailJurnal::where('akun_id', $item->id)
                ->select(DB::raw('sum(debit) as total_debit'), DB::raw('sum(kredit) as total_kredit'))
                ->whereHas('jurnalUmum', function ($query) use ($startMonth, $endMonth) {
                    $query->whereBetween('tanggal', [$startMonth, $endMonth]);
                })->first();

            if ($total->total_credit == 0 && $total->total_debit > 0) {
                $subtotal = $total->total_debit - $total->total_kredit;
            } else {
                $subtotal = $total->total_kredit - $total->total_debit;
            }

            $debitKredit[] = [
                'id_akun' => $item->id,
                'kode_akun' => $item->kode_akun,
                'nama_akun' => $item->nama_akun,
                'total' => $subtotal,
            ];
        }

        return $debitKredit;
    }

    public function getDataToExport(Request $request)
    {
        $month = $request->input('month');
        $startMonth = Carbon::parse($month)->startOfMonth();
        $endMonth = Carbon::parse($month)->endOfMonth();

        $akunPendapatan = $this->getAkunByKategori('Pendapatan');
        $akunBeban = $this->getAkunByKategori('Beban');

        $pendapatan = $this->getDebitKreditAkun($akunPendapatan, $startMonth, $endMonth);
        $beban = $this->getDebitKreditAkun($akunBeban, $startMonth, $endMonth);

        $response = [
            'pendapatan' => $pendapatan,
            'beban' => $beban
        ];

        return $response;
    }

    public function export(Request $request)
    {
        $data = $this->getDataToExport($request);
        return Excel::download(new LabaRugiExport($data), 'laba-rugi.xlsx');
    }
}
