<div class=" mx-auto px-4 lg:px-8 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- 2. MAIN PROFILE CONTENT -->
        <div class="lg:col-span-10 ">

            <!-- PROFILE HEADER CARD -->
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6 relative group/cover">

                <!-- Cover Photo -->
                <div class="h-48 md:h-64 w-full bg-slate-200 relative">
                    <img src="@if ($selectedUser->cover) {{ asset('storage/images/cover/' . $selectedUser->cover) }} @else https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop @endif"
                        class="w-full h-full object-cover" alt="Cover Photo">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                    <!-- Edit Cover Button -->
                    @if ($selectedUser->id == auth()->user()->id)
                        <div class="absolute top-4 right-4 opacity-0 group-hover/cover:opacity-100 transition-opacity">
                            <form wire:submit.prevent="updateProfile" enctype="multipart/form-data">
                                <label for="uploadCover"
                                    class="flex items-center gap-2 bg-black/50 hover:bg-black/70 backdrop-blur-md text-white px-3 py-1.5 rounded-lg cursor-pointer text-xs font-medium transition-all">

                                    <x-heroicon-o-arrow-path wire:loading wire:target="cover"
                                        class="w-4 h-4 animate-spin" />
                                    <x-heroicon-o-camera wire:loading.remove wire:target="cover" class="w-4 h-4" />
                                    <span>Edit Cover</span>
                                </label>
                                <input type="file" class="hidden" wire:model="cover" id="uploadCover"
                                    accept="image/*">
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Profile Info Bar -->
                <div class="px-6 pb-6 relative">
                    <div class="flex flex-col md:flex-row items-start md:items-end -mt-12 gap-4">

                        <!-- Avatar -->
                        <div class="relative group/avatar flex-shrink-0">
                            <div
                                class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-md overflow-hidden relative z-10">
                                <img src="@if ($selectedUser->dp) {{ asset('storage/images/dp/' . $selectedUser->dp) }} @else https://ui-avatars.com/api/?name={{ $selectedUser->first_name }}+{{ $selectedUser->last_name }}&background=6366f1&color=fff @endif"
                                    class="w-full h-full object-cover">

                                @if ($selectedUser->id == auth()->user()->id)
                                    <form wire:submit.prevent="updateProfile" enctype="multipart/form-data">
                                        <label for="uploadDp"
                                            class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover/avatar:opacity-100 transition-opacity cursor-pointer z-20">

                                            <x-heroicon-o-camera wire:loading.remove wire:target="dp"
                                                class="w-8 h-8 text-white mb-1" />
                                            <x-heroicon-o-arrow-path wire:loading wire:target="dp"
                                                class="w-8 h-8 text-white animate-spin" />
                                        </label>
                                        <input type="file" class="hidden" wire:model="dp" id="uploadDp"
                                            accept="image/*">
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="flex-1 text-center md:text-left mt-2 md:mt-0 md:mb-1">
                            <h1
                                class="text-2xl font-bold text-slate-800 capitalize flex items-center justify-center md:justify-start gap-2">
                                {{ $selectedUser->first_name }} {{ $selectedUser->last_name }}
                                <x-heroicon-s-check-badge class="w-5 h-5 text-blue-500" />
                            </h1>
                            <p class="text-slate-500 font-medium text-sm">
                                {{ $selectedUser->course ?? 'Student' }} • Purnea University
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 mb-1">
                            @if ($selectedUser->id == auth()->user()->id)
                                <button
                                    class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 border border-indigo-200 font-semibold px-4 py-2 rounded-xl transition text-sm flex items-center gap-2">
                                    <x-heroicon-o-pencil-square class="w-4 h-4" /> Edit
                                </button>
                            @else
                                <div class="w-40">
                                    <livewire:user.friendship-button :selectedUser="$selectedUser" :key="$selectedUser->id" />
                                </div>
                                <button
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl transition text-sm flex items-center gap-2 shadow-sm shadow-indigo-200">
                                    <x-heroicon-o-chat-bubble-left-right class="w-4 h-4" /> Message
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <!-- CONTENT GRID -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

                <!-- LEFT COLUMN -->
                <div class="xl:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5">
                        <h3 class="font-bold text-slate-800 text-base mb-4">About</h3>

                        <div class="space-y-3">
                            @if ($selectedUser->course)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <x-heroicon-o-book-open class="w-4 h-4" />
                                    </div>
                                    <span class="text-sm">Studies <strong>{{ $selectedUser->course }}</strong></span>
                                </div>
                            @endif

                            @if ($selectedUser->contact)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <x-heroicon-o-phone class="w-4 h-4" />
                                    </div>
                                    <span class="text-sm">{{ $selectedUser->contact }}</span>
                                </div>
                            @endif

                            @if ($selectedUser->email)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <x-heroicon-o-envelope class="w-4 h-4" />
                                    </div>
                                    <span class="text-sm break-all">{{ $selectedUser->email }}</span>
                                </div>
                            @endif

                            @if ($selectedUser->dob)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <x-heroicon-o-gift class="w-4 h-4" />
                                    </div>
                                    <span class="text-sm">
                                        Born
                                        <strong>{{ \Carbon\Carbon::parse($selectedUser->dob)->format('F j, Y') }}</strong>
                                    </span>
                                </div>
                            @endif

                            @if ($selectedUser->gender)
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <x-heroicon-o-user class="w-4 h-4" />
                                    </div>
                                    <span class="text-sm capitalize">{{ $selectedUser->gender }}</span>
                                </div>
                            @endif

                            @if ($selectedUser->id === auth()->id())
                                <a wire:navigate href="{{ route('courses') }}">
                                    <div class="flex items-center gap-3 text-slate-600 mt-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                            <x-heroicon-o-squares-2x2 class="w-4 h-4" />
                                        </div>
                                        <span>Courses</span>
                                    </div>
                                </a>
                            @endif


                        </div>
                    </div>


                    <!-- Photos / Media -->
                    <div x-data="{ expanded: false }"
                        class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 transition-all duration-300">

                        <!-- Heading -->
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-800 text-base">Photos</h3>

                            @if ($mediaPosts->count() > 3)
                                <button @click="expanded = !expanded"
                                    class="text-indigo-600 text-xs font-medium hover:underline focus:outline-none">

                                    <span x-show="!expanded">See All</span>
                                    <span x-show="expanded">Collapse</span>
                                </button>
                            @endif
                        </div>

                        <!-- Media Grid Wrapper -->
                        <div :class="expanded ? 'max-h-[440px] overflow-y-auto pr-1' : ''"
                            class="transition-all duration-300">

                            <div class="grid grid-cols-3 gap-2 rounded-xl">

                                @foreach ($mediaPosts as $index => $post)
                                    <a x-show="expanded || {{ $index }} < 3"
                                        href="{{ asset('storage/' . $post->image) }}" target="_blank"
                                        class="relative aspect-square bg-slate-100 overflow-hidden group" x-transition>

                                        <img src="{{ asset('storage/' . $post->image) }}"
                                            class="w-full h-full object-cover
                                transition-transform duration-300
                                group-hover:scale-105">

                                        <div
                                            class="absolute inset-0 bg-black/0
                                group-hover:bg-black/20 transition">
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="xl:col-span-8 space-y-6">
                    @if ($selectedUser->id == auth()->user()->id)
                        <livewire:user.post.create-post />
                    @endif

                    <div>
                        <h3 class="font-bold text-slate-700 text-lg mb-4 px-1">Recent Activity</h3>
                        <livewire:user.post.calling-post :selectedUser="$selectedUser" />
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
