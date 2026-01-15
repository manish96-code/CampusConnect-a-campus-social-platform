<?php

namespace App\Livewire\User\Group;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\GroupPost;
use App\Services\ImageKitService;
use Illuminate\Support\Facades\Auth;

class CreateGroupPost extends Component{
    use WithFileUploads;

    public $group;
    public $caption;
    public $image;

    protected $rules = [
        'caption' => 'nullable|string|max:1000',
        'image'   => 'nullable|image|max:2048',
    ];

    public function mount($group){
        $this->group = $group;
    }

    public function createPost(){
        $this->validate();

        if (!$this->caption && !$this->image) {
            $this->dispatch('toast', message: 'Please provide either a caption or an image.', type: 'warning');
            return;
        }

        $imageKit = app(ImageKitService::class);
        $imageUrl = null;

        if ($this->image) {
            try {
                $imageUrl = $imageKit->upload($this->image, 'group_chat_images');
            } catch (\Exception $e) {
                $this->dispatch('toast', message: 'Image upload failed. Please try again.', type: 'error');
                return;
            }
        }

        GroupPost::create([
            'group_id' => $this->group->id,
            'user_id'  => Auth::id(),
            'caption'  => ucfirst(trim($this->caption)),
            'image'    => $imageUrl,
        ]);

        $this->reset('caption', 'image');

        $this->dispatch('toast', message: 'Post shared successfully! 🚀', type: 'success');

        $this->dispatch('postCreated');
    }

    public function render(){
        return view('livewire.user.group.create-group-post');
    }
}
