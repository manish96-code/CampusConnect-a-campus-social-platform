<div class="w-full inline-block">

    {{-- =====================================================
   CASE 1: THIS BUTTON IS FOR ME (SELF)
   ===================================================== --}}
    @if ($targetUserId === auth()->id())

        {{-- NOT A MEMBER --}}
        @if ($status === 'not_member')
            <button wire:click="join" wire:loading.attr="disabled"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl
                   shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2 text-sm">
                <x-heroicon-o-user-plus class="w-4 h-4" />
                {{ $group->group_type === 'private' ? 'Request to Join' : 'Join Group' }}
            </button>

            {{-- PENDING --}}
        @elseif ($status === 'pending')
            <button wire:click="cancelRequest"
                class="w-full bg-slate-100 text-slate-600 font-semibold py-2.5 px-6 rounded-xl
                   border border-slate-200 hover:bg-slate-200 transition text-sm">
                Request Sent (Cancel)
            </button>

            {{-- APPROVED MEMBER --}}
        @elseif ($status === 'approved')
            <div x-data="{ open: false }" class="relative w-full">
                <button @click="open = !open" @click.outside="open = false"
                    class="w-full bg-emerald-50 text-emerald-600 font-bold py-2.5 px-6 rounded-xl
                       border border-emerald-100 hover:bg-emerald-100 transition flex gap-2 justify-center text-sm">
                    <x-heroicon-o-check class="w-4 h-4" />
                    Joined
                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                </button>

                <div x-show="open" x-cloak
                    class="absolute right-0 mt-2 w-full bg-white rounded-xl shadow-xl border z-50">
                    <button wire:click="leave_group" wire:confirm="Are you sure you want to leave this group?"
                        class="w-full px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 flex gap-2">
                        <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4" />
                        Leave Group
                    </button>
                </div>
            </div>

            {{-- ADMIN (ME) --}}
        @elseif ($status === 'admin')
            <div x-data="{ open: false }" class="relative w-full">
                <button @click="open = !open" @click.outside="open = false"
                    class="w-full bg-slate-100 text-slate-700 font-bold py-2.5 px-6 rounded-xl
                       border border-slate-200 hover:bg-slate-200 transition flex gap-2 justify-center text-sm">
                    <x-heroicon-o-shield-check class="w-4 h-4" />
                    Admin
                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                </button>

                <div x-show="open" x-cloak
                    class="absolute right-0 mt-2 w-full bg-white rounded-xl shadow-xl border z-50">
                    @can('delete', $group)
                        <button wire:click="deleteGroup" wire:confirm="⚠️ This will permanently delete the group. Continue?"
                            class="w-full px-4 py-3 text-sm text-rose-600 hover:bg-rose-50 flex gap-2">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            Delete Group
                        </button>
                    @endcan
                </div>
            </div>
        @endif


        {{-- =====================================================
   CASE 2: THIS BUTTON IS FOR ANOTHER USER
   ===================================================== --}}
    @else
        {{-- ONLY ADMINS CAN MANAGE OTHERS --}}
        @if ($isGroupAdmin)

            {{-- PENDING USER --}}
            @if ($status === 'pending')
                <div class="flex gap-2">
                    <button wire:click="approve"
                        class="bg-indigo-600 text-white text-xs font-bold px-4 py-2 rounded-lg">
                        Approve
                    </button>
                    <button wire:click="reject" class="bg-white border text-xs font-bold px-4 py-2 rounded-lg">
                        Reject
                    </button>
                </div>

                {{-- APPROVED MEMBER --}}
            @elseif ($status === 'approved')
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                        class="text-slate-400 hover:text-indigo-600">
                        <x-heroicon-o-ellipsis-vertical class="w-5 h-5" />
                    </button>

                    <div x-show="open" x-cloak
                        class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border z-50 space-y-1">

                        <button wire:click="makeAdmin" wire:confirm="Make this user an admin?"
                            class="w-full px-4 py-2 text-sm text-indigo-600 hover:bg-indigo-50 flex gap-2">
                            <x-heroicon-o-shield-check class="w-4 h-4" />
                            Make Admin
                        </button>

                        <button wire:click="removeUser" wire:confirm="Remove user from group?"
                            class="w-full px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 flex gap-2">
                            Remove User
                        </button>
                    </div>
                </div>

                {{-- OTHER ADMIN --}}
            @elseif ($status === 'admin')
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                        class="text-slate-400 hover:text-indigo-600">
                        <x-heroicon-o-ellipsis-vertical class="w-5 h-5" />
                    </button>

                    <div x-show="open" x-cloak
                        class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border z-50">
                        @can('manageMembers', [$group, $targetUserId])
                            <button wire:click="removeAdmin" wire:confirm="Remove admin role from this user?"
                                class="w-full px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 flex gap-2">
                                <x-heroicon-o-shield-exclamation class="w-4 h-4" />
                                Remove Admin
                            </button>
                        @endcan
                    </div>
                </div>
            @endif

            {{-- NON-ADMIN VIEWING ADMIN --}}
        @elseif ($status === 'admin')
            <div class="bg-slate-100 text-slate-500 py-2.5 px-6 rounded-xl text-sm font-bold flex gap-2 justify-center">
                <x-heroicon-o-shield-check class="w-4 h-4" />
                Admin
            </div>
        @endif

    @endif

</div>
