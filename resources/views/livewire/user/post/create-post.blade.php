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

        <!-- Image Preview Area -->
        @if ($image)
            <div class="relative mt-3 ml-14 group">
                <div class="relative rounded-2xl overflow-hidden shadow-sm border border-slate-100 bg-slate-50">
                    <img src="{{ $image->temporaryUrl() }}" class="w-full max-h-80 object-cover object-center">
                    
                    <!-- Loading Indicator -->
                    <div wire:loading wire:target="image"
                         class="absolute inset-0 bg-white/50 backdrop-blur-sm flex items-center justify-center">
                        <x-heroicon-o-arrow-path class="w-6 h-6 text-indigo-600 animate-spin" />
                    </div>
                </div>
                
                <!-- Remove Image Button -->
                <button type="button" wire:click="$set('image', null)"
                    class="absolute top-2 right-2 p-1.5 bg-black/50 hover:bg-black/70 text-white rounded-full backdrop-blur-md transition">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
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
                <label
                    class="group flex items-center gap-2 px-3 py-2 rounded-full hover:bg-indigo-50 cursor-pointer transition-colors">
                    <div class="text-indigo-500 group-hover:scale-110 transition-transform">
                        <x-heroicon-o-photo class="w-5 h-5" />
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
                    <x-heroicon-o-arrow-path class="w-4 h-4 animate-spin text-white" />
                    Posting...
                </span>
                
                <x-heroicon-o-paper-airplane
                    wire:loading.remove
                    wire:target="createPost"
                    class="w-4 h-4" />
            </button>
        </div>
    </form>
</div>
