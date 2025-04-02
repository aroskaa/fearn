<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $levels = Level::all();

        $courses = [
            [
                'title' => 'Complete Web Development Bootcamp',
                'description' => 'Learn HTML, CSS, JavaScript, PHP, and MySQL to become a full-stack web developer.',
                'status' => 'published',
            ],
            [
                'title' => 'Advanced Laravel Development',
                'description' => 'Master Laravel framework with advanced concepts, testing, and deployment.',
                'status' => 'published',
            ],
            [
                'title' => 'React & Vue.js Mastery',
                'description' => 'Build modern web applications with React and Vue.js frameworks.',
                'status' => 'published',
            ],
            [
                'title' => 'Python for Data Science',
                'description' => 'Learn Python programming for data analysis and machine learning.',
                'status' => 'published',
            ],
            [
                'title' => 'AWS Cloud Practitioner',
                'description' => 'Get certified in AWS cloud services and infrastructure.',
                'status' => 'draft',
            ],
            [
                'title' => 'Mobile App Development with Flutter',
                'description' => 'Create cross-platform mobile applications using Flutter and Dart.',
                'status' => 'published',
            ],
            [
                'title' => 'Cybersecurity Fundamentals',
                'description' => 'Learn the basics of cybersecurity and network security.',
                'status' => 'draft',
            ],
            [
                'title' => 'Database Design & Optimization',
                'description' => 'Master database design, SQL, and performance optimization.',
                'status' => 'published',
            ],
        ];

        foreach ($courses as $course) {
            Course::create([
                'title' => $course['title'],
                'slug' => Str::slug($course['title']),
                'description' => $course['description'],
                'image' => 'courses/default.jpg', // You'll need to add actual images
                'status' => $course['status'],
                'category_id' => $categories->random()->id,
                'level_id' => $levels->random()->id,
            ]);
        }
    }
} 