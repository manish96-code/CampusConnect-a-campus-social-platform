<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Course Management</h1>
            <p class="text-slate-500 mt-1">Add, edit, or remove courses available for students.</p>
        </div>
        <button wire:click="openModal"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
            <x-heroicon-o-plus class="w-5 h-5" />
            Add New Course
        </button>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group">
                <div class="h-40 bg-slate-100 relative">
                    <img src="{{ $course->image }}" class="w-full h-full object-cover">
                    <div
                        class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                        <button wire:click="edit({{ $course->id }})"
                            class="p-2 bg-white rounded-lg text-indigo-600 shadow-lg hover:scale-110 transition">
                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                        </button>
                        <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                            wire:click="delete({{ $course->id }})"
                            class="p-2 bg-white rounded-lg text-rose-600 shadow-lg hover:scale-110 transition">
                            <x-heroicon-o-trash class="w-5 h-5" />
                        </button>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-800 text-lg truncate">{{ $course->course_name }}</h3>
                    <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ $course->description }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" wire:click="closeModal"></div>

            <!-- Modal Content -->
            <div
                class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg relative z-10 overflow-hidden border border-slate-100">
                <div class="px-8 py-6 bg-indigo-600 text-white flex items-center justify-between">
                    <h2 class="text-xl font-bold">{{ $isEdit ? 'Edit Course' : 'Add New Course' }}</h2>
                    <button wire:click="closeModal" class="text-indigo-100 hover:text-white">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </div>

                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="p-8 space-y-5">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Course Name</label>
                        <input type="text" wire:model="course_name"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('course_name') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Description</label>
                        <textarea wire:model="description" rows="3"
                            class="w-full bg-slate-50 border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                        @error('description') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 ml-1">Course Image</label>
                        <input type="file" wire:model="image"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('image') <span class="text-xs text-rose-500 ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" wire:click="closeModal"
                            class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-2xl transition">Cancel</button>
                        <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-2xl shadow-lg shadow-indigo-200 transition">
                            <span wire:loading.remove>{{ $isEdit ? 'Update' : 'Save' }} Course</span>
                            <span wire:loading class="flex items-center justify-center gap-2">
                                <x-heroicon-o-arrow-path class="w-5 h-5 animate-spin" />
                                Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>