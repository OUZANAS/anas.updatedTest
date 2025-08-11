<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CareerResource;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CareerController extends Controller
{
    /**
     * Display a listing of careers with optional filtering and search
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Career::query();

        // Only show active careers by default
        $query->where('is_active', true);

        // Include relationships
        $query->with(['category', 'author', 'tags', 'jobType', 'city']);

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

        // Filter by job type
        if ($request->has('job_type_id')) {
            $query->where('job_type_id', $request->input('job_type_id'));
        }

        // Filter by city
        if ($request->has('city_id')) {
            $query->where('city_id', $request->input('city_id'));
        }

        // Filter by tag
        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('career_tags.tag_id', $request->input('tag_id'));
            });
        }

        // Filter by contract type
        if ($request->has('contract_type')) {
            $query->where('contract_type', $request->input('contract_type'));
        }

        // Filter by payment type
        if ($request->has('payment_type')) {
            $query->where('payment_type', $request->input('payment_type'));
        }

        // Filter by featured
        if ($request->has('is_featured')) {
            $query->where('is_featured', $request->boolean('is_featured'));
        }

        // Filter by location
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        // Filter by company
        if ($request->has('company')) {
            $query->where('company_name', 'like', '%' . $request->input('company') . '%');
        }

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%")
                  ->orWhere('company_name', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%")
                  ->orWhere('slug', 'like', "%{$searchTerm}%");
            });
        }

        // Ordering
        $orderBy = $request->input('order_by', 'created_at');
        $orderDirection = $request->input('order_direction', 'desc');
        
        if (in_array($orderBy, ['title', 'slug', 'created_at', 'view_count', 'company_name'])) {
            $query->orderBy($orderBy, $orderDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = min($request->input('per_page', 15), 100);
        $careers = $query->paginate($perPage);

        return CareerResource::collection($careers);
    }

    /**
     * Display the specified career
     */
    public function show(Request $request, string $slug): CareerResource
    {
        $career = Career::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'author', 'tags', 'jobType', 'city'])
            ->firstOrFail();

        // Increment view count if not requested to skip
        if (!$request->has('skip_view_increment') || !$request->boolean('skip_view_increment')) {
            $career->increment('view_count');
        }

        return new CareerResource($career);
    }

    /**
     * Get featured careers
     */
    public function featured(Request $request): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 10), 50);
        
        $careers = Career::where('is_active', true)
            ->where('is_featured', true)
            ->with(['category', 'author', 'tags', 'jobType', 'city'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return CareerResource::collection($careers);
    }

    /**
     * Get popular careers (most viewed)
     */
    public function popular(Request $request): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 10), 50);
        $days = $request->input('days', 30); // Default to last 30 days
        
        $careers = Career::where('is_active', true)
            ->when($days, function ($query) use ($days) {
                $query->where('created_at', '>=', now()->subDays($days));
            })
            ->with(['category', 'author', 'tags', 'jobType', 'city'])
            ->orderBy('view_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return CareerResource::collection($careers);
    }

    /**
     * Get related careers
     */
    public function related(Career $career, Request $request): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 5), 20);
        
        $relatedCareers = Career::where('is_active', true)
            ->where('id', '!=', $career->id)
            ->where(function ($query) use ($career) {
                // Same category, job type, or city
                $query->where('category_id', $career->category_id)
                      ->orWhere('job_type_id', $career->job_type_id)
                      ->orWhere('city_id', $career->city_id)
                      ->orWhere('company_name', $career->company_name);
            })
            ->with(['category', 'author', 'tags', 'jobType', 'city'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return CareerResource::collection($relatedCareers);
    }

    /**
     * Search careers
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $searchTerm = $request->input('q');
        
        $careers = Career::where('is_active', true)
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('content', 'like', "%{$searchTerm}%")
                      ->orWhere('company_name', 'like', "%{$searchTerm}%")
                      ->orWhere('location', 'like', "%{$searchTerm}%")
                      ->orWhere('slug', 'like', "%{$searchTerm}%");
            })
            ->with(['category', 'author', 'tags', 'jobType', 'city'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return CareerResource::collection($careers);
    }

    /**
     * Get careers by company
     */
    public function byCompany(Request $request, string $company): AnonymousResourceCollection
    {
        $limit = min($request->input('limit', 10), 50);
        
        $careers = Career::where('is_active', true)
            ->where('company_name', 'like', "%{$company}%")
            ->with(['category', 'author', 'tags', 'jobType', 'city'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return CareerResource::collection($careers);
    }
}
