<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GalleryJsonMedia\JsonMedia\Concerns\InteractWithMedia;
use GalleryJsonMedia\JsonMedia\Contracts\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Career extends Model implements HasMedia
{
    use HasFactory;
    use InteractWithMedia;

    protected $guarded = [];

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'career_tags');
    }

    protected $casts =[
        'images' => 'array',
        'documents' => 'array',
    ];
 
    // for auto-delete media thumbnails
    protected function getFieldsToDeleteMedia(): array {
        return ['images','documents'];
    }
}
