<div class="space-y-6">
    @foreach ($posts as $post)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden transition-shadow hover:shadow-md" 
             x-data="{ open: false }">
            
            <!-- 1. POST HEADER -->
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <!-- Avatar -->
                    <a href="{{ route('profile', ['id' => $post->user->id]) }}" class="relative block group">
                        <img src="@if ($post->user->dp) {{ asset('storage/images/dp/' . $post->user->dp) }} @else https://ui-avatars.com/api/?name={{ $post->user->first_name }}+{{ $post->user->last_name }}&background=6366f1&color=fff @endif"
                             alt="{{ $post->user->first_name }}" 
                             class="w-10 h-10 rounded-full object-cover border border-slate-100 group-hover:opacity-90 transition">
                    </a>
                    
                    <!-- Meta -->
                    <div class="leading-tight">
                        <a href="{{ route('profile', ['id' => $post->user->id]) }}" class="font-bold text-slate-800 hover:text-indigo-600 transition text-sm block">
                            {{ $post->user->first_name }} {{ $post->user->last_name }}
                        </a>
                        <span class="text-xs text-slate-400 font-medium">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <!-- Options Icon -->
                <button class="text-slate-400 hover:bg-slate-50 p-2 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                </button>
            </div>

            <!-- 2. CONTENT -->
            @if ($post->caption)
                <div class="px-4 pb-3">
                    <p class="text-slate-700 text-[15px] leading-relaxed whitespace-pre-line">{{ $post->caption }}</p>
                </div>
            @endif

            @if ($post->image)
                <div class="w-full bg-slate-50 border-y border-slate-100">
                    <img src="{{ asset('storage/' . $post->image) }}" 
                         alt="Post content" 
                         class="w-full max-h-[500px] object-cover"
                         loading="lazy">
                </div>
            @endif

            <!-- 3. ACTION BAR -->
            <div class="px-4 py-3 flex items-center justify-between border-t border-slate-100">
                <div class="flex items-center gap-6">
                    
                    <!-- Like Button -->
                    <button wire:click="likePost({{ $post->id }})" 
                        class="group flex items-center gap-2 transition-colors {{ $post->likes()->where('user_id', auth()->id())->exists() ? 'text-rose-500' : 'text-slate-500 hover:text-rose-500' }}">
                        <div class="p-2 rounded-full group-hover:bg-rose-50 transition">
                            @if($post->likes()->where('user_id', auth()->id())->exists())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            @endif
                        </div>
                        <span class="text-sm font-semibold">{{ $post->likes()->count() > 0 ? $post->likes()->count() : 'Like' }}</span>
                    </button>

                    <!-- Comment Toggle -->
                    <button @click="open = !open" class="group flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors">
                        <div class="p-2 rounded-full group-hover:bg-indigo-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <span class="text-sm font-semibold">{{ $post->comments()->count() > 0 ? $post->comments()->count() : 'Comment' }}</span>
                    </button>

                    <!-- Share Button -->
                    <button class="group flex items-center gap-2 text-slate-500 hover:text-green-600 transition-colors">
                        <div class="p-2 rounded-full group-hover:bg-green-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" /></svg>
                        </div>
                    </button>
                </div>
            </div>

            <!-- 4. COMMENT SECTION -->
            <div x-show="open" x-cloak x-transition.origin.top class="bg-slate-50/50 border-t border-slate-100 p-4">
                
                <!-- Existing Comments -->
                @if($post->comments->count() > 0)
                    <div class="space-y-4 mb-4 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        @foreach ($post->comments as $comment)
                            <div class="flex gap-3">
                                <img src="@if ($comment->user->dp) {{ asset('storage/images/dp/' . $comment->user->dp) }} @else https://ui-avatars.com/api/?name={{ $comment->user->first_name }}+{{ $comment->user->last_name }}&background=random @endif" 
                                     class="w-8 h-8 rounded-full object-cover flex-shrink-0 mt-1">
                                
                                <div>
                                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100">
                                        <a href="{{ route('profile', ['id' => $comment->user->id]) }}" class="font-bold text-xs text-slate-800 hover:underline block mb-0.5">
                                            {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                                        </a>
                                        <p class="text-slate-600 text-sm">{{ $comment->comment }}</p>
                                    </div>
                                    <div class="flex items-center gap-3 mt-1 ml-1">
                                        <span class="text-[10px] text-slate-400 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                                        <button class="text-[10px] text-slate-500 font-bold hover:text-indigo-600">Like</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Comment Input (Fix: Using comments.{{ $post->id }}) -->
                <form wire:submit.prevent="commentPost({{ $post->id }})" class="relative flex items-center">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}&background=6366f1&color=fff" 
                         class="w-8 h-8 rounded-full absolute left-3 border border-slate-100">
                    
                    <input type="text" 
                           wire:model="comments.{{ $post->id }}" 
                           placeholder="Write a comment..." 
                           class="w-full pl-12 pr-12 py-2.5 bg-white border border-slate-200 rounded-full text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition shadow-sm placeholder-slate-400">
                    
                    <button type="submit" 
                            class="absolute right-2 p-1.5 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition shadow-md disabled:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-90" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    @endforeach
</div>