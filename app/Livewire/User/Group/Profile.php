<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.user")]

class Profile extends Component{
    public $group;
    public $activeTab = 'discussion';

    public function mount($id){
        $this->group = Group::with(['creator', 'members'])->findOrFail($id);
    }

    // public function refreshGroup(){
    //     $this->group->refresh();
    // }

    public function setTab($tab){
        $this->activeTab = $tab;
    }

    public function render(){
        return view('livewire.user.group.profile');
    }
}