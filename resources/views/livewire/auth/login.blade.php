<div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <form wire:submit.prevent="login">
        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" wire:model="email" class="w-full p-2 border rounded">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Password</label>
            <input type="password" wire:model="password" class="w-full p-2 border rounded">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" wire:model="remember" class="mr-2">
                <span class="text-gray-700">Remember me</span>
            </label>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Login
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
            Don't have an account? Register
        </a>
    </div>
</div>
