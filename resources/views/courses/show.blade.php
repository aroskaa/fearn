<x-app-layout>
    <div class="bg-white">
        <!-- Course Header -->
        <div class="relative h-[400px] bg-gray-900">
            @if($course->image)
                <div class="absolute inset-0">
                    <img src="{{ Storage::url($course->image) }}" 
                         alt="{{ $course->title }}" 
                         class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                </div>
            @endif
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div class="flex flex-col justify-end h-full pb-8">
                    <div class="flex items-center gap-4 text-sm mb-3">
                        <span class="bg-indigo-500 px-3 py-1 rounded-full text-white">{{ $course->category->name }}</span>
                        <span class="bg-gray-700 px-3 py-1 rounded-full text-white">{{ $course->level->name }}</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-bold text-white">{{ $course->title }}</h1>
                </div>
            </div>
        </div>

        <!-- Course Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Description -->
                    <div class="prose max-w-none mb-12">
                        <h2 class="text-2xl font-bold mb-4">About This Course</h2>
                        <p class="text-gray-600">{{ $course->description }}</p>
                    </div>

                    <!-- Curriculum -->
                    <div>
                        <h2 class="text-2xl font-bold mb-6">Course Curriculum</h2>
                        <div class="space-y-4">
                            @foreach($course->lessons as $lesson)
                                <div class="bg-white border rounded-lg overflow-hidden {{ $isEnrolled ? 'hover:border-indigo-500 cursor-pointer' : 'opacity-75' }}">
                                    <a href="{{ $isEnrolled ? route('courses.lessons.show', [$course, $lesson]) : '#' }}" 
                                       class="{{ !$isEnrolled ? 'pointer-events-none' : '' }}">
                                        <div class="p-4">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $lesson->title }}</h3>
                                                    <p class="mt-1 text-sm text-gray-500">{{ $lesson->description }}</p>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <span class="text-sm text-gray-500">{{ $lesson->duration }} min</span>
                                                    @if(!$isEnrolled)
                                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
                        <!-- Course Stats -->
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600">{{ $course->lessons->sum('duration') }} minutes total</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-600">{{ $course->lessons->count() }} lessons</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="text-gray-600">{{ $course->level->name }} Level</span>
                            </div>
                        </div>

                        <!-- Enrollment Section -->
                        @auth
                            @if($isEnrolled)
                                <a href="{{ route('courses.lessons.show', [$course, $course->lessons->first()]) }}" 
                                   class="block w-full text-center bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition duration-150">
                                    Continue Learning
                                </a>
                            @else
                                <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-150">
                                        Enroll Now
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-150">
                                Login to Enroll
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif
</x-app-layout> 