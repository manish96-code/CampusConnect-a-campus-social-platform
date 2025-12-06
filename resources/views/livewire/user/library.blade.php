<div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 min-h-[80vh]">

    @if($showViewer && $viewerUrl)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-5xl h-[80vh] flex flex-col overflow-hidden">

            {{-- Modal header --}}
            <div class="px-4 py-3 border-b flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-slate-800 truncate">{{ $viewerTitle }}</h2>
                    <p class="text-xs text-slate-500 uppercase">{{ strtoupper($viewerExt) }} Preview</p>
                </div>
                <button wire:click="closeViewer" class="p-2 rounded-lg hover:bg-slate-100">Close
                    <i data-feather="x" class="w-4 h-4"></i>
                </button>
            </div>

            {{-- Modal body --}}
            <div class="flex-1 bg-slate-50">
                @if(in_array($viewerExt, ['jpg','jpeg','png','gif','webp']))
                    <img src="{{ $viewerUrl }}" class="w-full h-full object-contain">
                @elseif($viewerExt === 'pdf')
                    <iframe 
                        src="{{ $viewerUrl }}" 
                        class="w-full h-full" 
                        frameborder="0">
                    </iframe>
                @else
                    {{-- For doc/docx etc. use Google Docs Viewer --}}
                    <iframe
                        src="https://docs.google.com/gview?url={{ urlencode($viewerUrl) }}&embedded=true"
                        class="w-full h-full"
                        frameborder="0">
                    </iframe>
                @endif
            </div>
        </div>
    </div>
@endif


    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- <div class="hidden lg:block lg:col-span-3">
                <div class="sticky top-24">
                    <livewire:user.sidebar />
                </div>
            </div> --}}

        <div class="lg:col-span-9 space-y-6">

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Campus Library</h1>
                    <p class="text-sm text-slate-500">Share notes and resources.</p>
                </div>

                <button wire:click="toggleCreate"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition flex items-center gap-2 
                    {{ $isCreating ? 'bg-slate-200 text-slate-700' : 'bg-indigo-600 text-white shadow-md hover:bg-indigo-700' }}">
                    @if ($isCreating)
                        <i data-feather="x" class="w-4 h-4"></i> Cancel
                    @else
                        <i data-feather="upload" class="w-4 h-4"></i> Upload
                    @endif
                </button>
            </div>

            @if (session()->has('message'))
                <div
                    class="px-4 py-3 bg-emerald-100 text-emerald-700 rounded-xl flex items-center gap-2 text-sm font-bold">
                    <i data-feather="check-circle" class="w-4 h-4"></i> {{ session('message') }}
                </div>
            @endif

            @if ($isCreating)
                <div class="bg-white border border-indigo-100 rounded-2xl p-6 shadow-sm mb-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Upload Resource</h3>

                    <form wire:submit.prevent="create">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Title</label>
                                <input type="text" wire:model="title"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                @error('title')
                                    <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">File</label>
                                <input type="file" wire:model="file"
                                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <div wire:loading wire:target="file" class="text-xs text-indigo-600 mt-1 font-bold">
                                    Uploading...</div>
                                @error('file')
                                    <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-slate-900 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-slate-800 flex items-center gap-2">
                                <span wire:loading.remove wire:target="create">Save Document</span>
                                <span wire:loading wire:target="create">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="divide-y divide-slate-100">
                    @forelse($documents as $doc)
                        @php $ext = pathinfo($doc->file, PATHINFO_EXTENSION); @endphp

                        <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition">
                            <div
                                class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                                <i data-feather="{{ in_array(strtolower($ext), ['pdf', 'doc', 'docx']) ? 'file-text' : 'image' }}"
                                    class="w-5 h-5"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-slate-800 truncate capitalize">{{ $doc->title }}
                                </h4>
                                <p class="text-xs text-slate-500 mt-0.5 capitalize">
                                    {{ strtoupper($ext) }} • {{ $doc->created_at->format('M d') }} •
                                    {{ $doc->user->first_name }}
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- View button --}}
                                <button wire:click="view({{ $doc->id }})"
                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                    <i data-feather="eye" class="w-4 h-4"></i>
                                </button>

                                <a href="{{ asset('storage/' . $doc->file) }}" download
                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                    <i data-feather="download" class="w-4 h-4"></i>
                                </a>

                                @if ($doc->user_id === auth()->id())
                                    <button wire:click="delete({{ $doc->id }})" wire:confirm="Delete this file?"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-500 text-sm">
                            No documents found.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => feather.replace());
        document.addEventListener('livewire:navigated', () => feather.replace());
    </script>
    
</div>
