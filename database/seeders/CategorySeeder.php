<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Mobile Development',
            'Data Science',
            'Machine Learning',
            'DevOps',
            'Cybersecurity',
            'Game Development',
            'Database Design',
            'Cloud Computing',
            'UI/UX Design',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
} 