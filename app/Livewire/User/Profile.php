<?php

namespace App\Livewire\User;
use App\Models\User;
use App\Models\UserPost;
use App\Services\ImageKitService;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout("components.layouts.user")]

class Profile extends Component{
    use WithFileUploads;

    public $mediaPosts = [];

    #[Validate("image|max:1024|nullable|mimes:jpg,jpeg,png")]
    public $dp;

    #[Validate("image|max:2048|mimes:jpg,jpeg,png|nullable")]
    public $cover;

    public $selectedUser = null;

    public function updatedCover(){
        $this->updateProfile();
    }

    public function updatedDp(){
        $this->updateProfile();
    }

    public function mount($id = null){
        if ($id && $id != auth()->user()->id) {
            $user = User::find($id);
            if ($user) {
                $this->selectedUser = $user;
            } else {
                return redirect()->route('profile');
            }
        } else {
            $this->selectedUser = auth()->user();
        }

        $this->loadMediaPosts();
    }


    public function updateProfile(){
        if ($this->selectedUser->id !== auth()->id()) {
            return;
        }

        $this->validate();
        $user = auth()->user();
        $imageKit = app(ImageKitService::class);

        if ($this->dp) {
            $user->dp = $imageKit->upload($this->dp, '/users/dp');
            $this->reset('dp');
        }

        if ($this->cover) {
            $user->cover = $imageKit->upload($this->cover, '/users/cover');
            $this->reset('cover');
        }

        $user->save();

        $this->selectedUser = $user->fresh();

        $this->loadMediaPosts();

        session()->flash('message', 'Profile updated successfully.');
    }

    private function loadMediaPosts(){
        $this->mediaPosts = UserPost::where('user_id', $this->selectedUser->id)
            ->whereNotNull('image')
            ->latest()
            ->take(9)
            ->get();
    }

    public function render(){
        return view('livewire.user.profile');
    }
}
