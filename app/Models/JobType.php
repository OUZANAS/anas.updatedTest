<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    protected $guarded = [];

    public function careers()
    {
        return $this->hasMany(Career::class);
    }
}
