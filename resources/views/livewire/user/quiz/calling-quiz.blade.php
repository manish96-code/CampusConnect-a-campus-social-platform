<div class="space-y-6 p-5">

    {{-- <livewire:user.quiz.quiz-view /> --}}

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Quizzes</h2>
            <p class="text-sm text-slate-500">Attempt quizzes by course</p>
        </div>

        <div class="flex gap-3 w-full md:w-auto">
            <!-- SEARCH -->
            <div class="relative w-full md:w-72">
                <input type="text" wire:model.live="search" placeholder="Search quiz..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm
                           focus:ring-2 focus:ring-indigo-500">
                <x-heroicon-o-magnifying-glass
                    class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
            </div>

            <!-- ALL QUIZZES -->
            <button wire:click="$set('myQuiz', false)"
                class="px-3 py-2 text-xs font-bold rounded-lg transition
                {{ !$myQuiz ? 'bg-indigo-600 text-white' : 'border border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                All Quizzes
            </button>

            <!-- MY QUIZZES -->
            <button wire:click="$set('myQuiz', true)"
                class="px-3 py-2 text-xs font-bold rounded-lg transition
                {{ $myQuiz ? 'bg-indigo-600 text-white' : 'border border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                My Quizzes
            </button>


            <!-- COURSE FILTER -->
            <select wire:model.live="courseFilter" class="rounded-xl border border-slate-200 px-4 py-2 text-sm capitalize">
                <option value="all">All Courses</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
            </select>

            {{-- Create Quiz --}}
            <a wire:navigate href="{{ route('quiz.create') }}"
                class="flex items-center gap-2 px-4 py-2 text-sm font-bold rounded-lg transition
                {{ request()->routeIs('quiz.create')
                    ? 'bg-indigo-50 text-indigo-600'
                    : 'border border-slate-200 text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">

                <x-heroicon-o-plus-circle class="w-4 h-4" />
                Create Quiz
            </a>

        </div>
    </div>

    <!-- QUIZ GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($quizzes as $quiz)
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 flex flex-col">

                <!-- TITLE -->
                <h3 class="text-lg font-bold text-slate-800 mb-1">
                    {{ $quiz->title }}
                </h3>

                <!-- COURSE -->
                <p class="text-xs text-indigo-600 font-semibold mb-3 capitalize">
                    {{ $quiz->course->course_name ?? 'General' }}
                </p>

                <!-- DESCRIPTION -->
                <p class="text-sm text-slate-500 line-clamp-2 flex-1">
                    {{ $quiz->description ?? 'No description provided.' }}
                </p>

                <!-- META -->
                <div class="flex items-center justify-between text-xs text-slate-500 my-4">
                    <span>Marks: <strong>{{ $quiz->total_marks }}</strong></span>
                    <span class="capitalize">By {{ $quiz->user->first_name ?? 'Admin' }}</span>
                </div>

                <!-- ACTION -->
                @php
                    $attempt = $quiz->attempts->where('user_id', auth()->id())->first();
                @endphp

                <div class="pt-4 mt-4 border-t border-slate-100">

                    @if ($quiz->user_id === auth()->id())
                        {{-- MANAGE --}}
                        <a wire:navigate href="{{ route('quiz.manage', $quiz->id) }}"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200 transition">
                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                            Manage Quiz
                        </a>
                    @elseif ($attempt)
                        {{-- RESULT --}}
                        <a wire:navigate href="{{ route('quiz.result', [$quiz->id, $attempt->id]) }}"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                            <x-heroicon-o-check-circle class="w-4 h-4" />
                            View Result
                        </a>
                    @else
                        {{-- ATTEMPT --}}
                        <a wire:navigate href="{{ route('quiz.attempt', $quiz->id) }}"
                            class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition">
                            <x-heroicon-o-play class="w-4 h-4" />
                            Attempt Quiz
                        </a>
                    @endif

                </div>


            </div>

        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed">
                <h3 class="text-lg font-bold text-slate-700">No quizzes found</h3>
                <p class="text-sm text-slate-500">Try searching something else</p>
            </div>
        @endforelse
    </div>

</div>
