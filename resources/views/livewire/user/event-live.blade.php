<div>
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-8 min-h-[90vh]">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">


            <div class="lg:col-span-10 space-y-8">

                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Campus Events</h1>
                        <p class="text-slate-500 mt-1">Discover workshops, meetups, and parties.</p>
                    </div>

                    <button wire:click="toggleCreate"
                        class="flex items-center gap-2 px-5 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-indigo-200 {{ $isCreating ? 'bg-slate-200 text-slate-600' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                        @if ($isCreating)
                            <i data-feather="x" class="w-4 h-4"></i> Cancel
                        @else
                            <i data-feather="plus" class="w-4 h-4"></i> Host Event
                        @endif
                    </button>
                </div>

                @if (session()->has('message'))
                    <div
                        class="px-4 py-3 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl flex items-center gap-2 text-sm font-bold animate-fade-in-down">
                        <i data-feather="check-circle" class="w-4 h-4"></i> {{ session('message') }}
                    </div>
                @endif

                @if ($isCreating)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-down">

                        <div
                            class="bg-white border border-indigo-100 rounded-3xl p-6 shadow-xl shadow-indigo-100/50 relative overflow-hidden">
                            <div
                                class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                            </div>

                            <h3 class="text-xl font-bold text-slate-800 mb-4">Event Details</h3>

                            <form wire:submit.prevent="createEvent">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Event
                                            Title</label>
                                        <input type="text" wire:model.live="title"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium"
                                            placeholder="e.g. Tech Fest 2025">
                                        @error('title')
                                            <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Date &
                                            Time</label>
                                        <input type="datetime-local" wire:model.live="event_date"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-slate-600">
                                        @error('event_date')
                                            <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Location</label>
                                        <input type="text" wire:model.live="location"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none"
                                            placeholder="e.g. Auditorium Hall">
                                        @error('location')
                                            <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Description</label>
                                        <textarea wire:model.live="description" rows="3"
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none resize-none"
                                            placeholder="What's happening?"></textarea>
                                        @error('description')
                                            <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <button type="submit"
                                        class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 rounded-xl font-bold text-sm transition shadow-lg flex items-center gap-2">
                                        <span wire:loading.remove wire:target="createEvent">Publish</span>
                                        <span wire:loading wire:target="createEvent">Saving...</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="hidden lg:block">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 pl-2">Live Preview
                            </p>

                            <div
                                class="bg-white rounded-3xl p-5 border border-slate-200 shadow-lg relative overflow-hidden opacity-90">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 w-16 h-16 bg-indigo-50 rounded-2xl flex flex-col items-center justify-center border border-indigo-100">
                                        <span class="text-xs font-bold text-indigo-500 uppercase">
                                            {{ $event_date ? \Carbon\Carbon::parse($event_date)->format('M') : 'DEC' }}
                                        </span>
                                        <span class="text-2xl font-extrabold text-indigo-700 leading-none">
                                            {{ $event_date ? \Carbon\Carbon::parse($event_date)->format('d') : '25' }}
                                        </span>
                                    </div>
                                    <div class="flex-1 pt-1">
                                        <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">
                                            {{ $title ?: 'Event Title' }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <div class="flex items-center gap-1">
                                                <i data-feather="clock" class="w-3 h-3"></i>
                                                {{ $event_date ? \Carbon\Carbon::parse($event_date)->format('h:i A') : '10:00 AM' }}
                                            </div>
                                            <span>•</span>
                                            <div class="flex items-center gap-1">
                                                <i data-feather="map-pin" class="w-3 h-3"></i>
                                                {{ $location ?: 'Location' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-slate-50">
                                    <p class="text-sm text-slate-600 line-clamp-3">
                                        {{ $description ?: 'Description will appear here...' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($events as $event)
                        @php $date = \Carbon\Carbon::parse($event->event_date); @endphp

                        <div
                            class="group bg-white rounded-3xl p-5 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">

                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-indigo-50 rounded-2xl flex flex-col items-center justify-center border border-indigo-100 group-hover:border-indigo-200 transition-colors">
                                    <span
                                        class="text-xs font-bold text-indigo-500 uppercase">{{ $date->format('M') }}</span>
                                    <span
                                        class="text-2xl font-extrabold text-indigo-700 leading-none">{{ $date->format('d') }}</span>
                                </div>

                                <div class="flex-1 min-w-0 pt-1">
                                    <h3
                                        class="text-lg font-bold text-slate-800 leading-tight mb-1 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                        {{ $event->title }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <span class="flex items-center gap-1"><i data-feather="clock"
                                                class="w-3 h-3"></i> {{ $date->format('h:i A') }}</span>
                                        <span>•</span>
                                        <span class="truncate">{{ Str::limit($event->location, 20) }}</span>
                                    </div>
                                </div>

                                @if ($event->user_id === auth()->id())
                                    <div class="flex items-center gap-2">
                                        <button wire:click="edit({{ $event->id }})"
                                            class="text-slate-300 hover:text-indigo-600 transition" title="Edit event">
                                            <i data-feather="edit-2" class="w-4 h-4"></i>
                                        </button>

                                        <button wire:click="delete({{ $event->id }})" wire:confirm="Cancel event?"
                                            class="text-slate-300 hover:text-rose-500 transition" title="Delete event">
                                            <i data-feather="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                @endif

                            </div>

                            <div class="mt-4 mb-4">
                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">
                                    {{ $event->description }}</p>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $event->user->dp ? asset('storage/images/dp/' . $event->user->dp) : asset('storage/images/dp.png') }}"
                                        class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm"
                                        alt="Avatar">
                                    <p class="text-xs font-medium text-slate-500 capitalize">Organized By <span
                                            class="font-bold text-slate-700">{{ $event->user->first_name }}</span></p>
                                </div>
                                {{-- <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg">View</span> --}}
                                <button wire:click="view({{ $event->id }})"
                                    class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 hover:text-indigo-700 flex items-center gap-1 transition">
                                    <i data-feather="eye" class="w-3 h-3"></i>
                                    View
                                </button>

                            </div>
                        </div>
                    @empty
                        <div
                            class="col-span-1 md:col-span-2 py-20 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                            <div
                                class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i data-feather="calendar" class="w-8 h-8 text-indigo-400"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-700">No Events Yet</h3>
                            <p class="text-slate-500 text-sm mt-1">Be the first to host an event on campus!</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>


        {{-- Show Detail --}}
        @if ($showViewModal)
            @php
                $modalDate = $viewEventDate ? \Carbon\Carbon::parse($viewEventDate) : null;
            @endphp

            <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60">
                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl mx-4 overflow-hidden animate-fade-in-down">

                    {{-- Header --}}
                    <div class="px-5 py-4 border-b flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-slate-800">
                                {{ $viewTitle }}
                            </h2>
                            @if ($modalDate)
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $modalDate->format('M d, Y') }} • {{ $modalDate->format('h:i A') }}
                                </p>
                            @endif
                        </div>
                        <button wire:click="closeViewModal" class="p-2 rounded-lg hover:bg-slate-100">
                            <i data-feather="x" class="w-4 h-4"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="px-5 py-4 space-y-4 text-sm text-slate-700">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] font-semibold text-slate-500 uppercase mb-1">Location</p>
                                <p class="text-slate-900">{{ $viewLocation }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold text-slate-500 uppercase mb-1">Organized By</p>
                                <p class="capitalize text-slate-900">{{ $viewOrganizer }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[11px] font-semibold text-slate-500 uppercase mb-1">Description</p>
                            <p class="leading-relaxed text-slate-900">
                                {{ $viewDescription ?: 'No description provided.' }}
                            </p>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-5 py-3 border-t flex justify-end">
                        <button wire:click="closeViewModal"
                            class="px-4 py-1.5 text-xs font-bold rounded-lg bg-slate-900 text-white hover:bg-slate-800">
                            Close
                        </button>
                    </div>

                </div>
            </div>
        @endif


        {{-- edit event --}}
        @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden animate-fade-in-down">

                {{-- Header --}}
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Edit Event</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Update your event details and save changes.</p>
                    </div>
                    <button wire:click="closeEditModal" class="p-2 rounded-lg hover:bg-slate-100">
                        <i data-feather="x" class="w-4 h-4"></i>
                    </button>
                </div>

                {{-- Body: form --}}
                <form wire:submit.prevent="updateEvent" class="px-6 py-5 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">
                            Event Title
                        </label>
                        <input type="text" wire:model.live="title"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                            placeholder="e.g. Tech Fest 2025">
                        @error('title')
                            <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">
                                Date & Time
                            </label>
                            <input type="datetime-local" wire:model.live="event_date"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm text-slate-600">
                            @error('event_date')
                                <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">
                                Location
                            </label>
                            <input type="text" wire:model.live="location"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm"
                                placeholder="e.g. Auditorium Hall">
                            @error('location')
                                <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">
                            Description
                        </label>
                        <textarea wire:model.live="description" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none text-sm resize-none"
                            placeholder="What's happening?"></textarea>
                        @error('description')
                            <span class="text-rose-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Footer --}}
                    <div class="pt-3 flex justify-end gap-2 border-t border-slate-100 mt-2">
                        <button type="button" wire:click="closeEditModal"
                            class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 flex items-center gap-2">
                            <span wire:loading.remove wire:target="updateEvent">Save Changes</span>
                            <span wire:loading wire:target="updateEvent">Updating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif


        {{-- <script>
        document.addEventListener('livewire:initialized', () => feather.replace());
        document.addEventListener('livewire:navigated', () => feather.replace());
    </script> --}}
        <script>
            document.addEventListener('livewire:load', () => {
                feather.replace();

                Livewire.hook('message.processed', () => {
                    feather.replace();
                });
            });
        </script>

    </div>
</div>
