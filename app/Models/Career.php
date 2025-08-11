<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GalleryJsonMedia\JsonMedia\Concerns\InteractWithMedia;
use GalleryJsonMedia\JsonMedia\Contracts\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model implements HasMedia
{
    use HasFactory;
    use InteractWithMedia;
    use SoftDeletes;

    protected $guarded = [];

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'career_tags');
    }

    protected $casts =[
        'images' => 'array',
        'documents' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Accessor for meta_keywords to convert JSON string to array
    public function getMetaKeywordsAttribute($value)
    {
        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return is_array($value) ? $value : [];
    }

    // Mutator for meta_keywords to convert array to JSON string
    public function setMetaKeywordsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['meta_keywords'] = json_encode($value);
        } else {
            $this->attributes['meta_keywords'] = $value;
        }
    }
 
    // for auto-delete media thumbnails
    protected function getFieldsToDeleteMedia(): array {
        return ['images','documents'];
    }
}
