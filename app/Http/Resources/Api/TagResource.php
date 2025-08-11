<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
            'name' => $this->name,
            //'slug' => $this->slug,
            //'description' => $this->description,
            'color' => $this->color,
            'is_active' => $this->is_active,
            'posts_count' => $this->when(
                $this->relationLoaded('posts') || isset($this->posts_count),
                fn() => $this->posts_count ?? $this->posts()->count()
            ),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
