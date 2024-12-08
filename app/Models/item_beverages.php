<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class item_beverages extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(rawMaterial::class, 'rawID');
    }
}
