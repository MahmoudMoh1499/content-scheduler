<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Schedule New Post</h2>

    @if(session('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Title -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Title</label>
            <input type="text" wire:model="title"
                   class="w-full p-2 border rounded">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Content -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Content</label>
                <textarea wire:model="content" rows="4" class="w-full p-2 border rounded"></textarea>
            <div class="text-sm text-gray-500">
                <span>{{ $characterCount }}</span>/{{ $maxChars }} characters
            </div>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Image Upload -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Image (Optional)</label>
            <input type="file" wire:model="image">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @if($image)
                <img src="{{ $image->temporaryUrl() }}" class="mt-2 h-32">
            @endif
        </div>

        <!-- Platforms -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Platforms</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                @foreach($platforms as $platform)
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                        <input type="checkbox"
                                class="h-5 w-5 text-blue-600 rounded"
                               wire:model="selectedPlatforms"
                               value="{{ $platform->id }}"
                        >
                            <span class="ml-3">{{ $platform->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('selectedPlatforms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Schedule Time -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Schedule Time</label>
            <input type="datetime-local"
                   wire:model="scheduled_time"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   class="w-full p-2 border rounded">
            @error('scheduled_time') <span class="text-red-500 text-spp/Http/Livewire/PostPreview.php">{{ $message }}</span> @enderror
        </div>

        <!-- Submit -->
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <span wire:loading.remove>Schedule Post</span>
            <span wire:loading>Saving...</span>
        </button>
    </form>
</div>
