<div>
    @if (auth()->check() && $group->members->contains(auth()->id()))

        @forelse ($posts as $post)
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 mb-4">

                {{-- Header --}}
                <div class="flex items-center gap-3 mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ $post->user->first_name }}+{{ $post->user->last_name }}&background=6366f1&color=fff"
                        class="w-9 h-9 rounded-full">

                    <div>
                        <p class="text-sm font-bold text-slate-800 capitalize">
                            {{ $post->user->first_name }} {{ $post->user->last_name }}
                        </p>
                        <p class="text-xs text-slate-500">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>

                {{-- Caption --}}
                @if ($post->caption)
                    <p class="text-sm text-slate-700 mb-3">
                        {{ $post->caption }}
                    </p>
                @endif

                {{-- Image --}}
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="rounded-xl border border-slate-200">
                @endif

            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 border border-slate-100 text-center">
                <p class="text-slate-500 text-sm">
                    No posts yet. Be the first to start the discussion!
                </p>
            </div>
        @endforelse

    @endif

</div>
