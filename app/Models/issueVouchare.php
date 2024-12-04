<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class issueVouchare extends Model
{
    protected $guarded = [];

    public function kitchen()
    {
        return $this->belongsTo(User::class, "kitchenID");
    }

    public function chef()
    {
        return $this->belongsTo(User::class, "chefID");
    }

}
