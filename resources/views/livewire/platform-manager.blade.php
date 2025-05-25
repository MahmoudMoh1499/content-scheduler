<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Manage Platforms</h2>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            @foreach($platforms as $platform)
                <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox"
                           wire:model="selectedPlatforms"
                           value="{{ $platform->id }}"
                           class="h-5 w-5 text-blue-600 rounded">
                    <div class="ml-3">
                        <span class="block text-gray-900 font-medium">{{ $platform->name }}</span>
                        <span class="block text-gray-500 text-sm">
                            Max {{ $platform->character_limit }} characters
                        </span>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    </form>
</div>
