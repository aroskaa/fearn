<x-app-layout>
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Video Section -->
                    @if($lesson->video_url)
                        <div class="relative pb-[56.25%] bg-gray-900 rounded-lg overflow-hidden mb-8">
                            <iframe src="{{ $lesson->embed_video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="absolute top-0 left-0 w-full h-full rounded-lg"></iframe>
                        </div>
                    @endif

                    <!-- Lesson Content -->
                    <div class="bg-white rounded-lg">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $lesson->title }}</h1>
                            <p class="mt-2 text-gray-600">{{ $lesson->description }}</p>
                        </div>
                        
                        <div class="prose max-w-none">
                            {!! $lesson->content !!}
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-8 flex items-center justify-between">
                        @if($previousLesson)
                            <a href="{{ route('courses.lessons.show', [$course, $previousLesson]) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous Lesson
                            </a>
                        @endif

                        @if($nextLesson)
                            <a href="{{ route('courses.lessons.show', [$course, $nextLesson]) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Next Lesson
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Content</h3>
                        <div class="space-y-3">
                            @foreach($course->lessons as $courseLesson)
                                <a href="{{ route('courses.lessons.show', [$course, $courseLesson]) }}" 
                                   class="flex items-center p-2 -mx-2 rounded hover:bg-gray-100 {{ $lesson->id === $courseLesson->id ? 'bg-gray-100' : '' }}">
                                    <span class="text-sm {{ $lesson->id === $courseLesson->id ? 'font-semibold text-indigo-600' : 'text-gray-600' }}">
                                        {{ $courseLesson->title }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 