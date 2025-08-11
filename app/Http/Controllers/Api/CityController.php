<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CityController extends Controller
{
    /**
     * Display a listing of cities with optional filtering and search
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = City::query();

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
        $cities = $query->paginate($perPage);

        return CityResource::collection($cities);
    }

    /**
     * Display the specified city
     */
    public function show(City $city): CityResource
    {
        $city->loadCount('careers');
        
        return new CityResource($city);
    }

    /**
     * Search cities
     */
    public function search(Request $request): AnonymousResourceCollection
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255'
        ]);

        $searchTerm = $request->input('q');
        
        $cities = City::where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('slug', 'like', "%{$searchTerm}%");
            })
            ->orderBy('title')
            ->limit(20)
            ->get();

        return CityResource::collection($cities);
    }
}
