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

    public function table()
    {
        return $this->belongsTo(tables::class, 'tableID');
    }
    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiterID');
    }


}
