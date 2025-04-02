<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Category;
use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;

class BrowseCourses extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $selectedLevel = '';
    public $sortBy = 'latest';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedLevel' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSelectedLevel()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Course::query()
            ->where('status', 'published')
            ->with(['category', 'level']);

        // Apply search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Apply level filter
        if ($this->selectedLevel) {
            $query->where('level_id', $this->selectedLevel);
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
        }

        $courses = $query->paginate(12);
        $categories = Category::all();
        $levels = Level::all();

        return view('livewire.browse-courses', [
            'courses' => $courses,
            'categories' => $categories,
            'levels' => $levels,
        ]);
    }
} 