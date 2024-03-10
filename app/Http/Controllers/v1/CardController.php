<?php

namespace App\Http\Controllers\v1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\JurnalUmum;
use App\Models\Kategori;
use App\Models\SubKategori;

class CardController extends Controller
{
    public function kategori()
    {
        return ResponseHelper::success(Kategori::count());
    }

    public function subKategori()
    {
        return ResponseHelper::success(SubKategori::count());
    }

    public function akun()
    {
        return ResponseHelper::success(Akun::count());
    }

    public function jurnalUmum()
    {
        return ResponseHelper::success(JurnalUmum::count());
    }
}
