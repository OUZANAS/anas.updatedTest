<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with optional filtering and search
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Category::query();

        // Include parent relationship for subcategories
        $query->with('parent');

        // Filter by active status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Filter by parent category (get only main categories)
        if ($request->has('parent_only') && $request->boolean('parent_only')) {
            $query->whereNull('parent_id');
        }

        // Filter by specific parent category
        if ($request->has('parent_id')) {
            $query->where('parent_id', $request->input('parent_id'));
        }

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('slug', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Ordering
        $orderBy = $request->input('order_by', 'order');
        $orderDirection = $request->input('order_direction', 'asc');
        
        if (in_array($orderBy, ['title', 'slug', 'order', 'created_at'])) {
            $query->orderBy($orderBy, $orderDirection);
        } else {
            $query->orderBy('order', 'asc');
        }

        // Pagination
        $perPage = min($request->input('per_page', 15), 100); // Max 100 items per page
        $categories = $query->paginate($perPage);

        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified category
     */
    public function show(Category $category): CategoryResource
    {
        $category->load(['parent', 'children' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }]);

        return new CategoryResource($category);
    }

    /**
     * Get category tree structure (hierarchical)
     */
    public function tree(Request $request): AnonymousResourceCollection
    {
        $query = Category::query();

        // Filter by active status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // Get main categories with their children
        $categories = $query->whereNull('parent_id')
            ->with(['children' => function ($q) use ($request) {
                $q->orderBy('order');
                if ($request->has('is_active')) {
                    $q->where('is_active', $request->boolean('is_active'));
                }
            }])
            ->orderBy('order')
            ->get();

        return CategoryResource::collection($categories);
    }

    /**
     * Get categories for a specific parent
     */
    public function children(Category $category): AnonymousResourceCollection
    {
        $children = $category->children()
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return CategoryResource::collection($children);
    }

    /**
     * Search categories
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $searchTerm = $request->input('q');
        
        $categories = Category::where('is_active', true)
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('slug', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
            })
            ->with('parent')
            ->orderBy('order')
            ->limit(20)
            ->get();

        return CategoryResource::collection($categories);
    }
}
