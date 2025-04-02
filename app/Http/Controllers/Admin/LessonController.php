<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('order')->paginate(10);
        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            // 'slug' => ['required', 'string', 'max:255', 'unique:lessons'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $lesson = $course->lessons()->create([
            'title' => $request->title,
            // 'slug' => $request->slug,
            'description' => $request->description,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'order' => $request->order ?? $course->lessons()->count(),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Lesson $lesson)
    {
        return view('admin.lessons.show', compact('course', 'lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('course', 'lesson'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            // 'slug' => ['required', 'string', 'max:255', 'unique:lessons,slug,' . $lesson->id],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $lesson->update([
            'title' => $request->title,
            // 'slug' => $request->slug,
            'description' => $request->description,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'order' => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.courses.lessons.index', $course)
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.courses.lessons.index', $course)
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Update the lesson status.
     */
    public function updateStatus(Request $request, Course $course, Lesson $lesson)
    {
        $request->validate([
            'status' => ['required', 'in:draft,published'],
        ]);

        $lesson->update(['status' => $request->status]);

        return back()->with('success', 'Lesson status updated successfully.');
    }

    /**
     * Reorder lessons.
     */
    public function reorder(Request $request, Course $course)
    {
        $request->validate([
            'lessons' => ['required', 'array'],
            'lessons.*' => ['required', 'integer', 'exists:lessons,id'],
        ]);

        foreach ($request->lessons as $index => $lessonId) {
            Lesson::where('id', $lessonId)->update(['order' => $index]);
        }

        return response()->json(['message' => 'Lessons reordered successfully.']);
    }
} 