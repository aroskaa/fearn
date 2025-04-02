<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lessons for') }}: {{ $course->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $course->category->name }} / {{ $course->level->name }}
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.courses.show', $course) }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                    {{ __('Back to Course') }}
                </a>
                <a href="{{ route('admin.courses.lessons.create', $course) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                    {{ __('Add New Lesson') }}
                </a>
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

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            Drag and drop lessons to reorder them. The order will be saved automatically.
                        </p>
                    </div>

                    <div id="lessons-container" class="space-y-4">
                        @forelse($lessons as $lesson)
                            <div class="lesson-item bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex items-center justify-between" data-id="{{ $lesson->id }}">
                                <div class="flex items-center space-x-4">
                                    <div class="cursor-move text-gray-400 hover:text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $lesson->title }}</h3>
                                        <p class="text-sm text-gray-500">{{ Str::limit($lesson->description, 100) }}</p>
                                        <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                                            @if($lesson->duration)
                                                <span>{{ $lesson->duration }} minutes</span>
                                            @endif
                                            @if($lesson->video_url)
                                                <span>Video included</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <form action="{{ route('admin.courses.lessons.update-status', [$course, $lesson]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" 
                                            onchange="this.form.submit()"
                                            class="rounded-full text-sm font-semibold px-3 py-1 {{ $lesson->isPublished() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            <option value="draft" {{ $lesson->isDraft() ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ $lesson->isPublished() ? 'selected' : '' }}>Published</option>
                                        </select>
                                    </form>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.courses.lessons.show', [$course, $lesson]) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('admin.courses.lessons.edit', [$course, $lesson]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this lesson?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">No lessons have been added to this course yet.</p>
                                <a href="{{ route('admin.courses.lessons.create', $course) }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition">
                                    Add Your First Lesson
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $lessons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('lessons-container');
            if (container) {
                new Sortable(container, {
                    animation: 150,
                    handle: '.cursor-move',
                    onEnd: function() {
                        const lessonIds = Array.from(container.querySelectorAll('.lesson-item')).map(item => item.dataset.id);
                        
                        fetch('{{ route("admin.courses.lessons.reorder", $course) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ lessons: lessonIds })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout> 