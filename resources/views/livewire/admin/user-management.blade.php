<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">User Management</h1>
            <p class="text-slate-500 mt-1">Manage all registered students and administrators.</p>
        </div>

        <div class="flex flex-wrap gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4 text-slate-400" />
                </div>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="block w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all shadow-sm"
                    placeholder="Search name or email...">
            </div>

            <select wire:model.live="filterRole"
                class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none shadow-sm capitalize transition-all">
                <option value="all">All Roles</option>
                <option value="admin">Administrators</option>
                <option value="user">Students</option>
            </select>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-xl overflow-hidden shadow-indigo-500/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">
                            Profile</th>
                        <th class="px-8 py-5 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">
                            Contact Info</th>
                        <th class="px-8 py-5 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">Joined
                            Date</th>
                        <th
                            class="px-8 py-5 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <img src="{{ $user->dp ?: 'https://ui-avatars.com/api/?name=' . $user->first_name . '+' . $user->last_name . '&background=6366f1&color=fff' }}"
                                            class="h-12 w-12 rounded-2xl object-cover shadow-sm ring-2 ring-white overflow-hidden">
                                        @if($user->is_admin)
                                            <div
                                                class="absolute -top-1 -right-1 bg-amber-400 p-0.5 rounded-full ring-2 ring-white">
                                                <x-heroicon-s-shield-check class="w-3 h-3 text-white" />
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 capitalize leading-none mb-1">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </p>
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                            ID: #U-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-slate-600">
                                        <x-heroicon-o-envelope class="w-3.5 h-3.5" />
                                        <span class="text-sm font-medium">{{ $user->email }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-400">
                                        <x-heroicon-o-phone class="w-3.5 h-3.5" />
                                        <span class="text-xs">{{ $user->contact }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="text-slate-600">
                                    <p class="text-sm font-bold">{{ $user->created_at->format('M d, Y') }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">
                                        {{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('profile', $user->id) }}" target="_blank"
                                        class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                        title="View Profile">
                                        <x-heroicon-o-eye class="w-5 h-5" />
                                    </a>
                                    <button
                                        onclick="confirm('Permanently delete this user?') || event.stopImmediatePropagation()"
                                        wire:click="deleteUser({{ $user->id }})"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all"
                                        title="Delete User">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="p-6 bg-slate-50 rounded-full mb-4">
                                        <x-heroicon-o-users class="w-12 h-12 text-slate-300" />
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700">No users found</h3>
                                    <p class="text-slate-400 mt-1">Try adjusting your search or filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>