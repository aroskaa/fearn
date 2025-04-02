<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_courses' => Course::count(),
            'total_users' => User::count(),
            'total_enrollments' => Enrollment::count(),
            'total_categories' => Category::count(),
            'total_levels' => Level::count(),
            'total_lessons' => Lesson::count(),
        ];

        $recent_courses = Course::with(['category', 'level'])
            ->latest()
            ->take(5)
            ->get();

        $recent_enrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_courses', 'recent_enrollments'));
    }
} 