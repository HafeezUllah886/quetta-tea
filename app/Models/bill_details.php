<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bill_details extends Model
{
    protected $guarded = [];

    public function size()
    {
        return $this->belongsTo(sizes::class, 'sizeID');
    }
}
