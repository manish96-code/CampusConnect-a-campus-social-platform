<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    @livewireStyles
    </head>

    <body class="bg-[#F4F7FE] text-slate-800 antialiased min-h-screen relative pb-16 md:pb-0">

        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-200/20 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-200/20 rounded-full blur-[100px]"></div>
        </div>

        <header
            class="fixed top-0 inset-x-0 h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/60 z-50 px-4 lg:px-8 transition-all duration-300">
            <div class="px-10 mx-auto h-full flex items-center justify-between">

                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z" />
                            <path d="M6 12v5c3 3 9 3 12 0v-5" />
                        </svg>
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <h1 class="text-lg font-bold text-slate-800 tracking-tight">Campus Connect</h1>
                        <p class="text-[10px] text-indigo-500 font-semibold uppercase tracking-wider">Student Network
                        </p>
                    </div>
                </a>

                <div class="hidden md:block flex-1 max-w-md mx-8">
                    <form action="{{ route('find-friends') }}" method="get" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i data-feather="search"
                                class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="text" name="query" placeholder="Search classmates, clubs..."
                            class="w-full bg-slate-100/80 border border-transparent focus:bg-white focus:border-indigo-200 focus:ring-4 focus:ring-indigo-500/10 rounded-full py-2 pl-10 pr-4 text-sm outline-none transition-all duration-200 placeholder-slate-400">
                    </form>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">

                    <button class="md:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-full transition-colors">
                        <i data-feather="search" class="w-5 h-5"></i>
                    </button>

                    <!-- Notifications -->
                    <button
                        class="relative p-2 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-full transition-all">
                        <i data-feather="bell" class="w-5 h-5"></i>
                        <!-- Notification Dot -->
                        <span
                            class="absolute top-2 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>

                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-full hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all">

                            <img src="@if (auth()->user()->dp) {{ asset('storage/images/dp/' . auth()->user()->dp) }} @else https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=6366f1&color=fff @endif"
                                alt="Avatar"
                                class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm">

                            <div class="hidden lg:block text-left">
                                <p class="text-xs font-bold text-slate-700 leading-none capitalize">
                                    {{ auth()->user()->first_name }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">Student</p>
                            </div>

                            <i data-feather="chevron-down" class="w-3 h-3 text-slate-400 hidden lg:block"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 origin-top-right">

                            <div class="px-4 py-2 border-b border-slate-50 mb-1">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->first_name }}
                                    {{ auth()->user()->last_name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('profile') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <i data-feather="user" class="w-4 h-4"></i> My Profile
                            </a>
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                <i data-feather="settings" class="w-4 h-4"></i> Settings
                            </a>

                            <div class="border-t border-slate-50 my-1"></div>


                            <a href="{{ route('logout') }}"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                <i data-feather="log-out" class="w-4 h-4"></i> Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="relative z-0 pt-12">
            <div class=" px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                    <aside class="hidden lg:block lg:col-span-2">
                        <div class="sticky top-24">
                            <livewire:user.sidebar />
                        </div>
                    </aside>

                    <section class="col-span-1 lg:col-span-12 lg:ml-72">
                        {{ $slot }}
                    </section>


                </div>
            </div>
        </main>

        <nav
            class="md:hidden fixed bottom-0 inset-x-0 bg-white/90 backdrop-blur-lg border-t border-slate-200 z-50 pb-safe">
            <div class="flex justify-between items-center px-6 h-16">
                <a href="{{ route('home') }}"
                    class="flex flex-col items-center gap-1 {{ request()->routeIs('home') ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
                    <i data-feather="home"
                        class="w-6 h-6 {{ request()->routeIs('home') ? 'fill-indigo-100' : '' }}"></i>
                </a>

                <a href="{{ route('find-friends') }}"
                    class="flex flex-col items-center gap-1 {{ request()->routeIs('find-friends') ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
                    <i data-feather="users"
                        class="w-6 h-6 {{ request()->routeIs('find-friends') ? 'fill-indigo-100' : '' }}"></i>
                </a>

                <a href="#"
                    class="relative -top-5 bg-gradient-to-br from-indigo-600 to-purple-600 p-3.5 rounded-2xl shadow-lg shadow-indigo-500/30 text-white transform active:scale-95 transition-transform">
                    <i data-feather="plus" class="w-6 h-6"></i>
                </a>

                <a href="#" class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-600">
                    <i data-feather="message-circle" class="w-6 h-6"></i>
                </a>

                <a href="{{ route('profile') }}"
                    class="flex flex-col items-center gap-1 {{ request()->routeIs('profile') ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600' }}">
                    <i data-feather="user"
                        class="w-6 h-6 {{ request()->routeIs('profile') ? 'fill-indigo-100' : '' }}"></i>
                </a>
            </div>
        </nav>

        {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

        @livewireScripts

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                feather.replace();
            });
        </script>


    </body>

</html>
