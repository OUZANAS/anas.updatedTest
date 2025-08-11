<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\JobTypeResource;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobTypeController extends Controller
{
    /**
     * Display a listing of job types with optional filtering and search
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = JobType::query();

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('slug', 'like', "%{$searchTerm}%");
            });
        }

        // Include careers count if requested
        if ($request->has('with_careers_count') && $request->boolean('with_careers_count')) {
            $query->withCount('careers');
        }

        // Ordering
        $orderBy = $request->input('order_by', 'title');
        $orderDirection = $request->input('order_direction', 'asc');
        
        if (in_array($orderBy, ['title', 'slug', 'created_at'])) {
            $query->orderBy($orderBy, $orderDirection);
        } else {
            $query->orderBy('title', 'asc');
        }

        // Pagination
        $perPage = min($request->input('per_page', 15), 100);
        $jobTypes = $query->paginate($perPage);

        return JobTypeResource::collection($jobTypes);
    }

    /**
     * Display the specified job type
     */
    public function show(JobType $jobType): JobTypeResource
    {
        $jobType->loadCount('careers');
        
        return new JobTypeResource($jobType);
    }

    /**
     * Search job types
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $searchTerm = $request->input('q');
        
        $jobTypes = JobType::where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('slug', 'like', "%{$searchTerm}%");
            })
            ->orderBy('title')
            ->limit(20)
            ->get();

        return JobTypeResource::collection($jobTypes);
    }
}
