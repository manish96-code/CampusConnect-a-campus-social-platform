<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 to-indigo-100 p-4">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">

        <h1 class="text-3xl font-extrabold text-purple-600 tracking-wide text-center">Social App</h1>

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Login</h2>

        <form wire:submit.prevent="login">

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" wire:model.live="email" class="w-full px-3 py-2 border rounded home">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-2">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" wire:model.live="password"
                    class="w-full px-3 py-2 border rounded home">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center gap-2 text-gray-700">
                    <input type="checkbox" class="rounded">
                    Remember Me
                </label>

                <a href="" class="text-purple-600 text-sm hover:underline">
                    Forgot Password?
                </a>
            </div>

            <button type="submit"
                class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700 transition-all">
                Login
            </button>

        </form>

        <p class="text-center text-gray-700 text-sm mt-4">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">Register</a>
        </p>

    </div>
</div>
