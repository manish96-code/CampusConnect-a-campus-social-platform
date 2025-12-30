<div class="max-w-3xl mx-auto bg-white rounded-3xl border p-8">

    <h2 class="text-2xl font-extrabold text-slate-800 mb-6">
        Create Quiz
    </h2>

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- COURSE --}}
        <div>
            <label class="text-xs font-bold text-slate-600 uppercase">Course</label>
            <select wire:model="course_id" class="mt-2 w-full rounded-xl border px-4 py-2 capitalize">
                <option value="">Select course</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
            </select>
            @error('course_id')
                <p class="text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- TITLE --}}
        <div>
            <label class="text-xs font-bold text-slate-600 uppercase">Quiz Title</label>
            <input wire:model.defer="title" class="mt-2 w-full rounded-xl border px-4 py-2">
            @error('title')
                <p class="text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- DESCRIPTION --}}
        <div>
            <label class="text-xs font-bold text-slate-600 uppercase">Description</label>
            <textarea wire:model.defer="description" class="mt-2 w-full rounded-xl border px-4 py-2"></textarea>
            @error('description')
                <p class="text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- MARKS --}}
        {{-- <div>
            <label class="text-xs font-bold text-slate-600 uppercase">Total Marks</label>
            <input type="number" wire:model.defer="total_marks"
                class="mt-2 w-full rounded-xl border px-4 py-2">
        @error('total_marks') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
        </div> --}}

        <button class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold">
            Next
            <x-heroicon-o-arrow-right class="w-4 h-4 inline-block ml-1" />
            Add Questions
        </button>
    </form>
</div>
