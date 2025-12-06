<div class="hidden lg:flex flex-col fixed left-0 top-16 h-[calc(100vh-4rem)] w-70 bg-white border-r border-slate-200 z-40">
    
    <!-- 1. Mini Profile Header (Fixed at Top) -->
    <div class="p-5 border-b border-slate-50 bg-slate-50/50 flex-shrink-0">
        <a href="{{ route('profile') }}" class="flex items-center gap-3 group">
            <div class="relative flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=6366f1&color=fff" 
                     class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm group-hover:scale-105 transition-transform">
                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
            </div>
            <div class="overflow-hidden">
                <h4 class="font-bold text-slate-800 text-sm truncate group-hover:text-indigo-600 transition-colors">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </h4>
                <p class="text-xs text-slate-500 truncate">@ {{ strtolower(auth()->user()->first_name) }}</p>
            </div>
        </a>
    </div>

    <!-- 2. Navigation Menu (Scrollable Middle) -->
    <nav class="flex-1 overflow-y-auto no-scrollbar p-3 space-y-1">
        
        <!-- MAIN LINKS -->
        <a href="{{ route('home') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('home') 
              ? 'bg-indigo-50 text-indigo-600' 
              : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="home" class="w-4 h-4"></i>
            <span>Campus Feed</span>
        </a>

        <a href="{{ route('profile') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('profile') 
              ? 'bg-indigo-50 text-indigo-600' 
              : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="user" class="w-4 h-4"></i>
            <span>My Profile</span>
        </a>

        <a href="{{ route('find-friends') }}" 
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

        <a href="{{ route('assignment') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
         {{ request()->routeIs('assignment')
         ? 'bg-indigo-50 text-indigo-600'
         : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <div class="flex items-center gap-3">
                <i data-feather="clipboard" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
                <span>Assignments</span>
            </div>
            <!-- Notification Dot -->
            <span class="bg-rose-100 text-rose-600 text-[10px] font-bold px-1.5 py-0.5 rounded-md">2</span>
        </a>

        <!-- NEW LINK: Library -->
        <a href="{{ route('library') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('library') 
              ? 'bg-indigo-50 text-indigo-600' 
              : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="book" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Library</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="book-open" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Resources</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="award" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Grades</span>
        </a>

        <!-- CAMPUS LIFE SECTION -->
        <div class="pt-4 pb-2 px-3">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Campus Life</p>
        </div>

        <a href="{{route('events')}}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('events') 
              ? 'bg-indigo-50 text-indigo-600' 
              : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
            <i data-feather="calendar" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Events</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="flag" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Clubs & Groups</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="shopping-bag" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Marketplace</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 group">
            <i data-feather="briefcase" class="w-4 h-4 group-hover:stroke-indigo-600"></i>
            <span>Placements</span>
        </a>

        <!-- Divider -->
        <div class="border-t border-slate-50 my-2"></div>

        <!-- SETTINGS -->
        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200">
            <i data-feather="settings" class="w-4 h-4"></i>
            <span>Settings</span>
        </a>

    </nav>

    <!-- 3. Bottom Footer Actions (Fixed at Bottom) -->
    <div class="p-3 border-t border-slate-100 flex-shrink-0 bg-white">
        <a href="{{ route('logout') }}" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all duration-200 group">
            <i data-feather="log-out" class="w-4 h-4 group-hover:stroke-rose-600"></i>
            <span>Log Out</span>
        </a>
    </div>

</div>