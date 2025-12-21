<div class="space-y-4">

    {{-- MEMBER CHECK --}}
    @if (auth()->check() && $group->members()->where('users.id', auth()->id())->exists())

        @forelse ($posts as $post)

            @php
                $isMe = $post->user_id === auth()->id();
            @endphp

            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">

                <div class="max-w-[75%] flex gap-2 {{ $isMe ? 'flex-row-reverse' : '' }}">

                    {{-- Avatar --}}
                    <img
                        src="{{ $post->user->dp
                            ? asset('storage/images/dp/' . $post->user->dp)
                            : 'https://ui-avatars.com/api/?name=' . $post->user->first_name }}"
                        class="w-8 h-8 rounded-full object-cover border">

                    {{-- Message Bubble --}}
                    <div
                        class="rounded-2xl px-4 py-2 shadow-sm
                        {{ $isMe
                            ? 'bg-indigo-600 text-white rounded-br-sm'
                            : 'bg-white border text-slate-800 rounded-bl-sm' }}">

                        {{-- Name (only for others) --}}
                        @unless ($isMe)
                            <p class="text-xs font-bold text-indigo-600 mb-1">
                                {{ $post->user->first_name }} {{ $post->user->last_name }}
                            </p>
                        @endunless

                        {{-- Text --}}
                        @if ($post->caption)
                            <p class="text-sm leading-relaxed whitespace-pre-line">
                                {{ $post->caption }}
                            </p>
                        @endif

                        {{-- Image --}}
                        @if ($post->image)
                            <img
                                src="{{ asset('storage/' . $post->image) }}"
                                class="mt-2 rounded-xl max-h-64 object-cover border">
                        @endif

                        {{-- Time --}}
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
        {{-- NON-MEMBER VIEW --}}
        <div class="bg-white rounded-2xl p-10 border border-slate-100 text-center space-y-4">
            <p class="text-slate-600 text-sm">
                Join this group to view and participate in the chat.
            </p>

            <livewire:user.group.group-button
                :group="$group"
                :wire:key="'group-btn-'.$group->id" />
        </div>
    @endif

</div>
