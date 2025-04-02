<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();
        
        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by level
        if ($request->has('level')) {
            $query->where('level_id', $request->level);
        }
        
        $courses = $query->with(['category', 'level'])->paginate(12);
        $categories = Category::all();
        $levels = Level::all();
        
        return view('courses.index', compact('courses', 'categories', 'levels'));
    }
    
    public function show(Course $course)
    {
        $course->load(['category', 'level', 'lessons' => function($query) {
            $query->orderBy('order');
        }]);

        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Auth::user()->courses()->where('course_id', $course->id)->exists();
        }
        
        return view('courses.show', compact('course', 'isEnrolled'));
    }
    
    public function myCourses()
    {
        $user = Auth::user();
        $enrolledCourses = $user->courses()->with(['category', 'level'])->paginate(12);
        return view('courses.my-courses', compact('enrolledCourses'));
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();
        
        // Check if user is already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        // Create enrollment
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        return redirect()->route('courses.show', $course)->with('success', 'Successfully enrolled in the course!');
    }

    public function showLesson(Course $course, Lesson $lesson)
    {
        // Check if user is enrolled in the course
        if (!Auth::user()->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You must be enrolled in this course to view lessons.');
        }

        // Load course with ordered lessons
        $course->load(['lessons' => function($query) {
            $query->orderBy('order');
        }]);

        // Get previous and next lessons
        $lessons = $course->lessons;
        $currentIndex = $lessons->search(function($item) use ($lesson) {
            return $item->id === $lesson->id;
        });

        $previousLesson = $currentIndex > 0 ? $lessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $lessons->count() - 1 ? $lessons[$currentIndex + 1] : null;

        return view('courses.lessons.show', compact('course', 'lesson', 'previousLesson', 'nextLesson'));
    }
} 