<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function journal_details()
    {
        return $this->hasMany(JournalDetail::class);
    }
}
