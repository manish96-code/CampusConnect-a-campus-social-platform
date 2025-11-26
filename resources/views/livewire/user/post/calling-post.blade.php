<div>
    @foreach ($posts as $post)
        <div class="w-full mt-5 flex justify-center bg-gray-100">
            <div class="w-full bg-white p-4 rounded shadow">

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
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="max-w-full h-auto rounded">
                    </div>
                @endif

                <div class="flex items-center mt-4 justify-between">
                    <button wire:click="likePost({{ $post->id }})" class="text-blue-500 hover:underline mr-4 hover:cursor-pointer">Like {{ ($post->likes()->count() > 0) ? "(".$post->likes()->count() .")" : "" }}</button>
                    <button class="text-blue-500 hover:underline mr-4">Comment</button>
                    <button class="text-blue-500 hover:underline">Share</button>
                </div>

            </div>
        </div>
    @endforeach
</div>
