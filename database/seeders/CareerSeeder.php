<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\User;
use App\Models\Category;
use App\Models\City;
use App\Models\JobType;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CareerSeeder extends Seeder
{

       /**
     * Get relevant tags for a career based on its title.
     * 
     * @param string $careerTitle
     * @param \Illuminate\Support\Collection $allTags
     * @return array
     */
    private function getRelevantTagsForCareer(string $careerTitle, $allTags): array
    {
        $title = strtolower($careerTitle);
        $relevantTagIds = [];
        
        // Map of keywords to tag names
        $keywordToTagMap = [
            'developer' => ['Digital Transformation', 'Innovation', 'Remote Work'],
            'software' => ['Digital Transformation', 'Innovation', 'Remote Work'],
            'business' => ['Leadership', 'Innovation', 'Management', 'Finance'],
            'hr' => ['Diversity', 'Leadership', 'Professional Development'],
            'human resources' => ['Diversity', 'Leadership', 'Professional Development'],
            'manager' => ['Leadership', 'Management', 'Project Management'],
            'financial' => ['Finance', 'Management', 'Productivity'],
            'finance' => ['Finance', 'Management', 'Productivity'],
            'tech' => ['Digital Transformation', 'Innovation', 'Cloud'],
            'it' => ['Cybersecurity', 'Cloud', 'Digital Transformation'],
            'support' => ['Customer Experience', 'Productivity'],
            'designer' => ['Innovation', 'Remote Work', 'Customer Experience'],
            'ux' => ['Customer Experience', 'Digital Transformation', 'Innovation'],
            'ui' => ['Customer Experience', 'Digital Transformation', 'Innovation'],
            'project' => ['Project Management', 'Leadership', 'Management'],
            'content' => ['Social Media', 'E-commerce', 'Digital Transformation'],
            'marketing' => ['Social Media', 'E-commerce', 'Customer Experience'],
            'analyst' => ['Data Analytics', 'Innovation', 'Finance'],
            'formateur' => ['Professional Development', 'Leadership'],
            'expert' => ['Professional Development', 'Leadership']
        ];
        
        // Find matching keywords in the career title
        foreach ($keywordToTagMap as $keyword => $tagNames) {
            if (str_contains($title, $keyword)) {
                foreach ($tagNames as $tagName) {
                    $tag = $allTags->where('name', $tagName)->first();
                    if ($tag && !in_array($tag->id, $relevantTagIds)) {
                        $relevantTagIds[] = $tag->id;
                    }
                }
            }
        }
        
        // If no relevant tags found, assign 2 random tags
        if (empty($relevantTagIds)) {
            return $allTags->random(2)->pluck('id')->toArray();
        }
        
        return $relevantTagIds;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user as author
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Get all categories of type 'career'
        $categories = Category::where('type', 'career')->get();
        
        // Get all cities
        $cities = City::all();
        
        // Get all job types
        $jobTypes = JobType::all();
        
        // Get all tags
        $tags = Tag::all();
        
        // Sample careers
        $careers = [
            [
                'title' => 'Business Developer - Services RH',
                'content' => '',
                'company_name' => 'Anas Agency',
                'location' => 'Marrakech',
                //'contract_type' => 'cdi',
                'payment_type' => 'monthly',
                //'salary' => 35000,
                'salary_range' => '30000-35000',
                //'is_remote' => false,
                'job_type_slug' => 'full-time',
                'city_slug' => 'marrakech',
                'category_slug' => 'software-development',
                'application_deadline' => Carbon::now()->addDays(30),
            ],
            [
                'title' => 'Formateur Expert RH',
                'content' => '',
                'company_name' => 'ExperRH Agency',
                'location' => 'Rabat',
                //'contract_type' => 'Freelance',
                'payment_type' => 'monthly',
                //'salary' => 25000,
                'salary_range' => '20000-30000',
                //'is_remote' => true,
                'job_type_slug' => 'Freelance',
                'city_slug' => 'rabat',
                'category_slug' => 'digital-marketing-careers',
                'application_deadline' => Carbon::now()->addDays(15),
            ],
            [
                'title' => 'Human Resources Manager',
                'content' => '',
                'company_name' => 'Global Enterprises',
                'location' => 'Marrakech',
                //'contract_type' => 'cdi',
                'payment_type' => 'monthly',
                'salary_range' => '18000-25000',
                //'salary' => 22000,
                //'is_remote' => false,
                'job_type_slug' => 'full-time',
                'city_slug' => 'marrakech',
                'category_slug' => 'recruitment-careers',
                'application_deadline' => Carbon::now()->addDays(20),
            ],
            [
                'title' => 'Financial Analyst',
                'content' => '',
                'company_name' => 'FinanceWorks',
                'location' => 'Casablanca',
                //'contract_type' => 'cdi',
                'payment_type' => 'monthly',
                //'salary' => 30000,
                'salary_range' => '25000-35000',
                //'is_remote' => false,
                'job_type_slug' => 'full-time',
                'city_slug' => 'casablanca',
                'category_slug' => 'accounting',
                'application_deadline' => Carbon::now()->addDays(25),
            ],
            [
                'title' => 'IT Support Specialist',
                'content' => '',
                'company_name' => 'TechSolutions Morocco',
                'location' => 'Rabat',
                //'contract_type' => 'cdi',
                'payment_type' => 'monthly',
                //'salary' => 12500,
                'salary_range' => '10000-15000',
                //'is_remote' => false,
                'job_type_slug' => 'full-time',
                'city_slug' => 'rabat',
                'category_slug' => 'it-infrastructure',
                'application_deadline' => Carbon::now()->addDays(14),
            ],
            [
                'title' => 'UX/UI Designer',
                'content' => '',
                'company_name' => 'DigitalCraft Studio',
                'location' => 'Casablanca',
                //'contract_type' => 'cdd',
                'payment_type' => 'monthly',
                //'salary' => 16000,
                'salary_range' => '12000-20000',
                //'is_remote' => true,
                'job_type_slug' => 'contract',
                'city_slug' => 'casablanca',
                'category_slug' => 'software-development',
                'application_deadline' => Carbon::now()->addDays(10),
            ],
            [
                'title' => 'Project Manager',
                'content' => '',
                'company_name' => 'Construct Morocco',
                'location' => 'Marrakech',
                //'contract_type' => 'cdi',
                'payment_type' => 'monthly',
                //'salary' => 28000,
                'salary_range' => '18000-25000',
                //'is_remote' => false,
                'job_type_slug' => 'full-time',
                'city_slug' => 'marrakech',
                'category_slug' => 'finance-careers',
                'application_deadline' => Carbon::now()->addDays(21),
            ],
            [
                'title' => 'Content Marketing Specialist',
                'content' => '',
                'company_name' => 'MarketPro Agency',
                'location' => 'Rabat',
                //'contract_type' => 'freelance',
                'payment_type' => 'project',
                'salary_min' => null,
                'salary_max' => null,
                //'is_remote' => true,
                'job_type_slug' => 'freelance',
                'city_slug' => 'rabat',
                'category_slug' => 'digital-marketing-careers',
                'application_deadline' => Carbon::now()->addDays(7),
            ],
        ];

        foreach ($careers as $careerData) {
            // Get job type and city by slug
            $jobType = JobType::where('slug', $careerData['job_type_slug'])->first();
            $city = City::where('slug', $careerData['city_slug'])->first();
            $category = Category::where('slug', $careerData['category_slug'])->where('type', 'career')->first();

            // Create career
            $career = Career::create([
                'title' => $careerData['title'],
                'slug' => Str::slug($careerData['title']),
                'content' => $careerData['content'],
                'excerpt' => substr(strip_tags($careerData['content']), 0, 150) . '...',
                'company_name' => $careerData['company_name'],
                'location' => $careerData['location'],
                //'contract_type' => $careerData['contract_type'],
                'payment_type' => $careerData['payment_type'],
                //'salary' => $careerData['salary'] ?? null,
                'salary_range' => $careerData['salary_range'] ?? null,
                //'is_remote' => $careerData['is_remote'],
                'is_featured' => rand(0, 1) == 1,
                'is_active' => true,
                //'application_deadline' => $careerData['application_deadline'],
                'meta_title' => $careerData['title'],
                'meta_description' => substr(strip_tags($careerData['content']), 0, 150) . '...',
                'meta_keywords' => json_encode(['career', 'job', str_replace(' ', '-', strtolower($careerData['title']))]),
                'view_count' => rand(10, 300),
                'created_by' => $user->id,
                'job_type_id' => $jobType ? $jobType->id : null,
                'city_id' => $city ? $city->id : null,
                'category_id' => $category ? $category->id : null,
                'created_at' => now()->subDays(rand(1, 14)),
                'updated_at' => now(),
            ]);

            // Attach relevant tags based on career title
            $relevantTags = $this->getRelevantTagsForCareer($careerData['title'], $tags);
            $career->tags()->attach($relevantTags);
        }
    }
}
