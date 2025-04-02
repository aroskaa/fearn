<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $course->name }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.courses.edit', $course) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                    {{ __('Edit Course') }}
                </a>
                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                        {{ __('Delete Course') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Course Image and Basic Info -->
                        <div class="md:col-span-1">
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="w-full rounded-lg shadow-md">
                            <div class="mt-4 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $course->isPublished() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Category:</span>
                                    <span class="font-semibold">{{ $course->category->name }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Level:</span>
                                    <span class="font-semibold">{{ $course->level->name }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Enrollments:</span>
                                    <span class="font-semibold">{{ $course->enrollments_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Course Details -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                                <div class="mt-2 text-gray-600">
                                    {{ $course->description }}
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Lessons</h3>
                                <div class="mt-4">
                                    @if($course->lessons->count() > 0)
                                        <div class="space-y-4">
                                            @foreach($course->lessons as $lesson)
                                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                    <div>
                                                        <h4 class="font-medium text-gray-900">{{ $lesson->title }}</h4>
                                                        <p class="text-sm text-gray-500">{{ Str::limit($lesson->description, 100) }}</p>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                        <form action="#" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this lesson?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500">No lessons have been added to this course yet.</p>
                                    @endif

                                    <div class="mt-4">
                                        <a href="#" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                                            Add New Lesson
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Recent Enrollments</h3>
                                <div class="mt-4">
                                    @if($course->enrollments->count() > 0)
                                        <div class="space-y-4">
                                            @foreach($course->enrollments->take(5) as $enrollment)
                                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                                    <div>
                                                        <h4 class="font-medium text-gray-900">{{ $enrollment->user->name }}</h4>
                                                        <p class="text-sm text-gray-500">Enrolled on {{ $enrollment->created_at->format('M d, Y') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500">No enrollments yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 