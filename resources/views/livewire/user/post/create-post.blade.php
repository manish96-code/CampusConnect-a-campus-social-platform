<div>
    <div class="flex flex-col justify-center bg-gray-100">

        <div class="w-full bg-white p-6 rounded-xl shadow-md">

            {{-- <form wire:submit.prevent="createPost" class="flex flex-col space-y-4">

                <div>
                    <textarea id="caption" rows="4" wire:model.live="caption"
                        class="w-full px-4 py-3 border rounded-xl text-xl focus:ring-2 focus:ring-purple-400 focus:border-transparent outline-none resize-none"
                        placeholder="What's on your mind?"></textarea>

                    @error('caption')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 w-32">
                    <input type="file" wire:model="image" accept="image/*">
                    @if ($image)
                        <div class="mt-4">
                            <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="max-w-full h-auto rounded">
                        </div>
                    @endif
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                    class="px-5 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-all duration-200 self-end shadow-sm">
                    Create Post
                </button>

            </form>  --}}

            <form wire:submit.prevent="createPost" class="flex flex-col space-y-4">

                {{-- Caption --}}
                <div>
                    <textarea id="caption" rows="4" wire:model.live="caption"
                        class="w-full px-4 py-3 border rounded-xl text-xl focus:ring-2 focus:ring-purple-400 focus:border-transparent outline-none resize-none"
                        placeholder="What's on your mind?"></textarea>

                    @error('caption')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Add Photo Button --}}
                <div class="mb-2">
                    <label
                        class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 font-medium rounded-xl cursor-pointer hover:bg-purple-200 transition">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4l2-3h6l2 3h4v13H3V7z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>

                        Add Photo

                        <input type="file" wire:model="image" accept="image/*" class="hidden">
                    </label>

                    @error('image')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Preview --}}
                @if ($image)
                    <div class="mt-3">
                        <p class="text-gray-600 text-sm mb-1">Preview:</p>
                        <img src="{{ $image->temporaryUrl() }}" class="rounded-xl max-h-64 w-full object-cover shadow">
                    </div>
                @endif

                {{-- Submit --}}
                <button type="submit"
                    class="px-5 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition-all duration-200 self-end shadow-sm">
                    Create Post
                </button>

            </form>


        </div>

    </div>
</div>
