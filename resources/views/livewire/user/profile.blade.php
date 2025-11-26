<div class="flex flex-1">

    <div class="w-full p-3 mt-6">
        <div class="w-8/12 ">

            <div class=" h-96 relative bg-white">

                {{-- cover image --}}
                <div class="h-full bg-gray-300">
                    <img src="@if ($selectedUser->cover) {{ asset('storage/images/cover/' . $selectedUser->cover) }} @else {{ asset('storage/images/cover.png') }} @endif"
                        alt="Cover Image" class="w-full h-full object-cover">
                </div>
                {{-- change cover button --}}
                @if ($selectedUser->id == auth()->user()->id)
                    <div
                        class="absolute right-0 top-0 p-2 bg-gradient-to-t from-black via-white/10 to-black/0 w-full h-full">
                        <form wire:submit.prevent="updateProfile" method="post" enctype="multipart/form-data"
                            class="flex">
                            <input type="file" class="hidden" wire:model="cover" id="uploadCover">
                            <label class="bg-sky-600/20 text-white rounded px-2 py-1 " for="uploadCover">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                </svg>
                            </label>
                            <button type="submit" title="Change cover Image" class="hidden"></button>

                        </form>
                    </div>
                @endif


                {{-- profile image --}}
                <div class="absolute left-24 bottom-0 transform translate-y-1/3">
                    <div class="w-32 h-32 rounded-full border-4 border-white overflow-hidden bg-gray-300">
                        <img src="@if ($selectedUser->dp) {{ asset('storage/images/dp/' . $selectedUser->dp) }} @else {{ asset('storage/images/dp.png') }} @endif"
                            alt="Profile Image" class="w-full h-full object-cover">
                    </div>
                    @if ($selectedUser->id == auth()->user()->id)
                        {{-- change profile button --}}
                        <div class="absolute right-0 bottom-0 p-1">
                            <form wire:submit.prevent="updateProfile" method="post" enctype="multipart/form-data"
                                class="flex">
                                <input type="file" class="hidden" wire:model="dp" id="uploadDp">
                                <label for="uploadDp" class="bg-sky-600/20 text-white px-2 py-1 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                                    </svg>
                                </label>
                                <button title="Change Profile Image" class="hidden"></button>
                        </div>
                    @endif

                </div>

                <div class="-mt-10 ml-60 absolute">
                    <h2 class="text-2xl font-bold text-white capitalize">
                        {{ $selectedUser->first_name }}
                        {{ $selectedUser->last_name }}
                    </h2>


                    @if ($selectedUser->id != auth()->user()->id)
                        <div class="mt-5">
                            <livewire:user.friendship-button :selectedUser="$selectedUser" />
                        </div>
                    @endif
                </div>
            </div>

            <div class="pt-20 pb-6 space-y-4 flex">
                <div class="w-4/12">

                    <p class="text-gray-700 text-sm flex items-center flex-wrap gap-2">
                        @if ($selectedUser->gender)
                            <span class="capitalize">{{ $selectedUser->gender }}</span>
                        @endif

                        @if ($selectedUser->gender && $selectedUser->dob)
                            <span class="text-gray-400">•</span>
                        @endif

                        @if ($selectedUser->dob)
                            <span>Born on {{ \Carbon\Carbon::parse($selectedUser->dob)->format('F j, Y') }}</span>
                        @endif
                    </p>

                    <div class="text-gray-700 text-sm space-y-1">
                        @if ($selectedUser->contact)
                            <p>📞 {{ $selectedUser->contact }}</p>
                        @endif

                        @if ($selectedUser->email)
                            <p>📧 {{ $selectedUser->email }}</p>
                        @endif
                    </div>

                    @if ($selectedUser->id == auth()->user()->id)
                        <div class="mt-3">
                            <a href=""
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm transition">
                                Edit Profile
                            </a>
                        </div>
                    @endif

                </div>

                <div class="w-8/12">
                    @if ($selectedUser->id == auth()->user()->id)
                        <livewire:user.post.create-post />
                    @endif

                    <livewire:user.post.calling-post :selectedUser="$selectedUser" />

                </div>

            </div>

        </div>





        <div class="w-2/12 bg-white h-screen fixed top-16 right-0 p-5">
            <livewire:user.online-friends>
        </div>


    </div>



</div>
