<div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 min-h-screen">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-9 space-y-6">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Assignments</h1>
                    <p class="text-slate-500 mt-1">View class assignments and submit work.</p>
                </div>
                
                @if (session()->has('message'))
                    <div class="px-4 py-2 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg flex items-center gap-2">
                        <i data-feather="check-circle" class="w-4 h-4"></i> {{ session('message') }}
                    </div>
                @endif

                <button wire:click="toggleCreate" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 transition active:scale-95">
                    @if($isCreating)
                        <i data-feather="x" class="w-4 h-4"></i> Close
                    @else
                        <i data-feather="plus" class="w-4 h-4"></i> New Assignment
                    @endif
                </button>
            </div>

            <div class="flex gap-2 overflow-x-auto pb-2 border-b border-slate-200">
                @foreach(['all' => 'All Tasks', 'pending' => 'Pending', 'completed' => 'Completed'] as $key => $label)
                    <button wire:click="setFilter('{{ $key }}')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap {{ $filter === $key ? 'bg-slate-800 text-white shadow-md' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-700' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            @if($isCreating)
                <div class="bg-white border border-indigo-100 rounded-2xl p-6 shadow-md mb-6 animate-fade-in-down">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-slate-800">Create New Assignment</h2>
                    </div>

                    <form wire:submit.prevent="create" class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Title</label>
                            <input type="text" wire:model="title" class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500">
                            @error('title') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Course</label>
                                <input type="text" wire:model="course" class="w-full px-4 py-2 border rounded-lg">
                                @error('course') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Due Date</label>
                                <input type="date" wire:model="due_date" class="w-full px-4 py-2 border rounded-lg">
                                @error('due_date') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Description</label>
                            <textarea wire:model="description" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Attachment</label>
                            <input type="file" wire:model="file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('file') <span class="text-rose-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-slate-900 text-white px-6 py-2 rounded-lg font-bold text-sm">
                                <span wire:loading.remove wire:target="create">Publish</span>
                                <span wire:loading wire:target="create">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($assignments as $assignment)
                    <div wire:click="showDetails({{ $assignment->id }})" 
                         class="group bg-white rounded-2xl p-5 border shadow-sm hover:shadow-md cursor-pointer relative overflow-hidden {{ $assignment->my_submission ? 'border-emerald-200' : 'border-slate-200' }}">
                        
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $assignment->my_submission ? 'bg-emerald-500' : ($assignment->due_date->isPast() ? 'bg-rose-500' : 'bg-indigo-500') }}"></div>

                        <div class="pl-4">
                            <div class="flex justify-between items-start">
                                <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">{{ $assignment->course }}</span>
                                @if($assignment->my_submission)
                                    <span class="text-emerald-600 text-xs font-bold flex items-center gap-1"><i data-feather="check" class="w-3 h-3"></i> Done</span>
                                    @elseif($assignment->due_date->isPast())
                                    <span class="text-rose-600 text-xs font-bold flex items-center gap-1"><i data-feather="alert-circle" class="w-3 h-3"></i> Overdue</span>
                                    @else
                                    <span class="text-indigo-600 text-xs font-bold flex items-center gap-1"><i data-feather="clock" class="w-3 h-3"></i> Pending</span>
                                @endif

                            </div>
                            
                            <h3 class="text-lg font-bold text-slate-800 mt-2 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $assignment->title }}</h3>
                            
                            <div class="flex items-center justify-between mt-4 text-xs font-medium text-slate-500">
                                <span class="flex items-center gap-1 {{ $assignment->due_date->isPast() && !$assignment->my_submission ? 'text-rose-600' : '' }}">
                                    <i data-feather="calendar" class="w-3 h-3"></i> {{ $assignment->due_date->format('M d') }}
                                </span>
                                <span>By {{ $assignment->user->first_name ?? 'Teacher' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-12 bg-white rounded-xl border border-dashed border-slate-300">
                        <p class="text-slate-500 text-sm">No assignments found.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    @if($selectedAssignment)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeDetails"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full p-6 relative">
                    
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">{{ $selectedAssignment->title }}</h3>
                            <p class="text-indigo-600 text-xs font-bold uppercase mt-1">{{ $selectedAssignment->course }} • Due {{ $selectedAssignment->due_date->format('F d, Y') }}</p>
                        </div>
                        <button wire:click="closeDetails" class="text-slate-400 hover:text-slate-600 bg-slate-100 p-1 rounded-full"><i data-feather="x" class="w-5 h-5"></i></button>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl text-sm text-slate-600 mb-6 border border-slate-100">
                        <h4 class="text-xs font-bold text-slate-400 uppercase mb-1">Instructions</h4>
                        {{ $selectedAssignment->description ?? 'No instructions.' }}
                        
                        @if($selectedAssignment->file)
                            <div class="mt-3 pt-3 border-t border-slate-200">
                                <a href="{{ asset('storage/'.$selectedAssignment->file) }}" target="_blank" class="text-indigo-600 text-xs font-bold hover:underline flex items-center gap-1">
                                    <i data-feather="download" class="w-3 h-3"></i> Download Attachment
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="border-t border-slate-100 pt-6">
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-4">Your Submission</h4>
                        
                        @if($selectedAssignment->my_submission)
                            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-center">
                                <p class="text-emerald-700 text-sm font-bold flex items-center justify-center gap-2">
                                    <i data-feather="check-circle" class="w-4 h-4"></i> Submitted Successfully
                                </p>
                                <p class="text-emerald-600 text-xs mt-1">
                                    On {{ \Carbon\Carbon::parse($selectedAssignment->my_submission->created_at)->format('M d, H:i') }}
                                </p>
                                @if($selectedAssignment->my_submission->file)
                                    <a href="{{ asset('storage/'.$selectedAssignment->my_submission->file) }}" target="_blank" class="text-emerald-700 text-xs underline mt-2 block">View Uploaded File</a>
                                @endif
                            </div>
                        @else
                            <form wire:submit.prevent="submitAssignment" class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase">Your Answer</label>
                                    <textarea wire:model="submission_text" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 text-sm"></textarea>
                                </div>
                                
                                <div>
                                    <label class="text-xs font-bold text-slate-500 uppercase">Attach File</label>
                                    <input type="file" wire:model="submission_file" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                    @error('submission_file') <span class="text-rose-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex justify-between items-center pt-2">
                                    @if($selectedAssignment->user_id === auth()->id())
                                        <button type="button" wire:click="delete({{ $selectedAssignment->id }})" wire:confirm="Delete task?" class="text-rose-500 text-xs font-bold uppercase hover:underline">Delete Task</button>
                                    @else
                                        <div></div>
                                    @endif
                                    
                                    <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-800 transition flex items-center gap-2">
                                        <span wire:loading.remove wire:target="submitAssignment">Submit Work</span>
                                        <span wire:loading wire:target="submitAssignment">Sending...</span>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => feather.replace());
        document.addEventListener('livewire:navigated', () => feather.replace());
    </script>
</div>