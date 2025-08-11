<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
            'company_name' => $this->company_name,
            'location' => $this->location,
            'contract_type' => $this->contract_type,
            'payment_type' => $this->payment_type,
            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'currency' => $this->currency,
            'is_remote' => $this->is_remote,
            'is_featured' => (bool) $this->is_featured,
            'is_active' => (bool) $this->is_active,
            'application_deadline' => $this->application_deadline,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords_array,
            'view_count' => (int) $this->view_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                    'slug' => $this->category->slug,
                    'type' => $this->category->type,
                    'parent_id' => $this->category->parent_id,
                ];
            }),
            
            'author' => $this->whenLoaded('author', function () {
                return [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                    'email' => $this->author->email,
                ];
            }),
            
            'job_type' => $this->whenLoaded('jobType', function () {
                return [
                    'id' => $this->jobType->id,
                    'name' => $this->jobType->name,
                    'slug' => $this->jobType->slug,
                    'description' => $this->jobType->description,
                ];
            }),
            
            'city' => $this->whenLoaded('city', function () {
                return [
                    'id' => $this->city->id,
                    'name' => $this->city->name,
                    'slug' => $this->city->slug,
                    'country' => $this->city->country,
                ];
            }),
            
            'tags' => $this->whenLoaded('tags', function () {
                return $this->tags->map(function ($tag) {
                    return [
                        'id' => $tag->id,
                        'name' => $tag->name,
                        'slug' => $tag->slug,
                    ];
                });
            }),
            
            // Computed fields
            'salary_range' => $this->when(
                $this->salary_min || $this->salary_max,
                function () {
                    if ($this->salary_min && $this->salary_max) {
                        return $this->currency . ' ' . number_format($this->salary_min) . ' - ' . $this->currency . ' ' . number_format($this->salary_max);
                    } elseif ($this->salary_min) {
                        return $this->currency . ' ' . number_format($this->salary_min) . '+';
                    } elseif ($this->salary_max) {
                        return 'Up to ' . $this->currency . ' ' . number_format($this->salary_max);
                    }
                    return null;
                }
            ),
            
            'formatted_application_deadline' => $this->when(
                $this->application_deadline,
                function () {
                    return $this->application_deadline ? $this->application_deadline->format('Y-m-d') : null;
                }
            ),
            
            'days_remaining' => $this->when(
                $this->application_deadline,
                function () {
                    return $this->application_deadline ? now()->diffInDays($this->application_deadline, false) : null;
                }
            ),
            
            'is_expired' => $this->when(
                $this->application_deadline,
                function () {
                    return $this->application_deadline ? $this->application_deadline->isPast() : false;
                }
            ),
            
            'reading_time' => $this->when(
                $this->content,
                function () {
                    $wordCount = str_word_count(strip_tags($this->content));
                    return max(1, ceil($wordCount / 200)); // Assuming 200 words per minute
                }
            ),
        ];
    }
}
