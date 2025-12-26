<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm">

        {{-- HEADER --}}
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                    Create New Quiz
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Quiz details, course & questions
                </p>
            </div>

            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center">
                <x-heroicon-o-academic-cap class="w-6 h-6 text-indigo-600" />
            </div>
        </div>

        <form wire:submit.prevent="save">

            {{-- QUIZ DETAILS --}}
            <div class="px-8 py-8 space-y-6">

                {{-- COURSE --}}
                <div>
                    <label class="text-xs font-bold text-slate-600 uppercase">
                        Course
                    </label>

                    <select wire:model="course_id"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-5 py-3 text-sm
                        focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>

                    @error('course_id')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TITLE --}}
                <div>
                    <label class="text-xs font-bold text-slate-600 uppercase">
                        Quiz Title
                    </label>
                    <input type="text" wire:model.defer="title"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-5 py-3 text-sm">
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="text-xs font-bold text-slate-600 uppercase">
                        Description
                    </label>
                    <textarea rows="3" wire:model.defer="description"
                        class="mt-2 w-full rounded-2xl border border-slate-200 px-5 py-3 text-sm resize-none"></textarea>
                </div>

                {{-- SETTINGS --}}
                <div class="grid sm:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-2xl">
                    <div>
                        <label class="text-xs font-bold text-slate-600 uppercase">
                            Total Marks
                        </label>
                        <input type="number" wire:model.defer="total_marks"
                            class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">
                    </div>
                </div>
            </div>

            {{-- QUESTIONS --}}
            <div class="px-8 pb-6 space-y-6 border-t border-slate-100">

                <div class="flex items-center justify-between pt-6">
                    <h3 class="text-lg font-bold text-slate-800">
                        Questions
                    </h3>

                    {{-- <button type="button" wire:click="addQuestion"
                        class="px-4 py-2 text-sm font-bold rounded-xl
                        bg-indigo-50 text-indigo-600 hover:bg-indigo-100">
                        + Add Question
                    </button> --}}
                </div>

                @foreach ($questions as $qIndex => $q)
                    <div class="border border-slate-200 rounded-2xl p-6 space-y-5">

                        {{-- QUESTION --}}
                        <textarea wire:model.defer="questions.{{ $qIndex }}.question" placeholder="Question {{ $qIndex + 1 }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm"></textarea>

                        {{-- OPTIONS --}}
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach (['A', 'B', 'C', 'D'] as $oIndex => $label)
                                <label class="flex items-center gap-3">
                                    <input type="radio" wire:model="questions.{{ $qIndex }}.correct"
                                        value="{{ $oIndex }}" class="text-indigo-600">
                                    <input type="text"
                                        wire:model.defer="questions.{{ $qIndex }}.options.{{ $oIndex }}"
                                        placeholder="Option {{ $label }}"
                                        class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                                </label>
                            @endforeach
                        </div>

                        <div class="flex justify-end">
                            <button type="button" wire:click="removeQuestion({{ $qIndex }})"
                                class="text-rose-500 text-xs font-bold hover:underline">
                                Remove Question
                            </button>
                        </div>
                    </div>
                @endforeach

                <button type="button" wire:click="addQuestion"
                    class="px-4 py-2 text-sm font-bold rounded-xl
                        bg-indigo-50 text-indigo-600 hover:bg-indigo-100">
                    + Add Question
                </button>

            </div>

            {{-- FOOTER --}}
            <div class="px-8 py-5 border-t bg-slate-50 rounded-b-3xl flex justify-between">

                <a href="{{ route('quiz') }}" class="px-5 py-2.5 text-sm font-bold bg-white border rounded-xl">
                    Cancel
                </a>

                <button type="submit" class="px-6 py-2.5 text-sm font-bold rounded-xl bg-indigo-600 text-white shadow">
                    Create Quiz
                </button>

            </div>
        </form>

    </div>
</div>
