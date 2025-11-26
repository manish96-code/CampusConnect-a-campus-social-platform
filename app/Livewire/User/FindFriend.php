<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.user")]

class FindFriend extends Component
{
    public $users = [];

    public function mount(){

        $query = request()->get("query", "");

        if ($query) {
            $this->users = User::where("id", "!=", auth()->user()->id)
                ->where(function ($q) use ($query) {
                    $q->where('first_name', 'like', '%' . $query . '%')
                        ->orWhere('last_name', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%');
                })
                ->get();
        }
        else {
            $this->users = User::where("id", "!=", auth()->user()->id)->get();
        }
    }

    public function render()
    {
        return view('livewire.user.find-friend', ['users' => $this->users]);
    }
}
