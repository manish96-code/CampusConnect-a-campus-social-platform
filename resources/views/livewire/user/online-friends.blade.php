<div>
    <h2 class="text-sm font-semibold text-slate-600 mb-4">Online Friends</h2>

    <div class="space-y-2">
        @foreach ($friends as $friend)
            <a href="{{ route('profile', ['id' => $friend->id]) }}"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition cursor-pointer">

                <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-200">
                    <img src="@if ($friend->dp) {{ asset('storage/images/dp/' . $friend->dp) }} @else {{ asset('storage/images/dp.png') }} @endif"
                        alt="{{ $friend->first_name }}'s Profile Image" class="w-full h-full object-cover">
                </div>

                <span class="font-medium text-gray-800 capitalize">{{ $friend->first_name }}</span>

                <span class="ml-auto">
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                </span>

            </a>
        @endforeach
    </div>
</div>
