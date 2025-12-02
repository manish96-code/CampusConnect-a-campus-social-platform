<?php

namespace App\Livewire\User\Post;

use App\Models\UserPost;
use Livewire\Component;
use Livewire\Attributes\On;

class CallingPost extends Component
{

    public $posts;
    public $selectedUser;
    public $comment;

    #[On("postCreated")]

    public function mount($selectedUser = null){
        if($selectedUser && $selectedUser->id != auth()->user()->id ){
            $this->posts = UserPost::where("user_id", $selectedUser->id)->orderBy('created_at', 'desc')->get();
        }
        // elseif($selectedUser && $selectedUser->id == auth()->user()->id){
        //     $this->posts = UserPost::where("user_id", auth()->user()->id)->orderBy('created_at', 'desc')->get();
        // }
        // else{
        //     $this->posts = UserPost::latest()->orderBy('created_at', 'desc')->get();
        // }
        else{
            $myFriendIds = auth()->user()->friends()->pluck('id')->toArray();
            $this->posts = UserPost::whereIn("user_id", $myFriendIds)->orwhere("user_id", auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }
    }

    public function likePost($postId){

        if(UserPost::find($postId)->likes()->where("user_id",auth()->id())->exists()){
            UserPost::find($postId)->likes()->where("user_id",auth()->id())->delete();
            $this->dispatch("postCreated");
            return;
        }
        
        $post = UserPost::find($postId);
        if ($post){
            $post->likes()->create(['user_id' => auth()->id()]);
        }
        $this->dispatch("postCreated");
    }

    public function commentPost($postId){
        $post = UserPost::find($postId);
        if ($post){
            $post->comments()->create([
                'user_id' => auth()->id(),
                'comment' => $this->comment
            ]);
        }
        $this->comment = "";
        $this->dispatch("postCreated");
    }
    
    public function render(){
        return view('livewire.user.post.calling-post', ['posts' => $this->posts]);
    }
}