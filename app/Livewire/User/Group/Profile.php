<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.user")]

class Profile extends Component
{

    use WithFileUploads;

    public $group;
    public $activeTab = 'discussion';

    #[Validate('nullable|image|max:2048')]
    public $profile_pic;

    #[Validate('nullable|image|max:4096')]
    public $cover_pic;

    public function mount($id)
    {
        $this->group = Group::with('members')->findOrFail($id);
    }

    public function getIsAdminProperty()
    {
        return $this->group->members()
            ->where('users.id', Auth::id())
            ->wherePivot('role', 'admin')
            ->exists();
    }

    public function updatedProfilePic()
    {
        $this->updateGroupImages();
    }

    public function updatedCoverPic()
    {
        $this->updateGroupImages();
    }

    public function updateGroupImages()
    {
        if (! $this->isAdmin) return;

        $this->validate();

        if ($this->profile_pic) {
            $path = $this->profile_pic->store('group/profile', 'public');
            $this->group->profile_pic = $path;
        }

        if ($this->cover_pic) {
            $path = $this->cover_pic->store('group/cover', 'public');
            $this->group->cover_pic = $path;
        }

        $this->group->save();

        $this->group->refresh();
    }



    // public function mount($id){
    //     $this->group = Group::with(['creator', 'members'])->findOrFail($id);
    // }

    // public function refreshGroup(){
    //     $this->group->refresh();
    // }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.user.group.profile');
    }
}
