<div>
    @if ($group->members->contains(auth()->id()))

        <form wire:submit.prevent="createPost"
            class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 space-y-3">

            <div class="flex gap-4">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=6366f1&color=fff"
                    class="w-10 h-10 rounded-full border">

                <textarea
                    wire:model="caption"
                    rows="2"
                    placeholder="Write something to the group..."
                    class="flex-1 resize-none bg-slate-50 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </textarea>
            </div>

            {{-- IMAGE PREVIEW --}}
            @if ($image)
                <div class="relative w-full max-w-xs">
                    <img src="{{ $image->temporaryUrl() }}"
                        class="rounded-xl border border-slate-200 shadow-sm">

                    <button type="button"
                        wire:click="$set('image', null)"
                        class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-lg hover:bg-black">
                        ✕
                    </button>
                </div>
            @endif

            @error('caption')
                <p class="text-xs text-rose-500">{{ $message }}</p>
            @enderror

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer hover:text-indigo-600">
                    <input type="file" wire:model="image" class="hidden" accept="image/*">
                    📷 Add Image
                </label>

                <button type="submit"
                    class="px-4 py-2 rounded-xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700">
                    <span wire:loading.remove wire:target="createPost">Post</span>
                    <span wire:loading wire:target="createPost">Posting...</span>
                </button>
            </div>

            @error('image')
                <p class="text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </form>

    @endif
</div>
