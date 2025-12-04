<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Assignments</h1>
            <p class="text-sm text-slate-500">Manage and submit your assignments.</p>
        </div>

        <div class="flex items-center gap-3">
            @if (session()->has('message'))
                <div class="text-sm text-emerald-700 bg-emerald-50 px-3 py-1 rounded-md">
                    {{ session('message') }}
                </div>
            @endif

            <button wire:click="toggleCreate"
                class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg shadow">
                <i data-feather="plus" class="w-4 h-4"></i>
                {{ $isCreating ? 'Close' : 'New Assignment' }}
            </button>
        </div>
    </div>

    <!-- CREATE FORM (Hidden Until Click) -->
    @if($isCreating)
    <div class="bg-white border rounded-lg p-5 shadow-sm mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Create New Assignment</h2>

        <form wire:submit.prevent="create" class="space-y-4">

            <!-- Title -->
            <div>
                <label class="text-xs text-slate-600">Title</label>
                <input type="text" wire:model.defer="title"
                    class="mt-1 w-full px-3 py-2 border rounded-md focus:ring-indigo-500 focus:ring-1">
                @error('title') <p class="text-rose-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <!-- Course & Due -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-slate-600">Course</label>
                    <input type="text" wire:model.defer="course"
                        class="mt-1 w-full px-3 py-2 border rounded-md">
                    @error('course') <p class="text-rose-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs text-slate-600">Due Date</label>
                    <input type="date" wire:model.defer="due_date"
                        class="mt-1 w-full px-3 py-2 border rounded-md">
                    @error('due_date') <p class="text-rose-500 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="text-xs text-slate-600">Description</label>
                <textarea wire:model.defer="description" rows="3"
                    class="mt-1 w-full px-3 py-2 border rounded-md"></textarea>
                @error('description') <p class="text-rose-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <!-- File -->
            <div>
                <label class="text-xs text-slate-600">Attach File (Optional)</label>
                <input type="file" wire:model="file"
                    class="mt-1 block w-full text-sm text-slate-700">
                @if($file)
                    <p class="text-xs text-emerald-600 mt-1">{{ $file->getClientOriginalName() }}</p>
                @endif
                @error('file') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" wire:click="toggleCreate"
                    class="px-4 py-2 border rounded-md">Cancel</button>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">
                    Save Assignment
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- ASSIGNMENTS LIST -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($assignments as $assignment)
        <div class="bg-white border rounded-lg p-5 shadow-sm">

            <!-- Assigned By -->
            <div class="flex items-center gap-3">
                <img src="{{ $assignment->user && $assignment->user->dp
                    ? asset('storage/images/dp/'.$assignment->user->dp)
                    : 'https://ui-avatars.com/api/?name='.urlencode($assignment->user->first_name ?? 'User') }}"
                    class="w-10 h-10 rounded-full object-cover">

                <div>
                    <p class="text-sm font-medium text-slate-800">
                        {{ $assignment->user->first_name ?? 'Unknown' }}
                    </p>
                    <p class="text-xs text-slate-400">{{ $assignment->user->email ?? '' }}</p>
                </div>
            </div>

            <!-- Title -->
            <h3 class="text-lg font-bold mt-3">{{ $assignment->title }}</h3>

            <!-- Course & Due -->
            <p class="text-sm mt-1 text-slate-600">
                Course: <b>{{ $assignment->course }}</b>
            </p>
            <p class="text-sm text-slate-600">
                Due: <b>{{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y') }}</b>
            </p>

            <!-- Status -->
            <div class="mt-2">
                @if($assignment->status === 'completed')
                    <span class="px-2 py-1 text-xs bg-emerald-100 text-emerald-700 rounded-md">Completed</span>
                @elseif(\Carbon\Carbon::parse($assignment->due_date)->isPast())
                    <span class="px-2 py-1 text-xs bg-rose-100 text-rose-700 rounded-md">Overdue</span>
                @else
                    <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-700 rounded-md">Pending</span>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-4 flex justify-end">
                <button wire:click="showDetails({{ $assignment->id }})"
                    class="text-indigo-600 text-sm font-semibold hover:underline">
                    View / Submit →
                </button>
            </div>

        </div>
        @empty
        <div class="col-span-2 text-center py-10 text-slate-500 bg-white border rounded-lg">
            No assignments found.
        </div>
        @endforelse
    </div>

    @if($isSubmitting && $selectedAssignment)
    <div class="mt-8 bg-white border rounded-lg p-6 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900">{{ $selectedAssignment->title }}</h3>
                <p class="text-xs text-slate-500">{{ $selectedAssignment->course }} • Due: {{ \Carbon\Carbon::parse($selectedAssignment->due_date)->format('d M Y') }}</p>
            </div>

            <div class="text-right">
                <button wire:click="closeDetails" class="text-sm text-slate-500 hover:underline">Close</button>
            </div>
        </div>

        <hr class="my-4">

        @if($selectedAssignment->status === 'completed' || $selectedAssignment->submission_file || $selectedAssignment->submission_text)
            <div class="bg-emerald-50 border border-emerald-100 rounded-md p-3 mb-4">
                <p class="text-sm font-semibold text-emerald-800 mb-1">Existing submission</p>
                @if(!empty($selectedAssignment->submission_text))
                    <div class="text-sm text-slate-700 mb-2 whitespace-pre-wrap">
                        {{ $selectedAssignment->submission_text }}
                    </div>
                @endif

                @if(!empty($selectedAssignment->submission_file))
                    <div class="text-sm">
                        <a href="{{ Storage::url($selectedAssignment->submission_file) }}" target="_blank" class="text-indigo-600 hover:underline">
                            View submitted file
                        </a>
                    </div>
                @endif
            </div>
            <p class="text-xs text-slate-500 mb-4">You may update your submission below (it will overwrite the previous one).</p>
        @endif

        <form wire:submit.prevent="submitAssignment" class="space-y-4">
            <div>
                <label class="text-xs font-medium text-slate-600 block mb-1">Text response (optional)</label>
                <textarea wire:model.defer="submission_text" rows="4" class="w-full px-3 py-2 border rounded-md"></textarea>
                @error('submission_text') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-medium text-slate-600 block mb-1">Attach file </label>
                <input type="file" wire:model="submission_file" class="block w-full text-sm">
                @if($submission_file)
                    <p class="text-xs text-emerald-600 mt-1">{{ $submission_file->getClientOriginalName() }}</p>
                @endif
                @error('submission_file') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                <div wire:loading wire:target="submission_file" class="text-xs text-slate-500 mt-2">Uploading file…</div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" wire:click="closeDetails" class="px-3 py-2 border rounded-md text-sm">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                    Submit Assignment
                </button>
            </div>
        </form>
    </div>
    @endif

</div>

<script>
    document.addEventListener('livewire:load', function () {
        if (typeof feather !== 'undefined') feather.replace();
    });
</script>
