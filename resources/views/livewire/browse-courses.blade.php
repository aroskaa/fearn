<div>
    <!-- Search and Filters Section -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-wrap gap-4 items-center">
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <div class="relative flex items-center">
                        <svg class="absolute left-3 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search courses..."
                            class="w-full pl-10 pr-4 py-2 h-10 border border-gray-200 rounded-lg text-sm bg-white focus:outline-none focus:border-gray-300"
                        >
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-4 items-center">
                    <!-- Category Filter -->
                    <select
                        wire:model.live="selectedCategory"
                        class="block w-40 pl-3 pr-10 py-2 h-10 text-sm border border-gray-200 focus:outline-none focus:border-gray-300 rounded-lg bg-white"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <!-- Level Filter -->
                    <select
                        wire:model.live="selectedLevel"
                        class="block w-40 pl-3 pr-10 py-2 h-10 text-sm border border-gray-200 focus:outline-none focus:border-gray-300 rounded-lg bg-white"
                    >
                        <option value="">All Levels</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                        @endforeach
                    </select>

                    <!-- Sort By -->
                    <select
                        wire:model.live="sortBy"
                        class="block w-40 pl-3 pr-10 py-2 h-10 text-sm border border-gray-200 focus:outline-none focus:border-gray-300 rounded-lg bg-white"
                    >
                        <option value="latest">Latest</option>
                        <option value="oldest">Oldest</option>
                        <option value="title_asc">Title (A-Z)</option>
                        <option value="title_desc">Title (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($courses->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No courses found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-150">
                        <a href="{{ route('courses.show', $course) }}" class="block">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $course->description }}</p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-indigo-600">{{ $course->category->name }}</span>
                                    <span class="text-gray-500">{{ $course->level->name }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>