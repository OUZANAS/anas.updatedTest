<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    /**
     * Display a listing of posts with optional filtering and search
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Post::query();

        // Only show published and active posts by default
        $query->where('is_published', true)
              ->where('is_active', true);

        // Include relationships
        $query->with(['category', 'author', 'tags']);

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter by category slug
        if ($request->has('category_slug')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category_slug'));
            });
        }

        // Filter by tag
        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->input('tag_id'));
            });
        }

        // Filter by tag slug
        if ($request->has('tag_slug')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.slug', $request->input('tag_slug'));
            });
        }

        // Filter by author
        if ($request->has('author_id')) {
            $query->where('user_id', $request->input('author_id'));
        }

        // Filter by featured
        if ($request->has('is_featured')) {
            $query->where('is_featured', $request->boolean('is_featured'));
        }

        if ($request->has('published')) {
            $query->where('is_published', $request->boolean('published'));
        }

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%")
                  ->orWhere('slug', 'like', "%{$searchTerm}%");
            });
        }

        // Ordering
        $orderBy = $request->input('order_by', 'published_at');
        $orderDirection = $request->input('order_direction', 'desc');
        
        if (in_array($orderBy, ['title', 'slug', 'published_at', 'created_at', 'view_count'])) {
            $query->orderBy($orderBy, $orderDirection);
        } else {
            $query->orderBy('published_at', 'desc');
        }

        // Pagination
        $perPage = min($request->input('per_page', 15), 100);
        $posts = $query->paginate($perPage);

        return PostResource::collection($posts);
    }

    /**
     * Display the specified post
     */
    public function show(Request $request, string $slug): PostResource
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->where('is_active', true)
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();

        // Increment view count if not requested to skip
        if (!$request->has('skip_view_increment') || !$request->boolean('skip_view_increment')) {
            $post->increment('view_count');
        }

        return new PostResource($post);
    }

    /**
     * Get featured posts
     */
    public function featured(Request $request): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 10), 50);
        
        $posts = Post::where('is_published', true)
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        return PostResource::collection($posts);
    }

    /**
     * Get popular posts (most viewed)
     */
    public function popular(Request $request): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 10), 50);
        $days = $request->input('days', 30); // Default to last 30 days
        
        $posts = Post::where('is_published', true)
            ->where('is_active', true)
            ->when($days, function ($query) use ($days) {
                $query->where('created_at', '>=', now()->subDays($days));
            })
            ->with(['category', 'author', 'tags'])
            ->orderBy('view_count', 'desc')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        return PostResource::collection($posts);
    }

    /**
     * Get related posts
     */
    public function related(Post $post, Request $request): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 5), 20);
        
        $relatedPosts = Post::where('is_published', true)
            ->where('is_active', true)
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                // Same category or shared tags
                $query->where('category_id', $post->category_id)
                      ->orWhereHas('tags', function ($q) use ($post) {
                          $q->whereIn('tags.id', $post->tags->pluck('id'));
                      });
            })
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        return PostResource::collection($relatedPosts);
    }

    /**
     * Search posts
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $searchTerm = $request->input('q');
        
        $posts = Post::where('is_published', true)
            ->where('is_active', true)
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('content', 'like', "%{$searchTerm}%")
                      ->orWhere('slug', 'like', "%{$searchTerm}%");
            })
            ->with(['category', 'author', 'tags'])
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return PostResource::collection($posts);
    }
}
