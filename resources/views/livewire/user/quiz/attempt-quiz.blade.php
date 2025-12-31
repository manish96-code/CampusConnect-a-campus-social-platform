<div class="max-w-4xl mx-auto mt-8">

    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm">

        {{-- HEADER --}}
        <div class="px-8 py-6 border-b">
            <h2 class="text-2xl font-extrabold text-slate-800">
                {{ $quiz->title }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                {{ $quiz->description }}
            </p>
        </div>

        {{-- BODY --}}
        <div class="px-8 py-6 space-y-8">

            @foreach ($quiz->questions as $index => $question)
                <div class="border border-slate-200 rounded-2xl p-6">

                    <h3 class="font-bold text-slate-700 mb-4">
                        Q{{ $index + 1 }}. {{ $question->question }}
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-4">
                        @foreach (['A', 'B', 'C', 'D'] as $opt)
                            <label
                                class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer
                                {{ isset($answers[$question->id]) && $answers[$question->id] === $opt
                                    ? 'border-indigo-500 bg-indigo-50'
                                    : 'border-slate-200 hover:bg-slate-50' }}">

                                <input type="radio" wire:model="answers.{{ $question->id }}"
                                    value="{{ $opt }}" @disabled($submitted) class="text-indigo-600">

                                <span class="text-sm">
                                    {{ $question->{'option_' . strtolower($opt)} }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- SUBMIT --}}
            <div class="flex justify-between items-center pt-6 border-t">

                @if ($submitted)
                    <div class="text-lg font-bold text-emerald-600">
                        ✔ Quiz Submitted
                        <span class="text-slate-600 text-sm ml-2">
                            Score: {{ $attempt->score }} / {{ $quiz->questions->count() }}
                        </span>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row gap-4">

                        {{-- Submit Quiz (Primary) --}}
                        <button wire:click="submitQuiz" @disabled($submitted)
                            class="px-6 py-3 rounded-xl font-bold text-white
                            bg-indigo-600 hover:bg-indigo-700
                            transition
                            disabled:opacity-50 disabled:cursor-not-allowed">
                            Submit Quiz
                        </button>

                        {{-- Quit Quiz (Secondary) --}}
                        <a wire:navigate href="{{ route('quiz') }}"
                            onclick="return confirm('Are you sure you want to quit? Your progress will be lost.')"
                            class="px-6 py-3 rounded-xl font-bold text-slate-600
                            bg-slate-100 border border-slate-200
                            hover:bg-slate-200 hover:text-slate-700
                            transition text-center">
                            Quit
                        </a>

                    </div>
                @endif


            </div>

        </div>
    </div>
</div>
