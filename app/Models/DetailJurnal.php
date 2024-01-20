<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJurnal extends Model
{
    use HasFactory;

    protected $table = 'detail_jurnal';

    protected $fillable = [
        'id_jurnal', 'id_akun', 'debit', 'kredit',
    ];

    public function jurnalUmum()
    {
        return $this->belongsTo(JurnalUmum::class, 'id_jurnal');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }
}
