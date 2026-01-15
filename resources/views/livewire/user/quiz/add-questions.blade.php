{{-- Wrapper to center content --}}
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center p-4">
    
    <div class="max-w-4xl w-full space-y-6">
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800">
                        Add Questions
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Quiz: <span class="font-semibold text-indigo-600">{{ $quiz->title }}</span></p>
                </div>
                <div class="bg-indigo-50 px-4 py-2 rounded-2xl">
                    <span class="text-xs font-bold text-indigo-600 uppercase">Questions: {{ count($questions) }}</span>
                </div>
            </div>

            <form wire:submit.prevent="save" class="space-y-8">
                @foreach ($questions as $index => $q)
                    <div class="group relative border border-slate-100 bg-slate-50/30 p-6 rounded-2xl space-y-4 transition-all hover:bg-white hover:shadow-md hover:border-indigo-100">
                        
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Question #{{ $index + 1 }}</span>
                            <button type="button" wire:click="removeQuestion({{ $index }})"
                                class="text-rose-400 hover:text-rose-600 transition-colors">
                                <x-heroicon-s-trash class="w-5 h-5" />
                            </button>
                        </div>

                        <textarea wire:model.defer="questions.{{ $index }}.question" 
                            placeholder="Type your question here..."
                            class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"></textarea>

                        @error('questions.' . $index . '.question')
                            <p class="text-[10px] font-bold text-rose-500 uppercase">{{ $message }}</p>
                        @enderror

                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach (['A', 'B', 'C', 'D'] as $oIndex => $label)
                                <div class="relative">
                                    <label class="flex items-center gap-3 p-3 bg-white border border-slate-100 rounded-xl cursor-pointer hover:border-indigo-200 transition-all">
                                        <input type="radio" wire:model="questions.{{ $index }}.correct"
                                            value="{{ $oIndex }}" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                        
                                        <div class="flex-1">
                                            <p class="text-[10px] font-bold text-slate-400 uppercase">Option {{ $label }}</p>
                                            <input type="text"
                                                wire:model.defer="questions.{{ $index }}.options.{{ $oIndex }}"
                                                placeholder="Choice {{ $label }}" 
                                                class="w-full border-none p-0 text-sm focus:ring-0 font-medium text-slate-700">
                                        </div>
                                    </label>
                                    @error('questions.' . $index . '.options.' . $oIndex)
                                        <p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="button" wire:click="addQuestion" 
                        class="flex-1 px-6 py-4 bg-white border-2 border-dashed border-slate-200 text-slate-500 rounded-2xl font-bold hover:border-indigo-300 hover:text-indigo-600 transition-all flex items-center justify-center gap-2">
                        <x-heroicon-o-plus-circle class="w-5 h-5" />
                        Add Another Question
                    </button>

                    <button type="submit" wire:loading.attr="disabled"
                        class="flex-1 px-6 py-4 bg-indigo-600 text-white font-extrabold rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all disabled:opacity-50">
                        <span wire:loading.remove wire:target="save">Finalize & Publish Quiz</span>
                        <span wire:loading wire:target="save">Publishing Quiz...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>