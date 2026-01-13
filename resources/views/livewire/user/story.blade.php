<div class="relative h-[220px] mb-6 flex gap-2 overflow-x-auto scrollbar-hide">
    <!-- Add Story Card -->
    <div class="min-w-[140px] max-w-48 h-full bg-white rounded-xl shadow overflow-hidden relative cursor-pointer group">
        <div wire:loading wire:target="media_path"
            class="absolute inset-0 z-20 bg-indigo-600/40 backdrop-blur-sm flex items-center justify-center">
            <x-heroicon-o-arrow-path class="w-8 h-8 text-white animate-spin" />
        </div>
        <img src="{{ auth()->user()->dp ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->first_name . ' ' . auth()->user()->last_name) . '&background=6366f1&color=fff' }}"
            alt="Profile" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

        <div class="absolute bottom-0 w-full bg-white h-12 flex justify-center items-center">
            <form wire:submit.prevent="createStory">
                <input type="file" wire:model="media_path" id="story_media" class="hidden">

                <label for="story_media"
                    class="w-8 h-8 bg-blue-500 rounded-full border-4 border-white flex items-center justify-center -mt-8 text-white cursor-pointer">
                    <x-heroicon-o-plus class="w-4 h-4" />
                </label>

                @error('media_path')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <input type="hidden" value="Create Story" class="hidden">
            </form>
        </div>

        <div class="absolute bottom-2 w-full text-center text-xs font-semibold text-black">
            Create Story
        </div>
    </div>

    {{-- calling stories --}}
    @foreach ($stories as $story)
        <div class="min-w-[112px] max-w-32 h-full bg-gray-200 rounded-xl overflow-hidden relative cursor-pointer">
            <img src="{{ $story->media_path }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

            <div
                class="absolute top-2 left-2 w-9 h-9 rounded-full border-2 border-indigo-500 overflow-hidden shadow-md">
                <img src="{{ $story->user->dp ?: 'https://ui-avatars.com/api/?name=' . urlencode($story->user->first_name) . '&background=random' }}"
                    class="w-full h-full object-cover">
            </div>

            <div
                class="absolute bottom-2 left-2 text-white font-semibold text-xs shadow-black drop-shadow-md capitalize">
                {{ $story->user->first_name }} {{ $story->user->last_name }}
            </div>
        </div>
    @endforeach

    <style>
        /* Hide scrollbar but keep scroll functionality */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>
