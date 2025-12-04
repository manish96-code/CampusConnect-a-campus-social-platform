<div class=" mx-auto px-4 lg:px-8 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- 1. LEFT SIDEBAR (Navigation) -->
        {{-- <div class="hidden lg:block lg:col-span-3">
            <div class="sticky top-24">
                <livewire:user.sidebar />
            </div>
        </div> --}}

        <!-- 2. MAIN PROFILE CONTENT -->
        <div class="lg:col-span-10 ">
            
            <!-- PROFILE HEADER CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6 relative group/cover">
                
                <!-- Cover Photo -->
                <div class="h-48 md:h-64 w-full bg-slate-200 relative">
                    <img src="@if ($selectedUser->cover) {{ asset('storage/images/cover/' . $selectedUser->cover) }} @else https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop @endif"
                        class="w-full h-full object-cover" 
                        alt="Cover Photo">
                    
                    <!-- Dark Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                    <!-- Edit Cover Button -->
                    @if ($selectedUser->id == auth()->user()->id)
                        <div class="absolute top-4 right-4 opacity-0 group-hover/cover:opacity-100 transition-opacity">
                            <form wire:submit.prevent="updateProfile" enctype="multipart/form-data">
                                <label for="uploadCover" class="flex items-center gap-2 bg-black/50 hover:bg-black/70 backdrop-blur-md text-white px-3 py-1.5 rounded-lg cursor-pointer text-xs font-medium transition-all">
                                    <svg wire:loading wire:target="cover" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <svg wire:loading.remove wire:target="cover" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span>Edit Cover</span>
                                </label>
                                <input type="file" class="hidden" wire:model="cover" id="uploadCover" accept="image/*">
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Profile Info Bar -->
                <div class="px-6 pb-6 relative">
                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-12 gap-4">
                        
                        <!-- Avatar Container -->
                        <div class="relative group/avatar flex-shrink-0">
                            <div class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-md overflow-hidden relative z-10">
                                <img src="@if ($selectedUser->dp) {{ asset('storage/images/dp/' . $selectedUser->dp) }} @else https://ui-avatars.com/api/?name={{ $selectedUser->first_name }}+{{ $selectedUser->last_name }}&background=6366f1&color=fff @endif"
                                    class="w-full h-full object-cover">
                                
                                <!-- Edit Avatar Overlay -->
                                @if ($selectedUser->id == auth()->user()->id)
                                    <form wire:submit.prevent="updateProfile" enctype="multipart/form-data">
                                        <label for="uploadDp" class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover/avatar:opacity-100 transition-opacity cursor-pointer z-20">
                                            <svg wire:loading.remove wire:target="dp" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            <svg wire:loading wire:target="dp" class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </label>
                                        <input type="file" class="hidden" wire:model="dp" id="uploadDp" accept="image/*">
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="flex-1 text-center md:text-left mt-2 md:mt-0 md:mb-1">
                            <h1 class="text-2xl font-bold text-slate-800 capitalize flex items-center justify-center md:justify-start gap-2">
                                {{ $selectedUser->first_name }} {{ $selectedUser->last_name }}
                                <svg class="w-5 h-5 text-blue-500 fill-current" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            </h1>
                            <p class="text-slate-500 font-medium text-sm">
                                {{ $selectedUser->course ?? 'Student' }} • Purnea University
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 mb-1">
                            @if ($selectedUser->id == auth()->user()->id)
                                <button class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 border border-indigo-200 font-semibold px-4 py-2 rounded-xl transition text-sm flex items-center gap-2">
                                    <i data-feather="edit-2" class="w-4 h-4"></i> Edit
                                </button>
                            @else
                                <div class="w-32">
                                    <livewire:user.friendship-button :selectedUser="$selectedUser" :key="$selectedUser->id" />
                                </div>
                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl transition text-sm flex items-center gap-2 shadow-sm shadow-indigo-200">
                                    <i data-feather="message-circle" class="w-4 h-4"></i> Message
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- CONTENT GRID (Intro & Posts) -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
                
                <!-- LEFT COLUMN: Intro (4 Cols on XL) -->
                <div class="xl:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <h3 class="font-bold text-slate-800 text-base mb-4">About</h3>
                        
                        <div class="space-y-3">
                            @if ($selectedUser->course)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <i data-feather="book-open" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-sm">Studies <strong>{{ $selectedUser->course }}</strong></span>
                                </div>
                            @endif

                            @if ($selectedUser->contact)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <i data-feather="phone" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-sm">{{ $selectedUser->contact }}</span>
                                </div>
                            @endif

                            @if ($selectedUser->email)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <i data-feather="mail" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-sm break-all">{{ $selectedUser->email }}</span>
                                </div>
                            @endif

                            @if ($selectedUser->dob)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <i data-feather="gift" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-sm">Born <strong>{{ \Carbon\Carbon::parse($selectedUser->dob)->format('F j, Y') }}</strong></span>
                                </div>
                            @endif

                            @if ($selectedUser->gender)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <i data-feather="user" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-sm capitalize">{{ $selectedUser->gender }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Photos Placeholder -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-800 text-base">Photos</h3>
                            <a href="#" class="text-indigo-600 text-xs font-medium hover:underline">See All</a>
                        </div>
                        <div class="grid grid-cols-3 gap-2 rounded-xl overflow-hidden">
                            <div class="aspect-square bg-slate-100">
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i data-feather="image" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div class="aspect-square bg-slate-100">
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i data-feather="image" class="w-6 h-6"></i>
                                </div>
                            </div>
                            <div class="aspect-square bg-slate-100">
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i data-feather="image" class="w-6 h-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Feed (8 Cols on XL) -->
                <div class="xl:col-span-8 space-y-6">
                    
                    <!-- Create Post (Only if own profile) -->
                    @if ($selectedUser->id == auth()->user()->id)
                        <livewire:user.post.create-post />
                    @endif

                    <!-- Posts List -->
                    <div>
                        <h3 class="font-bold text-slate-700 text-lg mb-4 px-1">Recent Activity</h3>
                        <livewire:user.post.calling-post :selectedUser="$selectedUser" />
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Init Icons -->
    <script>
        feather.replace();
    </script>
</div>