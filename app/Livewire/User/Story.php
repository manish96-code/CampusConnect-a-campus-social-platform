<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithFileUploads;   
use Livewire\Attributes\Validate;


class Story extends Component
{
    public $stories;

    #[Validate("required|file|mimes:jpg,jpeg,png,mp4|max:10240")]
    public $media_path;

    use withfileuploads;
    

    public function mount(){
        $this->stories = auth()->user()->stories()->where('expires_at', '>', now())->get();
    }   

    public function createStory(){
        $data = $this->validate();
        
        $data['media_path'] = $this->media_path->store('stories','public');
        $data['user_id'] = auth()->id();
        $data['expires_at'] = now()->addHours(24);

        auth()->user()->stories()->create($data);

        $this->stories = auth()->user()->stories()->where('expires_at', '>', now())->get();
        session()->flash('success', 'Story uploaded successfully.');

        $this->media_path = '';
        
        
    }

    public function updatedMediaPath()
    {
        $this->createStory();
    }
    public function render()
    {
        return view('livewire.user.story');
    }
}