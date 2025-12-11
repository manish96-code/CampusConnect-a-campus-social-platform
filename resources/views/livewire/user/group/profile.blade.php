<div class="max-w-7xl mx-auto px-4 lg:px-8 py-6 min-h-screen">

    <!-- 1. GROUP HEADER -->
    <div class="bg-white rounded-b-3xl rounded-t-2xl shadow-sm border border-slate-100 overflow-hidden mb-6 relative">

        <!-- Cover Photo -->
        <div class="h-48 md:h-80 w-full bg-slate-200 relative group/cover">
            @if ($group->cover_pic)
                <img src="{{ asset('storage/' . $group->cover_pic) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400"></div>
            @endif

            <!-- Admin Edit Button (Optional) -->
            @if ($group->user_id === auth()->id())
                <button
                    class="absolute top-4 right-4 bg-black/40 hover:bg-black/60 text-white px-3 py-1.5 rounded-lg text-xs font-bold backdrop-blur-md transition opacity-0 group-hover/cover:opacity-100">
                    Edit Cover
                </button>
            @endif
        </div>

        <!-- Group Info Bar -->
        <div class="px-6 pb-6 relative">
            <div class="flex flex-col md:flex-row items-start md:items-end -mt-10 gap-5">

                <!-- Group Icon -->
                <div class="relative flex-shrink-0">
                    <div
                        class="h-28 w-28 rounded-2xl border-4 border-white bg-white shadow-md overflow-hidden flex items-center justify-center">
                        @if ($group->profile_pic)
                            <img src="{{ asset('storage/' . $group->profile_pic) }}" class="w-full h-full object-cover">
                        @else
                            <span
                                class="text-3xl font-bold text-indigo-500 uppercase">{{ substr($group->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                <!-- Text Info -->
                <div class="flex-1 min-w-0 mb-1">
                    <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">{{ $group->name }}</h1>

                    <div class="flex items-center gap-4 text-sm text-slate-500 mt-1 font-medium">
                        <span class="flex items-center gap-1">
                            @if ($group->group_type === 'private')
                                <i data-feather="lock" class="w-3 h-3"></i> Private Group
                            @else
                                <i data-feather="globe" class="w-3 h-3"></i> Public Group
                            @endif
                        </span>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <span>{{ $group->members->count() }} Members</span>
                    </div>
                </div>



                <div>
                    <livewire:user.group.group-button :group="$group" />
                </div>

            </div>


            <!-- Navigation Tabs -->
            <div class="mt-8 border-t border-slate-100 pt-1 flex gap-6 overflow-x-auto no-scrollbar">
                @foreach (['discussion' => 'Discussion', 'about' => 'About', 'members' => 'Members', 'events' => 'Events', 'media' => 'Media'] as $key => $label)
                    <button wire:click="setTab('{{ $key }}')"
                        class="pb-3 text-sm font-bold border-b-2 transition-colors whitespace-nowrap {{ $activeTab === $key ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 2. CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- LEFT COLUMN (Main Feed) -->
        <div class="lg:col-span-8 space-y-6">

            @if ($activeTab === 'discussion')
                <!-- Create Post (If member) -->
                @if ($group->members->contains(auth()->id()))
                    <div
                        class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 flex gap-4 items-center cursor-text hover:border-indigo-200 transition">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=6366f1&color=fff"
                            class="w-10 h-10 rounded-full border border-slate-100">
                        <div
                            class="flex-1 bg-slate-50 hover:bg-slate-100 rounded-xl px-4 py-2.5 text-sm text-slate-500 transition">
                            Write something to the group...
                        </div>
                        <button class="text-slate-400 hover:text-indigo-600 transition"><i data-feather="image"
                                class="w-5 h-5"></i></button>
                    </div>
                @endif

                <!-- Feed Content -->
                <div class="bg-white rounded-2xl p-8 border border-slate-100 text-center py-16">
                    <div class="inline-flex p-4 rounded-full bg-slate-50 mb-3">
                        <i data-feather="message-square" class="w-6 h-6 text-slate-300"></i>
                    </div>
                    <p class="text-slate-500 text-sm">No recent posts. Start the conversation!</p>
                </div>
            @endif

            @if ($activeTab === 'about')
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 text-lg mb-4">About this group</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        {{ $group->description ?? 'No description available for this group.' }}
                    </p>

                    <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-4">
                        <div>
                            <span
                                class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Created</span>
                            <span
                                class="text-sm font-semibold text-slate-800">{{ $group->created_at->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span
                                class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Privacy</span>
                            <span
                                class="text-sm font-semibold text-slate-800 capitalize">{{ $group->group_type }}</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN (Widgets) -->
        <div class="hidden lg:block lg:col-span-4 space-y-6">

            <!-- About Widget -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm mb-3">About</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-3">
                    {{ $group->description ?? 'Welcome to our community!' }}
                </p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-slate-600 text-xs font-medium">
                        <i data-feather="clock" class="w-4 h-4"></i>
                        <span>Created {{ $group->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-600 text-xs font-medium">
                        <i data-feather="tag" class="w-4 h-4"></i>
                        <span class="capitalize">{{ $group->group_type }} Group</span>
                    </div>
                </div>
            </div>

            <!-- Admins Widget -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800 text-sm">Admins</h3>
                </div>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ $group->creator->first_name ?? 'Admin' }}&background=random"
                        class="w-10 h-10 rounded-xl">
                    <div>
                        <p class="text-sm font-bold text-slate-700">{{ $group->creator->first_name ?? 'Unknown' }}
                            {{ $group->creator->last_name ?? '' }}</p>
                        <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider">Owner</p>
                    </div>
                </div>
            </div>

            <!-- Recent Media Widget -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-slate-800 text-sm">Recent Media</h3>
                    <a href="#" class="text-xs text-indigo-600 font-bold hover:underline">See all</a>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div class="aspect-square bg-slate-100 rounded-lg"></div>
                    <div class="aspect-square bg-slate-100 rounded-lg"></div>
                    <div class="aspect-square bg-slate-100 rounded-lg"></div>
                </div>
            </div>

        </div>

    </div>

    <!-- Init Icons -->
    <script>
        document.addEventListener('livewire:initialized', () => feather.replace());
        document.addEventListener('livewire:navigated', () => feather.replace());
    </script>
</div>
