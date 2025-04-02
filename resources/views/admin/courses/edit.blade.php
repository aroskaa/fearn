<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Course') }}: {{ $course->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="title" :value="__('Course Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $course->title)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $course->slug)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('description', $course->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <div>
                                <x-input-label for="level_id" :value="__('Level')" />
                                <select id="level_id" name="level_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select a level</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}" {{ old('level_id', $course->level_id) == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('level_id')" />
                            </div>
                        </div>

                        <!-- Image Upload with Simple Preview -->
                        <div>
                            <x-input-label for="image" :value="__('Course Image')" class="mb-2" />
                            
                            <!-- Current image -->
                            <div id="currentImageContainer" class="mb-3">
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-48 h-auto rounded border border-gray-200">
                                <p class="text-sm text-gray-600 mt-1">Current image</p>
                            </div>
                            
                            <!-- New image preview (initially hidden) -->
                            <div id="previewContainer" style="display: none" class="mb-3">
                                <img id="previewImage" src="#" alt="Preview" class="w-48 h-auto rounded border border-gray-200">
                                <p class="text-sm text-gray-600 mt-1">New image</p>
                                <button type="button" onclick="removeImage()" class="text-xs bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded mt-2">Remove</button>
                            </div>
                            
                            <!-- File input -->
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewFile()"
                                class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100">
                                    
                            <p class="mt-1 text-xs text-gray-500">Upload a new image or leave empty to keep the current one</p>
                            
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $course->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Course') }}</x-primary-button>
                            <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // // Auto-generate slug from title
        // document.getElementById('title').addEventListener('input', function() {
        //     let slug = this.value
        //         .toLowerCase()
        //         .replace(/[^\w\s-]/g, '')
        //         .replace(/\s+/g, '-');
        //     document.getElementById('slug').value = slug;
        // });
    
        // Simple inline image preview functions
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();
            
            reader.onloadend = function() {
                preview.src = reader.result;
                document.getElementById('previewContainer').style.display = 'block';
                document.getElementById('currentImageContainer').style.opacity = '0.5';
            }
            
            if (file) {
                reader.readAsDataURL(file);
            }
        }
        
        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('previewContainer').style.display = 'none';
            document.getElementById('currentImageContainer').style.opacity = '1';
        }
    </script>
    @endpush
</x-app-layout>