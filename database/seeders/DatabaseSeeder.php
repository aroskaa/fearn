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
        // User::factory(10)->create();

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
