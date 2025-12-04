<div class="w-full">
    @if($friendshipStatus === 'self')
        <button class="w-full px-3 py-2 border rounded-md text-sm bg-slate-50 text-slate-600" disabled>You</button>
        @return
    @endif

    @if($friendshipStatus === 'not_friends')
        <button wire:click="sendFriendRequest" wire:loading.attr="disabled"
            class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm text-white bg-indigo-600 hover:bg-indigo-700">
            <span wire:loading.remove wire:target="sendFriendRequest">Connect</span>
            <span wire:loading wire:target="sendFriendRequest">Sending...</span>
        </button>

    @elseif($friendshipStatus === 'request_sent')
        <button wire:click="cancelFriendRequest" wire:loading.attr="disabled"
            class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm border bg-indigo-50 text-indigo-700">
            <span wire:loading.remove wire:target="cancelFriendRequest">Requested</span>
            <span wire:loading wire:target="cancelFriendRequest">Cancelling...</span>
        </button>

    @elseif($friendshipStatus === 'request_received')
        <div class="grid grid-cols-2 gap-2">
            <button wire:click="acceptFriendRequest" wire:loading.attr="disabled"
                class="px-3 py-2 rounded-md text-sm bg-green-600 text-white">Accept</button>
            <button wire:click="rejectFriendRequest" wire:loading.attr="disabled"
                class="px-3 py-2 rounded-md text-sm border bg-white text-slate-600">Delete</button>
        </div>

    @elseif($friendshipStatus === 'friends')
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('profile', ['id' => $selectedUser->id]) }}" class="px-3 py-2 rounded-md text-sm border bg-white text-slate-600 text-center">Profile</a>
            <button wire:click="unfriend" wire:loading.attr="disabled"
                class="px-3 py-2 rounded-md text-sm bg-rose-50 text-rose-600">Unfriend</button>
        </div>
    @endif
</div>
