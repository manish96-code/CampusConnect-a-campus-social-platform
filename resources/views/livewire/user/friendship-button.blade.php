<div>
    @if($friendshipStatus === 'not_friends')
        <button wire:click="sendFriendRequest" class="w-full bg-[#e7f3ff] hover:bg-[#dbe7f2] text-[#1877f2] font-semibold px-4 py-2 rounded-md text-[15px] transition flex items-center justify-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" /></svg>
            Add Friend
        </button>
    @elseif($friendshipStatus === 'request_sent')
        <button wire:click="cancelFriendRequest" class="w-full bg-[#e4e6eb] hover:bg-[#d8dadf] text-black font-semibold px-4 py-2 rounded-md text-[15px] transition whitespace-nowrap">
            Cancel Request
        </button>
    @elseif($friendshipStatus === 'request_received')
        <div class="flex gap-2 w-full">
            <button wire:click="acceptFriendRequest" class="w-full bg-[#1877f2] hover:bg-[#166fe5] text-white font-semibold px-4 py-2 rounded-md text-[15px] transition whitespace-nowrap">
                Confirm
            </button>
            <button wire:click="rejectFriendRequest" class="w-full bg-[#e4e6eb] hover:bg-[#d8dadf] text-black font-semibold px-4 py-2 rounded-md text-[15px] transition whitespace-nowrap">
                Delete
            </button>   
        </div>
    @elseif($friendshipStatus === 'friends')
    <div class="flex gap-2 w-full">
        <button  class="w-full bg-[#e4e6eb] hover:bg-[#d8dadf] text-black font-semibold px-4 py-2 rounded-md text-[15px] transition flex items-center justify-center gap-2 whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 192C96 130.1 146.1 80 208 80C269.9 80 320 130.1 320 192C320 253.9 269.9 304 208 304C146.1 304 96 253.9 96 192zM32 528C32 430.8 110.8 352 208 352C305.2 352 384 430.8 384 528L384 534C384 557.2 365.2 576 342 576L74 576C50.8 576 32 557.2 32 534L32 528zM464 128C517 128 560 171 560 224C560 277 517 320 464 320C411 320 368 277 368 224C368 171 411 128 464 128zM464 368C543.5 368 608 432.5 608 512L608 534.4C608 557.4 589.4 576 566.4 576L421.6 576C428.2 563.5 432 549.2 432 534L432 528C432 476.5 414.6 429.1 385.5 391.3C408.1 376.6 435.1 368 464 368z"/></svg>
        </button>
        <button wire:click="unfriend" class="w-full bg-[#e4e6eb] hover:bg-[#d8dadf] text-black font-semibold px-4 py-2 rounded-md text-[15px] transition whitespace-nowrap">
            Unfriend
        </button>
    </div>
    @endif
</div>