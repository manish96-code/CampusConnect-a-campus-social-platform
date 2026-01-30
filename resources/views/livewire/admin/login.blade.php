<div class="min-h-screen flex items-center justify-center bg-slate-950 relative overflow-hidden px-4">
    <!-- Abstract Background Effects -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/10 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-violet-600/10 rounded-full blur-[120px]"></div>

    <div class="w-full max-w-md relative z-10" x-data="{ showPassword: false }">
        <!-- Logo/Header -->
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-indigo-600 shadow-2xl shadow-indigo-500/20 mb-6 group transition-transform hover:scale-105 duration-300">
                <x-heroicon-o-shield-check class="w-10 h-10 text-white" />
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Admin<span class="text-indigo-500">Access</span>
            </h1>
            <p class="text-slate-400 mt-2 text-sm font-medium uppercase tracking-widest">Management Portal</p>
        </div>

        <!-- Login Card -->
        <div class="bg-slate-900/50 backdrop-blur-xl border border-slate-800 p-10 rounded-[2.5rem] shadow-3xl">
            <form wire:submit.prevent="login" class="space-y-6">
                <!-- Email -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Admin Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-heroicon-o-envelope
                                class="w-5 h-5 text-slate-600 group-focus-within:text-indigo-400 transition-colors" />
                        </div>
                        <input type="email" wire:model="email"
                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl py-4 pl-12 pr-4 text-white placeholder:text-slate-700 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all"
                            placeholder="admin@campusconnect.com">
                    </div>
                    @error('email') <span class="text-xs text-rose-500 ml-1 font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Security Key</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-heroicon-o-lock-closed
                                class="w-5 h-5 text-slate-600 group-focus-within:text-indigo-400 transition-colors" />
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                            class="w-full bg-slate-950 border border-slate-800 rounded-2xl py-4 pl-12 pr-12 text-white placeholder:text-slate-700 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all"
                            placeholder="••••••••••••">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-600 hover:text-indigo-400 transition-colors">
                            <x-heroicon-o-eye x-show="!showPassword" class="w-5 h-5" />
                            <x-heroicon-o-eye-slash x-show="showPassword" class="w-5 h-5" />
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-rose-500 ml-1 font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-black shadow-lg shadow-indigo-600/20 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                        <span wire:loading.remove wire:target="login">Authenticate Access</span>
                        <span wire:loading wire:target="login" class="flex items-center gap-2">
                            <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin" />
                            Verifying...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <a href="{{ route('login') }}"
                class="text-slate-600 hover:text-indigo-400 text-sm font-bold transition-colors">
                Return to Student Login
            </a>
        </div>
    </div>
</div>