<div class="space-y-6">

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

            <!-- COURSE FILTER -->
            <select wire:model="courseFilter" class="rounded-xl border border-slate-200 px-4 py-2 text-sm capitalize">
                <option value="all">All Courses</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
            </select>
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
                {{-- <div class="mt-5">
                    @if ($quiz->user_id === auth()->id())
                        <a href=""
                           class="block w-full text-center py-2.5 rounded-xl font-bold text-sm
                                  bg-slate-100 text-slate-700 hover:bg-slate-200">
                            Manage Quiz
                        </a>
                    @else
                        <a href=""
                           class="block w-full text-center py-2.5 rounded-xl font-bold text-sm
                                  bg-indigo-600 text-white hover:bg-indigo-700">
                            Attempt Quiz
                        </a>
                    @endif
                </div> --}}

                @php
                    $attempt = $quiz->attempts->where('user_id', auth()->id())->first();
                @endphp

                @if ($quiz->user_id === auth()->id())
                    {{-- MANAGE --}}
                    <button wire:click="$dispatch('openManageQuiz', { quizId: {{ $quiz->id }} })"
                        class="block w-full py-2.5 rounded-xl bg-slate-100 font-bold">
                        Manage Quiz
                    </button>
                @elseif ($attempt)
                    {{-- RESULT --}}
                    <button wire:click="$dispatch('openResultQuiz', { quizId: {{ $quiz->id }} })"
                        class="block w-full py-2.5 rounded-xl bg-emerald-600 text-white font-bold">
                        View Result
                    </button>
                    {{-- <button wire:click="$dispatch('openResultQuiz', quizId: {{ $quiz->id }})"
                        class="block w-full py-2.5 rounded-xl bg-emerald-600 text-white font-bold">
                        View Result
                    </button> --}}
                @else
                    {{-- ATTEMPT --}}
                    <button wire:click="$dispatch('openAttemptQuiz', { quizId: {{ $quiz->id }} })"
                        class="block w-full py-2.5 rounded-xl bg-indigo-600 text-white font-bold">
                        Attempt Quiz
                    </button>
                @endif


            </div>

        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-dashed">
                <h3 class="text-lg font-bold text-slate-700">No quizzes found</h3>
                <p class="text-sm text-slate-500">Try searching something else</p>
            </div>
        @endforelse
    </div>

</div>
