<div class="">
    <div class="max-w-[1200px] mx-auto pt-6 px-4">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h2 class="text-[20px] font-bold text-[#050505]">People You May Know</h2>
        </div>

        {{-- <div class="">
            @foreach ($users as $user)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 flex flex-col">
                    <a href="{{ route('profile', ['id' => $user->id]) }}"
                        class="aspect-square overflow-hidden cursor-pointer block">
                        <img src="{{ $user->dp ? asset('storage/images/dp/' . $user->dp) : asset('images/dp.png') }}"
                            alt="{{ $user->first_name }}"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </a>

                    <div class="p-3 flex  flex-1">
                        <a href="{{ route('profile', ['id' => $user->id]) }}"
                            class="font-semibold text-[#050505] leading-tight mb-1 hover:underline ">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </a>

                        <div class="mt-auto space-y-2">
                            <div class="w-full">
                                <livewire:user.friendship-button :selectedUser="$user" :key="$user->id" />
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}


        <div class="space-y-3">
            @foreach ($users as $user)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center">

                    <a href="{{ route('profile', ['id' => $user->id]) }}" class="flex-shrink-0">
                        <img src="@if ($user->dp) {{ asset('storage/images/dp/' . $user->dp) }} @else {{ asset('storage/images/dp.png') }} @endif"
                            alt="{{ $user->first_name }}"
                            class="w-14 h-14 rounded-full object-cover border border-gray-300">
                    </a>

                    <div class="ml-4 flex-1">
                        <a href="{{ route('profile', ['id' => $user->id]) }}"
                            class="text-[16px] font-semibold text-gray-800 hover:underline capitalize">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </a>

                    </div>

                    <div class="flex-shrink-0">
                        <livewire:user.friendship-button :selectedUser="$user" :key="$user->id" />
                    </div>

                </div>
            @endforeach
        </div>


    </div>
</div>
