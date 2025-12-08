<div class="w-full">
    @if (auth()->id() !== $event->user_id)
        @if ($participationStatus === 'not_participating')
            <button wire:click="sendParticipationRequest" wire:loading.attr="disabled"
                class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm text-white bg-indigo-600 hover:bg-indigo-700">
                <span wire:loading.remove wire:target="sendParticipationRequest">
                    Request for participation
                </span>
                <span wire:loading wire:target="sendParticipationRequest">
                    Requesting...
                </span>
            </button>
        @elseif($participationStatus === 'request_sent')
            <button disabled
                class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm border bg-slate-50 text-slate-500 cursor-not-allowed">
                Request sent – waiting for approval
            </button>

            {{-- cancel request button --}}
            <button>
                <span wire:click="cancelParticipationRequest" wire:loading.attr="disabled"
                    class="text-sm text-red-600 hover:underline cursor-pointer">
                    Cancel Request
                </span>
            </button>
        @elseif($participationStatus === 'participating')
            <button wire:click="cancelParticipationRequest" wire:loading.attr="disabled"
                class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm border bg-indigo-50 text-indigo-700">
                <span wire:loading.remove wire:target="cancelParticipationRequest">
                    Cancel Participation
                </span>
                <span wire:loading wire:target="cancelParticipationRequest">
                    Cancelling...
                </span>
            </button>
        @endif
    @endif


    @if (auth()->id() === $event->user_id && $participationStatus === 'request_sent')
        {{-- Approve or Reject buttons for event creator --}}
        <div class="grid grid-cols-2 gap-2 mt-2">
            <button wire:click="approveParticipationRequest" wire:loading.attr="disabled"
                class="px-3 py-2 rounded-md text-sm bg-green-600 text-white">
                <span wire:loading.remove wire:target="approveParticipationRequest">
                    Approve Request
                </span>
                <span wire:loading wire:target="approveParticipationRequest">
                    Approving...
                </span>
            </button>
            <button wire:click="rejectParticipationRequest" wire:loading.attr="disabled"
                class="px-3 py-2 rounded-md text-sm border bg-white text-slate-600">
                <span wire:loading.remove wire:target="rejectParticipationRequest">
                    Reject Request
                </span>
                <span wire:loading wire:target="rejectParticipationRequest">
                    Rejecting...
                </span>
            </button>
        </div>
    @endif
</div>
