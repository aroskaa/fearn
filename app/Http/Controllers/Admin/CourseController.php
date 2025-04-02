<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['category', 'level'])
            ->latest()
            ->paginate(10);
            
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $levels = Level::all();
        
        return view('admin.courses.create', compact('categories', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:courses'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'image' => ['required', 'image', 'max:2048'], // 2MB max
            'status' => ['required', 'in:draft,published'],
        ]);

        $imagePath = $request->file('image')->store('courses', 'public');

        Course::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'level_id' => $request->level_id,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['category', 'level', 'lessons']);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        $levels = Level::all();
        
        return view('admin.courses.edit', compact('course', 'categories', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:courses,title,' . $course->id],
            'slug' => ['required', 'string', 'max:255', 'unique:courses,slug,' . $course->id],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'image' => ['nullable', 'image', 'max:2048'], // 2MB max
            'status' => ['required', 'in:draft,published'],
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            
            // Store new image
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->enrollments()->count() > 0) {
            return back()->with('error', 'Cannot delete course with active enrollments.');
        }

        // Delete course image
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        // Delete associated lessons
        $course->lessons()->delete();
        
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function updateStatus(Request $request, Course $course)
    {
        $request->validate([
            'status' => ['required', 'in:draft,published'],
        ]);

        $course->update(['status' => $request->status]);

        return back()->with('success', 'Course status updated successfully.');
    }
} 