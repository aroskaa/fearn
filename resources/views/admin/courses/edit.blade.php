<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Course') }}: {{ $course->name }}
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

                        <div>
                            <x-input-label for="image" :value="__('Course Image')" />
                            @if($course->image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($course->image) }}" alt="{{ $course->name }}" class="w-48 h-auto rounded">
                                </div>
                            @endif
                            <input type="file" id="image" name="image" accept="image/*" class="mt-2 block w-full">
                            <div class="mt-2 text-sm text-gray-500">
                                Leave empty to keep the current image. Recommended size: 1280x720 pixels (16:9 ratio)
                            </div>
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
        // Auto-generate slug from name
        document.getElementById('title').addEventListener('input', function() {
            let slug = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        });

        // Preview image before upload
        document.getElementById('image').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.className = 'mt-2 w-48 h-auto rounded';
                    let container = document.getElementById('image').parentNode;
                    let existingPreview = container.querySelector('img:not([src^="data:"])');
                    if (existingPreview) {
                        existingPreview.style.display = 'none';
                    }
                    let newPreview = container.querySelector('img[src^="data:"]');
                    if (newPreview) {
                        container.removeChild(newPreview);
                    }
                    container.insertBefore(preview, document.getElementById('image').nextSibling);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
    @endpush
</x-app-layout> 