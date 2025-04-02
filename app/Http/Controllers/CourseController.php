<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $course->load(['category', 'level', 'lessons']);
        return view('courses.show', compact('course'));
    }
    
    public function myCourses()
    {
        $enrolledCourses = Auth::user()->enrollments()->with('course')->paginate(12);
        return view('courses.my-courses', compact('enrolledCourses'));
    }
} 