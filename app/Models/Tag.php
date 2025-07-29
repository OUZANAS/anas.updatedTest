<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Concerns\Translatable;

class Tag extends Model
{
    protected $guarded = [];

    protected $translatable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags', 'tag_id', 'post_id');
    }
}
