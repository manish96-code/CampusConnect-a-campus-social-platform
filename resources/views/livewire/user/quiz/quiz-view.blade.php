<div class="flex bg-white border rounded-xl p-1 mb-6 w-56">

    {{-- All Quizzes --}}
    <a wire:navigate href="{{ route('quiz') }}"
       class="px-4 py-2 text-sm font-bold rounded-lg transition
       {{ request()->routeIs('quiz') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }}">
        All Quizzes
    </a>

    {{-- Create Quiz --}}
    <a wire:navigate href="{{ route('quiz.create') }}"
       class="px-4 py-2 text-sm font-bold rounded-lg transition
       {{ request()->routeIs('quiz.create') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }}">
        Create Quiz
    </a>

</div>
