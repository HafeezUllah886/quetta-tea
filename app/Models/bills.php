<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bills extends Model
{
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(bill_details::class, 'billID');
    }
}
