<div class="min-h-screen flex bg-white relative overflow-hidden">

    <div class="hidden lg:block relative w-0 flex-1 overflow-hidden bg-indigo-900">
        <img class="absolute inset-0 h-full w-full object-cover object-center opacity-40 mix-blend-overlay filter blur-[1px]"
            src="https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=1200&auto=format&fit=crop"
            alt="Campus grounds">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/90 to-blue-500/90 mix-blend-multiply"></div>

        <div class="relative z-10 flex flex-col justify-center h-full px-12 text-white">
            <div class="mb-6">
                <div
                    class="h-16 w-16 flex items-center justify-center rounded-2xl bg-white/20 backdrop-blur-lg border border-white/30 text-white mb-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.558 50.552 50.552 0 00-2.658.813m-15.482 0A50.555 50.555 0 0112 13.489a50.555 50.555 0 0110.499-3.342" />
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight">Welcome to Campus Connect</h1>
                <p class="mt-4 text-lg text-indigo-100 max-w-md leading-relaxed">
                    Your central hub for academic life. Register today to access courses, events, and connect with your
                    community.
                </p>
            </div>
            <div class="absolute bottom-10 left-12 text-sm text-indigo-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M9.661 2.237a.531.531 0 01.678 0 11.947 11.947 0 006.878 2.743c.484.114.823.542.823 1.043v4.572c0 3.573-2.213 6.839-5.504 8.32a.628.628 0 01-.513 0C5.153 17.462 2.94 14.196 2.94 10.623V6.023c0-.501.339-.929.823-1.043A11.947 11.947 0 009.661 2.237z"
                        clip-rule="evenodd" />
                </svg>
                Official Campus Portal
            </div>
        </div>
    </div>

    <div
        class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-16 xl:px-24 bg-gray-50 lg:bg-white w-full lg:w-[600px] xl:w-[700px]">
        <div class="mx-auto w-full max-w-md lg:max-w-lg space-y-8" x-data="{ showPassword: false }">

            <div class="text-center lg:text-left">
                <div
                    class="lg:hidden mx-auto h-12 w-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white mb-4 shadow-lg shadow-indigo-600/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.558 50.552 50.552 0 00-2.658.813m-15.482 0A50.555 50.555 0 0112 13.489a50.555 50.555 0 0110.499-3.342" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Create Student Account</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Enter your details below to join the platform.
                </p>
            </div>

            <form wire:submit.prevent="register" class="space-y-6 mt-8" novalidate>

                <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold leading-6 text-gray-700">First Name</label>
                        <div class="mt-1.5">
                            <input type="text" wire:model.blur="first_name"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 transition-shadow bg-white/50 focus:bg-white"
                                placeholder="John">
                        </div>
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold leading-6 text-gray-700">Last Name</label>
                        <div class="mt-1.5">
                            <input type="text" wire:model.blur="last_name"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 transition-shadow bg-white/50 focus:bg-white"
                                placeholder="Doe">
                        </div>
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold leading-6 text-gray-700">Date of Birth</label>
                        <div class="mt-1.5">
                            <input type="date" wire:model.blur="dob"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 transition-shadow bg-white/50 focus:bg-white">
                        </div>
                        @error('dob')
                            <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold leading-6 text-gray-700">Gender</label>
                        <div class="relative mt-1.5">
                            <select wire:model.blur="gender"
                                class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 appearance-none transition-shadow bg-white/50 focus:bg-white">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-700">University Email</label>
                    <div class="relative mt-1.5 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="email" wire:model.blur="email"
                            class="block w-full rounded-lg border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 transition-shadow bg-white/50 focus:bg-white"
                            placeholder="student@university.edu">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-700">Phone Number</label>
                    <div class="relative mt-1.5 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.blur="contact"
                            class="block w-full rounded-lg border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 transition-shadow bg-white/50 focus:bg-white"
                            placeholder="9876543210">
                    </div>
                    @error('contact')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold leading-6 text-gray-700">Password</label>
                    <div class="relative mt-1.5 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>

                        <input :type="showPassword ? 'text' : 'password'" wire:model.blur="password"
                            class="block w-full rounded-lg border-0 py-2.5 pl-10 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 transition-shadow bg-white/50 focus:bg-white"
                            placeholder="••••••••">

                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-indigo-600 focus:outline-none transition-colors">
                            <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5" style="display: none;"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all transform hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:translate-y-0">

                        <span wire:loading.remove wire:target="register">Create My Account</span>

                        <span wire:loading wire:target="register" class="flex items-center gap-2">
                            <svg class="animate-spin -ml-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>

            </form>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Already a member?
                    <a href="{{ route('login') }}"
                        class="font-semibold text-indigo-600 hover:text-indigo-500 hover:underline transition-colors">
                        Log in here
                    </a>
                </p>
                <div class="mt-8 flex justify-center items-center gap-2 text-xs text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd"
                            d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Secure Campus SSL Encryption</span>
                </div>
            </div>
        </div>
    </div>
</div>
