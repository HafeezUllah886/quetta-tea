<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rawMaterial extends Model
{
    use HasFactory;
    protected $table = "raw_materials";
    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(units::class, 'unitID');
    }

    public function category()
    {
        return $this->belongsTo(raw_categories::class, 'catID');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(purchase_details::class, 'materialID');
    }
}
