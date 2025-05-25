<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
                <a href="{{ route('posts') }}" class="text-gray-500 hover:text-gray-700">
                    &times;
                </a>
            </div>
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach($post->platforms as $platform)
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $platform->name }}
                    </span>
                @endforeach
            </div>
        </div>

        <!-- Content -->
        <div class="px-6 py-4">
            <div class="prose max-w-none">
                {!! nl2br(e($post->content)) !!}
            </div>

            @if($post->image_url)
                <div class="mt-6">
                    <img src="{{ Storage::url($post->image_url) }}"
                         class="rounded-lg max-h-96 mx-auto">
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t bg-gray-50">
            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Status:</span>
                    <span @class([
                        'ml-2 capitalize',
                        'text-gray-600' => $post->status === 'draft',
                        'text-yellow-600' => $post->status === 'scheduled',
                        'text-green-600' => $post->status === 'published',
                    ])>
                        {{ $post->status }}
                    </span>
                </div>
                <div>
                    <span class="font-medium">Scheduled:</span>
                    <span class="ml-2">
                        {{ $post->scheduled_time->format('M j, Y \a\t g:i A') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('posts') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Back to Posts
        </a>
    </div>
</div>
