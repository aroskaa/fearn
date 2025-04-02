<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Add New Lesson to') }}: {{ $course->name }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ $course->category->name }} / {{ $course->level->name }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.courses.lessons.store', $course) }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="title" :value="__('Lesson Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        {{-- <div>
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                        </div> --}}

                        <div>
                            <x-input-label for="description" :value="__('Short Description')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label for="content" :value="__('Lesson Content')" />
                            <textarea id="content" name="content" rows="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('content') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <div>
                            <x-input-label for="video_url" :value="__('Video URL')" />
                            <x-text-input id="video_url" name="video_url" type="url" class="mt-1 block w-full" :value="old('video_url')" placeholder="https://www.youtube.com/watch?v=..." />
                            <p class="mt-1 text-sm text-gray-500">YouTube, Vimeo, or other video platform URL</p>
                            <x-input-error class="mt-2" :messages="$errors->get('video_url')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="duration" :value="__('Duration (minutes)')" />
                                <x-text-input id="duration" name="duration" type="number" min="1" class="mt-1 block w-full" :value="old('duration')" />
                                <x-input-error class="mt-2" :messages="$errors->get('duration')" />
                            </div>

                            <div>
                                <x-input-label for="order" :value="__('Order')" />
                                <x-text-input id="order" name="order" type="number" min="0" class="mt-1 block w-full" :value="old('order', $course->lessons()->count())" />
                                <p class="mt-1 text-sm text-gray-500">Position in the course (0 is first)</p>
                                <x-input-error class="mt-2" :messages="$errors->get('order')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Lesson') }}</x-primary-button>
                            <a href="{{ route('admin.courses.lessons.index', $course) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
    <script>
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            let slug = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-');
            document.getElementById('slug').value = slug;
        });

        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
    @endpush
</x-app-layout> 