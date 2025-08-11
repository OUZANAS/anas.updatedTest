<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->generateExcerpt(),
            'featured_image' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'gallery_images' => $this->formatGalleryImages(),
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'is_published' => $this->is_published,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'view_count' => $this->view_count,
            'published_at' => $this->published_at?->diffForHumans(),
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'title' => $this->category->title,
                    'slug' => $this->category->slug,
                    'type' => $this->category->type,
                ];
            }),
            'author' => $this->whenLoaded('author', function () {
                return [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                ];
            }),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Generate excerpt from content
     */
    private function generateExcerpt(int $length = 200): string
    {
        $content = strip_tags($this->content);
        return strlen($content) > $length 
            ? substr($content, 0, $length) . '...' 
            : $content;
    }

    /**
     * Format gallery images with full URLs
     */
    private function formatGalleryImages(): array
    {
        if (!$this->gallery_images || !is_array($this->gallery_images)) {
            return [];
        }

        return collect($this->gallery_images)->map(function ($image) {
            if (is_array($image) && isset($image['file'])) {
                // Handle gallery JSON format
                return [
                    'file' => asset('uploads/posts' . $image['file']),
                    'size' => $image['size'] ?? null,
                    'mime_type' => $image['mime_type'] ?? null,
                    'customProperties' => $image['customProperties'] ?? []
                ];
            } elseif (is_string($image)) {
                // Handle simple string paths
                return asset('uploads/posts' . $image);
            }
            
            // Return as is if it doesn't match expected formats
            return $image;
        })->toArray();
    }
}
