<div class="max-w-7xl mx-auto mt-8 px-4" x-data="{ tab: 'list' }">

    {{-- PAGE HEADER --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">
                Quiz Hub
            </h1>
            <p class="text-sm text-slate-500">
                Create quizzes or attempt available quizzes
            </p>
        </div>

        {{-- TAB SWITCH --}}
        <div class="flex bg-white border border-slate-200 rounded-xl p-1">
            <button
                @click="tab='list'"
                class="px-4 py-2 text-sm font-bold rounded-lg transition"
                :class="tab === 'list'
                    ? 'bg-indigo-50 text-indigo-600'
                    : 'text-slate-500 hover:text-indigo-600'">
                All Quizzes
            </button>

            <button
                @click="tab='create'"
                class="px-4 py-2 text-sm font-bold rounded-lg transition"
                :class="tab === 'create'
                    ? 'bg-indigo-50 text-indigo-600'
                    : 'text-slate-500 hover:text-indigo-600'">
                Create Quiz
            </button>
        </div>
    </div>

    {{-- TAB CONTENT --}}
    <div class="mt-6">

        {{-- ALL QUIZZES --}}
        <div x-show="tab === 'list'" x-transition>
            <livewire:user.quiz.calling-quiz />
        </div>

        {{-- CREATE QUIZ --}}
        <div x-show="tab === 'create'" x-transition>
            <livewire:user.quiz.create-quiz />
        </div>

    </div>

</div>
