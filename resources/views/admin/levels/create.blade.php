<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Level') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.levels.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create Level') }}</x-primary-button>
                            <a href="{{ route('admin.levels.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        nameInput.addEventListener('input', function() {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-');
        });
    </script>
    @endpush
</x-app-layout> 