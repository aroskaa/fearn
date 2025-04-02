<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Courses') }}
        </h2>

        <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6">My Courses</h1>
        
            @if($enrolledCourses->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                    <p>You are not enrolled in any courses yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($enrolledCourses as $course)
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
                                <p class="text-gray-600">{{ $course->description }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('courses.show', $course) }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-150">
                                        View Course
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $enrolledCourses->links() }}
            @endif
        </div>
    </x-slot>

</x-app-layout>