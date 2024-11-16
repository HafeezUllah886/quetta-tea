<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(categories::class, 'catID');
    }

    public function kitchen()
    {
        return $this->belongsTo(User::class, 'kitchenID');
    }

    public function sizes()
    {
        return $this->hasMany(sizes::class, 'itemID');
    }
}
