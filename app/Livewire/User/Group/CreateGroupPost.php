<?php

namespace App\Livewire\User\Group;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GroupPost;
use Illuminate\Support\Facades\Auth;

class CreateGroupPost extends Component
{
    use WithFileUploads;

    public $group;
    public $caption;
    public $image;

    protected $rules = [
        'caption' => 'nullable|string|max:1000',
        'image'   => 'nullable|image|max:2048',
    ];

    public function mount($group)
    {
        $this->group = $group;

        // if (! $group->members->contains(Auth::id())) {
        //     abort(403, 'You are not a member of this group.');
        // }
    }

    public function createPost()
    {
        $this->validate();

        if (!$this->caption && !$this->image) {
            $this->addError('caption', 'Caption or image is required.');
            return;
        }

        GroupPost::create([
            'group_id' => $this->group->id,
            'user_id'  => Auth::id(),
            'caption'  => $this->caption,
            'image'    => $this->image
                ? $this->image->store('group_posts', 'public')
                : null,
        ]);

        $this->reset('caption', 'image');

        $this->dispatch('postCreated');
    }

    public function render()
    {
        return view('livewire.user.group.create-group-post');
    }
}
