<div class="space-y-6">
    @forelse ($posts as $post)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden transition-shadow hover:shadow-md"
            x-data="{ open: false }">

            <!-- POST HEADER -->
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <!-- Avatar -->
                    <a href="{{ route('profile', ['id' => $post->user->id]) }}" class="relative block group">
                        <img src="{{ $post->user->dp ?: 'https://ui-avatars.com/api/?name=' . $post->user->first_name . '+' . $post->user->last_name . '&background=6366f1&color=fff' }}"
                            class="w-10 h-10 rounded-full object-cover">
                    </a>

                    <!-- Meta -->
                    <div class="leading-tight">
                        <a href="{{ route('profile', ['id' => $post->user->id]) }}"
                            class="font-bold text-slate-800 hover:text-indigo-600 transition text-sm block capitalize">
                            {{ $post->user->first_name }} {{ $post->user->last_name }}
                        </a>
                        <span class="text-xs text-slate-400 font-medium">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <!-- Options Icon -->
                <button class="text-slate-400 hover:bg-slate-50 p-2 rounded-full transition">
                    <x-heroicon-o-ellipsis-horizontal class="w-5 h-5" />
                </button>
            </div>

            <!-- Caption -->
            @if ($post->caption)
                <div class="px-4 pb-3">
                    <p class="text-slate-700 text-[15px] leading-relaxed whitespace-pre-line">{{ $post->caption }}</p>
                </div>
            @endif

            @if ($post->image)
                <div class="w-full bg-slate-50 border-y border-slate-100">
                    <img src="{{ $post->image }}" alt="Post content" class="w-full max-h-[500px] object-cover"
                        loading="lazy">
                </div>
            @endif

            <!-- ACTION BAR -->
            <div class="px-4 py-3 flex items-center justify-between border-t border-slate-100">
                <div class="flex items-center gap-6">

                    <!-- Like Button -->
                    <button wire:click="likePost({{ $post->id }})"
                        class="group flex items-center gap-2 transition-colors {{ $post->likes()->where('user_id', auth()->id())->exists()? 'text-rose-500': 'text-slate-500 hover:text-rose-500' }}">
                        <div class="p-2 rounded-full group-hover:bg-rose-50 transition">
                            @if ($post->likes()->where('user_id', auth()->id())->exists())
                                <x-heroicon-s-heart class="w-5 h-5" />
                            @else
                                <x-heroicon-o-heart class="w-5 h-5" />
                            @endif
                        </div>
                        <span class="text-sm font-semibold">
                            {{ $post->likes()->count() > 0 ? $post->likes()->count() : 'Like' }}
                        </span>
                    </button>

                    <!-- Comment Toggle -->
                    <button @click="open = !open"
                        class="group flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors">
                        <div class="p-2 rounded-full group-hover:bg-indigo-50 transition">
                            <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                        </div>
                        <span class="text-sm font-semibold">
                            {{ $post->comments()->count() > 0 ? $post->comments()->count() : 'Comment' }}
                        </span>
                    </button>

                    <!-- Share Button -->
                    <button class="group flex items-center gap-2 text-slate-500 hover:text-green-600 transition-colors">
                        <div class="p-2 rounded-full group-hover:bg-green-50 transition">
                            <x-heroicon-o-share class="w-5 h-5" />
                        </div>
                    </button>
                </div>
            </div>

            <!-- COMMENT SECTION -->
            <div x-show="open" x-cloak x-transition.origin.top class="bg-slate-50/50 border-t border-slate-100 p-4">

                <!-- Existing Comments -->
                @if ($post->comments->count() > 0)
                    <div class="space-y-4 mb-4 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        @foreach ($post->comments as $comment)
                            <div class="flex gap-3">
                                <img src="{{ $comment->user->dp ?: 'https://ui-avatars.com/api/?name=' . $comment->user->first_name . '&background=random' }}"
                                    class="w-8 h-8 rounded-full object-cover">

                                <div>
                                    <div
                                        class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100">
                                        <a href="{{ route('profile', ['id' => $comment->user->id]) }}"
                                            class="font-bold text-xs text-slate-800 hover:underline block mb-0.5 capitalize">
                                            {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                                        </a>
                                        <p class="text-slate-600 text-sm">{{ $comment->comment }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 mt-1 ml-1">
                                        <span class="text-[10px] text-slate-400 font-medium">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                        <button class="text-[10px] text-slate-500 font-bold hover:text-indigo-600">
                                            Like
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Comment Input -->
                <form wire:submit.prevent="commentPost({{ $post->id }})" class="relative flex items-center">
                    <img src="{{ auth()->user()->dp ?: 'https://ui-avatars.com/api/?name=' . auth()->user()->first_name . '+' . auth()->user()->last_name . '&background=6366f1&color=fff' }}"
                        alt="{{ auth()->user()->first_name }}"
                        class="w-8 h-8 rounded-full absolute left-3 border border-slate-100">

                    <input type="text" wire:model="comments.{{ $post->id }}" placeholder="Write a comment..."
                        class="w-full pl-12 pr-12 py-2.5 bg-white border border-slate-200 rounded-full text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm placeholder-slate-400">

                    <button type="submit"
                        class="absolute right-2 p-1.5 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition shadow-md disabled:opacity-50">
                        <x-heroicon-o-paper-airplane class="w-4 h-4" />
                    </button>
                </form>
            </div>

        </div>
        {{-- @endforeach --}}
    @empty
        <!-- NO POST STATE -->
        <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-10 text-center">
            <div class="flex flex-col items-center gap-3">
                <x-heroicon-o-document-text class="w-10 h-10 text-slate-400" />
                <p class="text-slate-600 font-semibold text-base">
                    No posts yet
                </p>
                <p class="text-sm text-slate-400">
                    This user hasn’t shared anything yet.
                </p>

                {{-- Only show button on own profile --}}
                @if (auth()->id() === $selectedUser->id)
                    <button
                        class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">
                        Create your first post
                    </button>
                @endif
            </div>
        </div>
    @endforelse
</div>
