<?php

namespace App\Livewire\User\Group;

use App\Models\GroupPost;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CallingGroupPost extends Component{
    public $group;

    #[On('postCreated')]
    public function refreshPosts(){
        
    }

    public function mount($group){
        $this->group = $group;
    }

    public function deletePost($postId){
    $post = GroupPost::findOrFail($postId);

    $isAdmin = $this->group->members()
        ->where('users.id', auth()->id())
        ->wherePivot('role', 'admin')
        ->exists();

    // Permission check
    if ($post->user_id !== auth()->id() && ! $isAdmin) {
        abort(403);
    }

    $post->delete();
}

    public function render()
    {
        if (
            ! auth()->check() ||
            ! $this->group->members()
                ->where('users.id', Auth::id())
                ->wherePivot('status', 'approved')
                ->exists()

        ) {
            return view('livewire.user.group.calling-group-post', [
                'posts' => collect(),
            ]);
        }

        return view('livewire.user.group.calling-group-post', [
            'posts' => GroupPost::with('user')
                ->where('group_id', $this->group->id)
                ->orderBy('created_at', 'asc')
                ->get(),
        ]);
    }
}
