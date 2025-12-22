<div class="flex flex-col h-full bg-white rounded-2xl border border-slate-200 overflow-hidden">

    {{-- 🔹 CHAT HEADER --}}
    <div class="sticky top-0 z-10 bg-white border-b border-slate-200 px-4 py-3 flex items-center gap-3">

        {{-- Group Avatar --}}
        <img src="{{ $group->profile_pic
            ? asset('storage/' . $group->profile_pic)
            : 'https://ui-avatars.com/api/?name=' . urlencode($group->group_name) }}"
            class="w-10 h-10 rounded-full object-cover border">

        {{-- Group Info --}}
        <div class="leading-tight">
            <h3 class="text-sm font-bold text-slate-800">
                {{ $group->group_name }}
            </h3>

            <p class="text-xs text-slate-500 truncate max-w-[220px]">
                {{ $group->description ?? 'Group chat' }}
            </p>
        </div>

        {{-- Optional status --}}
        <span class="ml-auto text-xs text-emerald-600 font-semibold">
            ● Active
        </span>
    </div>

    {{-- 🔹 CHAT MESSAGES --}}
    <div class="flex-1 overflow-y-auto px-4 py-4 space-y-4 bg-slate-50" x-data="{ scroll() { this.$el.scrollTop = this.$el.scrollHeight } }" x-init="scroll()"
        x-on:post-created.window="$nextTick(() => scroll())">

        {{-- @if (auth()->check() &&
    $group->members()->where('users.id', auth()->id())->exists()) --}}
        @if (auth()->check() &&
                $group->members()->where('users.id', auth()->id())->wherePivot('status', 'approved')->exists())


            @forelse ($posts as $post)
                @php
                    $isMe = $post->user_id === auth()->id();

                    $isAdmin =
                        $group
                            ->members()
                            ->where('users.id', auth()->id())
                            ->wherePivot('status', 'approved')
                            ->first()?->pivot->role === 'admin';

                    $canDelete = $isMe || $isAdmin;
                @endphp
                {{-- @php $isMe = $post->user_id === auth()->id(); @endphp --}}

                <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] flex gap-2 {{ $isMe ? 'flex-row-reverse' : '' }}">

                        {{-- Avatar --}}
                        <img src="{{ $post->user->dp
                            ? asset('storage/images/dp/' . $post->user->dp)
                            : 'https://ui-avatars.com/api/?name=' . $post->user->first_name }}"
                            class="w-8 h-8 rounded-full object-cover border">

                        {{-- Message --}}
                        <div
                            class="rounded-2xl px-4 py-2 shadow-sm
                            {{ $isMe ? 'bg-indigo-600 text-white rounded-br-sm' : 'bg-white border text-slate-800 rounded-bl-sm' }}">

                            @unless ($isMe)
                                <p class="text-xs font-bold text-indigo-600 mb-1 capitalize">
                                    {{ $post->user->first_name }} {{ $post->user->last_name }}
                                </p>
                            @endunless

                            @if ($canDelete)
                                <div class="relative ml-2 mb-6" x-data="{ open: false }">

                                    {{-- 3 DOT BUTTON --}}
                                    <button @click="open = !open" class="text opacity-80 hover:opacity-100 absolute right-2">
                                        ⋮
                                    </button>

                                    {{-- DROPDOWN --}}
                                    <div x-show="open" @click.outside="open = false" x-cloak
                                        class="absolute right-0 mt-1 w-28 bg-white border rounded-xl shadow-lg z-20">

                                        <button wire:click="deletePost({{ $post->id }})" @click="open = false"
                                            class="w-full text-left px-3 py-2 text-sm text-rose-600 hover:bg-rose-50 rounded-xl">
                                            🗑 Delete
                                        </button>
                                    </div>
                                </div>
                            @endif


                            @if ($post->caption)
                                <p class="text-sm leading-relaxed">
                                    {{ $post->caption }}
                                </p>
                            @endif

                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}"
                                    class="mt-2 rounded-xl max-h-64 object-cover border">
                            @endif

                            <p class="text-[10px] mt-1 text-right opacity-70">
                                {{ $post->created_at->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

            @empty
                <div class="text-center text-sm text-slate-500 py-10">
                    No messages yet. Start the conversation 👋
                </div>
            @endforelse
        @else
            <div class="bg-white rounded-2xl p-10 border border-slate-100 text-center space-y-4">
                <p class="text-slate-600 text-sm">
                    Join this group to view and participate in the chat.
                </p>

                <livewire:user.group.group-button :group="$group" :wire:key="'group-btn-'.$group->id" />
            </div>
        @endif

    </div>
</div>
