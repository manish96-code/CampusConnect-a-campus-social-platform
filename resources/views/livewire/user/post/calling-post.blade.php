<div>
    @foreach ($posts as $post)
        <div class="w-full mt-5 flex justify-center bg-gray-100">
            <div class="w-full bg-white p-4 rounded shadow" x-data="{ open: false }">

                <div class="flex items-center mb-2">
                    <img src="@if ($post->user->dp) {{ asset('storage/images/dp/' . $post->user->dp) }} @else {{ asset('storage/images/dp.png') }} @endif"
                        alt="{{ $post->user->first_name }}'s image" class="w-14 h-14 rounded-full object-cover mr-2">

                    <div class="flex flex-col justify-start">
                        <h2 class="text-lg font-bold capitalize">
                            {{ $post->user->first_name }} {{ $post->user->last_name }}
                        </h2>
                        <span class="text-gray-500 text-sm">
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                @if ($post->caption)
                    <p class="text-gray-700 text-xl">{{ $post->caption }}</p>
                @endif

                @if ($post->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                            class="max-w-full h-auto rounded">
                    </div>
                @endif

                <div class="flex items-center mt-4 justify-between">
                    {{-- like, comment, share buttons --}}
                    {{-- <button wire:click="likePost({{ $post->id }})"
                        class="text-blue-500 hover:underline mr-4 hover:cursor-pointer flex items-center gap-1">
                        @if ($post->)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="red-500" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        
                        @else

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        
                        @endif
                        {{ $post->likes()->count() > 0 ? '(' . $post->likes()->count() . ')' : '' }}
                    </button> --}}
                    <button wire:click="likePost({{ $post->id }})"
                        class="text-blue-500 hover:underline mr-4 hover:cursor-pointer">Like
                        {{ $post->likes()->count() > 0 ? '(' . $post->likes()->count() . ')' : '' }}</button>
                    <button x-on:click="open =  !open" class="text-blue-500 hover:underline mr-4">Comment
                        {{ $post->comments()->count() > 0 ? '(' . $post->comments()->count() . ')' : '' }}</button>
                    <button class="text-blue-500 hover:underline">Share</button>
                </div>

                {{-- comment section --}}
                <div x-show="open" class="px-4 pb-4 mt-4">
                    <form wire:submit.prevent="commentPost({{ $post->id }})" class="flex items-center gap-2">
                        <input type="text" wire:model="comment" placeholder="Write a comment..."
                            class="w-full border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            autofocus>
                        <input type="submit" value="Post"
                            class="hidden mt-2 bg-blue-500 text-white font-semibold px-4 py-2 rounded-full hover:bg-blue-600 cursor-pointer">
                    </form>

                    {{--  calling post comment --}}
                    <div class="mt-4 space-y-4">
                        @foreach ($post->comments as $comment)
                            <div class="flex items-start gap-2">
                                <a href="{{ route('profile', ['id' => $comment->user->id]) }}"
                                    class="w-8 h-8 rounded-full overflow-hidden cursor-pointer">
                                    <img src="@if ($comment->user->dp) {{ asset('storage/images/dp/' . $comment->user->dp) }} @else {{ asset('storage/images/dp.png') }} @endif"
                                        alt="{{ $comment->user->first_name }}'s image"
                                        class="w-full h-full object-cover">
                                </a>
                                <div class="bg-gray-100 rounded-lg px-3 py-2">
                                    <a href="{{ route('profile', ['id' => $comment->user->id]) }}"
                                        class="font-semibold text-[#050505] text-[14px] hover:underline cursor-pointer capitalize">
                                        {{ $comment->user->first_name }} {{ $comment->user->last_name }}
                                    </a>
                                    <p class="text-[#050505] text-[14px]">{{ $comment->comment }}</p>
                                    <div class="text-[#65676b] text-[12px] mt-1 flex items-center gap-2">
                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                        <button class="hover:underline">Like</button>
                                        <button class="hover:underline">Reply</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
