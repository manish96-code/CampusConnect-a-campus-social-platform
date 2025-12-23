<div class="max-w-7xl mx-auto px-4 lg:px-8 py-6 min-h-screen">

    <!-- 1. GROUP HEADER -->
    <div class="bg-white rounded-b-3xl rounded-t-2xl shadow-sm border border-slate-100 overflow-hidden mb-6 relative">

        <div class="relative h-52 bg-slate-200 group">

            <img src="{{ $group->cover_pic
                ? asset('storage/' . $group->cover_pic)
                : 'https://images.unsplash.com/photo-1557683316-973673baf926' }}"
                class="w-full h-full object-cover">

            @if ($isAdmin)
                <label
                    class="absolute top-4 right-4 bg-black/60 text-white text-xs px-3 py-1.5 rounded-lg cursor-pointer opacity-0 group-hover:opacity-100 transition">
                    📷 Edit Cover
                    <input type="file" wire:model="cover_pic" class="hidden" accept="image/*">
                </label>
            @endif
        </div>


        <!-- Group Info Bar -->
        <div class="px-6 pb-6 relative">
            <div class="flex flex-col md:flex-row items-start md:items-end -mt-10 gap-5">


                <div class="relative -mt-2 ml-6 group">

                    <img src="{{ $group->profile_pic
                        ? asset('storage/' . $group->profile_pic)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($group->group_name) }}"
                        class="w-28 h-28 rounded-full border-4 border-white object-cover">

                    @if ($this->isAdmin)
                        <label
                            class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-full
                            opacity-0 group-hover:opacity-100 cursor-pointer transition">
                            📷
                            <input type="file" wire:model="profile_pic" class="hidden" accept="image/*">
                        </label>
                    @endif
                </div>


                <!-- Text Info -->
                <div class="flex-1 min-w-0 mb-1">
                    <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">{{ $group->group_name }}</h1>

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
                    <div class="absolute inset-0 bottom-20 overflow-y-auto space-y-4 mb-4" x-data="{ scroll() { this.$el.scrollTop = this.$el.scrollHeight } }"
                        x-init="scroll()" x-on:post-created.window="$nextTick(() => scroll())">
                        <livewire:user.group.calling-group-post :group="$group"
                            :wire:key="'group-chat-messages-'.$group->id" />
                    </div>


                    {{-- FIXED INPUT AT BOTTOM --}}
                    <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-slate-200 p-4">
                        <livewire:user.group.create-group-post :group="$group"
                            :wire:key="'group-chat-input-'.$group->id" />
                    </div>

                </div>
            @endif


            @if ($activeTab === 'about')
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 space-y-6">

                    {{-- HEADER --}}
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">
                            {{ $group->group_name }}
                        </h3>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="bg-slate-50 rounded-xl p-4 text-sm text-slate-700 leading-relaxed">
                        {{ $group->description ?? 'No description available for this group.' }}
                    </div>

                    {{-- DETAILS GRID --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                        {{-- CREATED BY --}}
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                Created By
                            </span>
                            <span class="font-semibold text-slate-800 capitalize">
                                {{ $group->creator->first_name }} {{ $group->creator->last_name }}
                            </span>
                        </div>

                        {{-- PRIVACY --}}
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                Privacy
                            </span>
                            <span class="font-semibold text-slate-800 capitalize">
                                {{ $group->group_type }}
                            </span>
                        </div>

                        {{-- CREATED DATE --}}
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                Created On
                            </span>
                            <span class="font-semibold text-slate-800">
                                {{ $group->created_at->format('d M Y') }}
                            </span>
                        </div>

                        {{-- MEMBERS COUNT --}}
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                                Members
                            </span>
                            <span class="font-semibold text-slate-800">
                                {{ $group->approvedMembers->count() }} Members
                            </span>
                        </div>

                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="pt-6 border-t border-slate-100 flex flex-wrap gap-3">

                        {{-- VIEW CHAT --}}
                        <button wire:click="setTab('discussion')"
                            class="px-4 py-2 rounded-xl text-sm font-bold bg-indigo-600 text-white hover:bg-indigo-700 transition">
                            💬 View Chat
                        </button>

                        {{-- VIEW MEMBERS --}}
                        @if ($isAdmin)
                            <button wire:click="setTab('members')"
                                class="px-4 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                👥 View Members
                            </button>
                        @endif

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

            {{-- <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-slate-800 text-sm">Recent Media</h3>
                    <a href="#" class="text-xs text-indigo-600 font-bold hover:underline">See all</a>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div class="aspect-square bg-slate-100 rounded-lg"></div>
                    <div class="aspect-square bg-slate-100 rounded-lg"></div>
                    <div class="aspect-square bg-slate-100 rounded-lg"></div>
                </div>
            </div> --}}

            @if (auth()->check() &&
                    $group->members()->where('users.id', auth()->id())->wherePivot('status', 'approved')->exists())

                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100" x-data="{ showAll: false }">

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-slate-800 text-sm">Recent Media</h3>

                        @if ($media->count() > 3)
                            <button @click="showAll = !showAll"
                                class="text-xs text-indigo-600 font-bold hover:underline">
                                <span x-show="!showAll">See all</span>
                                <span x-show="showAll">Show less</span>
                            </button>
                        @endif
                    </div>

                    {{-- MEDIA GRID --}}
                    @if ($media->count())
                        <div class="grid grid-cols-3 gap-2 transition-all duration-300"
                            :class="showAll ? 'max-h-64 overflow-y-auto pr-1' : ''">
                            @foreach ($media as $index => $item)
                                <template x-if="showAll || {{ $index }} < 3">
                                    <a href="{{ asset('storage/' . $item->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $item->image) }}"
                                            class="aspect-square w-full rounded-lg object-cover hover:opacity-90 transition">
                                    </a>
                                </template>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500 text-center py-6">
                            No media shared yet
                        </p>
                    @endif

                </div>

            @endif



        </div>

    </div>

</div>
