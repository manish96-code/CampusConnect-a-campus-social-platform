<div>
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 min-h-screen">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- MAIN CONTENT -->
            <div class="lg:col-span-9 xl:col-span-8">

                <!-- Breadcrumb / Header -->
                <div class="mb-6 flex items-center gap-3">
                    {{-- <a href="{{ route('home') }}"
                        class="p-2 rounded-full bg-white border border-slate-200 text-slate-500 hover:text-indigo-600 transition">
                        <i data-feather="arrow-left" class="w-4 h-4"></i>
                    </a> --}}
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Create New Group</h1>
                        <p class="text-sm text-slate-500">Build a community for students to connect.</p>
                    </div>
                </div>

                <div class="bg-white border border-slate-100 rounded-3xl shadow-sm overflow-hidden">

                    <!-- Decorative Header -->
                    <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                    <form wire:submit.prevent="create_group" class="p-6 md:p-8 space-y-8">

                        <!-- 1. GROUP DETAILS -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">1</span>
                                Basic Details
                            </h3>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Group Name</label>
                                <input type="text" wire:model.live="group_name"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition font-medium text-slate-800 placeholder-slate-400"
                                    placeholder="e.g. Coding Club 2025">
                                @error('group_name')
                                    <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Description <span
                                        class="text-slate-400 font-normal">(Optional)</span></label>
                                <textarea wire:model="description" rows="3"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none resize-none transition text-slate-700"
                                    placeholder="What is this group about?"></textarea>
                                @error('description')
                                    <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Privacy Selection -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-3">Privacy Setting</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Public Option -->
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" wire:model.live="group_type" value="public"
                                            class="peer sr-only">
                                        <div
                                            class="p-4 rounded-xl border-2 transition-all duration-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 border-slate-200 hover:border-indigo-200">
                                            <div class="flex items-center gap-3 mb-1">
                                                <div class="p-2 rounded-lg bg-indigo-100 text-indigo-600">
                                                    <i data-feather="globe" class="w-4 h-4"></i>
                                                </div>
                                                <span class="font-bold text-slate-800">Public Group</span>
                                            </div>
                                            <p class="text-xs text-slate-500 ml-[52px]">Anyone can see posts and join
                                                this group.</p>
                                        </div>
                                        <div
                                            class="absolute top-4 right-4 text-indigo-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <i data-feather="check-circle" class="w-5 h-5 fill-indigo-100"></i>
                                        </div>
                                    </label>

                                    <!-- Private Option -->
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" wire:model.live="group_type" value="private"
                                            class="peer sr-only">
                                        <div
                                            class="p-4 rounded-xl border-2 transition-all duration-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 border-slate-200 hover:border-indigo-200">
                                            <div class="flex items-center gap-3 mb-1">
                                                <div class="p-2 rounded-lg bg-indigo-100 text-indigo-600">
                                                    <i data-feather="lock" class="w-4 h-4"></i>
                                                </div>
                                                <span class="font-bold text-slate-800">Private Group</span>
                                            </div>
                                            <p class="text-xs text-slate-500 ml-[52px]">Only members can see posts.
                                                Admin must approve join requests.</p>
                                        </div>
                                        <div
                                            class="absolute top-4 right-4 text-indigo-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <i data-feather="check-circle" class="w-5 h-5 fill-indigo-100"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="h-px bg-slate-100 w-full"></div>

                        <!-- 2. VISUALS -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <span
                                    class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">2</span>
                                Visuals
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <!-- Profile_pic Upload -->
                                <div class="md:col-span-1">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Icon / Logo</label>
                                    <div class="flex flex-col items-center">
                                        <label
                                            class="relative w-32 h-32 rounded-full border-2 border-dashed border-slate-300 hover:border-indigo-500 cursor-pointer transition flex items-center justify-center bg-slate-50 overflow-hidden group">

                                            @if ($profile_pic)
                                                <img src="{{ $profile_pic->temporaryUrl() }}"
                                                    class="w-full h-full object-cover">
                                                <!-- Remove Overlay -->
                                                <div
                                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                                    <i data-feather="edit-2" class="w-6 h-6 text-white"></i>
                                                </div>
                                            @else
                                                <div class="text-center p-4">
                                                    <i data-feather="image"
                                                        class="w-6 h-6 text-slate-400 mx-auto mb-1"></i>
                                                    <span
                                                        class="text-[10px] text-slate-500 uppercase font-bold">Upload</span>
                                                </div>
                                            @endif

                                            <input type="file" wire:model="profile_pic" class="hidden"
                                                accept="image/*">

                                            <!-- Loading Spinner -->
                                            <div wire:loading wire:target="profile_pic"
                                                class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                                <div
                                                    class="animate-spin rounded-full h-6 w-6 border-2 border-indigo-600 border-t-transparent">
                                                </div>
                                            </div>
                                        </label>
                                        @error('profile_pic')
                                            <span class="text-rose-500 text-xs mt-2 text-center">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cover Image Upload -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Cover Banner</label>
                                    <label
                                        class="relative block w-full h-32 rounded-xl border-2 border-dashed border-slate-300 hover:border-indigo-500 cursor-pointer transition bg-slate-50 overflow-hidden group">

                                        @if ($cover_pic)
                                            <img src="{{ $cover_pic->temporaryUrl() }}"
                                                class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                                <span class="text-white text-sm font-bold flex items-center gap-2">
                                                    <i data-feather="refresh-ccw" class="w-4 h-4"></i> Change Cover
                                                </span>
                                            </div>
                                        @else
                                            <div
                                                class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                                                <i data-feather="image" class="w-8 h-8 mb-2 opacity-50"></i>
                                                <span class="text-sm font-medium">Click to upload cover image</span>
                                                <span class="text-[10px] opacity-70">Recommended: 1200x400px</span>
                                            </div>
                                        @endif

                                        <input type="file" wire:model="cover_pic" class="hidden"
                                            accept="image/*">

                                        <!-- Loading -->
                                        <div wire:loading wire:target="cover_pic"
                                            class="absolute inset-0 bg-white/80 flex items-center justify-center">
                                            <div class="flex items-center gap-2 text-indigo-600 font-bold text-sm">
                                                <div
                                                    class="animate-spin rounded-full h-4 w-4 border-2 border-current border-t-transparent">
                                                </div>
                                                Uploading...
                                            </div>
                                        </div>
                                    </label>
                                    @error('cover_pic')
                                        <span class="text-rose-500 text-xs mt-2 block">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-4">
                            <a href="{{ route('home') }}"
                                class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="create">Create Group</span>
                                <span wire:loading wire:target="create" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            fill="none" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Creating...
                                </span>
                            </button>
                        </div>

                    </form>
                </div>

                @if (session()->has('message'))
                    <div class="mt-3 px-4 py-3 bg-emerald-100 text-emerald-700 rounded-xl flex items-center gap-2 text-sm font-bold">
                        <i data-feather="check-circle" class="w-4 h-4"></i> {{ session('message') }}
                    </div>
                @endif
            </div>


        </div>

        <!-- Init Icons -->
        <script>
            document.addEventListener('livewire:initialized', () => feather.replace());
            document.addEventListener('livewire:navigated', () => feather.replace());
        </script>
    </div>
</div>
