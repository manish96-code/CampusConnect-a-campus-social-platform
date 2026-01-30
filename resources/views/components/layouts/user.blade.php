<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    {{--
    <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        .section-lock {
            height: calc(100vh - 5rem);
            overflow: hidden !important;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-[#F4F7FE] text-slate-800 antialiased min-h-screen relative pb-16 md:pb-0">

    <!-- Background blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-200/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-200/20 rounded-full blur-[100px]"></div>
    </div>

    <!-- HEADER -->
    <header
        class="fixed top-0 inset-x-0 h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/60 z-50 px-4 lg:px-8">
        <div class="px-10 mx-auto h-full flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div
                    class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                    <x-heroicon-o-academic-cap class="w-5 h-5" />
                </div>
                <div class="hidden sm:block leading-tight">
                    <h1 class="text-lg font-bold text-slate-800">Campus Connect</h1>
                    <p class="text-[10px] text-indigo-500 font-semibold uppercase tracking-wider">
                        Student Network
                    </p>
                </div>
            </a>

            <!-- Search -->
            <div class="hidden md:block flex-1 max-w-md mx-8">
                <form action="{{ route('find-friends') }}" method="get" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center">
                        <x-heroicon-o-magnifying-glass class="w-4 h-4 text-slate-400" />
                    </div>
                    <input type="text" name="query" placeholder="Search classmates, clubs..."
                        class="w-full bg-slate-100/80 rounded-full py-2 pl-10 pr-4 text-sm outline-none">
                </form>
            </div>

            <!-- Right icons -->
            <div class="flex items-center gap-2 sm:gap-4">

                <!-- Mobile search -->
                <button class="md:hidden p-2 text-slate-500 rounded-full">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                </button>

                <!-- Notifications -->
                <livewire:user.notification-dropdown />

                <div class="relative" x-data="{ open: false }">

                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-full hover:bg-slate-50 transition-colors focus:outline-none">

                        <img src="{{ auth()->user()->dp ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->first_name . ' ' . auth()->user()->last_name) . '&background=6366f1&color=fff' }}"
                            alt="{{ auth()->user()->first_name }}"
                            class="w-8 h-8 rounded-full border-2 border-white shadow-sm object-cover">

                        <div class="hidden lg:block text-left">
                            <p class="text-xs font-bold text-slate-700 capitalize">
                                {{ auth()->user()->first_name }}
                            </p>
                            <p class="text-[10px] text-slate-400">Student</p>
                        </div>

                        <x-heroicon-o-chevron-down
                            class="w-3 h-3 text-slate-400 hidden lg:block transition-transform duration-200"
                            ::class="open ? 'rotate-180' : ''" />
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-[60]"
                        x-cloak>

                        <a href="{{ route('profile') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                            <x-heroicon-o-user class="w-4 h-4" />
                            <span class="font-semibold">My Profile</span>
                        </a>

                        <div class="my-1 border-t border-slate-100"></div>

                        <a wire:navigate href="{{ route('logout') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-all duration-200 group">
                            <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 group-hover:text-rose-600" />
                            <span>Log Out</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main class="relative z-0 pt-12">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <aside class="hidden lg:block lg:col-span-2">
                    <div class="sticky top-24">
                        <livewire:user.sidebar />
                    </div>
                </aside>

                <section id="main-content-section"
                    class="col-span-1 lg:col-span-12 lg:ml-72 relative transition-all duration-300">

                    <div id="page-loader"
                        class="absolute inset-0 z-40 hidden flex flex-col items-center justify-center bg-white/70 backdrop-blur-md rounded-2xl">
                        <div class="flex flex-col items-center gap-4">
                            <div class="flex gap-2">
                                <span
                                    class="w-3 h-3 bg-indigo-600 rounded-full animate-bounce [animation-delay:-0.3s]"></span>
                                <span
                                    class="w-3 h-3 bg-indigo-500 rounded-full animate-bounce [animation-delay:-0.15s]"></span>
                                <span class="w-3 h-3 bg-indigo-400 rounded-full animate-bounce"></span>
                            </div>
                            <p class="font-semibold text-slate-600">Loading content…</p>
                        </div>
                    </div>

                    {{ $slot }}

                </section>

            </div>
        </div>
    </main>

    <!-- MOBILE NAV -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-slate-200 z-50">
        <div class="flex justify-between items-center px-6 h-16">

            <a href="{{ route('home') }}">
                <x-heroicon-o-home class="w-6 h-6" />
            </a>

            <a href="{{ route('find-friends') }}">
                <x-heroicon-o-users class="w-6 h-6" />
            </a>

            <a href="#" class="-top-5 relative bg-indigo-600 p-3.5 rounded-2xl text-white">
                <x-heroicon-o-plus class="w-6 h-6" />
            </a>

            <a href="#">
                <x-heroicon-o-chat-bubble-left-right class="w-6 h-6" />
            </a>

            <a href="{{ route('profile') }}">
                <x-heroicon-o-user class="w-6 h-6" />
            </a>

        </div>
    </nav>




    <div id="alpine-root">
        <style>
            @keyframes shrink-progress {
                from {
                    width: 100%;
                }

                to {
                    width: 0%;
                }
            }

            .animate-progress {
                animation: shrink-progress 3s linear forwards;
            }
        </style>

        <div x-data="{ show: false, message: '', type: 'success' }" x-init="window.addEventListener('toast', e => {
            message = e.detail.message;
            type = e.detail.type ?? 'success';
            show = false;
            setTimeout(() => show = true, 50);
            setTimeout(() => show = false, 3000);
        })" class="fixed top-20 right-6 z-[100] flex flex-col gap-2 w-full max-w-sm" style="display: none;"
            x-show="show">

            <div x-show="show" x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="relative overflow-hidden flex items-start w-full p-4 bg-white rounded-xl shadow-2xl border border-slate-100 ring-1 ring-black/5"
                role="alert">

                <div class="flex-shrink-0">
                    <template x-if="type === 'success'">
                        <div
                            class="inline-flex items-center justify-center w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg">
                            <x-heroicon-s-check-circle class="w-5 h-5" />
                        </div>
                    </template>

                    <template x-if="type === 'delete'">
                        <div
                            class="inline-flex items-center justify-center w-8 h-8 text-rose-500 bg-rose-100 rounded-lg">
                            <x-heroicon-s-x-circle class="w-5 h-5" />
                        </div>
                    </template>

                    <template x-if="type === 'error'">
                        <div
                            class="inline-flex items-center justify-center w-8 h-8 text-rose-500 bg-rose-100 rounded-lg">
                            <x-heroicon-s-x-circle class="w-5 h-5" />
                        </div>
                    </template>

                    <template x-if="type === 'warning'">
                        <div
                            class="inline-flex items-center justify-center w-8 h-8 text-amber-500 bg-amber-100 rounded-lg">
                            <x-heroicon-s-exclamation-triangle class="w-5 h-5" />
                        </div>
                    </template>
                </div>

                <div class="ml-3 text-sm font-bold text-slate-700 pt-1 flex-1">
                    <span x-text="message"></span>
                </div>

                <button type="button" @click="show = false"
                    class="ml-auto -mx-1.5 -my-1.5 bg-transparent text-slate-400 hover:text-slate-900 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 transition">
                    <x-heroicon-s-x-mark class="w-4 h-4" />
                </button>

                {{-- Progress Bar --}}
                <div x-show="show" class="absolute bottom-0 left-0 h-1 animate-progress" :class="{
                        'bg-emerald-500': type === 'success',
                        'bg-rose-500': type === 'delete',
                        'bg-rose-600': type === 'error',
                        'bg-amber-500': type === 'warning'
                    }">
                </div>
            </div>
        </div>
    </div>

    @livewireScripts

    <script>
        document.addEventListener('livewire:navigated', () => {
            @if (session()->has('message'))
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        message: "{{ session('message') }}",
                        type: 'success'
                    }
                }));
            @endif

            @if (session()->has('delete'))
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        message: "{{ session('delete') }}",
                        type: 'delete'
                    }
                }));
            @endif

            @if (session()->has('error'))
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: {
                        message: "{{ session('error') }}",
                        type: 'error'
                    }
                }));
            @endif
        });
    </script>

    <script>
        (function () {
            const loader = document.getElementById('page-loader');
            const section = document.getElementById('main-content-section');

            const showLoader = () => {
                if (!loader) return;
                loader.classList.remove('hidden');
                loader.classList.add('flex');

                if (section) {
                    section.classList.add('section-lock');
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            };

            const hideLoader = () => {
                if (!loader) return;
                loader.classList.add('hidden');
                loader.classList.remove('flex');

                if (section) {
                    section.classList.remove('section-lock');
                }
            };

            document.addEventListener('click', function (e) {
                const link = e.target.closest('a[href]');
                if (!link) return;
                if (link.target === '_blank' || link.hasAttribute('download') || link.href.includes('#') ||
                    (link.href.startsWith('http') && !link.href.startsWith(location.origin)) || e.metaKey || e
                        .ctrlKey
                ) return;

                showLoader();
            }, true);

            window.addEventListener('beforeunload', showLoader);
            window.addEventListener('pageshow', hideLoader);
        })();
    </script>

</body>

</html>