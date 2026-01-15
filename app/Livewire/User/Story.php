<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Story as StoryModel;
use App\Services\ImageKitService;
use Illuminate\Support\Facades\Auth;

class Story extends Component{

    use WithFileUploads;

    public $stories;

    #[Validate("required|file|mimes:jpg,jpeg,png,mp4|max:10240")]
    public $media_path;

    public function mount(){
        $this->loadStories();
    }

    public function loadStories(){
        $friendIds = Auth::user()->friends()->pluck('friends.receiver_id')
            ->merge(Auth::user()->friends()->pluck('friends.sender_id'))
            ->unique();

        $userIds = $friendIds->push(Auth::id());

        $this->stories = StoryModel::with('user')
            ->whereIn('user_id', $userIds)
            ->where('expires_at', '>', now())
            ->latest()
            ->get();
    }

    public function createStory(){
        $this->validate();

        try {
            $imageKit = app(ImageKitService::class);
            $cloudPath = $imageKit->upload($this->media_path, 'stories');

            Auth::user()->stories()->create([
                'media_path' => $cloudPath,
                'expires_at' => now()->addHours(24),
            ]);

            $this->reset('media_path');
            $this->loadStories();

            $this->dispatch('toast', message: 'Story uploaded successfully! ✨', type: 'success');
        } catch (\Exception $e) {
            $this->addError('media_path', 'Cloud upload failed: ' . $e->getMessage());
        }
    }

    public function updatedMediaPath(){
        $this->createStory();
    }

    public function render(){
        return view('livewire.user.story');
    }
}
