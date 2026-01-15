<?php

namespace App\Livewire\User\Post;

use App\Models\UserPost;
use App\Services\ImageKitService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component{
    use WithFileUploads;

    #[Validate("nullable|image|max:2048")]
    public $image;

    #[Validate("nullable|string|max:1000")]
    public $caption;

    public function createPost(){
        if (!$this->caption && !$this->image) {
            $this->dispatch('toast', 
                message: 'Write something or add an image to post! ✍️', 
                type: 'warning'
            );
            return;
        }

        $data = $this->validate();

        try {
            $imageUrl = null;

            if ($this->image) {
                $imageKit = app(ImageKitService::class);
                $imageUrl = $imageKit->upload($this->image, 'posts');
            }

            UserPost::create([
                'user_id' => Auth::id(),
                'caption' => $this->caption,
                'image'   => $imageUrl,
            ]);

            $this->reset('caption', 'image');
            
            $this->dispatch('toast', 
                message: 'Post shared successfully! 🚀', 
                type: 'success'
            );
            
            $this->dispatch("postCreated");

        } catch (\Exception $e) {
            $this->dispatch('toast', 
                message: 'Something went wrong. Please try again.', 
                type: 'error'
            );
        }

    }

    public function render(){
        return view('livewire.user.post.create-post');
    }
}
