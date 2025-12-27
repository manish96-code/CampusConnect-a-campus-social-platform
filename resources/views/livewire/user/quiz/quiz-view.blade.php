<div class="max-w-7xl mx-auto mt-8 px-4">

    {{-- HEADER --}}
    <div class="mb-6 flex justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Quiz Hub</h1>
            <p class="text-sm text-slate-500">Create or attempt quizzes</p>
        </div>

        <div class="flex bg-white border rounded-xl p-1">
            <button
                wire:click="$set('tab','list')"
                class="px-4 py-2 text-sm font-bold rounded-lg
                {{ $tab === 'list' ? 'bg-indigo-50 text-indigo-600' : '' }}">
                All Quizzes
            </button>

            <button
                wire:click="$set('tab','create')"
                class="px-4 py-2 text-sm font-bold rounded-lg
                {{ $tab === 'create' ? 'bg-indigo-50 text-indigo-600' : '' }}">
                Create Quiz
            </button>
        </div>
    </div>

    {{-- CONTENT --}}
    @if($tab === 'list')
        <livewire:user.quiz.calling-quiz />
    @endif

    @if($tab === 'create')
        <livewire:user.quiz.create-quiz />
    @endif

    @if($tab === 'questions' && $quizId)
        <livewire:user.quiz.add-questions :quizId="$quizId" />
    @endif

    @if($tab === 'attempt' && $quizId)
        <livewire:user.quiz.attempt-quiz :quizId="$quizId" />
    @endif

    @if($tab === 'result' && $quizId)
        <livewire:user.quiz.quiz-result :quizId="$quizId" />
    @endif

    @if($tab === 'manage' && $quizId)
        <livewire:user.quiz.manage-quiz :quizId="$quizId" />
    @endif

</div>
