<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];
    // 3lach biti dir hadchi ??? nqad
    // hna model tan9addo functions relationships between tables and .... ok
    // An3tik mital example 

    public function careers()
    {
        return $this->hasMany(Career::class);
    }
}
