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
            <i data-feather="home" class="w-4 h-4"></i>
            <span>Campus Feed</span>
        </a>

        <a wire:navigate href="{{ route('profile') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('profile')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="user" class="w-4 h-4"></i>
            <span>My Profile</span>
        </a>

        <a wire:navigate href="{{ route('find-friends') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('find-friends')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="users" class="w-4 h-4"></i>
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
            <i data-feather="layers" class="w-4 h-4"></i>
            <span>Courses</span>
        </a>


        <a wire:navigate href="{{ route('assignment') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
         {{ request()->routeIs('assignment')
             ? 'bg-indigo-50 text-indigo-600'
             : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <div class="flex items-center gap-3">
                <i data-feather="clipboard" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
                <span>Assignments</span>
            </div>
            <!-- Notification Dot -->
            {{-- <span class="bg-rose-100 text-rose-600 text-[10px] font-bold px-1.5 py-0.5 rounded-md">2</span> --}}
        </a>

        <a wire:navigate href="{{ route('library') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('library')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="book" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Library</span>
        </a>

        <a wire:navigate href="{{ route('quiz') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
            {{ request()->routeIs('quiz')
                ? 'bg-indigo-50 text-indigo-600'
                : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">

            <i data-feather="help-circle" class="w-4 h-4"></i>
            <span>Quiz</span>
        </a>


        <a wire:navigate href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="award" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Grades</span>
        </a>

        <!-- CAMPUS LIFE SECTION -->
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Campus Life</p>
        </div>

        <a wire:navigate href="{{ route('events') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('events')
               ? 'bg-indigo-50 text-indigo-600'
               : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="calendar" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Events</span>
        </a>

        <a wire:navigate href="{{ route('group') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group
           {{ request()->routeIs('group') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="grid" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Groups</span>
        </a>

        <a wire:navigate href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="shopping-bag" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Marketplace</span>
        </a>

        <a wire:navigate href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="briefcase" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Placements</span>
        </a>

        <!-- Divider -->
        <div class="border-t border-slate-50 my-2"></div>

        <!-- SETTINGS -->
        <a wire:navigate href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200">
            <i data-feather="settings" class="w-4 h-4"></i>
            <span>Settings</span>
        </a>

    </nav>

    <!-- Bottom Footer Actions (Fixed at Bottom) -->
    <div class="p-3 border-t border-slate-100 flex-shrink-0 bg-white">
        <a wire:navigate href="{{ route('logout') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all duration-200 group">
            <i data-feather="log-out" class="w-4 h-4 group-hover:stroke-rose-600"></i>
            <span>Log Out</span>
        </a>
    </div>

</div>
