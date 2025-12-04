<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
    
    <form wire:submit.prevent="createPost">
        
        <!-- Top Section: Avatar & Input -->
        <div class="flex gap-4">
            <!-- User Avatar -->
            <div class="flex-shrink-0">
                <img src="@if (auth()->user()->dp) {{ asset('storage/images/dp/' . auth()->user()->dp) }} @else https://ui-avatars.com/api/?name={{ auth()->user()->first_name }}+{{ auth()->user()->last_name }}&background=6366f1&color=fff @endif" 
                     alt="User" 
                     class="w-10 h-10 rounded-full object-cover border border-slate-100">
            </div>

            <!-- Text Input -->
            <div class="flex-grow">
                <textarea id="caption" rows="2" wire:model.live="caption"
                    class="w-full bg-transparent border-none focus:ring-0 text-slate-700 text-base placeholder-slate-400 resize-none p-0 focus:outline-none"
                    placeholder="What's happening on campus, {{ auth()->user()->first_name }}?"></textarea>
                
                @error('caption')
                    <span class="text-rose-500 text-xs mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Image Preview Area (Only shows if image exists) -->
        @if ($image)
            <div class="relative mt-3 ml-14 group">
                <div class="relative rounded-2xl overflow-hidden shadow-sm border border-slate-100 bg-slate-50">
                    <img src="{{ $image->temporaryUrl() }}" class="w-full max-h-80 object-cover object-center">
                    
                    <!-- Loading Indicator while image processes -->
                    <div wire:loading wire:target="image" class="absolute inset-0 bg-white/50 backdrop-blur-sm flex items-center justify-center">
                        <svg class="animate-spin h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Remove Image Button -->
                <button type="button" wire:click="$set('image', null)" class="absolute top-2 right-2 p-1.5 bg-black/50 hover:bg-black/70 text-white rounded-full backdrop-blur-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @error('image')
            <span class="text-rose-500 text-xs mt-2 ml-14 block font-medium">{{ $message }}</span>
        @enderror

        <!-- Divider -->
        <div class="h-px bg-slate-50 mt-4 mb-3 ml-14"></div>

        <!-- Bottom Actions -->
        <div class="flex items-center justify-between ml-14">
            
            <!-- Left: Media Actions -->
            <div class="flex items-center gap-2">
                <label class="group flex items-center gap-2 px-3 py-2 rounded-full hover:bg-indigo-50 cursor-pointer transition-colors">
                    <div class="text-indigo-500 group-hover:scale-110 transition-transform">
                        <!-- Image Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-slate-500 group-hover:text-indigo-600">Photo</span>
                    <input type="file" wire:model="image" accept="image/*" class="hidden">
                </label>
            </div>

            <!-- Right: Submit Button -->
            <button type="submit" 
                class="flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-bold rounded-full hover:from-indigo-700 hover:to-purple-700 shadow-md shadow-indigo-500/20 transform hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none">
                
                <span wire:loading.remove wire:target="createPost">Post</span>
                
                <!-- Loading State -->
                <span wire:loading wire:target="createPost" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Posting...
                </span>
                
                <svg wire:loading.remove wire:target="createPost" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </div>
    </form>
</div>