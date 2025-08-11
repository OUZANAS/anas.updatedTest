<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'structured_data',
        'index_page',
        'follow_links',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
        'structured_data' => 'array',
        'index_page' => 'boolean',
        'follow_links' => 'boolean',
    ];
}
