<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $lesson->title }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $course->name }} / {{ $course->category->name }} / {{ $course->level->name }}
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.courses.lessons.edit', [$course, $lesson]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Edit Lesson') }}
                </a>
                <form action="{{ route('admin.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this lesson?') }}')">
                        {{ __('Delete Lesson') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Lesson Details -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Lesson Details') }}</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">{{ __('Status') }}</span>
                                        <p class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lesson->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($lesson->status) }}
                                            </span>
                                        </p>
                                    </div>

                                    <div>
                                        <span class="text-sm font-medium text-gray-500">{{ __('Duration') }}</span>
                                        <p class="mt-1">{{ $lesson->duration }} {{ __('minutes') }}</p>
                                    </div>

                                    <div>
                                        <span class="text-sm font-medium text-gray-500">{{ __('Order') }}</span>
                                        <p class="mt-1">{{ $lesson->order }}</p>
                                    </div>

                                    <div>
                                        <span class="text-sm font-medium text-gray-500">{{ __('Description') }}</span>
                                        <p class="mt-1">{{ $lesson->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Lesson Content') }}</h3>
                                <div class="mt-4 prose max-w-none">
                                    {!! $lesson->content !!}
                                </div>
                            </div>
                        </div>

                        <!-- Video Preview -->
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Video') }}</h3>
                                <div class="mt-4 aspect-w-16 aspect-h-9">
                                    @if($lesson->embed_video_url)
                                        <iframe src="{{ $lesson->embed_video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full rounded-lg"></iframe>
                                    @else
                                        <div class="flex items-center justify-center w-full h-full bg-gray-100 rounded-lg">
                                            <p class="text-gray-500">No video available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Quick Actions') }}</h3>
                                <div class="mt-4 space-y-4">
                                    <a href="{{ route('admin.courses.lessons.index', $course) }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        {{ __('Back to Lessons') }}
                                    </a>
                                    <a href="{{ route('admin.courses.show', $course) }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        {{ __('View Course') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 