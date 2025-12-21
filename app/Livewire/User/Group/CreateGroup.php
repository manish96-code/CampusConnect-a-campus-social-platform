<?php

namespace App\Livewire\User\Group;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateGroup extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:3|max:50|unique:groups,group_name')]
    public $group_name;

    #[Validate('nullable|string|max:500')]
    public $description;

    #[Validate('required|in:public,private')]
    public $group_type = 'public';

    #[Validate('nullable|image|max:1024')]
    public $profile_pic;

    #[Validate('nullable|image|max:5120')]
    public $cover_pic;

    public function create_group()
    {
        // dd('create_group fired');
        
        $this->validate();

        $profilePic = $this->profile_pic
            ? $this->profile_pic->store('group/groupProfilePic', 'public')
            : null;

        $coverPic = $this->cover_pic
            ? $this->cover_pic->store('group/groupCoverPic', 'public')
            : null;

        $group = Group::create([
            'created_by' => Auth::id(),
            'group_name' => $this->group_name,
            'description' => $this->description,
            'group_type' => $this->group_type,
            'profile_pic' => $profilePic,
            'cover_pic' => $coverPic,
        ]);

        $group->members()->attach(Auth::id(), [
            'role' => 'admin',
            'status' => 'approved',
        ]);

        session()->flash('message', 'Group created successfully!');

        $this->reset(['group_name', 'description', 'profile_pic', 'cover_pic']);
        $this->group_type = 'public';
    }

    public function render()
    {
        return view('livewire.user.group.create-group');
    }
}
