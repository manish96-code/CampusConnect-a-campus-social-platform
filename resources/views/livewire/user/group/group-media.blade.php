<div>
    @if ($media->count())
        <div class="grid grid-cols-3 gap-2">
            @foreach ($media as $index => $item)
                @if (is_null($limit) || $index < $limit)
                    <a href="{{ $item->image }}" target="_blank">
                        <img src="{{ $item->image }}"
                            class="aspect-square w-full rounded-lg object-cover
                               hover:opacity-90 transition">
                    </a>
                @endif
            @endforeach
        </div>
    @else
        <p class="text-xs text-slate-500 text-center py-6">
            No media shared yet
        </p>
    @endif

</div>
