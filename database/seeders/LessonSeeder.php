<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            $lessons = [
                [
                    'title' => 'Introduction to ' . $course->title,
                    'description' => 'An overview of what you will learn in this course.',
                    'content' => 'Welcome to ' . $course->title . '! In this course, you will learn...',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'duration' => 15,
                    'order' => 1,
                    'status' => 'published',
                ],
                [
                    'title' => 'Setting Up Your Development Environment',
                    'description' => 'Learn how to set up your development environment.',
                    'content' => 'Before we start coding, you need to set up your development environment...',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'duration' => 20,
                    'order' => 2,
                    'status' => 'published',
                ],
                [
                    'title' => 'Basic Concepts and Fundamentals',
                    'description' => 'Understanding the basic concepts and fundamentals.',
                    'content' => 'Let\'s dive into the basic concepts and fundamentals...',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'duration' => 25,
                    'order' => 3,
                    'status' => 'published',
                ],
                [
                    'title' => 'Advanced Topics',
                    'description' => 'Exploring advanced topics and concepts.',
                    'content' => 'Now that we understand the basics, let\'s explore some advanced topics...',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'duration' => 30,
                    'order' => 4,
                    'status' => 'draft',
                ],
                [
                    'title' => 'Project Work',
                    'description' => 'Hands-on project to apply what you\'ve learned.',
                    'content' => 'Time to put your knowledge into practice with a real-world project...',
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'duration' => 45,
                    'order' => 5,
                    'status' => 'draft',
                ],
            ];

            foreach ($lessons as $lesson) {
                Lesson::create([
                    'title' => $lesson['title'],
                    'slug' => Str::slug($lesson['title']),
                    'description' => $lesson['description'],
                    'content' => $lesson['content'],
                    'video_url' => $lesson['video_url'],
                    'duration' => $lesson['duration'],
                    'order' => $lesson['order'],
                    'status' => $lesson['status'],
                    'course_id' => $course->id,
                ]);
            }
        }
    }
} 