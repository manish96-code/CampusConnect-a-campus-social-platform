<?php

namespace App\Livewire\User;

use App\Models\Friend;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FriendshipButton extends Component{

    public $selectedUser;
    public $friendshipStatus;

    public function mount($selectedUser){
        $this->selectedUser = $selectedUser;
        $this->deterMineFriendshipStatus();
    }

    public function deterMineFriendshipStatus(){
        // $user = auth()->user();
        $user = Auth::user();

        $friendRequest = Friend::where(function($query) use ($user){
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $this->selectedUser->id);
        })->orWhere(function($query) use ($user){
            $query->where('sender_id', $this->selectedUser->id)
                  ->where('receiver_id', $user->id);
        })->first();
        

        if(!$friendRequest){
            $this->friendshipStatus = 'not_friends';
        }
        elseif($friendRequest->status == 'pending'){
            if($friendRequest->sender_id == $user->id){
                $this->friendshipStatus = 'request_sent';
            } else {
                $this->friendshipStatus = 'request_received';
            }
        }
        elseif($friendRequest->status == 'accepted'){
            $this->friendshipStatus = 'friends';
        }
        else{
            $this->friendshipStatus = 'not_friends';
        }

    }

    // send friend request
    public function sendFriendRequest(){
        $user = auth()->user();
        Friend::create([
            'sender_id' => $user->id,
            'receiver_id' => $this->selectedUser->id,
            'status' => 'pending'
        ]);
        $this->deterMineFriendshipStatus();
    }
    
    // cancel friend request
    public function cancelFriendRequest(){
        $user = auth()->user();
        Friend::where('sender_id', $user->id)
        ->where('receiver_id', $this->selectedUser->id)
        ->delete();
        $this->deterMineFriendshipStatus();
    }

    // accept friend request
    public function acceptFriendRequest(){
        $user = auth()->user();

        $friendRequest = Friend::where('sender_id', $this->selectedUser->id)
        ->where('receiver_id', $user->id)
        ->first();
        
        if($friendRequest){
            $friendRequest->status = 'accepted';
            $friendRequest->save();
        }
        $this->deterMineFriendshipStatus();
    }
    
    // reject friend request
    public function rejectFriendRequest(){
        $user = auth()->user();
        
        $friendRequest = Friend::where('sender_id', $this->selectedUser->id)
        ->where('receiver_id', $user->id)
        ->delete();
        $this->deterMineFriendshipStatus();
    }

    // unfriend
    public function unfriend(){
        $user = auth()->user();

        Friend::where(function($query) use ($user){
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $this->selectedUser->id);
        })->orWhere(function($query) use ($user){
            $query->where('sender_id', $this->selectedUser->id)
                  ->where('receiver_id', $user->id);
        })->delete();

        $this->deterMineFriendshipStatus();
    }

        
    public function render()
    {
        return view('livewire.user.friendship-button');
    }
}
