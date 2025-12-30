<div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 space-y-8">

    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 text-white shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Courses</h1>
                <p class="text-indigo-100 mt-1">
                    Enroll, track and manage your learning
                </p>
            </div>

            <!-- Search -->
            <div class="relative w-full md:w-72">
                <input
                    wire:model.live="search"
                    type="search"
                    placeholder="Search courses..."
                    class="w-full rounded-xl pl-11 pr-4 py-2.5 text-sm text-slate-700
                    focus:ring-2 focus:ring-white outline-none"
                >
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                </span>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex gap-3">
        <button wire:click="setFilter('my')"
            class="px-5 py-2 rounded-full text-sm font-bold transition
            {{ $filter === 'my'
                ? 'bg-indigo-600 text-white shadow'
                : 'bg-white text-slate-600 border hover:bg-slate-50' }}">
            My Courses
        </button>

        <button wire:click="setFilter('all')"
            class="px-5 py-2 rounded-full text-sm font-bold transition
            {{ $filter === 'all'
                ? 'bg-indigo-600 text-white shadow'
                : 'bg-white text-slate-600 border hover:bg-slate-50' }}">
            All Courses
        </button>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($courses as $course)

            @php
                $enrolled = $user->courses->contains('id', $course->id);
            @endphp

            <!-- Course Card -->
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm
                        hover:shadow-xl transition-all duration-300 overflow-hidden">

                <!-- Image -->
                <div class="h-40 bg-slate-100 relative overflow-hidden">
                    <img
                        src="{{ asset('storage/course/' . $course->image) }}"
                        alt="{{ $course->course_name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                    >

                    <!-- Status Badge -->
                    <span class="absolute top-4 left-4 text-[11px] font-bold px-3 py-1 rounded-full
                        {{ $enrolled
                            ? 'bg-emerald-100 text-emerald-700'
                            : 'bg-indigo-100 text-indigo-700' }}">
                        {{ $enrolled ? 'Enrolled' : 'Available' }}
                    </span>
                </div>

                <!-- Content -->
                <div class="p-6 flex flex-col justify-between h-[240px]">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 leading-snug capitalize">
                            {{ $course->course_name }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-2 line-clamp-3">
                            {{ $course->description }}
                        </p>
                    </div>

                    <div class="mt-5 flex items-center justify-between">
                        <span class="text-xs text-slate-400 flex items-center">
                            <x-heroicon-o-user class="w-4 h-4 mr-1" />
                            Admin
                        </span>

                        @if($enrolled)
                            <button
                                class="px-4 py-2 rounded-xl text-sm font-bold
                                bg-emerald-600 text-white cursor-default">
                                Enrolled
                            </button>
                        @else
                            <button
                                wire:click="enroll({{ $course->id }})"
                                class="px-4 py-2 rounded-xl text-sm font-bold
                                bg-indigo-600 hover:bg-indigo-700 text-white transition">
                                Enroll
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <p class="text-slate-500">No courses found.</p>
        @endforelse
    </div>

</div>
