<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name' => 'E-commerce',
                //'description' => 'Digital transformation strategies and case studies',
                //'color' => '#3498db',
                //'is_active' => true,
            ],
            [
                'name' => 'Management',
                //'description' => 'Innovative business ideas and practices',
                //'color' => '#2ecc71',
                //'is_active' => true,
            ],
            [
                'name' => 'Vente',
                //'description' => 'Remote work practices and tools',
                //'color' => '#9b59b6',
                //'is_active' => true,
            ],
            [
                'name' => 'Leadership',
                //'description' => 'Leadership skills and development',
                //'color' => '#e74c3c',
                //'is_active' => true,
            ],
            [
                'name' => 'SEO',
                //'description' => 'Startup ecosystem and funding',
                //'color' => '#f39c12',
                //'is_active' => true,
            ],
            [
                'name' => 'Google Ads',
                //'description' => 'Cybersecurity practices and threats',
                //'color' => '#1abc9c',
                //'is_active' => true,
            ],
            [
                'name' => 'Analytics',
                //'description' => 'Cloud computing and services',
                //'color' => '#34495e',
                //'is_active' => true,
            ],
            [
                'name' => 'Content Marketing',
                //'description' => 'Data analysis and business intelligence',
                //'color' => '#d35400',
                //'is_active' => true,
            ],
            [
                'name' => 'Gestion de projet',
                //'description' => 'Sustainable business practices',
                //'color' => '#27ae60',
                //'is_active' => true,
            ],
            [
                'name' => 'SIRH',
                //'description' => 'Workplace diversity and inclusion',
                //'color' => '#8e44ad',
                //'is_active' => true,
            ],
            [
                'name' => 'Formation',
                //'description' => 'Customer experience strategies',
                //'color' => '#e67e22',
                //'is_active' => true,
            ],
            [
                'name' => 'Pedagogie',
                //'description' => 'AI applications and trends',
                //'color' => '#3498db',
                //'is_active' => true,
            ],
            [
                'name' => 'Expertise',
                //'description' => 'Blockchain technology and applications',
                //'color' => '#2c3e50',
                //'is_active' => true,
            ],
            [
                'name' => 'Digitalisation',
                //'description' => 'Career growth and skills development',
                //'color' => '#16a085',
                //'is_active' => true,
            ],
            [
                'name' => 'IT',
                //'description' => 'Productivity tools and techniques',
                //'color' => '#c0392b',
                //'is_active' => true,
            ],
            [
                'name' => 'Support',
                //'description' => 'Financial management and strategies',
                //'color' => '#7f8c8d',
                //'is_active' => true,
            ],
            [
                'name' => 'Commercial',
                //'description' => 'Online retail and e-commerce strategies',
                //'color' => '#f1c40f',
                //'is_active' => true,
            ],
            [
                'name' => 'Prospection',
                //'description' => 'Social media marketing and management',
                //'color' => '#9b59b6',
                //'is_active' => true,
            ],
            [
                'name' => 'Negotiation',
                //'description' => 'Project management methodologies and tools',
                //'color' => '#3498db',
                //'is_active' => true,
            ],
            [
                'name' => 'B2B',
                //'description' => 'Professional networking strategies',
                //'color' => '#2ecc71',
                //'is_active' => true,
            ],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
