<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    /**
     * Display a listing of tags with optional filtering and search
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Tag::query();

        // Filter by active status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('slug', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Include posts count if requested
        if ($request->has('with_posts_count') && $request->boolean('with_posts_count')) {
            $query->withCount('posts');
        }

        // Ordering
        $orderBy = $request->input('order_by', 'name');
        $orderDirection = $request->input('order_direction', 'asc');
        
        if (in_array($orderBy, ['name', 'slug', 'created_at'])) {
            $query->orderBy($orderBy, $orderDirection);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Pagination
        $perPage = min($request->input('per_page', 15), 100);
        $tags = $query->paginate($perPage);

        return TagResource::collection($tags);
    }

    /**
     * Display the specified tag
     */
    public function show(Tag $tag): TagResource
    {
        $tag->loadCount('posts');
        
        return new TagResource($tag);
    }

    /**
     * Search tags
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $searchTerm = $request->input('q');
        
        $tags = Tag::where('is_active', true)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('slug', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get();

        return TagResource::collection($tags);
    }

    /**
     * Get popular tags (most used tags)
     */
    public function popular(Request $request): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 10), 50);
        
        $tags = Tag::where('is_active', true)
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();

        return TagResource::collection($tags);
    }
}
