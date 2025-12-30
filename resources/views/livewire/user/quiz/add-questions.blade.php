<div class="max-w-4xl mx-auto bg-white p-8 rounded-3xl border">

    <h2 class="text-xl font-extrabold text-slate-800 mb-6">
        Add Questions – {{ $quiz->title }}
    </h2>

    <form wire:submit.prevent="save" class="space-y-6">

        @foreach ($questions as $index => $q)
            <div class="border p-6 rounded-2xl space-y-4">

                <textarea wire:model.defer="questions.{{ $index }}.question" placeholder="Question {{ $index + 1 }}"
                    class="w-full rounded-xl border px-4 py-2"></textarea>

                @error('questions.' . $index . '.question')
                    <p class="text-xs text-rose-600 mt-1">
                        {{ $message }}
                    </p>
                @enderror


                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach (['A', 'B', 'C', 'D'] as $oIndex => $label)
                        <label class="flex gap-2">
                            <input type="radio" wire:model="questions.{{ $index }}.correct"
                                value="{{ $oIndex }}">


                            <input type="text"
                                wire:model.defer="questions.{{ $index }}.options.{{ $oIndex }}"
                                placeholder="Option {{ $label }}" class="w-full rounded-xl border px-3 py-2">

                            @error('questions.' . $index . '.options.' . $oIndex)
                                <p class="text-xs text-rose-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </label>
                    @endforeach
                </div>

                <button type="button" wire:click="removeQuestion({{ $index }})"
                    class="text-rose-500 text-xs font-bold">
                    Remove
                </button>

                @error('questions.' . $index . '.correct')
                    <p class="text-xs text-rose-600 mt-1">
                        Please select the correct option.
                    </p>
                @enderror

            </div>
        @endforeach

        <button type="button" wire:click="addQuestion" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl">
            <x-heroicon-o-plus class="w-4 h-4 mr-1 inline-block" />
            Add Question
        </button>

        <button class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl">
            Save Quiz
        </button>

    </form>
</div>
