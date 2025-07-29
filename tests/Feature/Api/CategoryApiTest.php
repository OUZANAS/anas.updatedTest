<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_categories()
    {
        // Create test categories
        $parentCategory = Category::create([
            'title' => 'Technology',
            'slug' => 'technology',
            'description' => 'Tech content',
            'is_active' => true,
            'order' => 1
        ]);

        $childCategory = Category::create([
            'title' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Web dev content',
            'parent_id' => $parentCategory->id,
            'is_active' => true,
            'order' => 1
        ]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'slug',
                            'description',
                            'is_active',
                            'order',
                            'image',
                            'parent_id',
                            'children_count',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'links',
                    'meta'
                ]);
    }

    public function test_can_filter_categories_by_active_status()
    {
        Category::create([
            'title' => 'Active Category',
            'slug' => 'active-category',
            'is_active' => true,
            'order' => 1
        ]);

        Category::create([
            'title' => 'Inactive Category',
            'slug' => 'inactive-category',
            'is_active' => false,
            'order' => 2
        ]);

        $response = $this->getJson('/api/categories?is_active=true');

        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data')));
        $this->assertEquals('Active Category', $response->json('data.0.title'));
    }

    public function test_can_search_categories()
    {
        Category::create([
            'title' => 'Technology News',
            'slug' => 'technology-news',
            'description' => 'Latest tech updates',
            'is_active' => true,
            'order' => 1
        ]);

        Category::create([
            'title' => 'Sports',
            'slug' => 'sports',
            'description' => 'Sports content',
            'is_active' => true,
            'order' => 2
        ]);

        $response = $this->getJson('/api/categories/search?q=tech');

        $response->assertStatus(200)
                ->assertJsonCount(1, 'data')
                ->assertJsonPath('data.0.title', 'Technology News');
    }

    public function test_can_get_single_category()
    {
        $category = Category::create([
            'title' => 'Technology',
            'slug' => 'technology',
            'description' => 'Tech content',
            'is_active' => true,
            'order' => 1
        ]);

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
                ->assertJsonPath('data.id', $category->id)
                ->assertJsonPath('data.title', 'Technology');
    }

    public function test_can_get_category_tree()
    {
        $parent = Category::create([
            'title' => 'Technology',
            'slug' => 'technology',
            'is_active' => true,
            'order' => 1
        ]);

        Category::create([
            'title' => 'Web Development',
            'slug' => 'web-development',
            'parent_id' => $parent->id,
            'is_active' => true,
            'order' => 1
        ]);

        $response = $this->getJson('/api/categories/tree');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'children' => [
                                '*' => [
                                    'id',
                                    'title',
                                    'parent_id'
                                ]
                            ]
                        ]
                    ]
                ]);
    }
}
