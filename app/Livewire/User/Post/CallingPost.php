<?php

namespace App\Livewire\User\Post;

use App\Models\Friend;
use App\Models\UserPost;
use Livewire\Component;
use Livewire\Attributes\On;

class CallingPost extends Component{
    public $posts = [];
    public $selectedUser;
    public $comments = [];

    public function mount($selectedUser = null){
        $this->selectedUser = $selectedUser;
        $this->loadPosts();
    }

    #[On('postCreated')]
    public function refreshPosts(){
        $this->loadPosts();
    }

    protected function loadPosts(){
        if ($this->selectedUser) {
            $this->posts = UserPost::where('user_id', $this->selectedUser->id)
                ->latest()
                ->get();
            return;
        }

        // HOME FEED → friends + own posts
        $myFriendIds = Friend::where(function ($query) {
            $query->where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
        })
            ->where('status', 'accepted')
            ->get()
            ->map(
                fn($friend) =>
                $friend->sender_id === auth()->id()
                    ? $friend->receiver_id
                    : $friend->sender_id
            )
            ->toArray();

        $this->posts = UserPost::whereIn('user_id', $myFriendIds)
            ->orWhere('user_id', auth()->id())
            ->latest()
            ->get();
    }


    public function likePost($postId)
    {
        $post = UserPost::findOrFail($postId);
        $isLiking = !$post->likes()->where('user_id', auth()->id())->exists();

        if ($isLiking) {
            $post->likes()->create(['user_id' => auth()->id()]);
            $this->dispatch('toast', message: 'Post liked! ❤️', type: 'success');
        } else {
            $post->likes()->where('user_id', auth()->id())->delete();
            $this->dispatch('toast', message: 'Like removed.', type: 'delete');
        }

        $this->loadPosts();
    }

    public function commentPost($postId){
        $commentText = $this->comments[$postId] ?? '';

        if (!trim($commentText)) {
            $this->dispatch('toast', message: 'Comment cannot be empty! ✍️', type: 'warning');
            return;
        }

        $post = UserPost::findOrFail($postId);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $commentText,
        ]);

        $this->comments[$postId] = '';
        $this->dispatch('toast', message: 'Comment posted! 💬', type: 'success');
        $this->loadPosts();
    }

    public function render(){
        return view('livewire.user.post.calling-post');
    }
}
