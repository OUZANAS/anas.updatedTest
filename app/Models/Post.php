<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Concerns\Translatable;

class Post extends Model
{
    use Translatable;

    protected $guarded = [];

    protected $translatable = ['title', 'content', 'meta_title', 'meta_description', 'meta_keywords'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}