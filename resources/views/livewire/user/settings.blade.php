<div class="max-w-5xl mx-auto p-6 space-y-6">

    <!-- HEADER -->
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800">Settings</h2>
        <p class="text-sm text-slate-500">
            Manage your account and application features
        </p>
    </div>

    <!-- SETTINGS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- PROFILE --}}
        <a wire:navigate href="{{ route('profile') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                    <x-heroicon-o-user class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600">
                        Profile
                    </h3>
                    <p class="text-sm text-slate-500">
                        Edit personal information
                    </p>
                </div>
            </div>
        </a>

        {{-- GROUPS --}}
        <a wire:navigate href="{{ route('group') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                    <x-heroicon-o-user-group class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-emerald-600">
                        Groups
                    </h3>
                    <p class="text-sm text-slate-500">
                        Manage and edit groups
                    </p>
                </div>
            </div>
        </a>

        {{-- QUIZ --}}
        <a wire:navigate href="{{ route('quiz') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                    <x-heroicon-o-clipboard-document-check class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-purple-600">
                        Quizzes
                    </h3>
                    <p class="text-sm text-slate-500">
                        Create and manage quizzes
                    </p>
                </div>
            </div>
        </a>

        {{-- ASSIGNMENTS --}}
        <a wire:navigate href="{{ route('assignment') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                    <x-heroicon-o-document-text class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-rose-600">
                        Assignments
                    </h3>
                    <p class="text-sm text-slate-500">
                        View and submit assignments
                    </p>
                </div>
            </div>
        </a>

        {{-- LIBRARY --}}
        <a wire:navigate href="{{ route('library') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                    <x-heroicon-o-book-open class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-amber-600">
                        Library
                    </h3>
                    <p class="text-sm text-slate-500">
                        Study materials & notes
                    </p>
                </div>
            </div>
        </a>

        {{-- COURSES --}}
        <a wire:navigate href="{{ route('courses') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-sky-50 text-sky-600 rounded-xl">
                    <x-heroicon-o-academic-cap class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-sky-600">
                        Courses
                    </h3>
                    <p class="text-sm text-slate-500">
                        Enrolled & available courses
                    </p>
                </div>
            </div>
        </a>

        {{-- EVENTS --}}
        <a wire:navigate href="{{ route('events') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-lime-50 text-lime-600 rounded-xl">
                    <x-heroicon-o-calendar-days class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-lime-600">
                        Events
                    </h3>
                    <p class="text-sm text-slate-500">
                        Campus events & activities
                    </p>
                </div>
            </div>
        </a>

        {{-- CLASSMATES --}}
        <a wire:navigate href="{{ route('find-friends') }}"
            class="group bg-white border rounded-2xl p-5 hover:border-indigo-500 hover:shadow transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-cyan-50 text-cyan-600 rounded-xl">
                    <x-heroicon-o-users class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 group-hover:text-cyan-600">
                        Classmates
                    </h3>
                    <p class="text-sm text-slate-500">
                        Find & connect with classmates
                    </p>
                </div>
            </div>
        </a>

    </div>
</div>
