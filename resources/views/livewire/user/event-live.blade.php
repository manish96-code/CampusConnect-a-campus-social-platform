<div class="py-8" x-data="{ open: false }">
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Events</h2>

            <button @click="open = !open"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                       bg-indigo-600 text-white hover:bg-indigo-700 transition">
                <span x-show="!open">＋ Add New Event</span>
                <span x-show="open">✕ Close</span>
            </button>
        </div>

        <div class="flex flex-col gap-8">

            {{-- LEFT: FORM --}}
            <div class="bg-white shadow-lg rounded-2xl border" x-show="open" x-transition x-cloak>
                <div class="p-6 border-b rounded-t-2xl bg-gradient-to-r from-indigo-600 to-purple-600">
                    <h3 class="text-lg font-semibold text-white">Create New Event</h3>
                    <p class="text-xs text-indigo-100 mt-1">Fill the details and see live preview on the right.</p>
                </div>

                <div class="p-6">
                    @if (session('success'))
                        <div
                            class="mb-4 text-sm text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="createEvent" class="space-y-5">

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Event Title</label>
                            <input type="text" wire:model.live="title"
                                class="w-full border rounded-xl px-4 py-2 text-sm
                                          focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                placeholder="Enter event title">
                            @error('title')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                            <textarea rows="4" wire:model.live="description"
                                class="w-full border rounded-xl px-4 py-2 text-sm
                                             focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                placeholder="Describe your event..."></textarea>
                            @error('description')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date & Time --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Date & Time</label>
                            <input type="datetime-local" wire:model.live="event_date"
                                class="w-full border rounded-xl px-4 py-2 text-sm
                                          focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                            @error('event_date')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                            <input type="text" wire:model.live="location"
                                class="w-full border rounded-xl px-4 py-2 text-sm
                                          focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                                placeholder="Event location">
                            @error('location')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold
                                           hover:bg-indigo-700 transition disabled:opacity-60"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>Save Event</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="max-w-md mx-auto w-full">
                @foreach ($events as $event)
                    <div class="bg-white rounded-2xl shadow-lg border overflow-hidden relative mb-6">

                        <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
                            <div class="text-xs tracking-wide uppercase text-slate-300">
                                Event
                            </div>
                            <div class="text-right text-xs">
                                <div class="font-semibold">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                </div>
                                <div class="text-slate-400">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-3">
                            {{-- Title --}}
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ $event->title }}
                            </h2>

                            {{-- Description --}}
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $event->description ?: 'No description provided.' }}
                            </p>

                            <hr class="my-2">

                            {{-- Details --}}
                            <div class="space-y-2 text-sm">

                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-indigo-600 text-lg">📅</span>
                                    <span>
                                        <strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-indigo-600 text-lg">⏰</span>
                                    <span>
                                        <strong>Time:</strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-indigo-600 text-lg">📍</span>
                                    <span>
                                        <strong>Location:</strong>
                                        {{ $event->location ?: 'Location not set yet' }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-indigo-600 text-lg">👤</span>
                                    <span>
                                        <strong>Organized by:</strong>
                                        {{ $event->user->first_name ?? 'Unknown' }}
                                        {{ $event->user->last_name ?? '' }}
                                    </span>
                                </div>

                            </div>

                            <div class="pt-3">
                                <button
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-xl
                               font-medium shadow-sm cursor-default">
                                    View Details
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>


        </div>

    </div>
</div>
