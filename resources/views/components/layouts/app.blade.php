<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Content Scheduler' }}</title>
    @livewireStyles
    @stack('styles')

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold">Content Scheduler</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">
                        📅 Dashboard
                    </a>
                    <a href="{{ route('schedule') }}" class="text-gray-700 hover:text-blue-600">Schedule</a>
                    <a href="{{ route('posts') }}" class="text-gray-700 hover:text-blue-600">Posts</a>
                    <a href="{{ route('settings.platforms') }}"
                       class="text-gray-700 hover:text-blue-600">
                        Platform Settings
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-12">
        {{ $slot }}
    </main>

    @livewireScripts
    @stack('scripts')
</body>

</html>
