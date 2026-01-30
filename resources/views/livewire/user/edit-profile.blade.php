<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-10 text-white relative">
            <h1 class="text-3xl font-extrabold tracking-tight">Edit Your Profile</h1>
            <p class="mt-2 text-indigo-100">Personalize your account and how others see you.</p>

            <div class="absolute -bottom-12 right-8">
                <div class="relative group">
                    <div class="h-24 w-24 rounded-2xl overflow-hidden border-4 border-white shadow-lg bg-slate-100">
                        @if($dp)
                            <img src="{{ $dp->temporaryUrl() }}" class="h-full w-full object-cover">
                        @elseif($existingDp)
                            <img src="{{ $existingDp }}" class="h-full w-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $first_name }}+{{ $last_name }}&background=6366f1&color=fff"
                                class="h-full w-full object-cover">
                        @endif
                    </div>
                    <label for="dp-upload"
                        class="absolute -bottom-2 -right-2 bg-white p-2 rounded-xl shadow-md cursor-pointer hover:bg-slate-50 transition-colors border border-slate-100">
                        <x-heroicon-o-camera class="w-5 h-5 text-indigo-600" />
                        <input type="file" id="dp-upload" wire:model="dp" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>
        </div>

        <div class="px-8 pt-16 pb-12">
            <form wire:submit.prevent="update" class="space-y-8">

                <!-- Section: Cover Photo -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <x-heroicon-o-photo class="w-5 h-5 text-indigo-500" />
                        Cover Photo
                    </h3>
                    <div
                        class="relative h-40 rounded-2xl overflow-hidden bg-slate-100 border-2 border-dashed border-slate-200 group">
                        @if($cover)
                            <img src="{{ $cover->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($existingCover)
                            <img src="{{ $existingCover }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-slate-400">
                                <x-heroicon-o-photo class="w-10 h-10" />
                            </div>
                        @endif

                        <label for="cover-upload"
                            class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <span
                                class="bg-white/90 backdrop-blur-sm text-slate-800 px-4 py-2 rounded-xl font-semibold text-sm">
                                Change Cover
                            </span>
                            <input type="file" id="cover-upload" wire:model="cover" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">First Name</label>
                        <input type="text" wire:model="first_name"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            placeholder="John">
                        @error('first_name') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Last Name</label>
                        <input type="text" wire:model="last_name"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            placeholder="Doe">
                        @error('last_name') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Email Address</label>
                        <input type="email" wire:model="email"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            placeholder="john@example.com">
                        @error('email') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Contact -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Phone Number</label>
                        <input type="text" wire:model="contact" maxlength="10"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all outline-none"
                            placeholder="Enter 10 digit number">
                        @error('contact') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Date of Birth</label>
                        <input type="date" wire:model="dob"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                        @error('dob') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Gender -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 ml-1">Gender</label>
                        <select wire:model="gender"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        @error('gender') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-8 flex items-center justify-end gap-4 border-t border-slate-100">
                    <a wire:navigate href="{{ route('profile') }}"
                        class="px-6 py-3 rounded-2xl font-bold text-slate-600 hover:bg-slate-50 transition-all">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                        <span wire:loading.remove wire:target="update">Save Changes</span>
                        <span wire:loading wire:target="update" class="flex items-center gap-2">
                            <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin" />
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>