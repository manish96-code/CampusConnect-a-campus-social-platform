<div class="max-w-5xl mx-auto mt-4 px-4 pb-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- LEFT: QUESTION NAVIGATION GRID (Question Numbers) --}}
        <div class="lg:col-span-1 order-2 lg:order-1">
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm sticky top-24">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Questions</h3>
                <div class="grid grid-cols-5 gap-2">
                    @foreach ($quiz->questions as $index => $q)
                        <button wire:click="goToQuestion({{ $index }})"
                            class="w-full aspect-square rounded-xl text-xs font-bold transition-all border
                            {{ $currentQuestionIndex === $index ? 'bg-indigo-600 text-white border-indigo-600 scale-110 shadow-md' : '' }}
                            {{ !isset($answers[$q->id]) && $currentQuestionIndex !== $index ? 'bg-slate-50 text-slate-400 border-slate-100' : '' }}
                            {{ isset($answers[$q->id]) && $currentQuestionIndex !== $index ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : '' }}">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                        <span class="w-3 h-3 bg-emerald-100 rounded-full"></span> Answered
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="w-3 h-3 bg-slate-100 rounded-full"></span> Unanswered
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: ACTIVE QUESTION CARD --}}
        <div class="lg:col-span-3 order-1 lg:order-2">
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

                {{-- PROGRESS BAR --}}
                <div class="w-full h-1.5 bg-slate-100">
                    <div class="h-full bg-indigo-600 transition-all duration-500"
                        style="width: {{ (($currentQuestionIndex + 1) / $quiz->questions->count()) * 100 }}%">
                    </div>
                </div>

                {{-- QUIZ INFO --}}
                <div class="px-8 py-6 border-b bg-slate-50/50 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-black text-slate-800">{{ $quiz->title }}</h2>
                        <p class="text-xs text-slate-500">Question {{ $currentQuestionIndex + 1 }} of
                            {{ $quiz->questions->count() }}</p>
                    </div>
                    @if ($submitted)
                        <span
                            class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">Completed</span>
                    @endif
                </div>

                {{-- QUESTION BODY --}}
                <div class="px-8 py-10">
                    @php $currentQuestion = $quiz->questions[$currentQuestionIndex]; @endphp

                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-slate-700 leading-relaxed">
                            {{ $currentQuestion->question }}
                        </h3>

                        <div class="grid gap-4">
                            @foreach (['A', 'B', 'C', 'D'] as $opt)
                                <label
                                    class="group flex items-center gap-4 p-4 rounded-2xl border-2 transition-all cursor-pointer
                                    {{ isset($answers[$currentQuestion->id]) && $answers[$currentQuestion->id] === $opt
                                        ? 'border-indigo-600 bg-indigo-50/50 ring-4 ring-indigo-50'
                                        : 'border-slate-100 hover:border-slate-200 hover:bg-slate-50' }}">

                                    <div
                                        class="w-10 h-10 rounded-xl flex items-center justify-center font-bold transition-all
                                        {{ isset($answers[$currentQuestion->id]) && $answers[$currentQuestion->id] === $opt
                                            ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200'
                                            : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200' }}">
                                        {{ $opt }}
                                    </div>

                                    <input type="radio" wire:model.live="answers.{{ $currentQuestion->id }}"
                                        value="{{ $opt }}" @disabled($submitted) class="hidden">

                                    <span
                                        class="text-slate-700 font-semibold">{{ $currentQuestion->{'option_' . strtolower($opt)} }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- FOOTER NAVIGATION --}}
                <div class="px-8 py-6 bg-slate-50 border-t flex justify-between items-center">
                    <div class="flex gap-3">
                        <button wire:click="previousQuestion" @disabled($currentQuestionIndex === 0)
                            class="px-5 py-2.5 rounded-xl font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 disabled:opacity-30 transition">
                            Previous
                        </button>

                        <button wire:click="nextQuestion" @disabled($currentQuestionIndex === $quiz->questions->count() - 1)
                            class="px-5 py-2.5 rounded-xl font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 disabled:opacity-30 transition">
                            Next
                        </button>
                    </div>

                    @if (!$submitted)
                        @if ($currentQuestionIndex === $quiz->questions->count() - 1)
                            <button wire:click="submitQuiz" wire:confirm="Are you sure you want to finish the quiz?"
                                class="px-8 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                                Finish Quiz
                            </button>
                        @endif
                    @else
                        <div class="text-sm font-bold text-emerald-600 flex items-center gap-2">
                            <x-heroicon-s-check-circle class="w-5 h-5" />
                            Score: {{ $attempt->score }} / {{ $quiz->questions->count() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
