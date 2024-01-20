<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'akun';

    protected $fillable = [
        'sub_kategori_id', 'nama_akun', 'kode_akun',
    ];

    public function subKategori()
    {
        return $this->belongsTo(SubKategori::class);
    }

    public function detailJurnal()
    {
        return $this->hasMany(DetailJurnal::class);
    }
}
