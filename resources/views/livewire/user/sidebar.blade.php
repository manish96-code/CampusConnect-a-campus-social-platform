<div
    class="hidden lg:flex flex-col fixed left-0 top-16 h-[calc(100vh-4rem)] w-72 bg-white border-r border-slate-200 z-40">

    <!-- Navigation Menu (Scrollable Middle) -->
    <nav class="flex-1 overflow-y-auto no-scrollbar p-3 space-y-1">

        <!-- MAIN LINKS -->
        <a wire:navigate href="{{ route('home') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('home')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-home class="w-4 h-4" />
            <span>Campus Feed</span>
        </a>

        <a wire:navigate href="{{ route('profile') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('profile')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-user class="w-4 h-4" />
            <span>My Profile</span>
        </a>

        <a wire:navigate href="{{ route('find-friends') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('find-friends')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-users class="w-4 h-4" />
            <span>Classmates</span>
        </a>

        <!-- ACADEMICS SECTION -->
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Academics</p>
        </div>

        <a wire:navigate href="{{ route('courses') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
            {{ request()->routeIs('courses')
                ? 'bg-indigo-50 text-indigo-600'
                : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-squares-2x2 class="w-4 h-4" />
            <span>Courses</span>
        </a>

        <a wire:navigate href="{{ route('assignment') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
         {{ request()->routeIs('assignment')
             ? 'bg-indigo-50 text-indigo-600'
             : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <div class="flex items-center gap-3">
                <x-heroicon-o-clipboard-document class="w-4 h-4 group-hover:text-indigo-600" />
                <span>Assignments</span>
            </div>
        </a>

        <a wire:navigate href="{{ route('library') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('library')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-book-open class="w-4 h-4 group-hover:text-indigo-600" />
            <span>Library</span>
        </a>

        <a wire:navigate href="{{ route('quiz') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
            {{ request()->routeIs('quiz')
                ? 'bg-indigo-50 text-indigo-600'
                : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-question-mark-circle class="w-4 h-4" />
            <span>Quiz</span>
        </a>

        {{-- <a wire:navigate href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <x-heroicon-o-trophy class="w-4 h-4 group-hover:text-indigo-600" />
            <span>Grades</span>
        </a> --}}

        <!-- CAMPUS LIFE SECTION -->
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Campus Life</p>
        </div>

        <a wire:navigate href="{{ route('events') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('events')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-calendar-days class="w-4 h-4 group-hover:text-indigo-600" />
            <span>Events</span>
        </a>

        <a wire:navigate href="{{ route('group') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group
           {{ request()->routeIs('group') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-squares-plus class="w-4 h-4 group-hover:text-indigo-600" />
            <span>Groups</span>
        </a>

        {{-- <a wire:navigate href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <x-heroicon-o-shopping-bag class="w-4 h-4 group-hover:text-indigo-600" />
            <span>Marketplace</span>
        </a> --}}

        {{-- <a wire:navigate href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <x-heroicon-o-briefcase class="w-4 h-4 group-hover:text-indigo-600" />
            <span>Placements</span>
        </a> --}}


        <!-- SHORTCUT -->
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                My Groups
            </p>
        </div>

        @forelse(auth()->user()->groups->take(3) as $group)
            <a wire:navigate href="{{ route('group-profile', $group->id) }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-semibold
        {{ request()->routeIs('group-profile') && request('id') == $group->id
            ? 'bg-indigo-50 text-indigo-600'
            : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">

                <!-- Avatar -->
                @if ($group->profile_pic)
                    <img src="{{ asset('storage/' . $group->profile_pic) }}" class="w-6 h-6 rounded-full object-cover">
                @else
                    <div
                        class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600
                        flex items-center justify-center text-[10px] font-bold">
                        {{ strtoupper(substr($group->group_name, 0, 1)) }}
                    </div>
                @endif

                <span class="truncate">{{ $group->group_name }}</span>
            </a>
        @empty
            <p class="px-3 py-2 text-xs text-slate-400">
                No groups joined
            </p>
        @endforelse

        <!-- Divider -->
        <div class="border-t border-slate-100 my-2"></div>

        <!-- SETTINGS -->
        <a wire:navigate href="{{ route('settings') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group
           {{ request()->routeIs('settings') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <x-heroicon-o-cog-6-tooth class="w-4 h-4" />
            <span>Settings</span>
        </a>

    </nav>

    <!-- Bottom Footer Actions -->
    <div class="p-3 border-t border-slate-100 flex-shrink-0 bg-white">
        <a wire:navigate href="{{ route('logout') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all duration-200 group">
            <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 group-hover:text-rose-600" />
            <span>Log Out</span>
        </a>
    </div>

</div>
