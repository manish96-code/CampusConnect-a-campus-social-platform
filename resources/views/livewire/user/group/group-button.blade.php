<div class="w-full inline-block">
    
    <!-- CASE 1: Managing Myself (Join/Leave) -->
    @if($targetUserId === auth()->id())

        @if($status === 'not_member')
            <button wire:click="join" wire:loading.attr="disabled"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-indigo-200 transition-all transform active:scale-95 flex items-center justify-center gap-2 text-sm">
                
                <span wire:loading.remove wire:target="join" class="flex items-center gap-2">
                    <i data-feather="user-plus" class="w-4 h-4"></i>
                    {{ $group->group_type === 'private' ? 'Request to Join' : 'Join Group' }}
                </span>
                
                <span wire:loading wire:target="join" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
            </button>

        @elseif($status === 'pending')
            <button wire:click="cancelRequest" wire:loading.attr="disabled"
                class="w-full bg-slate-100 text-slate-500 font-semibold py-2.5 px-6 rounded-xl border border-slate-200 hover:bg-slate-200 hover:text-slate-700 transition flex items-center justify-center gap-2 text-sm">
                <span wire:loading.remove wire:target="cancelRequest">Request Sent (Cancel)</span>
                <span wire:loading wire:target="cancelRequest">Cancelling...</span>
            </button>

        @elseif($status === 'approved')
            <div x-data="{ open: false }" class="relative w-full">
                <button @click="open = !open" @click.outside="open = false"
                    class="w-full bg-emerald-50 text-emerald-600 font-bold py-2.5 px-6 rounded-xl border border-emerald-100 hover:bg-emerald-100 transition flex items-center justify-center gap-2 text-sm">
                    <i data-feather="check" class="w-4 h-4"></i> Joined
                    <i data-feather="chevron-down" class="w-4 h-4"></i>
                </button>

                <!-- Dropdown -->
                <div x-show="open" x-cloak x-transition
                     class="absolute top-full mt-2 right-0 w-full min-w-[160px] bg-white rounded-xl shadow-xl border border-slate-100 z-50 overflow-hidden">
                    <button wire:click="leave_group" 
                            wire:confirm="Are you sure you want to leave this group?"
                            class="w-full text-left px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 flex items-center gap-2 font-medium">
                        <i data-feather="log-out" class="w-4 h-4"></i> Leave Group
                    </button>
                </div>
            </div>

        @elseif($status === 'admin')
            <button class="w-full bg-slate-100 text-slate-500 font-bold py-2.5 px-6 rounded-xl border border-slate-200 cursor-default text-sm flex items-center justify-center gap-2">
                <i data-feather="shield" class="w-4 h-4"></i> Admin
            </button>
        @endif

    <!-- CASE 2: Managing Others (Approve/Reject/Remove) -->
    @elseif($isGroupAdmin)

        @if($status === 'pending')
            <div class="flex gap-2 w-full">
                <button wire:click="approve" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-3 rounded-lg shadow-sm transition">
                    Approve
                </button>
                <button wire:click="reject" class="flex-1 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold py-2 px-3 rounded-lg transition">
                    Reject
                </button>
            </div>
        @elseif($status === 'approved')
            <button wire:click="removeUser" wire:confirm="Remove user?" 
                class="w-full text-xs font-bold text-rose-500 hover:text-rose-700 border border-rose-200 hover:bg-rose-50 px-3 py-1.5 rounded-lg transition">
                Remove
            </button>
        @endif

    @endif

    <!-- Init Icons -->
    <script>
        document.addEventListener('livewire:initialized', () => feather.replace());
    </script>
</div>