<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sticky top-24">

    <!-- Header -->
    <div class="flex items-center justify-between mb-4 px-1">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Contacts</h3>
        @if (count($friends) > 0)
            <span class="bg-emerald-100 text-emerald-600 text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                {{ count($friends) }}
            </span>
        @endif
    </div>

    <!-- Friends List -->
    <div class="space-y-3 max-h-[calc(100vh-200px)] overflow-y-auto no-scrollbar pr-1">
        @foreach ($friends as $friend)
            <a href="{{ route('profile', ['id' => $friend->id]) }}"
                class="group flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition-all duration-200 cursor-pointer border border-transparent hover:border-slate-100">

                <!-- Avatar Container -->
                <div class="relative flex-shrink-0">
                    <img src="{{ $friend->dp ?: 'https://ui-avatars.com/api/?name=' . urlencode($friend->first_name . '+' . $friend->last_name) . '&background=6366f1&color=fff' }}"
                        alt="{{ $friend->first_name }}"
                        class="w-10 h-10 rounded-full object-cover border-2 border-slate-50 group-hover:border-white shadow-sm transition-colors">

                    <!-- Online Dot -->
                    <span
                        class="absolute bottom-0.5 right-0.5 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full">
                        <span
                            class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                    </span>
                </div>

                <!-- Text Info -->
                <div class="overflow-hidden">
                    <h4
                        class="font-semibold text-sm text-slate-700 group-hover:text-indigo-600 transition-colors truncate capitalize leading-tight">
                        {{ $friend->first_name }} {{ $friend->last_name }}
                    </h4>
                    <p class="text-[11px] text-slate-400 font-medium truncate mt-0.5">
                        Online now
                    </p>
                </div>
            </a>
        @endforeach

        <!-- Empty State -->
        @if ($friends->isEmpty())
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                    <x-heroicon-o-moon class="w-5 h-5 text-slate-300" />
                </div>
                <p class="text-xs font-semibold text-slate-500">It's quiet here</p>
                <p class="text-[10px] text-slate-400 mt-1">No friends are online right now.</p>
            </div>
        @endif
    </div>

</div>
