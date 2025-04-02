<x-admin-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-100 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800">Total Courses</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_courses'] }}</p>
                </div>
                
                <div class="bg-green-100 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800">Total Users</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['total_users'] }}</p>
                </div>
                
                <div class="bg-purple-100 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-purple-800">Total Enrollments</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $stats['total_enrollments'] }}</p>
                </div>
                
                <div class="bg-yellow-100 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-yellow-800">Categories</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['total_categories'] }}</p>
                </div>
                
                <div class="bg-red-100 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-red-800">Levels</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['total_levels'] }}</p>
                </div>
                
                <div class="bg-indigo-100 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-indigo-800">Lessons</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_lessons'] }}</p>
                </div>
            </div>
            
            <!-- Recent Courses -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Recent Courses</h3>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach($recent_courses as $course)
                            <li>
                                <a href="{{ route('admin.courses.show', $course) }}" class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $course->title }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $course->category->name }}
                                                </p>
                                                <p class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $course->level->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Recent Enrollments -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Recent Enrollments</h3>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach($recent_enrollments as $enrollment)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-indigo-600 truncate">
                                            {{ $enrollment->user->name }}
                                        </p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $enrollment->course->title }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500">
                                                {{ $enrollment->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 