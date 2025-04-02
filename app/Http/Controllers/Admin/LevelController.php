<?php

namespace App\Http\Controllers\Admin;

use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = Level::latest()->paginate(10);
        $courses = Course::all();
        return view('admin.levels.index', compact('levels', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:levels'],
            // 'slug' => ['required', 'string', 'max:255', 'unique:levels'],
        ]);

        Level::create($request->all());

        return redirect()->route('admin.levels.index')
            ->with('success', 'Level created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        return view('admin.levels.show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        return view('admin.levels.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Level $level)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:levels,name,' . $level->id],
            // 'slug' => ['required', 'string', 'max:255', 'unique:levels,slug,' . $level->id],
        ]);

        $level->update($request->all());

        return redirect()->route('admin.levels.index')
            ->with('success', 'Level updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        if ($level->courses()->count() > 0) {
            return back()->with('error', 'Cannot delete level with associated courses.');
        }

        $level->delete();

        return redirect()->route('admin.levels.index')
            ->with('success', 'Level deleted successfully.');
    }
} 