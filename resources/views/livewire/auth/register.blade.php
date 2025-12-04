<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- Animated Background Blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-400/20 blur-[100px] animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-purple-400/20 blur-[100px]"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] rounded-full bg-blue-400/20 blur-[100px]"></div>
    </div>

    <div class="max-w-lg w-full relative z-10">
        <!-- Glass Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden p-8" x-data="{ showPassword: false }">
            
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 shadow-lg shadow-indigo-500/30 mb-4 text-white">
                    <i data-feather="user-plus" class="w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Join Campus Connect</h1>
                <p class="text-slate-500 text-sm mt-2">Create your student account to get started.</p>
            </div>

            <form wire:submit.prevent="register" class="space-y-5" novalidate>

                <!-- Names Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">First Name</label>
                        <input type="text" wire:model.live="first_name" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                            placeholder="John">
                        @error('first_name') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Last Name</label>
                        <input type="text" wire:model.live="last_name" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                            placeholder="Doe">
                        @error('last_name') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- DOB & Gender Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Date of Birth</label>
                        <input type="date" wire:model.live="dob" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-600">
                        @error('dob') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Gender</label>
                        <div class="relative">
                            <select wire:model.live="gender" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-600 appearance-none">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                                <i data-feather="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                        @error('gender') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Email Field -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-feather="mail" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="email" wire:model.live="email" 
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                            placeholder="student@university.edu">
                    </div>
                    @error('email') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Contact Field -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Phone Number</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-feather="phone" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="text" wire:model.live="contact" 
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                            placeholder="9876543210">
                    </div>
                    @error('contact') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-feather="lock" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        
                        <input :type="showPassword ? 'text' : 'password'" wire:model.live="password" 
                            class="w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                            placeholder="••••••••">

                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                            <i x-show="!showPassword" data-feather="eye" class="h-5 w-5"></i>
                            <i x-show="showPassword" data-feather="eye-off" class="h-5 w-5" style="display: none;"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:ring-4 focus:ring-indigo-500/50 flex items-center justify-center gap-2 mt-2">
                    <span wire:loading.remove wire:target="register">Create Account</span>
                    <span wire:loading wire:target="register" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Processing...
                    </span>
                </button>

            </form>

            <!-- Footer -->
            <p class="text-center text-slate-500 text-sm mt-8">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors hover:underline">Log in</a>
            </p>
        </div>
        
        <!-- Trust Text -->
        <p class="text-center text-xs text-slate-400 mt-6 flex items-center justify-center gap-1">
            <i data-feather="shield" class="w-3 h-3"></i>
            Secure Campus Registration
        </p>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            feather.replace();
        });
    </script>
</div>