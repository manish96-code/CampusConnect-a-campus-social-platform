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
                                <x-heroicon-o-lock-closed class="w-3 h-3" /> Private Group
                            @else
                                <x-heroicon-o-globe-alt class="w-3 h-3" /> Public Group
                            @endif
                        </span>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <p>{{ $group->members->where('pivot.status', 'approved')->count() }} Members</p>
                    </div>
                </div>

                <div class="w-full md:w-auto">
                    <livewire:user.group.group-button :group="$group" :wire:key="'group-btn-'.$group->id" />
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

        <!-- LEFT COLUMN -->
        <div class="lg:col-span-8 space-y-6">

           @if ($activeTab === 'discussion')

<div class="relative h-[calc(100vh-160px)] bg-slate-50 rounded-2xl overflow-hidden">

    {{-- CHAT MESSAGES (scrollable) --}}
    <div class="absolute inset-0 bottom-20 overflow-y-auto px-4 py-4 space-y-4">
        <livewire:user.group.calling-group-post
            :group="$group"
            :wire:key="'group-chat-messages-'.$group->id"
        />
    </div>

    {{-- FIXED INPUT AT BOTTOM --}}
    <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-4">
        <livewire:user.group.create-group-post
            :group="$group"
            :wire:key="'group-chat-input-'.$group->id"
        />
    </div>

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

            @if ($activeTab === 'members')
                <livewire:user.group.group-members :group="$group" :wire:key="'group-members-'.$group->id" />
            @endif

        </div>

        <!-- RIGHT COLUMN -->
        <div class="hidden lg:block lg:col-span-4 space-y-6">

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm mb-3">About</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4 line-clamp-3">
                    {{ $group->description ?? 'Welcome to our community!' }}
                </p>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-slate-600 text-xs font-medium">
                        <x-heroicon-o-clock class="w-4 h-4" />
                        <span>Created {{ $group->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-600 text-xs font-medium">
                        <x-heroicon-o-tag class="w-4 h-4" />
                        <span class="capitalize">{{ $group->group_type }} Group</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-slate-800 text-sm">Admins</h3>
                </div>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ $group->creator->first_name ?? 'Admin' }}&background=random"
                        class="w-10 h-10 rounded-xl">
                    <div>
                        <a href="{{ route('profile', $group->creator->id) }}">
                            <p class="text-sm font-bold text-slate-700 capitalize">
                                {{ $group->creator->first_name ?? 'Unknown' }} {{ $group->creator->last_name ?? '' }}
                            </p>
                            <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider">Owner</p>
                        </a>
                    </div>
                </div>
            </div>

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

</div>
