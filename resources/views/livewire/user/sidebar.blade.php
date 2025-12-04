<!-- LEFT SIDEBAR: fixed on lg+ screens, hidden on smaller -->
<!-- Adjust w-64 to match your layout/spacing -->
<div class="hidden lg:block">
  <div class=" h-[calc(100vh-6rem)]  bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Scrollable content -->
    <div class="h-full flex flex-col">
      <!-- 1. Mini Profile Header -->
      <div class="p-5 border-b border-slate-50 bg-slate-50/30">
        <a href="{{ route('profile') }}" class="flex items-center gap-3 group">
          <div class="relative">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=6366f1&color=fff"
                 class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm group-hover:scale-105 transition-transform">
            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
          </div>
          <div class="overflow-hidden">
            <h4 class="font-bold text-slate-800 text-sm truncate group-hover:text-indigo-600 transition-colors capitalize">
              {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
            </h4>
            {{-- <p class="text-xs text-slate-500 truncate">@{{ strtolower(auth()->user()->first_name) }}</p> --}}
          </div>
        </a>
      </div>

      <!-- 2. Navigation Menu -->
      <nav class="p-3 space-y-1 overflow-y-auto">
        <!-- Feed -->
        <a href="{{ route('home') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
          <i data-feather="home" class="w-4 h-4 {{ request()->routeIs('home') ? 'fill-indigo-200' : '' }}"></i>
          <span>Feed</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('profile') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
          <i data-feather="user" class="w-4 h-4 {{ request()->routeIs('profile') ? 'fill-indigo-200' : '' }}"></i>
          <span>My Profile</span>
        </a>

        <!-- Classmates -->
        <a href="{{ route('find-friends') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('find-friends') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
          <i data-feather="users" class="w-4 h-4 {{ request()->routeIs('find-friends') ? 'fill-indigo-200' : '' }}"></i>
          <span>Classmates</span>
        </a>

        <!-- Assignments -->
        <a href="{{ route('assignment') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('assignment') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
          <i data-feather="file-text" class="w-4 h-4 {{ request()->routeIs('assignment') ? 'fill-indigo-200' : '' }}"></i>
          <span>Assignments</span>
        </a>

        <!-- Events -->
        <a href=""
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('events.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
          <i data-feather="calendar" class="w-4 h-4 {{ request()->routeIs('events.*') ? 'fill-indigo-200' : '' }}"></i>
          <span>Events</span>
        </a>

        <!-- Resources / Library -->
        <a href=""
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('resources.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
          <i data-feather="book" class="w-4 h-4 {{ request()->routeIs('resources.*') ? 'fill-indigo-200' : '' }}"></i>
          <span>Resources</span>
        </a>

        <!-- Notifications (with badge) -->
        <a href=""
           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200">
          <div class="flex items-center gap-3">
            <i data-feather="bell" class="w-4 h-4"></i>
            <span>Notifications</span>
          </div>
          <span class="bg-rose-100 text-rose-600 text-[10px] font-bold px-1.5 py-0.5 rounded-md">2</span>
        </a>

        <!-- Create Post (Trigger) -->
        <button
          class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-all duration-200 text-left">
          <i data-feather="plus-square" class="w-4 h-4"></i>
          <span>Create Post</span>
        </button>

        <!-- Settings -->
        <a href=""
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('settings') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
          <i data-feather="settings" class="w-4 h-4 {{ request()->routeIs('settings') ? 'fill-indigo-200' : '' }}"></i>
          <span>Settings</span>
        </a>
      </nav>

      <div class="border-t border-slate-50 mx-3 my-2"></div>

      <!-- 3. Bottom Actions -->
      <div class="p-3">
        <a href="{{ route('logout') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all duration-200">
          <i data-feather="log-out" class="w-4 h-4"></i>
          <span>Log Out</span>
        </a>
      </div>
    </div>
  </div>
</div>
