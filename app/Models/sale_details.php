<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale_details extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(items::class, 'itemID');
    }

    public function category()
    {
        return $this->belongsTo(categories::class, 'catID');
    }
}
