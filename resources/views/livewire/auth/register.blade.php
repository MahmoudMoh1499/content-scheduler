<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Create Account</h2>

    <form wire:submit.prevent="register">
        <!-- Name -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Full Name</label>
            <input type="text" wire:model="name" class="w-full p-2 border rounded" autofocus>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

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

        <!-- Confirm Password -->
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" class="w-full p-2 border rounded">
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Register
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
            Already have an account? Login
        </a>
    </div>
</div>
