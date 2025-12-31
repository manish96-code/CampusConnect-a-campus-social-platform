<div x-data="{ showReview: false }" class="max-w-7xl mx-auto space-y-6 pb-4">

    {{-- RESULT VIEW --}}
    <div class="space-y-4" x-transition>

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">
                    Quiz Result
                </h2>

                <p class="text-sm text-slate-500 capitalize">
                    {{ $quiz->title }}

                    @if ($attempt->user_id !== auth()->id())
                        · Student: <strong>{{ $attempt->user->first_name }} {{ $attempt->user->last_name }}</strong>
                    @else
                        · Your Result
                    @endif
                </p>
            </div>

            <span
                class="px-4 py-1.5 rounded-full text-xs font-bold
                {{ $isPassed ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                {{ $isPassed ? 'PASSED' : 'FAILED' }}
            </span>
        </div>

        <!-- SUMMARY -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-white border rounded-2xl p-5 text-center">
                <p class="text-xs text-slate-500">Total Questions</p>
                <p class="text-2xl font-extrabold">
                    {{ $totalQuestions }}
                </p>
            </div>

            <div class="bg-white border rounded-2xl p-5 text-center">
                <p class="text-xs text-slate-500">Correct</p>
                <p class="text-2xl font-extrabold text-emerald-600">
                    {{ $correct }}
                </p>
            </div>

            <div class="bg-white border rounded-2xl p-5 text-center">
                <p class="text-xs text-slate-500">Wrong</p>
                <p class="text-2xl font-extrabold text-rose-600">
                    {{ $wrong }}
                </p>
            </div>

            <div class="bg-white border rounded-2xl p-5 text-center">
                <p class="text-xs text-slate-500">Score</p>
                <p class="text-2xl font-extrabold text-indigo-600">
                    {{ $scorePercentage }}%
                </p>
            </div>

        </div>

        <!-- PROGRESS -->
        <div class="bg-white border rounded-2xl p-6">
            <div class="flex justify-between text-xs font-semibold text-slate-600 mb-2">
                <span>Performance</span>
                <span>{{ $scorePercentage }}%</span>
            </div>

            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                <div class="h-full transition-all duration-700 rounded-full
                    {{ $isPassed ? 'bg-emerald-500' : 'bg-rose-500' }}"
                    style="width: {{ $scorePercentage }}%">
                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="flex flex-col md:flex-row gap-4">

            <button @click="showReview = !showReview"
                class="flex-1 py-3 rounded-xl bg-slate-200 font-bold hover:bg-slate-300">

                <span x-show="!showReview" x-cloak>
                    Review Answers
                </span>

                <span x-show="showReview" x-cloak>
                    Close Review
                </span>
            </button>


            <a wire:navigate href="{{ route('quiz') }}"
                class="flex-1 py-3 rounded-xl bg-indigo-600 text-white font-bold text-center hover:bg-indigo-700">
                Back to Quizzes
            </a>
        </div>
    </div>

    {{-- REVIEW ANSWERS --}}
    <div x-show="showReview" x-transition>

        <!-- HEADER -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">
                    Review Answers
                </h2>
                <p class="text-sm text-slate-500">
                    {{ $quiz->title }}
                </p>
            </div>

            <button @click="showReview = false"
                class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm font-bold">
                Close
            </button>
        </div>

        <!-- QUESTIONS -->
        @foreach ($quiz->questions as $index => $question)
            @php
                $answer = $attempt->answers->where('quiz_question_id', $question->id)->first();

                $selected = $answer?->selected_option;
                $correct = $question->correct_option;
            @endphp

            <div class="bg-white border rounded-2xl p-6 space-y-4 mt-4">

                <!-- QUESTION -->
                <h4 class="font-bold text-slate-800">
                    Q{{ $index + 1 }}. {{ $question->question }}
                </h4>

                <!-- OPTIONS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    {{-- @foreach (['A', 'B', 'C', 'D'] as $opt)
                        @php
                            $text = $question->{'option_' . strtolower($opt)};
                            $isCorrect = $opt === $correct;
                            $isSelected = $opt === $selected;
                        @endphp

                        <div
                            class="p-3 rounded-xl border text-sm font-medium
                            {{ $isCorrect
                                ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                                : ($isSelected
                                    ? 'border-rose-500 bg-rose-50 text-rose-700'
                                    : 'border-slate-200 bg-slate-50') }}">
                            <strong>{{ $opt }}.</strong> {{ $text }}

                            @if ($isCorrect && $isSelected)
                                <span class="ml-2 text-xs font-bold text-emerald-700">
                                    (Your Answer · Correct)
                                </span>
                            @elseif ($isCorrect)
                                <span class="ml-2 text-xs font-bold text-emerald-700">
                                    (Correct Answer)
                                </span>
                            @elseif ($isSelected)
                                <span class="ml-2 text-xs font-bold text-rose-700">
                                    (Your Answer)
                                </span>
                            @endif

                        </div>
                    @endforeach --}}

                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                        @php
                            $text = $question->{'option_' . strtolower($opt)};
                            $isCorrect = $opt === $correct;
                            $isSelected = $opt === $selected;

                            // seen by user
                            $isOwnResult = $attempt->user_id === auth()->id();

                            // seen by quiz admin/creater
                            $userResult = $isOwnResult ? 'Your' : 'Their';
                        @endphp

                        <div
                            class="p-3 rounded-xl border text-sm font-medium
                            {{ $isCorrect
                                ? 'border-emerald-500 bg-emerald-50 text-emerald-700'
                                : ($isSelected
                                    ? 'border-rose-500 bg-rose-50 text-rose-700'
                                    : 'border-slate-200 bg-slate-50') }}">

                            <strong>{{ $opt }}.</strong> {{ $text }}

                            @if ($isCorrect && $isSelected)
                                <span class="ml-2 text-xs font-bold text-emerald-700">
                                    ({{ $userResult }} Answer · Correct)
                                </span>
                            @elseif ($isCorrect)
                                <span class="ml-2 text-xs font-bold text-emerald-700">
                                    (Correct Answer)
                                </span>
                            @elseif ($isSelected)
                                <span class="ml-2 text-xs font-bold text-rose-700">
                                    ({{ $userResult }} Answer)
                                </span>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach
    </div>

</div>
