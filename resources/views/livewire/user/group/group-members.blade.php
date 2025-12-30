@if ($isAdmin)

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 bg-white">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <!-- Title -->
                @php
                    $count = match ($filter) {
                        'approved' => $group->members->where('pivot.status', 'approved')->count(),
                        'admin' => $group->members
                            ->where('pivot.role', 'admin')
                            ->where('pivot.status', 'approved')
                            ->count(),
                        'pending' => $group->members->where('pivot.status', 'pending')->count(),
                        'all' => $group->members->count(),
                        default => null,
                    };
                @endphp

                <div class="flex items-center gap-2">
                    <h3 class="text-lg font-bold text-slate-800">
                        {{ $filter === 'add' ? 'Add Members' : 'Members' }}
                    </h3>

                    @if (!is_null($count))
                        <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-indigo-50 text-indigo-600">
                            {{ $count }}
                        </span>
                    @endif
                </div>


                <!-- Search -->
                <div class="relative w-full lg:w-64">
                    <input type="search" wire:model.live="search"
                        placeholder="{{ $filter === 'add' ? 'Search classmates…' : 'Search members…' }}"
                        class="w-full pl-9 pr-4 py-2 text-sm rounded-xl
                       border border-slate-200 bg-slate-50
                       focus:bg-white focus:ring-2 focus:ring-indigo-500
                       placeholder:text-slate-400">

                    <!-- Search Icon -->
                    <x-heroicon-o-magnifying-glass
                        class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />

                </div>
            </div>

            <!-- Filters Row -->
            <div class="mt-4 flex flex-wrap items-center gap-2">

                @if ($isAdmin)
                    <button wire:click="setFilter('add')"
                        class="px-3 py-1.5 text-xs font-bold rounded-lg transition
                        {{ $filter === 'add' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                        <x-heroicon-o-user-plus class="w-4 h-4 mr-1 inline-block" />
                        Add Members
                    </button>
                @endif

                @foreach ([
                    'approved' => 'Members',
                    'admin' => 'Admins',
                    'pending' => 'Pending',
                    'all' => 'All',
                ] as $key => $label)
                    <button wire:click="setFilter('{{ $key }}')"
                        class="px-3 py-1.5 text-xs font-bold rounded-lg transition
                {{ $filter === $key ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

        </div>


        <!-- Members List -->
        <div class="divide-y divide-slate-100">

            @if ($filter === 'add' && $isAdmin)

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm mt-6">

                    <div class="px-6 py-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">
                            Add Members
                        </h3>
                    </div>

                    <div class="divide-y divide-slate-100">

                        @forelse($users as $user)
                            <div wire:key="add-user-{{ $user->id }}"
                                class="flex items-center justify-between px-6 py-4">

                                <div class="flex items-center gap-4">
                                    {{-- <img src="https://ui-avatars.com/api/?name={{ $user->first_name }}+{{ $user->last_name }}&background=6366f1&color=fff"
                                        class="w-11 h-11 rounded-xl"> --}}
                                    <img src="@if ($user->dp) {{ asset('storage/images/dp/' . $user->dp) }}
                                        @else
                                            https://ui-avatars.com/api/?name={{ $user->first_name }}+{{ $user->last_name }}&background=6366f1&color=fff @endif"
                                        alt="{{ $user->first_name }}"
                                        class="w-11 h-11 rounded-full object-cover border">


                                    <div>
                                        <p class="text-sm font-bold text-slate-800 capitalize">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>

                                <button wire:click="addMember({{ $user->id }})" wire:loading.attr="disabled"
                                    wire:target="addMember({{ $user->id }})"
                                    class="px-4 py-1.5 text-xs font-bold rounded-lg
                                    bg-emerald-600 text-white hover:bg-emerald-700
                                    disabled:opacity-50 disabled:cursor-not-allowed transition">
                                    <x-heroicon-o-user-plus class="w-4 h-4 mr-1 inline-block" /> Add
                                </button>

                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-slate-500">
                                No users available to add.
                            </div>
                        @endforelse

                    </div>
                </div>

            @endif


            @if ($filter !== 'add')
                @forelse ($members as $member)
                    <div wire:key="member-{{ $member->id }}" class="flex items-center justify-between px-6 py-4">

                        <!-- User Info -->
                        <div class="flex items-center gap-4">
                            {{-- <img src="https://ui-avatars.com/api/?name={{ $member->first_name }}+{{ $member->last_name }}&background=6366f1&color=fff"
                                class="w-11 h-11 rounded-xl"> --}}
                            <img src="@if ($member->dp) {{ asset('storage/images/dp/' . $member->dp) }}
                                @else
                                    https://ui-avatars.com/api/?name={{ $member->first_name }}+{{ $member->last_name }}&background=6366f1&color=fff @endif"
                                alt="{{ $member->first_name }}" class="w-11 h-11 rounded-full object-cover border">


                            <div>
                                <a href="{{ route('profile', $member->id) }}"
                                    class="text-sm font-bold text-slate-800 hover:underline capitalize">
                                    {{ $member->first_name }} {{ $member->last_name }}
                                </a>

                                <div class="text-xs text-slate-500 flex gap-2 items-center">
                                    <span class="capitalize">{{ $member->pivot->role }}</span>
                                    <span class="w-1 h-1 bg-slate-400 rounded-full"></span>
                                    <span class="capitalize">{{ $member->pivot->status }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <livewire:user.group.group-button :group="$group" :candidate-id="$member->id"
                                :wire:key="'member-btn-'.$member->id" />
                        </div>

                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-slate-500">
                        No members found.
                    </div>
                @endforelse
            @endif

        </div>
    </div>
@else
    <!-- message for non-admins -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center text-sm text-slate-500">
        Only group admins can view the member list.
    </div>
@endif
