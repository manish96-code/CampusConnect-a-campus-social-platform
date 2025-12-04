<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- Animated Background Blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-400/20 blur-[100px] animate-pulse"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-purple-400/20 blur-[100px]"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[40%] h-[40%] rounded-full bg-blue-400/20 blur-[100px]"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
        <!-- Glass Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden p-8" x-data="{ showPassword: false }">
            
            <!-- Brand Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 shadow-lg shadow-indigo-500/30 mb-4 text-white">
                    <i data-feather="log-in" class="w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Welcome Back</h1>
                <p class="text-slate-500 text-sm mt-2">Enter your credentials to access your account.</p>
            </div>

            <form wire:submit.prevent="login" class="space-y-6" novalidate>

                <!-- Email Field -->
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-feather="mail" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="email" id="email" wire:model.live="email" 
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                            placeholder="student@university.edu">
                    </div>
                    @error('email') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-semibold text-slate-600 ml-1 uppercase tracking-wider">Password</label>
                    </div>
                    
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-feather="lock" class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        
                        <!-- Dynamic Type for Show/Hide Password -->
                        <input :type="showPassword ? 'text' : 'password'" id="password" wire:model.live="password" 
                            class="w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-slate-800 placeholder-slate-400"
                            placeholder="••••••••">

                        <!-- Toggle Button -->
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                            <i x-show="!showPassword" data-feather="eye" class="h-5 w-5"></i>
                            <i x-show="showPassword" data-feather="eye-off" class="h-5 w-5" style="display: none;"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-rose-500 text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer hover:text-indigo-600 transition-colors">
                        <input type="checkbox" wire:model="remember" class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 cursor-pointer">
                        <span>Remember me</span>
                    </label>

                    <a href="#" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700 hover:underline transition-colors">
                        Forgot Password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:ring-4 focus:ring-indigo-500/50 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="login">Sign In</span>
                    <span wire:loading wire:target="login" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Authenticating...
                    </span>
                </button>

            </form>

            <!-- Footer -->
            <p class="text-center text-slate-500 text-sm mt-8">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:text-indigo-800 transition-colors hover:underline">Create Account</a>
            </p>
        </div>
        
        <!-- Trust Text -->
        <p class="text-center text-xs text-slate-400 mt-6 flex items-center justify-center gap-1">
            <i data-feather="shield" class="w-3 h-3"></i>
            Secure Campus Connection
        </p>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            feather.replace();
        });
    </script>
</div>