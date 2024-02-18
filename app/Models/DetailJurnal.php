<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJurnal extends Model
{
    use HasFactory;

    protected $table = 'detail_jurnal';

    protected $fillable = [
        'jurnal_id', 'akun_id', 'debit', 'kredit',
    ];

    public function jurnalUmum()
    {
        return $this->belongsTo(JurnalUmum::class, 'jurnal_id');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
