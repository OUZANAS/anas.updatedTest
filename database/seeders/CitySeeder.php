<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'title' => 'Casablanca',
                'slug' => 'casablanca',
                'description' => 'The largest city in Morocco and major economic hub.',
                'is_active' => true,
            ],
            [
                'title' => 'Rabat',
                'slug' => 'rabat',
                'description' => 'The capital city of Morocco.',
                'is_active' => true,
            ],
            [
                'title' => 'Marrakech',
                'slug' => 'marrakech',
                'description' => 'A major cultural and tourist center in Morocco.',
                'is_active' => true,
            ],
            [
                'title' => 'Fes',
                'slug' => 'fes',
                'description' => 'One of the oldest imperial cities in Morocco.',
                'is_active' => true,
            ],
            [
                'title' => 'Tangier',
                'slug' => 'tangier',
                'description' => 'A major city in northwestern Morocco.',
                'is_active' => true,
            ],
            [
                'title' => 'Agadir',
                'slug' => 'agadir',
                'description' => 'A major coastal city in Morocco known for its beaches.',
                'is_active' => true,
            ],
            [
                'title' => 'Meknes',
                'slug' => 'meknes',
                'description' => 'One of the imperial cities of Morocco.',
                'is_active' => true,
            ],
            [
                'title' => 'Oujda',
                'slug' => 'oujda',
                'description' => 'A city in eastern Morocco near the Algerian border.',
                'is_active' => true,
            ],
            [
                'title' => 'Kenitra',
                'slug' => 'kenitra',
                'description' => 'A city in northern Morocco on the Atlantic coast.',
                'is_active' => true,
            ],
            [
                'title' => 'Tetouan',
                'slug' => 'tetouan',
                'description' => 'A city in northern Morocco near the Mediterranean Sea.',
                'is_active' => true,
            ],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
