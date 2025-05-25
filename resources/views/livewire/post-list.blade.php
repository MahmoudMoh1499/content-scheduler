<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Your Scheduled Posts</h2>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded">
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select wire:model.live="statusFilter" class="mt-1 block w-full border rounded p-2">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="scheduled">Scheduled</option>
                <option value="published">Published</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Platform</label>
            <select wire:model.live="platformFilter" class="mt-1 block w-full border rounded p-2">
                <option value="">All Platforms</option>
                @foreach($platforms as $platform)
                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" wire:model.live="dateFilter" class="mt-1 block w-full border rounded p-2">
        </div>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platforms</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scheduled Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($posts as $post)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span @class([
                                'px-2 py-1 text-xs rounded-full',
                                'bg-gray-100 text-gray-800' => $post->status === 'draft',
                                'bg-yellow-100 text-yellow-800' => $post->status === 'scheduled',
                                'bg-green-100 text-green-800' => $post->status === 'published',
                            ])>
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach ($post->platforms as $platform)
                                <span
                                    class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full mr-1">
                                    {{ $platform->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $post->scheduled_time->format('M j, Y g:i A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('posts.preview', $post->id) }}"
                                class="text-blue-600 hover:text-blue-800 mr-3">
                                Preview
                            </a>
                            <button wire:click="delete({{ $post->id }})" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
