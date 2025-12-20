<?php

namespace App\Livewire\User\Group;

use App\Models\GroupPost;
use Livewire\Component;

class CallingGroupPost extends Component
{

     public $group;

    protected $listeners = ['postCreated' => '$refresh'];

    public function mount($group)
    {
        $this->group = $group;
    }

    public function render()
    {
        return view('livewire.user.group.calling-group-post', [
            'posts' => GroupPost::with('user')
                ->where('group_id', $this->group->id)
                ->latest()
                ->get(),
        ]);
    }

}
