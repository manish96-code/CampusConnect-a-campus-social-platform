<div class="relative h-[220px] mb-6 flex gap-2 overflow-x-auto scrollbar-hide">
    <!-- Add Story Card -->
    <div class="min-w-[140px] max-w-48 h-full bg-white rounded-xl shadow overflow-hidden relative cursor-pointer group">

        {{-- Loader --}}
        <div wire:loading wire:target="media_path, createStory"
            class="absolute inset-0 z-20 bg-indigo-900/60 backdrop-blur-md flex flex-col items-center justify-center h-full">
            <x-heroicon-o-arrow-path class="w-10 h-10 text-white animate-spin" />
            <span class="text-white text-[10px] mt-2 font-bold uppercase tracking-widest text-center px-2">
                Uploading Story...
            </span>
        </div>

        {{-- Profile Background --}}
        <img src="{{ auth()->user()->dp ?: 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->first_name . ' ' . auth()->user()->last_name) . '&background=6366f1&color=fff' }}"
            alt="Profile" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

        <div class="absolute bottom-0 w-full bg-white h-12 flex justify-center items-center">
            <input type="file" wire:model="media_path" id="story_media" class="hidden">

            <label for="story_media"
                class="w-8 h-8 bg-blue-500 rounded-full border-4 border-white flex items-center justify-center -mt-8 text-white cursor-pointer hover:bg-blue-600 transition-colors">
                <x-heroicon-o-plus class="w-4 h-4" />
            </label>
        </div>

        <div class="absolute bottom-2 w-full text-center text-xs font-semibold text-black pointer-events-none">
            Create Story
        </div>
    </div>

    {{-- calling stories --}}
    @foreach ($stories as $story)
        <div wire:key="story-{{ $story->id }}"
            class="min-w-[112px] max-w-32 h-full bg-gray-200 rounded-xl overflow-hidden relative cursor-pointer">
            <img src="{{ $story->media_path }}?tr=w-200,cm-pad_resize,f-auto" loading="lazy"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

            <div
                class="absolute top-2 left-2 w-9 h-9 rounded-full border-2 border-indigo-500 overflow-hidden shadow-md">
                <img src="{{ $story->user->dp ?: 'https://ui-avatars.com/api/?name=' . urlencode($story->user->first_name) . '&background=random' }}?tr=w-50,h-50"
                    class="w-full h-full object-cover">
            </div>

            <div
                class="absolute bottom-2 left-2 text-white font-semibold text-xs shadow-black drop-shadow-md capitalize">
                {{ $story->user->first_name }}
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
