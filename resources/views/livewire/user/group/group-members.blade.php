
@if($isAdmin)

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm">

    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h3 class="text-lg font-bold text-slate-800">
            Members ({{ $group->members->where('pivot.status', 'approved')->count() }})
        </h3>

        <!-- Filters -->
        <div class="flex gap-2 flex-wrap">
            @foreach ([
                'approved' => 'Members',
                'admin'    => 'Admins',
                'pending'  => 'Pending',
                'all'      => 'All'
            ] as $key => $label)
                <button
                    wire:click="setFilter('{{ $key }}')"
                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition
                    {{ $filter === $key
                        ? 'bg-indigo-600 text-white'
                        : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Members List -->
    <div class="divide-y divide-slate-100">

        @forelse ($members as $member)
            <div class="flex items-center justify-between px-6 py-4">

                <!-- User Info -->
                <div class="flex items-center gap-4">
                    <img
                        src="https://ui-avatars.com/api/?name={{ $member->first_name }}+{{ $member->last_name }}&background=6366f1&color=fff"
                        class="w-11 h-11 rounded-xl">

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
                    <livewire:user.group.group-button
                        :group="$group"
                        :candidate-id="$member->id"
                        :wire:key="'member-btn-'.$member->id" />
                </div>

            </div>
        @empty
            <div class="px-6 py-10 text-center text-sm text-slate-500">
                No members found.
            </div>
        @endforelse

    </div>
</div>

@else
    <!-- Optional message for non-admins -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center text-sm text-slate-500">
        Only group admins can view the member list.
    </div>
@endif
