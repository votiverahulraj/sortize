<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventCategory;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Sports',
            'Music',
            'Arts',
            'Conferences',
            'Fashion shows',
            'Festivals',
        ];

        foreach ($categories as $name) {
            EventCategory::updateOrCreate(
                ['name' => $name]
            );
        }
    }
}