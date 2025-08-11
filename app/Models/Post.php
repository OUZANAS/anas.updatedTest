<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Concerns\Translatable;
use GalleryJsonMedia\JsonMedia\Concerns\InteractWithMedia;
use GalleryJsonMedia\JsonMedia\Contracts\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractWithMedia;
    use Translatable;
    use SoftDeletes;

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

    protected $casts =[
        'gallery_images' => 'array',
        'meta_keywords' => 'array',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
 
    // for auto-delete media thumbnails
    protected function getFieldsToDeleteMedia(): array {
        return ['gallery_images'];
    }
}