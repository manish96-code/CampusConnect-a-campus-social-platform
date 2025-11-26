<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 to-indigo-100 p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

        <h1 class="text-3xl font-extrabold text-purple-600 tracking-wide text-center">Social App</h1>

        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Create Your Account</h2>

        <form wire:submit.prevent="register" class="space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">First Name</label>
                    <input type="text" wire:model.live="first_name" class="w-full px-3 py-2 border rounded-lg ">
                    @error('first_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Last Name</label>
                    <input type="text" wire:model.live="last_name" class="w-full px-3 py-2 border rounded-lg ">
                    @error('last_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Date of Birth</label>
                <input type="date" wire:model.live="dob" class="w-full px-3 py-2 border rounded-lg ">
                @error('dob')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Gender</label>
                <select wire:model.live="gender" class="w-full px-3 py-2 border rounded-lg ">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                @error('gender')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Email</label>
                <input type="email" wire:model.live="email" class="w-full px-3 py-2 border rounded-lg ">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Contact</label>
                <input type="text" wire:model.live="contact" class="w-full px-3 py-2 border rounded-lg ">
                @error('contact')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Password</label>
                <input type="password" wire:model.live="password" class="w-full px-3 py-2 border rounded-lg ">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-purple-600 text-white py-2 rounded-lg font-semibold hover:bg-purple-700 transition-all duration-200 shadow-md">
                Register
            </button>
        </form>

        <p class="text-center text-gray-600 text-sm mt-4">
            Already have an account?
            <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">Login</a>
        </p>

    </div>
</div>
