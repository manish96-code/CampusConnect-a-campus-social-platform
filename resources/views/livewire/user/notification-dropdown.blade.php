<div class="relative" x-data="{ open: false }" wire:poll.30s="loadNotifications">
    <!-- Notification Bell -->
    <button @click="open = !open"
        class="relative p-2 text-slate-500 rounded-full hover:bg-slate-100 transition-all focus:outline-none">
        <x-heroicon-o-bell class="w-5 h-5" />
        @if($unreadCount > 0)
            <span
                class="absolute top-2 right-2.5 w-4 h-4 bg-rose-500 text-white text-[10px] font-bold rounded-full ring-2 ring-white flex items-center justify-center">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-[100]"
        style="display: none;">

        <div class="p-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-sm">Notifications</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead"
                    class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-wider">Mark all
                    read</button>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div wire:click="markAsRead('{{ $notification->id }}')"
                    class="p-4 flex gap-3 hover:bg-slate-50 cursor-pointer transition-colors {{ $notification->read_at ? '' : 'bg-indigo-50/30' }}">
                    <div
                        class="flex-shrink-0 w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                        @php
                            $icon = $notification->data['icon'] ?? 'heroicon-o-bell';
                        @endphp
                        <x-dynamic-component :component="$icon" class="w-5 h-5" />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800 leading-tight">
                            {{ $notification->data['title'] ?? 'New Notification' }}
                        </p>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                            {{ $notification->data['message'] ?? 'You have a new update.' }}
                        </p>
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if(!$notification->read_at)
                        <div class="w-2 h-2 bg-indigo-500 rounded-full mt-2"></div>
                    @endif
                </div>
            @empty
                <div class="p-10 text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-heroicon-o-bell-slash class="w-8 h-8 text-slate-300" />
                    </div>
                    <h4 class="text-sm font-bold text-slate-700">All caught up!</h4>
                    <p class="text-xs text-slate-400 mt-1">No new notifications at the moment.</p>
                </div>
            @endforelse
        </div>

        @if($notifications->count() > 0)
            <div class="p-3 border-t border-slate-50 text-center">
                <a href="#" class="text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors">View All
                    Activity</a>
            </div>
        @endif
    </div>
</div>