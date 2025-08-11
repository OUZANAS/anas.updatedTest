<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobTypes = [
            [
                'title' => 'Full Time',
                'slug' => 'full-time',
                'description' => '<p>Full-time positions with standard working hours.</p>',
                'color' => '#3498db',
                'is_active' => true,
            ],
            [
                'title' => 'Part Time',
                'slug' => 'part-time',
                'description' => '<p>Part-time positions with reduced working hours.</p>',
                'color' => '#2ecc71',
                'is_active' => true,
            ],
            [
                'title' => 'Contract',
                'slug' => 'contract',
                'description' => '<p>Fixed-term contract positions for specific projects or timeframes.</p>',
                'color' => '#9b59b6',
                'is_active' => true,
            ],
            [
                'title' => 'Freelance',
                'slug' => 'freelance',
                'description' => '<p>Independent contractor positions with flexible arrangements.</p>',
                'color' => '#e74c3c',
                'is_active' => true,
            ],
            [
                'title' => 'Internship',
                'slug' => 'internship',
                'description' => '<p>Training positions for students or recent graduates.</p>',
                'color' => '#f39c12',
                'is_active' => true,
            ],
            [
                'title' => 'Remote',
                'slug' => 'remote',
                'description' => '<p>Positions that can be done remotely from any location.</p>',
                'color' => '#1abc9c',
                'is_active' => true,
            ],
            [
                'title' => 'Consulting',
                'slug' => 'consulting',
                'description' => '<p>Advisory and consulting positions for specialized expertise.</p>',
                'color' => '#34495e',
                'is_active' => true,
            ],
            [
                'title' => 'Seasonal',
                'slug' => 'seasonal',
                'description' => '<p>Temporary positions available during specific seasons or periods.</p>',
                'color' => '#d35400',
                'is_active' => true,
            ],
        ];

        foreach ($jobTypes as $jobType) {
            JobType::create($jobType);
        }
    }
}
