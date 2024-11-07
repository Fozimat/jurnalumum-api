<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];

    public function journal_details()
    {
        return $this->hasMany(JournalDetail::class);
    }
}
