<div class="max-w-7xl mx-auto space-y-6" x-data="{ editingQuiz: false, adding: false }">

    <livewire:user.quiz.quiz-view />


    <!-- ================= HEADER ================= -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">
                Manage Quiz
            </h2>
            <p class="text-sm text-slate-500 capitalize">
                {{ $quiz->title }}
            </p>
        </div>

        <div class="flex gap-3">
            <a wire:navigate href="{{ route('quiz') }}"
                class="flex-1 py-2 px-3 rounded-xl bg-slate-200 font-bold text-sm text-center hover:bg-slate-300">
                Back to Quizzes
            </a>

            <button @click="editingQuiz = !editingQuiz"
                class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold">
                Edit Quiz
            </button>

            <button wire:click="deleteQuiz" wire:confirm="Are you sure you want to delete this quiz?"
                class="px-4 py-2 rounded-xl bg-rose-600 text-white text-sm font-bold">
                Delete Quiz
            </button>
        </div>
    </div>


    <!-- ================= QUIZ DETAILS ================= -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white border rounded-2xl p-5">
            <p class="text-xs text-slate-500">Course</p>
            <p class="font-bold text-slate-800 capitalize">
                {{ $quiz->course->course_name ?? 'General' }}
            </p>
        </div>

        <div class="bg-white border rounded-2xl p-5">
            <p class="text-xs text-slate-500">Total Questions</p>
            <p class="font-bold text-slate-800">
                {{ $quiz->total_marks }}
            </p>
        </div>

        <div class="bg-white border rounded-2xl p-5">
            <p class="text-xs text-slate-500">Status</p>
            <span
                class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-bold
                {{ $quiz->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                {{ $quiz->is_published ? 'Published' : 'Draft' }}
            </span>
        </div>

        <div class="bg-white border rounded-2xl p-5">
            <p class="text-xs text-slate-500">Attempts</p>
            <p class="font-bold text-slate-800">
                {{ $quiz->attempts->count() }}
            </p>
        </div>

    </div>



    <!-- ================= EDIT QUESTIONS ================= -->
    <div x-show="editingQuiz" x-transition class="bg-white border rounded-2xl overflow-hidden mt-6">

        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">
                Edit Questions
            </h3>

            <div class="flex gap-2">
                <button x-show="!adding" @click="adding = true"
                    class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-bold">
                    + Add Question
                </button>

                <button wire:click="updateQuiz" wire:loading.attr="disabled"
                    class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold flex items-center gap-2">
                    <span wire:loading.remove wire:target="updateQuiz">Save Changes</span>
                    <span wire:loading wire:target="updateQuiz">Saving...</span>
                </button>

                <button @click="editingQuiz = false; adding = false"
                    class="px-4 py-2 rounded-xl bg-slate-200 text-sm font-bold">
                    Cancel
                </button>
            </div>
        </div>

        <div class="p-6 space-y-6">

            @foreach ($questions as $index => $q)
                <div class="border rounded-2xl p-5 space-y-4">

                    <!-- QUESTION HEADER -->
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-slate-700">
                            Question {{ $index + 1 }}
                        </h4>

                        <button wire:click="deleteQuestion({{ $q['id'] }})"
                            wire:confirm="Are you sure you want to delete this question?"
                            class="text-rose-600 text-xs font-bold hover:underline">
                            Delete
                        </button>
                    </div>

                    <!-- QUESTION -->
                    <textarea wire:model.defer="questions.{{ $index }}.question" class="w-full rounded-xl border px-4 py-2"
                        placeholder="Question {{ $index + 1 }}">
                    </textarea>

                    <!-- OPTIONS -->
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach (['A', 'B', 'C', 'D'] as $oIndex => $label)
                            <label class="flex gap-2 items-center">
                                <input type="radio" wire:model="questions.{{ $index }}.correct"
                                    value="{{ $oIndex }}">

                                <input type="text"
                                    wire:model.defer="questions.{{ $index }}.options.{{ $oIndex }}"
                                    class="w-full rounded-xl border px-3 py-2"
                                    placeholder="Option {{ $label }}">
                            </label>
                        @endforeach
                    </div>

                </div>
            @endforeach


        </div>

    </div>

    <!-- ADD QUESTION FORM -->
    <div x-show="adding" x-transition class="border rounded-2xl p-5 bg-slate-50 mb-6 space-y-4">

        <h4 class="font-bold text-slate-700">
            New Question
        </h4>

        <textarea wire:model.defer="newQuestion.question" class="w-full rounded-xl border px-4 py-2"
            placeholder="Enter question">
        </textarea>

        <div class="grid sm:grid-cols-2 gap-3">
            @foreach (['A', 'B', 'C', 'D'] as $i => $label)
                <label class="flex gap-2 items-center">
                    <input type="radio" wire:model="newQuestion.correct" value="{{ $i }}">

                    <input type="text" wire:model.defer="newQuestion.options.{{ $i }}"
                        class="w-full rounded-xl border px-3 py-2" placeholder="Option {{ $label }}">
                </label>
            @endforeach
        </div>

        <div class="flex gap-3">
            <button wire:click="addNewQuestion" @click="adding = false"
                class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-bold">
                Save
            </button>

            <button @click="adding = false" class="px-4 py-2 rounded-xl bg-slate-200 text-sm font-bold">
                Cancel
            </button>
        </div>

    </div>


    <!-- ================= USER ATTEMPTS ================= -->
    <div class="bg-white border rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-slate-800">
                Student Submissions
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-6 py-3 text-left">Student</th>
                        <th class="px-6 py-3 text-left">Score</th>
                        <th class="px-6 py-3 text-left">Percentage</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($quiz->attempts as $attempt)
                        @php
                            $percentage = round(($attempt->score / max($quiz->total_marks, 1)) * 100);
                        @endphp

                        <tr>
                            <td class="px-6 py-3 font-medium capitalize">
                                {{ $attempt->user->first_name . ' ' . $attempt->user->last_name }}
                            </td>

                            <td class="px-6 py-3">
                                {{ $attempt->score }} / {{ $quiz->total_marks }}
                            </td>

                            <td class="px-6 py-3">
                                {{ $percentage }}%
                            </td>

                            <td class="px-6 py-3">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $percentage >= 40 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $percentage >= 40 ? 'Pass' : 'Fail' }}
                                </span>
                            </td>

                            <td class="px-6 py-3">
                                <a wire:navigate href="{{ route('quiz.result', [$quiz->id, $attempt->id]) }}"
                                    class="inline-flex items-center gap-1.5 text-indigo-600 font-bold hover:text-indigo-800 transition">
                                    <x-heroicon-o-eye class="w-4 h-4" />
                                    View
                                </a>
                            </td>


                        </tr>

                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                No student has attempted this quiz yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
