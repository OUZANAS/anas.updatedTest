<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent blog categories
        $parentPostCategories = [
            [
                'title' => 'Technology',
                'slug' => 'technology',
                'description' => '<p>Articles about technology trends and innovations.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => null,
                'order' => 1,
            ],
            [
                'title' => 'Business',
                'slug' => 'business',
                'description' => '<p>Business strategies, market trends and analysis.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => null,
                'order' => 2,
            ],
            [
                'title' => 'HR Management',
                'slug' => 'hr-management',
                'description' => '<p>Human resources management practices and insights.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => null,
                'order' => 3,
            ],
            [
                'title' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'description' => '<p>Digital marketing strategies, tools, and case studies.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => null,
                'order' => 4,
            ],
        ];

        // Create parent blog categories
        foreach ($parentPostCategories as $category) {
            Category::create($category);
        }

        // Create child blog categories
        $childPostCategories = [
            [
                'title' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'description' => '<p>AI developments and applications in business.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 1, // Technology
                'order' => 1,
            ],
            [
                'title' => 'Cloud Computing',
                'slug' => 'cloud-computing',
                'description' => '<p>Cloud technologies and solutions for businesses.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 1, // Technology
                'order' => 2,
            ],
            [
                'title' => 'Entrepreneurship',
                'slug' => 'entrepreneurship',
                'description' => '<p>Starting and growing businesses in Morocco.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 2, // Business
                'order' => 1,
            ],
            [
                'title' => 'Finance',
                'slug' => 'finance',
                'description' => '<p>Financial strategies and management for businesses.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 2, // Business
                'order' => 2,
            ],
            [
                'title' => 'Recruitment',
                'slug' => 'recruitment',
                'description' => '<p>Recruitment strategies and best practices.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 3, // HR Management
                'order' => 1,
            ],
            [
                'title' => 'Employee Development',
                'slug' => 'employee-development',
                'description' => '<p>Training, development, and retention strategies.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 3, // HR Management
                'order' => 2,
            ],
            [
                'title' => 'Social Media Marketing',
                'slug' => 'social-media-marketing',
                'description' => '<p>Social media strategies and case studies.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 4, // Digital Marketing
                'order' => 1,
            ],
            [
                'title' => 'Content Marketing',
                'slug' => 'content-marketing',
                'description' => '<p>Content creation and distribution strategies.</p>',
                'type' => 'post',
                'is_active' => true,
                'parent_id' => 4, // Digital Marketing
                'order' => 2,
            ],
        ];

        // Create child blog categories
        foreach ($childPostCategories as $category) {
            Category::create($category);
        }

        // Create parent career categories
        $parentCareerCategories = [
            [
                'title' => 'Technology',
                'slug' => 'technology-careers',
                'description' => '<p>Technology and IT related positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => null,
                'order' => 1,
            ],
            [
                'title' => 'Finance',
                'slug' => 'finance-careers',
                'description' => '<p>Finance, accounting, and banking positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => null,
                'order' => 2,
            ],
            [
                'title' => 'Marketing',
                'slug' => 'marketing-careers',
                'description' => '<p>Marketing, advertising, and PR positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => null,
                'order' => 3,
            ],
            [
                'title' => 'Human Resources',
                'slug' => 'hr-careers',
                'description' => '<p>HR, recruitment, and personnel management positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => null,
                'order' => 4,
            ],
        ];

        // Create parent career categories
        foreach ($parentCareerCategories as $category) {
            Category::create($category);
        }

        // Create child career categories
        $childCareerCategories = [
            [
                'title' => 'Software Development',
                'slug' => 'software-development',
                'description' => '<p>Software engineering and development positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 13, // Technology careers
                'order' => 1,
            ],
            [
                'title' => 'IT Infrastructure',
                'slug' => 'it-infrastructure',
                'description' => '<p>Network, systems, and infrastructure positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 13, // Technology careers
                'order' => 2,
            ],
            [
                'title' => 'Accounting',
                'slug' => 'accounting',
                'description' => '<p>Accounting and financial management positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 14, // Finance careers
                'order' => 1,
            ],
            [
                'title' => 'Banking',
                'slug' => 'banking',
                'description' => '<p>Banking and financial services positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 14, // Finance careers
                'order' => 2,
            ],
            [
                'title' => 'Digital Marketing',
                'slug' => 'digital-marketing-careers',
                'description' => '<p>Digital marketing specialist positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 15, // Marketing careers
                'order' => 1,
            ],
            [
                'title' => 'Brand Management',
                'slug' => 'brand-management',
                'description' => '<p>Brand development and management positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 15, // Marketing careers
                'order' => 2,
            ],
            [
                'title' => 'Recruitment',
                'slug' => 'recruitment-careers',
                'description' => '<p>Recruitment and talent acquisition positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 16, // HR careers
                'order' => 1,
            ],
            [
                'title' => 'Training & Development',
                'slug' => 'training-development',
                'description' => '<p>Training and employee development positions.</p>',
                'type' => 'career',
                'is_active' => true,
                'parent_id' => 16, // HR careers
                'order' => 2,
            ],
        ];

        // Create child career categories
        foreach ($childCareerCategories as $category) {
            Category::create($category);
        }
    }
}
