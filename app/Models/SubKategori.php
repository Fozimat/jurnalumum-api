<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    use HasFactory;

    protected $table = 'sub_kategori';

    protected $fillable = [
        'kategori_id', 'nama_sub_kategori', 'kode_sub_kategori'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function akun()
    {
        return $this->hasMany(Akun::class);
    }
}
