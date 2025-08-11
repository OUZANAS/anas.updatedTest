<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Filament\Resources\Concerns\Translatable;

class Category extends Model
{
    //use Translatable;

    protected $guarded = [];

    protected $translatable = ['title', 'description'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
 
    public function getImageUrl()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function careers()
    {
        return $this->hasMany(Career::class);
    }
}
