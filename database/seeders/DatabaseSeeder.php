<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@anas.test',
            'password' => bcrypt('password'), // Use a secure password in production
        ]);

        // Seed basic data first
        $this->call([
            // Reference data
            CitySeeder::class,
            JobTypeSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            
            // Content data (depends on reference data)
            PostSeeder::class,
            CareerSeeder::class,
            StaticPageSeeder::class,
        ]);
    }
}
