<?php

namespace App\Livewire\User\Post;

use App\Models\UserPost;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{

    use WithFileUploads;

    #[Validate("nullable|image|max:2048")]
    public $image;

    #[Validate("nullable|string|max:1000")]
    public $caption;

    public function createPost()
    {
        if (!$this->caption && !$this->image) {
            $this->addError('caption', 'Caption or image is required.');
            $this->addError('image', 'Caption or image is required.');
            return;
        }

        $data = $this->validate();

        $data['user_id'] = Auth::id();

        if ($this->image) {
            $data['image'] = $this->image->store('posts', 'public');
        }

        UserPost::create($data);
        $this->reset('caption', 'image');
        $this->dispatch("postCreated");
        session()->flash('message', 'Post created successfully!');
    }

    public function render()
    {
        return view('livewire.user.post.create-post');
    }
}
