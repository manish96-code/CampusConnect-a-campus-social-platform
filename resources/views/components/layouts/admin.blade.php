<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard - Campus Connect' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @livewireStyles
</head>

<body class="bg-slate-50 text-slate-900 antialiased font-sans">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white fixed h-full z-50">
            <div class="p-6">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <x-heroicon-o-academic-cap class="w-5 h-5" />
                    </div>
                    <span class="text-xl font-bold tracking-tight">Admin<span
                            class="text-indigo-400">Panel</span></span>
                </a>
            </div>

            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl font-semibold transition-all">
                    <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                    Dashboard
                </a>
                <a href="{{ route('admin.courses') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/courses') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl font-semibold transition-all">
                    <x-heroicon-o-academic-cap class="w-5 h-5" />
                    Courses
                </a>
                <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/users') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} rounded-xl font-semibold transition-all">
                    <x-heroicon-o-users class="w-5 h-5" />
                    Users
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <x-heroicon-o-document-text class="w-5 h-5" />
                    Posts
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <x-heroicon-o-calendar-days class="w-5 h-5" />
                    Events
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
                    Settings
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-4">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-800 hover:text-white rounded-xl transition-all">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-5 h-5" />
                    Back to App
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- Top Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 sticky top-0 z-40">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">
                        <span>Main</span>
                        <x-heroicon-m-chevron-right class="w-3 h-3" />
                        <span class="text-indigo-500">
                            @if(request()->routeIs('admin.dashboard')) Dashboard @elseif(request()->routeIs('admin.users')) Users @elseif(request()->routeIs('admin.courses')) Courses @else Portal @endif
                        </span>
                    </div>
                    <h2 class="text-xl font-black text-slate-800 tracking-tight leading-none">
                        @if(request()->routeIs('admin.dashboard')) Overview @elseif(request()->routeIs('admin.users')) User Directory @elseif(request()->routeIs('admin.courses')) Course Catalog @else Admin Panel @endif
                    </h2>
                </div>
                
                <div class="flex items-center gap-6">
                    <!-- Global Search Mock -->
                    <div class="hidden md:flex relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors" />
                        </div>
                        <input type="text" class="w-64 bg-slate-100/50 border-none rounded-xl py-2 pl-9 pr-4 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all outline-none" placeholder="Search anything...">
                    </div>

                    <div class="flex items-center gap-3 pr-4 border-r border-slate-100">
                        <button class="relative p-2.5 bg-slate-100 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-all group">
                            <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                            <span class="absolute top-2 right-2 w-2 h-2 bg-indigo-500 rounded-full border-2 border-white"></span>
                        </button>
                        <button class="relative p-2.5 bg-slate-100 text-slate-500 hover:bg-rose-50 hover:text-rose-600 rounded-xl transition-all">
                            <x-heroicon-o-bell class="w-5 h-5" />
                            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                        </button>
                    </div>

                    <div class="flex items-center gap-3 group cursor-pointer">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-extrabold text-slate-800 leading-none mb-0.5 capitalize">{{ auth()->user()->first_name }}</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">System Administrator</p>
                        </div>
                        <div class="h-11 w-11 bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-2xl shadow-lg shadow-indigo-200 border-2 border-white flex items-center justify-center text-white font-black text-sm">
                            @if(auth()->user()->dp)
                                <img src="{{ auth()->user()->dp }}" class="w-full h-full rounded-2xl object-cover">
                            @else
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <div class="p-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>

</html>