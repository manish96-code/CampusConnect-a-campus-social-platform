<div>
    @if ($group->members()->where('users.id', auth()->id())->wherePivot('status', 'approved')->exists())

        <form wire:submit.prevent="createPost"
            class="bg-white border border-slate-200 rounded-2xl p-3 shadow-sm space-y-2">

            {{-- INPUT ROW --}}
            <div class="flex items-end gap-3">

                {{-- Avatar --}}
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=6366f1&color=fff"
                    class="w-9 h-9 rounded-full border flex-shrink-0">

                <div class="flex-1">
                    <input type="text" wire:model.defer="caption" placeholder="Type a message…"
                        oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                        class="w-full bg-slate-100 rounded-2xl px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-indigo-500">

                </div>

                {{-- Image Upload --}}
                <label class="cursor-pointer text-slate-400 hover:text-indigo-600 transition">
                    <input type="file" wire:model="image" class="hidden" accept="image/*">
                    📎
                </label>

                {{-- Send Button --}}
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white p-2.5 rounded-full
                               flex items-center justify-center transition disabled:opacity-50"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="createPost">➤</span>
                    <span wire:loading wire:target="createPost">…</span>
                </button>

            </div>

            {{-- IMAGE PREVIEW --}}
            @if ($image)
                <div class="relative mt-2 max-w-xs">
                    <img src="{{ $image->temporaryUrl() }}" class="rounded-xl border border-slate-200 shadow-sm">

                    <button type="button" wire:click="$set('image', null)"
                        class="absolute top-2 right-2 bg-black/60 text-white text-xs
                                   px-2 py-1 rounded-full hover:bg-black">
                        ✕
                    </button>
                </div>
            @endif

            {{-- ERRORS --}}
            @error('caption')
                <p class="text-xs text-rose-500">{{ $message }}</p>
            @enderror

            @error('image')
                <p class="text-xs text-rose-500">{{ $message }}</p>
            @enderror

        </form>

    @endif
</div>
