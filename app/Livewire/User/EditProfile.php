<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Services\ImageKitService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.user")]
class EditProfile extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $contact;
    public $dob;
    public $gender;

    public $dp;
    public $cover;

    public $existingDp;
    public $existingCover;

    public function mount()
    {
        $user = auth()->user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->contact = $user->contact;
        $this->dob = $user->dob;
        $this->gender = $user->gender;
        $this->existingDp = $user->dp;
        $this->existingCover = $user->cover;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'contact' => 'required|regex:/^[6-9][0-9]{9}$/|unique:users,contact,' . auth()->id(),
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'dp' => 'image|max:1024|nullable|mimes:jpg,jpeg,png',
            'cover' => 'image|max:2048|mimes:jpg,jpeg,png|nullable',
        ];
    }

    public function update()
    {
        $this->validate();

        $user = auth()->user();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->contact = $this->contact;
        $user->dob = $this->dob;
        $user->gender = $this->gender;

        $imageKit = app(ImageKitService::class);

        if ($this->dp) {
            $user->dp = $imageKit->upload($this->dp, '/users/dp');
        }

        if ($this->cover) {
            $user->cover = $imageKit->upload($this->cover, '/users/cover');
        }

        $user->save();
        $this->dispatch('toast', message: 'Profile updated successfully!', type: 'success');

        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.user.edit-profile');
    }
}
