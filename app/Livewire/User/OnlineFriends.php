<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class OnlineFriends extends Component
{
    public function render(){
        $myFriendsIds = auth()->user()->friends()->pluck('id')->toArray();
        $friends = User::whereIn('id', $myFriendsIds)->get();
        return view('livewire.user.online-friends', ["friends" => $friends]);
    }
}
