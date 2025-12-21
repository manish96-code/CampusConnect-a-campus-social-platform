<?php

namespace App\Livewire\User\Group;

use App\Models\GroupPost;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CallingGroupPost extends Component
{
    public $group;

    public function mount($group)
    {
        $this->group = $group;
    }

    public function render()
    {
        // Security: only group members can load posts
        if (! auth()->check() ||
            ! $this->group->members()
                ->where('users.id', Auth::id())
                ->exists()
        ) {
            return view('livewire.user.group.calling-group-post', [
                'posts' => collect(), // empty collection
            ]);
        }

        return view('livewire.user.group.calling-group-post', [
            'posts' => GroupPost::with('user')
                ->where('group_id', $this->group->id)
                ->orderBy('created_at', 'asc') // chat-style order
                ->get(),
        ]);
    }
}
