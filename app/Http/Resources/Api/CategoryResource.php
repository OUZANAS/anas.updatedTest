<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'description' => $this->description,
            'is_active' => $this->is_active,
            'order' => $this->order,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'parent_id' => $this->parent_id,
            'parent' => $this->whenLoaded('parent', function () {
                return [
                    'id' => $this->parent->id,
                    'title' => $this->parent->title,
                    'slug' => $this->parent->slug,
                ];
            }),
            'children' => CategoryResource::collection($this->whenLoaded('children')),
            'children_count' => $this->when(
                $this->relationLoaded('children'),
                fn() => $this->children->count(),
                fn() => $this->children()->count()
            ),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
