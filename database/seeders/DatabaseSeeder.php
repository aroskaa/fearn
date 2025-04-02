<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\LevelSeeder;
use Database\Seeders\CourseSeeder;
use Database\Seeders\LessonSeeder;

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
            'email' => 'admin@fearn.com',
            'role' => 'admin',
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@fearn.com',
            'role' => 'user',
        ]);

        // Seed categories, levels, courses, and lessons
        $this->call([
            CategorySeeder::class,
            LevelSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
        ]);
    }
}
