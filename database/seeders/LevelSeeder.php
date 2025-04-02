<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            'Beginner',
            'Intermediate',
            'Advanced',
            'Expert',
        ];

        foreach ($levels as $level) {
            Level::create([
                'name' => $level,
            ]);
        }
    }
} 