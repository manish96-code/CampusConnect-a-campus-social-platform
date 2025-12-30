<div class="min-h-screen bg-[#F4F7FE] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- 1. Header & Search -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Find Classmates</h2>
                <p class="text-slate-500 text-sm mt-1">Discover students to connect with.</p>
            </div>
        </div>

        <!-- 2. Users Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($users as $user)
                <div
                    class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col h-full group relative">

                    <!-- Decorative Banner (Gradient or User Cover) -->
                    <div
                        class="h-24 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 relative overflow-hidden">
                        <img src="@if ($user->cover) {{ asset('storage/images/cover/' . $user->cover) }} @else https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop @endif"
                            class="w-full h-full object-cover" alt="Cover Photo">
                    </div>

                    <!-- Profile Content -->
                    <div class="px-5 pb-5 flex-1 flex flex-col items-center -mt-12 text-center relative z-10">

                        <!-- Avatar -->
                        <a href="{{ route('profile', ['id' => $user->id]) }}"
                            class="relative block group-hover:scale-105 transition-transform duration-300">
                            <img src="@if ($user->dp) {{ asset('storage/images/dp/' . $user->dp) }} @else {{ asset('storage/images/dp.png') }} @endif"
                                alt="{{ $user->first_name }}"
                                class="w-24 h-24 rounded-full object-cover border-[4px] border-white shadow-md bg-white">
                        </a>

                        <!-- Name & Info -->
                        <div class="mt-3 w-full mb-4">
                            <a href="{{ route('profile', ['id' => $user->id]) }}"
                                class="text-lg font-bold text-slate-800 hover:text-indigo-600 transition block truncate capitalize">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </a>

                            <!-- Department/Course -->
                            <p class="text-xs text-slate-500 font-medium mt-1 truncate">
                                {{ $user->course ?? 'Student' }}
                            </p>

                            <!-- Location -->
                            <p class="text-[10px] text-slate-400 mt-2 flex items-center justify-center gap-1.5">
                                <x-heroicon-o-map-pin class="w-3 h-3" />
                                Purnea University
                            </p>
                        </div>

                        <!-- Action Button (Livewire Component) -->
                        <div class="mt-auto w-full pt-4 border-t border-slate-50">
                            <div class="w-full">
                                <livewire:user.friendship-button :selected-user="$user" :key="$user->id" />
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 3. Empty State -->
        @if ($users->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-200">
                <div class="bg-indigo-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-users class="w-8 h-8 text-indigo-500" />
                </div>
                <h3 class="text-lg font-bold text-slate-700">No new suggestions</h3>
                <p class="text-slate-500 text-sm mt-1">Check back later for more students.</p>
            </div>
        @endif

    </div>
</div>
