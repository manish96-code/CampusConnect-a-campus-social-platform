<div class="space-y-6">

    <!-- 1. Header & Filters -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Discover Groups</h2>
            <p class="text-sm text-slate-500">Find your community on campus.</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex p-1 bg-white border border-slate-200 rounded-xl shadow-sm">
            <button wire:click="$set('filter', 'all')"
                class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $filter === 'all' ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">
                All
            </button>
            <button wire:click="$set('filter', 'public')"
                class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $filter === 'public' ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">
                Public
            </button>
            <button wire:click="$set('filter', 'my_groups')"
                class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all {{ $filter === 'my_groups' ? 'bg-indigo-50 text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">
                My Groups
            </button>
        </div>
    </div>

    <!-- 2. Groups Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($groups as $group)
            <div
                class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-100 transition-all duration-300 flex flex-col overflow-hidden relative">

                <!-- A. Cover Image Banner -->
                <div class="h-28 w-full bg-slate-100 relative overflow-hidden">
                    @if ($group->cover_pic)
                        <img src="{{ asset('storage/' . $group->cover_pic) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-r from-indigo-400 to-purple-400"></div>
                    @endif

                    <!-- Privacy Badge -->
                    <div class="absolute top-3 right-3">
                        @if ($group->group_type === 'private')
                            <span
                                class="bg-black/50 backdrop-blur-md text-white text-[10px] font-bold px-2 py-1 rounded-lg flex items-center gap-1">
                                <x-heroicon-o-lock-closed class="w-3 h-3" /> Private
                            </span>
                        @else
                            <span
                                class="bg-white/90 backdrop-blur-md text-indigo-600 text-[10px] font-bold px-2 py-1 rounded-lg flex items-center gap-1 shadow-sm">
                                <x-heroicon-o-globe-alt class="w-3 h-3" /> Public
                            </span>
                        @endif
                    </div>
                </div>

                <!-- B. Profile Icon (Overlapping) -->
                <div class="px-5 relative">
                    <div
                        class="absolute -top-8 left-5 w-16 h-16 rounded-2xl border-4 border-white bg-white shadow-md overflow-hidden">
                        @if ($group->profile_pic)
                            <img src="{{ asset('storage/' . $group->profile_pic) }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-slate-50 flex items-center justify-center text-indigo-500 font-bold text-xl uppercase">
                                {{ substr($group->group_name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- Option Menu -->
                    {{-- <div class="flex justify-end pt-3">
                         @if ($group->created_by === auth()->id())
                            <button class="text-slate-400 hover:text-indigo-600 transition">
                                <x-heroicon-o-ellipsis-horizontal class="w-5 h-5" />
                            </button>
                         @endif
                    </div> --}}
                </div>

                <!-- C. Content -->
                <div class="px-5 pt-9 pb-5 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors">
                        {{ $group->group_name }}
                    </h3>

                    <p class="text-xs text-slate-500 line-clamp-2 mb-4 flex-1">
                        {{ $group->description ?? 'No description provided.' }}
                    </p>

                    <!-- Stats Row -->
                    <div class="flex items-center justify-between border-t border-slate-50 pt-4 mt-auto">
                        {{-- <div class="flex -space-x-2">
                            <img class="w-6 h-6 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=A&background=random" alt="">
                            <img class="w-6 h-6 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=B&background=random" alt="">
                            <img class="w-6 h-6 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=C&background=random" alt="">
                            <div class="w-6 h-6 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-[8px] font-bold text-slate-500">+12</div>
                        </div> --}}


                        <div class="flex -space-x-2 items-center">

                            {{-- SHOW UP TO 3 MEMBERS --}}
                            @foreach ($group->members->take(3) as $member)
                                <img class="w-6 h-6 rounded-full border-2 border-white object-cover"
                                    src="{{ $member->dp
                                        ? asset('storage/images/dp/' . $member->dp)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($member->first_name) }}"
                                    alt="{{ $member->first_name }}">
                            @endforeach

                            {{-- REMAINING COUNT --}}
                            @if ($group->members_count > 3)
                                <div
                                    class="w-6 h-6 rounded-full border-2 border-white bg-slate-100
                                        flex items-center justify-center text-[8px] font-bold text-slate-500">
                                    +{{ $group->members_count - 3 }}
                                </div>
                            @endif

                        </div>


                        <!-- Action Button -->
                        @if ($group->created_by === auth()->id())
                            <a wire:navigate href="{{ route('group-profile', ['id' => $group->id]) }}"
                                class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg hover:bg-slate-200 transition">
                                Manage
                            </a>
                        @else
                            <a wire:navigate href="{{ route('group-profile', ['id' => $group->id]) }}"
                                class="text-xs font-bold text-white bg-indigo-600 px-4 py-1.5 rounded-lg hover:bg-indigo-700 shadow-md shadow-indigo-200 transition">
                                View
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-users class="w-8 h-8 text-indigo-400" />
                </div>
                <h3 class="text-lg font-bold text-slate-700">No Groups Found</h3>
                <p class="text-slate-500 text-sm max-w-xs mx-auto mt-1">Be the first to create a community on campus!
                </p>
            </div>
        @endforelse
    </div>

</div>
